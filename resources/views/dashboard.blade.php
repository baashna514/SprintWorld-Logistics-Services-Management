<!DOCTYPE html>
<html lang="en">


<!-- widget-chart.html  21 Nov 2019 03:49:32 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sprint World - Dashboard</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/flag-icon-css/css/flag-icon.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('assets/img/favicon.ico') }}' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
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
    <style>
        /* Custom styles for the search results */
        #searchResultsContainer {
            position: relative;
            margin-top: -50px;
        }

        #searchInput{
            width: 30%;
            margin-bottom: 20px;
        }

        #searchResults {
            display: none;
            position: absolute;
            top: calc(100% + -10px);
            left: 0;
            width: calc(100% - 2px); /* Adjust based on your preference */
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 999;
        }

        #searchResults ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #searchResults li {
            padding: 8px 10px;
            cursor: pointer;
        }

        #searchResults li:hover {
            background-color: #f0f0f0;
        }






        .searchResultsTable {
            border-collapse: collapse;
            width: 100%;
        }

        .searchResultsTable th,
        .searchResultsTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .searchResultsTable th {
            background-color: #f2f2f2;
        }

        .searchResultsTable tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .searchResultsTable tr:hover {
            background-color: #f2f2f2;
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
                    <div id="searchResultsContainer">
                        <label for="">Search Sprint Ref, Status, AWB No., Transporter, Shipper, Warehouse or '000' for all LHRs</label><br>
                        <input type="text" id="searchInput" name="searchInput">
                        <div id="searchResults"></div>
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::user()->hasRole('OPS'))
                        <div class="row">
                            <div class="col-12 col-sm-12 col-lg-12">
                                <div class="mb-4">
                                    <form method="POST" action="{{ route('chart.search-graph-data') }}">
                                        @csrf
                                        <input type="hidden" value="true" name="search">
                                        <select name="user_id" style="height: 28px;width: 10%;">
                                            <option value="all">All OPS</option>
                                            @foreach($users as $usr)
                                                <option value="{{ $usr->id }}" {{ isset($data_chart_user)&&$data_chart_user->id&&$data_chart_user->id == $usr->id?'selected':'' }}>{{ $usr->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" class="date" placeholder="dd-mm-yyyy" value="{{ $from }}" name="fromDate">
                                        <input type="text" class="date" placeholder="dd-mm-yyyy" value="{{ $to }}" name="toDate">
                                        <button type="submit" class="search-btn">Search</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>LHR</h4>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart2" height="180"></canvas>
                                </div>
                            </div>
                        </div>
                        </div>
                    @elseif(\Illuminate\Support\Facades\Auth::user()->hasRole('MGMT') || \Illuminate\Support\Facades\Auth::user()->hasRole('System Administrator'))
                        <div class="row">
                            <div class="col-12 col-sm-12 col-lg-12">
                                <div class="mb-4">
                                    <form method="POST" action="{{ route('chart.search-graph-data') }}">
                                        @csrf
                                        <input type="hidden" value="true" name="search">
                                        <select name="user_id" style="height: 28px;width: 10%;">
                                            <option value="all">All OPS</option>
                                            @foreach($users as $usr)
                                                <option value="{{ $usr->id }}" {{ isset($data_chart_user)&&$data_chart_user->id == $usr->id?'selected':'' }}>{{ $usr->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" class="date" placeholder="dd-mm-yyyy" value="{{ $from }}" name="fromDate">
                                        <input type="text" class="date" placeholder="dd-mm-yyyy" value="{{ $to }}" name="toDate">
                                        <button type="submit" class="search-btn">Search</button>
                                    </form>
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>LHR</h4>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="MGMT_LHR" height="180"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Gross Profit</h4>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="MGMT_GROSS_PROFIT" height="180"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Total Jobs</h4>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="MGMT_SHIPMENTS" height="180"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Non-Invoiced LHR</h4>
                                </div>
                                <div class="card-body">
                                    <canvas id="MGMT_NON_INVOICED" height="180"></canvas>
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
<!-- JS Libraies -->
<script src="{{ asset('assets/bundles/chartjs/chart.min.js') }}"></script>
{{--<script src="{{ asset('assets/bundles/jquery.sparkline.min.js') }}"></script>--}}
{{--<script src="{{ asset('assets/bundles/apexcharts/apexcharts.min.js') }}"></script>--}}
<script src="{{ asset('assets/bundles/jqvmap/dist/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets/bundles/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('assets/bundles/jqvmap/dist/maps/jquery.vmap.indonesia.js') }}"></script>
<script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
<!-- Page Specific JS File -->
{{--<script src="{{ asset('assets/js/page/widget-chart.js') }}"></script>--}}
<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<!-- Custom JS File -->
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr(".date", {
        dateFormat: "d-m-Y",
    });
    $(document).ready(function() {
        $('#searchInput').keyup(function() {
            // Get the search query from the input field
            var searchQuery = $(this).val();

            // Make an AJAX request to the backend endpoint
            $.ajax({
                url: '{{ route('search-lhr') }}',
                method: 'GET',
                data: { search_query: searchQuery },
                success: function(response) {
                    // Clear previous search results
                    $('#searchResults').empty();

                    // Check if there are search results
                    if (response.length > 0) {
                        // Create table structure
                        var table = $('<table>').addClass('searchResultsTable');
                        var thead = $('<thead>').appendTo(table);
                        var tbody = $('<tbody>').appendTo(table);
                        var tr = $('<tr>').appendTo(thead);

                        // Add table headers
                        $('<th>').text('Sprint Ref').appendTo(tr);
                        $('<th>').text('Awb Number').appendTo(tr);
                        $('<th>').text('Transporter').appendTo(tr);
                        $('<th>').text('Flight Date').appendTo(tr);
                        $('<th>').text('Shipper').appendTo(tr);
                        $('<th>').text('Warehouse').appendTo(tr);
                        $('<th>').text('Status').appendTo(tr);
                        $('<th>').text('Actions').appendTo(tr);

                        // Populate the search results
                        $.each(response, function(index, order) {
                            // Create table row
                            var row = $('<tr>').appendTo(tbody);

                            // Add order data to table cells
                            $('<td>').text(order.sprint_ref).appendTo(row);
                            $('<td>').text(order.shipment.awb_number).appendTo(row);
                            $('<td>').text(order.shipment.transporter).appendTo(row);
                            $('<td>').text(order.shipment.flight_date).appendTo(row);
                            $('<td>').text(order.shipment.shipper).appendTo(row);
                            $('<td>').text(order.shipment.warehouse).appendTo(row);
                            $('<td>').text(order.status).appendTo(row);

                            // Add buttons for view and edit actions
                            var viewButton = $('<button>').text('View').click(function() {
                                var url = '{{ route('order-view', ['id' => ':orderId']) }}';
                                url = url.replace(':orderId', order.id);
                                window.open(url, '_blank');
                            });
                            {{--var editButton = $('<button>').text('Edit').click(function() {--}}
                            {{--    var url = '{{ route('order-edit', ['id' => ':orderId']) }}';--}}
                            {{--    url = url.replace(':orderId', order.id);--}}
                            {{--    window.open(url, '_blank');--}}
                            {{--});--}}
                            // $('<td>').append(viewButton).append(editButton).appendTo(row);
                            $('<td>').append(viewButton).appendTo(row);
                        });

                        // Append table to search results container
                        $('#searchResults').append(table);
                    } else {
                        // If no search results, display a message
                        $('#searchResults').append('<div class="noResults">No results found</div>');
                    }

                    // Show the search results
                    $('#searchResults').show();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        // Hide search results when clicking outside
        $(document).click(function(event) {
            if (!$(event.target).closest('#searchResultsContainer').length) {
                $('#searchResults').hide();
            }
        });

        // Handle click on search result
        $(document).on('click', '#searchResults .searchResultItem', function() {
            // Get the selected value
            var selectedValue = $(this).text();
            $('#searchInput').val(selectedValue);
            $('#searchResults').hide();
        });
    });

</script>
<script>
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
    const search = true;
    const id = "{{ $id }}";
    const from = "{{ $from }}";
    const to = "{{ $to }}";
    const all = "{{ $all }}";


    if('{{ \Illuminate\Support\Facades\Auth::user()->hasRole('OPS') }}'){
        // LHR Chart
        fetch('{{ route("chart.get-ops-data") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken, // Include the CSRF token in the headers
            },
            body: JSON.stringify({
                search: search,
                id: id,
                from: from,
                to: to,
                all: all,
            }),
        })
            .then(response => response.json())
            .then(data => {
                const months = Object.keys(data); // Extract month keys
                const counts = Object.values(data); // Extract order counts

                // Render chart using Chart.js
                var ctx = document.getElementById("myChart2").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months, // Months
                        datasets: [{
                            label: 'Under Process LHR',
                            data: counts, // Order counts for each month
                            backgroundColor: '#e54100', // Single color for all bars
                            borderColor: '#e54100', // Border color
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value, index, values) {
                                        return Number.isInteger(value) ? value : ''; // Display only integer values
                                    }
                                }
                            }]
                        }
                    }
                });
            });
    }

    if('{{ \Illuminate\Support\Facades\Auth::user()->hasRole('MGMT') || \Illuminate\Support\Facades\Auth::user()->hasRole('System Administrator') }}'){
        // LHR Chart
        fetch('{{ route("chart.get-mgmt-data") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken, // Include the CSRF token in the headers
            },
            body: JSON.stringify({
                search: search,
                id: id,
                from: from,
                to: to,
                all: all,
            }),
        })
            .then(response => response.json())
            .then(data => {
                // Extract month names and counts for each status from the data
                const months = Object.keys(data);
                const openCounts = [];
                const underProcessCounts = [];
                const processedCounts = [];

                // Loop through all months from the data and push counts for each status
                for (let yearMonth of months) {
                    openCounts.push(data[yearMonth]['open'] || 0);
                    underProcessCounts.push(data[yearMonth]['under_process'] || 0);
                    processedCounts.push(data[yearMonth]['processed'] || 0);
                }

                // Create a new Chart object
                var ctx = document.getElementById('MGMT_LHR').getContext('2d');
                var orderChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Open',
                            data: openCounts,
                            backgroundColor: '#a72f00', // Color for open status
                            borderColor: '#a72f00', // Border color for open status
                            borderWidth: 1
                        },{
                            label: 'Under Process',
                            data: underProcessCounts,
                            backgroundColor: '#ff4800', // Color for under process status
                            borderColor: '#ff4800', // Border color for under process status
                            borderWidth: 1
                        },{
                            label: 'Processed',
                            data: processedCounts,
                            backgroundColor: '#272a8d', // Color for processed status
                            borderColor: '#272a8d', // Border color for processed status
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value, index, values) {
                                        return Number.isInteger(value) ? value : ''; // Display only integer values
                                    }
                                }
                            }]
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });


        // Gross Profit Chart
        fetch('{{ route("chart.get-mgmt-gross-profit-data") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken, // Include the CSRF token in the headers
            },
            body: JSON.stringify({
                search: search,
                id: id,
                from: from,
                to: to,
                all: all,
            }),
        })
            .then(response => response.json())
            .then(data => {
                const months = Object.keys(data); // Extract month keys
                const grossProfits = Object.values(data); // Extract gross profits for each month

                // Render chart using Chart.js
                var ctx = document.getElementById("MGMT_GROSS_PROFIT").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months, // Months
                        datasets: [{
                            label: 'Gross Profit',
                            data: grossProfits, // Gross profits for each month
                            backgroundColor: '#272a8d', // Single color for all bars
                            borderColor: '#272a8d', // Border color
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value, index, values) {
                                        return Number.isInteger(value) ? value : ''; // Display only integer values
                                    }
                                }
                            }]
                        }
                    }
                });
            });


        // Shipment Charts
        fetch('{{ route("chart.get-mgmt-shipment-data") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken, // Include the CSRF token in the headers
            },
            body: JSON.stringify({
                search: search,
                id: id,
                from: from,
                to: to,
                all: all,
            }),
        })
            .then(response => response.json())
            .then(data => {
                const months = Object.keys(data); // Extract month keys
                const counts = Object.values(data); // Extract order counts

                // Render chart using Chart.js
                var ctx = document.getElementById("MGMT_SHIPMENTS").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months, // Months
                        datasets: [{
                            label: 'Total Jobs',
                            data: counts, // Order counts for each month
                            backgroundColor: '#e54100', // Single color for all bars
                            borderColor: '#e54100', // Border color
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value, index, values) {
                                        return Number.isInteger(value) ? value : ''; // Display only integer values
                                    }
                                }
                            }]
                        }
                    }
                });
            });


        // Non Invoiced LHR Chart
        fetch('{{ route("chart.get-mgmt-non-invoiced-data") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken, // Include the CSRF token in the headers
                },
                body: JSON.stringify({
                    search: search,
                    id: id,
                    from: from,
                    to: to,
                    all: all,
                }),
            })
            .then(response => response.json())
            .then(data => {
                const months = Object.keys(data); // Extract month keys
                const counts = Object.values(data); // Extract order counts

                // Render chart using Chart.js
                var ctx = document.getElementById("MGMT_NON_INVOICED").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months, // Months
                        datasets: [{
                            label: 'Non Invoiced LHR',
                            data: counts, // Order counts for each month
                            backgroundColor: '#a72f00', // Single color for all bars
                            borderColor: '#a72f00', // Border color
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value, index, values) {
                                        return Number.isInteger(value) ? value : ''; // Display only integer values
                                    }
                                }
                            }]
                        }
                    }
                });
            });
    }
</script>

</body>


<!-- widget-chart.html  21 Nov 2019 03:50:03 GMT -->
</html>
