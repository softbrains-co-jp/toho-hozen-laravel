<?php

namespace App\View\Components\Main;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

use App\Models\MstApply;
use App\Models\MstKddiReport;

class SubmissionInfo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $user = Auth::user();

        $time_cds = [
            'AM' => '午前',
            'PM' => '午後',
            'AP' => '終日',
        ];

        // チェック者(担当者)一覧
        $applies = MstApply::orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->pluck('name', 'code')
            ->toArray();

        // KDDI報告種別一覧
        $kddi_reports = MstKddiReport::orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->pluck('name', 'code')
            ->toArray();

        return view('components.main.submission-info')
            ->with(compact(
                'time_cds',
                'applies',
                'kddi_reports',
            ));
    }
}
