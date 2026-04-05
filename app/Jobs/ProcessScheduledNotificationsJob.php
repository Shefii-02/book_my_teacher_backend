<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\NotificationRecipient;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class ProcessScheduledNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 1;
    public int $timeout = 120;

    public function handle(): void
    {
        // Get all pending scheduled notifications
        $notifications = Notification::pending()->get();

        if ($notifications->isEmpty()) {
            return;
        }


        foreach ($notifications as $notification) {
            try {
                $this->processNotification($notification);
            } catch (\Exception $e) {
                Log::error('Failed to process notification', [
                    'notification_id' => $notification->id,
                    'error'           => $e->getMessage(),
                ]);
            }
        }
    }

    private function processNotification(Notification $notification): void
    {
        // Resolve target users
        $users = $this->resolveUsers($notification);

        if ($users->isEmpty()) {
            $notification->update(['sent_at' => now()]);
            return;
        }

        // Get already existing recipient user IDs
        $existingIds = NotificationRecipient::where('notification_id', $notification->id)
            ->pluck('user_id')
            ->toArray();

        // Only new users
        $newUsers = $users->whereNotIn('id', $existingIds);

        // Bulk insert recipients
        if ($newUsers->isNotEmpty()) {
            $recipients = $newUsers->map(fn($user) => [
                'notification_id' => $notification->id,
                'user_id'         => $user->id,
                'created_at'      => now(),
                'updated_at'      => now(),
            ])->toArray();

            NotificationRecipient::insert($recipients);
        }

        // Dispatch push jobs in batch
        if (in_array($notification->type, ['push', 'both'])) {
            $usersWithToken = $users->filter(fn($u) => !empty($u->fcm_token_android));

            if ($usersWithToken->isNotEmpty()) {
                // Chunk into batches of 100
                $usersWithToken->chunk(100)->each(function ($chunk) use ($notification) {
                    $jobs = $chunk->map(fn($user) =>
                        new SendPushNotificationJob($notification, $user)
                    )->values()->toArray();

                    Bus::batch($jobs)
                        ->allowFailures()
                        ->onQueue('notifications')
                        ->dispatch();
                });
            }
        }

        // Mark as sent
        $notification->update(['sent_at' => now()]);


    }

    private function resolveUsers(Notification $notification)
    {
        return match ($notification->target_type) {
            'all'      => User::whereNotNull('fcm_token_android')->get(),
            'role'     => User::where('role', $notification->target_role)->get(),
            'specific' => User::whereIn('id', $notification->target_user_ids ?? [])->get(),
            default    => collect(),
        };
    }
}
