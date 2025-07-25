<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class GetLogsQuery extends Query
{
    protected $attributes = [
        'name' => 'getLogs',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('LogType'));
    }

    public function args(): array
    {
        return [
            'start_date' => ['type' => Type::string()],
            'end_date' => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $filters = [
            'start_date' => $args['start_date'] ?? null,
            'end_date' => $args['end_date'] ?? null,
        ];

        return app(\App\Repositories\LogRepository::class)->getAll($filters);
    }
}
