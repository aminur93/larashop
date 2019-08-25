<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index',compact('users'));
    }
    
    public function show($id)
    {
        //find the user
        $orders = Order::where('user_id',$id)->get();
        
        //Return array back to user details page
        return view('admin.users.details',compact('orders'));
    }
}
