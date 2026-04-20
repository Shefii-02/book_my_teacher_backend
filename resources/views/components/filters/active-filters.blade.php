@php
    // Fields to check (passed from parent)
    $fields = $fields ?? [];

    // Custom labels (optional)
    $labels = $labels ?? [];

    // Get active filters from request
    $activeFilters = collect(request()->only($fields))
        ->filter(fn($value) => filled($value));
@endphp

@if ($activeFilters->isNotEmpty())
    <div class="mb-4 flex flex-wrap gap-2" id="activeFilters">

        @foreach ($activeFilters as $key => $value)
            <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full flex items-center text-sm">

                {{-- Label --}}
                <span class="mr-2">
                    {{ $labels[$key] ?? ucwords(str_replace('_', ' ', $key)) }}:
                    <strong>{{ ucfirst($value) }}</strong>
                </span>

                {{-- Remove Filter --}}
                <a href="{{ request()->fullUrlWithQuery([$key => null]) }}"
                    class="active-filter-remove text-red-500 hover:text-red-700 font-bold ml-1"
                    data-key="{{ $key }}">
                    ×
                </a>

            </div>
        @endforeach

        {{-- Clear All --}}
        <a href="{{ $resetUrl ?? url()->current() }}"
            class="ml-2 text-sm text-red-600 underline active-filter-reset">
            Clear All
        </a>

    </div>
@endif
