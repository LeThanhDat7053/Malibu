<?php

namespace Botble\Product\Tables;

use Botble\Product\Models\ProductOrder;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;

class ProductOrderTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(ProductOrder::class)
            ->addActions([
                EditAction::make()->route('product-order.edit'),
                DeleteAction::make()->route('product-order.destroy'),
            ]);
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('total_amount', function (ProductOrder $item) {
                return number_format($item->total_amount, 0, ',', '.') . ' VND';
            })
            ->editColumn('service_date', function (ProductOrder $item) {
                if (! $item->service_date) {
                    return '-';
                }

                $date = $item->service_date->format('d/m/Y');
                $time = $item->service_time ? \Carbon\Carbon::parse($item->service_time)->format('H:i') : '';

                return $time ? $date . ' ' . $time : $date;
            });

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this
            ->getModel()
            ->query()
            ->select([
                'id',
                'order_number',
                'customer_name',
                'customer_email',
                'customer_phone',
                'service_date',
                'service_time',
                'total_amount',
                'status',
                'created_at',
            ]);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            Column::make('order_number')
                ->title(trans('plugins/product::product.order_number'))
                ->alignLeft(),
            Column::make('customer_name')
                ->title(trans('plugins/product::product.customer_name'))
                ->alignLeft(),
            Column::make('customer_phone')
                ->title(trans('plugins/product::product.customer_phone')),
            Column::make('total_amount')
                ->title(trans('plugins/product::product.total_amount')),
            Column::make('service_date')
                ->title(trans('plugins/product::product.service_date'))
                ->width(150),
            Column::make('status')
                ->title(trans('core/base::tables.status')),
            CreatedAtColumn::make(),
        ];
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()->permission('product-order.destroy'),
        ];
    }
}
