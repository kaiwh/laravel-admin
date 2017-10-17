<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Kaiwh\Admin\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Redirect;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin::login.index');
    }
    
    protected function guard()
    {
        return Auth::guard('admin');
    }
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return Redirect::route('admin');
    }
}
