<?php

namespace App\Http\Controllers;

use App\Http\Services\AdvancedSearch;
use App\Models\Resources\HomeAdvisorItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Orchid\Screen\Builder;
use Orchid\Screen\Fields\Input;

class AdvancedSearchController extends Controller
{
    private AdvancedSearch $search;

    public function __construct(AdvancedSearch $search)
    {
        $this->search = $search;
    }

    /**
     * @throws \Exception
     */
    public function query(string $model, Request $request): string
    {
        $query = $request->query('all_words');
        $perPage = $request->query('length', 10);
        $page = ($request->query('start') / $perPage) + 1;

        $paginate = $query
            ? $this->search->query($model, $query, $page, $perPage)
            : $this->search->paginate($model, $page, $perPage);
        return $paginate->toJson();
    }

    /**
     * @throws \Exception
     */
    public function view(): mixed
    {
        return view('search.search', ['models' => array_keys(config('scout.meilisearch.index-settings'))]);
    }
}
