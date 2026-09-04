@php
    $values = $values == '[null]' ? '[]' : $values;
    $attributes = $attributes ?? [];
    $allowThumb = Arr::get($attributes, 'allow_thumb', true);
    $inputName = Arr::get($attributes, 'input_name', $name);
    $images = array_filter((array) old($name, !is_array($values) ? json_decode($values ?: '', true) : $values));
@endphp

<x-core::form.images
    :name="$name"
    :input-name="$inputName"
    :allow-thumb="true"
    :images="$images"
/>
