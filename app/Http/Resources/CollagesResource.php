<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class CollagesResource extends JsonResource
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
        $ids = [];
        foreach ($products as $pro) {
            $ids [] = $pro->product_id;
        }
        $real_products = Product::whereIn('id', $ids)->get();
        $price = 0;
        $price_after_discount = 0;

        foreach ($real_products as $pro) {
            $price += $pro->price;
            $price_after_discount += $pro->discount_price;
        }
        if ($request->header('lang') == 'ar') {
            $lang = 'ar';
        } else {
            $lang = 'en';
        }
        return [
            'id'=>$this->id,
            'name' => $this['name_' . $lang],
            'image' => $this->image,
            'price' => $price,
            'price_after_discount' => $price_after_discount,
            'discount' => $price - $price_after_discount,
            'brand' => new BrandsResource($this->brand),
            'products' => ProductsResource::collection($real_products),
            'created_since_with_days' => date('d', strtotime($this->created_at))
        ];
    }
}
