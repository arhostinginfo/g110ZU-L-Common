<?php
namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\Superadm\DashboardService;
use App\Models\{Officers, Gpdetails};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

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

                // ── GP stats for dashboard ──
                $gpdetails = Gpdetails::leftJoin('districts', 'gpdetails.gp_under_district', '=', 'districts.id')
                    ->leftJoin('talukas', 'gpdetails.gp_under_taluka', '=', 'talukas.id')
                    ->where('gpdetails.is_deleted', 0)
                    ->select('gpdetails.*', 'districts.district_name', 'talukas.taluka_name')
                    ->get();

                $today = Carbon::today();
                $gpdetails->map(function ($gp) use ($today) {
                    $validTill = Carbon::parse($gp->gp_valid_till);
                    $gp->is_expired = $today->gt($validTill->copy()->startOfDay());
                    return $gp;
                });

                $gpStats = [
                    'total'    => $gpdetails->count(),
                    'active'   => $gpdetails->filter(fn($g) => (int)$g->is_active === 1 && !$g->is_expired)->count(),
                    'inactive' => $gpdetails->filter(fn($g) => (int)$g->is_active === 0 && !$g->is_expired)->count(),
                    'expired'  => $gpdetails->filter(fn($g) => $g->is_expired)->count(),
                ];

                $gpDistrictStats = $gpdetails
                    ->groupBy('district_name')
                    ->map(function ($rows, $district) {
                        return [
                            'district' => $district ?: '(Not Set)',
                            'total'    => $rows->count(),
                            'active'   => $rows->filter(fn($g) => (int)$g->is_active === 1 && !$g->is_expired)->count(),
                            'inactive' => $rows->filter(fn($g) => (int)$g->is_active === 0 && !$g->is_expired)->count(),
                            'expired'  => $rows->filter(fn($g) => $g->is_expired)->count(),
                        ];
                    })
                    ->sortBy('district')
                    ->values();

                $gpTalukaStats = $gpdetails
                    ->groupBy('taluka_name')
                    ->map(function ($rows, $taluka) {
                        return [
                            'district' => $rows->first()->district_name ?: '(Not Set)',
                            'taluka'   => $taluka ?: '(Not Set)',
                            'total'    => $rows->count(),
                            'active'   => $rows->filter(fn($g) => (int)$g->is_active === 1 && !$g->is_expired)->count(),
                            'inactive' => $rows->filter(fn($g) => (int)$g->is_active === 0 && !$g->is_expired)->count(),
                            'expired'  => $rows->filter(fn($g) => $g->is_expired)->count(),
                        ];
                    })
                    ->sortBy(['district', 'taluka'])
                    ->values();

                return view('superadmin.dashboard.dashboard-admin', compact(
                    'officers', 'gpStats', 'gpDistrictStats', 'gpTalukaStats'
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
