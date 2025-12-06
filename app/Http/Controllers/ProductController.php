<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return ProductResource::collection($products);
    }
    
    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->createProduct($request->validated());
        return new ProductResource($product);
    }
    
    public function show($id)
    {
        $product = $this->productService->getProductById($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return new ProductResource($product);
    }
    
    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productService->getProductById($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        
        $product = $this->productService->updateProduct($id, $request->validated());
        return new ProductResource($product);
    }
    
    public function destroy($id)
    {
        $product = $this->productService->getProductById($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        
        $this->productService->deleteProduct($id);
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
