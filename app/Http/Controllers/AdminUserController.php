<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admins')->except('logout');
    }
    
    public function index()
    {
        return view('admin.login');
    }
    
    public function store(Request $request)
    {
        //validate the front
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        //log the front in
        $credentials = $request->only('email', 'password');
        
        if(! Auth::guard('admins')->attempt($credentials))
        {
            return back()->withErrors([
                'message' => 'Wrong Credentials please try again'
            ]);
        }
        
        //session message
        session()->flash('msg','You have been logged In');
        
        //redirect
        return redirect('/admins');
    }
    
    public function logout()
    {
        \auth()->guard('admins')->logout();
        
        session()->flash('msg','You have been logged out');
        
        return redirect('/admins/login');
    }
}
