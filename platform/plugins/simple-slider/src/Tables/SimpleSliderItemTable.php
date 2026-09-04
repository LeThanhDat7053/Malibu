<?php

namespace Botble\SimpleSlider\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Language\Facades\Language;
use Botble\SimpleSlider\Models\SimpleSliderItem;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\Action;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class SimpleSliderItemTable extends TableAbstract
{
    public function setup(): void
    {
        $defaultLocale = Language::getDefaultLocaleCode();
        $refLang = Language::getCurrentAdminLocaleCode();

        if ($refLang === $defaultLocale || $refLang === 'all') {
            $refLang = null;
        }

        $isTranslatedPage = $refLang && $refLang !== Language::getDefaultLocaleCode();

        $this
            ->model(SimpleSliderItem::class)
            ->setView('plugins/simple-slider::items')
            ->setDom($this->simpleDom())
            ->addColumns([
                IdColumn::make(),
                ImageColumn::make(),
                FormattedColumn::make('title')
                    ->title(trans('core/base::tables.title'))
                    ->alignStart()
                    ->getValueUsing(function (FormattedColumn $column) use ($refLang) {
                        $item = $column->getItem();
                        $name = BaseHelper::clean($item->title ?: '#' . $item->getKey());

                        if (! $this->hasPermission('simple-slider-item.edit')) {
                            return $name;
                        }

                        $editUrl = route('simple-slider-item.edit', $item->getKey());

                        if ($refLang) {
                            $editUrl .= '?' . http_build_query(['ref_lang' => $refLang]);
                        }

                        return Html::link($editUrl, $name, [
                            'data-bs-toggle' => 'modal',
                            'data-bs-target' => '#simple-slider-item-modal',
                        ]);
                    }),
                Column::make('order')
                    ->title(trans('core/base::tables.order'))
                    ->className('text-start order-column'),
                CreatedAtColumn::make(),
            ])
            ->addActions(array_filter([
                EditAction::make()
                    ->url(function (Action $action) use ($refLang) {
                        $url = route('simple-slider-item.edit', $action->getItem()->getKey());

                        if ($refLang) {
                            $url .= '?' . http_build_query(['ref_lang' => $refLang]);
                        }

                        return $url;
                    })
                    ->attributes([
                        'data-bs-toggle' => 'modal',
                        'data-bs-target' => '#simple-slider-item-modal',
                    ])
                    ->permission('simple-slider-item.edit'),
                $isTranslatedPage ? null : DeleteAction::make()
                    ->route('simple-slider-item.destroy')
                    ->permission('simple-slider-item.destroy'),
            ]))
            ->queryUsing(function (Builder $query) use ($refLang) {
                return $query
                    ->when(
                        $refLang && $refLang !== Language::getDefaultLocaleCode(),
                        function (Builder $query) use ($refLang): void {
                            $query
                                ->leftJoin('simple_slider_items_translations as ssit', function ($join) use ($refLang): void {
                                    $join
                                        ->on('ssit.simple_slider_items_id', '=', 'simple_slider_items.id')
                                        ->where('ssit.lang_code', $refLang);
                                })
                                ->select([
                                    'simple_slider_items.id',
                                    DB::raw('COALESCE(NULLIF(ssit.title, ""), simple_slider_items.title) as title'),
                                    'simple_slider_items.image',
                                    'simple_slider_items.order',
                                    'simple_slider_items.created_at',
                                ]);
                        },
                        function (Builder $query): void {
                            $query->select([
                                'simple_slider_items.id',
                                'simple_slider_items.title',
                                'simple_slider_items.image',
                                'simple_slider_items.order',
                                'simple_slider_items.created_at',
                            ]);
                        }
                    )
                    ->oldest('order')
                    ->where('simple_slider_id', request()->route()->parameter('id'));
            });
    }
}
