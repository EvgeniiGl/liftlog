<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecordsChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int id record
     */
    public $recordId;

    /**
     * Create a new event instance.
     *
     * @param int $recordId id record
     */
    public function __construct(int $recordId)
    {
        $this->recordId = $recordId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
