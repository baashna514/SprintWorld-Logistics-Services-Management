<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sprint World - Dashboard</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('assets/img/favicon.ico') }}' />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .search-btn{
            background: #ff4800;
            border: 1px solid #e54100;
            color: #fff;
            height: 27px;
            border-radius: 2px;
        }
        .search-btn:hover{
            background: #e54100;
            border: 1px solid #e54100;
        }
    </style>
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
                            <div class="my-3 pull-left">
                                <a href="{{ route('orders', ['status' => 'open']) }}" class="btn btn-primary btn-sm {{ $status == 'open'?'active':'' }}">Open LHR</a>
                                <a href="{{ route('orders', ['status' => 'under_process']) }}" class="btn btn-primary btn-sm {{ $status == 'under_process'?'active':'' }}">Under Process LHR</a>
                                <a href="{{ route('orders', ['status' => 'processed']) }}" class="btn btn-primary btn-sm {{ $status == 'processed'?'active':'' }}">Processed LHR</a>
                                <a href="{{ route('orders', ['status' => 'closed']) }}" class="btn btn-primary btn-sm {{ $status == 'closed'?'active':'' }}">Closed LHR</a>
                            </div>
                            <div class="my-3 pull-right">
                                @if($login_user->hasRole('MGMT'))
                                    <a href="{{ route('order-create') }}" class="btn btn-primary btn-sm">Add New LHR</a>
                                    <a href="{{ route('export-lhr') }}" class="btn btn-success btn-sm">Download</a>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>LHR List</h4>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <form method="POST" action="{{ route('search-order', ['status' => $status]) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="{{ $status }}">
                                            @if(!($login_user->hasRole("Accountant") || $login_user->hasRole("System Administrator") || ($login_user->hasRole("MGMT") && $status == 'open') || ($login_user->hasRole("OPS") && $status == 'open')))
                                                <select name="user_id" style="height: 28px;width: 10%;">
                                                    <option value="">All OPS</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}" {{ $login_user->hasRole("OPS")&&$login_user->id == $user->id?'selected':'' }}>{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                            <input type="text" class="date" placeholder="dd-mm-yyyy" value="{{ dateFormat($from) }}" name="fromDate">
                                            <input type="text" class="date" placeholder="dd-mm-yyyy" value="{{ dateFormat($to) }}" name="toDate">
                                            <button type="submit" class="search-btn">Search</button>
                                        </form>
                                    </div>
                                    <div class="mb-4">
                                        @include('layouts.messages')
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Sprint Ref</th>
                                                    <th>AWB No.</th>
                                                    <th>Shipper</th>
                                                    <th>Transporter</th>
                                                    <th>Flight Date</th>
                                                    <th>Warehouse</th>
                                                    <th>Client</th>
                                                    <th>OPS Handler</th>
                                                    <th>MGMT Handler</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($orders))
                                                    @foreach($orders as $key=>$order)
                                                        <tr>
                                                            <td>{{ $key+1 }}</td>
                                                            <td>{{ strtoupper($order->sprint_ref) }}</td>
                                                            <td>{{ strtoupper($order->shipment->awb_number) }}</td>
                                                            <td>{{ strtoupper($order->shipment->shipper) }}</td>
                                                            <td>{{ strtoupper($order->shipment->transporter) }}</td>
                                                            <td>{{ dateFormat($order->shipment->flight_date) }}</td>
                                                            <td>{{ strtoupper($order->shipment->warehouse) }}</td>
                                                            <td>{{ strtoupper($order->shipment->client) }}</td>
                                                            <td>{{ strtoupper($order->ops_user) }}</td>
                                                            <td>{{ strtoupper($order->name) }}</td>
                                                            <td>
                                                                <a href="{{ route('order-view', ['id' => $order->id]) }}" class="btn btn-primary btn-sm" title="Show LHR"><i class="fa fa-eye"></i></a>
                                                                <?php
                                                                    $can_edit = false;
                                                                    if($status == 'open') {
                                                                        if ($order->user->id == $login_user->id || $login_user->hasRole('System Administrator') || $login_user->hasRole('Accountant')){
                                                                            $can_edit = true;
                                                                        }
                                                                    }elseif ($status == 'under_process'){
                                                                        if ($order->claims_by == $login_user->id || $login_user->hasRole('MGMT') || $login_user->hasRole('System Administrator') || $login_user->hasRole('Accountant')){
                                                                            $can_edit = true;
                                                                        }
                                                                    }elseif ($status == 'processed'){
                                                                        if ($order->processed_by == $login_user->id || $login_user->hasRole('MGMT') || $login_user->hasRole('System Administrator') || $login_user->hasRole('Accountant')){
                                                                            $can_edit = true;
                                                                        }
                                                                    }elseif ($status == 'closed'){
                                                                        if ($login_user->hasRole('OPS') || $login_user->hasRole('MGMT') || $login_user->hasRole('System Administrator') || $login_user->hasRole('Accountant')){
                                                                            $can_edit = true;
                                                                        }
                                                                    }
                                                                ?>
                                                                @if($can_edit)
                                                                    <a href="{{ route('order-edit', ['id' => $order->id]) }}" class="btn btn-primary btn-sm" title="Edit LHR"><i class="fa fa-edit"></i></a>
                                                                @endif
                                                                @if(($login_user->hasRole('MGMT') || $login_user->hasRole('OPS')) && $order->status != 'closed')
                                                                    <a href="{{ route('order-close', ['id' => $order->id]) }}" onclick="return generateConfirmation('Closed', '{{ $order->pre_alert_sent }}', '{{ $order->pre_alert_docs }}', '{{ $order->custom_entry }}', '{{ $order->mucr_closed }}', '{{ $order->fwb_fhl }}', '{{ $order->docs_to_print }}');" class="btn btn-success btn-sm" title="Mark as Closed LHR">Close</a>
                                                                @endif
                                                                @if($login_user->hasRole('OPS') && $order->status == 'open')
                                                                    <a href="{{ route('order-claim', ['id' => $order->id]) }}" class="btn btn-success btn-sm" title="Claim LHR">Claim</a>
                                                                @endif
                                                                @if($login_user->hasRole('OPS') && $order->status == 'under_process' && $order->claims_by == \Illuminate\Support\Facades\Auth::id())
                                                                    <a href="{{ route('order-processed', ['id' => $order->id]) }}" onclick="return generateConfirmation('Processed', '{{ $order->pre_alert_sent }}', '{{ $order->pre_alert_docs }}', '{{ $order->custom_entry }}', '{{ $order->mucr_closed }}', '{{ $order->fwb_fhl }}', '{{ $order->docs_to_print }}');" class="btn btn-success btn-sm" title="Mark as Processed LHR">Processed</a>
                                                                @endif
                                                                <a href="{{ route('order-comments', ['id' => $order->id]) }}" class="btn btn-secondary btn-sm" title="Add Comments on LHR">Comments</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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

