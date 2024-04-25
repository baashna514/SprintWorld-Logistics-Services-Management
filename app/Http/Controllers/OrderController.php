<?php

namespace App\Http\Controllers;

use App\Exports\ExportOrder;
use App\Models\Comment;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{

    public function index($status = null){
        $user = Auth::user();
        if($status != 'open' && $user->hasRole("OPS")){
            $lhr = Order::getOrders($status, $user->id, null, null, 'OPS', null);
        }else{
            $lhr = Order::getOrders($status, null, null, null, null, null);
        }
        $users = [];
        if ($user->hasRole('MGMT')) {
            $users = User::whereHas('roles', function($query) {
                $query->where('name', 'OPS');
            })->get();
        } elseif ($user->hasRole('OPS')) {
            $users = User::whereHas('roles', function($query) {
                $query->where('name', 'OPS');
            })->get();
        } elseif ($user->hasRole('Accountant')) {
            $users = User::whereHas('roles', function($query) {
                $query->where('name', 'OPS');
            })->get();
        }
        $output['status'] = $status;
        $output['orders'] = $lhr;
        $output['login_user'] = $user;
        $output['users'] = $users;
        $output['from'] = null;
        $output['to'] = null;
        return view('lhr.list', $output);
    }

    public function exportOrders(Request $request){
        return Excel::download(new ExportOrder(), 'LHR.xlsx');
    }

    public function search(Request $request, $status){
//        dd($request->all());
        $user = Auth::user();
        $role = null;
        $users = [];
        if ($user->hasRole('MGMT')) {
            $role = 'MGMT';
            $users = User::whereHas('roles', function($query) {
                $query->where('name', 'OPS');
            })->get();
        } elseif ($user->hasRole('OPS')) {
            $role = 'OPS';
            $users = User::whereHas('roles', function($query) {
                $query->where('name', 'OPS');
            })->get();
        } elseif ($user->hasRole('Accountant')) {
            $role = 'Accountant';
            $users = User::whereHas('roles', function($query) {
                $query->where('name', 'OPS');
            })->get();
        }

        $lhr = Order::getOrders($status, $request->get('user_id'), $request->get('fromDate'), $request->get('toDate'), $role, 'true');
        $output['status'] = $status;
        $output['orders'] = $lhr;
        $output['login_user'] = $user;
        $output['users'] = $users;
        $output['from'] = $request->get('fromDate');
        $output['to'] = $request->get('toDate');
        return view('lhr.list', $output);
    }

    public function comments($id){
        $order = Order::find($id);
        $comments = Comment::with('user')->where('order_id', $id)->get();
        $output['order'] = $order;
        $output['comments'] = $comments;
        return view('lhr/comments', $output);
    }

    public function store_comment(Request $request, $id){
        $request->validate([
            'comment' => ['required'],
        ]);
        Comment::create([
            'order_id' => $id,
            'user_id' => Auth::id(),
            'description' => $request->comment,
        ]);
        return Redirect::back();
    }

    public function claim($id){
        $order = Order::find($id);
        $order->update([
            'status' => 'under_process',
            'claims_by' => Auth::id(),
            'claims_date' => Carbon::now()
        ]);
        return Redirect::route('orders', ['status' => 'under_process']);
    }

    public function processed($id){
        $order = Order::find($id);
        $order->update([
            'status' => 'processed',
            'processed_by' => Auth::id(),
            'processed_date' => Carbon::now()
        ]);
        return Redirect::route('orders', ['status' => 'processed']);
    }

    public function close($id){
        $order = Order::find($id);
        $order->update([
            'status' => 'closed',
            'closed_by' => Auth::id(),
            'closed_date' => Carbon::now()
        ]);
        return Redirect::route('orders', ['status' => 'closed']);
    }

    public function show($id){
        if(!$id){
            return Redirect::route('orders', ['status' => 'open'])->with('error', 'LHR not found with this ID.');
        }
        $lhr = Order::with(['user','shipment','account'])->find($id);
        $output['order'] = $lhr;
        $output['user'] = Auth::user();
        return view('lhr/view', $output);
    }
    public function create_lhr(){
        $lhr = Order::latest()->first();
        return view('lhr.add')->with('lhr', $lhr);
    }

    public function store_lhr(Request $request){
        $request->validate([
            'sprint_ref' => ['required', 'string', 'max:255'],
        ]);

        $digits = preg_replace("/[^0-9]/", "", $request->sprint_ref);
        if(Order::isReferenceNumberTaken($digits)){
            return back()->with('error', 'This Sprint Reff number is already taken');
        }

        $order = Order::create([
            'sprint_ref' => $request->sprint_ref,
            'user_id'    => Auth::id(),
            'creation_date' => Carbon::now()
        ]);
        if($order){
            Order::storeShipment($order);
            Order::storeAccount($order);
        }
        return Redirect::route('orders', ['status' => 'open'])->with('success', $request->sprint_ref. ' created successfully.');
    }

    public function edit($id){
        $lhr = Order::with(['user','shipment','account'])->find($id);
        $output['order'] = $lhr;
        $output['user'] = Auth::user();
        return view('lhr/edit', $output);
    }

    public function update(Request $request, $id){
        $request->validate([
            'sprint_ref' => ['required', 'string', 'max:255'],
        ]);
        $order = Order::find($id);
        if(!$order){
            return Redirect::route('orders', ['status' => 'open'])->with('error', 'LHR does not exist with this ID.');
        }
        $data = $request->all();
        $result1 = Order::updateOrder($data, $id);
        $result2 = Order::updateShipment($data, $order->shipment);
        $result3 = Order::updateAccount($data, $order->account);

        if($result1 && $result2 && $result3){
            return Redirect::route('orders', ['status' => $order->status])->with('success', 'LHR updated successfully.');
        }else{
            return Redirect::route('orders', ['status' => $order->status])->with('error', 'LHR does not updated.');
        }
    }
}
