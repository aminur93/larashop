<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function index()
    {
        return view('front.login.index');
    }
    
    public function store(Request $request)
    {
        //validate the user
        
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        
        $request->validate($rules);
        
        //check if user exists
        $data = request(['email','password']);
        if (! auth()->attempt($data))
        {
            return back()->withErrors([
                'message' => 'Wrong credentials please try again'
            ]);
        }
        
        return redirect('/user/profile');
    }
    
    public function logout()
    {
        auth()->logout();
        
        session()->flash('msg','You have been logged out successfully');
        
        return redirect('/user/login');
    }
}
