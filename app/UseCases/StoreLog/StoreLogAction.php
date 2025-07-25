<?php

namespace App\UseCases\StoreLog;

use App\Repositories\LogRepository;
use Carbon\Carbon;

class StoreLogAction
{
    public function __construct(protected LogRepository $repository) {}

    public function execute(StoreLogDTO $dto)
    {
        return $this->repository->store($dto->value());
    }
}
