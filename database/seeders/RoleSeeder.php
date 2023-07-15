<?php

namespace Database\Seeders;

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
                    'manager.home_advisor' => 1,
                    'manager.nd'           => 1,
                    'manager.yelp'         => 1
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
                    'manager.home_advisor' => 1
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
                    'manager.nd' => 1
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
                    'manager.yelp' => 1
                ]
            ]
        );
    }
}
