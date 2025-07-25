<?php

namespace App\UseCases\Log\Dtos;

final class UpdateLogDTO
{   
    public function __construct(
        private string $username
    ) {}

    public function value(): array
    {
        return [
            'username' => $this->username
        ];      
    }
}
