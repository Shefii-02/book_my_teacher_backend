@extends('layouts.teacher')

@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white " href="javascript:;">Home</a>
            </li>
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="javascript:;">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">My Schedules</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">My Schedules</h6>
    </nav>
@endsection

@section('content')
    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">

        <!-- table 1 -->
        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <div class="flex1">
                            <div class="w-full max-w-full ">
                                <h6 class="dark:text-white">Schedules List</h6>
                            </div>
                            <div class="w-full max-w-full ">

                            </div>
                        </div>
                    </div>



                    <div class="flex-auto px-0 pt-0 pb-2">
                        <div class="p-0 overflow-x-auto">
                            <table
                                class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                                <thead class="align-bottom">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-start font-bold uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Scheduled Date</th>
                                        <th
                                            class="px-6 py-3 text-start font-bold uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Started At</th>
                                        <th
                                            class="px-6 py-3 text-start font-bold uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Ended At</th>
                                        <th
                                            class="px-6 py-3 text-start font-bold uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Title</th>
                                        <th
                                            class="px-6 py-3 text-start font-bold uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Type</th>
                                        <th
                                            class="px-6 py-3 text-start font-bold uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Mode/Source</th>
                                        <th
                                            class="px-6 py-3 text-start font-bold uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Link</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                            Students</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($events ?? [] as $key => $eventsParent)
                                        @forelse($eventsParent ?? [] as $key => $event)
                                            <tr>
                                                <td
                                                    class="py-3 px-6 text-start text-sm align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                    {{ $event['schedule_date'] }}
                                                </td>

                                                <td
                                                    class="py-3 px-6 text-sm text-start align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                    {{ $event['started_at'] }}
                                                </td>
                                                <td
                                                    class="py-3 px-6 text-sm text-start align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                    {{ $event['ended_at'] }}
                                                </td>
                                                <td
                                                    class="py-3 px-6 text-sm text-start align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                    {{ $event['title'] }}
                                                </td>
                                                <td
                                                    class="py-3 px-6 text-sm text-start align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                    {{ $event['type'] }}
                                                </td>
                                                <td
                                                    class="py-3 px-6 text-sm text-start align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                    {{ $event['mode'] }}/{{ $event['source'] }}
                                                </td>
                                                <td
                                                    class="py-3 px-6 text-sm text-start align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                    <a title="{{ $event['class_link'] }}" href="{{ $event['class_link'] }}">{{ Str::limit($event['class_link'],20,'..') }}  </a>
                                                      @if($event['class_link'] != '')<i class="bi bi-copy mx-2" onclick="copyPageLink(`{{ $event['class_link'] }}`)"></i> @endif

                                                </td>
                                                <td
                                                    class="py-3 px-6 text-sm  text-center align-middle bg-transparent border-b dark:border-white/40  shadow-transparent">
                                                    {{ $event['students_count'] }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">
                                                    <h6 class="text-center my-4">No Data Found</h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @empty
                                        <tr>
                                            <td colspan="8">
                                                <h6 class="text-center my-4">No Data Found</h6>
                                            </td>
                                        </tr>
                                    @endforelse



                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- <div class="d-flex justify-content-center m-4">
                        {!! $teachers->links() !!}
                    </div>
                    <p class="p-3">Showing {{ $teachers->firstItem() }} to {{ $teachers->lastItem() }} of
                        {{ $teachers->total() }} users.</p> --}}

                </div>
            </div>
        </div>
    </div>
@endsection
