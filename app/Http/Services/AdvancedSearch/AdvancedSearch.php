<?php

namespace App\Http\Services\AdvancedSearch;

use Illuminate\Pagination\LengthAwarePaginator;

abstract class AdvancedSearch
{
    protected string $model;

    public function setModel(string $model): static
    {
        $this->model = $model;
        return $this;
    }

    public abstract function pushAnyWordsQuery(string $query): static;

    public abstract function pushNoneWordsQuery(string $query): static;

    public abstract function paginate(int $page = 1, int $perPage = 10): LengthAwarePaginator;

    public abstract function query(string $query, int $page = 1, int $perPage = 10): LengthAwarePaginator;
}
