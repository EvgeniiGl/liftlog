<?php

namespace Tests\Unit\App\Helpers;

use App\Helpers\RecordsSocketHelper;
use App\Services\Socket\Connection;
use Illuminate\Container\Container;
use Tests\TestCase;

class RecordsSocketHelperTest extends TestCase
{
    private $recordsSocketHelper;
    private $userId;
    private $record;
    private $connection;

    protected function setUp(): void
    {
        parent::setUp();
        $container                 = Container::getInstance();
        $this->recordsSocketHelper = $container->make(RecordsSocketHelper::class);
        $this->userId              = 1;
        $this->record              = [
            'time_create' => 'some string',
            'creator_id'  => null,
            'maker_id'    => null,
            'closer_id'   => null,
        ];
        $this->connection          = new Connection($this->userId);
        $this->connection->setNotificate('свои');
    }

    public function testIsSendShouldBeReturnFalseWithInitialData()
    {
        $isSend = $this->recordsSocketHelper->isSend($this->userId, $this->connection, $this->record);
        $this->assertFalse($isSend);
    }

    public function testIsSendShouldBeReturnTrueIfRecordTimeCreateIsEmpty()
    {
        $record                = $this->record;
        $record['time_create'] = '';
        $isSend                = $this->recordsSocketHelper->isSend($this->userId, $this->connection, $record);
        $this->assertTrue($isSend);
    }

    public function testIsSendShouldBeReturnTrueIfConnectionNotificateIsAll()
    {
        $this->connection->setNotificate('все');
        $isSend = $this->recordsSocketHelper->isSend($this->userId, $this->connection, $this->record);
        $this->assertTrue($isSend);
    }

    public function testIsSendShouldBeReturnTrueIfRecordCreatorIdEqualUserId()
    {
        $record               = $this->record;
        $record['creator_id'] = 1;
        $isSend               = $this->recordsSocketHelper->isSend($this->userId, $this->connection,
            $record);
        $this->assertTrue($isSend);
    }

    public function testIsSendShouldBeReturnTrueIfRecordMakerIdEqualUserId()
    {
        $record             = $this->record;
        $record['maker_id'] = 1;
        $isSend             = $this->recordsSocketHelper->isSend($this->userId, $this->connection,
            $record);
        $this->assertTrue($isSend);
    }

    public function testIsSendShouldBeReturnTrueIfRecordCloserIdEqualUserId()
    {
        $record              = $this->record;
        $record['closer_id'] = 1;
        $isSend              = $this->recordsSocketHelper->isSend($this->userId, $this->connection,
            $record);
        $this->assertTrue($isSend);
    }

    public function testIsSendShouldBeReturnFalseIfNotificateOff()
    {
        $this->connection->setNotificate('откл');
        $record                = $this->record;
        $record['closer_id']   = 1;
        $record['maker_id']    = 1;
        $record['creator_id']  = 1;
        $record['time_create'] = '';
        $isSend                = $this->recordsSocketHelper->isSend($this->userId, $this->connection,
            $record);
        $this->assertFalse($isSend);
    }

    public function testGetUpdatedRecordsShouldBeReturnCorrectRecord()
    {
        $result  = '{"records":[{"id":311,"creator_id":15,"type":"\u0410\u0412\u0410\u0420\u0418\u0419\u041d\u0410\u042f \u0411\u041b\u041e\u041a\u0418\u0420\u041e\u0412\u041a\u0410","theme":null,"theme_end":null,"time_create":"2020-01-16T13:12:40.000000Z","time_sent":"2020-01-16T13:12:56.000000Z","maker_id":13,"time_take":"2020-01-16T13:12:58.000000Z","time_done":"2020-01-16T13:00:00.000000Z","closer_id":15,"notice":null,"time_incident":"2020-01-16T13:12:00.000000Z","time_evacuation":null,"evacuation":0,"created_at":"2020-01-16 13:12:40","updated_at":"2020-01-16 13:13:04","deleted_at":null,"num":311}],"removedRecords":[]}';
        $records = $this->recordsSocketHelper->getUpdatedRecords("[311]");
        $this->assertEquals(json_encode($records), $result);
    }

