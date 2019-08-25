<?php

namespace App\Http\Controllers\front;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    public function index()
    {
        $id = auth()->user()->id;
        
        $users = User::where('id',$id)->first();
        return view('front.profile.index',compact('users'));
    }
    
    public function show($id)
    {
        $order = Order::find($id);
        
        return view('front.profile.details',compact('order'));
    }
    
    public function edit($id)
    {
        $user = User::find($id);
        return view('front.profile.edit',compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        //validate the user
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'address' => 'required'
        ]);
    
        //save the data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'address' => $request->address
        ]);
        
         //sessions message
        $request->session()->flash('msg','User Profile Has Been Updated');
        //redirect page
        return redirect('/user/profile');
    }
}
