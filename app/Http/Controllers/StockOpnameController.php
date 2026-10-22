<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\StockOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockOpnameController extends Controller
{
    protected function authorizeAdmin(): void
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk mengelola stock opname.');
        }
    }

    public function index()
    {
        $this->authorizeAdmin();

        $menus = Menu::orderBy('name')->get();
        $opnames = StockOpname::with(['user', 'items'])
            ->latest()
            ->paginate(8);

        return view('stock-opnames.index', compact('menus', 'opnames'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'counts' => 'required|array|min:1',
            'counts.*' => 'required|integer|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($data): void {
            $menus = Menu::query()->orderBy('id')->lockForUpdate()->get();
            $submittedIds = array_map('intval', array_keys($data['counts']));
            $menuIds = $menus->modelKeys();
            sort($submittedIds);
            sort($menuIds);

            if ($submittedIds !== $menuIds) {
                throw ValidationException::withMessages([
                    'counts' => 'Pastikan stok fisik semua menu diisi sebelum menyimpan stock opname.',
                ]);
            }

            $opname = StockOpname::create([
                'user_id' => Auth::id(),
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($menus as $menu) {
                $countedStock = (int) $data['counts'][$menu->id];
                $expectedStock = $menu->stock;

                $opname->items()->create([
                    'menu_id' => $menu->id,
                    'menu_name' => $menu->name,
                    'expected_stock' => $expectedStock,
                    'counted_stock' => $countedStock,
                    'difference' => $countedStock - $expectedStock,
                ]);

                $menu->update(['stock' => $countedStock]);
            }
        });

        return redirect()
            ->route('stock-opnames.index')
            ->with('success', 'Stock opname berhasil disimpan dan stok menu telah diperbarui.');
    }
}
