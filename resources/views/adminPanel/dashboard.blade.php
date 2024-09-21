@extends('adminPanel/master')
@section('content')

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="d-flex">
                        <div class="input-group">
                            <input type="number" value="{{ date('Y') }}" id="reporting-year" placeholder="YYYY" class="form-control">
                            <span class="input-group-text bg-primary border-primary text-white">
                                <i class="mdi mdi-calendar-range font-13"></i>
                            </span>
                        </div>
                        <button type="button" class="ml-2 btn btn-sm btn-success" onclick="loadDashboardData()"><i class="mdi mdi-autorenew"></i></button>

                    </form>
                </div>
                <h4 class="page-title">G Bricks Analytics</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    @php
                                    $user = Auth::user();
                                    
                                @endphp
@if($user->roles->first()->name == 'Admin')
    <div class="row">
        <div class="col-xl-12 col-lg-12">

            <div class="row">
                <div class="col-sm-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-truck-minus widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Orders</h5>
                            <p class="card-text-top placeholder-glow">
                                <span class="placeholder col-7"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-7"></span>
                            </p>
                            <h3 class="mt-3 mb-3"></h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i></span>
                                <span class="text-nowrap" id="orders-sale" style="font-size: 1.2rem;font-weight:bolder"></span><br>
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i></span>
                                <span class="text-nowrap" id="orders-count" style="font-size: 1rem;font-weight:bolder"></span><br>

                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-sm-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-currency-rupee widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Payments & Receiving</h5>
                            <p class="card-text-top placeholder-glow">
                                <span class="placeholder col-7"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-7"></span>
                            </p>
                            <h3 class="mt-3 mb-3"></h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i></span>
                                <span class="text-nowrap" id="todayPayments" style="font-size: 1.2rem;font-weight:bolder"></span>
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i></span>
                                <span class="text-nowrap" id="todayReceivedPayments" style="font-size: 1.2rem;font-weight:bolder"></span>

                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
                <div class="col-sm-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-currency-rupee widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Profit</h5>
                            <p class="card-text-top placeholder-glow">
                                <span class="placeholder col-7"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-7"></span>
                            </p>
                            <h3 class="mt-3 mb-3"></h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-down-bold"></i></span>
                                <span class="text-nowrap" id="todayOrderProfit" style="font-size: 1.2rem;font-weight:bolder"></span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-sm-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-currency-rupee widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Expanse</h5>
                            <p class="card-text-top placeholder-glow">
                                <span class="placeholder col-7"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-7"></span>
                            </p>
                            <h3 class="mt-3 mb-3"></h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i></span>
                                <span class="text-nowrap" id="todayExpense" style="font-size: 1.2rem;font-weight:bolder"></span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row -->

            <div class="row">
                <div class="col-sm-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-toy-brick widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Average Revenue">Marka</h5>
                            <p class="card-text-top placeholder-glow">
                                <span class="placeholder col-7"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-7"></span>
                            </p>
                            <h3 class="mt-3 mb-3"></h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i></span>
                                <span class="text-nowrap year-heading" id="markaReceivable" style="font-size: 1.2rem;font-weight:bolder"></span><br>
                                <span class="text-danger me-2"><i class="mdi mdi-arrow-up-bold"></i></span>
                                <span class="text-nowrap year-heading" id="markaPayable" style="font-size: 1.2rem;font-weight:bolder"></span>

                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-sm-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-car-clock widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Growth">Driver</h5>
                            <p class="card-text-top placeholder-glow">
                                <span class="placeholder col-7"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-7"></span>
                            </p>
                            <h3 class="mt-3 mb-3"></h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i></span>
                                <span class="text-nowrap year-heading" id="driverReceivable" style="font-size: 1.2rem;font-weight:bolder"></span><br>
                                <span class="text-danger me-2"><i class="mdi mdi-arrow-up-bold"></i></span>
                                <span class="text-nowrap year-heading" id="driverPayable" style="font-size: 1.2rem;font-weight:bolder"></span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
                <div class="col-sm-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-currency-usd widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Average Revenue">Revenue</h5>
                            <p class="card-text-top placeholder-glow">
                                <span class="placeholder col-7"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-7"></span>
                            </p>
                            <h3 class="mt-3 mb-3"></h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i></span>

                                <span class="text-nowrap year-heading" id="revenue-heading" style="font-size: 1.2rem;font-weight:bolder"></span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-sm-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-pulse widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Growth">Accounts Receivable & payable</h5>
                            <p class="card-text-top placeholder-glow">
                                <span class="placeholder col-7"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-7"></span>
                            </p>
                            <h3 class="mt-3 mb-3"></h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i></span>
                                <span class="text-nowrap year-heading" id="accountReceivable" style="font-size: 1.2rem;font-weight:bolder"></span><br>
                                <span class="text-danger me-2"><i class="mdi mdi-arrow-up-bold"></i></span>
                                <span class="text-nowrap year-heading" id="accountPayable" style="font-size: 1.2rem;font-weight:bolder"></span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row -->

        </div> <!-- end col -->


    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-6">
            <div class="card card-h-20">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title">Category Wise Expense</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>
                    </div>

                    <div dir="ltr">
                        <div id="expense-column" class="apex-charts mt-3" data-colors="#727cf5,#0acf97"></div>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->

        </div> <!-- end col -->
        <div class="col-xl-6 col-lg-6">
            <div class="card card-h-20">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title">Months wise Expanse</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>
                    </div>

                    <div dir="ltr">
                        <div id="basic-column" class="apex-charts mt-3" data-colors="#727cf5,#0acf97"></div>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->

        </div> <!-- end col -->
        <div class="col-xl-6 col-lg-6">
            <div class="card card-h-20">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title">Months Wise Orders</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>
                    </div>

                    <div dir="ltr">
                        <div id="month-wise-order" class="apex-charts mt-3" data-colors="#727cf5,#0acf97"></div>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->

        </div> <!-- end col -->
        <div class="col-xl-6 col-lg-6">
            <div class="card card-h-20">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title">Months Wise Profits</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>
                    </div>

                    <div dir="ltr">
                        <div id="month-wise-profit" class="apex-charts mt-3" data-colors="#727cf5,#0acf97"></div>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->

        </div> <!-- end col -->
    </div>
    @endif
    <!-- end row -->



    <!-- end row -->

