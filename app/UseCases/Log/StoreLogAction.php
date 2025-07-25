<?php

namespace App\UseCases\Log;

use App\Repositories\LogRepository;
use App\UseCases\Log\Dtos\StoreLogDTO;

final class StoreLogAction
{
    public function __construct(protected LogRepository $repository) {}

    public function execute(StoreLogDTO $dto)
    {
        return $this->repository->store($dto->value());
    }
}
