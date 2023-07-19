<?php

namespace App\Providers;

use App\Http\Services\AdvancedSearch\AdvancedSearch;
use App\Http\Services\AdvancedSearch\MeilisearchAdvancedSearch;
use Illuminate\Support\ServiceProvider;
use Yajra\DataTables\Html\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AdvancedSearch::class, function () {
            return match (env('SCOUT_DRIVER')) {
                'meilisearch' => new MeilisearchAdvancedSearch(),
                default => throw new \Exception('Search engine is not supported.'),
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Builder::useVite();
    }
}
