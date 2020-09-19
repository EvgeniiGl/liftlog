<?php

namespace App\Helpers\View;

use Modules\Records\Models\Record;

class AddressHelper
{
    /**
     * Address to string helper
     *
     * @param $address \stdClass
     *
     * @return string
     */
    public static function addressToStringHelper(\stdClass $address)
    {
        if (empty($address)) {
            return null;
        }
        $city        = empty($address->city) ? '' : $address->city . ', ';
        $street      = empty($address->street) ? '' : $address->street . ', ';
        $house       = empty($address->house) ? '' : $address->house . ', ';
        $houseLetter = empty($address->house_letter) ? '' : $address->house_letter . ', ';
        $numLift     = empty($address->num_lift) ? '' : $address->num_lift;
        $strAddress  = $city . $street . $house . $houseLetter . $numLift;
        return $strAddress;
    }

    /**
     * @param $records iterable records
     * @param $addresses array
     * @return array records with addresses [['address_id'=>string address id, 'address_name'=>string address name]]
     */
    public static function getRecordsWithAddresses(iterable $records, array $addresses)
    {
        $records = gettype($records) === 'array' ? $records : $records->toArray();
        $records = array_map(function ($record) use ($addresses) {
            $record = ($record instanceof Record) ? $record->toArray() :
                (array)$record;
            foreach ($addresses as $address) {
                if ($record['id'] === $address->records_id) {
                    $record['addresses'][] = self::getPreparedAddress($address);
                }
            }
            return $record;
        }, $records);
        return $records;
    }

    public static function getPreparedAddress($address)
    {
        return [
            'address_id'   => $address->id,
            'address_name' => self::addressToStringHelper($address)
        ];
    }

}
