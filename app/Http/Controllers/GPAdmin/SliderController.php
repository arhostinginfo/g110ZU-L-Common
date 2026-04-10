<?php

namespace App\Http\Controllers\GPAdmin;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class SliderController extends Controller
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
        $slider = Slider::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$this->gp_name_in_url,
					'gp_user_id'=>$this->gp_user_id,
				])
                ->orderBy('id', 'desc')
                ->get();
        return view('gpadmin.slider.list', compact('slider'));
    }

    public function add()
    {
        return view('gpadmin.slider.create');
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:3072' // max 3MB
        ]);

        if ($request->hasFile('photo')) {
            // Save file to storage/app/public/Slider
            $data['photo'] = $request->file('photo')->store($this->gp_name_in_url.'/slider', 'public');
            $data['name'] = $request->input('name');
        }
        $data['gp_name_in_url']= $this->gp_name_in_url;
        $data['gp_user_id']= $this->gp_user_id;
        $data['is_active'] = $request->input('is_active', 1);
        Slider::create($data);

        return redirect()->route('gpadmin.slider.list')->with('success', 'Officer added successfully.');
    }

    public function edit($encodedId)
    {
        $id = base64_decode($encodedId);
        $slider = Slider::where('id', $id)
            ->where('gp_user_id', $this->gp_user_id)
            ->firstOrFail();
        return view('gpadmin.slider.edit', compact('slider','encodedId'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'encodedId' => 'required',
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:3072'
        ]);


            $id = base64_decode($request->encodedId);
            $data = [
                'name' => $request->name,
                'is_active' => $request->input('is_active', 1),
            ];

        $officer = Slider::where('id', $id)
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
            $data['photo'] = $request->file('photo')->store($this->gp_name_in_url.'/slider', 'public');
        }

        $data['gp_name_in_url']= $this->gp_name_in_url;
        $data['gp_user_id']= $this->gp_user_id;
        
        $officer->update($data);

        return redirect()->route('gpadmin.slider.list')->with('success', 'Officer updated successfully.');
    }

    public function delete(Request $request)
    {
        $id = base64_decode($request->encodedId);
        $officer = Slider::where('id', $id)
            ->where('gp_user_id', $this->gp_user_id)
            ->firstOrFail();
        if ($officer->photo && Storage::disk('public')->exists($officer->photo)) {
            Storage::disk('public')->delete($officer->photo);
        }
        Slider::where('id', $id)->update(['is_deleted' => 1]);
        return redirect()->route('gpadmin.slider.list')->with('success', 'Slider deleted successfully.');
    }

    public function updateStatus(Request $request)
    {
        try {
            $id = base64_decode($request->id);
            Slider::where('id', $id)
                ->where('gp_user_id', $this->gp_user_id)
                ->update(['is_active' => $request->is_active]);
            return redirect()->route('gpadmin.slider.list')->with('success', 'Status updated successfully.');
        } catch (\Exception $e) {
            \Log::error('SliderController@updateStatus: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update status. Please try again.');
        }
    }
}
