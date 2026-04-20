<div class="bg-white shadow rounded-lg">

    <div class="p-0 overflow-x-auto">
        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">

            <thead class="align-bottom">
                <tr>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        #</th>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Student</th>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Parent</th>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Grade</th>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Mode</th>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Course Enrolled</th>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Status</th>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Created</th>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Last Active</th>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Action</th>
                </tr>
            </thead>


            <tbody>
                @forelse($students as  $student)
                    @php
                        $key = ($students->currentPage() - 1) * $students->perPage() + $loop->iteration;
                        $subjects = $student->recommendedSubjects->pluck('subject')->toArray();
                        $grades = $student->studentGrades->pluck('grade')->toArray();
                        $grades_val = implode(',', $grades);
                        $sub_val = implode(',', $subjects);
                        $mode = $student->studentPersonalInfo?->study_mode;
                    @endphp

                    <tr class="border-b">

                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                            {{ $key }}
                        </td>
                        <!-- Student -->
                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                            <div class="flex gap-2 items-center">
                                {{-- <img src="{{ $student->avatar_url }}" class="w-10 h-10 rounded"> --}}

                                <div>
                                    <p class="font-semibold">{{ $student->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $student->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                            {{ $student->studentPersonalInfo->parent_name }}
                        </td>
                        <td class="p-3 capitalize" role="button" title="{{ $grades_val . '(' . $sub_val . ')' }}">
                            <p class="text-sm">
                                @if ($grades_val)
                                    {{ Str::limit($grades_val, 20) }}<br>
                                    ({{ Str::limit($sub_val, 20) }})
                                @else
                                    Please update
                                @endif
                            </p>
                        </td>

                        <!-- Mode -->
                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                            {{ ucfirst($mode ?? '-') }}
                        </td>
                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                            {{ $student->courseEnrolled->count() }}
                        </td>

                        <!-- Status -->
                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                            @if ($student->status == '1')
                                <span class="bg-green-500 text-white px-2 py-1 rounded text-xs">Active</span>
                            @elseif($student->status == '0')
                                <span class="bg-gray-500 text-white px-2 py-1 rounded text-xs">Inactive</span>
                            @else
                                <span class="bg-red-500 text-white px-2 py-1 rounded text-xs">Suspend</span>
                            @endif
                        </td>

                        <!-- Date -->
                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                            {{ formatDateTime($student->created_at) }}
                        </td>

                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                            {{ timeAgo($student->last_active) }}
                        </td>

                        <!-- Action -->

                        <td class="p-3 text-center">
                            <button id="dropdownBottomButton" data-dropdown-toggle="dropdownBottom_{{ $key }}"
                                data-dropdown-placement="bottom" class="" type="button"> <svg
                                    class="w-6 h-6 text-gray-800 dark:text-white text-right" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                        d="M12 6h.01M12 12h.01M12 18h.01" />
                                </svg> </button> <!-- Dropdown menu -->
                            <div id="dropdownBottom_{{ $key }}"
                                class="z-10 text-left hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownBottomButton">
                                    <li> <a href="{{ route('company.students.overview', $student->id) }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">View</a>
                                    </li>
                                    <li> <a href="{{ route('company.students.edit', $student->id) }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                    </li>
                                    <form id="form_{{ $student->id }}" class="m-0 p-0"
                                        action="{{ route('company.students.destroy', $student->id) }}" method="POST"
                                        class="inline-block"> @csrf
                                        @method('DELETE') </form> <a role="button" href="javascript:;"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white"
                                        onclick="confirmDelete({{ $student->id }})">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-6">
                            No data found
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
        <!-- Loader -->
        <div id="scrollLoader" class="text-center py-4 hidden">
            <span class="text-gray-500">Loading...</span>
        </div>

        <!-- Load More Button -->
        <div class="text-center py-4">
            <button id="loadMoreBtn" class="px-4 py-2 bg-blue-600 text-white rounded hidden">
                Load More
            </button>
        </div>

        <div class="text-right p-3 text-gray-500">
            Total :
            {{ $students->total() }} results
        </div>
    </div>

</div>