    public function testGetUpdatedRecordsShouldBeReturnCorrectRecords()
    {
        $result  = '{"records":[{"id":311,"creator_id":15,"type":"\u0410\u0412\u0410\u0420\u0418\u0419\u041d\u0410\u042f \u0411\u041b\u041e\u041a\u0418\u0420\u041e\u0412\u041a\u0410","theme":null,"theme_end":null,"time_create":"2020-01-16T13:12:40.000000Z","time_sent":"2020-01-16T13:12:56.000000Z","maker_id":13,"time_take":"2020-01-16T13:12:58.000000Z","time_done":"2020-01-16T13:00:00.000000Z","closer_id":15,"notice":null,"time_incident":"2020-01-16T13:12:00.000000Z","time_evacuation":null,"evacuation":0,"created_at":"2020-01-16 13:12:40","updated_at":"2020-01-16 13:13:04","deleted_at":null,"num":311},{"id":312,"creator_id":15,"type":"\u0410\u0412\u0410\u0420\u0418\u0419\u041d\u0410\u042f \u0411\u041b\u041e\u041a\u0418\u0420\u041e\u0412\u041a\u0410","theme":null,"theme_end":null,"time_create":"2020-01-16T13:13:11.000000Z","time_sent":"2020-03-29T09:58:58.000000Z","maker_id":1,"time_take":"2020-03-29T09:15:39.000000Z","time_done":"2020-03-17T17:00:00.000000Z","closer_id":1,"notice":null,"time_incident":"2020-01-16T13:13:00.000000Z","time_evacuation":null,"evacuation":0,"created_at":"2020-01-16 13:13:11","updated_at":"2020-03-29 09:59:44","deleted_at":null,"num":312}],"removedRecords":[]}';
        $records = $this->recordsSocketHelper->getUpdatedRecords("[311, 312]");
        $this->assertEquals(json_encode($records), $result);
    }

    public function testGetUpdatedRecordsShouldBeReturnRemovedRecord()
    {
        $result  = '{"records":[],"removedRecords":[{"id":3333333333}]}';
        $records = $this->recordsSocketHelper->getUpdatedRecords("[3333333333]");
        $this->assertEquals(json_encode($records), $result);
    }

    public function testGetUpdatedRecordsShouldBeReturnRemovedRecords()
    {
        $result  = '{"records":[],"removedRecords":[{"id":3333333333},{"id":44444444444}]}';
        $records = $this->recordsSocketHelper->getUpdatedRecords("[3333333333,44444444444]");
        $this->assertEquals(json_encode($records), $result);
    }

    public function testGetUpdatedRecordsShouldBeReturnRemovedAndUpdatedRecords()
    {
        $result  = '{"records":[{"id":311,"creator_id":15,"type":"\u0410\u0412\u0410\u0420\u0418\u0419\u041d\u0410\u042f \u0411\u041b\u041e\u041a\u0418\u0420\u041e\u0412\u041a\u0410","theme":null,"theme_end":null,"time_create":"2020-01-16T13:12:40.000000Z","time_sent":"2020-01-16T13:12:56.000000Z","maker_id":13,"time_take":"2020-01-16T13:12:58.000000Z","time_done":"2020-01-16T13:00:00.000000Z","closer_id":15,"notice":null,"time_incident":"2020-01-16T13:12:00.000000Z","time_evacuation":null,"evacuation":0,"created_at":"2020-01-16 13:12:40","updated_at":"2020-01-16 13:13:04","deleted_at":null,"num":311}],"removedRecords":[{"id":44444444444}]}';
        $records = $this->recordsSocketHelper->getUpdatedRecords("[311,44444444444]");
        $this->assertEquals(json_encode($records), $result);
    }


    protected function tearDown(): void
    {
        // Do something
        parent::tearDown();
    }
}
