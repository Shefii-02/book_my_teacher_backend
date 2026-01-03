@php
    // Default values
    $size = $size ?? null;
    $label = $label ?? 'Select Image';
    $isEdit = $isEdit ?? false;
    $isRequired = $isRequired ?? false;
    // Auto-generate IDs
    $inputId = $name . '_input';
    $previewId = $name . '_preview';

    // Determine image source
    $src = $src ?? '';
    if (!empty($item) && !empty($item->$field) && empty($src)) {
        $src = $item->$field;
    }


    // Required logic (only required in create mode)
    $requiredAttr = $isEdit && !$isRequired ? '' : 'required';
@endphp
<div class="flex mb-4 gap-3">

    {{-- Preview Box --}}
    <div
        class="relative w-32 h-32 rounded-xl overflow-hidden border border-gray-300 bg-gray-50 shadow-sm
                hover:shadow-md transition-all flex items-center justify-center cursor-pointer group">

        <img id="{{ $previewId }}" src="{{ $src }}"
            class="object-cover w-full h-full1 group-hover:opacity-80 transition">

        {{-- Overlay on Hover --}}
        <div
            class="absolute inset-0 bg-black/40 text-white opacity-0
                    group-hover:opacity-100 transition flex items-center justify-center text-sm">
            Change Image
        </div>
    </div>
    <div class="flex flex-col mb-4 gap-3">
        {{-- Label --}}
        <label for="{{ $inputId }}" class="font-medium text-gray-700">
            {{ $label }}
        </label>

        {{-- Size info --}}
        @if ($size)
            <small class="text-gray-600">
                {{ $requiredAttr ? '<span class="text-red-600">*</span>' : '' }} Size {{ $size }}
            </small>
        @endif

        {{-- File input --}}
        <input type="file" id="{{ $inputId }}" name="{{ $name }}"
            class="image-preview-input block w-full text-sm text-gray-700
               border border-gray-300 rounded-lg cursor-pointer bg-gray-100 hover:bg-gray-200 transition"
            data-preview="#{{ $previewId }}" accept=".jpg,.jpeg,.png" {!! $requiredAttr !!}>

        {{-- Error --}}
        @error($name)
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>
</div>
