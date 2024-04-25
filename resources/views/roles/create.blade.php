<!DOCTYPE html>
<html lang="en">


<!-- widget-chart.html  21 Nov 2019 03:49:32 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sprint World - Add Role</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
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
                            <div class="card">
                                <form method="POST" action="{{ isset($edit) && $edit && isset($role) && $role ?route('role-update', ['id' => $role->id]):route('role-store') }}" class="needs-validation" novalidate="">
                                    @csrf
                                    <div class="card-header">
                                        <h4>Role Edit</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-uppercase">Name</label>
                                                    <input type="text" name="name" value="{{ isset($edit) && $edit && isset($role) && $role ? $role->name:old('name') }}" class="form-control" required="" {{ isset($edit) && $edit && isset($role) && $role ? 'readonly':'' }}>
                                                    @error('name')
                                                        <div class="text-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                    <div class="invalid-feedback">
                                                        Role name is required
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-uppercase">Status</label>
                                                    <select class="form-control" name="status" required="">
                                                        <option value="active" {{ isset($edit)&&$edit&&isset($role)&&$role->status == 'active' ? 'selected' : '' }}>Active</option>
                                                        <option value="inactive" {{ isset($edit)&&$edit&&isset($role)&&$role->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Status is required
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-lg-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if(isset($edit) && $edit)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header d-block">
                                        <h4 class="float-left">Role Permissions</h4>
                                        <button class="float-right btn btn-primary btn-sm" onclick="toggleCheckboxes()">Mark All as Checked</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4">
                                            @include('layouts.messages')
                                        </div>
                                        <form method="POST" action="{{ route('update-role-permissions', ['id' => $role->id]) }}">
                                            @csrf
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Field</th>
                                                        <th>View</th>
                                                        <th>Update</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($allPermissions as $permission)
                                                            <tr>
                                                                <th>{{ $loop->iteration }}</th>
                                                                <th>{{ $permission }}</th>
                                                                <th><input type="checkbox" name="{{ $permission. ' view' }}" {{ $rolePermissions->contains('name', $permission. ' view') ? 'checked' : '' }}></th>
                                                                <th><input type="checkbox" name="{{ $permission. ' update' }}" {{ $rolePermissions->contains('name', $permission. ' update') ? 'checked' : '' }}></th>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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
<script>
    function toggleCheckboxes() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = !checkbox.checked;
        });
    }
</script>
</body>


<!-- widget-chart.html  21 Nov 2019 03:50:03 GMT -->
</html>
