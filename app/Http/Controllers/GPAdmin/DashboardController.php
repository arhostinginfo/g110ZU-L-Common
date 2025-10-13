<?php
namespace App\Http\Controllers\GPAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\Superadm\DashboardService;
use App\Models\{
   Officers
};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    protected $gp_name_in_url;
    protected $gp_name;
    protected $gp_user_id;

    public function __construct()
   {
		$this->gp_name_in_url = Session::get('gp_name_in_url');
        $this->gp_name = Session::get('gp_name');
        $this->gp_user_id = Session::get('gp_user_id');
   }



     public function gplogin(Request $req)
    {
        try {
                $officers = Officers::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$this->gp_name_in_url,
					'gp_user_id'=>$this->gp_user_id,
				])->count();
                return view('gpadmin.dashboard-gp', compact(
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
