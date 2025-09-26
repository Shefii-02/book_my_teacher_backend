<?php

namespace App\Services;

use Zego\ServerAssistant\ZegoServerAssistant;

class ZegoTokenService
{
    protected string $appId;
    protected string $serverSecret;

    public function __construct()
    {
        $this->appId = config('services.zego.app_id');
        $this->serverSecret = config('services.zego.server_secret');
    }

    public function generateToken(string $userId, int $roomId, int $expireSeconds = 3600): string
    {
        return ZegoServerAssistant::generateToken04(
            intval($this->appId),
            $userId,
            $this->serverSecret,
            $roomId,
            $expireSeconds
        )['token'];
    }
}
