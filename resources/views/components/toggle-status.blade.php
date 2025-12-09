@php
    $label = $label ?? 'Publish';
    $name = $name ?? 'published';
    $isEdit = $isEdit ?? false;

    // Determine checked value
    $checked = old($name, $isEdit && isset($item) ? $item->$name ?? false : false);
@endphp

<div class="my-3">
    <div class="flex items-center gap-3">
        <label class="font-medium">
            <input type="checkbox" class="border pe-3" name="{{ $name }}" value="1"
                {{ $checked ? 'checked' : '' }}> {{ $label }}</label>
    </div>
</div>
