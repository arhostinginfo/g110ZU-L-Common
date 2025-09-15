<?php

namespace App\Http\Controllers\Superadm;
use App\Http\Controllers\Controller;
use App\Models\Famouslocations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FamousLocationController extends Controller
{
    public function list()
    {
        $famouslocations = Famouslocations::where('is_deleted',0)
                ->orderBy('id', 'desc')
                ->get();
        return view('superadm.famous-locations.list', compact('famouslocations'));
    }

    public function add()
    {
        return view('superadm.famous-locations.create');
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string|max:5255',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:3072' // max 3MB
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('famouslocations', 'public');
            $data['name'] = $request->input('name');
            $data['desc'] = $request->input('desc');
        }

        Famouslocations::create($data);

        return redirect()->route('famous-locations.list')->with('success', 'Officer added successfully.');
    }

    public function edit($encodedId)
    {
        $id = base64_decode($encodedId);
        $famouslocations = Famouslocations::where('id', $id)->first();
        return view('superadm.famous-locations.edit', compact('famouslocations','encodedId'));
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
                'desc' => $request->desc
                // 'is_active' => $req->is_active
            ];

        $officer = Famouslocations::where('id', $id)->first();
        if ($request->hasFile('photo')) {
            // remove old if exists
             $data = $request->validate([
                'photo' => 'required|image|mimes:jpeg,jpg,png|max:3072'
            ]);

            if ($officer->photo && Storage::disk('public')->exists($officer->photo)) {
                Storage::disk('public')->delete($officer->photo);
            }
            $data['photo'] = $request->file('photo')->store('famouslocations', 'public');
        }

        $officer->update($data);

        return redirect()->route('famous-locations.list')->with('success', 'Officer updated successfully.');
    }

    public function delete(Request $request)
    {
        $id = base64_decode($request->encodedId);
        $officer = Famouslocations::findOrFail($id);
        // delete file from storage if present
        if ($officer->photo && Storage::disk('public')->exists($officer->photo)) {
            Storage::disk('public')->delete($officer->photo);
        }

        $officer = Famouslocations::where ('id', $id)->update(['is_deleted' => 1]);

        return redirect()->route('famous-locations.list')->with('success', 'Officer deleted successfully.');
    }
}
