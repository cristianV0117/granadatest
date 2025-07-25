<?php

namespace App\Implementations\Eloquent;

use App\Models\Log;
use App\Repositories\LogRepository;

final class LogImplementation implements LogRepository
{
    public function store(array $data): Log
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

    public function update(int $id, array $data): Log | null
    {
        $log = Log::find($id);

        if (!$log) {
            return null;
        }

        $log->fill($data);
        $log->save();

        return $log;
    }

    public function delete(int $id): bool
    {
        return Log::where('id', $id)->delete() > 0;
    }
}