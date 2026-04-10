<?php

namespace App\Http\Controllers\GPAdmin;
use App\Http\Controllers\Controller;
use App\Models\Famouslocations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class FamousLocationController extends Controller
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
        $famouslocations = Famouslocations::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$this->gp_name_in_url,
					'gp_user_id'=>$this->gp_user_id,
				])
                ->orderBy('id', 'desc')
                ->get();
        return view('gpadmin.famous-locations.list', compact('famouslocations'));
    }

    public function add()
    {
        return view('gpadmin.famous-locations.create');
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string|max:5255',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:3072' // max 3MB
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store($this->gp_name_in_url.'/famouslocations', 'public');
            $data['name'] = $request->input('name');
            $data['desc'] = $request->input('desc');
        }

        $data['gp_name_in_url']= $this->gp_name_in_url;
        $data['gp_user_id']= $this->gp_user_id;
        $data['is_active'] = $request->input('is_active', 1);

        Famouslocations::create($data);

        return redirect()->route('gpadmin.famous-locations.list')->with('success', 'Officer added successfully.');
    }

    public function edit($encodedId)
    {
        $id = base64_decode($encodedId);
        $famouslocations = Famouslocations::where('id', $id)
            ->where('gp_user_id', $this->gp_user_id)
            ->firstOrFail();
        return view('gpadmin.famous-locations.edit', compact('famouslocations','encodedId'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'encodedId' => 'required',
            'name' => 'required|string|max:255',
            'desc' => 'required|string|max:5255',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:3072'
        ]);


            $id = base64_decode($request->encodedId);
            $data = [
                'name' => $request->name,
                'desc' => $request->desc,
                'is_active' => $request->input('is_active', 1),
                'gp_name_in_url'=>$this->gp_name_in_url,
				'gp_user_id'=>$this->gp_user_id,
            ];

        $officer = Famouslocations::where('id', $id)
            ->where('gp_user_id', $this->gp_user_id)
            ->firstOrFail();
        if ($request->hasFile('photo')) {
            // remove old if exists
             $data = $request->validate([
                'photo' => 'required|image|mimes:jpeg,jpg,png|max:3072'
            ]);

            if ($officer->photo && Storage::disk('public')->exists($officer->photo)) {
                Storage::disk('public')->delete($officer->photo);
            }
            $data['photo'] = $request->file('photo')->store($this->gp_name_in_url.'/famouslocations', 'public');
        }

        $officer->update($data);

        return redirect()->route('gpadmin.famous-locations.list')->with('success', 'Officer updated successfully.');
    }

    public function delete(Request $request)
    {
        $id = base64_decode($request->encodedId);
        $officer = Famouslocations::where('id', $id)
            ->where('gp_user_id', $this->gp_user_id)
            ->firstOrFail();
        if ($officer->photo && Storage::disk('public')->exists($officer->photo)) {
            Storage::disk('public')->delete($officer->photo);
        }
        Famouslocations::where('id', $id)->update(['is_deleted' => 1]);
        return redirect()->route('gpadmin.famous-locations.list')->with('success', 'Location deleted successfully.');
    }

    public function updateStatus(Request $request)
    {
        try {
            $id = base64_decode($request->id);
            Famouslocations::where('id', $id)
                ->where('gp_user_id', $this->gp_user_id)
                ->update(['is_active' => $request->is_active]);
            return redirect()->route('gpadmin.famous-locations.list')->with('success', 'Status updated successfully.');
        } catch (\Exception $e) {
            \Log::error('FamousLocationController@updateStatus: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update status. Please try again.');
        }
    }
}
