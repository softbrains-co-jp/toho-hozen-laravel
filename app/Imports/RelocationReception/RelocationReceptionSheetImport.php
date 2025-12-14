<?php

namespace App\Imports\RelocationReception;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class RelocationReceptionSheetImport implements WithEvents
{
    private $parent;

    public function __construct($parentImport)
    {
        $this->parent = $parentImport; // ← 親を保持
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {

                $sheet = $event->getDelegate();

                $kddi_cd =
                    $sheet->getCell('AQ7')->getValue() .
                    $sheet->getCell('AR7')->getValue() . "-" .
                    $sheet->getCell('AV7')->getValue() . "-" .
                    $sheet->getCell('AZ7')->getValue();

                $relation_cd = $sheet->getCell('AQ6')->getValue();
                $branch_cd   = $sheet->getCell('Q7')->getValue();

                $work_address = $sheet->getCell('H11')->getValue();

                $work_notes =
                    $sheet->getCell('H13')->getValue() . "\r\n" .
                    $sheet->getCell('H14')->getValue() . "\r\n" .
                    $sheet->getCell('H15')->getValue();

                $order_notes =
                    $sheet->getCell('H16')->getValue() . "\r\n" .
                    $sheet->getCell('H17')->getValue() . "\r\n" .
                    $sheet->getCell('H18')->getValue();

                $pole_cd = $sheet->getCell('H19')->getValue();
                $term_start_date = $this->parseExcelDate($sheet->getCell('H20')->getValue());
                $term_end_date = $this->parseExcelDate($sheet->getCell('S20')->getValue());
                $t_term_start_date = $this->parseExcelDate($sheet->getCell('AJ20')->getValue());
                $t_term_end_date   = $this->parseExcelDate($sheet->getCell('AU20')->getValue());
                $kddi_oder_date    = $this->parseExcelDate($sheet->getCell('AU24')->getValue());

                // ★ 取得したデータを親に渡す ★
                $this->parent->relocationReception = [
                    'kddi_cd' => $kddi_cd,
                    'toh_cd' => mb_convert_kana($kddi_cd, 'a'),
                    'relation_cd' => $relation_cd,
                    'branch_cd' => $branch_cd,
                    'work_address' => $work_address,
                    'work_notes' => $work_notes,
                    'order_notes' => $order_notes,
                    'pole_cd' => mb_convert_kana($pole_cd, 'A'),
                    'term_start_date' => $term_start_date,
                    'term_end_date' => $term_end_date,
                    't_term_start_date' => $t_term_start_date,
                    't_term_end_date' => $t_term_end_date,
                    'kddi_oder_date' => $kddi_oder_date,
                ];
            }
        ];
    }

    /**
     * Excel の日付シリアル値 または 文字列日付 を Carbon に変換
     */
    private function parseExcelDate($value)
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Excel のシリアル値（日付が数字の場合）
        if (is_numeric($value)) {
            return Carbon::instance(ExcelDate::excelToDateTimeObject($value));
        }

        // 文字列日付（例：2024/12/01）
        return Carbon::parse($value);
    }
}

