<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBreedRequest;

use App\Http\Services\Breeds\CreateBreedsService;
use App\Http\Services\Breeds\GetAllBreedsService;
use App\Traits\HttpResponses;
use Symfony\Component\HttpFoundation\Response;

class BreedController extends Controller
{

    use HttpResponses;

    public function index(GetAllBreedsService $getAllBreedsService)
    {
        try {
            $breeds = $getAllBreedsService->handle();
            return $breeds;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(StoreBreedRequest $request, CreateBreedsService $createBreedsService)
    {
        try {
            $body = $request->all();
            $breed = $createBreedsService->handle($body);
            return $breed;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
