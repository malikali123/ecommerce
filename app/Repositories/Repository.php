<?php


namespace App\Repositories;
use \App\Http\Interfaces\RepositoryInterfaces;
use Illuminate\Database\Eloquent\Model;


class Repository implements RepositoryInterfaces
{
    protected $model;
    // construct to bind model to rebo

    public function __construct(Model $model)
    {
        $this -> model = $model;
    }

    public function all()
    {
        return $this -> model -> all() -> paginate(PAGINATION_COUNT);
    }

    public function create(array $id)
    {
        return $this -> model -> create($id);
    }

    public function update(array $data, $id)
    {
        $record = $this -> find($id);
        return$record -> update($data);
    }

    public function delete($id)
    {
        return $this -> model -> destroy($id);
    }

    public function show($id)
    {
        return $this -> model -> findOrFail($id);
    }
    //git associated model
    public function getMODEL()
    {
        return $this -> model;
    }
    //set the associated model
    public function setMODEL($model)
    {
        $this -> model = $model;
        return $this;
    }
    //Eager load database relashionship
    public function with($relations)
    {
        return $this -> model ->with($relations);
    }
}
