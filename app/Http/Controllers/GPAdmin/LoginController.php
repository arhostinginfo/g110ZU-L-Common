<?php

namespace App\Http\Controllers\GPAdmin;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use App\Models\Gpdetails;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
   public function __construct()
   {
   }

   public function loginsuper()
   {
      return view('gpadmin.login');
   }

   public function validateSuperLogin(Request $req)
   {
      $this->validateLogin($req);
      $uname = $req->input('superemail');
      $pass = $req->input('superpassword');
      $result = Gpdetails::where('employee_email', $uname)
         ->where('is_deleted', 0)
         ->where('is_active', 1)
         ->first();
      if ($result) {
         if (Hash::check($pass, $result->employee_password)) {

            Session::put('gp_name_in_url', $result->gp_name_in_url);
            Session::put('gp_name', $result->gp_name);
            Session::put('gp_user_id', $result->id);
            Session::put('email_id', $result->email);
            return redirect('gpadmin/dashboard-gp');
            
         } else {
            return redirect()->back()->with('error', 'User credentials not matching with records');
         }
      } else {
         return redirect()->back()->with('error', 'User not found contact to admin');
      }

   }

   public function validateLogin(Request $req)
   {
      $req->validate(
         [
            'superemail.required|email',
            'superpassword.required'
         ],
         [
            'superemail.email' => 'Enter proper email adddress',
            'superemail.required' => 'Enter email adddress',
            'superpassword.required' => 'Enter password'
         ]

      );
   }

   public function logOut(Request $req)
   {
      $req->session()->flush();
      return redirect('login');
   }

}
