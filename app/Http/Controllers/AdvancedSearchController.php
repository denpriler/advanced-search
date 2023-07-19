<?php

namespace App\Http\Controllers;

use App\Http\Services\AdvancedSearch\AdvancedSearch;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $this->search->setModel($model);

        $query = $request->query('all_words', '');
        $anyWordsQuery = $request->query('any_words', false);
        $noneWordsQuery = $request->query('none_words', false);

        $perPage = $request->query('length', 10);
        $page = ($request->query('start') / $perPage) + 1;

        if ($anyWordsQuery && strlen($anyWordsQuery)) {
            $this->search->pushAnyWordsQuery($anyWordsQuery);
        }

        if ($noneWordsQuery && strlen($noneWordsQuery)) {
            $this->search->pushNoneWordsQuery($noneWordsQuery);
        }

        try {
            return $this->search->query($query, $page, $perPage)->toJson();
        } catch (\Exception $e) {
            \Debugbar::addThrowable($e);
            return (new LengthAwarePaginator([], 0, $page))->toJson();
        }
    }

    /**
     * @throws \Exception
     */
    public function view(): mixed
    {
        return view('search.search', ['models' => array_keys(config('scout.meilisearch.index-settings'))]);
    }
}
