<?php

namespace App\Http\Controllers;

use App\Mail\SendWelcomePet;
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
            // pegar os dados que foram enviados via query params
            $filters = $request->query();

            // inicializa uma query
            // $pets = Pet::query();

            $pets = Pet::query()
                ->select(
                    'id',
                    'pets.name as pet_name',
                    'pets.breed_id',
                    'pets.specie_id',
                    'pets.size as size',
                    'pets.weight as weight',
                    'pets.age as age'
                )
                #->with('breed') // traz todas as colunas
                ->with(['breed' => function ($query) {
                    $query->select('name', 'id');
                }])
                ->with('specie')
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
}
