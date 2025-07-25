<?php

namespace App\UseCases\StoreLog;

use Carbon\Carbon;

class StoreLogDTO
{   
    public function __construct(
        public string $username,
        public int $numCountries,
        public array $countries
    ) {}

    public function value(): array
    {
        return [
            'username' => $this->username,
            'request_timestamp' => Carbon::now()->toDateTimeString(),
            'num_countries_returned' => $this->numCountries,
            'countries_details' => json_encode($this->countries)
        ];      
    }
}
