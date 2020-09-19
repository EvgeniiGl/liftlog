<?php


namespace App\Models\Traits;


use Carbon\Carbon;

trait FormatsDates
{
    public function setUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(config('datetime_format.dateFormat'). " " . config('datetime_format.timeFormat'));
    }

    public function setCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(config('datetime_format.dateFormat'). " " . config('datetime_format.timeFormat'));
    }

    public function setExpiresAtAttribute($value)
    {
        return Carbon::parse($value)->format(config('datetime_format.dateFormat'). " " . config('datetime_format.timeFormat'));
    }


}
