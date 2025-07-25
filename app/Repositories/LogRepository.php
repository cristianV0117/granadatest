<?php

namespace App\Repositories;

use App\Models\Log;

interface LogRepository
{
    public function store(array $data);
    public function getAll(array $filters = []);
    public function update(int $id, array $data): Log | null;
    public function delete(int $id): bool;
}
