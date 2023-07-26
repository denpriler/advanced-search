<?php

namespace App\Http\Services\AdvancedSearch;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Meilisearch\Client;

class MeilisearchAdvancedSearch extends AdvancedSearch
{
    private ?string $anyWordsQuery = null;
    private ?string $noneWordsQuery = null;
    private ?Carbon $startDate = null;
    private ?Carbon $endDate = null;

    public function __construct()
    {
        $this->client = new Client(env('MEILISEARCH_HOST'), env('MEILISEARCH_KEY'));
    }

    public function paginate(int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $raw = $this->client->index($this->model::slug() . '_index')
            ->rawSearch(null, [
                'hitsPerPage' => $perPage,
                'page'        => $page
            ]);
        return (new LengthAwarePaginator($raw['hits'], $raw['totalHits'], $perPage, $page))
            ->setPath(route('platform.advanced-search.query', ['model' => $this->model]));
    }

    private function generateFilter(): array
    {
        $filter = [];

        if ($this->anyWordsQuery) {
            $phrases = collect(preg_split('/or/i', strtolower($this->anyWordsQuery)))
                ->map(fn(string $chunk) => trim($chunk))
                ->join(', ');
            $orFilter = collect($this->model::SCOUT_SEARCHABLE_ATTRIBUTES)
                ->map(fn(string $attribute) => "($attribute IN [$phrases])")
                ->join(' OR ');
            $filter[] = $orFilter;
        }

        if ($this->noneWordsQuery) {
            $phrases = collect(preg_split('/,/i', strtolower($this->noneWordsQuery)))
                ->map(function (string $chunk) {
                    $trim = trim($chunk);
                    return $trim[0] === '-' ? substr($trim, 1) : $trim;
                })
                ->join(', ');
            $noneFilter = collect($this->model::SCOUT_SEARCHABLE_ATTRIBUTES)
                ->map(fn(string $attribute) => "($attribute NOT IN [$phrases])")
                ->join(' AND ');
            $filter[] = $noneFilter;
        }

        $dateFilter = null;
        if ($this->startDate) {
            $dateFilter = 'timestamp >= ' . $this->startDate->timestamp;
        }
        if ($this->endDate) {
            if ($dateFilter) {
                $dateFilter = "$dateFilter AND timestamp <= " . $this->endDate->timestamp;
            } else {
                $dateFilter = 'timestamp <= ' . $this->endDate->timestamp;
            }
        }
        if ($dateFilter) {
            $filter[] = $dateFilter;
        }

        return $filter;
    }

    /**
     * @throws \Exception
     */
    public function query(string $query, int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $raw = $this->client->index($this->model::slug() . '_index')
            ->search($query, [
                'hitsPerPage' => $perPage,
                'page'        => $page,
                'filter'      => $this->generateFilter()
            ])
            ->getRaw();
        return (new LengthAwarePaginator($raw['hits'], $raw['totalHits'], $perPage, $page))
            ->setPath(route('platform.advanced-search.query', ['model' => $this->model]));
    }

    public function pushAnyWordsQuery(string $query): static
    {
        $this->anyWordsQuery = $query;
        return $this;
    }

    public function pushNoneWordsQuery(string $query): static
    {
        $this->noneWordsQuery = $query;
        return $this;
    }

    public function pushStartDate(Carbon $startDate): static
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function pushEndDate(Carbon $endDate): static
    {
        $this->endDate = $endDate;
        return $this;
    }
}
