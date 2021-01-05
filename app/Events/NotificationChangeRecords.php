<?php

namespace App\Events;

use App\Services\Socket\ConnectionPool;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationChangeRecords
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int id record
     */
    public $recordsId;
    /**
     * @var ConnectionPool instance
     */
    public $pConnect;

    /**
     * Create a new event instance.
     *
     * @param  int  $recordsId  id records
     * @param  ConnectionPool  $pConnect
     */
    public function __construct(int $recordsId, ConnectionPool $pConnect)
    {
        $this->recordsId = $recordsId;
        $this->pConnect  = $pConnect;
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
