<?php

namespace App\Http\Controllers;

use App\Models\Account\Account;
use App\Models\Account\expense;
use App\Models\Account\expenseCategory;
use App\Models\Account\MakePayment;
use App\Models\Account\ReceivedPayment;
use App\Models\Order;
use App\Models\Party;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller

{
    public function dashboard(): View
    {
        return view('adminPanel/dashboard');
    }


    public function getDashboardCard(Request $request)
    {
        $todaySaleAmount = Order::where('date', date('Y-m-d'))->sum('total_sale_amount');
        $todayOrdersCount = Order::where('date', date('Y-m-d'))->count();
        $todayOrderProfit = Order::where('date', date('Y-m-d'))->sum('profit');

        $todayPayments = MakePayment::where('date', date('Y-m-d'))->sum('total_payments');
        $todayReceivedPayments = ReceivedPayment::where('date', date('Y-m-d'))->sum('total_payments');

        $todayExpense = expense::whereYear('date', $request->year)
            ->sum('total_amount');

        $markaReceivable = Party::where('type', 'Marka')
            ->where('balance', '<', 0)->sum('balance');

        $markaPayable = Party::where('type', 'Marka')
            ->where('balance', '>', 0)->sum('balance');

        $driverReceivable = Party::where('type', 'Driver')
            ->where('balance', '<', 0)->sum('balance');

        $driverPayable = Party::where('type', 'Driver')
            ->where('balance', '>', 0)->sum('balance');

        $accountPayable = Account::where('balance', '<', 0)->sum('balance');

        $accountReceivable = Account::where('balance', '>', 0)->sum('balance');



        $year = $request->input('year', date('Y'));

        return response()->json([
            'error' => false,
            'data' => [
                'todaySaleAmount' => number_format($todaySaleAmount),
                'todayOrdersCount' => number_format($todayOrdersCount),
                'todayOrderProfit' => number_format($todayOrderProfit),
                'todayPayments' => number_format($todayPayments),
                'todayReceivedPayments' =>  number_format($todayReceivedPayments),
                'todayExpense' =>  number_format($todayExpense),
                'markaReceivable' =>  number_format($markaReceivable),
                'markaPayable' =>  number_format($markaPayable),
                'driverReceivable' =>  number_format($driverReceivable),
                'driverPayable' =>  number_format($driverPayable),
                'accountPayable' =>  number_format($accountPayable),
                'accountReceivable' =>  number_format($accountReceivable),
                'todayRevenue' => number_format($todayOrderProfit - $todayExpense),
                'expenseGraph' => $this->categoryWiseExpenseGraph($year),
                'expenseMonthyGraph' => $this->monthWiseExpense($year),
                'monthWiseOrders' => $this->monthWiseOrders($year),
                'monthWiseProfit' => $this->monthWiseProfit($year),
            ]
        ]);
    }

    private function categoryWiseExpenseGraph($year)
    {
        $expenseCategory = expenseCategory::all();
        $expenseLables = [];
        $expenseValues = [];
        foreach ($expenseCategory as $category) {
            $expenseLables[] = $category->exp_category_name;
            $totalExpense = expense::where('category_id', $category->id)->whereYear('date', $year)->sum('total_amount');
            $expenseValues[] = ["name" => $category->exp_category_name, "data" => [$totalExpense]];
        }

        return [$expenseLables, $expenseValues];
    }

    private function monthWiseExpense($year)
    {
        // Month Wise Graph

        $monthLabels = [];
        $expenseMonthlyValues = [];

        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::create($year, $month, 1);
            $monthLabels[] = $date->format('F');
            $expenseMonthlyValues[] = 0;
        }

        $expenses = Expense::selectRaw('MONTH(date) as month, SUM(total_amount) as total_expense')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        foreach ($expenses as $expense) {
            $monthIndex = $expense->month - 1;
            $expenseMonthlyValues[$monthIndex] = $expense->total_expense;
        }

        return [$monthLabels, $expenseMonthlyValues];
    }

    private function monthWiseOrders($year)
    {
        // Month Wise Graph

        $monthLabels = [];
        $orderMonthlyValues = [];

        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::create($year, $month, 1);
            $monthLabels[] = $date->format('F');
            $orderMonthlyValues[] = 0;
        }

        $orders = Order::selectRaw('MONTH(date) as month, count(id) as total_order')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        foreach ($orders as $order) {
            $monthIndex = $order->month - 1;
            $orderMonthlyValues[$monthIndex] = $order->total_order;
        }

        return [$monthLabels, $orderMonthlyValues];
    }

    private function monthWiseProfit($year)
    {
        // Month Wise Graph

        $monthLabels = [];
        $MonthyProfitValues = [];

        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::create($year, $month, 1);
            $monthLabels[] = $date->format('F');
            $MonthyProfitValues[] = 0;
        }

        $ordersProfit = Order::selectRaw('MONTH(date) as month, Sum(profit) as total_profit')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $expenses = Expense::selectRaw('MONTH(date) as month, SUM(total_amount) as total_expense')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        foreach ($ordersProfit as $index => $order) {
            $monthIndex = $order->month - 1;
            $MonthyProfitValues[$monthIndex] = $order->total_profit - $expenses[$index]->total_expense;
        }

        return [$monthLabels, $MonthyProfitValues];
    }
}
