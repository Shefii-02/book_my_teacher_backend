@php
    // Default values
    $label = $label ?? 'Submit';
    $color = $color ?? 'green';
    $full = $full ?? false;
    $center = $center ?? true;
@endphp

<div class="{{ $center ? 'flex justify-center' : '' }}">
    <button
        type="submit"
        class="px-5 py-2.5 text-sm font-medium text-white rounded-lg
               bg-{{ $color }}-700 hover:bg-{{ $color }}-800 {{ $full ? 'w-full' : '' }}">
        {{ $label }}
    </button>
</div>
