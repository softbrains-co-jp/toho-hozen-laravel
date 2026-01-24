<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Exclusion;
use App\Models\MstTrader;
use App\Models\MstUser;
use App\Http\Requests\User\EditRequest;

class UserController extends Controller
{
    public function __construct()
    {
        if (Auth::check() && Auth::user()->role !== MstUser::ROLE_ADMIN) {
            abort(404);
        }
    }

    public function index()
    {
        $list = MstUser::orderBy('id', 'asc')
            ->get();


        return view('user.index')
            ->with([
                'list' => $list
            ]);
    }

    public function edit($id = null)
    {
        $user = new MstUser();
        if ($id) {
            $user = MstUser::find($id);
            if (!$user) {
                abort(404);
            }
        }

        // 施工業者一覧
        $traders = MstTrader::orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->pluck('name', 'code')
            ->toArray();

        return view('user.edit')
            ->with(compact(
                'user',
                'traders'
            ));
    }

    public function post(EditRequest $request, $id = null)
    {
        $data = $request->input();

        $user = new MstUser();
        if ($id) {
            $user = MstUser::find($id);
            if (!$user) {
                abort(404);
            }
        }

        $user->fill($request->input());
        $user->password = $user->password ?: $user->getOriginal('password');
        $user->save();

        return redirect()->route('user.index')->with('success', "データを更新しました。");
    }

    public function delete(Request $request)
    {
        $toh_cd = $request->input('toh_cd');
        $data = Exclusion::where('toh_cd', $toh_cd);
        if (!$data) {
            abort(404);
        }
        $data->delete();

        return redirect()->route('exclusion.index')->with('success', "データを削除しました。");
    }
}
