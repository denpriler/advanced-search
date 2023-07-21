<?php

namespace App\Orchid\Screens\Resources;

use App\Models\Resources\NDItem;
use App\Orchid\Filters\IDFilter;
use App\Orchid\Filters\WhereLikeFilter;

//use App\View\Components\TableSearchInput;
use App\Orchid\Layouts\ResourceFilterSelection;
use App\Orchid\Layouts\Resources\NDItemTable;
use Orchid\Screen\Action;
use Orchid\Screen\Screen;

//use Orchid\Support\Facades\Layout as LayoutFacade;

class NDItemListScreen extends Screen
{
    private array $filters;

    public function __construct()
    {
        $this->filters = [
            IDFilter::class,
            new WhereLikeFilter('name'),
            new WhereLikeFilter('phone'),
            new WhereLikeFilter('email'),
            new WhereLikeFilter('url')
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
            'items' => NDItem::filters($this->filters)->defaultSort('updated_on')->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('resources.labels.' . NDItem::slug());
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
            NDItemTable::class
        ];
    }
}
