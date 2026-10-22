<?php

namespace App\Exports;

use RuntimeException;
use XMLWriter;
use ZipArchive;

class FinancePaymentsXlsx
{
    /**
     * @param array<int, array<int, string|int|float>> $rows
     */
    public function export(array $rows): string
    {
        if (!class_exists(ZipArchive::class)) {
            throw new RuntimeException('Ekstensi PHP Zip harus diaktifkan untuk mengekspor file Excel.');
        }

        $path = tempnam(sys_get_temp_dir(), 'finance-');
        if ($path === false) {
            throw new RuntimeException('File sementara untuk ekspor keuangan gagal dibuat.');
        }

        $archive = new ZipArchive();
        if ($archive->open($path, ZipArchive::OVERWRITE) !== true) {
            @unlink($path);
            throw new RuntimeException('File Excel gagal dibuat.');
        }

        try {
            $files = [
                '[Content_Types].xml' => $this->contentTypes(),
                '_rels/.rels' => $this->rootRelationships(),
                'xl/workbook.xml' => $this->workbook(),
                'xl/_rels/workbook.xml.rels' => $this->workbookRelationships(),
                'xl/worksheets/sheet1.xml' => $this->worksheet($rows),
            ];

            foreach ($files as $name => $contents) {
                if (!$archive->addFromString($name, $contents)) {
                    throw new RuntimeException('Bagian file Excel gagal ditulis.');
                }
            }
        } catch (\Throwable $exception) {
            $archive->close();
            @unlink($path);
            throw $exception;
        }

        if (!$archive->close()) {
            @unlink($path);
            throw new RuntimeException('File Excel gagal diselesaikan.');
        }

        return $path;
    }

    private function contentTypes(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '</Types>';
    }

    private function rootRelationships(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>';
    }

    private function workbook(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="Pemasukan" sheetId="1" r:id="rId1"/></sheets>'
            . '</workbook>';
    }

    private function workbookRelationships(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '</Relationships>';
    }

    /**
     * @param array<int, array<int, string|int|float>> $rows
     */
    private function worksheet(array $rows): string
    {
        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8', 'yes');
        $writer->startElement('worksheet');
        $writer->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $writer->startElement('sheetData');

        foreach ($rows as $rowIndex => $row) {
            $rowNumber = $rowIndex + 1;
            $writer->startElement('row');
            $writer->writeAttribute('r', (string) $rowNumber);

            foreach ($row as $columnIndex => $value) {
                $cellReference = $this->columnName($columnIndex + 1) . $rowNumber;
                $writer->startElement('c');
                $writer->writeAttribute('r', $cellReference);

                if (is_int($value) || is_float($value)) {
                    $writer->startElement('v');
                    $writer->text((string) $value);
                    $writer->endElement();
                } else {
                    $writer->writeAttribute('t', 'inlineStr');
                    $writer->startElement('is');
                    $writer->writeElement('t', $value);
                    $writer->endElement();
                }

                $writer->endElement();
            }

            $writer->endElement();
        }

        $writer->endElement();
        $writer->endElement();
        $writer->endDocument();

        return $writer->outputMemory();
    }

    private function columnName(int $column): string
    {
        $name = '';
        while ($column > 0) {
            $remainder = ($column - 1) % 26;
            $name = chr(65 + $remainder) . $name;
            $column = intdiv($column - 1, 26);
        }

        return $name;
    }
}
