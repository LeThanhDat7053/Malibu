<?php

namespace Botble\Restaurant\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Gallery\Facades\Gallery;
use Botble\Restaurant\Forms\RestaurantForm;
use Botble\Restaurant\Http\Requests\RestaurantRequest;
use Botble\Restaurant\Models\Restaurant;
use Botble\Restaurant\Tables\RestaurantTable;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RestaurantController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/restaurant::restaurant.name'), route('restaurant.index'));
    }

    public function index(RestaurantTable $table)
    {
        $this->pageTitle(trans('plugins/restaurant::restaurant.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/restaurant::restaurant.create'));

        return RestaurantForm::create()->renderForm();
    }

    public function store(RestaurantRequest $request)
    {
        $form = RestaurantForm::create();
        $form->saving(function (RestaurantForm $form) use ($request): void {
            $this->save($form, $request);
        });

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('restaurant.index'))
            ->setNextUrl(route('restaurant.edit', $form->getModel()->getKey()))
            ->withCreatedSuccessMessage();
    }

    public function edit(Restaurant $restaurant)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $restaurant->name]));

        return RestaurantForm::createFromModel($restaurant)->renderForm();
    }

    public function update(Restaurant $restaurant, RestaurantRequest $request)
    {
        $form = RestaurantForm::createFromModel($restaurant);
        $form->saving(function (RestaurantForm $form) use ($request): void {
            $this->save($form, $request);
        });

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('restaurant.index'))
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Restaurant $restaurant)
    {
        return DeleteResourceAction::make($restaurant);
    }

    /**
     * Tách lưới media hợp nhất thành hai cột: images (URL ảnh) và videos (đối tượng),
     * đồng thời lưu vào gallery_meta để lần sửa sau nạp lại được — giống RoomController.
     */
    protected function save(RestaurantForm $form, Request $request): void
    {
        $data = $request->validated();

        $galleryItems = json_decode($request->input('gallery', '[]'), true) ?: [];

        $data['images'] = json_encode(array_values(array_filter(array_map(
            fn ($item) => Arr::get($item, 'type', 'image') === 'image' ? Arr::get($item, 'img') : null,
            $galleryItems
        ))));

        $data['videos'] = json_encode(array_values(array_filter(
            $galleryItems,
            fn ($item) => in_array(Arr::get($item, 'type'), ['video', 'vr360'], true)
        )));

        $form->getModel()->fill($data)->save();

        Gallery::saveGallery($request, $form->getModel());
    }
}
