<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Interfaces\BaseRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    use  GeneralTrait;

    public $model;

    public function __construct(BaseRepositoryInterface $base)
    {
        $this->base = $base;
        $this->base->model('Category');
        $this->records = 'categories';
        $this->record = 'category';
        $this->middleware('checkBrand', ['only' => ['store', 'update', 'destroy']]);
        $this->middleware(function ($request, $next) {
            if ($request->MMDevice) {
                $this->device = 'mobile';
            } else {
                $this->device = 'web';
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $keys = [])
    {
        /*        dd($this->device);*/
        if($request->brand_id){
            $keys['brand_id'] = $request->brand_id;
        }
        $records = $this->base->index($keys);
        $lang = $request->header('lang') ?? 'ar';
        foreach ($records as $record) {
            if ($lang == 'ar') {
                $name = $record->name_ar;
            } else {
                $name = $record->name_en;
            }
            $record->name = $name;
            unset(
                $record->is_brand,
                $record->brand_id,
                $record->created_at,
                $record->updated_at,
                $record->name_ar,
                $record->name_en,
            );
        }
        return $this->returnData([$this->records], [$records]);
    }

    public function show($id)
    {
        return $this->returnData([$this->records], [$this->base->show($id)]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required',
            'name_en' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->returnValidationError(422, $validator);
        } else {
            if ($request->image) {
                $image = $this->uploadImage($request, 'image', 'categories');
            } else {
                $image = '';
            }
            $data = [
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'image' => asset('assets/images/categories/' . $image),
            ];
            if (Auth::guard('brands-api')->user()) {
                $data['is_brand'] = 1;
                $data['brand_id'] = Auth::guard('brands-api')->user()->id;
            }
            if (Auth::guard('brand')->user()) {
                $data['is_brand'] = 1;
                $data['brand_id'] = Auth::guard('brand')->user()->id;
            }

            return $this->returnData([$this->record], [$this->base->store($data), '']);
        }

    }

    public function update(Request $request, $id)
    {

        $record = Category::find($id);
        if ($record) {
            if (Auth::guard('brands-api')->user()) {
                if (!$this->isBrandItems($id, $this->records)) {
                    return $this->returnError(201, $this->record . 'Is Not Belong to you , so you can not edit it');
                }
            }
            $data = [];
            if ($request->image) {
                $image = $this->uploadImage($request, 'image', 'categories');
            } else {
                $image = $record->image;
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
            if (Auth::guard('brands-api')->user()) {
                $data['is_brand'] = 1;
                $data['brand_id'] = Auth::guard('brands-api')->user()->id;
            }
            if (Auth::guard('brand')->user()) {
                $data['is_brand'] = 1;
                $data['brand_id'] = Auth::guard('brand')->user()->id;
            }
            $this->base->update($data, $id);
            $record = Category::find($id);

            return $this->returnData([$this->record], [$record]);
        } else {
            return $this->returnError(201, $this->record . ' Not Found With This ID ');
        }

    }


    public function destroy($id)
    {
        if ($this->base->destroy($id)) {
            if (!$this->isBrandItems($id, $this->records)) {
                return $this->returnError(201, $this->record . 'Is Not Belong to you , so you can not edit it');
            }
            return $this->returnSuccessMessage($this->record . 'Deleted Successfully', 200);
        }
        return $this->returnError(201, $this->record . ' Not Found With This ID ');
    }

    public function getDevice(Request $request)
    {

    }
}
