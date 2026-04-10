<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use App\Models\Gpdetails;

class AdminLoginController extends Controller
{
    public function loginsuper()
    {
        return view('superadmin.adminlogin');
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

        $result = Admin::where('employee_email', $uname)
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->first();

        if (!$result) {
            return redirect()->back()->with('error', 'Invalid credentials.');
        }

        $passwordMatch = false;

        // 1. Try bcrypt (passwords updated via change-password form)
        try {
            if (Hash::check($pass, $result->employee_password)) {
                $passwordMatch = true;
            }
        } catch (\Exception $e) {
            // not a bcrypt hash, fall through
        }

        // 2. Fall back to legacy Crypt encryption
        if (!$passwordMatch) {
            try {
                $passwordMatch = ($pass === Crypt::decryptString($result->employee_password));
            } catch (\Exception $e) {
                $passwordMatch = false;
            }
        }

        if (!$passwordMatch) {
            return redirect()->back()->with('error', 'Invalid credentials.');
        }

        // Regenerate session ID to prevent session fixation attacks
        $request->session()->regenerate();

        Session::put('super_user_id', $result->id);
        Session::put('email_id', $result->email);

        return redirect('superadmin/dashboard-admin');
    }

    public function supergpautologin(Request $request)
    {
        $request->validate([
            'gp_id' => 'required|integer',
        ]);

        $gp_id = $request->input('gp_id');
        $result = Gpdetails::where('id', $gp_id)
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->first();

        if (!$result) {
            return redirect()->back()->with('error', 'GP not found or inactive.');
        }

        // Regenerate session to isolate the new GP session
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
        return redirect('adminlogin');
    }
}
