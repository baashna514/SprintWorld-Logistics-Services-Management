<!DOCTYPE html>
<html lang="en">


<!-- widget-chart.html  21 Nov 2019 03:49:32 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sprint World - Roles</title>
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
                            <div class="my-3 pull-right">
                                <a href="{{ route('role-create') }}" class="btn btn-primary btn-sm">Add New Role</a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Roles List</h4>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        @include('layouts.messages')
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Created On</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($roles as $key=>$role)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ ucwords($role->name) }}</td>
                                                        <td><span class="badge badge-{{$role->status == 'active'?'success':'danger'}}">{{ ucfirst($role->status) }}</span></td>
                                                        <td>{{ $role->created_at->format('d-m-Y') }}</td>
                                                        <td>
                                                            <a href="{{ route('role-edit', ['id' => $role->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
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
</body>


<!-- widget-chart.html  21 Nov 2019 03:50:03 GMT -->
</html>
