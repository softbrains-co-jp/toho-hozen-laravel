<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\MstBranch;
use App\Models\MstSetup;
use App\Models\MstRequest;
use App\Models\MstRoad;
use App\Models\MstStatus;
use App\Models\MstTrader;
use App\Models\MstMember;
use App\Models\Exclusion;
use App\Models\Maintenance;

class HomeController extends Controller
{
    public function index()
    {

        return view('home.index');
    }
}
