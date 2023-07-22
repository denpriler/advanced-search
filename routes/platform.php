<?php

declare(strict_types=1);

use App\Http\Controllers\AdvancedSearchController;
use App\Models\Resources\HomeAdvisorItem;
use App\Models\Resources\NDItem;
use App\Models\Resources\YelpItem;
use App\Orchid\Screens\ParserHistoryScreen;
use App\Orchid\Screens\ParserListScreen;
use App\Orchid\Screens\Resources\HomeAdvisorItemListScreen;
use App\Orchid\Screens\Resources\HomeAdvisorItemScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Resources\NDItemListScreen;
use App\Orchid\Screens\Resources\NDItemScreen;
use App\Orchid\Screens\Resources\YelpItemListScreen;
use App\Orchid\Screens\Resources\YelpItemScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\SearchScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
//Route::screen('/main', PlatformScreen::class)
//    ->name('platform.main');

Route::redirect('/main', '/advanced-search')->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn(Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn(Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
//Route::screen('example', ExampleScreen::class)
//    ->name('platform.example')
//    ->breadcrumbs(fn (Trail $trail) => $trail
//        ->parent('platform.index')
//        ->push('Example Screen'));
//
//Route::screen('/form/examples/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
//Route::screen('/form/examples/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
//Route::screen('/form/examples/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
//Route::screen('/form/examples/actions', ExampleActionsScreen::class)->name('platform.example.actions');
//
//Route::screen('/layout/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
//Route::screen('/charts/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
//Route::screen('/cards/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

//Route::screen('idea', Idea::class, 'platform.screens.idea');

Route::prefix('parser')->name('platform.parser.')->group(function () {
    Route::screen('list', ParserListScreen::class)->name('list');
    Route::screen('{parser}/history', ParserHistoryScreen::class)->name('history');
});
Route::screen('parsers', ParserListScreen::class)->name('platform.parsers');

Route::prefix(HomeAdvisorItem::slug())->name('platform.' . HomeAdvisorItem::slug() . '.')->group(function () {
    Route::screen('items', HomeAdvisorItemListScreen::class)->name('item.list');
    Route::screen('items/{item?}', HomeAdvisorItemScreen::class)->name('item.view');
});

Route::prefix(NDItem::slug())->name('platform.' . NDItem::slug() . '.')->group(function () {
    Route::screen('items', NDItemListScreen::class)->name('item.list');
    Route::screen('items/{item?}', NDItemScreen::class)->name('item.view');
});

Route::prefix(YelpItem::slug())->name('platform.' . YelpItem::slug() . '.')->group(function () {
    Route::screen('items', YelpItemListScreen::class)->name('item.list');
    Route::screen('items/{item?}', YelpItemScreen::class)->name('item.view');
});

Route::screen('search/{query}', SearchScreen::class)->name('platform.search');

Route::prefix('advanced-search')->group(function () {
    Route::get('query/{model}', [AdvancedSearchController::class, 'query'])->name('platform.advanced-search.query');
    Route::get('/', [AdvancedSearchController::class, 'view'])->name('platform.advanced-search');
});
