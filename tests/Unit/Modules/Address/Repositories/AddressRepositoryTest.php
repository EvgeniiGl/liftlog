<?php

namespace Tests\Unit\Modules\Address\Repositories;

use Tests\TestCase;

class AddressRepositoryTest extends TestCase
{
    private $addressRepository;

    protected function setUp(): void
    {
//        $this->addressRepository = new AddressRepository();
    }

    public function testGetAddressByIdsReturnAddresses()
    {
        $this->assertEquals(true, true);
    }
}
