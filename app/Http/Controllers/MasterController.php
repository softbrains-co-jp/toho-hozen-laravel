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
use App\Models\MstApply;
use App\Models\MstUser;
use App\Models\MstKddiReport;
use App\Http\Requests\Master\EditRequest;


class MasterController extends Controller
{
    private $master;
    private $title;

    public function __construct()
    {
        if (Auth::check() && Auth::user()->role < MstUser::ROLE_TOHO) {
            abort(404);
        }
    }

    public function index($kind)
    {
        $this->setMaster($kind);
        $list = $this->master::orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->get();


        return view('master.index')
            ->with([
                'kind' => $kind,
                'title' => $this->title,
                'list' => $list
            ]);
    }

    public function edit($kind, $id = null)
    {
        $this->setMaster($kind);
        $data = new $this->master();
        if ($id) {
            $data = $this->master::find($id);
            if (!$data) {
                abort(404);
            }
        }

        return view('master.edit')
            ->with([
                'kind' => $kind,
                'title' => $this->title,
                'data' => $data
            ]);
    }

    public function post(EditRequest $request, $kind, $id = null)
    {
        $this->setMaster($kind);
        $data = new $this->master([
            'add_datetime' => now()
        ]);
        if ($id) {
            $data = $this->master::find($id);
            if (!$data) {
                abort(404);
            }
        }

        $data->fill($request->input());
        $data->edit_datetime = now();
        $data->save();

        return redirect()->route('master.index', ['kind' => $kind])->with('success', "データを更新しました。");
    }

    public function delete(Request $request, $kind)
    {
        $this->setMaster($kind);
        $id = $request->input('id');
        $data = $this->master::find($id);
        if (!$data) {
            abort(404);
        }

        $data->delete();

        return redirect()->route('master.index', ['kind' => $kind])->with('success', "データを削除しました。");
    }

    private function setMaster($kind) {
        switch ($kind) {
            case 'branch':
                $this->master = MstBranch::class;
                $this->title = '支社';
                break;
            case 'trader':
                $this->master = MstTrader::class;
                $this->title = '施工業者';
                break;
            case 'request':
                $this->master = MstRequest::class;
                $this->title = '依頼種別';
                break;
            case 'status':
                $this->master = MstStatus::class;
                $this->title = '工事進捗ステータス';
                break;
            case 'member':
                $this->master = MstMember::class;
                $this->title = 'チェック者';
                break;
            case 'setup':
                $this->master = MstSetup::class;
                $this->title = '移設種別';
                break;
            case 'road':
                $this->master = MstRoad::class;
                $this->title = '道路種別';
                break;
            case 'apply':
                $this->master = MstApply::class;
                $this->title = '申請種別';
                break;
            case 'kddi':
                $this->master = MstKddiReport::class;
                $this->title = 'KDDI報告種別';
                break;
            default:
                abort(404);
        }
    }

}
