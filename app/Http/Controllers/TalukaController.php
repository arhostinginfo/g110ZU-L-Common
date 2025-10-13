<?php
namespace App\Http\Controllers;

use App\Models\Taluka;
use App\Models\District;
use Illuminate\Http\Request;

class TalukaController extends Controller
{
    public function index()
    {
        $talukas = Taluka::with('district')->get();
        return view('talukas.index', compact('talukas'));
    }

    public function create()
    {
        $districts = District::where('is_active', true)->where('is_deleted', false)->get();
        return view('talukas.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'taluka_name' => 'required',
            'district_id' => 'required|exists:districts,id',
        ]);

        Taluka::create($request->all());
        return redirect()->route('talukas.index')->with('success', 'Taluka created successfully.');
    }

    public function edit(Taluka $taluka)
    {
        $districts = District::where('is_active', true)->where('is_deleted', false)->get();
        return view('talukas.edit', compact('taluka', 'districts'));
    }

    public function update(Request $request, Taluka $taluka)
    {
        $request->validate([
            'taluka_name' => 'required',
            'district_id' => 'required|exists:districts,id',
        ]);

        $taluka->update($request->all());
        return redirect()->route('talukas.index')->with('success', 'Taluka updated successfully.');
    }

    public function destroy(Taluka $taluka)
    {
        $taluka->delete();
        return redirect()->route('talukas.index')->with('success', 'Taluka deleted successfully.');
    }
}
