<?php

namespace Database\Seeders;

use App\Models\Resources\HomeAdvisorItem;
use App\Models\Resources\NDItem;
use App\Models\Resources\YelpItem;
use Illuminate\Database\Seeder;
use Orchid\Platform\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrCreate(
            [
                'slug' => 'main-manager'
            ],
            [
                'name'        => __('permissions.roles.main-manager'),
                'slug'        => 'main-manager',
                'permissions' => [
                    'manager.' . HomeAdvisorItem::slug() => 1,
                    'manager.' . NDItem::slug()          => 1,
                    'manager.' . YelpItem::slug()        => 1
                ]
            ]
        );
        Role::updateOrCreate(
            [
                'slug' => 'home-advisor-manager'
            ],
            [
                'name'        => __('permissions.roles.home-advisor-manager'),
                'slug'        => 'home-advisor-manager',
                'permissions' => [
                    'manager.' . HomeAdvisorItem::slug() => 1
                ]
            ]
        );
        Role::updateOrCreate(
            [
                'slug' => 'nd-manager'
            ],
            [
                'name'        => __('permissions.roles.nd-manager'),
                'slug'        => 'nd-manager',
                'permissions' => [
                    'manager.' . NDItem::slug() => 1
                ]
            ]
        );
        Role::updateOrCreate(
            [
                'slug' => 'yelp-manager'
            ],
            [
                'name'        => __('permissions.roles.yelp-manager'),
                'slug'        => 'yelp-manager',
                'permissions' => [
                    'manager.' . YelpItem::slug() => 1
                ]
            ]
        );
        Role::updateOrCreate(
            [
                'slug' => 'parser-manager'
            ],
            [
                'name'        => __('permissions.roles.parser-manager'),
                'slug'        => 'parser-manager',
                'permissions' => [
                    'manager.parsers' => 1
                ]
            ]
        );
    }
}
