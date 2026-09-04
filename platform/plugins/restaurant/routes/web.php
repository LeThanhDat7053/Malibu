<?php

use Botble\Base\Facades\BaseHelper;
use Botble\Restaurant\Models\Restaurant;
use Botble\Slug\Facades\SlugHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Botble\Restaurant\Http\Controllers',
    'middleware' => ['web', 'core'],
], function (): void {
    Route::group([
        'prefix' => BaseHelper::getAdminPrefix() . '/restaurants',
        'as' => 'restaurant.',
        'middleware' => 'auth',
    ], function (): void {
        Route::resource('', 'RestaurantController')->parameters(['' => 'restaurant']);
    });

    if (defined('THEME_MODULE_SCREEN_NAME')) {
        Theme::registerRoutes(function (): void {
            $prefix = SlugHelper::getPrefix(Restaurant::class, 'nha-hang');

            Route::get($prefix, 'PublicRestaurantController@index')
                ->name('public.restaurants');

            Route::get($prefix . '/{slug}', 'PublicRestaurantController@show')
                ->name('public.restaurant');
        });
    }
});
