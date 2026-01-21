<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    // GET /api/expenses
    public function index()
    {
        return Expense::orderBy('expense_date', 'desc')->get();
    }

    // POST /api/expenses
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

        // 3. Update the expense using Eloquent
        $expense->update($validated);

        // 4. Return the updated item
        return response()->json($expense);
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return response()->noContent();
    }
}
