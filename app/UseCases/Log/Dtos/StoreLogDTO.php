<?php

namespace App\UseCases\Log\Dtos;

use Carbon\Carbon;

final class StoreLogDTO
{   
    public function __construct(
        private string $username,
        private int $numCountries,
        private array $countries
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
