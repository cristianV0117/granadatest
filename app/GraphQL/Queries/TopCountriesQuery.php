<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Collection;
use Rebing\GraphQL\Support\Query;
use Illuminate\Support\Facades\Http;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\UseCases\StoreLog\StoreLogDTO;
use App\UseCases\StoreLog\StoreLogAction;

class TopCountriesQuery extends Query
{
    protected $attributes = [
        'name' => 'topCountries'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Country'));
    }

    public function args(): array
    {
        return [
            'username' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'limit' => [
                'type' => Type::nonNull(Type::int()),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $response = Http::get('https://restcountries.com/v3.1/all?fields=name,area,population');

        $countries = $this->formatCountriesWithSpecifications(response: $response, args: $args);
        
        $storeLog = app(StoreLogAction::class);
        $storeLog->execute(new StoreLogDTO(
            username: $args['username'],
            numCountries: $countries->count(),
            countries: $countries->toArray()
        ));

        return $countries;
    }

    private function formatCountriesWithSpecifications(mixed $response, array $args): Collection
    {
        return collect($response->json())
            ->filter(fn ($c) => isset($c['area'], $c['population']) && $c['area'] > 0)
            ->map(fn ($c) => [
                'name' => $c['name']['common'] ?? '',
                'area' => $c['area'],
                'population' => $c['population'],
                'density' => $c['population'] / $c['area'],
            ])
            ->sortByDesc('density')
            ->take(min($args['limit'], 50))
            ->values();

    }
}
