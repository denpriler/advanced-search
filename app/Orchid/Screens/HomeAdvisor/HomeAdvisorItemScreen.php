<?php

namespace App\Orchid\Screens\HomeAdvisor;

use App\Models\HomeAdvisor\HomeAdvisorItem;
use Orchid\Screen\Action;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Orchid\Screen\Screen;

class HomeAdvisorItemScreen extends Screen
{
    public $item;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(HomeAdvisorItem $item): iterable
    {
        return [
            'item' => $item
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->item->name;
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
            Layout::legend('item', [
                Sight::make('id', 'ID'),
                Sight::make('name', mb_convert_case(__('validation.attributes.name'), MB_CASE_TITLE, "UTF-8")),
                Sight::make('rating', mb_convert_case(__('validation.attributes.rating'), MB_CASE_TITLE, "UTF-8")),
                Sight::make('details', mb_convert_case(__('validation.attributes.description'), MB_CASE_TITLE, "UTF-8")),
            ]),
        ];
    }
}
