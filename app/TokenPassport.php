<?php

namespace App;

use App\Models\Traits\FormatsDates;
use Laravel\Passport\Token;

/**
 * Overriding default model Passport Token set default date format for MSSQL 2013
 *
 * Class TokenPassport
 * @package App
 */
class TokenPassport extends Token
{
    use FormatsDates;
    /**
     * @var string date format
     */
    protected $dateFormat = 'Y-m-d';

    public function __construct($attributes = [])
    {
        //fix conflict MSSQL 2013 year
        $this->dateFormat = config('datetime_format.dateFormat'). " " . config('datetime_format.timeFormat');
        parent::__construct($attributes);
    }

}
