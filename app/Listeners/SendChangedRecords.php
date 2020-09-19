<?php

namespace App\Listeners;

use App\Events\NotificationChangeRecords;
use App\Helpers\RecordsSocketHelper;
use App\Helpers\Response\ResponseHelper;
use App\Helpers\View\AddressHelper;
use Modules\Address\Repositories\AddressRepository;
use Modules\Records\Repositories\RecordsRepository;

class SendChangedRecords
{
    /**
     * @var RecordsSocketHelper
     */
    private $recordsSocketHelper;
    /**
     * @var AddressRepository
     */
    private $addressRepository;

    /**
     * RecordsSocketHelper constructor.
     * @param AddressRepository $addressRepository
     */
    public function __construct(RecordsSocketHelper $recordsSocketHelper, AddressRepository $addressRepository)
    {
        $this->addressRepository   = $addressRepository;
        $this->recordsSocketHelper = $recordsSocketHelper;
    }

    /**
     * Handle the event.
     *
     * @param NotificationChangeRecords $event
     * @return void|bool
     */
    public function handle(NotificationChangeRecords $event)
    {
        try {
            $updatedRecords  = $this->recordsSocketHelper->getUpdatedRecords($event->recordsId);
            $addresses       = $this->addressRepository->getAddressByRecords($updatedRecords["records"]);
            $preparedRecords = AddressHelper::getRecordsWithAddresses($updatedRecords["records"], $addresses);
            $records         = array_merge($preparedRecords, $updatedRecords['removedRecords']);
//отправляем информацию пользователям
            foreach ($event->pConnect->all() as $connection) {
                $userId = (int)$connection->getUserId();
                foreach ($records as $record) {
                    if ($this->recordsSocketHelper->isSend($userId, $connection, $record)) {
                        ResponseHelper::setData($record);
                        echo "send to id - {$connection->getUserId()}\n";
                        $connection->getConnect()->emit("records_change", ResponseHelper::successStrJson()
                        );
                    }
                }
            }
        } catch (\Exception $e) {
            echo '$e' . $e->getMessage() . $e->getTraceAsString();
            report($e);
            return false;
        }
    }

}
