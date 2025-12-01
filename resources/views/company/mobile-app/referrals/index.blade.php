@extends('layouts.mobile-layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>
            <li class="text-sm pl-2 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="javascript:;">Dashboard</a>
            </li>
            <li class="text-sm pl-2 font-bold text-white capitalize before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Referral List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Referral List</h6>
    </nav>
@endsection


@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="p-6 pb-0 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between align-center items-center">
                            <h6>Referral List</h6>
                            <div class="flex gap-2">
                                <button type="button" data-modal-target="wallet-modal" data-modal-toggle="wallet-modal"
                                    class="px-3 py-1 bg-emerald-500/50 text-white flex justify-between items-center rounded-full text-sm">
                                    <i class="bi bi-check-circle me-1 text-lg"></i>
                                  Referral Page Content
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="relative flex flex-col min-w-0 my-6 break-words bg-white shadow-xl rounded-2xl">
                    <div class="flex-auto px-3 pt-0 pb-2  overflow-x-auto">
                        <form method="GET" class="my-6 p-4 rounded-xl border">
                            <div class="grid md:grid-cols-4 gap-6">
                                <div>
                                    <input type="text" autocomplete="off" name="name" value="{{ request('search') }}"
                                        placeholder="Search name" class="border p-2 rounded w-full">
                                </div>
                                <div>
                                    <input type="text" autocomplete="off" name="email" value="{{ request('search') }}"
                                        placeholder="Search email" class="border p-2 rounded w-full">
                                </div>
                                <div>
                                    <input type="text" autocomplete="off" name="mobile" value="{{ request('search') }}"
                                        placeholder="Search mobile" class="border p-2 rounded w-full">
                                </div>
                                <div class="flex gap-3">
                                    <select name="acc_type" class="border p-2 rounded w-full">
                                        <option value="">Account Type</option>
                                        <option value="teacher" {{ request('acc_type') == 'teacher' ? 'selected' : '' }}>
                                            Teacher
                                        </option>
                                        <option value="student" {{ request('acc_type') == 'student' ? 'selected' : '' }}>
                                            Student
                                        </option>
                                        <option value="student" {{ request('acc_type') == 'student' ? 'selected' : '' }}>
                                            Staff
                                        </option>
                                    </select>
                                    <button type="submit"
                                        class="bg-emerald-500/50  text-white rounded px-4">Filter</button>

                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="flex-auto px-3 pt-0 pb-2 overflow-x-auto">
                        <table class="w-full border">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">User</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Email</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Referral Code</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Total Visitors</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Joined Users</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Conversion %</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $u)
                                    <tr class="border-b">
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">{{ $u->name }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">{{ $u->email }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70 font-bold">{{ $u->referral_code }}</td>

                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">{{ $u->total_visits }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">{{ $u->joined_users }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                            {{ $u->total_visits > 0 ? round(($u->joined_users / $u->total_visits) * 100, 1) : 0 }}%
                                        </td>

                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                            <a href="{{ route('admin.app.referral.show', $u->id) }}"
                                                class="px-3 py-1 bg-blue-500 text-white rounded">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
