<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\MstUser;

class QueryController extends Controller
{
    public function __construct()
    {
        if (Auth::check() && Auth::user()->role !== MstUser::ROLE_ADMIN) {
            abort(404);
        }
    }

    public function index()
    {
        $maintenance_columns = DB::select(<<<'SQL'
            SELECT
                a.attname AS name,
                col_description(a.attrelid, a.attnum) AS comment
            FROM pg_attribute a
            INNER JOIN pg_class c ON c.oid = a.attrelid
            INNER JOIN pg_namespace n ON n.oid = c.relnamespace
            WHERE c.relname = ?
                AND n.nspname = ANY (current_schemas(false))
                AND a.attnum > 0
                AND NOT a.attisdropped
            ORDER BY a.attnum
        SQL, ['maintenance']);

        return view('query.index', compact('maintenance_columns'));
    }
}
