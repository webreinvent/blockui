<?php
namespace Modules\Core\Libraries;

class CarbonHelper
{

    //---------------------------------------------------
    public static function parse($date_time)
    {
        return \Carbon::parse($date_time);
    }
    //---------------------------------------------------
    public static function format($date_time, $format)
    {
        return CarbonHelper::parse($date_time)->format($format);
    }
    //---------------------------------------------------
    public static function dateForHumans($date=null)
    {
        if(!$date)
        {
            $date = \Carbon::now();
        }
        return CarbonHelper::parse($date)->format('D, M d, Y');
    }
    //---------------------------------------------------
    public static function dateTimeForHumans($date=null)
    {
        if(!$date)
        {
            $date = \Carbon::now();
        }
        return CarbonHelper::parse($date)->format('D, M d, Y h:i A')." (IST)";
    }
    //---------------------------------------------------
    public static function differenceInSeconds($start, $end)
    {
        $end = CarbonHelper::parse($end);
        $start = CarbonHelper::parse($start);

        $seconds = $end->diffInSeconds($start);
        return $seconds;
    }
    //---------------------------------------------------
    public static function differenceInHHMMSS($start, $end)
    {
        $seconds = CarbonHelper::differenceInSeconds($start, $end);

        return gmdate('H:i:s', $seconds);
    }
    //---------------------------------------------------
    public static function differenceInHours($start, $end)
    {
        $seconds = CarbonHelper::differenceInSeconds($start, $end);
        return ceil($seconds/3600);
    }
    //---------------------------------------------------
    public static function differenceInFormat($start, $end, $format)
    {
        $seconds = CarbonHelper::differenceInSeconds($start, $end);
        return gmdate($format, $seconds);
    }
    //---------------------------------------------------
    public static function differenceInDays($start, $end)
    {
        $start = \Carbon::parse($start);
        $end = \Carbon::parse($end);

        return $end->diffInDays($start);




    }
    //---------------------------------------------------
    public static function secondsToFormat($seconds, $format)
    {
        return gmdate($format, $seconds);
    }
    //---------------------------------------------------
    public static function firstDayOfMonth($date)
    {
        $date = \Carbon::parse($date)->startOfMonth();
        return $date;
    }
    //---------------------------------------------------
    public static function lastDayOfMonth($date)
    {
        $date = \Carbon::parse($date)->endOfMonth();
        return $date;
    }
    //---------------------------------------------------
    public static function daysOfTheMonth($date)
    {
        $date = \Carbon::parse($date);
        $days = cal_days_in_month(CAL_GREGORIAN, $date->format('m'), $date->format('Y'));
        return $days;
    }
    //---------------------------------------------------
    public static function countDayOfTheMonth($date, $day_name='Sunday')
    {

        $start = CarbonHelper::firstDayOfMonth($date);
        $end = CarbonHelper::lastDayOfMonth($date);

        $dates = Date::getDaysBetweenDates($start, $end);


        $day_count = 0;
        foreach ($dates as $date_item)
        {
            $day = \Carbon::parse($date_item)->format('l');
            if($day == $day_name)
            {
                $day_count = $day_count+1;
            }
        }

        return $day_count;

    }
    //---------------------------------------------------
    //---------------------------------------------------
    //---------------------------------------------------

}
