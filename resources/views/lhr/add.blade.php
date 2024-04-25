<!DOCTYPE html>
<html lang="en">


<!-- widget-chart.html  21 Nov 2019 03:49:32 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sprint World - Add LHR</title>
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
                                <form method="POST" action="{{ route('order-store') }}" class="needs-validation" novalidate="">
                                    @csrf
                                    <div class="card-header">
                                        <h4>LHR Add</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                @include('layouts.messages')
                                            </div>
                                            <div class="col-12 my-2">
                                                @if($lhr)
                                                    <span><b>Last Sprint Ref: {{ $lhr->sprint_ref }}</b></span>
                                                @else
                                                    <span><b>Last Sprint Ref: LHR6000</b></span>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-12 col-lg-6">
                                                <div class="form-group">
                                                    <label>Sprint Ref</label>
                                                    <input type="text" name="sprint_ref" id="sprint_ref" oninput="convertToUppercase()" class="form-control" placeholder="Enter Sprint Ref" required="">
                                                    <x-input-error :messages="$errors->get('sprint')" class="mt-2" />
                                                    <div class="invalid-feedback">
                                                        Sprint Ref is required
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
<script>
    function convertToUppercase() {
        var inputElement = document.getElementById('sprint_ref'); // Replace 'yourInput' with the actual id of your input element
        inputElement.value = inputElement.value.toUpperCase();
    }
</script>
</body>


<!-- widget-chart.html  21 Nov 2019 03:50:03 GMT -->
</html>
