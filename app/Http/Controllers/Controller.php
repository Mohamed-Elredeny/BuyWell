<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use GeneralTrait;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    #region paginate
    public function paginate(Request $request, $array)
    {
        $limit = $request->header('limit') ?? Product::count();
        $active = $request->header('active');

        $all_records = count($array);
        $pages = ceil($all_records / $limit);
        if ($active < $pages) {
            $paginate_response = $this->paginate_redo($array, $limit, $active);
            $count_paginate_response = count($this->paginate_redo($array, $limit, $active));
            $data = [
                'posts' => $paginate_response,
                'pages' => $pages,
                'page_records' => $count_paginate_response,
                'active' => intval($active),
                'count' => $all_records
            ];
            return $this->returnData(['records'], [$data], 'success');
        } else {
            $data = [
                'posts' => [],
                'pages' => $pages,
                'page_records' => 0,
                'active' => -1,
                'count' => $all_records
            ];
            return $this->returnData(['records'], [$data], 'error');


        }
    }

    public function paginate_redo($data, $limit, $page)
    {
        $count_records = count($data);
        if ($limit > $count_records) {
            $limit = $count_records;
        }
        $res = [];
        for ($i = 0 + ($limit * $page); $i < $limit + ($limit * $page); $i++) {
            if ($i > $count_records - 1) {
                break;
            }
            $res[] = $data[$i];
        }
        return $res;
    }
    #endregion
    #region
    public function uploadImage(Request $request, $filename, $path)
    {

        $filename = strval($filename);
        if ($request->hasFile($filename)) {
            //  Let's do everything here
            $extension = $request->file($filename)->extension();
            $image = time() . '.' . $request->file($filename)->getClientOriginalExtension();
            $request->file($filename)->move(public_path('/assets/images/' . $path), $image);
            return $image;
        }
    }

    public function uploadImages(Request $request, $path)
    {
        if ($request->hasFile('images')) {

            $image_ext = ['jpg', 'png', 'jpeg'];

            $video_ext = ['mpeg', 'ogg', 'mp4', 'webm', '3gp', 'mov', 'flv', 'avi', 'wmv', 'ts'];

            $files = $request->file('images');
            $image = [];
            foreach ($files as $file) {

                $fileextension = $file->getClientOriginalExtension();


                $filename = $file->getClientOriginalName();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                $test = $file->move(public_path('assets/images/' . $path), $file_to_store);

                if ($test) {
                    $images [] = $file_to_store;
                }
            }
            $images = implode('|', $images);
            return $images;
        }

    }

    #endregion

    public function checkRole($role, $token)
    {
        switch ($role) {
            case 'user':
                if (User::where('remember_token', $token)->first()) {
                    return 1;
                }
                break;
            case 'brand':
                if (Brand::where('remember_token', $token)->first()) {
                    return 1;
                }
                break;
        }
        return 0;
    }

    public function isBrandItems($id, $type)
    {

        switch ($type) {
            case 'categories':
                if (Category::where('id', $id)->where('brand_id', Auth::guard('brands-api')->user()->id)->count() <= 0) {
                    return 0;
                }
                break;
            case 'subCategories':
                $cat_id = SubCategory::find($id)->category_id;
                if (Category::where('id', $cat_id)->where('brand_id', Auth::guard('brands-api')->user()->id)->count() <= 0) {
                    return 0;
                }
                break;
            case 'subSubCategories':
                $sub_cat_id = SubSubCategory::find($id)->sub_category_id;
                $cat_id = SubCategory::find($sub_cat_id)->category_id;
                if (Category::where('id', $cat_id)->where('brand_id', Auth::guard('brands-api')->user()->id)->count() <= 0) {
                    return 0;
                }
                break;
        }
        return 1;
    }

}
