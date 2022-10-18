<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
        foreach ($products as $pro) {
            $pro->product->amount = $pro->amount;
            $new_products [] = $pro->product;
        }

        $token = $request->header('token');
        $user = User::where('remember_token', $token)->first();
        if($user) {
            if (UserAddress::find($this->address_id)) {
                $address = UserAddress::find($this->address_id);
            } else {
                $address = UserAddress::where('user_id', $user->id)->first();
            }
        }else{
            $address = null;
        }
        if($request->header('lang') == 'ar') {
            $status = $this->trans_status($this->status);
        }else{
            $status = $this->status;
        }
        return [
            'id' => $this->id,
            'status' =>$status ,
            'is_paid' => $this->is_paid,
            'products' => OrderProductsResource::collection($new_products),
            'discount' => $this->total  - ($this->total * $this->discount / 100),
            'total' => $this->total ?? 0,
            'total_after_discount' => $this->total_after_discount ?? 0,
            'address' =>new AddressResource($address)
        ];
    }

    public function trans_status($status)
    {
        switch ($status) {
            case 'pending':
                return 'قيد الانتظار';
            case 'accepted':
                return 'مقبول';
            case 'refused':
                return 'مرفوض';
            case 'delivered':
                return 'تم التسليم';
            case 'notDelivered':
                return 'لم يتم التسليم';
        }
    }

}
