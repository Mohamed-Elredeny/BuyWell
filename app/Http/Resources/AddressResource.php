<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $area = $this->area->name ?? '';
        $city = $this->area->city->name ?? '';
        $street_name = $this->street_name;
        $building_number = $this->building_number;
        $floor_number = $this->floor_number;
        $flat_number = $this->flat_number;
        $address = $city . ' ' . $area . ' ' . $street_name . ' ' . $building_number .' ' . $floor_number . ' '. $flat_number;
        return [
            'id' => $this->id,
            'address'=>$address
        ];
    }


}
