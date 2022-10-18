<?php

namespace App\Http\Resources;

use App\Models\CartProducts;
use App\Models\User;
use App\Models\UserCart;
use App\Models\UserLike;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $current_images = $this->images ?? '';
        $images = explode('|', $current_images);
        $new_images = [];
        foreach ($images as $image) {
            $new_images [] = asset('assets/images/products/' . $image);
        }
        $is_liked = 0;
        $is_added_to_cart = 0;
        $token = $request->header('token');

        if ($token && $token != '') {
            $exist = User::where('remember_token', $token)->get();
            if (count($exist) > 0) {
                $this->user = $exist[0];
                //Check Our User Liked it or not
                if (UserLike::where('user_id', $exist[0]->id)->where('product_id', $this->id)->count() > 0) {
                    $is_liked = 1;
                }
                $cart = UserCart::where('user_id', $exist[0]->id)->first();
                if ($cart) {
                    foreach ($cart->products as $product) {
                        if ($product->id == $this->id) {
                            $is_added_to_cart = 1;
                        }
                    }
                }
            } else {
                $exist = null;

            }
        }


        $response = [
            'id' => $this->id,
            'name' => $this->name,
            'price' => floatval($this->price),
            'discount_price' => floatval($this->discount_price),
            'price_after_discount' => floatval($this->price) - (floatval($this->price) * (floatval($this->discount_price) / 100)),
            'images' => $new_images,
            'category' => $this->category,
            'specifications' => json_decode($this->specifications),
            'auth' => [
                'is_liked' => $is_liked,
                'is_added_to_cart' => $is_added_to_cart
            ],
            'amount'=>$this->amount
        ];

        return $response;
    }
}
