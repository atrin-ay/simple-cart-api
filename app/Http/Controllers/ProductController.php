<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(){
        return $this->productService->getAllProducts();
    }
    
    public function store(Request $request){
        $product = $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'string',
            'price'=>'required|numeric',
            'quantity'=>'required|integer',
        ]);
       $this->productService->createProduct($product);
        return response()->json(['message'=>'Product created successfully'], 201);
    }
    public function show($id){
        return $this->productService->getProductById($id);
    }
    public function update(Request $request, $id){
        $product = $this->productService->getProductById($id);
        $product->update($request->all());
        return $product;
    }
    public function destroy($id){
        $this->productService->deleteProduct($id);
        
    }
}
