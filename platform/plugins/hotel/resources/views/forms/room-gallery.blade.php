{{--
    Unified media field for Room: Images + Videos in one gallery-box grid.
    Reuses gallery-box.blade.php (same UI as Blog), hides the VR360 button
    since VR360 is managed via the dedicated vr360_url field.
--}}
@php
    use Illuminate\Support\Arr;

    $model = $model ?? null;
    $existingItems = [];

    if ($model && $model->id) {
        // Priority 1: gallery_meta table (managed by Gallery plugin)
        if (function_exists('gallery_meta_data')) {
            $metaData = gallery_meta_data($model) ?: [];
            $metaData = array_values(array_filter($metaData, fn ($i) => !empty(Arr::get($i, 'img'))));
            if (!empty($metaData)) {
                $existingItems = $metaData;
            }
        }

        // Priority 2: build from images column + videos column
        if (empty($existingItems)) {
            foreach ($model->images ?? [] as $imgUrl) {
                if ($imgUrl) {
                    $existingItems[] = ['img' => $imgUrl, 'type' => 'image', 'description' => '', 'thumb' => null];
                }
            }
            foreach ($model->videos ?? [] as $video) {
                if (!empty($video['img'])) {
                    $existingItems[] = $video;
                }
            }
        }
    }

    $value = $existingItems;
@endphp

<div class="room-gallery-field-wrapper">
    {!! view('plugins/gallery::gallery-box', compact('value'))->render() !!}
</div>

<style>
/* VR360 is managed separately via the dedicated vr360_url field below */
.room-gallery-field-wrapper .btn_add_vr360 { display: none !important; }
</style>