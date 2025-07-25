<?php

namespace App\UseCases\Log;

use App\Repositories\LogRepository;
use App\UseCases\Log\Dtos\UpdateLogDTO;

final class UpdateLogAction
{
    public function __construct(protected LogRepository $repository) {}

    public function execute(int $id, UpdateLogDTO $dto)
    {
        return $this->repository->update(id: $id, data: $dto->value());
    }
}
