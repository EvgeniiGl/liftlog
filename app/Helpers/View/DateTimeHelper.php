<?php

namespace App\Helpers\View;

use Carbon\Carbon;

class DateTimeHelper
{
    /**
     * Carbon helper
     *
     * @param $time Carbon
     *
     * @return string format 'H:i d.m.Y'
     */

    public static function formatToString($time)
    {
        if ($time === null) return null;
        return $time->format('H:i d.m.Y');
    }

    /**
     * Reformat string time "d.m.Y H:i" to time Carbon
     *
     * @param string $timeStr
     *
     * @return Carbon time
     */

    public static function reformatStringToTime($timeStr)
    {
        if (empty($timeStr)) return null;
        return Carbon::createFromFormat('d.m.Y H:i', $timeStr);
    }
}
