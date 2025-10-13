<?php

namespace App\Http\Controllers\GPAdmin;
use App\Http\Controllers\Controller;
use App\Models\Officers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class OfficerController extends Controller
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

    public function list()
    {
        $officers = Officers::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$this->gp_name_in_url,
					'gp_user_id'=>$this->gp_user_id,
				])
                ->orderBy('id', 'desc')
                ->get();
        return view('gpadmin.officers.list', compact('officers'));
    }

    public function add()
    {
        return view('gpadmin.officers.create');
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'designation' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'mobile' => ['required','string','max:15'],
            'email' => 'required|email|max:255',
            'type' => 'required|max:255', //Sadsya or officer
            'sequence_officer' => 'required|max:255', //sequence officer
            'sequence_general' => 'required|max:255', //sequence Sadsya
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:3072' // max 3MB
        ]);

        if ($request->hasFile('photo')) {
            // Save file to storage/app/public/officers
            $data['photo'] = $request->file('photo')->store('officers', 'public');
        }

        $data['gp_name_in_url']= $this->gp_name_in_url;
        $data['gp_user_id']= $this->gp_user_id;
        Officers::create($data);

        return redirect()->route('gpadmin.officers.list')->with('success', 'Officer added successfully.');
    }

    public function edit($encodedId)
    {
        $id = base64_decode($encodedId);
        $officer = Officers::where('id', $id)->first();
        return view('gpadmin.officers.edit', compact('officer','encodedId'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'encodedId' => 'required',
            'designation' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'mobile' => ['required','string','max:15'],
            'email' => 'required|email|max:255',
            'type' => 'required|max:255', //Sadsya or officer
            'sequence_officer' => 'required|max:255', //sequence officer
            'sequence_general' => 'required|max:255', //sequence Sadsya
        ]);


            $id = base64_decode($request->encodedId);
            $data = [
                'designation' => $request->input('designation'),
                'name' => $request->input('name'),
                'mobile' => $request->input('mobile'),
                'email' => $request->input('email'),
                'type' => $request->input('type'),
                'sequence_officer' => $request->input('sequence_officer'),
                'sequence_general' => $request->input('sequence_general'),
                // 'is_active' => $req->is_active,
                'gp_name_in_url'=>$this->gp_name_in_url,
				'gp_user_id'=>$this->gp_user_id,
            ];

        $officer = Officers::where('id', $id)->first();
        if ($request->hasFile('photo')) {
            // remove old if exists
            if ($officer->photo && Storage::disk('public')->exists($officer->photo)) {
                Storage::disk('public')->delete($officer->photo);
            }
            $data['photo'] = $request->file('photo')->store('officers', 'public');
        }

        $officer->update($data);

        return redirect()->route('gpadmin.officers.list')->with('success', 'Officer updated successfully.');
    }

    public function delete(Request $request)
    {
        $id = base64_decode($request->encodedId);
        $officer = Officers::findOrFail($id);
        // delete file from storage if present
        if ($officer->photo && Storage::disk('public')->exists($officer->photo)) {
            Storage::disk('public')->delete($officer->photo);
        }

        $officer = Officers::where ('id', $id)->update(['is_deleted' => 1]);
        return redirect()->route('gpadmin.officers.list')->with('success', 'Officer deleted successfully.');
    }
}
