<?php

use App\Helpers\Helper;
?>
@extends('adminPanel/print_master')
@section('content')
<h3 style="margin-top:40px;">Payable & Receivable report</h3>

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
        <h6>Reporting Date: {{ date('d-m-Y') }}</h6>
    </div>
    <div class="col-md-9">
        <h6>Reporting Time: {{ date('h:i:sa') }}</h6>
    </div>
</div>
<section style="margin: 20px;">
    <h4 style="text-align: right;" id=""></h4>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-sm table-hover table-bordered" style="border: 2px solid black;">
                <thead style="color: black; border: 1px solid black;">
                    <tr style="background-color: lightgray; color: black;">
                        <th style="border:1px solid black;">Date</th>
                        <th style="border:1px solid black;">Particular</th>
                        <th style="border:1px solid black;">Payable</th>
                        <th style="border:1px solid black;">Receivable</th>
                        <th style="border:1px solid black;">Balance</th>

                    </tr>

                </thead>
                <tbody style="border: 2px solid black;">
                    @php
                    $totalPayable = 0;
                    $totalReceivable = 0;
                    @endphp
                    <tr>
                        <td style="border:1px solid black;">{{ date('d-m-Y') }}</td>
                        <td style="border:1px solid black;">Marka</td>
                        <td style="border:1px solid black;">{{ number_format($markaPayable) }}</td>
                        <td style="border:1px solid black;">{{ number_format($markaReceivable) }}</td>
                        <td style="border:1px solid black;">{{ number_format($markaPayable - (-$markaReceivable)) }}</td>
                    </tr>
                    @php
                    $totalPayable += $markaPayable;
                    $totalReceivable += $markaReceivable;
                    @endphp
                    <tr>
                        <td style="border:1px solid black;">{{ date('d-m-Y') }}</td>
                        <td style="border:1px solid black;">Vehicle</td>
                        <td style="border:1px solid black;">{{ number_format($driverPayable) }}</td>
                        <td style="border:1px solid black;">{{ number_format($driverReceivable) }}</td>
                        <td style="border:1px solid black;">{{ number_format($driverPayable - (-$driverReceivable)) }}</td>
                    </tr>
                    @php
                    $totalPayable += $driverPayable;
                    $totalReceivable += $driverReceivable;
                    @endphp
                    @isset($supplierAccounts)
                    @foreach($supplierAccounts as $supplier)
                    <tr>
                        <td style="border:1px solid black;">{{ date('d-m-Y') }}</td>
                        <td style="border:1px solid black;">{{ $supplier['name'] }} (Supplier)

                        </td>
                        <td style="border:1px solid black;">{{ number_format($supplier['payable']) }}</td>
                        <td style="border:1px solid black;">{{ number_format($supplier['receivable']) }}</td>
                        <td style="border:1px solid black;">{{ number_format($supplier['payable'] - (-$supplier['receivable'])) }}</td>
                    </tr>
                    @php
                    $totalPayable += $supplier['payable'];
                    $totalReceivable += $supplier['receivable'];
                    @endphp
                    @endforeach
                    @endisset

                    @isset($cashAccounts)
                    @foreach($cashAccounts as $account)
                    <tr>
                        <td style="border:1px solid black;">{{ date('d-m-Y') }}</td>
                        <td style="border:1px solid black;">{{ $account->account_name }} (Cash Account)

                        </td>
                        <td style="border:1px solid black;">
                            @if($account->balance < 0) {{ number_format($account->balance) }} @php $totalPayable +=$account->balance;
                                @endphp
                                @endif </td>
                        <td style="border:1px solid black;">
                            @if($account->balance > 0) {{ number_format($account->balance) }}
                            @php
                            $totalReceivable += (-$account->balance);
                            @endphp
                            @endif </td>
                        <td style="border:1px solid black;">{{ number_format($account->balance) }}</td>
                    </tr>
                    @php
                    @endphp
                    @endforeach
                    @endisset

                </tbody>
                <tfoot>
                    <tr class="font-weight-bold" style="background-color: #f0eded !important; font-size: 20px;">

                    <tr class="font-weight-bold">
                        <td style="border:1px solid black;">Totals</td>
                        <td style="border:1px solid black;"></td>
                        <td style="border:1px solid black;">{{ number_format($totalPayable) }}</td>
                        <td style="border:1px solid black;">{{ number_format($totalReceivable) }}</td>

                        <td style="border:1px solid black;">{{ number_format($totalPayable - (-$totalReceivable)) }}</td>

                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    @endsection

    @section('prepaid_by')
    {{ Helper::getUserName(\Auth::user()->id) }}
    @endsection