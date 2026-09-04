<?php

return [
    [
        'name' => 'Restaurants',
        'flag' => 'restaurant.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'restaurant.create',
        'parent_flag' => 'restaurant.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'restaurant.edit',
        'parent_flag' => 'restaurant.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'restaurant.destroy',
        'parent_flag' => 'restaurant.index',
    ],
];
