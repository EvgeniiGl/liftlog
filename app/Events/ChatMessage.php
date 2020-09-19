<?php
//
//namespace App\Events;
//
////use App\Models\Comment;
//use Illuminate\Queue\SerializesModels;
//use Illuminate\Broadcasting\PrivateChannel;
//use Illuminate\Foundation\Events\Dispatchable;
//use Illuminate\Broadcasting\InteractsWithSockets;
//use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
//
//class ChatMessage implements ShouldBroadcast
//{
//    use Dispatchable, InteractsWithSockets, SerializesModels;
//
//    protected $comment;
//
//    public function __construct(Comment $comment)
//    {
//        $this->comment = $comment;
//    }
//
//    /**
//     * Get the channels the event should broadcast on.
//     *
//     * @return \Illuminate\Broadcasting\Channel|array
//     */
//    public function broadcastOn()
//    {
//        return new PrivateChannel('chat.'.$this->comment->task_id);
//    }
//
//    public function broadcastWith()
//    {
//        return [
//            'view' => view('tasks.comments.single', ['i' => $this->comment])->render()
//        ];
//    }
//}
