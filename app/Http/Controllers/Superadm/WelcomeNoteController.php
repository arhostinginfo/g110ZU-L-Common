<?php
namespace App\Http\Controllers\Superadm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rule;
use Exception;
use App\Models\WelcomeNote;

class WelcomeNoteController extends Controller
{
	public function index()
	{
		try {
			$welcomenote = WelcomeNote::where('is_deleted', 0)
                ->orderBy('id', 'desc')
                ->get();
			return view('superadm.welcome-note.list', compact('welcomenote'));
		} catch (Exception $e) {
			dd($e->getMessage());
			return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
		}
	}

	public function create(Request $req)
	{
		try {
			return view('superadm.welcome-note.create');
		} catch (Exception $e) {
			return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
		}
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
            ];
			WelcomeNote::create($data);
			return redirect()->route('welcome-note.list')->with('success', 'Welcome note added successfully.');
		} catch (Exception $e) {
			dd($e->getMessage());
			return redirect()->back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
		}

	}

	public function edit($encodedId)
	{
		try {
			$id = base64_decode($encodedId);
			$data = WelcomeNote::where('id', $id)->first();;
			return view('superadm.welcome-note.edit', compact('data', 'encodedId'));
		} catch (Exception $e) {
			return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
		}
	}

	public function update(Request $req)
	{
		$req->validate([
			'title' => 'required|max:255',
			 'content' => 'required|max:5255',
			'id' => 'required',
			'is_active' => 'required'
		], [
			'title.required' => 'Enter maque content',
			'title.max' => 'Welcome note name must not exceed 255 characters.',
			'content.required' => 'Enter maque content',
			'content.max' => 'Welcome note name must not exceed 5255 characters.',
			'id.required' => 'ID required',
			'is_active.required' => 'Select active or inactive required',
		]);

		try {
			$id = $req->id;
            $data = [
                'title' => $req->input('title'),
                'content' => $req->input('content'),
                'is_active' => $req->is_active
            ];

			WelcomeNote::where('id', $id)->update($data);
			return redirect()->route('welcome-note.list')->with('success', 'Welcome note updated successfully.');
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
			WelcomeNote::where('id', $id)->update($data);
			return redirect()->route('welcome-note.list')->with('success', 'Welcome note deleted successfully.');
		} catch (Exception $e) {
			return redirect()->back()->with('error', 'Failed to delete role: ' . $e->getMessage());
		}
	}


	public function updateStatus(Request $req)
	{
		try {
			 $id = base64_decode($req->id);
            $data = ['is_active' => $req->is_active];
			WelcomeNote::where('id', $id)->update($data);
			return redirect()->route('welcome-note.list')->with('success', 'Welcome note status updated successfully.');
		} catch (Exception $e) {
			return redirect()->back()->with('error', 'Failed to update status: ' . $e->getMessage());
		}
	}
}
