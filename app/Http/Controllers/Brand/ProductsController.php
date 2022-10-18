<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Throwable;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->api = new \App\Http\Controllers\Api\ProductsController(new BaseRepository());
        $this->collections = 'products';
        $this->collection = 'product';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keys = [];
        if ($request->type && $request->type != 'system') {
            $keys['brand_id'] = $request->type;
        }
        $object = $this->api->index($keys);
        if ($object->original['status']) {
            $records = $object->original['data'][$this->collections];
            $brands = Brand::get();
            return view('brand.sections.' . $this->collections . '.index', compact('records', 'brands', 'keys'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $collections = $this->collections;
        $categories = Category::get();
        return view('brand.sections.' . $this->collections . '.create', compact('collections', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $object = $this->api->store($request);
        if ($object->original['status']) {
            return redirect()->back()->with('success', 'created Successfully');
        } else {
            return redirect()->back()->withErrors($object->original['msg']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $object = $this->api->show($id);
        if ($object->original['status']) {
            $record = $object->original['data'][$this->collections];
            $collection = $this->collection;
            $collections = $this->collections;
            $categories = Category::get();
            $sub_categories = SubCategory::get();
            return view('brand.sections.' . $this->collections . '.show', compact('record', 'collections', 'collection', 'categories', 'sub_categories'));
            return $record;
        } else {
            return redirect()->back()->withErrors($object->original['msg']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $object = $this->api->show($id);
        if ($object->original['status']) {
            $record = $object->original['data'][$this->collections];
            $collection = $this->collection;
            $collections = $this->collections;
            $categories = Category::get();
            $sub_categories = SubCategory::get();
            return view('brand.sections.' . $this->collections . '.edit', compact('record', 'collections', 'collection', 'categories', 'sub_categories'));
        } else {
            return redirect()->back()->withErrors($object->original['msg']);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $object = $this->api->update($request, $id);
        if ($object->original['status']) {
            return redirect()->back()->with('success', 'Updated Successfully');
        } else {
            return redirect()->back()->withErrors($object->original['msg']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($type, $id, $index)
    {
        switch ($type) {
            case 'products':
                $product = Product::find($id);
                $images = $product->images;
                $images = explode('|', $images);
                $new_images = [];
                for ($i = 0; $i < count($images); $i++) {
                    if ($i != $index) {
                        $new_images [] = $images[$i];
                    }
                }
                $new_images = implode($new_images, '|');
                $product->update([
                    'images' => $new_images
                ]);
                break;
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $object = $this->api->destroy($id);
            if ($object) {
                return redirect()->back()->with('success', 'Deleted Successfully');
            } else {
                return redirect()->back()->withErrors($object->original['msg']);
            }
        } catch (Throwable $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
