<?php
namespace App\Http\Controllers\GPAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
			\Log::error('MarqueeController@index: ' . $e->getMessage());
			return redirect()->back()->with('error', 'Something went wrong. Please try again.');
		}
	}

	public function create(Request $req)
	{
		return view('gpadmin.marques.create');
	}

	public function save(Request $req)
	{
		$req->validate([
			 'message' => 'required|max:255',
		], [
			'message.required' => 'Enter marquee content',
			'message.max' => 'Marquee name must not exceed 255 characters.',
		]);

		try {
			$data = [
                'message' => $req->input('message'),
                'is_active' => $req->input('is_active', 1),
				'gp_name_in_url' => $this->gp_name_in_url,
				'gp_user_id' => $this->gp_user_id,
            ];
			Marquees::create($data);
			return redirect()->route('gpadmin.marquee.list')->with('success', 'Marquee added successfully.');
		} catch (Exception $e) {
			\Log::error('MarqueeController@save: ' . $e->getMessage());
			return redirect()->back()->withInput()->with('error', 'Something went wrong. Please try again.');
		}
	}

	public function edit($encodedId)
	{
		$id = base64_decode($encodedId);
		$data = Marquees::where('id', $id)
			->where('gp_user_id', $this->gp_user_id)
			->firstOrFail();
		return view('gpadmin.marques.edit', compact('data', 'encodedId'));
	}

	public function update(Request $req)
	{
		$req->validate([
			'message' => 'required|max:255',
			'id' => 'required',
			'is_active' => 'required'
		], [
			'message.required' => 'Enter marquee content',
			'message.max' => 'Marquee name must not exceed 255 characters.',
			'id.required' => 'ID required',
			'is_active.required' => 'Select active or inactive required',
		]);

		try {
			$id = $req->id;
            $data = [
                'message' => $req->input('message'),
                'is_active' => $req->is_active,
				'gp_name_in_url' => $this->gp_name_in_url,
				'gp_user_id' => $this->gp_user_id,
            ];
			Marquees::where('id', $id)
				->where('gp_user_id', $this->gp_user_id)
				->update($data);
			return redirect()->route('gpadmin.marquee.list')->with('success', 'Marquee updated successfully.');
		} catch (Exception $e) {
			\Log::error('MarqueeController@update: ' . $e->getMessage());
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
			Marquees::where('id', $id)
				->where('gp_user_id', $this->gp_user_id)
				->update(['is_deleted' => 1]);
			return redirect()->route('gpadmin.marquee.list')->with('success', 'Marquee deleted successfully.');
		} catch (Exception $e) {
			\Log::error('MarqueeController@delete: ' . $e->getMessage());
			return redirect()->back()->with('error', 'Failed to delete. Please try again.');
		}
	}

	public function updateStatus(Request $req)
	{
		try {
			$id = base64_decode($req->id);
			Marquees::where('id', $id)
				->where('gp_user_id', $this->gp_user_id)
				->update(['is_active' => $req->is_active]);
			return redirect()->route('gpadmin.marquee.list')->with('success', 'Marquee status updated successfully.');
		} catch (Exception $e) {
			\Log::error('MarqueeController@updateStatus: ' . $e->getMessage());
			return redirect()->back()->with('error', 'Failed to update status. Please try again.');
		}
	}
}
