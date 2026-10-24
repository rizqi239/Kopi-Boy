<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    protected function authorizeAdmin(): void
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk mengelola menu.');
        }
    }

    /**
     * Menampilkan daftar menu dengan paginasi.
     */
    public function index(Request $request)
    {
        $category = $request->get('category');

        $query = Menu::orderBy('created_at', 'desc');
        if ($category) {
            $query->where('category', $category);
        }

        $menus = $query->paginate(12)->withQueryString();
        return view('menus.index', compact('menus', 'category'));
    }

    /**
     * Menampilkan form tambah menu.
     */
    public function create()
    {
        $this->authorizeAdmin();

        return view('menus.create');
    }

    /**
     * Menyimpan menu baru ke database.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'nullable|integer|min:0',
            // Validasi file gambar (maksimal 5MB)
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'category'    => 'nullable|string|max:100',
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $data['image'] = $path;
        }

        Menu::create($data);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit menu.
     */
    public function edit(Menu $menu)
    {
        $this->authorizeAdmin();

        return view('menus.edit', compact('menu'));
    }

    /**
     * Memperbarui data menu yang sudah ada.
     */
    public function update(Request $request, Menu $menu)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'nullable|integer|min:0',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'category'    => 'nullable|string|max:100',
        ]);

        // Proses update gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage jika ada
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Menghapus menu dan file gambarnya.
     */
    public function destroy(Menu $menu)
    {
        $this->authorizeAdmin();

        // Hapus file fisik gambar dari folder storage agar tidak menumpuk
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return back()->with('success', 'Menu dan gambar terkait berhasil dihapus.');
    }
}