</div>
@endsection

@section('scripts')
<script>
    function loadDashboardData() {
        console.log('function is call');
        $('.card-text-top').css('display', 'block');
        $('#orders-sale').html('PKR ');
        $('#orders-count').html('Orders ');
        $('#todayPayments').html('PKR ');
        $('#todayReceivedPayments').html('PKR ');
        $('#todayOrderProfit').html('PKR ');
        $('#todayExpense').html('PKR ');
        $('#markaReceivable').html('PKR ');
        $('#markaPayable').html('PKR ');
        $('#driverReceivable').html('PKR ');
        $('#driverPayable').html('PKR ');
        $('#revenue-heading').html('PKR ');
        $('#accountReceivable').html('PKR ');
        $('#accountPayable').html('PKR ');
        $('#peroid-items').html('');

        var year = $('#reporting-year').val();

        getDashboardCards(year);
    }
    loadDashboardData();

    function getDashboardCards(year) {
        $.ajax({
            url: "{{ URL::to('get-dashboard-card') }}",
            type: 'POST',
            data: {
                _token: '{{ CSRF_token() }}',
                year: year
            },
            success: function(data) {
                var data = data['data'];
                $('#orders-sale').html('PKR ' + data['todaySaleAmount']);
                $('#orders-count').html('Orders ' + data['todayOrdersCount']);
                $('#todayPayments').html('PKR ' + data['todayPayments']);
                $('#todayReceivedPayments').html('PKR ' + data['todayReceivedPayments']);
                $('#todayOrderProfit').html('PKR ' + data['todayOrderProfit']);
                $('#todayExpense').html('PKR ' + data['todayExpense']);
                $('#markaReceivable').html('PKR ' + data['markaReceivable']);
                $('#markaPayable').html('PKR ' + data['markaPayable']);
                $('#driverReceivable').html('PKR ' + data['driverReceivable']);
                $('#driverPayable').html('PKR ' + data['driverPayable']);
                $('#revenue-heading').html('PKR ' + data['todayRevenue']);
                $('#accountReceivable').html('PKR ' + data['accountReceivable']);
                $('#accountPayable').html('PKR ' + data['accountPayable']);

                $('.card-text-top').css('display', 'none');

                expenseChart(data['expenseGraph'][0], data['expenseGraph'][1]);
                peroidsChart(data['expenseMonthyGraph'][0], data['expenseMonthyGraph'][1]);
                monthWiseOrderChartChart(data['monthWiseOrders'][0], data['monthWiseOrders'][1]);
                monthWiseProfitChartChart(data['monthWiseProfit'][0], data['monthWiseProfit'][1]);
            }
        });
    }




    function peroidsChart(categories, values) {
        $('#basic-column').html("");

        dataColors = $("#basic-column").data("colors");
        dataColors && (colors = dataColors.split(","));
        var options = {
                chart: {
                    height: 396,
                    type: "bar",
                    toolbar: {
                        show: !1
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        endingShape: "rounded",
                        columnWidth: "55%"
                    }
                },
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    show: !0,
                    width: 2,
                    colors: ["transparent"]
                },
                colors: ["#39afd1"],
                series: [{
                    name: 'Values',
                    data: values
                }],
                xaxis: {
                    categories: categories
                },
                legend: {
                    offsetY: 7
                },
                yaxis: {
                    title: {
                        text: ""
                    }
                },
                fill: {
                    opacity: 1
                },
                grid: {
                    row: {
                        colors: ["transparent", "transparent"],
                        opacity: .2
                    },
                    borderColor: "#f1f3fa",
                    padding: {
                        bottom: 5
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(o) {
                            return "" + o + ""
                        }
                    }
                }
            },
            chart = new ApexCharts(document.querySelector("#basic-column"), options);
        chart.render();
        // colors = ["#fa5c7c"];
    }


    function monthWiseOrderChartChart(categories, values) {
        $('#month-wise-order').html("");

        dataColors = $("#month-wise-order").data("colors");
        dataColors && (colors = dataColors.split(","));
        var options = {
                chart: {
                    height: 396,
                    type: "bar",
                    toolbar: {
                        show: !1
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        endingShape: "rounded",
                        columnWidth: "55%"
                    }
                },
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    show: !0,
                    width: 2,
                    colors: ["transparent"]
                },
                colors: ["#39afd1"],
                series: [{
                    name: 'Values',
                    data: values
                }],
                xaxis: {
                    categories: categories
                },
                legend: {
                    offsetY: 7
                },
                yaxis: {
                    title: {
                        text: ""
                    }
                },
                fill: {
                    opacity: 1
                },
                grid: {
                    row: {
                        colors: ["transparent", "transparent"],
                        opacity: .2
                    },
                    borderColor: "#f1f3fa",
                    padding: {
                        bottom: 5
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(o) {
                            return "" + o + ""
                        }
                    }
                }
            },
            chart = new ApexCharts(document.querySelector("#month-wise-order"), options);
        chart.render();
        // colors = ["#fa5c7c"];
    }

    function monthWiseProfitChartChart(categories, values) {
        $('#month-wise-profit').html("");

        dataColors = $("#month-wise-profit").data("colors");
        dataColors && (colors = dataColors.split(","));
        var options = {
                chart: {
                    height: 396,
                    type: "bar",
                    toolbar: {
                        show: !1
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        endingShape: "rounded",
                        columnWidth: "55%"
                    }
                },
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    show: !0,
                    width: 2,
                    colors: ["transparent"]
                },
                colors: ["#0acf97"],
                series: [{
                    name: 'Values',
                    data: values
                }],
                xaxis: {
                    categories: categories
                },
                legend: {
                    offsetY: 7
                },
                yaxis: {
                    title: {
                        text: ""
                    }
                },
                fill: {
                    opacity: 1
                },
                grid: {
                    row: {
                        colors: ["transparent", "transparent"],
                        opacity: .2
                    },
                    borderColor: "#f1f3fa",
                    padding: {
                        bottom: 5
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(o) {
                            return "" + o + ""
                        }
                    }
                }
            },
            chart = new ApexCharts(document.querySelector("#month-wise-profit"), options);
        chart.render();
        // colors = ["#fa5c7c"];
    }



    function expenseChart(categories, value) {
        $('#expense-column').html("");

        dataColors = $("#expense-column").data("colors");
        dataColors && (colors = dataColors.split(","));
        var options = {
                chart: {
                    height: 396,
                    type: "bar",
                    toolbar: {
                        show: !1
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        endingShape: "rounded",
                        columnWidth: "55%"
                    }
                },
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    show: !0,
                    width: 2,
                    colors: ["transparent"]
                },
                colors: ["#fa5c7c", "#0acf97", "#39afd1"],
                series: value,
                xaxis: {
                    categories: categories
                },
                legend: {
                    offsetY: 7
                },
                yaxis: {
                    title: {
                        text: ""
                    }
                },
                fill: {
                    opacity: 1
                },
                grid: {
                    row: {
                        colors: ["transparent", "transparent"],
                        opacity: .2
                    },
                    borderColor: "#f1f3fa",
                    padding: {
                        bottom: 5
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(o) {
                            return "" + o + ""
                        }
                    }
                }
            },
            chart = new ApexCharts(document.querySelector("#expense-column"), options);
        chart.render();
        // colors = ["#fa5c7c"];
    }

    function expenseMonthWiseChart(months, values) {
        $('#expense-column').html("");
        console.log(values);
        dataColors = $("#expense-month-wise").data("colors");
        dataColors && (colors = dataColors.split(","));
        var options = {
                chart: {
                    height: 396,
                    type: "bar",
                    toolbar: {
                        show: !1
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        endingShape: "rounded",
                        columnWidth: "55%"
                    }
                },
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    show: !0,
                    width: 2,
                    colors: ["transparent"]
                },
                colors: ["#fa5c7c", "#0acf97", "#39afd1"],
                series: values,
                xaxis: {
                    months: months
                },
                legend: {
                    offsetY: 7
                },
                yaxis: {
                    title: {
                        text: ""
                    }
                },
                fill: {
                    opacity: 1
                },
                grid: {
                    row: {
                        colors: ["transparent", "transparent"],
                        opacity: .2
                    },
                    borderColor: "#f1f3fa",
                    padding: {
                        bottom: 5
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(o) {
                            return "" + o + ""
                        }
                    }
                }
            },
            chart = new ApexCharts(document.querySelector("#expense-month-wise"), options);
        chart.render();
        // colors = ["#fa5c7c"];
    }
</script>

@endsection
<!-- container -->