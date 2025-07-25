<?php

namespace App\UseCases\Log;

use App\Repositories\LogRepository;

final class DeleteLogAction
{
    public function __construct(protected LogRepository $repository) {}

    public function execute(int $id): bool
    {
        return $this->repository->delete($id);
    }
}