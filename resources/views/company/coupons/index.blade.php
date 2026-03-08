@extends('layouts.layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>
            <li class="text-sm pl-2 capitalize text-white before:content-['/'] before:pr-2">
                <a class="text-white">Dashboard</a>
            </li>
            <li class="text-sm pl-2 font-bold capitalize text-white before:content-['/'] before:pr-2">
                Coupons List
            </li>
        </ol>

        <h6 class="mb-0 font-bold text-white">Coupons List</h6>
    </nav>
@endsection


@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        {{-- ================= DASHBOARD CARDS ================= --}}

        <div class="flex flex-wrap -mx-3 mb-4">

            <div class="w-full max-w-full px-3 sm:w-1/2 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl rounded-2xl">
                    <div class="p-4">
                        <p class="text-sm">Total Coupons</p>
                        <h5 class="font-bold">{{ $stats['total'] }}</h5>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 sm:w-1/2 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl rounded-2xl">
                    <div class="p-4">
                        <p class="text-sm">Active</p>
                        <h5 class="font-bold text-green-600">{{ $stats['active'] }}</h5>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 sm:w-1/2 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl rounded-2xl">
                    <div class="p-4">
                        <p class="text-sm">Expired</p>
                        <h5 class="font-bold text-red-600">{{ $stats['expired'] }}</h5>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 sm:w-1/2 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl rounded-2xl">
                    <div class="p-4">
                        <p class="text-sm">Upcoming</p>
                        <h5 class="font-bold text-blue-600">{{ $stats['upcoming'] }}</h5>
                    </div>
                </div>
            </div>

        </div>


        {{-- ================= FILTER SECTION ================= --}}

        <div class="bg-white p-4 rounded-xl shadow mb-4">

            <form method="GET">

                <div class="flex flex-wrap gap-4 items-end">

                    <div>
                        <label class="text-xs font-semibold">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Offer name or code" class="border px-3 py-2 rounded w-48">
                    </div>

                    <div>
                        <label class="text-xs font-semibold">Status</label>
                        <select name="status" class="border px-3 py-2 rounded">

                            <option value="">All</option>

                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>
                                Expired
                            </option>

                            <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>
                                Upcoming
                            </option>

                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-semibold">Start Date</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="border px-3 py-2 rounded">
                    </div>

                    <div>
                        <label class="text-xs font-semibold">End Date</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="border px-3 py-2 rounded">
                    </div>

                    <div class="flex gap-2">

                        <button class="px-4 py-2 bg-emerald-500 text-white rounded">
                            Search
                        </button>

                        <a href="{{ route('company.coupons.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded">
                            Reset
                        </a>

                    </div>

                </div>

            </form>

        </div>


        {{-- ================= COUPON TABLE ================= --}}

        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-full max-w-full px-3">

                <div class="bg-white shadow-xl rounded-2xl">

                    <div class="p-6 flex justify-between">

                        <h6>Coupons List</h6>

                        <a href="{{ route('company.coupons.create') }}"
                            class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400 text-white rounded text-sm">
                            Create Coupon
                        </a>

                    </div>

                    <div class="overflow-x-auto">

                        <table class="items-center w-full border-collapse text-slate-500">

                            <thead>
                                <tr>

                                    <th class="px-6 py-3 text-xs font-bold text-left uppercase">#</th>

                                    <th class="px-6 py-3 text-xs font-bold text-left uppercase">
                                        Offer Name
                                    </th>

                                    <th class="px-6 py-3 text-xs font-bold text-left uppercase">
                                        Offer Code
                                    </th>

                                    <th class="px-6 py-3 text-xs font-bold text-left uppercase">
                                        Coupon Type
                                    </th>

                                    <th class="px-6 py-3 text-xs font-bold text-left uppercase">
                                        Discount
                                    </th>

                                    <th class="px-6 py-3 text-xs font-bold text-left uppercase">
                                        Validity
                                    </th>

                                    <th class="px-6 py-3"></th>

                                </tr>
                            </thead>


                            <tbody>

                                @forelse ($coupons as $key => $coupon)
                                    <tr>

                                        <td class="px-6 py-3">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="px-6 py-3">
                                            {{ $coupon->offer_name }}
                                        </td>

                                        <td class="px-6 py-3 font-semibold">
                                            {{ $coupon->offer_code }}
                                        </td>

                                        <td class="px-6 py-3">
                                            {{ ucfirst($coupon->coupon_type) }}
                                        </td>

                                        <td class="px-6 py-3">

                                            @if ($coupon->discount_type == 'flat')
                                                ₹{{ $coupon->discount_value }}
                                            @else
                                                {{ $coupon->discount_value }}%
                                            @endif

                                        </td>

                                        <td class="px-6 py-3 text-xs">

                                            {{ \Carbon\Carbon::parse($coupon->start_date_time)->format('d M Y') }}

                                            <br>

                                            {{ \Carbon\Carbon::parse($coupon->end_date_time)->format('d M Y') }}

                                        </td>


                                        <td
                                            class="p-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap text-right">
                                            <button id="dropdownBottomButton"
                                                data-dropdown-toggle="dropdownBottom_{{ $key }}"
                                                data-dropdown-placement="bottom" class="" type="button"> <svg
                                                    class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                        d="M12 6h.01M12 12h.01M12 18h.01" />
                                                </svg> </button> <!-- Dropdown menu -->
                                            <div id="dropdownBottom_{{ $key }}"
                                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                                                <ul class="py-2 text-sm text-gray-700"
                                                    aria-labelledby="dropdownBottomButton">
                                                    <li> <a href="{{ route('company.coupons.edit', $coupon->id) }}"
                                                            class="block px-4 py-2 hover:bg-gray-100">Edit</a> </li>
                                                    <li>
                                                        <form action="{{ route('company.coupons.destroy', $coupon->id) }}"
                                                            id="form_{{ $coupon->id }}" method="POST"> @csrf
                                                            @method('DELETE') <a role="button" href="javascript:;"
                                                                class="block px-4 py-2 hover:bg-gray-100"
                                                                onclick="confirmDelete({{ $coupon->id }})">Delete</a>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            No coupons found
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    <div class="p-4">

                        {{ $coupons->links() }}

                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection
