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
            $data['image'] = $this->processUploadedImage($request->file('image'));
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
            // Hapus gambar lama dari storage jika sebelumnya berupa path file fisik
            if ($menu->image && !str_starts_with($menu->image, 'data:')) {
                try {
                    Storage::disk('public')->delete($menu->image);
                } catch (\Throwable $e) {
                    // Abaikan jika file lama tidak ditemukan atau gagal dihapus
                }
            }
            
            // Simpan gambar baru sebagai data URI terkompresi
            $data['image'] = $this->processUploadedImage($request->file('image'));
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

        // Hapus file fisik gambar jika berupa path file
        if ($menu->image && !str_starts_with($menu->image, 'data:')) {
            try {
                Storage::disk('public')->delete($menu->image);
            } catch (\Throwable $e) {
                // Abaikan jika file fisik sudah tidak ada
            }
        }

        $menu->delete();

        return back()->with('success', 'Menu dan gambar terkait berhasil dihapus.');
    }

    /**
     * Memproses file upload gambar menjadi base64 yang terkompresi
     * agar tersimpan permanen di database tanpa bergantung pada filesystem serverless.
     */
    protected function processUploadedImage(\Illuminate\Http\UploadedFile $file): string
    {
        $mime = $file->getMimeType() ?: 'image/jpeg';
        $content = file_get_contents($file->getRealPath());

        // Kompres & resize gambar jika ekstensi GD tersedia
        if (extension_loaded('gd') && function_exists('imagecreatefromstring')) {
            try {
                $img = @imagecreatefromstring($content);
                if ($img !== false) {
                    $origWidth = imagesx($img);
                    $origHeight = imagesy($img);
                    $maxDim = 800; // Ukuran optimal untuk POS & Web (tajam dan sangat ringan)

                    if ($origWidth > $maxDim || $origHeight > $maxDim) {
                        if ($origWidth > $origHeight) {
                            $newWidth = $maxDim;
                            $newHeight = (int) ($origHeight * ($maxDim / $origWidth));
                        } else {
                            $newHeight = $maxDim;
                            $newWidth = (int) ($origWidth * ($maxDim / $origHeight));
                        }

                        $resized = imagecreatetruecolor($newWidth, $newHeight);
                        imagealphablending($resized, false);
                        imagesavealpha($resized, true);
                        imagecopyresampled($resized, $img, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
                        imagedestroy($img);
                        $img = $resized;
                    }

                    ob_start();
                    imagejpeg($img, null, 80);
                    $content = ob_get_clean();
                    $mime = 'image/jpeg';
                    imagedestroy($img);
                }
            } catch (\Throwable $e) {
                // Gunakan file asli jika proses kompresi GD gagal
            }
        }

        return 'data:' . $mime . ';base64,' . base64_encode($content);
    }
}