<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Exclusion;
use App\Models\MstUser;

class ExclusionController extends Controller
{
    public function __construct()
    {
        if (Auth::check() && Auth::user()->role < MstUser::ROLE_TOHO) {
            abort(404);
        }
    }

    public function index()
    {
        $list = Exclusion::orderBy('add_datetime', 'asc')
            ->get();


        return view('exclusion.index')
            ->with([
                'list' => $list
            ]);
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
