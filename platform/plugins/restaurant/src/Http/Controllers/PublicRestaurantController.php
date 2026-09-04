<?php

namespace Botble\Restaurant\Http\Controllers;

use Botble\Restaurant\Models\Restaurant;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Slug\Facades\SlugHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class PublicRestaurantController extends Controller
{
    public function index()
    {
        SeoHelper::setTitle(trans('plugins/restaurant::restaurant.name'));

        Theme::breadcrumb()->add(
            trans('plugins/restaurant::restaurant.name'),
            route('public.restaurants')
        );

        $restaurants = Restaurant::query()
            ->wherePublished()
            ->with('slugable')
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        return Theme::scope('restaurants', compact('restaurants'))->render();
    }

    public function show(string $key)
    {
        $slug = SlugHelper::getSlug($key, SlugHelper::getPrefix(Restaurant::class));

        abort_unless($slug, 404);

        $restaurant = Restaurant::query()
            ->wherePublished()
            ->with('slugable')
            ->findOrFail($slug->reference_id);

        SeoHelper::setTitle($restaurant->name)
            ->setDescription(Str::words((string) $restaurant->description, 60));

        if ($image = $restaurant->image) {
            SeoHelper::openGraph()->setImage($image);
        }

        Theme::breadcrumb()
            ->add(trans('plugins/restaurant::restaurant.name'), route('public.restaurants'))
            ->add($restaurant->name, $restaurant->url);

        $others = Restaurant::query()
            ->wherePublished()
            ->with('slugable')
            ->whereNot('id', $restaurant->id)
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        // Ảnh, video và VR360 do plugin Gallery quản lý (bảng gallery_meta).
        $galleryItems = function_exists('gallery_meta_data')
            ? array_values(array_filter(
                gallery_meta_data($restaurant) ?: [],
                fn ($item) => ! empty($item['img'])
            ))
            : [];

        if (! $galleryItems) {
            foreach ($restaurant->images as $image) {
                $galleryItems[] = ['img' => $image, 'type' => 'image', 'description' => ''];
            }

            foreach ($restaurant->videos as $video) {
                $galleryItems[] = $video;
            }
        }

        return Theme::scope(
            'restaurant',
            compact('restaurant', 'others', 'galleryItems')
        )->render();
    }
}
