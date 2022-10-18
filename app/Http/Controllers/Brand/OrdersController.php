<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->api = new \App\Http\Controllers\Api\OrdersController(new BaseRepository());
        $this->collections = 'orders';
        $this->collection = 'order';
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
        return view('brand.sections.' . $this->collections . '.create', compact('collections'));
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
            return view('brand.sections.' . $this->collections . '.edit', compact('record', 'collections', 'collection'));
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
