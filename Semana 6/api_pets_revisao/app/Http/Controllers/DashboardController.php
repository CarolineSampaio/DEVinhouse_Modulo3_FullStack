<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getSpeciesAmountByPet(Request $request)
    {
        return DB::select('select count(specie_id), species.name from pets
        right join species on pets.specie_id = species.id
        group by specie_id, species.name');
    }
}
