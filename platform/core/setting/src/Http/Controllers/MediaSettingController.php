<?php

namespace Botble\Setting\Http\Controllers;

use Botble\Base\Facades\Assets;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Media\Facades\RvMedia;
use Botble\Media\Models\MediaFile;
use Botble\Setting\Forms\MediaSettingForm;
use Botble\Setting\Http\Requests\MediaSettingRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Throwable;

class MediaSettingController extends SettingController
{
    protected int $defaultResizeBatchSize = 20;

    public function edit()
    {
        $this->pageTitle(trans('core/setting::setting.media.title'));

        $form = MediaSettingForm::create();

        return view('core/setting::media', compact('form'));
    }

    public function resizeImages()
    {
        Assets::addScriptsDirectly('vendor/core/core/setting/js/media.js');

        $this->pageTitle('Resize media images');

        return view('core/setting::media-resize', [
            'defaultMaxWidth' => 2560,
            'defaultMaxHeight' => 2560,
            'defaultQuality' => 82,
            'defaultMinFileSizeKb' => 1024,
            'defaultBatchSize' => $this->defaultResizeBatchSize,
        ]);
    }

    public function update(MediaSettingRequest $request): BaseHttpResponse
    {
        $data = $request->validated();

        $this->saveSettings([
            ...$data,
            'media_folders_can_add_watermark' => $request->boolean('media_folders_can_add_watermark_all')
                ? []
                : $request->input('media_folders_can_add_watermark', []),
        ]);

        return $this
            ->httpResponse()
            ->withUpdatedSuccessMessage()
            ->setData(['files_count' => MediaFile::query()->count()]);
    }

    public function generateThumbnails(Request $request): BaseHttpResponse
    {
        $request->validate([
            'total' => ['required', 'numeric', 'min:0'],
            'offset' => ['required', 'numeric', 'min:0'],
            'limit' => ['required', 'numeric', 'min:1'],
        ]);

        BaseHelper::maximumExecutionTimeAndMemoryLimit();

        $totalFiles = $request->input('total');
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', RvMedia::getConfig('generate_thumbnails_chunk_limit'));

        /**
         * @var Collection<MediaFile> $files
         */
        $files = MediaFile::query()
            ->select(['url', 'mime_type', 'folder_id'])
            ->skip($offset)
            ->take($limit)
            ->get();

        $errors = [];

        if ($files->isNotEmpty()) {
            foreach ($files as $file) {
                try {
                    RvMedia::generateThumbnails($file);
                } catch (Throwable $exception) {
                    BaseHelper::logError($exception);
                    $errors[] = $file->url;
                }
            }

            $errors = array_map(fn ($item) => [$item], array_unique($errors));
        }

        if ($errors) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage(trans('core/setting::setting.generate_thumbnails_error', ['count' => count($errors)]))
                ->setData([
                    'total' => $totalFiles,
                    'next' => $offset + $limit,
                ]);
        }

        return $this
            ->httpResponse()
            ->setMessage(trans('core/setting::setting.generate_thumbnails_success', ['count' => $totalFiles]))
            ->setData([
                'total' => $totalFiles,
                'next' => $offset + $limit,
            ]);
    }

    public function scanImagesForResize(Request $request): BaseHttpResponse
    {
        $options = $this->validateResizeOptions($request);

        $query = $this->getResizeCandidatesQuery($options['min_file_size_kb']);

        return $this
            ->httpResponse()
            ->setData([
                'total_images' => MediaFile::query()
                    ->whereIn('mime_type', RvMedia::getOptimizableMimeTypes())
                    ->count(),
                'candidate_images' => $query->count(),
                'candidate_size' => (int) $query->sum('size'),
                'batch_size' => $options['batch_size'],
            ]);
    }

    public function processImageResize(Request $request): BaseHttpResponse
    {
        $options = $this->validateResizeOptions($request, true);

        BaseHelper::maximumExecutionTimeAndMemoryLimit();

        $files = $this->getResizeCandidatesQuery($options['min_file_size_kb'])
            ->where('id', '>', $options['last_id'])
            ->orderBy('id')
            ->take($options['batch_size'])
            ->get();

        $optimized = 0;
        $skipped = 0;
        $failed = 0;
        $savedBytes = 0;
        $nextId = $options['last_id'];
        $errors = [];

        foreach ($files as $file) {
            $nextId = $file->id;

            try {
                $result = RvMedia::optimizeExistingImage(
                    $file,
                    $options['max_width'],
                    $options['max_height'],
                    $options['quality']
                );

                if (($result['status'] ?? null) === 'optimized') {
                    $optimized++;
                    $savedBytes += max(0, ($result['original_size'] ?? 0) - ($result['optimized_size'] ?? 0));
                } else {
                    $skipped++;
                }
            } catch (Throwable $exception) {
                $failed++;
                $errors[] = $file->url;
                BaseHelper::logError($exception);
            }
        }

        $hasMore = $files->count() === $options['batch_size'];

        return $this
            ->httpResponse()
            ->setMessage(
                $failed
                    ? 'The batch finished with some failed files.'
                    : 'The batch finished successfully.'
            )
            ->setData([
                'processed' => $files->count(),
                'optimized' => $optimized,
                'skipped' => $skipped,
                'failed' => $failed,
                'saved_bytes' => $savedBytes,
                'next_id' => $nextId,
                'has_more' => $hasMore,
                'errors' => $errors,
            ]);
    }

    protected function validateResizeOptions(Request $request, bool $withCursor = false): array
    {
        $rules = [
            'max_width' => ['nullable', 'integer', 'min:500', 'max:10000'],
            'max_height' => ['nullable', 'integer', 'min:500', 'max:10000'],
            'quality' => ['required', 'integer', 'min:40', 'max:100'],
            'min_file_size_kb' => ['required', 'integer', 'min:0'],
            'batch_size' => ['required', 'integer', 'min:1', 'max:100'],
        ];

        if ($withCursor) {
            $rules['last_id'] = ['required', 'integer', 'min:0'];
        }

        return $request->validate($rules);
    }

    protected function getResizeCandidatesQuery(int $minFileSizeKb)
    {
        return MediaFile::query()
            ->select(['id', 'url', 'mime_type', 'size', 'visibility', 'folder_id'])
            ->whereIn('mime_type', RvMedia::getOptimizableMimeTypes())
            ->where('size', '>=', $minFileSizeKb * 1024)
            ->whereNotNull('url')
            ->where('url', '!=', '');
    }
}
