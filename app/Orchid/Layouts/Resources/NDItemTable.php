<?php

namespace App\Orchid\Layouts\Resources;

use App\Models\Resources\NDItem;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class NDItemTable extends Table
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
            TD::make('id', 'ID'),
            TD::make('name', ucfirst(__('validation.attributes.name')))
                ->render(function (NDItem $item) {
                    return Link::make($item->name)
                        ->route('platform.' . NDItem::slug() . '.item.view', $item);
                })
                ->sort(),
            TD::make('email', ucfirst(__('validation.attributes.email')))
                ->sort(),
            TD::make('phone', ucfirst(__('validation.attributes.phone')))
                ->sort(),
            TD::make('url', ucfirst(__('validation.attributes.website')))
                ->sort()
        ];
    }
}
