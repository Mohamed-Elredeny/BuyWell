<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubSubCategoriesController extends Controller
{
    public function __construct()
    {
        $this->api = new \App\Http\Controllers\Api\SubSubCategoriesController(new BaseRepository());
        $this->collections = 'subSubCategories';
        $this->collection = 'subSubCategory';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keys = [];
        if ($request->sub_category_id) {
            $keys['sub_category_id'] = $request->sub_category_id;
        }
        $object = $this->api->index($keys);
        $new_records = [];
        if ($object->original['status']) {
            $records = $object->original['data'][$this->collections];
            foreach($records as $record){
                if($record->SubCategory->category->brand_id ==  Auth::guard('brand')->user()->id){
                    $new_records [] = $record;
                }
            }
            $records = $new_records;
            return view('brand.sections.' . $this->collections . '.index', compact('records'));
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
        $categories = Category::where('brand_id',Auth::guard('brand')->user()->id)->get();
        return view('brand.sections.' . $this->collections . '.create', compact('collections','categories'));
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
            // return view('admin.sections.categories.show', compact('record'));
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
            $categories = SubCategory::get();
            return view('brand.sections.' . $this->collections . '.edit', compact('record', 'collections', 'collection','categories'));
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
