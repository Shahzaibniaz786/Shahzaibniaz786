@extends('adminPanel/print_master')
@section('content')
<h3 style="margin-top:40px;">
    Summary Day Wise
</h3>

</section>
<div class="row pl-5 pr-5">
    <div class="col-md-9">
        <h5>Report </h5>
    </div>
    <div class="col-md-3">
        <h5>Details</h5>
    </div>
    <div class="col-md-9">
        <h6>User: {{ \Auth::user()->name }}</h6>
    </div>
    <div class="col-md-3">
        <h6>Summary Date: {{ $date }}</h6>
    </div>
    <div class="col-md-9">
        <h6>Reporting Date: {{ date('d-m-Y') }}</h6>
    </div>
    <div class="col-md-3">
        <h6>Reporting Time: {{ date('h:i:sa') }}</h6>
    </div>

</div>

<section style="margin: 20px;">
    <h4 class="m-4" style="text-align: center;" id="">Orders List</h4>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-sm table-hover table-bordered" style="border: 2px solid black;">
                <thead style="color: black; border: 1px solid black;">
                    <tr style="background-color: lightgray; color: black;">
                        <th style="border:1px solid black;">Sr</th>
                        <th style="border:1px solid black;">Date</th>
                        <th style="border:1px solid black;">Product Type</th>
                        <th style="border:1px solid black;">Purchase</th>
                        <th style="border:1px solid black;">Carriage</th>
                        <th style="border:1px solid black;">Sale</th>
                        <th style="border:1px solid black;">Profit</th>
                    </tr>

                </thead>
                <tbody style="border: 2px solid black;">

                    @php
                    $totalPurchase = 0;
                    $totalCarraige = 0;
                    $totalSale = 0;
                    $totalProfit = 0;
                    $productTypes = [];
                    @endphp
                    @isset($orders)

                    @foreach($orders as $order)
                    <?php
                    $totalPurchase += $order->total_purchase;
                    $totalCarraige += $order->total_carriage;
                    $totalSale += $order->total_sale_amount;
                    $totalProfit += $order->profit;

                    $productType = $order->product->name ?? '';
                    if ($productType != '') {
                        if (isset($productTypes[$productType]))
                            $productTypes[$productType] = $productTypes[$productType] + $order->purchase_qty;
                        else
                            $productTypes[$productType] = $order->purchase_qty;
                    }

                    ?>

                    <tr>
                        <td style="border:1px solid black;">{{ $loop->iteration }}</td>
                        <td style="border:1px solid black;">{{ date('d-m-Y',strtotime($order->date)) }}</td>
                        <td style="border:1px solid black;">{{ $order->product->name ?? '' }}</td>
                        <td style="border:1px solid black;">
                            <h6>Maraka: {{ $order->maraka->name }}</h6>
                            <h6>Qty: {{ number_format($order->purchase_qty) }}</h6>
                            <h6>Purchase Rate: {{ number_format($order->purchase_rate) }}</h6>
                            <h6>Total Purchase: {{ number_format($order->total_purchase) }}</h6>
                        </td>
                        <td style="border:1px solid black;">
                            <h6>Driver: {{ $order->driver->name }}</h6>
                            <h6>Carriage Amount: {{ number_format($order->carriage_amount) }}</h6>
                            <h6>Total Carriage: {{ number_format($order->total_carriage) }}</h6>
                        </td>
                        <td style="border:1px solid black;">
                            <h6>Supplier: {{ $order->supplier->name }}</h6>
                            <h6>Customer: {{ $order->customer->name }}</h6>
                            <h6>Sale Price: {{ number_format($order->sale_rate) }}</h6>
                            <h6>Total Sale: {{ number_format($order->total_sale_amount) }}</h6>
                        </td>
                        <td style="border:1px solid black;">{{ number_format($order->profit) }}</td>

                    </tr>

                    @endforeach
                    @endisset

                </tbody>

            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mt-4">
            <h4>Summary:</h4>
            <hr>
        </div>
        <div class="col-md-8 p-5">
            <h5>Product Types Totals</h5>

            @foreach($productTypes as $index => $productType)
            <h6>{{ $index }}: {{ number_format($productType) }}</h6>
            @endforeach
        </div>
        <div class="col-md-4 p-5">
            <h6>Total Purchase: {{ number_format($totalPurchase) }}</h6>
            <h6>Total Carriage: {{ number_format($totalCarraige) }}</h6>
            <h6>Total Sale: {{ number_format($totalSale) }}</h6>
            <h6>Total Profit: {{ number_format($totalProfit) }}</h6>
        </div>
    </div>

</section>

