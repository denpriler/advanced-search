<?php

namespace App\Orchid\Screens;

use App\View\Components\AdvancedSearchDataTable;
use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout as LayoutFacade;

class AdvancedSearchScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
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
     * @return Layout[]|string[]
     */
    public function layout(): iterable
    {
        $tabs = [];
        foreach (array_keys(config('scout.meilisearch.index-settings')) as $model) {
            $tabs[__('resources.labels.' . $model::slug())] = LayoutFacade::component(AdvancedSearchDataTable::class)->with(['model' => $model]);
        }
        return [
            LayoutFacade::view('search.search'),
            LayoutFacade::tabs($tabs)
        ];
    }
}
