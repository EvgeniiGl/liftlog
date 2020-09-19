<?php

namespace App\Services\Firebase;

use App\Jobs\SendFirebaseMessageJob;
use App\Models\Device;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Modules\Address\Repositories\AddressRepository;

class FirebaseService
{
    protected $messaging;

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    public function send(CloudMessage $msg)
    {
        try {
            $this->messaging->send($msg);
        } catch (MessagingException $e) {
            report($e);
        } catch (FirebaseException $e) {
            report($e);
        }
    }

}
