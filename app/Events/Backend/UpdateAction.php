<?php

namespace App\Events\Backend;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateAction
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $oldAction;
    public $newAction;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( $oldAction, $newAction )
    {
        $this->oldAction = $oldAction;
        $this->newAction = $newAction;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [];
    }
}
