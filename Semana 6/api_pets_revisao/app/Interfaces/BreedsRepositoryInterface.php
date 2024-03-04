<?php

namespace App\Interfaces;

interface BreedsRepositoryInterface
{
    public function getAll();
    public function create(array $data);
}
