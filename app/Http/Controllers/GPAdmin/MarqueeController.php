<?php
namespace App\Http\Controllers\GPAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rule;
use Exception;
use App\Models\Marquees;
use Illuminate\Support\Facades\Session;

class MarqueeController extends Controller
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
			$marquee = Marquees::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$this->gp_name_in_url,
					'gp_user_id'=>$this->gp_user_id,
				])
                ->orderBy('id', 'desc')
                ->get();
			return view('gpadmin.marques.list', compact('marquee'));
		} catch (Exception $e) {
			dd($e->getMessage());
			return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
		}
	}

	public function create(Request $req)
	{
		try {
			return view('gpadmin.marques.create');
		} catch (Exception $e) {
			return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
		}
	}

	public function save(Request $req)
	{

		$req->validate([
			 'message' => 'required|max:255',
		], [
			'message.required' => 'Enter maque content',
			'message.max' => 'Marque name must not exceed 255 characters.',
		]);

		try {
			$data = [
                'message' => $req->input('message'),
            ];
			$data['gp_name_in_url']= $this->gp_name_in_url;
			$data['gp_user_id']= $this->gp_user_id;
			Marquees::create($data);
			return redirect()->route('gpadmin.marquee.list')->with('success', 'Marque added successfully.');
		} catch (Exception $e) {
			dd($e->getMessage());
			return redirect()->back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
		}

	}

	public function edit($encodedId)
	{
		try {
			$id = base64_decode($encodedId);
			$data = Marquees::where('id', $id)->first();;
			return view('gpadmin.marques.edit', compact('data', 'encodedId'));
		} catch (Exception $e) {
			return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
		}
	}

	public function update(Request $req)
	{
		$req->validate([
			'message' => 'required|max:255',
			'id' => 'required',
			'is_active' => 'required'
		], [
			'message.required' => 'Enter Role Name',
			'message.max' => 'Marque name must not exceed 255 characters.',
			'id.required' => 'ID required',
			'is_active.required' => 'Select active or inactive required',
		]);

		try {
			$id = $req->id;
            $data = [
                'message' => $req->input('message'),
                'is_active' => $req->is_active,
				'gp_name_in_url'=>$this->gp_name_in_url,
				'gp_user_id'=>$this->gp_user_id,
            ];

			Marquees::where('id', $id)->update($data);
			return redirect()->route('gpadmin.marquee.list')->with('success', 'Marque updated successfully.');
		} catch (Exception $e) {
			dd($e->getMessage());
			return redirect()->back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
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
            $data = ['is_deleted' => 1];
			Marquees::where('id', $id)->update($data);
			return redirect()->route('gpadmin.marquee.list')->with('success', 'Marque deleted successfully.');
		} catch (Exception $e) {
			return redirect()->back()->with('error', 'Failed to delete role: ' . $e->getMessage());
		}
	}


	public function updateStatus(Request $req)
	{
		try {
			 $id = base64_decode($req->id);
            $data = ['is_active' => $req->is_active];
			Marquees::where('id', $id)->update($data);
			return redirect()->route('gpadmin.marquee.list')->with('success', 'Marque status updated successfully.');
		} catch (Exception $e) {
			return redirect()->back()->with('error', 'Failed to update status: ' . $e->getMessage());
		}
	}
}
