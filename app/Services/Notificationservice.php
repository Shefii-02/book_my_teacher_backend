<?php

namespace App\Services;

use App\Jobs\SendPushNotificationJob;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    // =============================================
    // SEND - Main Entry Point
    // =============================================
    public function send(array $params): Notification
    {
        $notification = Notification::create([
            'title'           => $params['title'],
            'body'            => $params['body'],
            'type'            => $params['type']            ?? 'both',
            'category'        => $params['category'],
            'action_type'     => $params['action_type'],
            'notifiable_type' => $params['notifiable_type'] ?? null,
            'notifiable_id'   => $params['notifiable_id']   ?? null,
            'target_type'     => $params['target_type']     ?? 'specific',
            'target_role'     => $params['target_role']     ?? null,
            'target_user_ids' => $params['user_ids']        ?? null,
            'screen'          => $params['screen']          ?? null,
            'screen_id'       => $params['screen_id']       ?? null,
            'extra_data'      => $params['extra_data']      ?? null,
            'created_by'      => auth()->id()               ?? 1,
            'scheduled_at'    => $params['scheduled_at']    ?? now(),
        ]);

        // If immediate send (not scheduled for future)
        $scheduledAt = $params['scheduled_at'] ?? now();
        if ($scheduledAt <= now()) {
            $this->dispatchImmediately($notification, $params);
        }
        // else: cron will pick it up via ProcessScheduledNotificationsJob

        return $notification;
    }

    // =============================================
    // DISPATCH IMMEDIATELY
    // =============================================
    private function dispatchImmediately(Notification $notification, array $params): void
    {
        $users = $this->resolveUsers($params);

        if ($users->isEmpty()) {
            $notification->update(['sent_at' => now()]);
            return;
        }

        // Bulk insert recipients
        $recipients = $users->map(fn($user) => [
            'notification_id' => $notification->id,
            'user_id'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ])->toArray();

        NotificationRecipient::insert($recipients);

        // Dispatch push jobs
        if (in_array($notification->type, ['push', 'both'])) {
            $usersWithToken = $users->filter(fn($u) => !empty($u->fcm_token_android));

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

        $notification->update(['sent_at' => now()]);
    }

    // =============================================
    // RESOLVE USERS
    // =============================================
    private function resolveUsers(array $params)
    {
        return match ($params['target_type'] ?? 'specific') {
            'all'      => User::whereNotNull('fcm_token_android')->get(),
            'role'     => User::where('role', $params['target_role'])->get(),
            'specific' => User::whereIn('id', $params['user_ids'] ?? [])->get(),
            default    => collect(),
        };
    }

    // =============================================
    // HELPERS - Quick send methods
    // =============================================
    public function sendToUser(int $userId, array $params): Notification
    {
        return $this->send(array_merge($params, [
            'target_type' => 'specific',
            'user_ids'    => [$userId],
        ]));
    }

    public function sendToRole(string $role, array $params): Notification
    {
        return $this->send(array_merge($params, [
            'target_type' => 'role',
            'target_role' => $role,
        ]));
    }

    public function sendToAll(array $params): Notification
    {
        return $this->send(array_merge($params, [
            'target_type' => 'all',
        ]));
    }

    public function sendToAdmins(array $params): Notification
    {
        // Send to both admin and staff
        $adminStaffIds = User::whereIn('role', ['admin', 'staff'])->pluck('id')->toArray();
        return $this->send(array_merge($params, [
            'target_type' => 'specific',
            'user_ids'    => $adminStaffIds,
        ]));
    }

    public function sendToAdminStaffTeacher(array $params): Notification
    {
        $ids = User::whereIn('role', ['admin', 'staff', 'teacher'])->pluck('id')->toArray();
        return $this->send(array_merge($params, [
            'target_type' => 'specific',
            'user_ids'    => $ids,
        ]));
    }
}
