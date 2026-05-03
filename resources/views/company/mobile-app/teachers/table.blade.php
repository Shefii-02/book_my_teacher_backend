@forelse ($teachers as $t)
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-4 relative border">

        {{-- Dropdown Top Right --}}
        <div class="absolute top-4 right-4">
            <button data-dropdown-toggle="dropdown_{{ $t->id }}" class="p-2 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01" />
                </svg>
            </button>

            <div id="dropdown_{{ $t->id }}"
                class="hidden absolute right-0 mt-2 bg-white shadow-xl rounded-xl w-44 z-10 border">
                <ul class="text-sm text-gray-700">

                    <li> <a href="{{ route('company.app.teachers.show', $t->id) }}"
                            class="block px-4 py-2 hover:bg-gray-100">View</a> </li>

                    <li> <a href="{{ route('company.app.teachers.edit', $t->id) }}"
                            class="block px-4 py-2 hover:bg-gray-100">Edit</a> </li>
                    <li> <a role="button" data-url="{{ route('company.app.teachers.login-security', $t->user_id) }}"
                            class="block px-4 py-2 hover:bg-gray-100 open-drawer dark:hover:bg-white dark:hover:text-white">Login
                            Security</a> </li>
                    <li> <a role="button" data-url="{{ route('company.app.teachers.grades.edit', $t->user_id) }}"
                            class="block px-4 py-2 hover:bg-gray-100 open-drawer dark:hover:bg-white dark:hover:text-white">
                            Teaching Grades</a> </li>
                    <li> <a role="button" data-url="{{ route('company.app.teachers.slots.edit', $t->user_id) }}"
                            class="block px-4 py-2 hover:bg-gray-100 open-drawer dark:hover:bg-white dark:hover:text-white">
                            Teaching Slots</a> </li>
                    <li>
                        <form id="form_{{ $t->id }}" method="POST"
                            action="{{ route('company.app.teachers.destroy', $t->id) }}"> @csrf
                            @method('DELETE') </form> <a onclick="confirmDelete({{ $t->id }})"
                            class="block px-4 py-2 hover:bg-gray-100" role="button">Delete</a>
                    </li>

                </ul>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="flex items-start gap-4">
            <div class="flex flex-col gap-2 ">

                {{-- Profile --}}
                <img src="{{ $t->thumbnail_url }}" class="h-16 w-16 rounded-xl object-cover shadow" />
                @if ($t->published == 1)
                    <span class="bg-success text-center text-light px-2 py-0.5 rounded text-xxs font-semibold">
                        Active
                    </span>
                @elseif ($t->published == -1)
                    <span class="bg-warning text-center text-light px-2 py-0.5 rounded text-xxs font-semibold">
                        Suspended
                    </span>
                @else
                    <span class="bg-danger text-center text-light px-2 py-0.5 rounded text-xxs font-semibold">
                        Inactive
                    </span>
                @endif

            </div>
            {{-- Details --}}
            <div class="flex">

                {{-- Name + Status --}}
                <div class="flex items-center gap-3 me-3">
                    <div class="text-base font-semibold text-gray-900">
                        {{ $t->name }} <p class="text-xxs">
                            {{ $t->user->email }}<br>{{ $t->user->mobile }}</p>
                        <p class="text-xxs">Last activated :<br> {{ timeAgo($t->user->last_activation) }}</p>
                    </div>
                </div>


                <p class="text-xs text-gray-500 mt-1">{{ $t->email }}</p>

                {{-- Info Row --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3 text-xs">

                    <div>
                        <p class="text-gray-400">Grades</p>
                        <p class="font-medium text-gray-700 line-clamp-2">
                            {{ implodeComma($t->teachingGrades?->pluck('name')) ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Boards</p>
                        <p class="font-medium text-gray-700 line-clamp-2">
                            {{ implodeComma($t->teachingBoards?->pluck('name')) ?: '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400">Courses</p>
                        <p class="font-medium text-gray-700">
                            {{ $t->total_courses->count() }} Total
                            • {{ $t->ongoing_courses->count() }}
                            Ongoing
                        </p>
                    </div>

                    <div>
                        {{-- <p class="text-gray-400">Earnings</p> --}}
                        {{-- <p class="font-semibold text-gray-900">
                            Total: ₹{{ number_format($t->earnings_total, 0) }} &nbsp; &nbsp; &nbsp;
                            Payout: ₹{{ number_format($t->earnings_payout, 0) }} &nbsp; &nbsp; &nbsp;<br>
                            Balance: ₹{{ number_format($t->earnings_balance, 0) }}
                        </p> --}}
                    </div>

                </div>

            </div>

        </div>

    </div>

@empty
    <div class="text-center py-10 text-gray-400 bg-white rounded-xl shadow">
        No teachers found
    </div>
@endforelse
