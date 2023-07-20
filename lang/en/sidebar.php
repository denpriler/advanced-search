<?php

use App\Models\Resources\HomeAdvisorItem;
use App\Models\Resources\NDItem;
use App\Models\Resources\YelpItem;

return [
    'labels'    => [
        'access-control'  => 'Access Control',
        'advanced-search' => 'Advanced Search',
        'items'           => 'Items',
        'resources'       => 'Resources',
        'parsers'         => 'Parsers'
    ],
    'resources' => [
        HomeAdvisorItem::slug() => 'Home Advisor',
        NDItem::slug()          => 'ND',
        YelpItem::slug()        => 'Yelp'
    ]
];
