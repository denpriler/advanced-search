<?php

namespace App\Http\Controllers;

use App\Http\Services\AdvancedSearch\AdvancedSearch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    public function query(Request $request): string
    {
        $model = $request->query('model');

        if(!$model) {
            throw new NotFoundHttpException();
        }

        $this->search->setModel($model);

        $query = $request->query('all_words', '');
        $anyWordsQuery = $request->query('any_words', false);
        $noneWordsQuery = $request->query('none_words', false);

        $startDate = $request->query('date_from', false);
        $endDate = $request->query('date_to', false);

        $perPage = $request->query('length', 10);
        $page = ($request->query('start') / $perPage) + 1;

        if ($anyWordsQuery && strlen($anyWordsQuery)) {
            $this->search->pushAnyWordsQuery($anyWordsQuery);
        }

        if ($noneWordsQuery && strlen($noneWordsQuery)) {
            $this->search->pushNoneWordsQuery($noneWordsQuery);
        }

        if ($startDate && strlen($startDate)) {
            $this->search->pushStartDate(Carbon::createFromTimestamp($startDate)->startOfDay());
        }

        if ($endDate && strlen($endDate)) {
            $this->search->pushEndDate(Carbon::createFromTimestamp($endDate)->endOfDay());
        }

        try {
            return $this->search->query($query, $page, $perPage)->toJson();
        } catch (\Exception $e) {
            \Debugbar::addThrowable($e);
            return (new LengthAwarePaginator([], 0, $page))->toJson();
        }
    }
}
