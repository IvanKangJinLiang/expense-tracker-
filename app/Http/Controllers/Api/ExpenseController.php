<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        return Expense::orderBy('expense_date', 'desc')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description'   => 'required|string|max:255',
            'amount'        => 'required|numeric|min:0',
            'currency'      => 'required|string|size:3',
            'expense_date' => 'required|date',
        ]);

        $expense = Expense::create($validated);

        return response()->json($expense, 201);
    }

    public function update(Request $request, $id)
    {

        $expense = Expense::findOrFail($id);

        $validated = $request->validate([
            'description'   => 'required|string|max:255',
            'amount'        => 'required|numeric|min:0',
            'currency'      => 'required|string|size:3',
            'expense_date'  => 'required|date',
        ]);

        $expense->update($validated);

        return response()->json($expense);
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return response()->noContent();
    }
}
