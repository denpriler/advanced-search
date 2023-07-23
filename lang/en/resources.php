<?php

use App\Models\Resources\HomeAdvisorItem;
use App\Models\Resources\NDItem;
use App\Models\Resources\YelpItem;

return [
    'labels'      => [
        HomeAdvisorItem::slug() => 'Home Advisor',
        NDItem::slug()          => 'ND',
        YelpItem::slug()        => 'Yelp'
    ],
    'search'      => [
        'labels'  => [
            'full-text-search' => 'Full Text Search'
        ],
        'inputs'  => [
            'search' => 'Search...'
        ],
        'buttons' => [
            'search' => 'Search'
        ]
    ],
    'filters'     => [
        'ID'            => [
            'title'       => 'ID',
            'placeholder' => 'Search by ID'
        ],
        'where-like'    => [
            'placeholder' => 'Search by :parameter'
        ],
        'date-interval' => [
            'from_title'       => 'Start date',
            'to_title'         => 'End date',
            'from_placeholder' => 'Search from date',
            'to_placeholder'   => 'Search to date'
        ]
    ],
    'description' => [
        'history' => 'History of :count last records.'
    ]
];
