<?php

namespace App\Jobs;

use App\Services\Firebase\FirebaseMessage;
use App\Services\Firebase\FirebaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class for send push notifications
 * @package App\Jobs
 */
class SendFirebaseMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $retryAfter = 5;
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * @var FirebaseMessage
     */
    private $msg;

    /**
     * @param FirebaseMessage $msg
     */
    public function __construct(FirebaseMessage $msg)
    {
        $this->msg = $msg;
    }

    public function handle(FirebaseService $firebaseService)
    {
        if ($this->msg->recipientDeviceExist()) {
            $message = $this->msg->getMessage();
            $firebaseService->send($message);
        }
    }
}
