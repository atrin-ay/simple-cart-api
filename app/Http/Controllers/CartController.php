<?php

namespace App\Http\Controllers;

use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function getCart()
    {
        return response()->json($this->cartService->getCart());
    }

    public function add($id)
    {
        $cart = $this->cartService->addToCart($id);
        if(!$cart) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json($cart);
    }

    public function remove($id)
    {
        $cart = $this->cartService->removeFromCart($id);
        return response()->json($cart);
    }
}
