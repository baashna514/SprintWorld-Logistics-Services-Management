<!DOCTYPE html>
<html lang="en">


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sprint World - Admin Login</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('assets/img/favicon.ico') }}' />
</head>

<body>
<div class="loader"></div>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="text-center">
                        <img alt="image" src="{{ asset('assets/img/login.png') }}" class="header-logo" style="width: 345px;" />
{{--                        <h1>Sprint World</h1>--}}
{{--                        <h5>Admin System</h5>--}}
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Sign In</h4>
                        </div>
                        <div class="card-body">
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                                @csrf
                                <div class="form-group">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="form-control block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div class="form-group">
                                    <div class="d-block">
                                        <x-input-label for="password" :value="__('Password')" />
                                        <div class="float-right">
                                            <a href="{{ route('forgot-password') }}" class="text-small">
                                                Forgot Password?
                                            </a>
                                        </div>
                                    </div>
                                    <x-text-input id="password" class="form-control block mt-1 w-full"
                                                  type="password"
                                                  name="password"
                                                  required autocomplete="current-password" />

                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                                <div class="form-group">
                                    <x-primary-button class="btn btn-primary btn-lg btn-block ms-3">
                                        {{ __('Sign in') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- General JS Scripts -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<!-- JS Libraies -->
<!-- Page Specific JS File -->
<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<!-- Custom JS File -->
<script src="{{ asset('assets/js/custom.js') }}"></script>
</body>
</html>
