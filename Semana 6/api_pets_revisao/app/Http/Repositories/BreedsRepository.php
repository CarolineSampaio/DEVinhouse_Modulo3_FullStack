<?php

namespace App\Http\Repositories;

use App\Interfaces\BreedsRepositoryInterface;
use App\Models\Breeds;

class BreedsRepository implements BreedsRepositoryInterface
{

    public function getAll()
    {
        return Breeds::all();
    }

    public function create(array $data)
    {
        return Breeds::create($data);
    }
}
