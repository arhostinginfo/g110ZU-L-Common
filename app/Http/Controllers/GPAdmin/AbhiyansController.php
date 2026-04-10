<?php
namespace App\Http\Controllers\GPAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rule;
use Exception;
use App\Models\Abhiyans;
use Illuminate\Support\Facades\Session;

class AbhiyansController extends Controller
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
			$abhiyans = Abhiyans::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$this->gp_name_in_url,
					'gp_user_id'=>$this->gp_user_id,
				])
                ->orderBy('id', 'desc')
                ->get();
			return view('gpadmin.abhiyan.list', compact('abhiyans'));
		} catch (Exception $e) {
			\Log::error('AbhiyansController@index: ' . $e->getMessage());
			return redirect()->back()->with('error', 'Something went wrong. Please try again.');
		}
	}

	public function create(Request $req)
	{
		return view('gpadmin.abhiyan.create');
	}

	public function save(Request $req)
	{
		$req->validate([
			 'abhiyan_name' => 'required|max:255',
			 'abhiyan_date' => 'required|max:255',
		], [
			'abhiyan_name.required' => 'Enter Abhiyan',
			'abhiyan_name.max' => 'Abhiyan name must not exceed 255 characters.',
			'abhiyan_date.required' => 'Select Date',
		]);

		try {
			$data = [
                'abhiyan_name' => $req->input('abhiyan_name'),
                'abhiyan_date' => $req->input('abhiyan_date'),
                'is_active' => $req->input('is_active', 1),
				'gp_name_in_url'=>$this->gp_name_in_url,
				'gp_user_id'=>$this->gp_user_id,
            ];
			Abhiyans::create($data);
			return redirect()->route('gpadmin.abhiyan.list')->with('success', 'Abhiyan added successfully.');
		} catch (Exception $e) {
			\Log::error('AbhiyansController@save: ' . $e->getMessage());
			return redirect()->back()->withInput()->with('error', 'Something went wrong. Please try again.');
		}
	}

	public function edit($encodedId)
	{
		$id = base64_decode($encodedId);
		$data = Abhiyans::where('id', $id)
			->where('gp_user_id', $this->gp_user_id)
			->firstOrFail();
		return view('gpadmin.abhiyan.edit', compact('data', 'encodedId'));
	}

	public function update(Request $req)
	{
		$req->validate([
			'abhiyan_name' => 'required|max:255',
			'abhiyan_date' => 'required|max:255',
			'id' => 'required',
			'is_active' => 'required'
		], [
			'abhiyan_name.required' => 'Enter Abhiyan',
			'abhiyan_name.max' => 'Abhiyan name must not exceed 255 characters.',
			'abhiyan_date.required' => 'Select Date',
			'id.required' => 'ID required',
			'is_active.required' => 'Select active or inactive required',
		]);

		try {
			$id = $req->id;
            $data = [
                'abhiyan_name' => $req->input('abhiyan_name'),
                'abhiyan_date' => $req->input('abhiyan_date'),
				'gp_name_in_url'=>$this->gp_name_in_url,
				'gp_user_id'=>$this->gp_user_id,
                'is_active' => $req->is_active
            ];
			Abhiyans::where('id', $id)
				->where('gp_user_id', $this->gp_user_id)
				->update($data);
			return redirect()->route('gpadmin.abhiyan.list')->with('success', 'Abhiyan updated successfully.');
		} catch (Exception $e) {
			\Log::error('AbhiyansController@update: ' . $e->getMessage());
			return redirect()->back()->withInput()->with('error', 'Something went wrong. Please try again.');
		}
	}

	public function delete(Request $req)
	{
		try {
			$req->validate([
				'id' => 'required',
			], [
				'id.required' => 'ID required'
			]);

			$id = base64_decode($req->id);
			Abhiyans::where('id', $id)
				->where('gp_user_id', $this->gp_user_id)
				->update(['is_deleted' => 1]);
			return redirect()->route('gpadmin.abhiyan.list')->with('success', 'Abhiyan deleted successfully.');
		} catch (Exception $e) {
			\Log::error('AbhiyansController@delete: ' . $e->getMessage());
			return redirect()->back()->with('error', 'Failed to delete. Please try again.');
		}
	}

	public function updateStatus(Request $req)
	{
		try {
			$id = base64_decode($req->id);
			Abhiyans::where('id', $id)
				->where('gp_user_id', $this->gp_user_id)
				->update(['is_active' => $req->is_active]);
			return redirect()->route('gpadmin.abhiyan.list')->with('success', 'Abhiyan status updated successfully.');
		} catch (Exception $e) {
			\Log::error('AbhiyansController@updateStatus: ' . $e->getMessage());
			return redirect()->back()->with('error', 'Failed to update status. Please try again.');
		}
	}
}
