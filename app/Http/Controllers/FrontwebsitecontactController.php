<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frontwebsitecontact;

class FrontwebsitecontactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string|max:255',
            'mobile_no' => 'required|string|max:255'
        ]);

        Frontwebsitecontact::create($request->all());

        return redirect()->to(url()->previous() . '#contact')
                 ->with('success', 'आपला संदेश यशस्वीरित्या जतन झाला आहे!');
    }
}
