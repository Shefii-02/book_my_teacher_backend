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
                aria-current="page">Wallet List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Wallet List</h6>
    </nav>
@endsection


@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="p-6 pb-0 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between align-center items-center">
                            <h6>Referral Details for: {{ $user->name }} ({{ $user->referral_code }})</h6>
                            <div class="flex gap-2">
                                <a type="button" href="{{ route('company.app.referral.index') }}"
                                    class="px-3 py-1 bg-emerald-500/50 text-white flex justify-between items-center rounded text-sm">
                                    <i class="bi bi-arrow-left me-1 text-lg"></i>
                                    Back
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="relative flex flex-col min-w-0 my-6 break-words bg-white shadow-xl rounded-2xl">


                    <div class="grid grid-cols-5 gap-1 mb-6 p-4">

                        <div class="p-4 bg-green-100 rounded">
                            <h4 class="font-semibold text-lg">Total Visitors</h4>
                            <p class="text-3xl">{{ $totalVisitors }}</p>
                        </div>

                        <div class="p-4 bg-blue-100 rounded">
                            <h4 class="font-semibold text-lg">Joined Users</h4>
                            <p class="text-3xl">{{ $joinedCount }}</p>
                        </div>

                        <div class="p-4 bg-yellow-100 rounded">
                            <h4 class="font-semibold text-lg">Conversion Rate</h4>
                            <p class="text-3xl">
                                {{ $totalVisitors ? round(($joinedCount / $totalVisitors) * 100, 1) : 0 }}%
                            </p>
                        </div>
                         <div class="p-4 bg-blue-100 rounded">
                            <h4 class="font-semibold text-lg">Green Coins</h4>
                            <p class="text-3xl">{{ $joinedCount }}</p>
                        </div>

                        <div class="p-4 bg-yellow-100 rounded">
                            <h4 class="font-semibold text-lg">Rupees</h4>
                            <p class="text-3xl">
                                {{ $totalVisitors ? round(($joinedCount / $totalVisitors) * 100, 1) : 0 }}%
                            </p>
                        </div>

                    </div>

                    <div class="p-4">
                        <h3 class="text-xl font-semibold p-3">Referral Visits & Join Details</h3>

                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-100">

                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Applied</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Applied User</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Visitor IP</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Device Hash</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">First Visit</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Last Visit</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($referrals as $ref)
                                    <tr class="border-b">
                                      <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                            @if ($ref->applied)
                                                <span class="text-green-700 font-semibold">YES</span>
                                            @else
                                                <span class="text-red-600">NO</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                            {{ $ref->appliedUser->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                            {{ $ref->ip }}</td>
                                        <td title="{{ $ref->device_hash, }}" class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70 text-xs">
                                            {{ Str::limit($ref->device_hash,'10') }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                            {{ $ref->first_visit }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                            {{ $ref->last_visit }}</td>


                                        <td
                                            class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70 text-sm font-semibold">
                                            {{ ucfirst($ref->status) }}
                                            @if ($ref->status == 'active')
                                                <form id="form__{{ $ref->id }}" method="POST"
                                                    action="{{ route('company.app.referral.credit', $ref->id) }}">
                                                    @csrf @method('POST')
                                                </form>
                                                <button form="form__{{ $ref->id }}"  type="submit"
                                                    class="px-3 py-1 bg-blue-500 text-white rounded mt-2 text-xxs" role="button">Credit Points</button>
                                            @endif
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $referrals->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
