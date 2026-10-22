<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    protected function authorizeAdmin(): void
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk mengelola pengeluaran.');
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'category' => 'required|string|max:100',
            'amount' => 'required|integer|min:1|max:9999999999',
            'expense_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        Expense::create([
            ...$data,
            'user_id' => Auth::id(),
        ]);

        return redirect()
            ->route('management.finance')
            ->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function update(Request $request, Expense $expense): RedirectResponse
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'category' => 'required|string|max:100',
            'amount' => 'required|integer|min:1|max:9999999999',
            'expense_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $expense->update($data);

        return redirect()
            ->route('management.finance')
            ->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $this->authorizeAdmin();

        $expense->delete();

        return redirect()
            ->route('management.finance')
            ->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