<section style="margin: 20px;">
    <h4 class="m-4" style="text-align: center;" id="">Expanses</h4>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-sm table-hover table-bordered" style="border: 2px solid black;">
                <thead style="color: black; border: 1px solid black;">
                    <tr style="background-color: lightgray; color: black;">
                        <th style="border:1px solid black;">Sr</th>
                        <th style="border:1px solid black;">ID</th>
                        <th style="border:1px solid black;">Date</th>
                        <th style="border:1px solid black;">Name</th>
                        <th style="border:1px solid black;">Category</th>
                        <th style="border:1px solid black;">Sub Category</th>
                        <th style="border:1px solid black;">Amount</th>
                        <th style="border:1px solid black;">Paid From</th>
                    </tr>

                </thead>
                <tbody style="border: 2px solid black;">
                    @php
                    $total_amount = 0;
                    @endphp
                    @isset($expense)

                    @foreach($expense as $expense_res)
                    <tr>
                        <td style="border:1px solid black;">{{ $loop->iteration }}</td>
                        <td style="border:1px solid black;">{{ $expense_res->id }}</td>
                        <td style="border:1px solid black;">{{ date('d-m-Y',strtotime($expense_res->date)) }}</td>

                        <td style="border:1px solid black;">{{ $expense_res->exp_name }}</td>
                        <td style="border:1px solid black;">{{ $expense_res->exp_category_name }}</td>
                        <td style="border:1px solid black;">{{ $expense_res->exp_sub_category }}</td>
                        <td style="border:1px solid black;">{{ number_format($expense_res->total_amount) }}</td>
                        <td style="border:1px solid black;">{{ $expense_res->account_name." / ".$expense_res->account_number}}</td>
                    </tr>
                    @php
                    $total_amount += $expense_res->total_amount;
                    @endphp
                    @endforeach
                    @endisset

                </tbody>
                <tfoot>
                    <tr class="font-weight-bold" style="background-color: #f0eded !important; font-size: 20px;">

                    <tr class="font-weight-bold">
                        <td style="border:1px solid black;">Totals</td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;">{{ $total_amount }}</td>
                        <td style="border:1px solid black;"></td>

                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</section>

<section style="margin: 20px;">
    <h4 class="m-4" style="text-align: center;" id="">Payments</h4>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-sm table-hover table-bordered" style="border: 2px solid black;">
                <thead style="color: black; border: 1px solid black;">
                    <tr style="background-color: lightgray; color: black;">

                        <th style="border:1px solid black;">Sr</th>
                        <th style="border:1px solid black;">Make Payment Id</th>
                        <th style="border:1px solid black;">Particular</th>
                        <th style="border:1px solid black;">Particular Name</th>
                        <th style="border:1px solid black;">Payment</th>
                        <th style="border:1px solid black;">Remarks</th>
                    </tr>

                </thead>
                <tbody style="border: 2px solid black;">
                    @php
                    $totalPayments = 0;
                    @endphp
                    @isset($makePayment)
                    @foreach($makePayment as $payment)
                    @foreach($payment->paymentItems as $item)
                    <tr>
                        <td style="border:1px solid black;">
                            {{ $loop->iteration }}
                        </td>
                        <td style="border:1px solid black;">
                            {{ $item->make_payment_id }}
                        </td>
                        <td style="border:1px solid black;">
                            {{ $item->particular }}
                        </td>
                        <td style="border:1px solid black;">
                            {{ $item->particular_name}}
                        </td>
                        <td style="border:1px solid black;">
                            {{ number_format($item->payment) }}
                        </td>
                        <td style="border:1px solid black;">
                            {{ $item->remarks }}
                        </td>


                    </tr>
                    @php
                    $totalPayments += $item->payment;
                    @endphp
                    @endforeach
                    @endforeach
                    @endisset

                </tbody>
                <tfoot>
                    <tr class="font-weight-bold" style="background-color: #f0eded !important; font-size: 20px;">

                    <tr class="font-weight-bold">
                        <td style="border:1px solid black;">Totals</td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;">{{ $totalPayments }}</td>
                        <td style="border:1px solid black;"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</section>

<section style="margin: 20px;">
    <h4 class="m-4" style="text-align: center;" id="">Received Payments</h4>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-sm table-hover table-bordered" style="border: 2px solid black;">
                <thead style="color: black; border: 1px solid black;">
                    <tr style="background-color: lightgray; color: black;">

                        <th style="border:1px solid black;">Sr</th>
                        <th style="border:1px solid black;">Receivable Payment Id</th>
                        <th style="border:1px solid black;">Particular</th>
                        <th style="border:1px solid black;">Particular Name</th>
                        <th style="border:1px solid black;">Payment</th>
                        <th style="border:1px solid black;">Remarks</th>
                    </tr>

                </thead>
                <tbody style="border: 2px solid black;">
                    @php
                    $totalPayments = 0;
                    @endphp
                    @isset($reaceivedPayment)
                    @foreach($reaceivedPayment as $payment)
                    @foreach($payment->paymentItems as $item)
                    <tr>
                        <td style="border:1px solid black;">
                            {{ $loop->iteration }}
                        </td>
                        <td style="border:1px solid black;">
                            {{ $item->received_payment_id }}
                        </td>
                        <td style="border:1px solid black;">
                            {{ $item->particular }}
                        </td>
                        <td style="border:1px solid black;">
                            {{ $item->particular_name}}
                        </td>
                        <td style="border:1px solid black;">
                            {{ number_format($item->payment) }}
                        </td>
                        <td style="border:1px solid black;">
                            {{ $item->remarks }}
                        </td>


                    </tr>
                    @php
                    $totalPayments += $item->payment;
                    @endphp
                    @endforeach
                    @endforeach
                    @endisset

                </tbody>
                <tfoot>
                    <tr class="font-weight-bold" style="background-color: #f0eded !important; font-size: 20px;">

                    <tr class="font-weight-bold">
                        <td style="border:1px solid black;">Totals</td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;">{{ $totalPayments }}</td>
                        <td style="border:1px solid black;"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</section>


@endsection

@section('prepaid_by')
{{ \Auth::user()->name }}
@endsection