<script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('assets/js/page/datatables.js') }}"></script>
<script src="{{ asset('assets/js/page/widget-chart.js') }}"></script>
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
    function generateConfirmation(action, preAlertSent, preAlertDocs, customEntry, mucrClosed, fwbFhl, docsToPrint) {
        var pendingAttributes = [];

        if (preAlertSent === "pending") {
            pendingAttributes.push("PRE-ALERT SENT");
        }
        if (preAlertDocs === "pending") {
            pendingAttributes.push("PRE-ALERT DOCS APPROVED?");
        }
        if (customEntry === "pending") {
            pendingAttributes.push("CUSTOM ENTRY");
        }
        if (mucrClosed === "pending") {
            pendingAttributes.push("MUCR CLOSED");
        }
        if (fwbFhl === "pending") {
            pendingAttributes.push("FWB / FHL");
        }
        if (docsToPrint === "pending") {
            pendingAttributes.push("DOCS TO PRINT");
        }

        var confirmationMessage = "Are you sure you want to mark this job " + action + "?\n";

        if (pendingAttributes.length > 0) {
            confirmationMessage += "The following attribute(s) are still pending:\n";
            confirmationMessage += pendingAttributes.join("\n");
        }
        return confirm(confirmationMessage);
    }
</script>
</body>


<!-- widget-chart.html  21 Nov 2019 03:50:03 GMT -->
</html>
