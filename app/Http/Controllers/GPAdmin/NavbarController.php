<?php
namespace App\Http\Controllers\GPAdmin;
use App\Http\Controllers\Controller;
use App\Models\Navbars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class NavbarController extends Controller
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
        $navbar = Navbars::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$this->gp_name_in_url,
					'gp_user_id'=>$this->gp_user_id,
				])
                ->orderBy('id', 'desc')
                ->get();
        return view('gpadmin.navbar.list', compact('navbar'));
    }

    public function add()
    {
        return view('gpadmin.navbar.create');
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            
			'footer_desc' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'email_id' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'lat' => 'required|string|max:255',
            'lon' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:3072' // max 3MB
        ]);

        if ($request->hasFile('logo')) {
            // Save file to storage/app/public/Slider
            $data['logo'] = $request->file('logo')->store($this->gp_name_in_url.'/navbar', 'public');
            $data['name'] = $request->input('name');

            $data['footer_desc'] = $request->input('footer_desc');
            $data['address'] = $request->input('address');
            $data['contact_number'] = $request->input('contact_number');
            $data['email_id'] = $request->input('email_id');
            $data['color'] = $request->input('color');
            $data['lat'] = $request->input('lat');
            $data['lon'] = $request->input('lon');
        }

        $data['gp_name_in_url']= $this->gp_name_in_url;
        $data['gp_user_id']= $this->gp_user_id;
        $data['is_active'] = $request->input('is_active', 1);
        Navbars::create($data);

        return redirect()->route('gpadmin.navbar.list')->with('success', 'Officer added successfully.');
    }

    public function edit($encodedId)
    {
        $id = base64_decode($encodedId);
        $navbar = Navbars::where('id', $id)
            ->where('gp_user_id', $this->gp_user_id)
            ->firstOrFail();
        return view('gpadmin.navbar.edit', compact('navbar','encodedId'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'encodedId' => 'required',
			'footer_desc' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'email_id' => 'required|string|max:255',
			'color' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'lat' => 'required|string|max:255',
            'lon' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:3072'
        ]);


            $id = base64_decode($request->encodedId);
            $data = [
                'name' => $request->name,
				'footer_desc' =>$request->footer_desc,
				'address' =>$request->address,
				'contact_number' =>$request->contact_number,
				'email_id' =>$request->email_id,
				'color' =>$request->color,
				'lat' =>$request->lat,
				'lon' =>$request->lon,
                'is_active' => $request->input('is_active', 1),
                'gp_name_in_url'=>$this->gp_name_in_url,
				'gp_user_id'=>$this->gp_user_id,
            ];

        $officer = Navbars::where('id', $id)
            ->where('gp_user_id', $this->gp_user_id)
            ->firstOrFail();
        if ($request->hasFile('logo')) {
            // remove old if exists
            if ($officer->logo && Storage::disk('public')->exists($officer->logo)) {
                Storage::disk('public')->delete($officer->logo);
            }
            $data['logo'] = $request->file('logo')->store($this->gp_name_in_url.'/navbar', 'public');
        }

        $officer->update($data);

        return redirect()->route('gpadmin.navbar.list')->with('success', 'Officer updated successfully.');
    }

    public function delete(Request $request)
    {
        $id = base64_decode($request->encodedId);
        $officer = Navbars::where('id', $id)
            ->where('gp_user_id', $this->gp_user_id)
            ->firstOrFail();
        if ($officer->logo && Storage::disk('public')->exists($officer->logo)) {
            Storage::disk('public')->delete($officer->logo);
        }
        Navbars::where('id', $id)->update(['is_deleted' => 1]);
        return redirect()->route('gpadmin.navbar.list')->with('success', 'Website details deleted successfully.');
    }

    public function updateStatus(Request $request)
    {
        try {
            $id = base64_decode($request->id);
            Navbars::where('id', $id)
                ->where('gp_user_id', $this->gp_user_id)
                ->update(['is_active' => $request->is_active]);
            return redirect()->route('gpadmin.navbar.list')->with('success', 'Status updated successfully.');
        } catch (\Exception $e) {
            \Log::error('NavbarController@updateStatus: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update status. Please try again.');
        }
    }
}
