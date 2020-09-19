<?php

namespace Modules\Records\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{

    protected $fillable = [
        "theme",
        "type_id",
        'num',
        "maker_id",
        "creator_id",
        "time_create",
        "time_sent",
        "evacuation",
        "time_take",
        "time_incident",
        "time_evacuation",
        "theme_end",
        "time_done",
        "closer_id",
    ];

//    protected $appends = [
//        'timesent_utc',
//        'timedone_utc',
//    ];

    protected $dateFormat;


    public function __construct($attributes = [])
    {
        $this->dateFormat = config('datetime_format.dateFormat') . " " . config('datetime_format.timeFormat');
        parent::__construct($attributes);
    }

    public function getTimeUtc($time = null)
    {
        $timeZone = 'Asia/Novokuznetsk';
        return empty($time) ? null : Carbon::parse($time)->timezone($timeZone);
    }

    public function getTimeCreateAttribute($time = null)
    {
        $timeZone = 'Asia/Novokuznetsk';
        return empty($time) ? null : Carbon::parse($time)->timezone($timeZone);
    }

    public function getTimeSentAttribute($time = null)
    {
        $timeZone = 'Asia/Novokuznetsk';
        return empty($time) ? null : Carbon::parse($time)->timezone($timeZone);
    }

    public function getTimeTakeAttribute($time = null)
    {
        $timeZone = 'Asia/Novokuznetsk';
        return empty($time) ? null : Carbon::parse($time)->timezone($timeZone);
    }

    public function getTimeDoneAttribute($time = null)
    {
        $timeZone = 'Asia/Novokuznetsk';
        return empty($time) ? null : Carbon::parse($time)->timezone($timeZone);
    }

    public function getTimeIncidentAttribute($time = null)
    {
        $timeZone = 'Asia/Novokuznetsk';
        return empty($time) ? null : Carbon::parse($time)->timezone($timeZone);
    }

    public function getTimeEvacuationAttribute($time = null)
    {
        $timeZone = 'Asia/Novokuznetsk';
        return empty($time) ? null : Carbon::parse($time)->timezone($timeZone);
    }

    public function getUpdatedAtAttribute($time = null)
    {
        $timeZone = 'Asia/Novokuznetsk';
        return empty($time) ? null : Carbon::parse($time)->timezone($timeZone);
    }

    public function getCreatedAtAttribute($time = null)
    {
        $timeZone = 'Asia/Novokuznetsk';
        return empty($time) ? null : Carbon::parse($time)->timezone($timeZone);
    }

    public function setTimeDoneAttribute($time = null)
    {
        $timeCarbon                    = empty($time) ? null : Carbon::parse($time)->addHours(-7);
        $this->attributes['time_done'] = $timeCarbon;
    }


    public function setTimeTakeAttribute($time = null)
    {
        if ($time instanceof Carbon) {
            $timeCarbon = $time;
        } else {
            $timeCarbon = empty($time) ? null : Carbon::parse($time)->addHours(-7);
        }
        $this->attributes['time_take'] = $timeCarbon;
    }

    public function setTimeSentAttribute($time = null)
    {
        if ($time instanceof Carbon) {
            $timeCarbon = $time;
        } else {
            $timeCarbon = empty($time) ? null : Carbon::parse($time)->addHours(-7);
        }
        $this->attributes['time_sent'] = $timeCarbon;
    }

    public function setTimeEvacuationAttribute($time = null)
    {
        $timeCarbon                          = empty($time) ? null : Carbon::parse($time)->addHours(-7);
        $this->attributes['time_evacuation'] = $timeCarbon;
    }

    public function setTimeIncidentAttribute($time = null)
    {
        $timeCarbon                        = empty($time) ? null : Carbon::parse($time)->addHours(-7);
        $this->attributes['time_incident'] = $timeCarbon;
    }

    public function setTimeUpdatedAtAtribute($time = null)
    {
        $timeCarbon                     = empty($time) ? null : Carbon::parse($time)->addHours(-7);
        $this->attributes['updated_at'] = $timeCarbon;
    }

    public function setTimeCreatedAtAttribute($time = null)
    {
        $timeCarbon                     = empty($time) ? null : Carbon::parse($time)->addHours(-7);
        $this->attributes['created_at'] = $timeCarbon;
    }

    /**
     * @return array ids of users who use the record
     */
    public function getIdUsersRecord()
    {
        $idUsers   = [];
        $idUsers[] = $this->attributes['creator_id'];
        $idUsers[] = $this->attributes['maker_id'];
        $idUsers[] = $this->attributes['closer_id'];
        return array_filter($idUsers);
    }

    public function type()
    {
        return $this->hasOne('App\Models\Type','id','type_id');
    }
}
