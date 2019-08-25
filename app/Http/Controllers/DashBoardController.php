<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    
    public function index()
    {
        $products = new Product();
        $orders = new Order();
        $users = new User();
        return view('admin.dashboard',compact('products','orders','users'));
    }
}
