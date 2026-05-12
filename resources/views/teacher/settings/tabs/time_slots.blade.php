{{-- TIME SLOT TAB --}}
<div class="mb-6 flex justify-between items-center">

    <div>
        <h3 class="text-2xl font-black text-slate-800 dark:text-white">
            Time Slots
        </h3>

        <p class="text-slate-500 text-sm">
            Teacher availability schedule
        </p>
    </div>

      <button data-url="{{ route('teacher.settings.teachers.slots.edit') }}"
        class="px-5 py-2 open-drawer rounded-xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold">
        <i class="bi bi-pencil"></i> Edit Slot
    </button>

</div>

{{-- VIEW --}}
<div class="grid md:grid-cols-2 gap-3">

    @php
        $days = $teacher->user->workingDays ?? [];
        $hours = $teacher->user->workingHours ?? [];
    @endphp

    <x-info label="Working Days"
        :value="count($days) ? implode(', ', $days->pluck('day')->toArray()) : '-'" />

    <x-info label="Total Slots"
        :value="count($hours) ?? 0" />

</div>

{{-- DETAILED SCHEDULE --}}
<div class="mt-5 space-y-2">

    @foreach($days as $day)

        <div class="bg-slate-50 dark:bg-slate-700 p-3 rounded-xl">

            <h4 class="font-black text-slate-800 dark:text-white">
                {{ $day->day }}
            </h4>

            <div class="text-sm text-slate-500 mt-1">

                @foreach($hours->where('available_day_id', $day->id) as $slot)

                    <span class="inline-block px-3 py-1 bg-white dark:bg-slate-800 rounded-full mr-2 mt-1">
                        {{ $slot->time_slot }}
                    </span>

                @endforeach

            </div>

        </div>

    @endforeach

</div>
