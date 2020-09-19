<?php

namespace App\Helpers;

use App\Services\Socket\Connection;
use Modules\Records\Models\Record;

class RecordsSocketHelper
{

    /**
     * @param string $recordsId
     * @return array [ "records"=>$records,  "removedRecords"=>$removedRecords,  ]
     */
    public function getUpdatedRecords(string $recordsId): array
    {
        $ids            = json_decode($recordsId);
        $records        = [];
        $removedRecords = [];
        foreach ($ids as $id) {
            $record = Record::find($id);
            if ($record === null) {
                $removedRecords[] = ['id' => $id];
            } else {
                $records[] = $record->toArray();
            }
        }
        return [
            "records"        => $records,
            "removedRecords" => $removedRecords,
        ];
    }

    /**
     * @param int $userId
     * @param Connection $connection
     * @param array $record
     * @return bool
     */
    public function isSend(int $userId, Connection $connection, array $record)
    {
        if ($connection->getNotificate() === 'откл') {
            return false;
        }
        return empty($record['time_create'])
            || $connection->getNotificate() === 'все'
            || $record['creator_id'] === $userId
            || $record['maker_id'] === $userId
            || $record['closer_id'] === $userId;
    }

}
