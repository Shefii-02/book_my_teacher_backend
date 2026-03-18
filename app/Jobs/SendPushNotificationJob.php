<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\NotificationRecipient;
use App\Models\User;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendPushNotificationJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 60;
    public int $backoff = 10;

    public function __construct(
        public readonly Notification $notification,
        public readonly User         $user,
    ) {}

    // =============================================
    // HANDLE
    // =============================================
    public function handle(): void
    {
        // Skip if batch cancelled
        if ($this->batch()?->cancelled()) {
            return;
        }

        // Skip if no FCM token
        if (!$this->user->fcm_token_android) {
            $this->updateRecipient(false, 'No FCM token');
            return;
        }

        // Skip if user disabled notifications
        if (!$this->userAllowsNotification()) {
            $this->updateRecipient(false, 'User disabled notifications');
            return;
        }

        try {
            $accessToken = $this->getAccessToken();
            $response    = $this->sendToFCM($accessToken);

            if ($response->successful()) {
                $this->updateRecipient(true);
                $this->notification->increment('sent_count');

                Log::info('FCM Push Sent', [
                    'user_id'         => $this->user->id,
                    'notification_id' => $this->notification->id,
                ]);
            } else {
                $error = $response->json('error.message') ?? 'Unknown error';
                $this->updateRecipient(false, $error);
                $this->notification->increment('failed_count');

                // Invalid token - clear it
                if ($response->status() === 404) {
                    $this->user->update(['fcm_token_android' => null]);
                    Log::warning('FCM Token Cleared (404)', ['user_id' => $this->user->id]);
                }

                Log::error('FCM Push Failed', [
                    'user_id'         => $this->user->id,
                    'notification_id' => $this->notification->id,
                    'status'          => $response->status(),
                    'error'           => $error,
                ]);

                // Retry for server errors only
                if ($response->serverError()) {
                    $this->release($this->backoff);
                }
            }
        } catch (\Exception $e) {
            $this->updateRecipient(false, $e->getMessage());
            $this->notification->increment('failed_count');
            Log::error('FCM Job Exception', [
                'user_id' => $this->user->id,
                'error'   => $e->getMessage(),
            ]);
            $this->fail($e);
        }
    }

    // =============================================
    // SEND TO FCM
    // =============================================
    private function sendToFCM(string $accessToken)
    {
        $projectId = config('services.firebase.project_id');

        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type'  => 'application/json',
        ])->timeout(30)
          ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
            'message' => [
                'token'        => $this->user->fcm_token,
                'notification' => [
                    'title' => $this->notification->title,
                    'body'  => $this->notification->body,
                ],
                'android' => [
                    'priority'     => 'high',
                    'notification' => [
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                        'sound'        => 'default',
                        'channel_id'   => 'high_importance_channel',
                    ],
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'sound'             => 'default',
                            'badge'             => 1,
                            'content-available' => 1,
                        ],
                    ],
                    'headers' => [
                        'apns-priority' => '10',
                    ],
                ],
                'data' => [
                    'notification_id' => (string) $this->notification->id,
                    'type'            => $this->notification->category,
                    'id'              => (string) ($this->notification->screen_id ?? ''),
                    'screen'          => $this->notification->screen ?? '',
                    'action'          => $this->notification->action_type,
                    'extra'           => json_encode($this->notification->extra_data ?? []),
                ],
            ],
        ]);
    }

    // =============================================
    // GET ACCESS TOKEN
    // =============================================
    private function getAccessToken(): string
    {
        $credentials = new ServiceAccountCredentials(
            ['https://www.googleapis.com/auth/firebase.messaging'],
            storage_path('app/json/fcm-file.json')
        );
        $token = $credentials->fetchAuthToken();

        if (empty($token['access_token'])) {
            throw new \RuntimeException('Failed to get FCM access token');
        }

        return $token['access_token'];
    }

    // =============================================
    // UPDATE RECIPIENT STATUS
    // =============================================
    private function updateRecipient(bool $success, ?string $error = null): void
    {
        NotificationRecipient::where('notification_id', $this->notification->id)
            ->where('user_id', $this->user->id)
            ->update([
                'is_push_sent'   => $success,
                'is_push_failed' => !$success,
                'push_error'     => $error,
                'push_sent_at'   => now(),
            ]);
    }

    // =============================================
    // CHECK USER SETTINGS
    // =============================================
    private function userAllowsNotification(): bool
    {
        $settings = $this->user->notificationSettings;

        if (!$settings) return true;
        if (!$settings->push_enabled) return false;

        $category = $this->notification->category;
        return $settings->allows($category);
    }

    // =============================================
    // FAILED - after all retries
    // =============================================
    public function failed(\Throwable $exception): void
    {
        $this->updateRecipient(false, 'Max retries: ' . $exception->getMessage());

        Log::error('FCM Job Failed After All Retries', [
            'user_id'         => $this->user->id,
            'notification_id' => $this->notification->id,
            'error'           => $exception->getMessage(),
        ]);
    }
}
