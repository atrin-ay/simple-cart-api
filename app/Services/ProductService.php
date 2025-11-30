<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAllProducts()
    {
        return Product::all();
    }

    public function getProductById($id)
    {
        return Product::find($id);
    }

    public function createProduct(array $data)
    {
        $product = Product::create($data);
        return $product;
    }

    public function updateProduct($id, array $data)
    {
        $product = Product::find($id);
        $product->update($data);
        return $product;
    }

    public function deleteProduct($id)
    {
        Product::find($id)->delete();
    }
}
