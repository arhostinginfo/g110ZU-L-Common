<?php
namespace App\Http\Controllers\Superadm;
use App\Http\Controllers\Controller;
use App\Models\Navbars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NavbarController extends Controller
{
    public function list()
    {
        $navbar = Navbars::where('is_deleted',0)
                ->orderBy('id', 'desc')
                ->get();
        return view('superadm.navbar.list', compact('navbar'));
    }

    public function add()
    {
        return view('superadm.navbar.create');
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
            $data['logo'] = $request->file('logo')->store('navbar', 'public');
            $data['name'] = $request->input('name');

            $data['footer_desc'] = $request->input('footer_desc');
            $data['address'] = $request->input('address');
            $data['contact_number'] = $request->input('contact_number');
            $data['email_id'] = $request->input('email_id');
            $data['color'] = $request->input('color');
            $data['lat'] = $request->input('lat');
            $data['lon'] = $request->input('lon');
        }

        Navbars::create($data);

        return redirect()->route('navbar.list')->with('success', 'Officer added successfully.');
    }

    public function edit($encodedId)
    {
        $id = base64_decode($encodedId);
        $navbar = Navbars::where('id', $id)->first();
        return view('superadm.navbar.edit', compact('navbar','encodedId'));
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
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:3072'
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
                // 'is_active' => $req->is_active
            ];

        $officer = Navbars::where('id', $id)->first();
        if ($request->hasFile('photo')) {
            // remove old if exists
            if ($officer->photo && Storage::disk('public')->exists($officer->photo)) {
                Storage::disk('public')->delete($officer->photo);
            }
            $data['photo'] = $request->file('photo')->store('navbar', 'public');
        }

        $officer->update($data);

        return redirect()->route('navbar.list')->with('success', 'Officer updated successfully.');
    }

    public function delete(Request $request)
    {
        $id = base64_decode($request->encodedId);
        $officer = Navbars::findOrFail($id);
        // delete file from storage if present
        if ($officer->photo && Storage::disk('public')->exists($officer->photo)) {
            Storage::disk('public')->delete($officer->photo);
        }

        $officer = Navbars::where ('id', $id)->update(['is_deleted' => 1]);

        return redirect()->route('navbar.list')->with('success', 'Officer deleted successfully.');
    }
}
