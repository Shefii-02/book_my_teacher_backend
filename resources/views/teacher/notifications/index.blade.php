@extends('layouts.teacher')

@section('nav-options')

<nav>

    <ol class="flex flex-wrap pt-1 bg-transparent rounded-lg sm:mr-16">

        <li class="text-sm">
            <a class="text-white" href="javascript:;">
                Home
            </a>
        </li>

        <li class="text-sm pl-2 text-white before:content-['/'] before:pr-2">
            Dashboard
        </li>

        <li class="text-sm pl-2 font-bold text-white before:content-['/'] before:pr-2">
            Notifications
        </li>

    </ol>

    <h6 class="mb-0 font-bold text-white capitalize">
        Notifications
    </h6>

</nav>

@endsection

@section('content')

<div class="w-full px-6 py-6 mx-auto">

    {{-- TOP CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-4 gap-6 mb-8">

        {{-- TOTAL --}}
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 p-6 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        Total Notifications
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['total_notifications'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-bell-55 text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- READ --}}
        <div class="rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-400 p-6 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        Read
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['read_notifications'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-check-bold text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- UNREAD --}}
        <div class="rounded-2xl bg-gradient-to-br from-orange-500 to-yellow-400 p-6 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        Unread
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['unread_notifications'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-email-83 text-2xl"></i>
                </div>

            </div>

        </div>

        {{-- FAILED --}}
        <div class="rounded-2xl bg-gradient-to-br from-red-500 to-pink-500 p-6 shadow-2xl text-white">

            <div class="flex justify-between">

                <div>

                    <p class="uppercase text-xs opacity-70 tracking-wider">
                        Push Failed
                    </p>

                    <h2 class="text-4xl font-black mt-3">
                        {{ $data['push_failed'] }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <i class="ni ni-fat-remove text-2xl"></i>
                </div>

            </div>

        </div>

    </div>

    {{-- ACTIONS --}}
    <div class="flex justify-end mb-5">

        <a href="{{ route('teacher.notifications.read-all') }}"
            class="px-5 py-3 rounded-xl  bg-dark text-white font-bold shadow-lg">

            Mark All As Read

        </a>

    </div>

    {{-- LIST --}}
    <div class="rounded-2xl bg-white dark:bg-slate-900 shadow-2xl overflow-hidden">

        <div class="p-6 border-b border-slate-100 dark:border-slate-800">

            <h3 class="text-2xl font-black text-slate-800 dark:text-white">
                Notification List
            </h3>

            <p class="text-slate-500 text-sm mt-1">
                Latest notifications & announcements
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50 dark:bg-slate-800">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            #
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Notification
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-black uppercase">
                            Category
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-black uppercase">
                            Push Status
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-black uppercase">
                            Read Status
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-black uppercase">
                            Date
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-black uppercase">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($notifications as $key => $item)

                    @php
                        $notification = $item->notification;
                    @endphp

                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800 transition">

                        <td class="px-6 py-5 border-b dark:border-slate-800">
                            {{ $notifications->firstItem() + $key }}
                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800">

                            <div class="font-bold text-slate-800 dark:text-white">
                                {{ $notification?->title }}
                            </div>

                            <div class="text-sm text-slate-500 mt-1">
                                {{ $notification?->body }}
                            </div>

                        </td>

                        <td class="px-6 py-5 border-b dark:border-slate-800">

                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-600 capitalize">

                                {{ $notification?->category ?? '-' }}

                            </span>

                        </td>

                        <td class="px-6 py-5 text-center border-b dark:border-slate-800">

                            @if($item->is_push_failed)

                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-600">
                                Failed
                            </span>

                            @elseif($item->is_push_sent)

                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-600">
                                Sent
                            </span>

                            @else

                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                Pending
                            </span>

                            @endif

                        </td>

                        <td class="px-6 py-5 text-center border-b dark:border-slate-800">

                            @if($item->is_read)

                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-600">
                                Read
                            </span>

                            @else

                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-600">
                                Unread
                            </span>

                            @endif

                        </td>

                        <td class="px-6 py-5 text-center border-b dark:border-slate-800 text-sm">

                            {{ $notification?->created_at
                                ? \Carbon\Carbon::parse($notification->created_at)->format('d M Y h:i A')
                                : '-' }}

                        </td>

                        <td class="px-6 py-5 text-center border-b dark:border-slate-800">

                            @if(!$item->is_read)

                            <a href="{{ route('teacher.notifications.read', $item->id) }}"
                                class="px-4 py-2 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white text-xs font-bold">

                                Mark Read

                            </a>

                            @else

                            <span class="text-emerald-500 font-bold text-sm">
                                Completed
                            </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7">

                            <div class="text-center py-5">

                                <div class="text-7xl mb-4">
                                    🔔
                                </div>

                                <h3 class="text-2xl font-black text-slate-700 dark:text-white">
                                    No Notifications
                                </h3>

                                <p class="text-slate-500 mt-2">
                                    No notifications available right now.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="p-6">
            {{ $notifications->links() }}
        </div>

    </div>

</div>

@endsection
