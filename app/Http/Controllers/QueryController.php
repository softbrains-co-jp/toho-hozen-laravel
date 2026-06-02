<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
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

    public function exportCsv(Request $request)
    {
        $displayColumns = json_decode($request->input('display_columns', '[]'), true) ?? [];
        $conditions = json_decode($request->input('conditions', '[]'), true) ?? [];
        $downloadToken = $request->input('download_token', '');

        $allowedColumns = $this->getAllowedColumns();
        $columnLabels = Maintenance::COLUMN_LABELS;

        $selectColumns = collect($displayColumns)
            ->pluck('field')
            ->filter(fn($col) => isset($allowedColumns[$col]))
            ->values()
            ->toArray();

        $query = Maintenance::query()->select($selectColumns);

        foreach ($conditions as $condition) {
            $field = $condition['field'] ?? null;
            if (!$field || !isset($allowedColumns[$field])) {
                continue;
            }

            if (!empty($condition['is_null'])) {
                $query->whereNull($field);
            }
            if (!empty($condition['is_not_null'])) {
                $query->whereNotNull($field);
            }
            if (!empty($condition['is_empty'])) {
                $query->where($field, '');
            }
            if (!empty($condition['value'])) {
                $query->where($field, 'like', '%' . $condition['value'] . '%');
            }
            if (!empty($condition['sort'])) {
                $direction = (int)$condition['sort'] === 1 ? 'asc' : 'desc';
                $query->orderBy($field, $direction);
            }
        }

        $records = $query->get();
        $filename = 'query_' . now()->format('YmdHis') . '.csv';

        $callback = function () use ($records, $selectColumns, $columnLabels) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");
            fputcsv($handle, array_map(fn($col) => $columnLabels[$col] ?? $col, $selectColumns));
            foreach ($records as $record) {
                fputcsv($handle, array_map(fn($col) => $record->$col ?? '', $selectColumns));
            }
            fclose($handle);
        };

        if ($downloadToken) {
            Cookie::queue(Cookie::make('download_token', $downloadToken, 1, '/', null, false, false));
        }

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function getAllowedColumns(): array
    {
        return collect(DB::select(<<<'SQL'
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
            ->reject(fn($column) => in_array($column->name, Maintenance::HIDDEN_QUERY_COLUMNS, true))
            ->mapWithKeys(fn($column) => [$column->name => true])
            ->toArray();
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
