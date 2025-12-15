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
use App\Services\Export\FutakuListService;
use App\Services\Export\SagyouService;
use App\Services\Export\LocationService;
use App\Services\Export\ChokkinListService;
use App\Services\Export\NippouKddiService;
use App\Services\Export\ShunkouListService;
use App\Services\Export\CheckListService;
use App\Services\Export\IsetsuListService;

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

    public function post(
        ExportRequest $request,
        FutakuListService $futakuListService,
        SagyouService $sagyouService,
        LocationService $locationService,
        ChokkinListService $chokkinListService,
        NippouKddiService $nippouKddiService,
        ShunkouListService $shunkouListService,
        CheckListService $checkListService,
        IsetsuListService $isetsuListService
    ) {
        // ログインユーザ
        $user = Auth::user();

        $action = $request->input('action');
        switch ($action) {
            case 'export01':        // 付託リスト
                $from = $request->input('export01_from');
                $to = $request->input('export01_to');

                $spreadsheet = $futakuListService->makeExcel($from, $to, $user);
                $fileName = '付託リスト_' . date('Ymd') . '.xls';

                return $this->exportExcel($fileName, $spreadsheet);
                break;
            case 'export02_1':      // 保守作業報告
                $date = $request->input('export02');

                $spreadsheet = $sagyouService->makeExcel($date);
                $fileName = date('Ymd', strtotime($date)) . '_保守作業報告表.xls';

                return $this->exportExcel($fileName, $spreadsheet);
                break;
            case 'export02_2':      // 位置情報用
                $date = $request->input('export02');

                $txtData = $locationService->makeTxt($date);
                $fileName = date('Ymd', strtotime($date)) . '_位置情報.txt';

                return response($txtData)
                    ->header('Content-Type', 'application/octet-stream')
                    ->header('Content-Disposition', 'attachment; filename="'.$fileName.'"');
                break;
            case 'export03':        // 直近工期リスト
                $from = $request->input('export03_from');
                $to = $request->input('export03_to');

                $spreadsheet = $chokkinListService->makeExcel($from, $to, $user);
                $fileName = date('Ymd') . '_直近工期リスト.xls';

                return $this->exportExcel($fileName, $spreadsheet);
                break;
            case 'export04':      // 作業日報（KDDI提出用）
                $date = $request->input('export04');

                $spreadsheet = $nippouKddiService->makeExcel($date);
                $fileName = date('Ymd') . '_作業日報（KDDI提出用）.xls';

                return $this->exportExcel($fileName, $spreadsheet);
                break;
            case 'export05':      // 竣工成果物遅延リスト
                $spreadsheet = $shunkouListService->makeExcel();
                $fileName = '竣工成果物遅延リスト' . date('Ymd') . '.xls';

                return $this->exportExcel($fileName, $spreadsheet);
                break;
            case 'export06':      // チェック日リスト
                $date = $request->input('export06');

                $spreadsheet = $checkListService->makeExcel($date);
                $fileName = 'チェック日リスト.xls';

                return $this->exportExcel($fileName, $spreadsheet);
                break;
            case 'export07':      // 保守工事報告リスト
                $date = $request->input('export07');

                $spreadsheet = $isetsuListService->makeExcel($date);
                $fileName = '【TOH】移設工事報告リスト_' . date('Ymd', strtotime($date)) . '.xlsx';

                return $this->exportExcel($fileName, $spreadsheet, 'Xlsx');
                break;
        }
    }

    protected function exportExcel($fileName, $spreadsheet, $type = 'Xls') {
        $tempPath = storage_path('app/' . $fileName);

        $writer = IOFactory::createWriter($spreadsheet, $type);
        $writer->save($tempPath);

        return response()
            ->download($tempPath, $fileName)
            ->deleteFileAfterSend(true);
    }
}
