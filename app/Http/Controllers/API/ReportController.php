<?php

namespace App\Http\Controllers\API;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ReportController extends BaseController
{
    public function monthly(Request $request)
    {
        $monthlyExpenses  = Expense::where('user_id', $request->user()->id)->select(
            DB::raw("DATE_FORMAT(expense_date,'%Y-%m') as month"),
            DB::raw("SUM(amount) as total"))
                ->groupBy('month')
                ->orderBy('month', 'desc')
                ->get();
        
        $totalExpense = Expense::where('user_id',$request->user()->id)->sum('amount');

        return $this->sendResponse("success", [$totalExpense,$monthlyExpenses]);
    }

    public function summary(Request $request) {
        $categoryExpenses = Expense::join('categories', 'expenses.category_id', '=', 'categories.id')
        ->where('expenses.user_id', $request->user()->id) // ✅ Specify the table!
        ->select('categories.name', DB::raw('SUM(expenses.amount) as total'))
        ->groupBy('categories.name')
        ->get();

        $totalExpense = Expense::where('user_id',$request->user()->id)->sum('amount');


        return $this->sendResponse("Success",[$totalExpense,$categoryExpenses]);
    }

    public function monthlyByCategory(Request $request)
{
    $userId = $request->user()->id;

    $data = Expense::join('categories', 'expenses.category_id', '=', 'categories.id')
        ->where('expenses.user_id', $userId)
        ->whereNotNull('expenses.expense_date') // ensure valid dates
        ->select(
            DB::raw("DATE_FORMAT(expenses.expense_date, '%Y-%m') as month"),
            'categories.name as category',
            DB::raw('SUM(expenses.amount) as total')
        )
        ->groupBy('month', 'category')
        ->orderBy('month', 'desc')
        ->get();

    return $this->sendResponse("Success",$data);
}
}
