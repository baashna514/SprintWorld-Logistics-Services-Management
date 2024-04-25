<!DOCTYPE html>
<html lang="en">


<!-- widget-chart.html  21 Nov 2019 03:49:32 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sprint World - Dashboard</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('assets/img/favicon.ico') }}' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>
<div class="loader"></div>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar sticky">
            @include('layouts.navbar')
        </nav>
        <div class="main-sidebar sidebar-style-2">
            @include('layouts.sidebar')
        </div>
        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-lg-12">
                            <div class="card">
                                <form class="needs-validation" novalidate="">
                                    <div class="card-header">
                                        <h4>LHR View</h4>
                                        <?php
                                        $can_edit = false;
                                        if($order->status == 'open') {
                                            if ($order->user->id == \Illuminate\Support\Facades\Auth::id() || \Illuminate\Support\Facades\Auth::user()->hasRole('System Administrator') || \Illuminate\Support\Facades\Auth::user()->hasRole('Accountant')){
                                                $can_edit = true;
                                            }
                                        }elseif ($order->status == 'under_process'){
                                            if ($order->claims_by == \Illuminate\Support\Facades\Auth::id() || \Illuminate\Support\Facades\Auth::user()->hasRole('MGMT') || \Illuminate\Support\Facades\Auth::user()->hasRole('System Administrator') || \Illuminate\Support\Facades\Auth::user()->hasRole('Accountant')){
                                                $can_edit = true;
                                            }
                                        }elseif ($order->status == 'processed'){
                                            if ($order->processed_by == \Illuminate\Support\Facades\Auth::id() || \Illuminate\Support\Facades\Auth::user()->hasRole('MGMT') || \Illuminate\Support\Facades\Auth::user()->hasRole('System Administrator') || \Illuminate\Support\Facades\Auth::user()->hasRole('Accountant')){
                                                $can_edit = true;
                                            }
                                        }elseif ($order->status == 'closed'){
                                            if (\Illuminate\Support\Facades\Auth::user()->hasRole('OPS') || \Illuminate\Support\Facades\Auth::user()->hasRole('MGMT') || \Illuminate\Support\Facades\Auth::user()->hasRole('System Administrator') || \Illuminate\Support\Facades\Auth::user()->hasRole('Accountant')){
                                                $can_edit = true;
                                            }
                                        }
                                        ?>
                                        @if($can_edit)
                                            <a href="{{ route('order-edit', ['id' => $order->id]) }}" title="Edit LHR" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 py-2 clearfix">
                                                <h5 class="float-left">SPRINT REF: {{ $order->sprint_ref }}</h5>
                                                <span class="float-right font-20">Days : {{ getDays($order->creation_date, $order->closed_date) }}</span>
                                            </div>
                                            <div class="col-12 col-sm-12 col-lg-12">
                                                <ul class="nav nav-pills" id="myTab3" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab"
                                                           aria-controls="home" aria-selected="true">General</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab"
                                                           aria-controls="profile" aria-selected="false">Shipment</a>
                                                    </li>
                                                    @if(!$user->hasRole('OPS'))
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#contact3" role="tab"
                                                               aria-controls="contact" aria-selected="false">Accounts</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                                <div class="tab-content" id="myTabContent2">
                                                    <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                                                        <div class="row">
                                                            @if($user->can('SPRINT REF view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">Sprint Ref</label>
                                                                        <input type="text" value="{{ $order->sprint_ref }}" class="form-control text-uppercase" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('DEPARTURE STATUS view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">Departure Status</label>
                                                                        <select class="form-control" readonly="">
                                                                            <option value="not departed" selected>{{ strtoupper($order->departure_status) }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('ORIGINAL DOCUMENTS STATUS view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">original document status</label>
                                                                        <input type="text" value="{{ $order->document_status }}" class="form-control text-uppercase" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('PRE-ALERT view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">pre-alert sent</label>
                                                                        <select class="form-control" readonly="">
                                                                            <option value="pending" selected>{{ strtoupper($order->pre_alert_sent) }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('PRE-ALERT DOCS APPROVED? view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">pre-alert docs approved?</label>
                                                                        <select class="form-control" readonly="">
                                                                            <option value="pending" selected>{{ strtoupper($order->pre_alert_docs) }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('CUSTOMS ENTRY view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">custom entry</label>
                                                                        <select class="form-control" readonly="">
                                                                            <option value="pending" selected>{{ strtoupper($order->custom_entry) }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('MUCR CLOSED view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">mucr closed</label>
                                                                        <select class="form-control" readonly="">
                                                                            <option value="" selected>{{ strtoupper($order->mucr_closed) }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('FWB / FHL view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">fwb / fhl</label>
                                                                        <select class="form-control" readonly="">
                                                                            <option value="" selected>{{ strtoupper($order->fwb_fhl) }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('DOCS TO PRINT view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">docs to print</label>
                                                                        <select class="form-control" readonly="">
                                                                            <option value="" selected>{{ strtoupper($order->docs_to_print) }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('INVOICE AMOUNT COMMENTS view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">invoice amount comments</label>
                                                                        <input type="text" value="{{ $order->invoice_amount_comment }}" class="form-control text-uppercase" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('INVOICE NUMBER view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">invoice number</label>
                                                                        <input type="text" value="{{ $order->invoice_number }}" class="form-control text-uppercase" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('INVOICE VALUE view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">invoice value</label>
                                                                        <input type="number" step="0.1" class="form-control" id="invoice_value" name="invoice_value" value="{{ $order->invoice_value }}" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="col-12 col-sm-12 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-uppercase">Status</label>
                                                                    <select class="form-control" readonly="">
                                                                        <option value="" selected>{{ strtoupper($order->status) }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-uppercase">lhr creation date</label>
                                                                    <input type="text" class="form-control date" placeholder="dd-mm-yyyy" value="{{ dateFormat($order->creation_date) }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-uppercase">ops claims date</label>
                                                                    <input type="text" class="form-control date" placeholder="dd-mm-yyyy" value="{{ dateFormat($order->claims_date) }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-uppercase">ops processed date</label>
                                                                    <input type="text" class="form-control date" placeholder="dd-mm-yyyy" value="{{ dateFormat($order->processed_date) }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-uppercase">closed date</label>
                                                                    <input type="text" class="form-control date" placeholder="dd-mm-yyyy" value="{{ dateFormat($order->closed_date) }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-uppercase">days</label>
                                                                    <input type="number" value="{{ getDays($order->creation_date, $order->closed_date) }}" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                                                        <div class="row">
                                                            @if($user->can('CLIENT view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">Client</label>
                                                                        <input type="text" value="{{ $order->shipment->client }}" class="form-control text-uppercase" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('DESTINATION view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">Destination</label>
                                                                        <input type="text" value="{{ $order->shipment->destination }}" class="form-control text-uppercase" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('SHIPPER view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">Shipper</label>
                                                                        <input type="text" value="{{ $order->shipment->shipper }}" class="form-control text-uppercase" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('PCS view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">PCS</label>
                                                                        <input type="number" value="{{ $order->shipment->pcs }}" class="form-control" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('GROSS WEIGHT view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">Gross Weight</label>
                                                                        <input type="number" step="0.1" value="{{ $order->shipment->gross_weight }}" class="form-control" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('CW PRE-ALERT view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">CW Pre-Alert</label>
                                                                        <input type="number" step="0.1" value="{{ $order->shipment->cw_pre_alert }}" class="form-control" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('CW PRINT view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">cw print</label>
                                                                        <input type="number" step="0.1" value="{{ $order->shipment->cw_print }}" class="form-control" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('DEP AIRPORT view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">dep airport</label>
                                                                        <input type="text" value="{{ $order->shipment->dep_airport }}" class="form-control text-uppercase" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('AIRLINE view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">airline</label>
                                                                        <input type="text" value="{{ $order->shipment->airline }}" class="form-control text-uppercase" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('AWB Number view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">awb number</label>
                                                                        <input type="text" value="{{ $order->shipment->awb_number }}" class="form-control text-uppercase" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('FLIGHT DATE view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">flight date</label>
                                                                        <input type="text" class="form-control date" placeholder="dd-mm-yyyy" value="{{ dateFormat($order->shipment->flight_date) }}" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('TRANSPORTER view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">transporter</label>
                                                                        <input type="text" value="{{ $order->shipment->transporter }}" class="form-control text-uppercase" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('COLL DATE view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">coll date</label>
                                                                        <input type="text" class="form-control date" placeholder="dd-mm-yyyy" value="{{ dateFormat($order->shipment->coll_date) }}" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('WAREHOUSE view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">warehouse</label>
                                                                        <input type="text" value="{{ $order->shipment->warehouse }}" class="form-control text-uppercase" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('EXPECTED TRANSPORT COST view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">expected transport cost</label>
                                                                        <input type="number" step="0.1" value="{{ $order->shipment->expected_transport_cost }}" class="form-control" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-uppercase">current processing status</label>
                                                                    <input type="text" value="{{ $order->shipment->current_processing_status }}" class="form-control text-uppercase" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="contact3" role="tabpanel" aria-labelledby="contact-tab3">
                                                        <div class="row">
                                                            @if($user->can('FREIGHT CHARGE view'))
                                                            <div class="col-12 col-sm-12 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-uppercase">freight charges</label>
                                                                    <input type="number" step="0.1" class="form-control" id="freight_charges" name="freight_charges" value="{{ $order->account->freight_charges }}" readonly>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            @if($user->can('TRANSP COST view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">transp cost</label>
                                                                        <input type="number" step="0.1" class="form-control" id="transport_cost" name="transport_cost" value="{{ $order->account->transport_cost }}" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('SECURITY CHARGE view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">security charges</label>
                                                                        <input type="number" step="0.1" class="form-control" id="security_charges" name="security_charges" value="{{ $order->account->security_charges }}" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('ENTRY COST view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">entry cost</label>
                                                                        <input type="number" step="0.1" class="form-control" id="entry_cost" name="entry_cost" value="{{ $order->account->entry_cost }}" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('MISC CHARGES view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">misc charges</label>
                                                                        <input type="number" step="0.1" class="form-control" id="misc_charges" name="misc_charges" value="{{ $order->account->misc_charges }}" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('IMPORTS HANDLING COST view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">import handling cost</label>
                                                                        <input type="number" step="0.1" class="form-control" id="import_handling_cost" name="import_handling_cost" value="{{ $order->account->import_handling_cost }}" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('CUSTOMS TAXES view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">customs taxes</label>
                                                                        <input type="number" step="0.1" class="form-control" id="customs_taxes" name="customs" value="{{ $order->account->customs }}" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('OVERSEAS CHARGES view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">overseas charges</label>
                                                                        <input type="number" step="0.1" id="overseas_charges" name="overseas_charges" class="form-control" value="{{ $order->account->overseas_charges }}" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('GROSS PROFIT view'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">gross profit</label>
                                                                        <input type="number" step="0.1" class="form-control" id="gross_profit" name="gross_profit" value="{{ $order->account->gross_profit }}" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <footer class="main-footer">
            @include('layouts.footer')
        </footer>
    </div>
</div>
<!-- General JS Scripts -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<!-- Custom JS File -->
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr(".date", {
        dateFormat: "d-m-Y",
    });
</script>

<script>
    function calculateGrossProfit() {
        var invoiceValue = parseFloat(document.getElementById('invoice_value').value);
        var freightCharges = parseFloat(document.getElementById('freight_charges').value);
        var transportCost = parseFloat(document.getElementById('transport_cost').value);
        var securityCharges = parseFloat(document.getElementById('security_charges').value);
        var entryCost = parseFloat(document.getElementById('entry_cost').value);
        var miscCharges = parseFloat(document.getElementById('misc_charges').value);
        var importHandlingCost = parseFloat(document.getElementById('import_handling_cost').value);
        var customs_taxes = parseFloat(document.getElementById('customs_taxes').value);
        var overseas_charges = parseFloat(document.getElementById('overseas_charges').value);

        var totalCharges = freightCharges + transportCost + securityCharges + entryCost + miscCharges + importHandlingCost + customs_taxes + overseas_charges;

        var grossProfit = invoiceValue - totalCharges;

        document.getElementById('gross_profit').value = grossProfit.toFixed(1);

        if (grossProfit >= 0) {
            document.getElementById('gross_profit').classList.remove('bg-danger');
            document.getElementById('gross_profit').classList.add('bg-success');
            document.getElementById('gross_profit').classList.add('text-white');
        } else if(grossProfit < 0) {
            document.getElementById('gross_profit').classList.remove('bg-success');
            document.getElementById('gross_profit').classList.add('bg-danger');
            document.getElementById('gross_profit').classList.add('text-white');
        }
    }

    var inputFields = document.querySelectorAll('#invoice_value, #freight_charges, #transport_cost, #security_charges, #entry_cost, #misc_charges, #import_handling_cost, #customs_taxes, #overseas_charges');
    inputFields.forEach(function(inputField) {
        inputField.addEventListener('input', calculateGrossProfit);
    });
    calculateGrossProfit();
</script>
</body>
</html>
