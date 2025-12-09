@php
    $name   = $name ?? 'title';
    $label  = $label ?? 'Title';
    $isEdit = $isEdit ?? false;
    $item   = $item ?? null;
    $required = $required ?? false;

    $value = $isEdit
        ? ($item->{$name} ?? '')
        : old($name);
@endphp

<div class="mb-3">
    <label class="form-label">
        {{ $label }}
        @if($required)
            <span class="text-red-600">*</span>
        @endif
    </label>

    <input
        type="text"
        name="{{ $name }}"
        value="{{ $value }}"
        class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block
               min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850
               dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all
               placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
        @if($required) required @endif
    >

    @error($name)
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
