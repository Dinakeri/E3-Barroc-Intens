<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Installation;
use App\Models\Maintenance;
use App\Models\Fault;
class maintenanceController extends Controller
{
    public function index()
    {
        $installationAmount = Installation::count();
        $maintenanceAmount = Maintenance::count();
        $incidentAmount = Fault::count();
        $recentMaintenances = Maintenance::orderByDesc('Date')
            ->take(8)
            ->get();

        return view('dashboards.maintenance', compact('installationAmount', 'maintenanceAmount', 'incidentAmount', 'recentMaintenances'));
    }
}
