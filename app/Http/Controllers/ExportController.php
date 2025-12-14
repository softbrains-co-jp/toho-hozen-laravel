<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests\Export\ExportRequest;
use App\Models\MstMember;
use App\Models\Maintenance;
use App\Models\MstBranch;
use App\Models\MstUser;

class ExportController extends Controller
{
    public function index(Request $request)
    {
        // チェック者(担当者)一覧
        $members = MstMember::orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->pluck('name', 'code')
            ->toArray();

        return view('export.index')
            ->with(compact(
                'members',
            ));
    }

    public function post(ExportRequest $request) {
        $action = $request->input('action');

        switch ($action) {
            case 'export01':
                return  $this->exportFutakuList($request->input('export01_from'), $request->input('export01_to'));
                break;
        }


    }

    protected function exportFutakuList($from, $to) {
        // ログインユーザ
        $user = Auth::user();

        // Excel 読み込み（Excel95 = Xls）
        $spreadsheet = IOFactory::load(resource_path('excel/template/futaku-list.xls'));
        $sheet = $spreadsheet->getActiveSheet();

        // セルに日付セット
        $sheet->setCellValue('C4', date('Y/m/d', strtotime($from)));
        $sheet->setCellValue('D4', date('Y/m/d', strtotime($to)));

        $maintenances = Maintenance::with([
                'branch',
                'trader'
            ])
            ->where(function ($q) use ($from, $to) {
                $q->whereBetween('conduct_commit_date', [$from, $to])
                ->orWhereBetween('commit_date', [$from, $to]);
            })
            ->when($user->role == MstUser::ROLE_USER, function ($q) use ($user) {
                $q->where('trader_cd', substr($user->login_id, 0, 3));
            })
            ->orderBy('toh_cd')
            ->get();

        $rowNo = 6;

        foreach ($maintenances as $maintenance) {
            $sheet->setCellValueByColumnAndRow(2, $rowNo, $maintenance->kddi_cd);
            $sheet->setCellValueByColumnAndRow(3, $rowNo, $maintenance->conduct_commit_date?->format('Y/m/d'));
            $sheet->setCellValueByColumnAndRow(4, $rowNo, $maintenance->commit_date?->format('Y/m/d'));
            $sheet->setCellValueByColumnAndRow(
                5,
                $rowNo,
                $maintenance->trader?->name
            );
            $sheet->setCellValueByColumnAndRow(
                6,
                $rowNo,
                $maintenance->branch?->name
            );

            $rowNo++;
        }

        // 一時ファイル保存
        $fileName = '付託リスト_' . date('Ymd') . '.xls';
        $tempPath = storage_path('app/' . $fileName);

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save($tempPath);

        // ダウンロードレスポンス
        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);

    }
}
