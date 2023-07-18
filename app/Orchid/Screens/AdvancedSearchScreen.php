<?php

namespace App\Orchid\Screens;

use App\Http\Services\AdvancedSearch;
use App\Orchid\Layouts\AdvancedSearchListener;
use App\Orchid\Layouts\AdvancedSearchResultTable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\Builder;
use Orchid\Support\Facades\Layout as LayoutFacade;

class AdvancedSearchScreen extends Screen
{
    private AdvancedSearch $search;

//    private string $query;

    public function __construct(AdvancedSearch $search)
    {
        $this->search = $search;
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     * @throws \Exception
     */
    public function query(): iterable
    {
        $query = [];
        foreach (config('scout.meilisearch.index-settings') as $model => $config) {
            $query[$model] = $this->search->paginate($model, LengthAwarePaginator::resolveCurrentPage(Str::snake(class_basename($model)) . '_page'));
        }
        return $query;
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('advanced-search.title');
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return iterable
     * @throws \Throwable
     */
    public function layout(): iterable
    {
        return [
            AdvancedSearchListener::class,
        ];
    }
}
