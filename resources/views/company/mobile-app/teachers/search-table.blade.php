    @forelse ($teachers as $t)
                                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-4 relative border">
                                    <a href="">
                                        {{-- Main Content --}}
                                        <div class="flex items-start gap-4">
                                            <div class="flex flex-col gap-2 ">

                                                {{-- Profile --}}
                                                <img src="{{ $t->thumbnail_url }}"
                                                    class="h-16 w-16 rounded-xl object-cover shadow" />
                                                @if ($t->status == 1)
                                                    <span
                                                        class="bg-success text-center text-light px-2 py-0.5 rounded text-xxs font-semibold">
                                                        Active
                                                    </span>
                                                @else
                                                    <span
                                                        class="bg-danger text-center text-light px-2 py-0.5 rounded text-xxs font-semibold">
                                                        Disabled
                                                    </span>
                                                @endif

                                            </div>
                                            {{-- Details --}}
                                            <div class="flex">

                                                {{-- Name + Status --}}
                                                <div class="flex items-center gap-3 me-3">
                                                    <div class="text-base font-semibold text-gray-900">
                                                        {{ $t->name }} <p class="text-xxs">
                                                            {{ $t->email }}<br>{{ $t->mobile }}</p>
                                                    </div>


                                                </div>


                                                {{-- Info Row --}}
                                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-3 text-xs">
                                                    <div class="flex flex-col">
                                                        <div class="flex gap-2">
                                                            <p class="text-gray-400">Grades</p>
                                                            <p class="font-medium text-gray-700 line-clamp-2" >
                                                                {{ implodeComma($t->teachingGrades?->pluck('name')) ?: '-' }}
                                                            </p>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            <p class="text-gray-400">Boards</p>
                                                            <p class="font-medium text-gray-700 line-clamp-2">
                                                                {{ implodeComma($t->teachingBoards?->pluck('name')) ?: '-' }}
                                                            </p>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            <p class="text-gray-400">Subjects</p>
                                                            <p class="font-medium text-gray-700 line-clamp-2">
                                                                {{ implodeComma($t->teachingSubjects?->pluck('name')) ?: '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <p class="text-gray-400">Courses</p>
                                                        <p class="font-medium text-gray-700">
                                                            {{ $t->courses()->count() }} Total
                                                            •
                                                            {{ $t->courses->where('ended_at', '>=', date('Y-m-d'))->count() }}
                                                            Ongoing
                                                        </p>
                                                    </div>

                                                    <div>
                                                        <p class="text-gray-400">Earnings</p>
                                                        <p class="font-semibold text-gray-900">
                                                            ₹{{ number_format($t->earnings_total, 0) }}
                                                        </p>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </a>
                                </div>

                            @empty
                                <div class="text-center py-24 text-gray-400 bg-white rounded-xl shadow">
                                    <p class="font-bold fw-bold">No teachers found</p>
                                </div>
                            @endforelse
