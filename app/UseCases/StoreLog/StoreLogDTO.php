<?php

namespace App\UseCases\StoreLog;

class StoreLogDTO
{
    public function __construct(
        public string $username,
        public int $numCountries,
        public array $countries
    ) {}
}
