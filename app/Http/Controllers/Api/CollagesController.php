<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollagesResource;
use App\Http\Traits\GeneralTrait;
use App\Interfaces\BaseRepositoryInterface;
use App\Models\Collage;
use App\Models\CollageProducts;
use App\Models\User;
use App\Models\UserCollage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollagesController extends Controller
{
    use  GeneralTrait;

    public $model;

    public function __construct(BaseRepositoryInterface $base)
    {
        $this->base = $base;
        $this->base->model('Collage');
        $this->records = 'collages';
        $this->record = 'collage';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->type) && $request->type == 'top') {
            $collages = Collage::inRandomOrder()->limit(3)->get();
        } else {
            $keys = [
            ];
            if (isset($request->brand_id)) {
                $keys['brand_id']  = $request->brand_id;
            }
            $collages = $this->base->index($keys);

            if (isset($request->my_collages) && $request->my_collages == 1) {
                $token = $request->header('token');
                $user = User::where('remember_token', $token)->first();
                if ($user) {
                    $res = UserCollage::where('user_id', $user->id)->get();
                } else {
                    $res = [];
                }
                $collages = [];
                foreach ($res as $r) {
                    $collages [] = $r->collage_id;
                }
                $collages = Collage::whereIn('id', $collages)->get();
            }


        }
        foreach ($collages as $col) {
            $col->products = $col->products;
        }
        return $this->returnData([$this->records], [CollagesResource::collection($collages)]);
    }

    public function show($id)
    {
        $collage = $this->base->show($id);
        if ($collage) {
            $collage->products = $collage->products;
        }
        return $this->returnData([$this->records], [$collage]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required',
            'name_en' => 'required',
            'brand_id' => 'nullable|exists:brands,id',
            'user_id' => 'nullable|exists:users,id',
            'products.*.id' => 'nullable|exists:products,id',
        ]);
        if ($validator->fails()) {
            return $this->returnValidationError(422, $validator);
        } else {
            if ($request->image) {
                $image = $this->uploadImage($request, 'image', 'collages');
            } else {
                $image = '';
            }
            $data = [
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'image' => asset('assets/images/collages/' . $image),
            ];

            if ($request->user_id) {
                $data['user_id'] = $request->user_id;
                $data['brand_id'] = null;
            } else {
                if ($request->brand_id) {
                    $data['brand_id'] = $request->brand_id;
                    $data['is_brand'] = 1;
                }
            }
            $record = $this->base->store($data);
            if ($request->products) {
                if (count($request->products) > 0) {
                    foreach ($request->products as $product) {
                        CollageProducts::create([
                            'collage_id' => $record->id,
                            'product_id' => intval($product)
                        ]);
                    }
                }
            }
            $token = $request->header('token');
            if ($token) {
                $user = User::where('remember_token', $token)->first();
                if ($user) {
                    UserCollage::create([
                        'user_id' => $user->id,
                        'collage_id' => $record->id
                    ]);
                }
            }


            return $this->returnData([$this->record], [new CollagesResource($record)]);
        }

    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'products.*.id' => 'required|exists:products,id',
            'user_id' => 'nullable|exists:users,id',
        ]);
        if ($validator->fails()) {
            return $this->returnValidationError(422, $validator);
        } else {
            $record = Collage::find($id);
            if ($record) {
                $data = [];
                if ($request->image) {
                    $image = $this->uploadImage($request, 'image', 'collages');
                } else {
                    $image = '';
                }

                $data = [
                    'image' => asset('assets/images/categories/' . $image),
                ];
                if ($request->name_ar) {
                    $data['name_ar'] = $request->name_ar;
                } else {
                    $data['name_ar'] = $record->name_ar;
                }
                if ($request->name_en) {
                    $data['name_en'] = $request->name_en;
                } else {
                    $data['name_en'] = $record->name_en;
                }
                if ($request->products) {
                    if (count($request->products) > 0) {
                        foreach ($request->products as $product) {
                            if (CollageProducts::where('collage_id', $record->id)->where('product_id', $product['id'])->count() <= 0) {
                                CollageProducts::create([
                                    'collage_id' => $record->id,
                                    'product_id' => $product['id']
                                ]);
                            }
                        }
                    }
                }
                if ($request->user_id) {
                    if (UserCollage::where('collage_id', $id)->where('user_id', $request->user_id)->count() <= 0) {
                        UserCollage::create([
                            'user_id' => $request->user_id,
                            'collage_id' => $record->id
                        ]);
                    }
                }
                $this->base->update($data, $id);
                $record = Collage::find($id);
                $record->products = $record->products;
                return $this->returnData([$this->record], [$record]);
            } else {
                return $this->returnError(201, $this->record . ' Not Found With This ID ');
            }
        }

    }

    public function destroy($id)
    {
        if (Collage::find($id)) {
            $products = CollageProducts::where('collage_id', $id)->get();
            foreach ($products as $pro) {
                $pro->delete();
            }
            $users = UserCollage::where('collage_id', $id)->get();
            foreach ($users as $pro) {
                $pro->delete();
            }
            if ($this->base->destroy($id)) {
                return $this->returnSuccessMessage($this->record . 'Deleted Successfully', 200);
            }
        }
        return $this->returnError(201, $this->record . ' Not Found With This ID ');
    }
}
