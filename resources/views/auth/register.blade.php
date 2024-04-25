<!DOCTYPE html>
<html lang="en">


<!-- widget-chart.html  21 Nov 2019 03:49:32 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sprint World - Add User</title>
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
                                <form method="POST" action="{{ route('user-store') }}" class="needs-validation" novalidate="">
                                    @csrf
                                    <div class="card-header">
                                        <h4>User Add</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-uppercase">full name</label>
                                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required="">
                                                    <x-input-error :messages="$errors->get('name')" class="text-danger mt-2" />
                                                    <div class="invalid-feedback">
                                                        Full name is required
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-uppercase">email address</label>
                                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required="">
                                                    <x-input-error :messages="$errors->get('email')" class="text-danger mt-2" />
                                                    <div class="invalid-feedback">
                                                        Email is required
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-uppercase">password</label>
                                                    <input type="password" name="password" value="{{ old('password') }}" class="form-control" required="">
                                                    <x-input-error :messages="$errors->get('password')" class="text-danger mt-2" />
                                                    <div class="invalid-feedback">
                                                        Password is required
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-uppercase">confirm password</label>
                                                    <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control" required="">
                                                    <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger mt-2" />
                                                    <div class="invalid-feedback">
                                                        Password confirmation is required
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-uppercase">role</label>
                                                    <select name="role" value="{{ old('role') }}" class="form-control" required="">
                                                        <option value="">Select Role</option>
                                                        @foreach($roles as $role)
                                                            <option value="{{ $role->name }}">{{ ucwords($role->name) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <x-input-error :messages="$errors->get('role')" class="text-danger mt-2" />
                                                    <div class="invalid-feedback">
                                                        Role is required
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
<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<!-- Custom JS File -->
<script src="{{ asset('assets/js/custom.js') }}"></script>
</body>


<!-- widget-chart.html  21 Nov 2019 03:50:03 GMT -->
</html>
