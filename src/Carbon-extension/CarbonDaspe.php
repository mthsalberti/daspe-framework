<?php
namespace Daspeweb\Framework;

use Carbon\Carbon;

class CarbonDaspe extends Carbon
{
    public static function parse($time = null, $tz = null)
    {
        $dt = self::createDate($time);
        if(!$dt){
            return parent::parse($time, $tz);
        }else{
            return $dt;
        }
    }
    private static function createDate($time){
        if (preg_match("/(last|next) [0-9]+/i", $time)) {
            $param = preg_replace("/(.*) (.*) (.*)/", "$1", $time);
            $number = preg_replace("/(.*) (.*) (.*)/", "$2", $time);
            $unit = preg_replace("/(.*) (.*) (.*)/", "$3", $time);
            if($param == 'next'){
                if($unit == 'minutes'){
                    return Carbon::now()->addMinutes($number);
                }else if($unit == 'hours'){
                    return Carbon::now()->addHours($number);
                }else if($unit == 'days'){
                    return Carbon::now()->addDays($number);
                }else if($unit == 'weeks'){
                    return Carbon::now()->addWeeks($number);
                }else if($unit == 'months'){
                    return Carbon::now()->addMonths($number);
                }else if($unit == 'years'){
                    return Carbon::now()->addYears($number);
                }
            }else if($param == 'last'){
                if($unit == 'minutes'){
                    return Carbon::now()->subMinutes($number);
                }else if($unit == 'hours'){
                    return Carbon::now()->subHours($number);
                }else if($unit == 'days'){
                    return Carbon::now()->subDays($number);
                }else if($unit == 'weeks'){
                    return Carbon::now()->subWeeks($number);
                }else if($unit == 'months'){
                    return Carbon::now()->subMonths($number);
                }else if($unit == 'years'){
                    return Carbon::now()->subYears($number);
                }
            }
        }
        return false;
    }
}
