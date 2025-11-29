<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        return Product::all();
    }
    
    public function create(){
        return view('create-product');
    }
    public function store(Request $request){
        $product = $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'string|max:255',
            'price'=>'required|numeric',
            'quantity'=>'required|integer',
        ]);
       Product::create($product);
        return response()->json(['message'=>'Product created successfully'], 201);
    }
    public function show($id){
        return Product::find($id);
    }
    public function update(Request $request, $id){
        $product = Product::find($id);
        $product->update($request->all());
        return $product;
    }
    public function destroy($id){
        Product::find($id)->delete();
        
    }
}
