<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

use App\Models\Maintenance;
use App\Models\MstApply;
use App\Models\MstBranch;
use App\Models\MstKddiReport;
use App\Models\MstMember;
use App\Models\MstRequest;
use App\Models\MstRoad;
use App\Models\MstSetup;
use App\Models\MstStatus;
use App\Models\MstTrader;
use App\Models\MstUser;
use App\Models\QueryPreset;

class QueryController extends Controller
{
    public function __construct()
    {
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

        $query_presets = QueryPreset::query()
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

        $query_column_meta = $this->buildColumnMeta();

        return view('query.index', compact(
            'maintenance_columns',
            'maintenance_column_labels',
            'query_column_labels',
            'query_preset_options',
            'query_preset_data',
            'query_column_meta',
        ));
    }

    public function search(Request $request)
    {
        $displayColumns = json_decode($request->input('display_columns', '[]'), true) ?? [];
        $conditions = json_decode($request->input('conditions', '[]'), true) ?? [];

        $allowedColumns = $this->getAllowedColumns();
        $columnLabels = Maintenance::COLUMN_LABELS;

        $selectColumns = collect($displayColumns)
            ->pluck('field')
            ->filter(fn($col) => isset($allowedColumns[$col]))
            ->values()
            ->toArray();

        $queryColumns = $this->mergeWithSortColumns($selectColumns, $conditions, $allowedColumns);
        $query = Maintenance::query()->distinct()->select($queryColumns);
        $this->applyConditions($query, $conditions, $allowedColumns);

        $limit = 1001;
        $records = $query->limit($limit)->get();
        $exceeded = $records->count() >= $limit;
        if ($exceeded) {
            $records = $records->take(1000);
        }

        $masterOptions = $this->buildMasterOptions();
        return view('query.search', compact('records', 'selectColumns', 'columnLabels', 'exceeded', 'masterOptions'));
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

        $queryColumns = $this->mergeWithSortColumns($selectColumns, $conditions, $allowedColumns);
        $query = Maintenance::query()->distinct()->select($queryColumns);
        $this->applyConditions($query, $conditions, $allowedColumns);

        $records = $query->get();
        $masterOptions = $this->buildMasterOptions();
        $filename = 'query_' . now()->format('YmdHis') . '.csv';

        $callback = function () use ($records, $selectColumns, $columnLabels, $masterOptions) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");
            fputcsv($handle, array_map(fn($col) => $columnLabels[$col] ?? $col, $selectColumns));
            foreach ($records as $record) {
                fputcsv($handle, array_map(fn($col) => $masterOptions[$col][$record->$col] ?? $record->$col ?? '', $selectColumns));
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

    private function mergeWithSortColumns(array $selectColumns, array $conditions, array $allowedColumns): array
    {
        $sortFields = collect($conditions)
            ->filter(fn($c) => !empty($c['sort']) && isset($allowedColumns[$c['field'] ?? '']))
            ->pluck('field')
            ->toArray();

        return array_values(array_unique(array_merge($selectColumns, $sortFields)));
    }

    private function applyConditions(\Illuminate\Database\Eloquent\Builder $query, array $conditions, array $allowedColumns): void
    {
        foreach ($conditions as $condition) {
            $field = $condition['field'] ?? null;
            if (!$field || !isset($allowedColumns[$field])) {
                continue;
            }

            $type = $condition['type'] ?? 'text';
            $whereCallbacks = $this->buildConditionCallbacks($field, $type, $condition);

            if ($whereCallbacks) {
                $query->where(function ($orQuery) use ($whereCallbacks) {
                    foreach ($whereCallbacks as $index => $callback) {
                        $index === 0
                            ? $orQuery->where($callback)
                            : $orQuery->orWhere($callback);
                    }
                });
            }

            if (!empty($condition['sort'])) {
                $direction = (int)$condition['sort'] === 1 ? 'asc' : 'desc';
                $query->orderBy($field, $direction);
            }
        }
    }

    private function buildConditionCallbacks(string $field, string $type, array $condition): array
    {
        $callbacks = [];

        if (!empty($condition['is_null'])) {
            $callbacks[] = fn ($q) => $q->whereNull($field);
        }
        if (!empty($condition['is_not_null'])) {
            $callbacks[] = fn ($q) => $q->whereNotNull($field);
        }
        if ($type !== 'date' && !empty($condition['is_empty'])) {
            $callbacks[] = fn ($q) => $q->where($field, '');
        }

        if ($type === 'date') {
            $dateFrom = $condition['date_from'] ?? '';
            $dateTo = $condition['date_to'] ?? '';
            if ($dateFrom !== '' || $dateTo !== '') {
                $callbacks[] = function ($q) use ($field, $dateFrom, $dateTo) {
                    if ($dateFrom !== '') {
                        $q->whereDate($field, '>=', Carbon::parse($dateFrom)->format('Y-m-d'));
                    }
                    if ($dateTo !== '') {
                        $q->whereDate($field, '<=', Carbon::parse($dateTo)->format('Y-m-d'));
                    }
                };
            }
        } elseif ($type === 'master') {
            if (array_key_exists('value', $condition) && $condition['value'] !== '') {
                $callbacks[] = fn ($q) => $q->where($field, $condition['value']);
            }
        } elseif (array_key_exists('value', $condition) && $condition['value'] !== '') {
            $callbacks[] = !empty($condition['is_like'])
                ? fn ($q) => $q->where($field, 'like', $this->buildLikePattern((string)$condition['value']))
                : fn ($q) => $q->where($field, $condition['value']);
        }

        return $callbacks;
    }

    private function buildLikePattern(string $value): string
    {
        $pattern = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $value);

        return '%' . $pattern . '%';
    }

    private function buildMasterOptions(): array
    {
        $members = MstMember::orderBy('code')->pluck('name', 'code')->toArray();
        return [
            'branch_cd'          => MstBranch::orderBy('code')->pluck('name', 'code')->toArray(),
            'trader_cd'          => MstTrader::orderBy('code')->pluck('name', 'code')->toArray(),
            'status_cd'          => MstStatus::orderBy('code')->pluck('name', 'code')->toArray(),
            'request_cd'         => MstRequest::orderBy('code')->pluck('name', 'code')->toArray(),
            'setup_cd'           => MstSetup::orderBy('code')->pluck('name', 'code')->toArray(),
            'apply_type'         => MstApply::orderBy('code')->pluck('name', 'code')->toArray(),
            'kddi_report_type'   => MstKddiReport::orderBy('code')->pluck('name', 'code')->toArray(),
            'road_cd'            => MstRoad::orderBy('code')->pluck('name', 'code')->toArray(),
            'check_mcd'          => $members,
            'conduct_start_mcd'  => $members,
            'conduct_end_mcd'    => $members,
            't_setup_start_mcd'  => $members,
            't_setup_finish_mcd' => $members,
            'setup_start_mcd'    => $members,
            'setup_finish_mcd'   => $members,
        ];
    }

    private function buildColumnMeta(): array
    {
        $masterOptions = $this->buildMasterOptions();

        $meta = [];

        $dateCols = array_keys(array_filter(
            (new Maintenance())->getCasts(),
            fn($cast) => str_starts_with($cast, 'date:')
        ));
        foreach ($dateCols as $col) {
            $meta[$col] = ['type' => 'date'];
        }
        foreach ($masterOptions as $col => $options) {
            $meta[$col] = ['type' => 'master', 'options' => $options];
        }

        return $meta;
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

    public function destroy(int $id)
    {
        QueryPreset::findOrFail($id)->delete();

        return redirect()->route('query.index')->with('success', 'クエリを削除しました。');
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
