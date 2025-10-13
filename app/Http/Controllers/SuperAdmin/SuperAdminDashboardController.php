<?php
namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\Superadm\DashboardService;
use App\Models\{
   Officers
};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SuperAdminDashboardController extends Controller
{
    function __construct()
    {
        // $this->service=new DashboardService();
    }

    public function admin(Request $req)
    {
        try {
                $officers = Officers::where('is_deleted', 0)->count();
                return view('superadmin.dashboard.dashboard-admin', compact(
                    'officers',
                ));
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('DashboardController@index error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Show friendly error message
            return back()->with('error', 'Something went wrong while loading the dashboard. Please try again later.');
        }
    }


  
}
