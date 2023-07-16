<?php

namespace App\Orchid\Screens\Resources;

use App\Models\Resources\HomeAdvisorItem;
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
                    Sight::make('name', ucfirst(__('validation.attributes.name'))),
                    Sight::make('website', ucfirst(__('validation.attributes.website'))),
                    Sight::make(
                        'homeadvisor_url',
                        __('resources.labels.home-advisor') . ' ' . ucfirst(__('validation.attributes.url'))
                    ),
                    Sight::make('phone', ucfirst(__('validation.attributes.phone'))),
                    Sight::make('email', ucfirst(__('validation.attributes.email'))),
                    Sight::make('country', ucfirst(__('validation.attributes.country'))),
                    Sight::make('address', ucfirst(__('validation.attributes.address'))),
                    Sight::make('city', ucfirst(__('validation.attributes.city'))),
                    Sight::make('state_region', ucfirst(__('validation.attributes.state'))),
                    Sight::make('zip', ucfirst(__('validation.attributes.postal_code'))),
                    Sight::make('bizid', strtoupper('biz id')),
                    Sight::make('category', ucfirst(__('validation.attributes.category')))
                        ->render(fn($entity) => view('legends.list', ['list' => preg_split("/\|/", $entity->category)])),
                    Sight::make('rating', ucfirst(__('validation.attributes.rating'))),
                    Sight::make('details', ucfirst(__('validation.attributes.description'))),
                    Sight::make('highly_rated_for', ucfirst(__('validation.attributes.highly_rated_for')))
                        ->render(fn($entity) => view('legends.list', ['list' => preg_split("/\|/", $entity->highly_rated_for)])),
                    Sight::make('reviews_qty', ucfirst(__('validation.attributes.reviews_qty'))),
                    Sight::make('approved_status', ucfirst(__('validation.attributes.approved_status')))
                        ->render(fn($entity) => view('legends.boolean', ['value' => $entity->approved_status])),
                    Sight::make('recommend', ucfirst(__('validation.attributes.recommend'))),
                    Sight::make('years_in_business', ucfirst(__('validation.attributes.years_in_business'))),
                    Sight::make('cities_served', ucfirst(__('validation.attributes.cities_served')))
                        ->render(fn($entity) => view('legends.list', ['list' => preg_split("/\|/", $entity->cities_served)])),
                    Sight::make('allservices', ucfirst(__('validation.attributes.allservices')))
                        ->render(fn($entity) => view('legends.list', ['list' => preg_split("/\|/", $entity->allservices)])),
                    Sight::make('cost', ucfirst(__('validation.attributes.cost')))
                        ->render(fn($entity) => view('legends.list', ['list' => preg_split("/\|/", $entity->cost)])),
                    Sight::make('alias', ucfirst(__('validation.attributes.alias')))
                ]
            ),
        ];
    }
}
