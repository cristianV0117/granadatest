<?php

namespace App\Implementations\Eloquent;

use App\Models\Log;
use App\Repositories\LogRepository;

class LogImplementation implements LogRepository
{
    public function store(array $data)
    {
        return Log::create($data);
    }

    public function getAll(array $filters = [])
    {
        return Log::query()
            ->when(isset($filters['start_date']), fn ($q) =>
                $q->whereDate('request_timestamp', '>=', $filters['start_date']))
            ->when(isset($filters['end_date']), fn ($q) =>
                $q->whereDate('request_timestamp', '<=', $filters['end_date']))
            ->orderBy('id', 'desc')
            ->get();
    }
}