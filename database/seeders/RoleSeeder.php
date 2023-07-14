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
    }
}
