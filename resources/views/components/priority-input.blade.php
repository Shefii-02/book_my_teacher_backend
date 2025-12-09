<div class="mb-4">
    <label for="{{ $name ?? 'priority' }}" class="block font-semibold text-gray-700 mb-1">
        {{ $label ?? 'Priority' }}
        @if(!empty($required)) <span class="text-red-600">*</span> @endif
    </label>

    <input
        type="number"
        name="{{ $name ?? 'priority' }}"
        id="{{ $name ?? 'priority' }}"
        value="{{ $isEdit ? ($item->{$name} ?? '') : old($name) }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm
               focus:border-indigo-500 focus:ring focus:ring-indigo-200
               focus:ring-opacity-50 transition"
        placeholder="{{ $placeholder ?? 'Enter display priority' }}"
    >

    @error($name ?? 'priority')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
