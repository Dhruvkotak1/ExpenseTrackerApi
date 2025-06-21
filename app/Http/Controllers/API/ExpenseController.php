<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $expenses = User::with('expense')->find($request->user()->id);
        
        return $this->sendResponse("All data fetched successfully", $expenses['expense']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateExpense = Validator::make($request->all(), [
            'title' => 'required',
            'amount' => 'required|integer',
            'description' => 'nullable',
            'date' => 'required|date_format:Y/m/d',
            'is_recurring' => 'required|boolean',
            'category_id' => 'required|exists:categories,id'
        ]);
        if ($validateExpense->fails()) {
            return $this->sendError("Validation Error", $validateExpense->errors()->all(), 401);
        }
        $categoryExists = Category::where('id', $request->category_id)->where('user_id', $request->user()->id)->first();
        if (!$categoryExists) {
            return $this->sendError("Category id not matched");
        }
        $expense = new Expense();
        $expense->user_id = $request->user()->id;
        $expense->category_id = $request->category_id;
        $expense->title = $request->title;
        $expense->amount = $request->amount;
        $expense->description = $request->description;
        $expense->expense_date = $request->date;
        $expense->is_recurring = boolval($request->is_recurring);

        if ($expense->save()) {
            return $this->sendResponse('Expense created successfully', $expense);
        }
        return $this->sendError("Expense not created", 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $expense = Expense::where('user_id', $request->user()->id)->find($id);
        if ($expense) {
            return $this->sendResponse("Expense found.", $expense);
        }
        return $this->sendError("Expense not found");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $expense = Expense::where('user_id', $request->user()->id)->find($id);
        if ($expense) {
            $validateExpense = Validator(
                $request->all(),
                [
                    'title' => 'required',
                    'amount' => 'required|integer',
                    'description' => 'nullable',
                    'date' => 'required|date_format:Y/m/d',
                    'is_recurring' => 'required|boolean',
                    'category_id' => 'required|exists:categories,id'
                ]
            );
            if ($validateExpense->fails()) {
                return $this->sendError("Validation Error", $validateExpense->errors()->all(), 400);
            }

            $categoryExists = Category::where('id', $request->category_id)->where('user_id', $request->user()->id)->first();
            if (!$categoryExists) {
                return $this->sendError("Category id not matched");
            }
            Expense::where("id", $id)->where('user_id', $request->user()->id)->update(['title' => $request->title, 'description' => $request->description, 'amount' => $request->amount, 'expense_date' => $request->date,'category_id' => $request->category_id, 'is_recurring' => boolval($request->is_recurring)]);
            return $this->sendResponse("Expense Updated successfully");
        }
        return $this->sendError("Expense not found");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $expense = Expense::where('user_id', $request->user()->id)->find($id);
        if ($expense) {
            Expense::where('id', $id)->delete();
            return $this->sendResponse("Expense deleted Successfully");
        }
        return $this->sendError("Expense not found");
    }
}
