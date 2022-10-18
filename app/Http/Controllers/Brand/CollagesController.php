<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class CollagesController extends Controller
{
    public function __construct()
    {
        $this->api = new \App\Http\Controllers\Api\CollagesController(new BaseRepository());
        $this->collections = 'collages';
        $this->collection = 'collage';
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
            $categories = Category::get();
            return view('brand.sections.' . $this->collections . '.index', compact('records', 'brands', 'keys', 'categories'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $collections = $this->collections;
        $brands = Brand::get();
        $categories = Category::get();
        if ($request->brand && $request->brand != 0) {
            $products = Product::where('is_brand', $request->brand)->get();
            $brand = $request->brand;
        } else {
            $products = Product::where('is_brand', 0)->get();
            $brand = 0;
        }
        return view('brand.sections.' . $this->collections . '.create', compact('collections', 'brands', 'categories', 'products', 'brand'));
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
            return view('brand.sections.' . $this->collections . '.show', compact('record'));
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
    public function edit(Request $request, $id)
    {
        $object = $this->api->show($id);
        $brands = Brand::get();
        $categories = Category::get();
        if ($object->original['status']) {
            $record = $object->original['data'][$this->collections];
            $active_products_ids = [];
            foreach ($record->products as $pro) {
                $active_products_ids[] = $pro->id;
            }
            $collection = $this->collection;
            $collections = $this->collections;
            if ($request->brand && $request->brand != 0) {
                $products = Product::where('is_brand', $request->brand)->get();
                $brand = $request->brand;
            } else {
                $products = Product::where('is_brand', 0)->get();
                $brand = 0;
            }
            return view('brand.sections.' . $this->collections . '.edit', compact('record', 'collections', 'collection', 'products', 'brand', 'brands', 'categories','active_products_ids'));
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
    public function destroy($id)
    {
        try {
            $object = $this->api->destroy($id);

            if ($object->original['status']) {
                return redirect()->back()->with('success', 'Deleted Successfully');
            } else {
                return redirect()->back()->withErrors($object->original['msg']);
            }
        } catch (Throwable $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
