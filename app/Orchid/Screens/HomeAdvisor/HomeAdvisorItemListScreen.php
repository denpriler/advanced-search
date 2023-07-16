<?php

namespace App\Orchid\Screens\HomeAdvisor;

use App\Models\HomeAdvisor\HomeAdvisorItem;
use App\Orchid\Filters\IDFilter;
use App\Orchid\Filters\WhereLikeFilter;
use App\Orchid\Layouts\HomeAdvisor\HomeAdvisorItemTable;

//use App\View\Components\TableSearchInput;
use App\Orchid\Layouts\ResourceFilterSelection;
use Orchid\Screen\Action;
use Orchid\Screen\Screen;

//use Orchid\Support\Facades\Layout as LayoutFacade;

class HomeAdvisorItemListScreen extends Screen
{
    private array $filters;

    public function __construct()
    {
        $this->filters = [
            IDFilter::class,
            new WhereLikeFilter('name'),
            new WhereLikeFilter('phone'),
            new WhereLikeFilter('email'),
            new WhereLikeFilter('website')
        ];
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'items' => HomeAdvisorItem::filters($this->filters)->defaultSort('updated_on')->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('resources.labels.home-advisor');
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
     */
    public function layout(): iterable
    {
        return [
            new ResourceFilterSelection($this->filters),
            HomeAdvisorItemTable::class
        ];
    }
}
