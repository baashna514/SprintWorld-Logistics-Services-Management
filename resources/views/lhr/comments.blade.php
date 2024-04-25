<!DOCTYPE html>
<html lang="en">


<!-- widget-chart.html  21 Nov 2019 03:49:32 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sprint World - Comments</title>
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
    <style>
        .comments-list {
            max-height: 400px; /* Set maximum height */
            overflow-y: auto; /* Enable vertical scrolling */
        }
        .comment-item {
            margin-bottom: 10px; /* Add space between comments */
        }
        .comment-content {
            margin-bottom: 5px; /* Add space between comment content and date */
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
                        <div class="col-xs-12 col-sm-12 col-12-9 col-lg-12">
                            <div class="card">
                                <div class="chat">
                                    <div class="chat-header">
                                        <h4>LHR Comments</h4>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">Comments</h5>
                                    <div class="comments-list">
                                        <ul class="list-group">
                                            @foreach($comments as $comment)
                                                <li class="list-group-item comment-item">
                                                    <div class="comment-content">
                                                        <strong>{{ $comment->user->name }}:</strong> {{ dateFormat($comment->created_at) }}
                                                    </div>
                                                    <div class="text-muted">{{ $comment->description }}</div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <form method="POST" action="{{ route('order-store-comment', ['id' => $order->id]) }}">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" name="comment" class="form-control" placeholder="Add a comment...">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary">Add Comment</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

{{--                                <div class="chat-box" id="">--}}
{{--                                    <div class="card-body chat-content">--}}
{{--                                        @foreach($comments as $comment)--}}
{{--                                            <div class="chat-item chat-left">--}}
{{--                                                <div class="chat-details">--}}
{{--                                                    <div class="chat-time"><b>Moin Abbas</b> - 01:45</div>--}}
{{--                                                    <div class="chat-text">This is a dummy chat</div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                    <div class="card-footer chat-form">--}}
{{--                                        <form id="chat-form">--}}
{{--                                            <input type="text" class="form-control" placeholder="Type a comment">--}}
{{--                                            <button class="btn btn-primary">--}}
{{--                                                <i class="far fa-paper-plane"></i>--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
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

{{--<script src="{{ asset('assets/js/page/chat.js') }}"></script>--}}
<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<!-- Custom JS File -->
<script src="{{ asset('assets/js/custom.js') }}"></script>
</body>


<!-- widget-chart.html  21 Nov 2019 03:50:03 GMT -->
</html>
