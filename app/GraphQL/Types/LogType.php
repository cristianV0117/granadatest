<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Log;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType; 

class LogType extends GraphQLType
{
     protected $attributes = [
        'name' => 'LogType',
        'description' => 'Log entry',
        'model' => Log::class,
    ];

    public function fields(): array
    {
        return [
            'id' => ['type' => Type::int()],
            'username' => ['type' => Type::string()],
            'request_timestamp' => ['type' => Type::string()],
            'num_countries_returned' => ['type' => Type::int()],
            'countries_details' => ['type' => Type::string()],
            'created_at' => ['type' => Type::string()],
        ];
    }
}
