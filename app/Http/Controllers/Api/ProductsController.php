<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsListResource;
use App\Http\Resources\ProductsResource;
use App\Http\Traits\GeneralTrait;
use App\Interfaces\BaseRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\UserLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    use  GeneralTrait;

    public $model;

    public function __construct(BaseRepositoryInterface $base)
    {
        $this->base = $base;
        $this->base->model('Product');
        $this->records = 'products';
        $this->record = 'products';
        $this->middleware('checkBrand', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $keys = [])
    {

        if ($request->brand_id) {
            $keys['is_brand'] = $request->brand_id;
        }
        if ($request->category_id && $request->category_type) {
            $keys['model_type'] = $request->category_type;
            $keys['model_id'] = $request->category_id;
        }
        $products = $this->base->index($keys);
        $ids=[];
        if($request->search){
            foreach ($products as $pro){
                $ids []= $pro->id;
            }
           $products = Product::whereIn('id',$ids)->where('name_ar','like','%'.$request->search.'%')->orWhere('name_en','like','%'.$request->search.'%')->get();
        }
        return $this->paginate($request,ProductsListResource::collection($products));

    }

    public function show($id)
    {
        return $this->returnData([$this->records], [new ProductsResource($this->base->show($id))]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|min:2',
            'price' => 'required',
            'discount' => 'required',

            'dimensions.height' => 'required',
            'dimensions.weight' => 'required',
            'dimensions.length' => 'required',

            'shipping.price' => 'required',
            'shipping.days_from' => 'required',
            'shipping.days_to' => 'required',

            'specifications.material' => 'required',
            'specifications.color' => 'required',
            'specifications.length' => 'required',
            'specifications.fit' => 'required',
            'specifications.occasion' => 'required',
            'specifications.care' => 'required',

            'images' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->returnValidationError(422, $validator);
        } else {
            if ($request->images) {
                $image = $this->uploadImages($request, 'products');
            }
            if ($request->main_image) {
                $main_image = $this->uploadImage($request,'main_image' ,'products');
            }


            if ($request->sub_category_id) {
                $model_type = 'subcategory';
                $model_id = $request->sub_category_id;
            } else {
                $model_type = 'category';
                $model_id = $request->category_id;
            }
            //Categories => 1
            //Sub Cat=>1
            //Sub Sub Cat=>1


            //Products=> 1 => sub sub cat => 1
            //Products=> 1 => sub cat => 1

            $specifications = [
                'dimensions' => [
                    'height' => $request->dimensions['height'],
                    'weight' => $request->dimensions['weight'],
                    'length' => $request->dimensions['length']
                ],
                'shipping' => [
                    'price' => $request->shipping['price'],
                    'days_from' => $request->shipping['days_from'],
                    'days_to' => $request->shipping['days_to'],
                ],
                'specifications' => [
                    'material' => $request->specifications['material'],
                    'color' => $request->specifications['color'],
                    'length' => $request->specifications['length'],
                    'fit' => $request->specifications['fit'],
                    'occasion' => $request->specifications['occasion'],
                    'care' => $request->specifications['care']
                ]
            ];
            $specifications = json_encode($specifications);

            //json_decode($record['specifications_' . APP::geolocation()])->specifications->color;

            $data = [
                'name_ar' => $request->name,
                'name_en' => $request->name,
                'specifications_ar' => $specifications,
                'specifications_en' => $specifications,
                'price' => $request->price,
                'discount_price' => $request->discount,
                'model_id' => $model_id,
                'model_type' => $model_type,
                'images' => $image,
                'main_image'=>$main_image
            ];
            if (Auth::guard('brands-api')->user()) {
                $data['is_brand'] = Auth::guard('brands-api')->user()->id;
            } else {
                $data['is_brand'] = 0;
            }
            return $this->returnData([$this->record], [ProductsResource::collection($this->base->store($data))], '');
        }

    }

    public function update(Request $request, $id)
    {

        $record = Product::find($id);
        if ($record) {
            if (Auth::guard('brands-api')->user()) {
                if (!$this->isBrandItems($id, $this->records)) {
                    return $this->returnError(201, $this->record . 'Is Not Belong to you , so you can not edit it');
                }
            }
            $data = [];
            if ($request->images) {
                $image = $this->uploadImages($request, 'products');
            } else {
                $image = $record->images;
            }
            if ($request->main_image) {
                $main_image = $this->uploadImage($request,'main_image' ,'products');
            } else {
                $main_image = $record->main_image;
            }

            if ($request->sub_category_id) {
                $model_type = 'subcategory';
                $model_id = $request->sub_category_id;
            } else {
                $model_type = 'category';
                $model_id = $request->category_id;
            }
            $specifications = [
                'dimensions' => [
                    'height' => $request->dimensions['height'] ?? json_decode($record['specifications_ar'])->dimensions->height,
                    'weight' => $request->dimensions['weight'] ?? json_decode($record['specifications_ar'])->dimensions->weight,
                    'length' => $request->dimensions['length'] ?? json_decode($record['specifications_ar'])->dimensions->length
                ],
                'shipping' => [
                    'price' => $request->shipping['price'] ?? json_decode($record['specifications_ar'])->shipping->price,
                    'days_from' => $request->shipping['days_from'] ?? json_decode($record['specifications_ar'])->shipping->days_from,
                    'days_to' => $request->shipping['days_to'] ?? json_decode($record['specifications_ar'])->shipping->days_to
                ],
                'specifications' => [
                    'material' => $request->specifications['material'] ?? json_decode($record['specifications_ar'])->specifications->material,
                    'color' => $request->specifications['color'] ?? json_decode($record['specifications_ar'])->specifications->color,
                    'length' => $request->specifications['length'] ?? json_decode($record['specifications_ar'])->specifications->length,
                    'fit' => $request->specifications['fit'] ?? json_decode($record['specifications_ar'])->specifications->fit,
                    'occasion' => $request->specifications['occasion'] ?? json_decode($record['specifications_ar'])->specifications->occasion,
                    'care' => $request->specifications['care'] ?? json_decode($record['specifications_ar'])->specifications->care,
                ]
            ];
            $specifications = json_encode($specifications);
            $data = [
                'name_ar' => $request->name ?? $record->name,
                'name_en' => $request->name ?? $record->name,
                'specifications_ar' => $specifications,
                'specifications_en' => $specifications,
                'price' => $request->price ?? $record->price,
                'discount_price' => $request->discount ?? $record->discount,
                'model_id' => $model_id,
                'model_type' => $model_type,
                'images' => $image,
                'main_image'=>$main_image
            ];

            if (Auth::guard('brands-api')->user()) {
                $data['is_brand'] = 1;
                $data['brand_id'] = Auth::guard('brands-api')->user()->id;
            }
            $this->base->update($data, $id);
            $record = Product::find($id);

            return $this->returnData([$this->record], [ProductsResource::collection($record)]);
        } else {
            return $this->returnError(201, $this->record . ' Not Found With This ID ');
        }

    }

    public function wishlistList(Request $request)
    {
        $token = $request->header('token');
        $exist = User::where('remember_token', $token)->first();
        $likes = UserLike::where('user_id', $exist->id)->get();
        $products = [];
        foreach ($likes as $like) {
            $products [] = $like->product_id;
        }
        $all_products = Product::whereIn('id', $products)->get();
        return $this->returnData([$this->records], [ProductsResource::collection($all_products)]);
    }

    public function wishlist(Request $request, $action)
    {
        $token = $request->header('token');
        $exist = User::where('remember_token', $token)->first();
        $exist_product = Product::find($request->product_id);
        if (!$exist_product) {
            return $this->returnError(200, 'Product not found with this id');
        }
        $exist_like = UserLike::where('user_id', $exist->id)->where('product_id', $request->product_id)->first();
        switch ($action) {
            case 'add':
                if ($exist_like) {
                    return $this->returnError(200, 'You Added This Product Before');
                } else {
                    UserLike::create([
                        'user_id' => $exist->id,
                        'product_id' => $request->product_id
                    ]);
                    return $this->returnSuccessMessage('You Added This Product successfully', 200);
                }
            case 'remove':
                if ($exist_like) {
                    $exist_like->delete();
                    return $this->returnSuccessMessage('You Deleted This Product successfully', 200);
                } else {
                    return $this->returnError(200, 'You Dont have this product in your wishlist');
                }
        }
        return $request->product_id;
    }

    public function destroy($id)
    {
        if (Auth::guard('brands-api')->user()) {
            if (!$this->isBrandItems($id, $this->records)) {
                return $this->returnError(201, $this->record . 'Is Not Belong to you , so you can not edit it');
            }
        }

        if ($this->base->destroy($id)) {
            return $this->returnSuccessMessage($this->record . 'Deleted Successfully', 200);
        }
        return $this->returnError(201, $this->record . ' Not Found With This ID ');
    }
}
