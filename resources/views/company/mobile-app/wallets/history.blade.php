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
                aria-current="page">Wallet Transations</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Wallet Transations List</h6>
    </nav>
@endsection


@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="p-6 pb-0 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between align-center items-center">
                            <h6>Wallet Transations</h6>
                            <div class="flex gap-2">
                                <a type="button" href="{{ route('admin.app.wallets.index') }}"
                                    class="px-3 py-1 bg-emerald-500/50 text-white flex justify-between items-center rounded-full text-sm">
                                    <i class="bi bi-arrow-left me-1 text-lg"></i>
                                    Back
                                </a>
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

                                        <option value="">Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                            Approved
                                        </option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                            Rejected
                                        </option>
                                    </select>
                                    <button type="submit"
                                        class="bg-emerald-500/50  text-white rounded px-4">Filter</button>

                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="flex-auto px-3 pt-0 pb-2 overflow-x-auto">
                        <!-- TABLE -->
                        <table class="items-center w-full mb-0 text-slate-500 align-top border-collapse">

                            <thead>
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">#</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">User</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Title</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Type</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Coins
                                    </th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70 text-green-600">
                                        Status</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70 text-blue-600">
                                        Date</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($histories as $key => $h)
                                    <tr>
                                        <td class="px-6 py-3 align-middle  text-left">
                                            <small>{{ $key + 1 }}
                                            </small>
                                        </td>
                                        <td class="px-6 py-3 align-middle  text-left">
                                            <img src="{{ $h->user->avatar_url }}" class="w-10 rounded-1">
                                            {{ $h->user->name }} <br>
                                            <small>{{ $h->user->email }}</small>
                                        </td>

                                        <td class="px-6 py-3 align-middle  text-left">{{ $h->title }}</td>

                                        <td class="px-6 py-3 align-middle  text-left">
                                            <span class="badge bg-{{ $h->type == 'credit' ? 'success' : 'danger' }}">
                                                {{ $h->type }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-3 align-middle  text-left">{{ $h->amount }}</td>

                                        <td class="px-6 py-3 align-middle  text-left">
                                            <span
                                                class="text-white px-3 py-1 capitalize text-xs rounded-full bg-{{ $h->status == 'approved' ? 'emerald-500/50 ' : ($h->status == 'pending' ? 'blue-300' : 'red-700') }}">
                                                {{ $h->status }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-3 align-middle  text-left">{{ $h->date }}</td>

                                        <td class="px-6 py-3 align-middle  text-left ">
                                            <div class="flex gap-3 items-center ">
                                                <button data-modal-target="wallet-modal" data-modal-toggle="wallet-modal"
                                                    data-title="{{ $h->title }}" data-amount="{{ $h->amount }}"
                                                    data-type="{{ $h->type }}" data-status="{{ $h->status }}"
                                                    data-date="{{ $h->date }}" data-notes="{{ $h->notes }}"
                                                    class="bg-brand px-4 py-2 rounded hover:bg-brand-strong"
                                                    title="Detailed View">
                                                    <i class="bi bi-eye"></i>
                                                </button>


                                                @if ($h->status == 'pending')
                                                    <form action="{{ route('admin.app.wallets.approve', $h->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-sm btn-success" title="Approve">
                                                            <i class="bi bi-check2-circle"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if ($h->status == 'approved')
                                                    <form action="{{ route('admin.app.wallets.rollback', $h->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-sm btn-danger" title="Rollback">
                                                            <i class="bi bi-arrow-repeat"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $histories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="wallet-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden fixed top-0 left-0 right-0 z-50 w-full h-full overflow-y-auto flex justify-center items-center">

        <div class="relative p-4 w-full max-w-xl">
            <div class="relative bg-white rounded-lg shadow border p-6">

                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Wallet Transaction Details</h3>

                    <button type="button" data-modal-hide="wallet-modal" class="text-gray-400 hover:text-gray-700">
                        ✕
                    </button>
                </div>

          <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">

                    <table class="w-full text-sm text-left rtl:text-right text-body">
                        <tr>
                            <th>Title</th>
                            <td><span id="wm_title"></span></td>
                        </tr>
                        <tr>
                            <th>Amount</th>
                            <td><span id="wm_amount"></span></td>
                        </tr>
                        <tr>
                            <th> Type</th>
                            <td><span id="wm_type"></span></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span id="wm_status"></span></td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td><span id="wm_date"></span></td>
                        </tr>
                        <tr>
                            <th>Notes</th>
                            <td><span id="wm_notes"></span></td>
                        </tr>
                    </table>

                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll("[data-modal-toggle]").forEach(button => {

                button.addEventListener("click", function() {

                    const modalId = this.dataset.modalToggle;
                    const modalEl = document.getElementById(modalId);

                    // Assign Modal Values
                    document.getElementById("wm_title").innerText = this.dataset.title ?? "-";
                    document.getElementById("wm_amount").innerText = this.dataset.amount ?? "-";
                    document.getElementById("wm_type").innerText = this.dataset.type ?? "-";
                    document.getElementById("wm_status").innerText = this.dataset.status ?? "-";
                    document.getElementById("wm_date").innerText = this.dataset.date ?? "-";
                    document.getElementById("wm_notes").innerText = this.dataset.notes ?? "-";

                });

            });
        });
    </script>
@endsection
