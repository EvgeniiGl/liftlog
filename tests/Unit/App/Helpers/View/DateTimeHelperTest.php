<?php

namespace App\Helpers\View;

use Carbon\Carbon;
use Tests\TestCase;

class DateTimeHelperTest extends TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testHelperToFormateDateTimeCorect()
    {
        $date        = Carbon::now();
        $strDateTime = DateTimeHelper::formatToString($date);
        $this->assertNotFalse(Carbon::createFromFormat('H:i d.m.Y', $strDateTime));
    }

    public function testHelperReturnNullIfDateIsNull()
    {
        $date        = null;
        $strDateTime = DateTimeHelper::formatToString($date);
        $this->assertNull($strDateTime);
    }
}
