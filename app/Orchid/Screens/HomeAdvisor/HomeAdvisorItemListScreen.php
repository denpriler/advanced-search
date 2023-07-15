<?php

namespace App\Orchid\Screens\HomeAdvisor;

use App\Models\HomeAdvisor\HomeAdvisorItem;
use App\Orchid\Layouts\HomeAdvisor\HomeAdvisorItemTable;
use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class HomeAdvisorItemListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'items' => HomeAdvisorItem::paginate()
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
     * @return Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            HomeAdvisorItemTable::class
        ];
    }
}
