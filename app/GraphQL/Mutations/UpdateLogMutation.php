<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\UseCases\Log\Dtos\UpdateLogDTO;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use \Rebing\GraphQL\Support\Facades\GraphQL;
use App\UseCases\Log\UpdateLogAction;

class UpdateLogMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateLog',
        'description' => 'Actualiza el nombre de usuario de un log'
    ];

    public function type(): Type
    {
        return GraphQL::type('LogType');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID del log',
            ],
            'username' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Nuevo nombre de usuario',
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $action = app(UpdateLogAction::class);
        return $action->execute($args['id'], new UpdateLogDTO($args['username']));
    }
}
