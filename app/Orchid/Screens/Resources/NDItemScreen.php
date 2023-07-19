<?php

namespace App\Orchid\Screens\Resources;

use App\Models\Resources\NDItem;
use Orchid\Screen\Action;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Orchid\Screen\Screen;

class NDItemScreen extends Screen
{
    public $item;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(NDItem $item): iterable
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
     * @return iterable
     */
    public function layout(): iterable
    {
        return [
            Layout::legend('item', [
                    Sight::make('id', 'ID'),
                    Sight::make('name', ucfirst(__('validation.attributes.name'))),
                    Sight::make('url', ucfirst(__('validation.attributes.website'))),
                    Sight::make(
                        'nd_url',
                        __('resources.labels.' . NDItem::slug()) . ' ' . ucfirst(__('validation.attributes.url'))
                    ),
                    Sight::make('phone', ucfirst(__('validation.attributes.phone'))),
                    Sight::make('email', ucfirst(__('validation.attributes.email'))),
                    Sight::make('country', ucfirst(__('validation.attributes.country'))),
                    Sight::make('address', ucfirst(__('validation.attributes.address'))),
                    Sight::make('city', ucfirst(__('validation.attributes.city'))),
                    Sight::make('state_region', ucfirst(__('validation.attributes.state'))),
                    Sight::make('streetnumber', ucfirst(__('validation.attributes.street_number'))),
                    Sight::make('unitnumber', ucfirst(__('validation.attributes.unit_number'))),
                    Sight::make('zip', ucfirst(__('validation.attributes.postal_code'))),
                    Sight::make('bizid', strtoupper('biz id')),
                    Sight::make('alias', ucfirst(__('validation.attributes.alias')))
                ]
            ),
        ];
    }
}
