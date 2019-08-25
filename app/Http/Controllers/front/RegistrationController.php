<?php

namespace App\Http\Controllers\front;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('front.register.index');
    }
    
    public function store(Request $request)
    {
        //validate the user
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'address' => 'required'
        ]);
        
        //save the data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'address' => $request->address
        ]);
        
        //sign the user in
        auth()->login($user);
        
        //redirect
        return redirect('/user/login');
    }
}
