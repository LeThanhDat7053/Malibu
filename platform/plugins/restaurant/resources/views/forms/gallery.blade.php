{{--
    Trường media hợp nhất cho Nhà hàng: Ảnh + Video + VR360 trong một lưới.
    Dùng lại gallery-box của plugin Gallery. Khác với Room, nút VR360 KHÔNG bị ẩn
    vì nhà hàng sẽ dùng ảnh panorama VR360 thay cho ảnh thường.
--}}
@php
    use Illuminate\Support\Arr;

    $model = $model ?? null;
    $existingItems = [];

    if ($model && $model->id) {
        // Ưu tiên 1: bảng gallery_meta (do plugin Gallery quản lý)
        if (function_exists('gallery_meta_data')) {
            $metaData = gallery_meta_data($model) ?: [];
            $metaData = array_values(array_filter($metaData, fn ($i) => ! empty(Arr::get($i, 'img'))));

            if (! empty($metaData)) {
                $existingItems = $metaData;
            }
        }

        // Ưu tiên 2: dựng lại từ cột images và videos
        if (empty($existingItems)) {
            foreach ($model->images ?? [] as $imageUrl) {
                if ($imageUrl) {
                    $existingItems[] = [
                        'img' => $imageUrl,
                        'type' => 'image',
                        'description' => '',
                        'thumb' => null,
                    ];
                }
            }

            foreach ($model->videos ?? [] as $video) {
                if (! empty($video['img'])) {
                    $existingItems[] = $video;
                }
            }
        }
    }

    $value = $existingItems;
@endphp

<div class="restaurant-gallery-field-wrapper">
    {!! view('plugins/gallery::gallery-box', compact('value'))->render() !!}
</div>
