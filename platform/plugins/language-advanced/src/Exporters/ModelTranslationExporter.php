<?php

namespace Botble\LanguageAdvanced\Exporters;

use Botble\DataSynchronize\Exporter\ExportColumn;
use Botble\DataSynchronize\Exporter\ExportCounter;
use Botble\DataSynchronize\Exporter\Exporter;
use Botble\Language\Facades\Language;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ModelTranslationExporter extends Exporter
{
    protected string $modelClass;

    public function __construct(?string $modelClass = null)
    {
        $this->modelClass = $modelClass ?: request()->input('class');
    }

    public function getLabel(): string
    {
        $modelName = class_basename($this->modelClass);

        return trans('plugins/language-advanced::language-advanced.export_model_translations', ['model' => $modelName]);
    }

    public function columns(): array
    {
        $columns = [
            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('name')->label('Name'),
        ];

        $translatableColumns = LanguageAdvancedManager::getTranslatableColumns($this->modelClass);

        foreach (Language::getSupportedLocales() as $language) {
            $langCode = $language['lang_code'];

            if (! $langCode || ! empty($language['lang_is_default'])) {
                continue;
            }

            foreach ($translatableColumns as $column) {
                if (! Schema::hasColumn($this->modelClass::query()->getModel()->getTable() . '_translations', $column)) {
                    continue;
                }

                $columns[] = ExportColumn::make($column . '_' . $langCode)
                    ->label(Str::title(str_replace('_', ' ', $column)) . ' (' . $langCode . ')');
            }
        }

        return $columns;
    }

    public function counters(): array
    {
        return [
            ExportCounter::make()
                ->label(trans('plugins/language-advanced::language-advanced.export.total'))
                ->value($this->modelClass::query()->count()),
        ];
    }

    public function hasDataToExport(): bool
    {
        return $this->modelClass::query()->exists();
    }

    public function collection(): Collection
    {
        $items = $this->modelClass::query()
            ->with(['slugable'])
            ->get();

        $result = collect();
        $translatableColumns = LanguageAdvancedManager::getTranslatableColumns($this->modelClass);

        foreach ($items as $item) {
            $data = [
                'id' => $item->id,
                'name' => $item->name,
            ];

            $translations = $item->translations;

            foreach (Language::getSupportedLocales() as $language) {
                $langCode = $language['lang_code'];

                if (! $langCode || ! empty($language['lang_is_default'])) {
                    continue;
                }

                $translation = $translations->where('lang_code', $langCode)->first();

                foreach ($translatableColumns as $column) {
                    $data[$column . '_' . $langCode] = (string) $translation?->{$column};
                }
            }

            $result->push($data);
        }

        return $result;
    }

    public static function make(?string $modelClass = null): static
    {
        return app(static::class, ['modelClass' => $modelClass]);
    }

    public function getUrl(): string
    {
        return url()->current() . '?class=' . $this->modelClass;
    }
}
