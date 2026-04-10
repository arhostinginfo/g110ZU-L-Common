<?php
namespace App\Http\Controllers;

use App\Models\Taluka;
use App\Models\District;
use Illuminate\Http\Request;

class TalukaController extends Controller
{
    public function index()
    {
        $talukas = Taluka::with('district')->where('is_deleted', 0)->get();
        return view('superadmin.talukas.index', compact('talukas'));
    }

    public function create()
    {
        $districts = District::where('is_active', true)->where('is_deleted', false)->get();
        return view('superadmin.talukas.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'taluka_name' => 'required',
            'district_id' => 'required|exists:districts,id',
        ]);

        Taluka::create([
            'taluka_name' => $request->taluka_name,
            'district_id' => $request->district_id,
            'is_active'   => $request->input('is_active', 1),
            'is_deleted'  => 0,
        ]);

        return redirect()->route('talukas.index')->with('success', 'Taluka created successfully.');
    }

    public function edit(Taluka $taluka)
    {
        $districts = District::where('is_active', true)->where('is_deleted', false)->get();
        return view('superadmin.talukas.edit', compact('taluka', 'districts'));
    }

    public function update(Request $request, Taluka $taluka)
    {
        $request->validate([
            'taluka_name' => 'required',
            'district_id' => 'required|exists:districts,id',
        ]);

        $taluka->update([
            'taluka_name' => $request->taluka_name,
            'district_id' => $request->district_id,
            'is_active'   => $request->input('is_active', 1),
        ]);

        return redirect()->route('talukas.index')->with('success', 'Taluka updated successfully.');
    }

    public function destroy(Taluka $taluka)
    {
        $taluka->update(['is_deleted' => 1]);
        return redirect()->route('talukas.index')->with('success', 'Taluka deleted successfully.');
    }

    public function updateStatus(Request $request, Taluka $taluka)
    {
        $taluka->update(['is_active' => $request->input('is_active', 0)]);
        return redirect()->route('talukas.index')->with('success', 'Status updated successfully.');
    }
}
