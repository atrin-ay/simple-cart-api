<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart');
    }
    
    public function getCart()
    {
        return response()->json(session('cart', []));
    }

    public function add($id)
    {
        $product = Product::find($id);
        if(!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $cart = session('cart', []);

        if($cart[$id] ?? false) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1
            ];
        }

        session(['cart' => $cart]);

        return response()->json($cart);
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        if($cart[$id] ?? false) {
            unset($cart[$id]);
        }

        session(['cart' => $cart]);

        return response()->json($cart);
    }
}
