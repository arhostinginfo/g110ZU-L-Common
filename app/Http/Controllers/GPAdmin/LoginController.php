<?php

namespace App\Http\Controllers\GPAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\Gpdetails;

class LoginController extends Controller
{
    public function loginsuper()
    {
        return view('gpadmin.login');
    }

    public function validateSuperLogin(Request $request)
    {
        $request->validate([
            'superemail'    => 'required|email',
            'superpassword' => 'required',
        ], [
            'superemail.required'    => 'Enter email address',
            'superemail.email'       => 'Enter a valid email address',
            'superpassword.required' => 'Enter password',
        ]);

        $uname = $request->input('superemail');
        $pass  = $request->input('superpassword');

        $result = Gpdetails::where('employee_email', $uname)
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->first();

        if (!$result) {
            return redirect()->back()->with('error', 'Invalid credentials.');
        }

        $passwordMatch = false;

        try {
            $passwordMatch = ($pass === Crypt::decryptString($result->employee_password));
        } catch (\Exception $e) {
            $passwordMatch = false;
        }

        if (!$passwordMatch) {
            return redirect()->back()->with('error', 'Invalid credentials.');
        }

        // Regenerate session ID to prevent session fixation attacks
        $request->session()->regenerate();

        Session::put('gp_name_in_url', $result->gp_name_in_url);
        Session::put('gp_name', $result->gp_name);
        Session::put('gp_user_id', $result->id);
        Session::put('email_id', $result->email);

        return redirect('gpadmin/dashboard-gp');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('login');
    }
}
