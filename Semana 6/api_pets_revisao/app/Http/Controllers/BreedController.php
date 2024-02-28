<?php

namespace App\Http\Controllers;

use App\Models\Breeds;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BreedController extends Controller
{

    use HttpResponses;

    public function index()
    {
        $breeds = Breeds::all();
        return $breeds;
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:breeds|max:50'
            ]);

            $body = $request->all();

            $breed = Breeds::create($body);

            return $breed;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
