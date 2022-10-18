<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;

class BaseRepository implements BaseRepositoryInterface
{
    public $model;

    public function model($model)
    {
        $this->model = "\App\Models\\" . $model;
    }

    public function index($keys = [])
    {
        $query = $this->model::query();

        foreach ($keys as $key => $value) {
            $query->where($key, $value);
        }
        return $query->get();
    }

    public function show($id)
    {
        return $this->model::find($id);
    }

    public function store($array = [])
    {
        return $this->model::create($array);

    }

    public function update($array, $id)
    {
        $record = $this->model::find($id);
        if ($record->update($array)) {
            $record->update($array);
            return 1;
        } else {
            return 0;
        }

    }

    public function destroy($id)
    {
        return $this->model::destroy($id);
    }


}
