<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class CountryType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Country',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            'name' => ['type' => Type::string()],
            'area' => ['type' => Type::float()],
            'population' => ['type' => Type::int()],
            'density' => ['type' => Type::float()],
        ];
    }
}
