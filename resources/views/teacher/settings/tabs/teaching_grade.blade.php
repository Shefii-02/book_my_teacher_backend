{{-- TEACHING GRADE TAB --}}

<div class="flex items-center justify-between mb-6">

    <div>

        <h3 class="text-2xl font-black text-slate-800 dark:text-white">
            Teaching Grades
        </h3>

        <p class="text-slate-500 text-sm">
            Grade, board & subject details
        </p>

    </div>

    <button data-url="{{ route('teacher.settings.teachers.grades.edit') }}"
        class="px-5 py-2 open-drawer rounded-xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold">
        <i class="bi bi-pencil"></i> Edit Grades
    </button>

</div>

{{-- LIST --}}
<div id="gradeViewBox">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>

                <tr class="border-b dark:border-slate-700">

                    <th class="py-3 text-left">
                        Grade
                    </th>

                    <th class="py-3 text-left">
                        Board
                    </th>

                    <th class="py-3 text-left">
                        Subject
                    </th>

                    <th class="py-3 text-center">
                        Online
                    </th>

                    <th class="py-3 text-center">
                        Offline
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($teachingGrades as $grade)
                    <tr class="border-b dark:border-slate-700">

                        <td class="py-4">
                            {{ $grade?->grade?->name }}
                        </td>

                        <td class="py-4">
                            {{ $grade?->board?->name }}
                        </td>

                        <td class="py-4">
                            {{ $grade?->subject?->name }}
                        </td>

                        <td class="py-4 text-center">

                            @if ($grade->online)
                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-600 text-xs font-bold">
                                    YES
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold">
                                    NO
                                </span>
                            @endif

                        </td>

                        <td class="py-4 text-center">

                            @if ($grade->offline)
                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-600 text-xs font-bold">
                                    YES
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold">
                                    NO
                                </span>
                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="py-10 text-center text-slate-500">
                            No teaching grades found.
                        </td>

                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>
