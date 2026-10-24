<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'category', 'image', 'stock',
    ];

    /**
     * Mendapatkan URL gambar yang siap ditampilkan (data URI base64 atau path file storage).
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'data:') || str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    /**
     * Mengelompokkan menu ke grup filter: kopi, non-kopi, pastry
     */
    public function getCategoryGroupAttribute(): string
    {
        $cat = strtolower(trim((string) ($this->category ?? '')));
        $name = strtolower(trim((string) ($this->name ?? '')));

        if (str_contains($cat, 'non-kopi') || str_contains($cat, 'non kopi') || str_contains($cat, 'non-coffee') || str_contains($cat, 'non coffee')) {
            return 'non-kopi';
        }

        if (str_contains($cat, 'kopi') || str_contains($cat, 'coffee')) {
            return 'kopi';
        }

        if (str_contains($cat, 'pastry') || str_contains($cat, 'snack') || str_contains($cat, 'makanan') || str_contains($cat, 'bakery') || str_contains($cat, 'cake') || str_contains($cat, 'roti')) {
            return 'pastry';
        }

        // Cek nama menu jika kategori umum (misal Minuman)
        $coffeeKeywords = ['kopi', 'coffee', 'latte', 'espresso', 'americano', 'cappuccino', 'mocha', 'macchiato', 'robusta', 'arabica', 'affogato', 'piccolo', 'v60', 'manual brew', 'cold brew'];
        foreach ($coffeeKeywords as $kw) {
            if (str_contains($name, $kw)) {
                return 'kopi';
            }
        }

        $pastryKeywords = ['croissant', 'croffle', 'pastry', 'roti', 'cake', 'toast', 'kentang', 'donut', 'brownies', 'cookie', 'cookies', 'pie', 'waffle'];
        foreach ($pastryKeywords as $kw) {
            if (str_contains($name, $kw)) {
                return 'pastry';
            }
        }

        if ($cat === 'minuman' || str_contains($name, 'tea') || str_contains($name, 'teh') || str_contains($name, 'matcha') || str_contains($name, 'chocolate') || str_contains($name, 'cokelat') || str_contains($name, 'susu') || str_contains($name, 'milk') || str_contains($name, 'juice') || str_contains($name, 'jus')) {
            return 'non-kopi';
        }

        return $cat ?: 'lainnya';
    }
}

