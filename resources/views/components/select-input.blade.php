@php
    // Default values
    $label = $label ?? 'Select';
    $name = $name ?? 'select';
    $options = $options ?? [];
    $value = $value ?? null;
    $required = $required ?? false;
@endphp

<div class="mb-3">
    <label class="form-label">{{ $label }}</label>
    <select
        name="{{ $name }}"
        class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
        {{ $required ? 'required' : '' }}
    >
        <option value="">-- Select {{ $label }} --</option>
        @foreach($options as $opt)
            <option value="{{ $opt['id'] }}" {{ $value == $opt['id'] ? 'selected' : '' }}>
                {{ $opt['title'] }}
            </option>
        @endforeach
    </select>
</div>
