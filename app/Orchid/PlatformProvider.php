<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Models\Resources\HomeAdvisorItem;
use App\Models\Resources\NDItem;
use App\Models\Resources\YelpItem;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

//        $dashboard->registerResource('stylesheet', \Vite::asset('resources/sass/app.scss'));
//        $dashboard->registerResource('script', \Vite::asset('resources/js/app.js'));
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            // Menu::make('Get Started')
            //     ->icon('bs.book')
            //     ->title('Navigation')
            //     ->route(config('platform.index')),

            // Menu::make('Example Screen')
            //     ->icon('bs.collection')
            //     ->route('platform.example')
            //     ->badge(fn () => 6),

            // Menu::make('Form Elements')
            //     ->icon('bs.journal')
            //     ->route('platform.example.fields')
            //     ->active('*/form/examples/*'),

            // Menu::make('Overview Layouts')
            //     ->icon('bs.columns-gap')
            //     ->route('platform.example.layouts')
            //     ->active('*/layout/examples/*'),

            // Menu::make('Charts')
            //     ->icon('bs.bar-chart')
            //     ->route('platform.example.charts'),

            // Menu::make('Cards')
            //     ->icon('bs.card-text')
            //     ->route('platform.example.cards')
            //     ->divider(),

            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('sidebar.labels.access-control')),

            Menu::make(__('Roles'))
                ->icon('bs.lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),

            Menu::make(__('sidebar.labels.resources'))
                ->icon('bs.folder')
                ->divider()
                ->list([
                    Menu::make(__('sidebar.resources.' . HomeAdvisorItem::slug()))
                        ->route('platform.' . HomeAdvisorItem::slug() . '.item.list')
                        ->permission('manager.' . HomeAdvisorItem::slug()),
                    Menu::make(__('sidebar.resources.' . NDItem::slug()))
                        ->route('platform.' . NDItem::slug() . '.item.list')
                        ->permission('manager.' . NDItem::slug()),
                    Menu::make(__('sidebar.resources.' . YelpItem::slug()))
                        ->route('platform.' . YelpItem::slug() . '.item.list')
                        ->permission('manager.' . YelpItem::slug())
                ]),

            Menu::make(__('sidebar.labels.advanced-search'))
                ->icon('bs.search')
                ->route('platform.advanced-search')
                ->permission('manager.*')

            // Menu::make('Documentation')
            //     ->title('Docs')
            //     ->icon('bs.box-arrow-up-right')
            //     ->url('https://orchid.software/en/docs')
            //     ->target('_blank'),

            // Menu::make('Changelog')
            //     ->icon('bs.box-arrow-up-right')
            //     ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
            //     ->target('_blank')
            //     ->badge(fn () => Dashboard::version(), Color::DARK),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
            ItemPermission::group(__('permissions.groups.manager'))
                ->addPermission('manager.' . HomeAdvisorItem::slug(), __('permissions.permissions.manager.home_advisor'))
                ->addPermission('manager.' . NDItem::slug(), __('permissions.permissions.manager.nd'))
                ->addPermission('manager.' . YelpItem::slug(), __('permissions.permissions.manager.yelp'))
        ];
    }
}
