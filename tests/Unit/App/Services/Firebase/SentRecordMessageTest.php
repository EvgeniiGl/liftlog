<?php

namespace Tests\Unit\App\Services\Firebase;

use App\Models\Device;
use App\Services\Firebase\SentRecordMessage;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Modules\Address\Repositories\AddressRepository;
use Modules\Records\Models\Record;
use Tests\TestCase;


class SentRecordMessageTest extends TestCase
{
    protected $addressRepositoryMock;
    protected $deviceModelMock;
    protected $recordModelMock;
    protected $sentRecordMessage;

    protected function setUp(): void
    {
        $this->deviceModelMock       = \Mockery::mock(Device::class);
        $this->addressRepositoryMock = \Mockery::mock(AddressRepository::class);
        $this->recordModelMock       = \Mockery::mock(Record::class);
        $this->sentRecordMessage     = new SentRecordMessage($this->addressRepositoryMock, $this->deviceModelMock,
            $this->recordModelMock);
    }

    public function testRecipientDeviceExistReturnFalseIfDeviceNotExist()
    {
        $mockDeviceResult = \Mockery::mock(Model::class);
        $mockDeviceResult->shouldReceive('first')->andReturn(null);
        $this->deviceModelMock->shouldReceive('where')->andReturn($mockDeviceResult);
        $existDevice = $this->sentRecordMessage->recipientDeviceExist();
        $this->assertFalse($existDevice);
    }

    public function testRecipientDeviceExistReturnTrueIfDeviceExist()
    {
        $device           = new Device ();
        $device->token    = "some-token";
        $mockDeviceResult = \Mockery::mock(Model::class);
        $mockDeviceResult->shouldReceive('first')->andReturn($device);
        $this->deviceModelMock->shouldReceive('where')->andReturn($mockDeviceResult);
        $existDevice = $this->sentRecordMessage->recipientDeviceExist();
        $this->assertTrue($existDevice);
    }

    public function testGetMessageThrowExceptionIfDataDoesNotContainRecipient()
    {
        $this->expectException(Exception::class);
        $existDevice = $this->sentRecordMessage->getMessage();
        $this->assertTrue($existDevice);
    }

    public function testGetMessageReturnCorrectCloudMessage()
    {
        $data    = [
            'id'       => 311,
            'maker_id' => 15,
        ];
        $address = (object)[
            "id"           => "0x82781867B034286411E7D8EAEDE088B5",
            "house"        => "32",
            "house_letter" => "б",
            "num_lift"     => "1",
            "city"         => "Новокузнецк",
            "street"       => "Екимова",
            "records_id"   => 2008
        ];
        $record  = new Record();
        $record->fill(['type' => 'TYPE SOME']);
        $device           = new Device ();
        $device->token    = "some-token";
        $mockDeviceResult = \Mockery::mock(Model::class);
        $mockDeviceResult->shouldReceive('first')->andReturn($device);
        $this->deviceModelMock->shouldReceive('where')->andReturn($mockDeviceResult);
        $this->recordModelMock->shouldReceive('find')->andReturn($record);
        $this->addressRepositoryMock->shouldReceive('getAddressByRecords')->andReturn([$address]);
        $sentRecordMessage = new SentRecordMessage($this->addressRepositoryMock, $this->deviceModelMock,
            $this->recordModelMock, $data);
        $sentRecordMessage->recipientDeviceExist();
        $cloudMessage = $sentRecordMessage->getMessage();
        $this->assertTrue($cloudMessage->hasTarget());
        $this->assertEquals($cloudMessage->jsonSerialize()['token'], 'some-token');
        $this->assertEquals($cloudMessage->jsonSerialize()['data']->jsonSerialize(), [
                "title" => "TYPE SOME",
                "body"  => "Новокузнецк, Екимова, 32, б, 1"
            ]
        );
    }
}
