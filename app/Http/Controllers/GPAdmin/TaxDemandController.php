<?php

namespace App\Http\Controllers\GPAdmin;

use App\Http\Controllers\Controller;
use App\Models\TaxDemand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TaxDemandController extends Controller
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

    public function index()
    {
        $demands = TaxDemand::where('gp_name_in_url', $this->gp_name_in_url)
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('gpadmin.tax-demands.index', compact('demands'));
    }

    public function create()
    {
        return view('gpadmin.tax-demands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tax_type'         => 'required|in:ghar_patti,paani_patti,other',
            'year'             => 'required|integer|min:2000|max:2099',
            'period'           => 'required|in:magil,chalu',
            'demand_amount'    => 'required|numeric|min:0',
            'collected_amount' => 'required|numeric|min:0',
        ]);

        $percentage = 0;
        if ($request->demand_amount > 0) {
            $percentage = round(($request->collected_amount / $request->demand_amount) * 100, 2);
        }

        TaxDemand::create([
            'gp_name_in_url'   => $this->gp_name_in_url,
            'tax_type'         => $request->tax_type,
            'year'             => $request->year,
            'period'           => $request->period,
            'demand_amount'    => $request->demand_amount,
            'collected_amount' => $request->collected_amount,
            'percentage'       => $percentage,
        ]);

        return redirect()->route('gpadmin.gp-tax.demands.index')->with('success', 'कर मागणी यशस्वीरित्या जोडली.');
    }

    public function edit($id)
    {
        $demand = TaxDemand::where('id', $id)
            ->where('gp_name_in_url', $this->gp_name_in_url)
            ->firstOrFail();

        return view('gpadmin.tax-demands.edit', compact('demand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tax_type'         => 'required|in:ghar_patti,paani_patti,other',
            'year'             => 'required|integer|min:2000|max:2099',
            'period'           => 'required|in:magil,chalu',
            'demand_amount'    => 'required|numeric|min:0',
            'collected_amount' => 'required|numeric|min:0',
        ]);

        $demand = TaxDemand::where('id', $id)
            ->where('gp_name_in_url', $this->gp_name_in_url)
            ->firstOrFail();

        $percentage = 0;
        if ($request->demand_amount > 0) {
            $percentage = round(($request->collected_amount / $request->demand_amount) * 100, 2);
        }

        $demand->update([
            'tax_type'         => $request->tax_type,
            'year'             => $request->year,
            'period'           => $request->period,
            'demand_amount'    => $request->demand_amount,
            'collected_amount' => $request->collected_amount,
            'percentage'       => $percentage,
        ]);

        return redirect()->route('gpadmin.gp-tax.demands.index')->with('success', 'कर मागणी यशस्वीरित्या अद्यतनित केली.');
    }

    public function destroy($id)
    {
        $demand = TaxDemand::where('id', $id)
            ->where('gp_name_in_url', $this->gp_name_in_url)
            ->firstOrFail();

        $demand->delete();

        return redirect()->route('gpadmin.gp-tax.demands.index')->with('success', 'कर मागणी यशस्वीरित्या हटवली.');
    }
}
