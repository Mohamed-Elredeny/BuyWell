<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\UserCart;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $products = $this->products;
        $new_products = [];
        $total = 0;
        foreach ($products as $product) {
            $product->product->amount = $product->amount;
            $product = $product->product;
            if ($product->id) {
                if (Product::find($product->id)) {
                    $new_products [] = $product;
                }
            }
        }
        foreach ($new_products as $product) {
            $product_price = $product->price ?? 0;
            $product_discount_price = $product->discount_price ?? 0;
            $product_total_price = $product_price - ($product_price * ($product_discount_price / 100));
            $product_total_price *= $product->amount ?? 0;
            $total += $product_total_price;
        }
        $discount = $this->discount ?? 0;
        $cart = UserCart::find($this->id);
        $cart->update([
            'discount'=> $total * ($discount / 100) ,
            'total'=>$total,
            'total_after_discount'=>$total -  ($total * ($discount / 100))
        ]);
        return [
            'id' => $this->id,
            'products' => ProductsListResource::collection($new_products),
            'coupon' => $this->coupon ?? '',
            'discount' =>$total * ($discount / 100),
            'totalPrice' => $total,
            'total_after_discount' => $total -  ($total * ($discount / 100))
        ];

    }
}
