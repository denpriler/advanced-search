<?php

namespace App\Http\Services;

use App\Models\Resources\NDItem;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Meilisearch\Client;

class AdvancedSearch
{
    private $client;

    private string $query;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->client = match (env('SCOUT_DRIVER')) {
            'meilisearch' => new Client(env('MEILISEARCH_HOST'), env('MEILISEARCH_KEY')),
            default => throw new \Exception('Search engine is not supported.'),
        };
    }

    public function paginate(string $model, int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        return match (env('SCOUT_DRIVER')) {
            'meilisearch' => $this->meiliSearchPaginate($model, $page, $perPage),
            default => throw new \Exception('Search engine is not supported.'),
        };
    }

    public function query(string $model, string $query, int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        return match (env('SCOUT_DRIVER')) {
            'meilisearch' => $this->meiliSearchQuery($model, $query, $page, $perPage),
            default => throw new \Exception('Search engine is not supported.'),
        };
    }

    private function meiliSearchPaginate(string $model, int $page, int $perPage): LengthAwarePaginator
    {
        $raw = $this->client->index(Str::snake(class_basename($model)) . '_index')
            ->rawSearch(null, [
                'hitsPerPage' => $perPage,
                'page'        => $page
            ]);
        return (new LengthAwarePaginator($raw['hits'], $raw['totalHits'], $perPage, $page))
//            ->setPageName(Str::snake(class_basename($model)) . '_page')
            ->setPath(route('platform.advanced-search.query', ['model' => $model]));
    }

    private function meiliSearchQuery(string $model, $query, int $page, int $perPage): LengthAwarePaginator
    {
        $raw = $this->client->index(Str::snake(class_basename($model)) . '_index')
            ->search($query, [
                'hitsPerPage' => $perPage,
                'page'        => $page
            ])
            ->getRaw();
        return new LengthAwarePaginator($raw['hits'], $raw['totalHits'], $perPage, $page);
    }
}
