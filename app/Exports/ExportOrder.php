<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportOrder implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('orders')
            ->select('orders.sprint_ref','orders.departure_status', 'orders.document_status', 'orders.pre_alert_sent', 'orders.pre_alert_docs',
                'orders.custom_entry', 'orders.mucr_closed', 'orders.fwb_fhl', 'orders.docs_to_print', 'orders.invoice_amount_comment', 'orders.invoice_number',
                'orders.invoice_value', 'orders.status', 'orders.creation_date', 'orders.claims_date', 'orders.processed_date', 'orders.closed_date',
                'shipments.client','shipments.destination','shipments.shipper','shipments.pcs','shipments.gross_weight','shipments.cw_pre_alert','shipments.cw_print',
                'shipments.dep_airport','shipments.airline','shipments.awb_number','shipments.flight_date','shipments.transporter','shipments.coll_date','shipments.warehouse','shipments.expected_transport_cost',
                'shipments.current_processing_status', 'accounts.freight_charges','accounts.transport_cost','accounts.security_charges','accounts.entry_cost','accounts.misc_charges','accounts.import_handling_cost','accounts.customs',
                'accounts.overseas_charges','accounts.gross_profit')
            ->leftJoin('shipments', 'orders.id', '=', 'shipments.order_id')
            ->leftJoin('accounts', 'orders.id', '=', 'accounts.order_id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Sprint Ref',
            'Departure Status',
            'Document Status',
            'Pre Alert Sent',
            'Pre Alert Docs',
            'Custom Entry',
            'MUCR Closed',
            'FWB/FHL',
            'Docs To Print',
            'Invoice Amount Comment',
            'Invoice Number',
            'Invoice Value',
            'Status',
            'Creation Date',
            'Claims Date',
            'Process Date',
            'Closed Date',
            'Client',
            'Destination',
            'Shipper',
            'PCS',
            'Gross Weight',
            'CW Pre Alert',
            'CW Print',
            'Dep Airport',
            'Airline',
            'AWB Number',
            'Flight Date',
            'Transporter',
            'Coll Date',
            'Warehouse',
            'Expected Transport Cost',
            'Current Processing Status',
            'Freight Charges',
            'Transport Cost',
            'Security Charges',
            'Entry Cost',
            'MISC Charges',
            'Import Handling Cost',
            'Customs',
            'Overseas Charges',
            'Gross Profit'
        ];
    }
}
