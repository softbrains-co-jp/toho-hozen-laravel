<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\MstBranch;
use App\Models\MstTrader;
use App\Models\MstRequest;
use App\Models\MstStatus;
use App\Models\MstMember;
use App\Models\MstSetup;
use App\Models\MstRoad;
use App\Models\MstUser;
use App\Models\Maintenance;
use App\Models\Exclusion;


class SearchController extends Controller
{
    protected const MAX_ROW = 100;

    public function index(Request $request)
    {
        $condition = $request->input();

        // 一般ユーザの場合、施工業者は固定
        if (Auth::user()->role == MstUser::ROLE_USER) {
            $condition['trader_cd'] = Auth::user()->trader_cd;
        }

        $list = [];
        $query = Maintenance::query();
        $query = $this->setCondition($query, $condition);
        if ($query) {
            $list = $query->with('trader')
                ->whereNotNull('kddi_cd')
                ->orderBy('toh_cd', 'asc')
                ->limit(self::MAX_ROW)
                ->get();
        }

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

        return view('search.index')
            ->with(compact(
                'condition',
                'branches',
                'setups',
                'requests',
                'roads',
                'status',
                'traders',
                'members',
                'list',
            ));
    }

    private function setCondition($query, $condition)
    {
        if (!array_key_exists('kddi_cd', $condition)) return false;

        // KDDI管理番号
        if ($condition['kddi_cd']) {
            $query->whereLike('kddi_cd', "%{$condition['kddi_cd']}%");
        }

        // TOH管理番号
        if ($condition['toh_cd']) {
            $query->whereLike('toh_cd', "%{$condition['toh_cd']}%");
        }

        // 支社
        if ($condition['branch_cd']) {
            $query->where('branch_cd', $condition['branch_cd']);
        }

        // 現場住所
        if ($condition['work_address']) {
            $query->whereLike('work_address', "%{$condition['work_address']}%");
        }

        // 施工業者
        if ($condition['trader_cd']) {
            $query->where('trader_cd', $condition['trader_cd']);
        }

        // 工事進捗ステータス
        if ($condition['status_cd']) {
            $query->where('status_cd', $condition['status_cd']);
        }

        // 工事進捗ステータス
        if ($condition['road_cd']) {
            $query->where('road_cd', $condition['road_cd']);
        }

        // 電柱番号
        if ($condition['pole_cd']) {
            $query->whereLike('pole_cd', "%{$condition['pole_cd']}%");
        }

        // チェック日(From)
        if ($condition['check_date_from']) {
            $query->where('check_date', '>=', $condition['check_date_from']);
        }

        // チェック日(To)
        if ($condition['check_date_to']) {
            $query->where('check_date', '<=', $condition['check_date_to']);
        }

        // チェック者
        if ($condition['check_mcd']) {
            $query->where('check_mcd', $condition['check_mcd']);
        }

        // 本工期（自）(From)
        if ($condition['term_start_date_from']) {
            $query->where('term_start_date', '>=', $condition['term_start_date_from']);
        }

        // 本工期（自）(To)
        if ($condition['term_start_date_to']) {
            $query->where('term_start_date', '<=', $condition['term_start_date_to']);
        }

        // 本工期（至）(From)
        if ($condition['term_end_date_from']) {
            $query->where('term_end_date', '>=', $condition['term_end_date_from']);
        }

        // 本工期（至）(To)
        if ($condition['term_end_date_to']) {
            $query->where('term_end_date', '<=', $condition['term_end_date_to']);
        }

        // 本工期（自）変更後(From)
        if ($condition['term2_start_date_from']) {
            $query->where('term2_start_date', '>=', $condition['term2_start_date_from']);
        }

        // 本工期（自）変更後(To)
        if ($condition['term2_start_date_to']) {
            $query->where('term2_start_date', '<=', $condition['term2_start_date_to']);
        }

        // 本工期（至）変更後(From)
        if ($condition['term2_end_date_from']) {
            $query->where('term2_end_date', '>=', $condition['term2_end_date_from']);
        }

        // 本工期（至）変更後(To)
        if ($condition['term2_end_date_to']) {
            $query->where('term2_end_date', '<=', $condition['term2_end_date_to']);
        }

        // 仮工期（自）(From)
        if ($condition['t_term_start_date_from']) {
            $query->where('t_term_start_date', '>=', $condition['t_term_start_date_from']);
        }

        // 仮工期（自）(To)
        if ($condition['t_term_start_date_to']) {
            $query->where('t_term_start_date', '<=', $condition['t_term_start_date_to']);
        }

        // 仮工期（至）(From)
        if ($condition['t_term_end_date_from']) {
            $query->where('t_term_end_date', '>=', $condition['t_term_end_date_from']);
        }

        // 仮工期（至）(To)
        if ($condition['t_term_end_date_to']) {
            $query->where('t_term_end_date', '<=', $condition['t_term_end_date_to']);
        }

        // 仮工期（自）変更後(From)
        if ($condition['t_term2_start_date_from']) {
            $query->where('t_term2_start_date', '>=', $condition['t_term2_start_date_from']);
        }

        // 仮工期（自）変更後(To)
        if ($condition['t_term2_start_date_to']) {
            $query->where('t_term2_start_date', '<=', $condition['t_term2_start_date_to']);
        }

        // 仮工期（至）変更後(From)
        if ($condition['t_term2_end_date_from']) {
            $query->where('t_term2_end_date', '>=', $condition['t_term2_end_date_from']);
        }

        // 仮工期（至）変更後(To)
        if ($condition['t_term2_end_date_to']) {
            $query->where('t_term2_end_date', '<=', $condition['t_term2_end_date_to']);
        }

        // KDDI依頼日(From)
        if ($condition['kddi_oder_date_from']) {
            $query->where('kddi_oder_date', '>=', $condition['kddi_oder_date_from']);
        }

        // KDDI依頼日(To)
        if ($condition['kddi_oder_date_to']) {
            $query->where('kddi_oder_date', '<=', $condition['kddi_oder_date_to']);
        }

        // 工事付託日(From)
        if ($condition['commit_date_from']) {
            $query->where('commit_date', '>=', $condition['commit_date_from']);
        }

        // 工事付託日(To)
        if ($condition['commit_date_to']) {
            $query->where('commit_date', '<=', $condition['commit_date_to']);
        }

        // 調査付託日(From)
        if ($condition['conduct_commit_date_from']) {
            $query->where('conduct_commit_date', '>=', $condition['conduct_commit_date_from']);
        }

        // 調査付託日(To)
        if ($condition['conduct_commit_date_to']) {
            $query->where('conduct_commit_date', '<=', $condition['conduct_commit_date_to']);
        }

        return $query;
    }

    public function delete(Request $request)
    {
        $code = $request->input('code');
// dd($code);
        $url_query = $request->input('url_query', []);
        // URLクエリ文字列に変換
        $url_query = http_build_query($request->input('url_query', []));


        // ログインユーザ
        $user = Auth::user();

        $maintenance = Maintenance::where('toh_cd', $code)
            ->first();
        if (!$maintenance) {
            return redirect()->to(route('search.index') . ($url_query ? "?{$url_query}" : ''))
                ->with('error', "該当の管理番号{$code}はありません。");
        }

        // 排他チェック
        $is_exclusion = Exclusion::where('login_id', '!=', $user->login_id)
            ->where('toh_cd', $maintenance->toh_cd)
            ->exists();

        if ($is_exclusion) {
            return redirect()->to(route('search.index') . ($url_query ? "?{$url_query}" : ''))
                ->with('error', "該当の管理番号{$code}は他の方が使用しています。");
        }

        $maintenance->delete();

        return redirect()->to(route('search.index') . ($url_query ? "?{$url_query}" : ''))
            ->with('success', "データを削除しました。");
    }
}
