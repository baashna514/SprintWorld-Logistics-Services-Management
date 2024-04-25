<!DOCTYPE html>
<html lang="en">


<!-- widget-chart.html  21 Nov 2019 03:49:32 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sprint World - Users</title>
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
                                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Add New User</a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Users List</h4>
                                </div>
                                <div class="card-body">
                                    <div class="col-12 mb-4">
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        @include('layouts.messages')
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Created On</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $key=>$user)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->roles->first()->name }}</td>
                                                        <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                                        <td>
                                                            @if($user->status == true)
                                                                <span class="badge badge-success">Active</span>
                                                            @else
                                                                <span class="badge badge-danger">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a type="button" class="btn btn-sm btn-primary" href="{{route('user-change-status', ["id"=>$user->id])}}" style="margin-right: 5px;">
                                                                @if($user->status == true)
                                                                    <i class="fa fa-toggle-off"></i> Inactive
                                                                @else
                                                                    <i class="fa fa-toggle-on"></i> Active
                                                                @endif
                                                            </a>
                                                            <a href="#" type="button" data-id="{{ $user->id }}" class="btn-user-edit btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
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


        <div class="modal fade" id="userEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
        </div>
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

<script>
    $(document).ready(function() {
        $('.btn-user-edit').on('click', function () {
            var user_id = $(this).data('id');
            var baseUrl = window.location.protocol + '//' + window.location.host;
            var route = baseUrl+'/getUserDetails/'+user_id;
            console.log(baseUrl);
            var route = "{{ route('getUserDetails', ['id' => ':user_id']) }}";
            route = route.replace(':user_id', user_id);
            $.ajax({
                url: route,
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    $('#userEditModal').modal('show');
                    $('.modal-body').html(data);
                },
                error: function (error) {
                    console.error('Error fetching user details:', error);
                }
            });
        });
    });
</script>
</body>


<!-- widget-chart.html  21 Nov 2019 03:50:03 GMT -->
</html>
