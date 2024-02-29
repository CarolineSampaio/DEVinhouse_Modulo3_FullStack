<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBreedRequest;
use App\Models\Breeds;
use App\Traits\HttpResponses;
use Symfony\Component\HttpFoundation\Response;

class BreedController extends Controller
{

    use HttpResponses;

    public function index()
    {
        $breeds = Breeds::all();
        return $breeds;
    }

    public function store(StoreBreedRequest $request)
    {
        try {
            $body = $request->all();

            $breed = Breeds::create($body);

            return $breed;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
