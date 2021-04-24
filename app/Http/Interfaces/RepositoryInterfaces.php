<?php


namespace App\Http\Interfaces;


interface RepositoryInterfaces
{
public function all();
public function create(array $id);
public function update(array $data,$id);
public function delete($id);
public function show($id);
}
