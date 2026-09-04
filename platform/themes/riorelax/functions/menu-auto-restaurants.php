<?php

use Botble\Restaurant\Models\Restaurant;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

if (! function_exists('theme_restaurants_menu_tree')) {
    /**
     * Build the "Restaurants" menu: a flat list of published venues.
     *
     * Each node is an object { title, url, active, children }, mirroring the
     * shape used by theme_rooms_menu_tree() so the menu partials can render
     * either tree with the same markup. The result is memoized per request so
     * the desktop and mobile menus share one query.
     */
    function theme_restaurants_menu_tree(): Collection
    {
        static $tree = null;

        if ($tree !== null) {
            return $tree;
        }

        if (! is_plugin_active('restaurant')) {
            return $tree = collect();
        }

        $currentUrl = rtrim((string) request()->url(), '/');

        return $tree = Restaurant::query()
            ->wherePublished()
            ->with('slugable')
            ->orderBy('order')
            ->orderBy('id')
            ->get()
            ->map(fn (Restaurant $restaurant) => (object) [
                'title' => $restaurant->name,
                'url' => $restaurant->url,
                'active' => rtrim((string) $restaurant->url, '/') === $currentUrl,
                'children' => collect(),
            ]);
    }
}

if (! function_exists('theme_is_restaurants_menu_node')) {
    /**
     * Decide whether a menu node should be auto-populated with restaurants.
     *
     * A node qualifies when either:
     *  - its CSS class contains "auto-restaurants" (explicit opt-in), or
     *  - its URL points to the restaurants listing page.
     */
    function theme_is_restaurants_menu_node($node): bool
    {
        if (! is_plugin_active('restaurant')) {
            return false;
        }

        if ($node->css_class && Str::contains($node->css_class, 'auto-restaurants')) {
            return true;
        }

        if (! Illuminate\Support\Facades\Route::has('public.restaurants')) {
            return false;
        }

        $listingPath = rtrim((string) parse_url(route('public.restaurants'), PHP_URL_PATH), '/');
        $nodePath = rtrim((string) parse_url((string) $node->url, PHP_URL_PATH), '/');

        return $listingPath !== '' && $nodePath === $listingPath;
    }
}
