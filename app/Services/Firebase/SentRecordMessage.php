<?php

namespace App\Services\Firebase;

use AddressHelper;
use App\Models\Device;
use Exception;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\MessageData;
use Modules\Address\Repositories\AddressRepository;
use Modules\Records\Models\Record;

/**
 * Class SentRecordMessage
 * @package App\Services\Firebase
 */
class SentRecordMessage implements FirebaseMessage
{
    private $data;
    private $token;
    private $addressRepository;
    private $deviceModel;
    private $recordModel;

    public function __construct(
        AddressRepository $addressRepository,
        Device $deviceModel,
        Record $recordModel,
        array $data = null
    ) {
        $this->addressRepository = $addressRepository;
        $this->deviceModel       = $deviceModel;
        $this->recordModel       = $recordModel;
        if (!empty($data)) {
            $this->setData($data);
        }
    }

    protected function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Set data record. Should be called first.
     * @param array $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function recipientDeviceExist(): bool
    {
        $device = $this->getDevice();
        if ($device !== null) {
            $this->setToken($device->token);
        }
        return $device !== null;
    }

//TODO write service for devices to separate class
    protected function getDevice()
    {
        return $this->deviceModel::where('user_id', $this->data['maker_id'])->first();
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): CloudMessage
    {
        if (empty($this->data['maker_id'])) {
            throw new Exception('Не передан id получателя!');
        }
        $data        = $this->getMessageData();
        $messageData = MessageData::fromArray($data);
        $message     = CloudMessage::withTarget('token', $this->token)
            ->withData($messageData);
        return $message;
    }

    protected function getMessageData()
    {
        if (empty($this->data['ids_selected_adr']) || empty($this->data['type'])) {
            $record    = $this->recordModel::find($this->data['id']);
            $addresses = $this->addressRepository->getAddressByRecords([$record]);
        } else {
            $record    = $this->data;
            $ids       = explode(',', $this->data['ids_selected_adr']);
            $addresses = $this->addressRepository->getAddressByIds($ids);
        }
        $body = AddressHelper::addressToStringHelper($addresses[0]);
        
        $data = [
            'title' => $record->type->title,
            'body'  => $body,
        ];
        return $data;
    }

}
