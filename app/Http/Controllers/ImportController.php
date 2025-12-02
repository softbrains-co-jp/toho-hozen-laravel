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
use App\Models\MstKddiReport;
use App\Models\Maintenance;
use App\Models\Exclusion;
use App\Http\Requests\Import\DailyReportRequest;

class ImportController extends Controller
{
    public function index(Request $request)
    {
        return view('import.index');
    }

    public function importDailyReport(DailyReportRequest $request) {

    }
}
