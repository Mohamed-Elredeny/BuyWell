<?php

namespace App\Interfaces;


interface BaseRepositoryInterface
{

    public function index();

    public function show($id);

    public function store($array);

    public function update($array, $id);

    public function destroy($id);
}
