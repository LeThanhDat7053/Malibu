<?php

namespace Botble\Restaurant\Tables;

use Botble\Restaurant\Models\Restaurant;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\ImageColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;

class RestaurantTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Restaurant::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('restaurant.create'))
            ->addActions([
                EditAction::make()->route('restaurant.edit'),
                DeleteAction::make()->route('restaurant.destroy'),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('restaurant.destroy'),
            ]);
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('location', fn (Restaurant $item) => $item->location ?: '—')
            ->editColumn('opening_hours', fn (Restaurant $item) => $item->opening_hours ?: '—');

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this
            ->getModel()
            ->query()
            ->select([
                'id',
                'name',
                'images',
                'location',
                'opening_hours',
                'order',
                'status',
                'created_at',
            ]);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            ImageColumn::make(),
            NameColumn::make()->route('restaurant.edit'),
            Column::make('location')->title(trans('plugins/restaurant::restaurant.location')),
            Column::make('opening_hours')->title(trans('plugins/restaurant::restaurant.opening_hours')),
            Column::make('order')->title(trans('core/base::forms.sort_order'))->width(60),
            CreatedAtColumn::make(),
            StatusColumn::make(),
        ];
    }

    public function getDefaultButtons(): array
    {
        return ['export', 'reload'];
    }
}
