<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Cart;

class CartService
{
    private $userId = 1;

    public function getCart()
    {
        $carts = Cart::where('user_id', $this->userId)
            ->with('product')
            ->get();
        
        return $carts;
    }

    public function addToCart($id)
    {
        $product = Product::find($id);
        if(!$product) {
            return false;
        }

        $cartItem = Cart::where('user_id', $this->userId)
            ->where('product_id', $id)
            ->first();

        if($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $this->userId,
                'product_id' => $id,
                'quantity' => 1
            ]);
        }

        return $this->getCart();
    }

    public function removeFromCart($id)
    {
        Cart::where('user_id', $this->userId)
            ->where('product_id', $id)
            ->delete();

        return $this->getCart();
    }
}

