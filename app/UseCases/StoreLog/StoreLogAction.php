<?php

namespace App\UseCases\StoreLog;

use App\Repositories\LogRepository;
use Carbon\Carbon;

class StoreLogAction
{
    public function __construct(protected LogRepository $repository) {}

    public function execute(StoreLogDTO $dto)
    {
        return $this->repository->store([
            'username' => $dto->username,
            'request_timestamp' => Carbon::now(),
            'num_countries_returned' => $dto->numCountries,
            'countries_details' => $dto->countries,
        ]);
    }
}
