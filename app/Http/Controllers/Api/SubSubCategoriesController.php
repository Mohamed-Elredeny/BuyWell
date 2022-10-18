<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Interfaces\BaseRepositoryInterface;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubSubCategoriesController extends Controller
{
    use  GeneralTrait;

    public $model;

    public function __construct(BaseRepositoryInterface $base)
    {
        $this->base = $base;
        $this->base->model('SubSubCategory');
        $this->records = 'subSubCategories';
        $this->record = 'subSubCategory';
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

    public function show($id)
    {
        return $this->returnData([$this->records], [$this->base->show($id)]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required',
            'name_en' => 'required',
            'sub_category_id' => 'required|exists:sub_categories,id'
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
                'sub_category_id' => $request->sub_category_id
            ];
            return $this->returnData([$this->record], [$this->base->store($data)]);
        }

    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'sub_category_id' => 'nullable|exists:sub_categories,id'
        ]);
        if ($validator->fails()) {
            return $this->returnValidationError(422, $validator);
        } else {
            $record = SubSubCategory::find($id);
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
                if ($request->sub_category_id) {
                    $data['sub_category_id'] = $request->sub_category_id;
                } else {
                    $data['sub_category_id'] = $record->sub_category_id;
                }
                $this->base->update($data, $id);
                $record = SubSubCategory::find($id);
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
