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
                            <h6>Wallet List</h6>
                            <div class="flex gap-2">
                                <a type="button"  href="{{ route('company.app.wallets.transations') }}"
                                    class="px-3 py-1 bg-emerald-500/50 text-white flex justify-between items-center rounded-full text-sm">
                                    <i class="bi bi-card-checklist me-1 text-lg"></i>
                                    Wallet Transations
                                </a>
                                <button type="button" data-modal-target="wallet-modal" data-modal-toggle="wallet-modal"
                                    class="px-3 py-1 bg-emerald-500/50 text-white flex justify-between items-center rounded-full text-sm">
                                    <i class="bi bi-plus me-1 text-lg"></i>
                                    Adjust Wallet
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
                        <table class="items-center w-full mb-0 text-slate-500 align-top border-collapse">

                            <thead>
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">#</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">User</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Email</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Mobile</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Acc Type
                                    </th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70 text-green-600">
                                        Green Coins</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70 text-blue-600">
                                        Rupees</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($wallets as $key => $wallet)
                                    <tr>
                                        <td class="px-6 py-3 align-middle  text-left">{{ $key + 1 }}</td>
                                        <td class="px-6 py-3  align-middle  text-left flex gap-3">
                                          <img src="{{ $wallet->user->avatar_url }}" class="w-10 rounded">
                                          {{ $wallet->user->name }}</td>
                                        <td class="px-6 py-3  align-middle  text-left">{{ $wallet->user->email }}</td>
                                        <td class="px-6 py-3  align-middle  text-left">{{ $wallet->user->mobile }}</td>
                                        <td class="px-6 py-3  align-middle  text-left uppercase">
                                            @if ($wallet->user->acc_type == 'teacher')
                                                <span class="bg-emerald-500/50 text-white px-3 py-1 text-xs rounded-full">
                                                    {{ $wallet->user->acc_type ?? 'N/A'  }}
                                                </span>
                                            @elseif ($wallet->user->acc_type == 'student')
                                                <span class="bg-blue-500 text-white px-3 py-1 text-xs rounded-full">
                                                    {{ $wallet->user->acc_type  ?? 'N/A'  }}
                                                </span>
                                            @else
                                            <span class="bg-blue-500/300 text-white px-3 py-1 text-xs rounded-full">
                                                    {{ $wallet->user->acc_type ?? 'N/A'  }}
                                                </span>
                                            @endif
                                          </td>

                                        <td class="px-6 py-3  align-middle   text-left text-green-700 font-bold">
                                            {{ $wallet->green_balance }}
                                        </td>

                                        <td class="px-6 py-3  align-middle text-left text-blue-700 font-bold">
                                            ₹{{ $wallet->rupee_balance }}
                                        </td>

                                        <td class="px-6 py-3  align-middle  text-left text-blue-700 font-bold">
                                            <a href="{{ route('company.app.wallets.show', $wallet->user_id) }}"
                                                class="px-3 py-1 rounded" title="View Details">
                                                <i class="bi bi-eye text-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <h6 class="py-5">No data founded..</h6>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $wallets->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main modal -->
    <div id="wallet-modal" data-modal-backdrop="wallet" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-screen-md bg-white shadow rounded">
            <!-- Modal content -->
            <div class="relative p-4 md:p-6">
                <!-- Modal header -->
                <div class="flex items-center justify-between  pb-4 md:pb-5">
                    <h3 class="text-lg font-medium text-heading">
                        Adjust Wallet
                    </h3>
                    <button type="button"
                        class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="wallet-modal">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                        {{-- <span class="sr-only"> <i class="bi bi-x-lg"></i></span> --}}
                    </button>
                </div>


                {{-- Modal Content --}}
                @include('company.mobile-app.wallets.adjust')
            </div>
        </div>
    </div>
@endsection
