<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
    function uppercase($str){
        return strtoupper($str);
    }

    function dateFormat($date)
    {
        if(!$date){
            return null;
        }else{
            return Carbon::parse($date)->format('d-m-Y');
        }
    }

    function getDays($startDate, $endDate) {
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        $differenceInDays = $endDate->diffInDays($startDate);
        return $differenceInDays;
    }
