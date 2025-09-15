<?php

namespace App\Http\Controllers\Superadm;
use App\Http\Controllers\Controller;
use App\Models\Yojna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class YojnaController extends Controller
{
    public function list()
    {
        $yojna = Yojna::where('is_deleted',0)
                ->orderBy('id', 'desc')
                ->get();
        return view('superadm.yojna.list', compact('yojna'));
    }

    public function add()
    {
        return view('superadm.yojna.create');
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type_attachment' => 'required|max:255', //Sadsya or officer
            'attachment' => 'nullable|mimes:jpeg,jpg,png,pdf,doc,docx,xls,xlsx|max:3072',
            'attachment_link'  => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('attachment')) {
            // Save file to storage/app/public/officers

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'type_attachment' => 'required|max:255', //Sadsya or officer
                'attachment' => 'nullable|mimes:jpeg,jpg,png,pdf,doc,docx,xls,xlsx|max:3072',
            ]);

            $data['attachment'] = $request->file('attachment')->store('yojna', 'public');
        }

        Yojna::create($data);

        return redirect()->route('yojna.list')->with('success', 'Officer added successfully.');
    }

    public function edit($encodedId)
    {
        $id = base64_decode($encodedId);
        $yojna = Yojna::where('id', $id)->first();
        return view('superadm.yojna.edit', compact('yojna','encodedId'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'encodedId' => 'required',
            'name' => 'required|string|max:255',
            'type_attachment' => 'required|max:255', //Sadsya or officer
        ]);


            $id = base64_decode($request->encodedId);
            $data = [
                'designation' => $request->input('designation'),
                'name' => $request->input('name'),
                'type_attachment' => $request->input('type_attachment'), 
                'attachment_link' => $request->input('attachment_link'), 
                // 'is_active' => $req->is_active
            ];

        $officer = Yojna::where('id', $id)->first();
        if ($request->hasFile('attachment')) {
            // remove old if exists
            if ($officer->attachment && Storage::disk('public')->exists($officer->attachment)) {
                Storage::disk('public')->delete($officer->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('yojna', 'public');
        }

        $officer->update($data);

        return redirect()->route('yojna.list')->with('success', 'Officer updated successfully.');
    }

    public function delete(Request $request)
    {
        $id = base64_decode($request->encodedId);
        $officer = Yojna::findOrFail($id);
        // delete file from storage if present
        if ($officer->attachment && Storage::disk('public')->exists($officer->attachment)) {
            Storage::disk('public')->delete($officer->attachment);
        }

        $officer = Yojna::where ('id', $id)->update(['is_deleted' => 1]);
        return redirect()->route('yojna.list')->with('success', 'Officer deleted successfully.');
    }
}
