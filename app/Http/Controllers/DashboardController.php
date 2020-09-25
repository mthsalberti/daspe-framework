<?php
namespace Daspeweb\Framework\Controller;

use App\DwModel;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function appCenter(){
        $dwModalColl = DwModel::all();
        $grouped = $dwModalColl->sortBy('app_center_group')->groupBy('app_center_group');
        return view('daspeweb::app_layout.dashboard.app-center')->with('grouped', $grouped);
    }
}
