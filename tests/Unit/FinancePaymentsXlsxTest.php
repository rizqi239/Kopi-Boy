<?php

use App\Exports\FinancePaymentsXlsx;

test('finance export creates a valid xlsx archive with safely encoded cells', function () {
    $path = (new FinancePaymentsXlsx())->export([
        ['Invoice', 'Pelanggan', 'Produk', 'Waktu Dibayar', 'Metode', 'Pemasukan (Rp)'],
        ['INV-001', 'Nama & Kedai', 'Kopi <Susu> x 2', '2026-10-03 11:00:00', 'Cash', 50000],
    ]);

    try {
        $archive = new ZipArchive();
        expect($archive->open($path))->toBeTrue();
        expect($archive->getNameIndex(0))->toBe('[Content_Types].xml');

        $worksheet = $archive->getFromName('xl/worksheets/sheet1.xml');
        expect($worksheet)->toContain('Nama &amp; Kedai')
            ->toContain('Kopi &lt;Susu&gt; x 2')
            ->toContain('<c r="F2"><v>50000</v></c>');

        $archive->close();
    } finally {
        if (file_exists($path)) {
            unlink($path);
        }
    }
});
