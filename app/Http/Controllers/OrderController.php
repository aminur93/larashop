<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('admin.orders.index',compact('orders'));
    }
    
    public function confirmed($id)
    {
        //find the order
        $order = Order::findOrFail($id);
        
        //update the order
        $order->update(['status' => 1]);
        
        //session message
        session()->flash('msg','Order has been confirmed');
        
        //Redirect the page
        return redirect('admins/orders');
    }
    
    public function pending($id)
    {
        //find the order
        $order = Order::findOrFail($id);
    
        //update the order
        $order->update(['status' => 0]);
    
        //session message
        session()->flash('msg','Order has been again into pending');
    
        //Redirect the page
        return redirect('admins/orders');
    }
    
    public function show($id)
    {
        $order = Order::find($id);
        return view('admin.orders.details',compact('order'));
    }
}
