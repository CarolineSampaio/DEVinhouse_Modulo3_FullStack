<?php

namespace App\Http\Services\Breeds;

use App\Http\Repositories\BreedsRepository;

class GetAllBreedsService
{
    private $BreedsRepository;

    public function __construct(BreedsRepository $BreedsRepository)
    {
        $this->BreedsRepository = $BreedsRepository;
    }

    public function handle()
    {
        return $this->BreedsRepository->getAll();
    }
}
