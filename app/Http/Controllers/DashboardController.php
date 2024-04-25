<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    public function index(){

        $user = Auth::user();
        $user_role = null;
        if ($user->hasRole('System Administrator')) {
            $user_role = 'System Administrator';
        } elseif ($user->hasRole('MGMT')) {
            $user_role = 'MGMT';
        } elseif ($user->hasRole('OPS')) {
            $user_role = 'OPS';
        } elseif ($user->hasRole('Accountant')) {
            $user_role = 'Accountant';
        }


        $users = User::whereHas('roles', function($query) {
            $query->where('name', 'OPS');
        })->get();

        if($user->hasRole('OPS')){
            $id = $user->id;
        }else{
            $all = true;
            $id = null;
        }


        $output['data_chart_user'] = $user;
        $output['login_user_role'] = $user_role;
        $output['login_user_id'] = $user->id;
        $output['users'] = $users;
        $output['id'] = isset($id)?$id:null;
        $output['from'] = isset($from)?$from:null;
        $output['to'] = isset($to)?$to:null;
        $output['search'] = isset($search)?$search:null;
        $output['all'] = isset($all)?$all:null;
        return view('dashboard', $output);
    }

    public function get_ops_data(Request $request){
        $id = $request->input('id');
        $from = $request->input('from');
        $to = $request->input('to');
        $all = $request->input('all');

        if($from){
            $from = date('Y-m-d', strtotime($from));
        }
        if ($to){
            $to = date('Y-m-d', strtotime($to));
        }
        $currentYear = Carbon::now()->year;
        $data = DB::table('orders')
            ->select(DB::raw('DATE_FORMAT(creation_date, "%Y-%m") AS month'), DB::raw('COUNT(*) AS order_count'))
            ->where('status', 'under_process')
            ->whereYear('creation_date', $currentYear)
            ->when(!$all && $id, function ($q) use ($id) {
                return $q->where('claims_by', $id);
            })
            ->when($from && $to, function ($q) use ($from, $to) {
                return $q->whereRaw('DATE(orders.creation_date) >= ?', [$from])
                    ->whereRaw('DATE(orders.creation_date) <= ?', [$to]);
            })
            ->groupBy(DB::raw('DATE_FORMAT(creation_date, "%Y-%m")'))
            ->get();
        $formattedData = [];
        foreach ($data as $item) {
            $formattedData[$item->month] = $item->order_count;
        }
        $allMonthsData = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT); // Ensure two digits for month format
            $allMonthsData["$currentYear-$month"] = isset($formattedData["$currentYear-$month"]) ? $formattedData["$currentYear-$month"] : 0;
        }
        return response()->json($allMonthsData);
    }

    public function search_graph_data(Request $request){
        $all = false;
        if($request->get('user_id')){
            if($request->get('user_id') === 'all'){
                $user = null;
                $all = true;
            }else{
                $user_id = $request->get('user_id');
                $user = User::query()->find($user_id);
            }
        }else{
            $user = null;
        }
        $from = $request->get('fromDate');
        $to = $request->get('toDate');
        $search = $request->get('search');

        $users = User::whereHas('roles', function($query) {
            $query->where('name', 'OPS');
        })->get();



        $login_user = Auth::user();
        $user_role = null;
        if ($login_user->hasRole('System Administrator')) {
            $user_role = 'System Administrator';
        } elseif ($login_user->hasRole('MGMT')) {
            $user_role = 'MGMT';
        } elseif ($login_user->hasRole('OPS')) {
            $user_role = 'OPS';
        } elseif ($login_user->hasRole('Accountant')) {
            $user_role = 'Accountant';
        }

        $output['data_chart_user'] = $user;
        $output['login_user_role'] = $user_role;
        $output['login_user_id'] = $login_user->id;
        $output['users'] = $users;
        $output['id'] = isset($user)&&$user?$user->id:null;
        $output['from'] = $from;
        $output['to'] = $to;
        $output['search'] = $search;
        $output['all'] = $all;
        return view('dashboard', $output);
//        return Redirect::route('dashboard', ['id' =>$user_id, 'from' => $from, 'to' => $to, 'search' => $search]);
    }

    public function get_mgmt_data(Request $request){
        $search = $request->input('search');
        $id = $request->input('id');
        $from = $request->input('from');
        $to = $request->input('to');
        $all = $request->input('all');
        if($from){
            $from = date('Y-m-d', strtotime($from));
        }
        if ($to){
            $to = date('Y-m-d', strtotime($to));
        }

        $orders = Order::selectRaw('DATE_FORMAT(creation_date, "%Y-%m") as month')
            ->selectRaw('SUM(status = "open") as open_count')
            ->selectRaw('SUM(status = "under_process") as under_process_count')
            ->selectRaw('SUM(status = "processed") as processed_count');

        if ($from && $to) {
            // Filter orders based on the specified date range
            $orders->whereBetween('creation_date', [$from, $to]);
        }

        if (!$all && $id) {
            // Additional filtering based on user or some ID if provided
            $orders->where('claims_by', $id);
        }

        $orders = $orders->groupBy('month')
            ->orderBy('month')
            ->get();

        $data = [];
        // Iterate through months to initialize data array
        $startYear = ($from) ? date('Y', strtotime($from)) : date('Y');
        $endYear = ($to) ? date('Y', strtotime($to)) : date('Y');
        for ($year = $startYear; $year <= $endYear; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                $monthKey = sprintf('%d-%02d', $year, $month);
                $data[$monthKey] = [
                    'open' => 0,
                    'under_process' => 0,
                    'processed' => 0
                ];
            }
        }

        // Populate data array with fetched orders
        foreach ($orders as $order) {
            $data[$order->month] = [
                'open' => $order->open_count,
                'under_process' => $order->under_process_count,
                'processed' => $order->processed_count
            ];
        }

        return response()->json($data);
    }

    public function get_mgmt_gross_profit_data(Request $request){
        $id = $request->input('id');
        $from = $request->input('from');
        $to = $request->input('to');
        $all = $request->input('all');

        if($from){
            $from = date('Y-m-d', strtotime($from));
        }
        if ($to){
            $to = date('Y-m-d', strtotime($to));
        }

        $grossProfits = Account::join('orders', 'accounts.order_id', '=', 'orders.id')
            ->selectRaw('DATE_FORMAT(orders.creation_date, "%Y-%m") as month')
            ->selectRaw('SUM(accounts.gross_profit) as total_gross_profit');

        if ($from && $to) {
            $grossProfits->whereBetween('orders.creation_date', [$from, $to]);
        }

        if (!$all && $id) {
            $grossProfits->where('orders.claims_by', $id);
        }

        $grossProfits = $grossProfits->groupBy('month')
            ->orderByRaw('DATE_FORMAT(orders.creation_date, "%Y-%m")') // Order by month
            ->get();

        $data = [];
        $startDate = $from ? Carbon::parse($from)->startOfMonth() : Carbon::now()->startOfYear();
        $endDate = $to ? Carbon::parse($to)->endOfMonth() : Carbon::now()->endOfYear();

        while ($startDate <= $endDate) {
            $monthKey = $startDate->format('Y-m');
            $data[$monthKey] = 0;
            $startDate->addMonth();
        }

        foreach ($grossProfits as $grossProfit) {
            $data[$grossProfit->month] = $grossProfit->total_gross_profit;
        }

        return response()->json($data);
    }


    public function get_mgmt_shipments_data(Request $request){
        $id = $request->input('id');
        $from = $request->input('from');
        $to = $request->input('to');
        $all = $request->input('all');

        if($from){
            $from = date('Y-m-d', strtotime($from));
        }
        if ($to){
            $to = date('Y-m-d', strtotime($to));
        }

        $shipments = Order::selectRaw('DATE_FORMAT(claims_date, "%Y-%m") as month')
            ->selectRaw('COUNT(*) as shipment_count')
            ->whereNotNull('claims_date')
            ->whereNotNull('claims_by')
            ->when($from && $to, function ($q) use ($from, $to) {
                return $q->whereBetween('claims_date', [$from, $to]);
            })
            ->when(!$all && $id, function ($q) use ($id) {
                return $q->where('claims_by', $id);
            })
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $data = [];
        // Extract year and month from provided date range or current date
        $startDate = $from ? Carbon::createFromFormat('Y-m-d', $from)->startOfMonth() : Carbon::now()->startOfYear();
        $endDate = $to ? Carbon::createFromFormat('Y-m-d', $to)->endOfMonth() : Carbon::now()->endOfYear();

        // Generate data for each month within the provided date range
        while ($startDate->lte($endDate)) {
            $monthKey = $startDate->format('Y-m');
            $data[$monthKey] = 0;
            $startDate->addMonth();
        }

        // Update counts for months with data from the database
        foreach ($shipments as $shipment) {
            $data[$shipment->month] = $shipment->shipment_count;
        }

        return response()->json($data);
    }

    public function get_mgmt_non_invoiced_data(Request $request){
        $id = $request->input('id');
        $from = $request->input('from');
        $to = $request->input('to');
        $all = $request->input('all');

        if($from){
            $from = date('Y-m-d', strtotime($from));
        }
        if ($to){
            $to = date('Y-m-d', strtotime($to));
        }

        $nonInvoicedOrders = Order::selectRaw('DATE_FORMAT(creation_date, "%Y-%m") as month')
            ->selectRaw('COUNT(*) as non_invoiced_count')
            ->where(function ($query) {
                $query->where('invoice_value', 0.0)
                    ->orWhere('invoice_value', '<=', 0);
            })
            ->when(!$all && $id, function ($q) use ($id) {
                return $q->where('claims_by', $id);
            })
            ->when($from && $to, function ($q) use ($from, $to) {
                return $q->whereDate('creation_date', '>=', $from)
                    ->whereDate('creation_date', '<=', $to);
            })
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $data = [];

        // Populate data array with zero values for all months within the date range
        $startDate = Carbon::parse($from ?? '')->startOfMonth();
        $endDate = Carbon::parse($to ?? '')->endOfMonth();
        while ($startDate <= $endDate) {
            $data[$startDate->format('Y-m')] = 0;
            $startDate->addMonth();
        }

        // Fill in non-invoiced counts for each month
        foreach ($nonInvoicedOrders as $order) {
            $data[$order->month] = $order->non_invoiced_count;
        }

        return response()->json($data);
    }

    public function search_lhr(Request $request){
        $searchQuery = $request->input('search_query');
        if ($searchQuery === '000') {
            $orders = Order::with(['shipment', 'user'])->orderBy('created_at', 'desc')->get();
        } else {
            $orders = Order::with(['shipment', 'user'])->where(function ($query) use ($searchQuery) {
                $query->where('sprint_ref', 'like', '%' . $searchQuery . '%')
                    ->orWhere('status', 'like', '%' . $searchQuery . '%')
                    ->orWhereHas('shipment', function ($query) use ($searchQuery) {
                        $query->where('awb_number', 'like', '%' . $searchQuery . '%')
                            ->orWhere('transporter', 'like', '%' . $searchQuery . '%')
                            ->orWhere('shipper', 'like', '%' . $searchQuery . '%')
                            ->orWhere('warehouse', 'like', '%' . $searchQuery . '%');
                    });
            })->get();
        }
        return response()->json($orders);
    }



}
