<?php

namespace App\Orchid\Layouts\HomeAdvisor;

use App\Models\HomeAdvisor\HomeAdvisorItem;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class HomeAdvisorItemTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'items';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id'),
            TD::make('name')
                ->render(function (HomeAdvisorItem $item) {
                    return Link::make($item->name)
                        ->route('platform.home-advisor.item.view', $item);
                })
                ->sort(),
            TD::make('rating')
                ->sort()
        ];
    }
}
