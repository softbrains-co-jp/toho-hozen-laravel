<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\MstBranch;
use App\Models\MstSetup;
use App\Models\MstRequest;
use App\Models\MstRoad;
use App\Models\MstStatus;
use App\Models\MstTrader;
use App\Models\MstMember;
use App\Models\Exclusion;
use App\Models\Maintenance;
use App\Http\Requests\MainRequest;

class MainController extends Controller
{
    public function index($code = null)
    {
        // ログインユーザ
        $user = Auth::user();

        // 支社一覧
        $branches = MstBranch::orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->pluck('name', 'code')
            ->toArray();

        // 移設種別一覧
        $setups = MstSetup::orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->pluck('name', 'code')
            ->toArray();

        // 依頼種別一覧
        $requests = MstRequest::orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->pluck('name', 'code')
            ->toArray();

        // 道路種別一覧
        $roads = MstRoad::orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->pluck('name', 'code')
            ->toArray();

        // 工事進捗ステータス一覧
        $status = MstStatus::orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->pluck('name', 'code')
            ->toArray();

        // 施工業者一覧
        $traders = MstTrader::orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->pluck('name', 'code')
            ->toArray();

        // チェック者(担当者)一覧
        $members = MstMember::orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->pluck('name', 'code')
            ->toArray();

        $is_exclusion = false;
        $maintenance = new Maintenance();
        $seika_files = [];

        if (session('exclusion_toh_cd') && $code == null) {
            return redirect()->route('main.index', ['code' => session('exclusion_toh_cd')]);
        }

        if ($code) {
            $maintenance = Maintenance::where(function($query) use ($code) {
                $query->where('kddi_cd', $code)
                    ->orWhere('toh_cd', $code);
            })->first();

            if (!$maintenance) {
                return redirect()->route('main.index')->with('error', "該当の管理番号{$code}はありません。");
            }

            Exclusion::where('login_id', $user->login_id)
                ->delete();

            $is_exclusion = Exclusion::where('login_id', '!=', $user->login_id)
                ->where('toh_cd', $maintenance->toh_cd)
                ->exists();

            if ($is_exclusion) {
                session()->flash('info', "該当の管理番号{$code}は他の方が使用しています。読み取り専用で表示します。");
            }
            else {
                // 排他処理
                $exclusion = Exclusion::create([
                    'login_id' => $user->login_id,
                    'toh_cd' => $maintenance->toh_cd,
                    'add_datetime' => now(),
                    'edit_datetime' => now(),
                ]);

                session(['exclusion_toh_cd' => $maintenance->toh_cd]);
            }

            // 成果物リスト取得
            $seika_folder = config('hozen.seika_folder_path') . $maintenance->toh_cd;
            if (is_dir($seika_folder)) {
                $seika_files = File::files($seika_folder);
            }
        }

        return view('main.index')
            ->with(compact(
                'code',
                'branches',
                'setups',
                'requests',
                'roads',
                'status',
                'traders',
                'members',
                'is_exclusion',
                'maintenance',
                'seika_files',
            ));
    }

    public function post(MainRequest $request, $code)
    {
        // ログインユーザ
        $user = Auth::user();

        if ($code) {
            $maintenance = $this->getMaintenace($code);
            if (!$maintenance) {
                return redirect()->route('main.index')->with('error', "該当の管理番号{$code}はありません。");
            }

            // 排他チェック
            $is_exclusion = Exclusion::where('login_id', '!=', $user->login_id)
                ->where('toh_cd', $maintenance->toh_cd)
                ->exists();

            if ($is_exclusion) {
                return redirect()->route('main.index')->with('error', "該当の管理番号{$code}は他の方が使用しています。読み取り専用で表示します。");
            }

            $data = $request->except(['key_cd']);

            $maintenance->fill($data);
            $maintenance->save();

            return redirect()->route('main.index', ['code' => $code])->with('success', "データを更新しました。");
        }
    }

    public function release(MainRequest $request, $code)
    {
        // ログインユーザ
        $user = Auth::user();

        if ($code) {
            $maintenance = Maintenance::where(function($query) use ($code) {
                $query->where('kddi_cd', $code)
                    ->orWhere('toh_cd', $code);
            })->first();

            if (!$maintenance) {
                return redirect()->route('main.index')->with('error', "該当の管理番号{$code}はありません。");
            }

            // 排他チェック
            $is_exclusion = Exclusion::where('login_id', '!=', $user->login_id)
                ->where('toh_cd', $maintenance->toh_cd)
                ->exists();

            if ($is_exclusion) {
                return redirect()->route('main.index')->with('error', "該当の管理番号{$code}は他の方が使用しています。");
            }

            Exclusion::where('login_id', $user->login_id)
                ->delete();

            session()->forget('exclusion_toh_cd');

            return redirect()->route('main.index')->with('success', "データを解放しました。");
        }
    }

    public function download($code, $filename) {
        $maintenance = $this->getMaintenace($code);
        if (!$maintenance) {
            return redirect()->route('main.index')->with('error', "該当の管理番号{$code}はありません。");
        }

        $filename = basename($filename);
        $file_path = config('hozen.seika_folder_path') . $maintenance->toh_cd . '/' . $filename;
        if (!File::exists($file_path)) {
            return redirect()->route('main.index', ['code' => $code])->with('error', "ファイルが存在しません。");
        }

        // ダウンロードレスポンスを返す
        return response()->download($file_path, $filename);

    }

    private function getMaintenace($code) {
        $maintenance = Maintenance::where(function($query) use ($code) {
            $query->where('kddi_cd', $code)
                ->orWhere('toh_cd', $code);
        })->first();

        return $maintenance;
    }
}
