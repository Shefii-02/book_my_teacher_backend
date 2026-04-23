<div class="flex-auto px-0 pt-0 pb-2">
    <div class="p-0 overflow-x-auto">
        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
            <thead class="align-bottom">
                <tr>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        #</th>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Name</th>
                    <th
                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Profession</th>
                    <th
                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Subject</th>
                    <th
                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Grade</th>
                    <th
                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Mode</th>
                    <th
                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Created At</th>
                    <th
                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                        Account Status</th>
                    <th
                        class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none  text-slate-400 opacity-70">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teachers ?? [] as $teacher)
                    @php
                        $key = ($teachers->currentPage() - 1) * $teachers->perPage() + $loop->iteration;
                        $teacherMedia = $teacher->mediaFiles->where('file_type', 'avatar')->first();
                        $teacherSubjects = $teacher->subjects->pluck('subject')->toArray();
                        $teacherGrades = $teacher->teacherGrades->pluck('grade')->toArray();
                    @endphp

                    <tr>
                        <td
                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                            {{ $key }}
                        </td>
                        <td class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                            <div class="flex px-2 py-1">
                                <div>
                                    <img src="{{ asset('storage/' . $teacher ? $teacher->avatar_url : '') }}"
                                        class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-9 rounded-xl"
                                        alt="user1" />
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h6 class="mb-0 text-sm text-neutral-900 dark:text-white">
                                        {{ $teacher->name }}
                                    </h6>
                                    <p
                                        class="my-1 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                        <a href="#" class="__cf_email__">{{ $teacher->email }}</a>
                                    </p>
                                    <p
                                        class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                        <a href="#" class="__cf_email__">{{ $teacher->mobile }}</a>
                                    </p>
                                    <div class="flex gap-3">
                                        <a target="_blank"
                                            href="https://web.whatsapp.com/send/?text=&type=custom_url&app_absent=0&utm_campaign=wa_api_send_v1&phone{{ $teacher->mobile }}"
                                            class="mb-0 text-sm text-neutral-900 dark:text-white">
                                            <i class="bi bi-whatsapp text-green-400"></i></a>
                                        <a target="_blank" href="tel://{{ $teacher->mobile }}"
                                            class="mb-0 text-sm text-neutral-900 dark:text-white">
                                            <i class="bi bi-telephone text-blue-400"></i></a>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                            <p
                                class="mb-0 text-xs font-semibold capitalize leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                {{-- {{ $teacher->address . ', ' . $teacher->city . ', ' . $teacher->postal_code . ', ' . $teacher->district . ', ' . $teacher->state . ', ' . $teacher->country }} --}}
                                {{ $teacher->professionalInfo ? $teacher->professionalInfo->profession : '' }}
                            </p>
                        </td>
                        <td class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                            <p
                                class="mb-0 capitalize text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                {{ implode(', ', $teacherSubjects) }}
                            </p>
                        </td>
                        <td class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                            <p
                                class="mb-0 capitalize text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                {{ implode(', ', $teacherGrades) }}
                            </p>
                        </td>
                        <td
                            class="p-2 text-sm text-neutral-900 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                            @if ($teacher->professionalInfo)
                                @if ($teacher->professionalInfo->teaching_mode == 'online')
                                    <span
                                        class="bg-gradient-to-tl from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold capitalize leading-none text-white">Online</span>
                                @elseif($teacher->professionalInfo->teaching_mode == 'offline')
                                    <span
                                        class="bg-gradient-to-tl from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold capitalize leading-none text-white">Offline</span>
                                @elseif($teacher->professionalInfo->teaching_mode == 'both')
                                    <span
                                        class="bg-gradient-to-tl from-blue-700 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold capitalize leading-none text-white">Both</span>
                                @endif
                            @endif
                        </td>
                        <td
                            class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                            <span
                                class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $teacher->created_at }}</span>
                        </td>
                        <td
                            class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent capitalize">
                            @if ($teacher->account_status == 'rejected')
                            @else
                                <span class="text-sm mb-1">{{ $teacher->current_account_stage }}</span><br>
                            @endif

                            @if ($teacher->account_status == 'in progress')
                                <span
                                    class="bg-gradient-to-tl capitalize from-lime-200 to-lime-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">In
                                    progress</span>
                            @elseif($teacher->account_status == 'ready for interview')
                                <span
                                    class="bg-gradient-to-tl capitalize from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Ready
                                    for interview</span>
                            @elseif($teacher->account_status == 'scheduled')
                                <span
                                    class="bg-gradient-to-tl capitalize from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Scheduled</span>
                            @elseif($teacher->account_status == 'completed')
                                <span
                                    class="bg-gradient-to-tl capitalize from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Completed</span>
                            @elseif($teacher->account_status == 'rejected')
                                <span
                                    class="bg-gradient-to-tl capitalize bg-red-900 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Rejected</span>
                            @endif
                        </td>
                        <td class="p-2 align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                            <button id="dropdownBottomButton" data-dropdown-toggle="dropdownBottom_{{ $key }}"
                                data-dropdown-placement="bottom" class="" type="button">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                        d="M12 6h.01M12 12h.01M12 18h.01" />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div id="dropdownBottom_{{ $key }}"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownBottomButton">
                                    <li>
                                        <a href="{{ route('company.teachers.overview', $teacher->id) }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">View</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.teachers.edit', $teacher->id) }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                    </li>
                                    <li>
                                        <form id="form_{{ $teacher->id }}" class="m-0 p-0"
                                            action="{{ route('company.teachers.destroy', $teacher->id) }}"
                                            method="POST" class="inline-block">
                                            @csrf @method('DELETE') </form>
                                        <a role="button" href="javascript:;"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white"
                                            onclick="confirmDelete({{ $teacher->id }})">Delete</a>

                                    </li>
                                </ul>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
