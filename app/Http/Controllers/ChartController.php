<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function get_ops_data(){
        $currentYear = Carbon::now()->year;

        // Fetch data for the current year with counts
        $data = DB::table('orders')
            ->select(DB::raw('DATE_FORMAT(creation_date, "%Y-%m") AS month'), DB::raw('COUNT(*) AS order_count'))
            ->where('status', 'under_process')
            ->whereYear('creation_date', $currentYear)
            ->groupBy(DB::raw('DATE_FORMAT(creation_date, "%Y-%m")'))
            ->get();

        // Prepare an associative array with month as key and order count as value
        $formattedData = [];
        foreach ($data as $item) {
            $formattedData[$item->month] = $item->order_count;
        }

        // Generate data for all months of the current year (with count 0 for months without data)
        $allMonthsData = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT); // Ensure two digits for month format
            $allMonthsData["$month-$currentYear"] = isset($formattedData["$month-$currentYear"]) ? $formattedData["$month-$currentYear"] : 0;
        }

        return response()->json($allMonthsData);
    }
}
