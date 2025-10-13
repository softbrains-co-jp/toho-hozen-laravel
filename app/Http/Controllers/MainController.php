<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ));
    }

    public function post(MainRequest $request, $code)
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
                return redirect()->route('main.index')->with('error', "該当の管理番号{$code}は他の方が使用しています。読み取り専用で表示します。");
            }

            $data = $request->except(['key_cd']);

            $maintenance->fill($data);
            $maintenance->save();


        }
    }
}
