<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Http\Resources\CartResource;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\RemoveFromCartRequest;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function getCart()
    {
        $carts = $this->cartService->getCart();
        return CartResource::collection($carts);
    }

    public function add(AddToCartRequest $request, $id)
    {
        $cart = $this->cartService->addToCart($id);
        if(!$cart) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return CartResource::collection($cart);
    }

    public function remove(RemoveFromCartRequest $request, $id)
    {
        $cart = $this->cartService->removeFromCart($id);
        return CartResource::collection($cart);
    }
}
