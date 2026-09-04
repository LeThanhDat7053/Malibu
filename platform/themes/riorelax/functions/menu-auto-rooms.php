<?php

use Botble\Hotel\Models\Room;
use Botble\Hotel\Models\RoomCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

if (! function_exists('theme_rooms_menu_tree')) {
    /**
     * Build the "Rooms" menu as a tree: room categories -> rooms.
     *
     * Each node is an object { title, url, active, children }.
     * - Level 1: published room categories (that have at least one published room),
     *   followed by any published room without a published category.
     * - Level 2: published rooms belonging to the category.
     *
     * Names and URLs are resolved by the models, so they are localized for the
     * current language. The result is memoized per request so the desktop and
     * mobile menus share a single set of queries.
     */
    function theme_rooms_menu_tree(): Collection
    {
        static $tree = null;

        if ($tree !== null) {
            return $tree;
        }

        if (! is_plugin_active('hotel')) {
            return $tree = collect();
        }

        $currentUrl = rtrim((string) request()->url(), '/');

        $makeNode = fn (?string $title, ?string $url, ?Collection $children = null) => (object) [
            'title' => $title,
            'url' => $url,
            'active' => $url && rtrim((string) $url, '/') === $currentUrl,
            'children' => $children ?? collect(),
        ];

        $rooms = Room::query()
            ->wherePublished()
            ->with(['slugable', 'category' => fn ($query) => $query->with('slugable')])
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        // Admin-defined ordering of categories (position map: id => index).
        $categoryOrder = RoomCategory::query()
            ->orderBy('order')
            ->orderBy('id')
            ->pluck('id')
            ->values()
            ->flip()
            ->all();

        // Group each published room under its own category. The category's own
        // published status is intentionally ignored: as long as a category has at
        // least one published room, it appears as a group header. This prevents
        // rooms from being rendered as a flat list when their category is not
        // published.
        $grouped = [];
        $withoutCategory = [];

        foreach ($rooms as $room) {
            $category = $room->category;

            if ($category && $category->getKey()) {
                $key = $category->getKey();
                $grouped[$key]['category'] = $category;
                $grouped[$key]['rooms'][] = $room;
            } else {
                $withoutCategory[] = $room;
            }
        }

        uksort(
            $grouped,
            fn ($a, $b) => ($categoryOrder[$a] ?? PHP_INT_MAX) <=> ($categoryOrder[$b] ?? PHP_INT_MAX)
        );

        $nodes = collect();

        foreach ($grouped as $group) {
            $children = collect($group['rooms'])
                ->map(fn (Room $room) => $makeNode($room->name, $room->url));

            $nodes->push($makeNode($group['category']->name, $group['category']->url, $children));
        }

        // Rooms that genuinely have no category are listed directly.
        foreach ($withoutCategory as $room) {
            $nodes->push($makeNode($room->name, $room->url));
        }

        return $tree = $nodes;
    }
}

if (! function_exists('theme_is_rooms_menu_node')) {
    /**
     * Decide whether a given menu node should be auto-populated with hotel rooms.
     *
     * A node qualifies when either:
     *  - its CSS class contains "auto-rooms" (explicit opt-in), or
     *  - its URL points to the rooms listing page.
     */
    function theme_is_rooms_menu_node($node): bool
    {
        if (! is_plugin_active('hotel')) {
            return false;
        }

        if ($node->css_class && Str::contains($node->css_class, 'auto-rooms')) {
            return true;
        }

        $roomsPath = rtrim((string) parse_url(route('public.rooms'), PHP_URL_PATH), '/');
        $nodePath = rtrim((string) parse_url((string) $node->url, PHP_URL_PATH), '/');

        return $roomsPath !== '' && $nodePath === $roomsPath;
    }
}
