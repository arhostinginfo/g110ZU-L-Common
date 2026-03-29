<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frontwebsitecontact;
use App\Models\Gpdetails;

class FrontwebsitecontactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email',
            'message'    => 'required|string|max:255',
            'mobile_no'  => 'required|string|max:255',
            'gp_name_in_url' => 'required|string',
        ]);

        $gp = Gpdetails::where('gp_name_in_url', $request->gp_name_in_url)->first();

        Frontwebsitecontact::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'message'        => $request->message,
            'mobile_no'      => $request->mobile_no,
            'gp_name_in_url' => $request->gp_name_in_url,
            'gp_user_id'     => $gp ? $gp->id : 0,
        ]);

        return redirect()->to(url()->previous() . '#contact')
                 ->with('success', 'आपला संदेश यशस्वीरित्या जतन झाला आहे!');
    }
}
