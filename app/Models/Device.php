<?php


namespace App\Models;


use App\Models\Traits\FormatsDates;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use FormatsDates;
    
    /**
     * @var string date format
     */
    protected $dateFormat = 'Y-m-d';

    public function __construct($attributes = [])
    {
        //fix conflict MSSQL 2013 year
        $this->dateFormat = config('datetime_format.dateFormat') . " " . config('datetime_format.timeFormat');
        parent::__construct($attributes);
    }


    protected $fillable = [
        'token',
        'user_id',
        'active',
    ];

}
