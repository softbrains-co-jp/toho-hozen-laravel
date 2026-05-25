<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Maintenance;
use App\Models\MstUser;
use App\Models\QueryPreset;

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
        $maintenance_columns = collect(DB::select(<<<'SQL'
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
        SQL, ['maintenance']))
            ->reject(fn ($column) => in_array($column->name, Maintenance::HIDDEN_QUERY_COLUMNS, true));

        $maintenance_column_labels = Maintenance::COLUMN_LABELS;
        $query_column_labels = $maintenance_columns
            ->mapWithKeys(fn ($column) => [
                $column->name => $maintenance_column_labels[$column->name] ?? $column->comment,
            ])
            ->toArray();

        $query_presets = QueryPreset::where('mst_user_id', Auth::id())
            ->orderBy('id')
            ->get(['id', 'name', 'display_columns', 'conditions']);
        $query_preset_options = $query_presets
            ->pluck('name', 'id')
            ->toArray();
        $query_preset_data = $query_presets
            ->mapWithKeys(fn ($preset) => [
                $preset->id => [
                    'id' => $preset->id,
                    'name' => $preset->name,
                    'display_columns' => $preset->display_columns ?? [],
                    'conditions' => $preset->conditions ?? [],
                ],
            ])
            ->toArray();

        return view('query.index', compact(
            'maintenance_columns',
            'maintenance_column_labels',
            'query_column_labels',
            'query_preset_options',
            'query_preset_data',
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'query_preset_id' => ['nullable', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'display_columns' => ['required', 'json'],
            'conditions' => ['required', 'json'],
        ]);

        $query_preset = new QueryPreset();
        if ($validated['query_preset_id'] ?? null) {
            $query_preset = QueryPreset::where('mst_user_id', Auth::id())
                ->findOrFail($validated['query_preset_id']);
        }

        $query_preset->fill([
            'name' => $validated['name'],
            'display_columns' => json_decode($validated['display_columns'], true),
            'conditions' => json_decode($validated['conditions'], true),
            'mst_user_id' => Auth::id(),
        ]);
        $query_preset->save();

        return redirect()->route('query.index')->with('success', 'クエリを保存しました。');
    }
}
