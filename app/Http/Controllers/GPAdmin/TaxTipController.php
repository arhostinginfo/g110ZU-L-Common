<?php

namespace App\Http\Controllers\GPAdmin;

use App\Http\Controllers\Controller;
use App\Models\TaxTip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TaxTipController extends Controller
{
    protected $gp_name_in_url;
    protected $gp_user_id;

    public function __construct()
    {
        $this->gp_name_in_url = Session::get('gp_name_in_url');
        $this->gp_user_id     = Session::get('gp_user_id');
    }

    public function index()
    {
        $tips = TaxTip::where('gp_name_in_url', $this->gp_name_in_url)
            ->where('is_deleted', 0)
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('gpadmin.tax-tips.index', compact('tips'));
    }

    public function create()
    {
        return view('gpadmin.tax-tips.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tip_text' => 'required|string',
        ]);

        TaxTip::create([
            'gp_name_in_url' => $this->gp_name_in_url,
            'gp_user_id'     => $this->gp_user_id,
            'tip_text'       => $request->tip_text,
            'is_active'      => $request->input('is_active', 1),
            'is_deleted'     => 0,
        ]);

        return redirect()->route('gpadmin.gp-tax.tips.index')->with('success', 'टीप यशस्वीरित्या जोडली.');
    }

    public function edit($id)
    {
        $tip = TaxTip::where('id', $id)
            ->where('gp_name_in_url', $this->gp_name_in_url)
            ->where('is_deleted', 0)
            ->firstOrFail();

        return view('gpadmin.tax-tips.edit', compact('tip'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tip_text' => 'required|string',
        ]);

        $tip = TaxTip::where('id', $id)
            ->where('gp_name_in_url', $this->gp_name_in_url)
            ->where('is_deleted', 0)
            ->firstOrFail();

        $tip->update([
            'tip_text'  => $request->tip_text,
            'is_active' => $request->input('is_active', 1),
        ]);

        return redirect()->route('gpadmin.gp-tax.tips.index')->with('success', 'टीप यशस्वीरित्या अद्यतनित केली.');
    }

    public function destroy($id)
    {
        $tip = TaxTip::where('id', $id)
            ->where('gp_name_in_url', $this->gp_name_in_url)
            ->firstOrFail();

        $tip->update(['is_deleted' => 1]);

        return redirect()->route('gpadmin.gp-tax.tips.index')->with('success', 'टीप यशस्वीरित्या हटवली.');
    }
}
