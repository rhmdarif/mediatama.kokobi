<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('admin.auth.login');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        $admin = DB::table('admins')->where('username', $request->username)->first();
        if($admin == null) {
            return back()->with("error", "Username tidak terdaftar");
        }

        if(!Hash::check($request->password, $admin->password)) {
            return back()->with("error", "Password anda salah");
        }

        request()->session()->put("admin", collect($admin)->except('password'));
        return redirect()->route('admin.home');
    }
}
