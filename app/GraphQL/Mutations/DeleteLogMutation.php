<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\UseCases\Log\DeleteLogAction;

class DeleteLogMutation extends Mutation
{
     protected $attributes = [
        'name' => 'deleteLog',
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
            ],
        ];
    }

    public function resolve($root, array $args)
    {
        $action = app(DeleteLogAction::class);
        return $action->execute($args['id']);
    }
}
