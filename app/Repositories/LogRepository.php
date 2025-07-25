<?php

namespace App\Repositories;

interface LogRepository
{
    public function store(array $data);
    public function getAll(array $filters = []);
}
