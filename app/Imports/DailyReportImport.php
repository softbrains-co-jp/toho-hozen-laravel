<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class DailyReportImport implements ToCollection
{
    public $dailyReports = [];

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        for ($i = 4; $i < count($rows); $i++) {
            $data = [
                'category' => $this->stringCell($rows[$i][2]), // 区分
                'conduct_plan_date' => $this->parseExcelDate($rows[$i][3]),  // 予定日
                'stop_flag' => $this->stringCell($rows[$i][4]), // 停止有無
                'stop_time' => $this->stringCell($rows[$i][5]), // 停止時間
                'toh_cd' => $this->stringCell($rows[$i][6]), // 付託番号
                'conduct_time_cd' => $this->stringCell($rows[$i][7]), // 午前／午後区分
                'conduct_member_name' => $this->stringCell($rows[$i][8]), // 作業班長
                'partner_company' => $this->stringCell($rows[$i][10]), // 協力会社名
                'address' => $this->stringCell($rows[$i][11]), // 住所
                'multi_mc' => $this->stringCell($rows[$i][12]), // マルチM/C開閉
                'pole_no' => $this->stringCell($rows[$i][13]), // 電柱番号
                'construction_type' => $this->stringCell($rows[$i][14]), // 工事種別
                'number_of_pages' => $this->stringCell($rows[$i][15]), // 紙枚数
                'start_time' => $this->parseExcelTime($rows[$i][16]), // 開始時間
                'end_time' => $this->parseExcelTime($rows[$i][17]),   // 終了時間
                'completion_flag' => $this->stringCell($rows[$i][18]), // 完了区分
                'remarks' => $this->stringCell($rows[$i][19]), // 備考
            ];

            if ($this->isEndData($data)) {
                break;
            }

            $this->dailyReports[] = $data;
        }
    }

    private function isEndData($data) {
        if (
            !$data['category'] &&
            !$data['stop_flag'] &&
            !$data['stop_time'] &&
            !$data['toh_cd'] &&
            !$data['conduct_time_cd'] &&
            !$data['conduct_member_name'] &&
            !$data['partner_company'] &&
            !$data['address'] &&
            !$data['multi_mc'] &&
            !$data['pole_no'] &&
            !$data['construction_type'] &&
            !$data['start_time'] &&
            !$data['end_time'] &&
            !$data['completion_flag'] &&
            !$data['remarks']
        ) {
            return true;
        }

        return false;
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

    private function stringCell($value): string
    {
        return trim((string) ($value ?? ''));
    }

    /**
     * Excel の時刻シリアル値 または 文字列時刻 を "H:i" 形式に変換
     */
    private function parseExcelTime($value)
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Excel の時刻シリアル値（例: 0.375 = 09:00）
        if (is_numeric($value)) {
            return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->format('H:i');
        }

        $stringValue = trim((string) $value);

        foreach (['H:i', 'G:i', 'H:i:s', 'G:i:s'] as $format) {
            $time = \DateTime::createFromFormat($format, $stringValue);
            if ($time && $time->format($format) === $stringValue) {
                return $time->format('H:i');
            }
        }

        // Controller 側のバリデーションでエラー表示させるため、そのまま返す
        return $stringValue;
    }
}
