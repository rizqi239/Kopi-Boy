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
     * Otomatis mengkoreksi kategori tampilan jika menu adalah varian non-kopi (seperti Macha Latte / Matcha Latte).
     */
    public function getCategoryAttribute($value): ?string
    {
        $name = strtolower(trim((string) ($this->attributes['name'] ?? '')));
        $nonCoffeeKeywords = [
            'matcha', 'macha', 'taro', 'red velvet', 'green tea', 'greentea', 'thai tea', 'thaitea',
            'chocolate', 'cokelat', 'choco', 'lemonade', 'squash', 'yakult', 'mojito'
        ];
        
        foreach ($nonCoffeeKeywords as $kw) {
            if (str_contains($name, $kw) && !str_contains($name, 'kopi') && !str_contains($name, 'coffee') && !str_contains($name, 'espresso')) {
                if (empty($value) || strtolower($value) === 'kopi' || strtolower($value) === 'coffee' || strtolower($value) === 'latte') {
                    return 'Non Kopi';
                }
            }
        }

        return $value;
    }

    /**
     * Mengelompokkan menu ke grup filter: kopi, non-kopi, pastry
     */
    public function getCategoryGroupAttribute(): string
    {
        $cat = strtolower(trim((string) ($this->category ?? '')));
        $name = strtolower(trim((string) ($this->name ?? '')));

        // 1. Minuman non-kopi spesifik (seperti Matcha Latte, Macha Latte, Taro Latte, Red Velvet Latte)
        // Meskipun mengandung kata "latte", minuman ini adalah non-kopi!
        $nonCoffeeKeywords = [
            'matcha', 'macha', 'taro', 'red velvet', 'green tea', 'greentea', 'thai tea', 'thaitea',
            'chocolate', 'cokelat', 'choco', 'boba', 'lemonade', 'squash', 'yakult', 'mojito',
            'milk tea', 'milktea', 'alpukat', 'avocado', 'mangga', 'mango', 'strawberry', 'stroberi',
            'taro latte', 'matcha latte', 'macha latte'
        ];
        foreach ($nonCoffeeKeywords as $kw) {
            if (str_contains($name, $kw) || str_contains($cat, $kw)) {
                if (!str_contains($name, 'kopi') && !str_contains($name, 'coffee') && !str_contains($name, 'espresso')) {
                    return 'non-kopi';
                }
            }
        }

        // 2. Kategori Non-Kopi eksplisit dari database
        if (str_contains($cat, 'non-kopi') || str_contains($cat, 'non kopi') || str_contains($cat, 'non-coffee') || str_contains($cat, 'non coffee')) {
            return 'non-kopi';
        }

        // 3. Pastry / Makanan
        if (str_contains($cat, 'pastry') || str_contains($cat, 'snack') || str_contains($cat, 'makanan') || str_contains($cat, 'bakery') || str_contains($cat, 'cake') || str_contains($cat, 'roti')) {
            return 'pastry';
        }

        $pastryKeywords = ['croissant', 'croffle', 'pastry', 'roti', 'cake', 'toast', 'kentang', 'donut', 'brownies', 'cookie', 'cookies', 'pie', 'waffle'];
        foreach ($pastryKeywords as $kw) {
            if (str_contains($name, $kw)) {
                return 'pastry';
            }
        }

        // 4. Kategori Kopi dari database
        if (str_contains($cat, 'kopi') || str_contains($cat, 'coffee')) {
            return 'kopi';
        }

        // 5. Cek nama menu untuk kata kunci kopi (latte, espresso, cappuccino, americano, dll)
        $coffeeKeywords = ['kopi', 'coffee', 'latte', 'espresso', 'americano', 'cappuccino', 'mocha', 'macchiato', 'robusta', 'arabica', 'affogato', 'piccolo', 'v60', 'manual brew', 'cold brew'];
        foreach ($coffeeKeywords as $kw) {
            if (str_contains($name, $kw)) {
                return 'kopi';
            }
        }

        // 6. Minuman umum lainnya (teh, susu, jus)
        if ($cat === 'minuman' || str_contains($name, 'tea') || str_contains($name, 'teh') || str_contains($name, 'susu') || str_contains($name, 'milk') || str_contains($name, 'juice') || str_contains($name, 'jus')) {
            return 'non-kopi';
        }

        return $cat ?: 'lainnya';
    }
}

