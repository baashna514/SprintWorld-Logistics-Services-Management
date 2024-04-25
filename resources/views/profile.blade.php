<!DOCTYPE html>
<html lang="en">


<!-- widget-chart.html  21 Nov 2019 03:49:32 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sprint World - Profile</title>
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
                    <div class="row mt-sm-4">
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="card author-box">
                                <div class="card-body">
                                    <div class="author-box-center">
                                        <img alt="image" src="assets/img/users/user-1.png" class="rounded-circle author-box-picture">
                                        <div class="clearfix"></div>
                                        <div class="author-box-name">
                                            <a href="#">Sarah Smith</a>
                                        </div>
                                        <div class="author-box-job">System Administrator</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-8">
                            <div class="card">
                                <div class="padding-20">
                                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                                               aria-selected="true">Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                                               aria-selected="false">Change Password</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content tab-bordered" id="myTab3Content">
                                        <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                                            <div class="row">
                                                @include('profile.partials.update-profile-information-form')
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-lg-6">
                                                    <div class="form-group">
                                                        <label>Old Password</label>
                                                        <input type="text" class="form-control" placeholder="Enter old password" required="">
                                                        <div class="invalid-feedback">
                                                            Old password is required
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-lg-6">
                                                    <div class="form-group">
                                                        <label>New Password</label>
                                                        <input type="text" class="form-control" placeholder="Enter new password" required="">
                                                        <div class="invalid-feedback">
                                                            New password is required
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-lg-6">
                                                    <div class="form-group">
                                                        <label>Confirm Password</label>
                                                        <input type="text" class="form-control" placeholder="Enter confirm password" required="">
                                                        <div class="invalid-feedback">
                                                            Confirm password is required
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-lg-6">
                                                </div>
                                                <div class="col-12 col-sm-12 col-lg-6">
                                                    <div class="form-group">
                                                        <button class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<!-- Custom JS File -->
<script src="{{ asset('assets/js/custom.js') }}"></script>
</body>


<!-- widget-chart.html  21 Nov 2019 03:50:03 GMT -->
</html>
