<?php
namespace App\Http\Controllers\GPAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rule;
use Exception;
use App\Models\ContactDakhala;
use Illuminate\Support\Facades\Session;

class DhakhalaController extends Controller
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

	public function index()
	{
		try {

			$abhiyans = ContactDakhala::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$this->gp_name_in_url,
					// 'gp_user_id'=>$this->gp_user_id,
				])
                ->orderBy('id', 'desc')
                ->get();
			return view('gpadmin.dakhala.list', compact('abhiyans'));
		} catch (Exception $e) {
			dd($e->getMessage());
			return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
		}
	}

	// public function create(Request $req)
	// {
	// 	try {
	// 		return view('gpadmin.abhiyan.create');
	// 	} catch (Exception $e) {
	// 		return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
	// 	}
	// }

	// public function save(Request $req)
	// {

	// 	$req->validate([
	// 		 'abhiyan_name' => 'required|max:255',
	// 		 'abhiyan_date' => 'required|max:255',
	// 	], [
	// 		'abhiyan_name.required' => 'Enter Abhiyan',
	// 		'abhiyan_name.max' => 'Abhiyan name must not exceed 255 characters.',
	// 		'abhiyan_date.required' => 'Select Date',
	// 	]);

	// 	try {
	// 		$data = [
    //             'abhiyan_name' => $req->input('abhiyan_name'),
    //             'abhiyan_date' => $req->input('abhiyan_date'),
	// 			'gp_name_in_url'=>$this->gp_name_in_url,
	// 			'gp_user_id'=>$this->gp_user_id,
    //         ];
	// 		Abhiyans::create($data);
	// 		return redirect()->route('gpadmin.abhiyan.list')->with('success', 'Abhiyan added successfully.');
	// 	} catch (Exception $e) {
	// 		dd($e->getMessage());
	// 		return redirect()->back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
	// 	}

	// }

	// public function edit($encodedId)
	// {
	// 	try {
	// 		$id = base64_decode($encodedId);
	// 		$data = Abhiyans::where('id', $id)->first();;
	// 		return view('gpadmin.abhiyan.edit', compact('data', 'encodedId'));
	// 	} catch (Exception $e) {
	// 		return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
	// 	}
	// }

	// public function update(Request $req)
	// {
	// 	$req->validate([
	// 		'abhiyan_name' => 'required|max:255',
	// 		'abhiyan_date' => 'required|max:255',
	// 		'id' => 'required',
	// 		'is_active' => 'required'
	// 	], [
	// 		'abhiyan_name.required' => 'Enter Abhiyan',
	// 		'abhiyan_name.max' => 'Abhiyan name must not exceed 255 characters.',
	// 		'abhiyan_date.required' => 'Select Date',
	// 		'id.required' => 'ID required',
	// 		'is_active.required' => 'Select active or inactive required',
	// 	]);

	// 	try {
	// 		$id = $req->id;
    //         $data = [
    //             'abhiyan_name' => $req->input('abhiyan_name'),
    //             'abhiyan_date' => $req->input('abhiyan_date'),
	// 			'gp_name_in_url'=>$this->gp_name_in_url,
	// 			'gp_user_id'=>$this->gp_user_id,
    //             'is_active' => $req->is_active
    //         ];

	// 		Abhiyans::where('id', $id)->update($data);
	// 		return redirect()->route('gpadmin.abhiyan.list')->with('success', 'Abhiyan updated successfully.');
	// 	} catch (Exception $e) {
	// 		dd($e->getMessage());
	// 		return redirect()->back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
	// 	}
	// }


	// public function delete(Request $req)
	// {
	// 	try {
	// 		$req->validate([
	// 			'id' => 'required',
	// 		], [
	// 			'id.required' => 'ID required'
	// 		]);

	// 		$id = base64_decode($req->id);
    //         $data = ['is_deleted' => 1];
	// 		Abhiyans::where('id', $id)->update($data);
	// 		return redirect()->route('gpadmin.abhiyan.list')->with('success', 'Abhiyan deleted successfully.');
	// 	} catch (Exception $e) {
	// 		return redirect()->back()->with('error', 'Failed to delete role: ' . $e->getMessage());
	// 	}
	// }


	public function updateStatus(Request $req)
	{
		try {
			// dd($req);
			 $id = base64_decode($req->id);
           $data = [
				'is_action_completed' => ($req->has('is_active') && $req->is_active) ? 0 : 1
			];
			ContactDakhala::where('id', $id)->update($data);
			return redirect()->route('gpadmin.dakhala.list')->with('success', 'Dakhala status updated successfully.');
		} catch (Exception $e) {
			dd($e->getMessage());
			return redirect()->back()->with('error', 'Failed to update status: ' . $e->getMessage());
		}
	}
}
