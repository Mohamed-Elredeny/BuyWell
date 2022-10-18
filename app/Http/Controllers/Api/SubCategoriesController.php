<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Interfaces\BaseRepositoryInterface;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubCategoriesController extends Controller
{
    use  GeneralTrait;

    public $model;

    public function __construct(BaseRepositoryInterface $base)
    {
        $this->base = $base;
        $this->base->model('SubCategory');
        $this->records = 'subCategories';
        $this->record = 'subCategory';
        $this->middleware('checkBrand', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($keys = [])
    {
        return $this->returnData([$this->records], [$this->base->index($keys)]);
    }

    public function indexAjax(Request $request)
    {
        $keys = [];

        if ($request->keys) {
            $keys['category_id'] = $request->keys;
        }
        return $this->returnData([$this->records], [$this->base->index($keys)]);
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
            'category_id' => 'required|exists:categories,id'
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
                'category_id' => $request->category_id
            ];
            return $this->returnData([$this->record], [$this->base->store($data)]);
        }

    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'category_id' => 'nullable|exists:categories,id'
        ]);
        if ($validator->fails()) {
            return $this->returnValidationError(422, $validator);
        } else {
            $record = SubCategory::find($id);
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
                if ($request->category_id) {
                    $data['category_id'] = $request->category_id;
                } else {
                    $data['category_id'] = $record->category_id;
                }
                $this->base->update($data, $id);
                $record = SubCategory::find($id);
                return $this->returnData([$this->record], [$record]);
            } else {
                return $this->returnError(201, $this->record . ' Not Found With This ID ');
            }
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
}
