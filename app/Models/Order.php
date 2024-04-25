<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }

    public function account(): HasOne
    {
        return $this->hasOne(Account::class);
    }

    public static function getOrders($status, $user_id = null, $fromDate = null, $toDate = null, $role = null, $search_by_user = null)
    {
        if($fromDate){
            $fromDate = date('Y-m-d', strtotime($fromDate));
        }
        if ($toDate){
            $toDate = date('Y-m-d', strtotime($toDate));
        }
        return Order::with(['user', 'shipment', 'account'])
            ->select('orders.*', 'users.name')
            ->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->leftJoin('users as u1', 'u1.id', '=', 'orders.claims_by')
            ->when($user_id, function ($q) use ($user_id, $status, $role, $search_by_user) {
                if($role == 'MGMT' && !$search_by_user){
                    return $q->where('user_id', $user_id);
                }elseif ($role == 'OPS' || $search_by_user){
                    if($status == 'under_process'){
                        return $q->where('claims_by', $user_id);
                    }elseif ($status == 'processed'){
                        return $q->where('processed_by', $user_id);
                    }elseif ($status == 'closed'){
                        return $q->where('processed_by', $user_id);
                    }
                }
            })
            ->when(in_array($status, ['under_process', 'processed', 'closed']), function ($q) use ($status) {
                return $q->leftJoin('users as u', function ($join) use ($status) {
                    if ($status == 'under_process') {
                        $join->on('u.id', '=', 'orders.claims_by');
                    } elseif ($status == 'processed') {
                        $join->on('u.id', '=', 'orders.processed_by');
                    } elseif ($status == 'closed') {
                        $join->on('u.id', '=', 'orders.processed_by');
                    }
                })->addSelect('u.name as ops_user');
            })
            ->when($fromDate && $toDate, function ($q) use ($status, $fromDate, $toDate, $role) {
                    if ($status == 'open' || $role == 'Accountant' || $role == 'System Administrator') {
                        return $q->whereRaw('DATE(orders.creation_date) >= ?', [$fromDate])
                            ->whereRaw('DATE(orders.creation_date) <= ?', [$toDate]);
                    }elseif ($status == 'under_process') {
                        return $q->whereRaw('DATE(orders.creation_date) >= ?', [$fromDate])
                            ->whereRaw('DATE(orders.creation_date) <= ?', [$toDate]);
                    } elseif ($status == 'processed') {
                        return $q->whereRaw('DATE(orders.creation_date) >= ?', [$fromDate])
                            ->whereRaw('DATE(orders.creation_date) <= ?', [$toDate]);
                    } elseif ($status == 'closed') {
                        return $q->whereRaw('DATE(orders.creation_date) >= ?', [$fromDate])
                            ->whereRaw('DATE(orders.creation_date) <= ?', [$toDate]);
                    }
            })
            ->where('orders.status', $status)
            ->get();
    }

    public static function storeShipment($order){
        return Shipment::create([
            'order_id' => $order->id,
        ]);
    }

    public static function storeAccount($order){
        return Account::create([
            'order_id' => $order->id,
        ]);
    }

    public static function updateOrder($data, $id){
        $order_input = [];
        $order_input['sprint_ref'] = isset($data['sprint_ref'])?$data['sprint_ref']:'';
        $order_input['departure_status'] = isset($data['departure_status'])?$data['departure_status']:'';
        $order_input['document_status'] = isset($data['document_status'])?$data['document_status']:'';
        $order_input['pre_alert_sent'] = isset($data['pre_alert_sent'])?$data['pre_alert_sent']:'';
        $order_input['pre_alert_docs'] = isset($data['pre_alert_docs'])?$data['pre_alert_docs']:'';
        $order_input['custom_entry'] = isset($data['custom_entry'])?$data['custom_entry']:'';
        $order_input['mucr_closed'] = isset($data['mucr_closed'])?$data['mucr_closed']:'';
        $order_input['fwb_fhl'] = isset($data['fwb_fhl'])?$data['fwb_fhl']:'';
        $order_input['docs_to_print'] = isset($data['docs_to_print'])?$data['docs_to_print']:'';
        $order_input['invoice_amount_comment'] = isset($data['invoice_amount_comment'])?$data['invoice_amount_comment']:'';
        $order_input['invoice_number'] = isset($data['invoice_number'])?$data['invoice_number']:'';
        $order_input['invoice_value'] = isset($data['invoice_value'])?$data['invoice_value']:'';
        return Order::find($id)->update($order_input);
    }

    public static function updateShipment($data, $shipment)
    {
        $shipment_input = [];
        $shipment_input['client'] = isset($data['client']) ? $data['client'] : null;
        $shipment_input['destination'] = isset($data['destination']) ? $data['destination'] : null;
        $shipment_input['shipper'] = isset($data['shipper']) ? $data['shipper'] : null;
        $shipment_input['pcs'] = isset($data['pcs']) ? $data['pcs'] : null;
        $shipment_input['gross_weight'] = isset($data['gross_weight']) ? $data['gross_weight'] : null;
        $shipment_input['cw_pre_alert'] = isset($data['cw_pre_alert']) ? $data['cw_pre_alert'] : null;
        $shipment_input['cw_print'] = isset($data['cw_print']) ? $data['cw_print'] : null;
        $shipment_input['dep_airport'] = isset($data['dep_airport']) ? $data['dep_airport'] : null;
        $shipment_input['airline'] = isset($data['airline']) ? $data['airline'] : null;
        $shipment_input['awb_number'] = isset($data['awb_number']) ? $data['awb_number'] : null;
        $shipment_input['flight_date'] = isset($data['flight_date']) ? Carbon::createFromFormat('d-m-Y', $data['flight_date']) : null;
        $shipment_input['transporter'] = isset($data['transporter']) ? $data['transporter'] : null;
        $shipment_input['coll_date'] = isset($data['coll_date']) ? Carbon::createFromFormat('d-m-Y', $data['coll_date']) : null;
        $shipment_input['warehouse'] = isset($data['warehouse']) ? $data['warehouse'] : null;
        $shipment_input['expected_transport_cost'] = isset($data['expected_transport_cost']) ? $data['expected_transport_cost'] : null;
        $shipment_input['current_processing_status'] = isset($data['current_processing_status']) ? $data['current_processing_status'] : null;
        return Shipment::find($shipment->id)->update($shipment_input);
    }

    public static function updateAccount($data, $account)
    {
        $account_input = [];

        if(Auth::user()->hasRole('OPS')){
            $account_input['freight_charges'] = isset($account->freight_charges) ? $account->freight_charges : 0.0;
            $account_input['transport_cost'] = isset($account->transport_cost) ? $account->transport_cost : 0.0;
            $account_input['security_charges'] = isset($account->security_charges) ? $account->security_charges : 0.0;
            $account_input['entry_cost'] = isset($account->entry_cost) ? $account->entry_cost : 0.0;
            $account_input['misc_charges'] = isset($account->misc_charges) ? $account->misc_charges : 0.0;
            $account_input['import_handling_cost'] = isset($account->import_handling_cost) ? $account->import_handling_cost : 0.0;
            $account_input['customs'] = isset($account->customs) ? $account->customs : 0.0;
            $account_input['overseas_charges'] = isset($account->overseas_charges) ? $account->overseas_charges : 0.0;
            $account_input['gross_profit'] = isset($account->gross_profit) ? $account->gross_profit : 0.0;
        }else{
            $account_input['freight_charges'] = isset($data['freight_charges']) ? $data['freight_charges'] : 0.0;
            $account_input['transport_cost'] = isset($data['transport_cost']) ? $data['transport_cost'] : 0.0;
            $account_input['security_charges'] = isset($data['security_charges']) ? $data['security_charges'] : 0.0;
            $account_input['entry_cost'] = isset($data['entry_cost']) ? $data['entry_cost'] : 0.0;
            $account_input['misc_charges'] = isset($data['misc_charges']) ? $data['misc_charges'] : 0.0;
            $account_input['import_handling_cost'] = isset($data['import_handling_cost']) ? $data['import_handling_cost'] : 0.0;
            $account_input['customs'] = isset($data['customs']) ? $data['customs'] : 0.0;
            $account_input['overseas_charges'] = isset($data['overseas_charges']) ? $data['overseas_charges'] : 0.0;
            $account_input['gross_profit'] = isset($data['gross_profit']) ? $data['gross_profit'] : 0.0;
        }
        return Account::find($account->id)->update($account_input);
    }


    public static function isReferenceNumberTaken($digits) {
        return Order::whereRaw('SUBSTRING(sprint_ref, 4) = ?', [$digits])->exists();
    }
}
