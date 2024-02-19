<?php

namespace App\Http\Controllers;

use App\Mail\SendWelcomePet;
use App\Models\Adoption;
use App\Models\People;
use App\Models\Pet;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class AdoptionController extends Controller
{
    use HttpResponses;

    public function index(Request $request)
    {
        try {
            $filters = $request->query();
            $pets = Pet::query()
                ->select(
                    'id',
                    'pets.name as pet_name',
                    'pets.breed_id',
                    'pets.age as age'
                )
                ->with(['breed' => function ($query) {
                    $query->select('name', 'id');
                }])
                ->where('client_id', null);

            // Verifica se há uma string de pesquisa
            if ($request->has('search') && !empty($request->input('search'))) {
                $searchQuery = '%' . $request->input('search') . '%';

                $pets->where(function ($query) use ($searchQuery) {
                    $query->where('name', 'ilike', $searchQuery)
                        ->orWhere('age', 'ilike', $searchQuery)
                        ->orWhere('weight', 'ilike', $searchQuery)
                        ->orWhereHas('breed', function ($query) use ($searchQuery) {
                            $query->where('name', 'ilike', $searchQuery);
                        });
                });
            }
            return $pets->orderBy('created_at', 'desc')->get();
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {
        $pet = Pet::find($id)->load('breed', 'specie');

        if ($pet->client_id) return $this->error('Dados confidenciais', Response::HTTP_FORBIDDEN);
        if (!$pet) return $this->error('Dado não encontrado!', Response::HTTP_NOT_FOUND);

        return $pet;
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $request->validate([
                'name' => 'string|required|max:255',
                'contact' => 'string|required|max:20',
                'email' => 'string|required',
                'cpf' => 'string|required',
                'observations' => 'string|required',
                'pet_id' => 'integer|required',
            ]);

            $adoption = Adoption::create([...$data, 'status' => 'PENDENTE']);
            return $adoption;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
