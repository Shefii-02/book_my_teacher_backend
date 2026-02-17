<div class="">

    <h2 class="text-xl font-semibold mb-4">
        {{ 'Watch Time Update' }}
    </h2>

    <form method="POST"
        action="{{ route('company.app.statistics-watch.update-with-type', ['statistics_watch' => $class['id'], 'type' => $class['type']]) }}">

        @csrf
        @if (isset($class))
            @method('PUT')
        @endif

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-2xl transition duration-300">
            <div class="flex gap-2 align-items-center2 p-3 relative">
                {{-- Class Image --}}
                <div class="relative">
                    <img src="{{ $class['image'] ?? asset('default.jpg') }}" class=" object-cover border rounded"
                        style="min-height: 150px;max-height:150px">

                    <span class="absolute top-2 end-2 bg-blue-600 text-white text-xs px-3 py-1 rounded-full">
                        {{ ucfirst($class['type']) }}
                    </span>
                </div>

                <div class="space-y-3 w-100 relative">
                    <div class=" grid grid-cols-1 md:grid-cols-2 xl:grid-cols-1">
                        <div>
                            {{-- Title --}}
                            <div class="flex gap-2 text-sm">
                                <span class="font-semibold text-gray-600">Class Title:</span>
                                <h3 class="text-lg font-bold text-gray-800">
                                    {{ $class['title'] }}
                                </h3>
                            </div>

                            {{-- Parent Title --}}

                            <div class="flex gap-3 text-sm">
                                <span class="font-semibold text-gray-600">{{ ucfirst($class['type']) }}
                                    Title:</span>
                                <p class="text-sm text-gray-500">
                                    {{ $class['parent_title'] ?? '-' }}
                                </p>
                            </div>
                            {{-- Class Mode --}}
                            <div class="flex gap-3  text-sm">
                                <span class="font-semibold text-gray-600">Class mode:</span>
                                <span class="text-gray-800">
                                    {{ ucfirst($class['class_mode']) }}
                                </span>
                            </div>
                            {{-- Source --}}
                            <div class="flex gap-3  text-sm">
                                <span class="font-semibold text-gray-600">Source:</span>
                                <span class="text-gray-800">
                                    {{ ucfirst($class['source']) }}
                                </span>
                            </div>
                            <div class="flex gap-2">
                                {{-- Links --}}
                                <div class="flex gap-3 items-baseline justify-between text-sm">
                                    <span class="font-semibold text-gray-600">Class Link:</span>
                                    <span class="text-gray-800">
                                        <a href="{{ $class['class_link'] }}" target="_blank"
                                            class="block text-center text-success text-sm py-2 rounded-lg ">
                                            Open
                                        </a>
                                    </span>
                                </div>
                                <div class="flex gap-3 items-baseline text-sm">
                                    <span class="font-semibold text-gray-600">Record Link:</span>
                                    <span class="text-gray-800">
                                        <a href="{{ $class['recorded_link'] }}" target="_blank"
                                            class="block text-center text-success text-sm py-2 rounded-lg ">
                                            Open
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div>
                            {{-- Teacher --}}
                            <div class="flex flex-col  space-x-3 pt-2 ">
                                <div class="flex gap-2 align-items-center pb-2">
                                    <img src="{{ $class->teacher->avatar ?? asset('default-avatar.png') }}"
                                        class="w-10 h-10 rounded-full object-cover">

                                    <div>
                                        <p class="text-sm m-0 p-0 font-semibold text-gray-800">
                                            Name : {{ $class->teacher->name ?? '-' }}
                                        </p>
                                        <p class="text-sm m-0 p-0 font-semibold text-gray-800">
                                            Email : {{ $class->teacher->name ?? '-' }}
                                        </p>
                                        <p class="text-sm m-0 p-0 font-semibold text-gray-800">
                                            Mobile : {{ $class->teacher->name ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Date & Time --}}
                                <div class="text-sm text-gray-600 border-t pt-2">
                                    <div class="flex gap-2 text-sm">
                                        <div>
                                            <strong>Date:</strong>
                                            {{ \Carbon\Carbon::parse($class['class_date'])->format('d M Y') }}
                                        </div>
                                        <div>
                                            <strong>Time:</strong> {{ $class['started_at'] }} -
                                            {{ $class['ended_at'] }}
                                        </div>
                                    </div>

                                </div>
                                {{-- Duration --}}
                                <div class="flex gap-2 text-sm">
                                    <span class="font-semibold text-gray-600">Spend Duration:</span>
                                    <span class="text-gray-800">
                                        {{ $class['spend_duration'] ?? 0 }} Mins
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 border-0">
            <div class="card-body">

                {{-- Duration --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Watch Duration (Minutes)</label>
                    <input type="number" name="watch_duration" class="form-control border"
                        placeholder="Enter duration in minutes" min="1"
                        value="{{ old('watch_duration', isset($statisticsSpend) && $statisticsSpend->watch_duration ? $statisticsSpend->watch_duration : 0) }}">
                    @error('watch_duration')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        {{-- Submit --}}
        <div class="text-end">
            <a href="{{ route('company.app.statistics-spend.index') }}" class="btn btn-light me-2">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary px-4">
                Update
            </button>
        </div>

    </form>

</div>
