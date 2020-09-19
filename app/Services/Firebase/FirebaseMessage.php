<?php

namespace App\Services\Firebase;

use App\Models\Device;
use Kreait\Firebase\Messaging\CloudMessage;

/**
 * Interface FirebaseMessage
 * @package App\Services\Firebase
 */
interface FirebaseMessage
{
    /**
     * @param array $data
     */
    public function setData(array $data):void;

    /**
     * Verifies whether the recipient has a device
     * @return bool
     */
    public function recipientDeviceExist(): bool;

    /**
     * @param Device $device
     * @return CloudMessage prepared message for sent firebase
     */
    public function getMessage(): CloudMessage;

}
