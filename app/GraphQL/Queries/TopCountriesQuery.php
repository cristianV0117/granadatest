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
use App\UseCases\Log\Dtos\StoreLogDTO;
use App\UseCases\Log\StoreLogAction;

class TopCountriesQuery extends Query
{
    protected $attributes = [
        'name' => 'topCountries'
    ];

    public function type(): Type
    {
        return GraphQL::paginate(GraphQL::type('Country'));
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
            'page' => [
                'type' => Type::int(),
                'defaultValue' => 1,
            ],
            'perPage' => [
                'type' => Type::int(),
                'defaultValue' => 10,
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $response = Http::get('https://restcountries.com/v3.1/all?fields=name,area,population');
        $storeLog = app(StoreLogAction::class);
        $limit = min($args['limit'], 50);
        
        $countries = $this->formatCountriesWithSpecifications($response)->take($limit)->values();

        if ($countries->isEmpty()) {
            $storeLog->execute(new StoreLogDTO(
                username: $args['username'],
                numCountries: 0,
                countries: [
                    "message" => "No se encontró información"
                ]
            ));
        }

        if ($limit <= 10) {
            $storeLog->execute(new StoreLogDTO(
                username: $args['username'],
                numCountries: $countries->count(),
                countries: $countries->toArray()
            ));

            return new \Illuminate\Pagination\LengthAwarePaginator(
                $countries,
                $countries->count(),
                $limit,
                1,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        // Paginación cuando limit > 10
        $page = max($args['page'], 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $pagedCountries = $countries->slice($offset, $perPage);

        $storeLog->execute(new StoreLogDTO(
            username: $args['username'],
            numCountries: $pagedCountries->count(),
            countries: $pagedCountries->toArray()
        ));

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedCountries,
            $countries->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    private function formatCountriesWithSpecifications(mixed $response): Collection
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
            ->values();

    }
}
