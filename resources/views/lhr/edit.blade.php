<!DOCTYPE html>
<html lang="en">


<!-- widget-chart.html  21 Nov 2019 03:49:32 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sprint World - LHR Edit</title>
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
                                <form class="needs-validation" novalidate="" method="POST" action="{{ route('order-update', ['id' => $order->id]) }}">
                                    @csrf
                                    <div class="card-header">
                                        <h4 class="pull-left">LHR Edit</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 py-2">
                                                <h5>SPRINT REF: {{ $order->sprint_ref }}</h5>
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
                                                            @if($user->can('SPRINT REF update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">Sprint Ref</label>
                                                                        <input type="text" class="form-control" name="sprint_ref" value="{{ $order->sprint_ref }}" readonly>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('DEPARTURE STATUS update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">Departure Status</label>
                                                                        <select class="form-control" name="departure_status">
                                                                            <option value="not departed" {{ $order->departure_status == 'not departed'? 'selected': '' }}>NOT DEPARTED</option>
                                                                            <option value="departed" {{ $order->departure_status == 'departed'? 'selected': '' }}>DEPARTED</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('ORIGINAL DOCUMENTS STATUS update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">original document status</label>
                                                                        <input type="text" class="form-control text-uppercase" name="document_status" value="{{ $order->document_status }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('PRE-ALERT update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">pre-alert sent</label>
                                                                        <select class="form-control" name="pre_alert_sent">
                                                                            <option value="pending" {{ $order->pre_alert_sent == 'pending'? 'selected': '' }}>PENDING</option>
                                                                            <option value="yes" {{ $order->pre_alert_sent == 'yes'? 'selected': '' }}>YES</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('PRE-ALERT DOCS APPROVED? update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">pre-alert docs approved?</label>
                                                                        <select class="form-control" name="pre_alert_docs">
                                                                            <option value="pending" {{ $order->pre_alert_docs == 'pending'? 'selected': '' }}>PENDING</option>
                                                                            <option value="yes" {{ $order->pre_alert_docs == 'yes'? 'selected': '' }}>YES</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('CUSTOMS ENTRY update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">custom entry</label>
                                                                        <select class="form-control" name="custom_entry">
                                                                            <option value="pending" {{ $order->custom_entry == 'pending'? 'selected': '' }}>PENDING</option>
                                                                            <option value="yes" {{ $order->custom_entry == 'yes'? 'selected': '' }}>YES</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('MUCR CLOSED update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">mucr closed</label>
                                                                        <select class="form-control" name="mucr_closed">
                                                                            <option value="pending" {{ $order->mucr_closed == 'pending'? 'selected': '' }}>PENDING</option>
                                                                            <option value="yes" {{ $order->mucr_closed == 'yes'? 'selected': '' }}>YES</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('FWB / FHL update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">fwb / fhl</label>
                                                                        <select class="form-control" name="fwb_fhl">
                                                                            <option value="pending" {{ $order->fwb_fhl == 'pending'? 'selected': '' }}>PENDING</option>
                                                                            <option value="yes" {{ $order->fwb_fhl == 'yes'? 'selected': '' }}>YES</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('DOCS TO PRINT update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">docs to print</label>
                                                                        <select class="form-control" name="docs_to_print">
                                                                            <option value="pending" {{ $order->docs_to_print == 'pending'? 'selected': '' }}>PENDING</option>
                                                                            <option value="yes" {{ $order->docs_to_print == 'yes'? 'selected': '' }}>YES</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('INVOICE AMOUNT COMMENTS update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">invoice amount comments</label>
                                                                        <input type="text" class="form-control text-uppercase" name="invoice_amount_comment" value="{{ $order->invoice_amount_comment }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('INVOICE NUMBER update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">invoice number</label>
                                                                        <input type="text" class="form-control text-uppercase" name="invoice_number" value="{{ $order->invoice_number }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('INVOICE VALUE update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">invoice value</label>
                                                                        <input type="number" step="0.1" class="form-control" id="invoice_value" name="invoice_value" value="{{ $order->invoice_value }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                                                        <div class="row">
                                                            @if($user->can('CLIENT update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">Client</label>
                                                                        <input type="text" class="form-control text-uppercase" name="client" value="{{ $order->shipment->client }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('DESTINATION update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">Destination</label>
                                                                        <input type="text" class="form-control text-uppercase" name="destination" value="{{ $order->shipment->destination }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('SHIPPER update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">Shipper</label>
                                                                        <input type="text" class="form-control text-uppercase" name="shipper" value="{{ $order->shipment->shipper }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('PCS update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">PCS</label>
                                                                        <input type="number" class="form-control" name="pcs" value="{{ $order->shipment->pcs }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('GROSS WEIGHT update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">Gross Weight</label>
                                                                        <input type="number" step="0.1" class="form-control" name="gross_weight" value="{{ $order->shipment->gross_weight }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('CW PRE-ALERT update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">CW Pre-Alert</label>
                                                                        <input type="number" step="0.1" class="form-control" name="cw_pre_alert" value="{{ $order->shipment->cw_pre_alert }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('CW PRINT update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">cw print</label>
                                                                        <input type="number" step="0.1" class="form-control" name="cw_print" value="{{ $order->shipment->cw_print }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('DEP AIRPORT update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">dep airport</label>
                                                                        <input type="text" class="form-control text-uppercase" name="dep_airport" value="{{ $order->shipment->dep_airport }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('AIRLINE update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">airline</label>
                                                                        <input type="text" class="form-control text-uppercase" name="airline" value="{{ $order->shipment->airline }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('AWB Number update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">awb number</label>
                                                                        <input type="text" class="form-control text-uppercase" name="awb_number" value="{{ $order->shipment->awb_number }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('FLIGHT DATE update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">flight date</label>
                                                                        <input type="text" class="form-control date" placeholder="dd-mm-yyyy" name="flight_date" value="{{ dateFormat($order->shipment->flight_date) }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('TRANSPORTER update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">transporter</label>
                                                                        <input type="text" class="form-control text-uppercase" name="transporter" value="{{ $order->shipment->transporter }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('COLL DATE update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">coll date</label>
                                                                        <input type="text" class="form-control date" placeholder="dd-mm-yyyy" name="coll_date" value="{{ dateFormat($order->shipment->coll_date) }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('WAREHOUSE update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">warehouse</label>
                                                                        <input type="text" class="form-control text-uppercase" name="warehouse" value="{{ $order->shipment->warehouse }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('EXPECTED TRANSPORT COST update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">expected transport cost</label>
                                                                        <input type="number" step="0.01" class="form-control" name="expected_transport_cost" value="{{ $order->shipment->expected_transport_cost }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="text-uppercase">current processing status</label>
                                                                    <input type="text" class="form-control text-uppercase" name="current_processing_status" value="{{ $order->shipment->current_processing_status }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="contact3" role="tabpanel" aria-labelledby="contact-tab3">
                                                        <div class="row">
                                                            @if($user->can('FREIGHT CHARGE update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">freight charges</label>
                                                                        <input type="number" step="0.01" class="form-control" id="freight_charges" name="freight_charges" value="{{ $order->account->freight_charges }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('TRANSP COST update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">transp cost</label>
                                                                        <input type="number" step="0.01" class="form-control" id="transport_cost" name="transport_cost" value="{{ $order->account->transport_cost }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('SECURITY CHARGE update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">security charges</label>
                                                                        <input type="number" step="0.01" class="form-control" id="security_charges" name="security_charges" value="{{ $order->account->security_charges }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('ENTRY COST update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">entry cost</label>
                                                                        <input type="number" step="0.01" class="form-control" id="entry_cost" name="entry_cost" value="{{ $order->account->entry_cost }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('MISC CHARGES update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">misc charges</label>
                                                                        <input type="number" step="0.01" class="form-control" id="misc_charges" name="misc_charges" value="{{ $order->account->misc_charges }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('IMPORTS HANDLING COST update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">import handling cost</label>
                                                                        <input type="number" step="0.01" class="form-control" id="import_handling_cost" name="import_handling_cost" value="{{ $order->account->import_handling_cost }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('CUSTOMS TAXES update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">customs taxes</label>
                                                                        <input type="number" step="0.01" class="form-control" id="customs_taxes" name="customs" value="{{ $order->account->customs }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('OVERSEAS CHARGES update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">overseas charges</label>
                                                                        <input type="number" step="0.01" class="form-control" id="overseas_charges" name="overseas_charges" value="{{ $order->account->overseas_charges }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($user->can('GROSS PROFIT update'))
                                                                <div class="col-12 col-sm-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="text-uppercase">gross profit</label>
                                                                        <input type="number" step="0.01" class="form-control" id="gross_profit" name="gross_profit" value="{{ $order->account->gross_profit }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-left">
                                        <button class="btn btn-primary">Submit</button>
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
<script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
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
