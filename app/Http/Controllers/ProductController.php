<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Mockery\Exception;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index',compact('products'));
    }
    
    public function create()
    {
        return view('admin.products.create');
    }
    
    public function store(Request $request)
    {
        //dd($request->all());
        
        //validation form
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required'
        ]);
        
        //upload the image
        if ($request->hasFile('image'))
        {
            $image = $request->image;
            $image->move('uploads', $image->getClientOriginalName());
        }
        
        //save data into database
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $request->image->getClientOriginalName()
        ]);
        
        //sessions message
        $request->session()->flash('msg','Your Product Has Been Added');
        //redirect page
        return redirect('admins/products');
    }
    
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit',compact('product'));
    }
    
    public function update(Request $request, $id)
    {
        //find the product
        $product = Product::findOrFail($id);
        
        //validate the form
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required'
        ]);
        
        //check if there is image
        if ($request->hasFile('image'))
        {
            //check if the old image exist inside the folder
            if(file_exists(public_path().'/uploads/'.$product->image))
            {
                unlink(public_path().'/uploads/'.$product->image);
            }
            
            //upload the new image
            $image = $request->image;
            $image->move('uploads', $image->getClientOriginalName());
        }
        
        //updating the image
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $request->image->getClientOriginalName()
        ]);
    
        //sessions message
        $request->session()->flash('msg','Your Product Has Been Updated');
        //redirect page
        return redirect('admins/products');
    }
    
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.details',compact('product'));
    }
    
    public function destroy($id)
    {
        $products = Product::findOrFail($id);
        $image_path = public_path()."/uploads/".$products->image;
         unlink($image_path);
        $products->delete();
        
        session()->flash('msg','Your Product Has Been Deleted');
        
        return redirect('admins/products');
    }
}
