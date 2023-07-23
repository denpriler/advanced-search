<?php

namespace App\Orchid\Screens\Resources;

use App\Models\Resources\HomeAdvisorItem;
use App\Orchid\Filters\DateIntervalFilter;
use App\Orchid\Filters\IDFilter;
use App\Orchid\Filters\WhereLikeFilter;
use App\Orchid\Layouts\Resources\HomeAdvisorItemTable;

//use App\View\Components\TableSearchInput;
use App\Orchid\Layouts\ResourceFilterSelection;
use JetBrains\PhpStorm\Pure;
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
            new WhereLikeFilter('website'),
            new DateIntervalFilter(HomeAdvisorItem::CREATED_AT)
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
        return __('resources.labels.' . HomeAdvisorItem::slug());
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
    #[Pure] public function layout(): iterable
    {
        return [
            new ResourceFilterSelection($this->filters),
            HomeAdvisorItemTable::class
        ];
    }
}
