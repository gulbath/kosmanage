<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\StoreExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::latest()->paginate(10);

        return view('owner.expenses.index', compact('expenses'));
    }

    public function store(StoreExpenseRequest $request): RedirectResponse
    {
        Expense::create([
            'category' => $request->category,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'description' => $request->description,
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('owner.expenses.index')->with('success', 'Pengeluaran operasional berhasil dicatat.');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $expense->delete();

        return redirect()->route('owner.expenses.index')->with('success', 'Pencatatan pengeluaran berhasil dihapus.');
    }
}