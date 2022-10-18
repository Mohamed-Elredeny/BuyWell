<?php

namespace App\Http\Controllers;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public $model;

    public function __construct(BaseRepositoryInterface $base)
    {
        $this->base = $base;
        $this->base->model('User');
    }

    public function index()
    {
        $keys = [
            'email' => 'mohamed5@yahoo.com',
            'password' => '123123'
        ];
        return $this->base->index($keys);
    }

    public function show()
    {
        $id = 2;
        return $this->base->show($id);
    }


    public function store()
    {
        $request =
            [
                'name' => 'mohamed',
                'email' => 'mohamed5@yahoo.com',
                'password' => '123123'
            ];
        return $this->base->store($request);
    }

    public function update()
    {
        $request =
            [
                'name' => 'mohamed1',
                'email' => 'mohamed11@yahoo.com',
                'password' => '1231231'
            ];
        return $this->base->update($request, 1);
    }

    public function destroy()
    {

        return $this->base->destroy(1);
    }
}
