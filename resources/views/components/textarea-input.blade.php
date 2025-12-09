<div class="mb-3">
    <label class="form-label">
        {{ $label ?? 'Description' }}
        @if (!empty($required))
            <span class="text-red-600">*</span>
        @endif
    </label>

    <textarea name="{{ $name ?? 'description' }}" rows="{{ $rows ?? 4 }}"
        class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block
               min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850
               dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all
               placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">{{ $isEdit ? $item->{$name} ?? '' : old($name) }}</textarea>

    @error($name ?? 'description')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
