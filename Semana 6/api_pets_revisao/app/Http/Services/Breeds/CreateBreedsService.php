<?php

namespace App\Http\Services\Breeds;

use App\Http\Repositories\BreedsRepository;

class CreateBreedsService
{
    private $BreedsRepository;

    public function __construct(BreedsRepository $BreedsRepository)
    {
        $this->BreedsRepository = $BreedsRepository;
    }

    public function handle(array $data)
    {
        return $this->BreedsRepository->create($data);
    }
}
