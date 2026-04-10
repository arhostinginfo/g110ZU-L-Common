<?php
namespace App\Http\Controllers\GPAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Exception;
use App\Models\WelcomeNote;
use Illuminate\Support\Facades\Session;

class WelcomeNoteController extends Controller
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
			$welcomenote = WelcomeNote::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$this->gp_name_in_url,
					'gp_user_id'=>$this->gp_user_id,
				])
                ->orderBy('id', 'desc')
                ->get();
			return view('gpadmin.welcome-note.list', compact('welcomenote'));
		} catch (Exception $e) {
			\Log::error('WelcomeNoteController@index: ' . $e->getMessage());
			return redirect()->back()->with('error', 'Something went wrong. Please try again.');
		}
	}

	public function create(Request $req)
	{
		return view('gpadmin.welcome-note.create');
	}

	public function save(Request $req)
	{
		$req->validate([
			 'title' => 'required|max:255',
			 'content' => 'required|max:5255',
		], [
			'title.required' => 'Enter welcome note title',
			'title.max' => 'Welcome note name must not exceed 255 characters.',
			'content.required' => 'Enter welcome note content',
			'content.max' => 'Welcome note name must not exceed 5255 characters.',
		]);

		try {
			$data = [
                'title' => $req->input('title'),
                'content' => $req->input('content'),
                'is_active' => $req->input('is_active', 1),
				'gp_name_in_url' => $this->gp_name_in_url,
				'gp_user_id' => $this->gp_user_id,
            ];
			WelcomeNote::create($data);
			return redirect()->route('gpadmin.welcome-note.list')->with('success', 'Welcome note added successfully.');
		} catch (Exception $e) {
			\Log::error('WelcomeNoteController@save: ' . $e->getMessage());
			return redirect()->back()->withInput()->with('error', 'Something went wrong. Please try again.');
		}
	}

	public function edit($encodedId)
	{
		$id = base64_decode($encodedId);
		$data = WelcomeNote::where('id', $id)
			->where('gp_user_id', $this->gp_user_id)
			->firstOrFail();
		return view('gpadmin.welcome-note.edit', compact('data', 'encodedId'));
	}

	public function update(Request $req)
	{
		$req->validate([
			'title' => 'required|max:255',
			 'content' => 'required|max:5255',
			'id' => 'required',
			'is_active' => 'required'
		], [
			'title.required' => 'Enter welcome note title',
			'title.max' => 'Welcome note name must not exceed 255 characters.',
			'content.required' => 'Enter welcome note content',
			'content.max' => 'Welcome note name must not exceed 5255 characters.',
			'id.required' => 'ID required',
			'is_active.required' => 'Select active or inactive required',
		]);

		try {
			$id = $req->id;
            $data = [
                'title' => $req->input('title'),
                'content' => $req->input('content'),
                'is_active' => $req->is_active,
				'gp_name_in_url' => $this->gp_name_in_url,
				'gp_user_id' => $this->gp_user_id,
            ];
			WelcomeNote::where('id', $id)
				->where('gp_user_id', $this->gp_user_id)
				->update($data);
			return redirect()->route('gpadmin.welcome-note.list')->with('success', 'Welcome note updated successfully.');
		} catch (Exception $e) {
			\Log::error('WelcomeNoteController@update: ' . $e->getMessage());
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
			WelcomeNote::where('id', $id)
				->where('gp_user_id', $this->gp_user_id)
				->update(['is_deleted' => 1]);
			return redirect()->route('gpadmin.welcome-note.list')->with('success', 'Welcome note deleted successfully.');
		} catch (Exception $e) {
			\Log::error('WelcomeNoteController@delete: ' . $e->getMessage());
			return redirect()->back()->with('error', 'Failed to delete. Please try again.');
		}
	}

	public function updateStatus(Request $req)
	{
		try {
			$id = base64_decode($req->id);
			WelcomeNote::where('id', $id)
				->where('gp_user_id', $this->gp_user_id)
				->update(['is_active' => $req->is_active]);
			return redirect()->route('gpadmin.welcome-note.list')->with('success', 'Welcome note status updated successfully.');
		} catch (Exception $e) {
			\Log::error('WelcomeNoteController@updateStatus: ' . $e->getMessage());
			return redirect()->back()->with('error', 'Failed to update status. Please try again.');
		}
	}
}
