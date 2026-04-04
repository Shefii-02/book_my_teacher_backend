<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ChatEvent implements ShouldBroadcast
{
    use SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    // 🔥 broadcast channel
    public function broadcastOn()
    {
        return new Channel('chat-channel');
    }

    // 🔥 event name in JS
    public function broadcastAs()
    {
        return 'chat-event';
    }
}
