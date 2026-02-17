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
                aria-current="page">Transfer Reward List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Transfer Reward List</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="p-6 pb-0 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between">
                            <h6>Transfer Reward List</h6>

                        </div>
                    </div>
                </div>
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">
                    <div class="flex justify-between">
                        <div class="flex p-3">
{{-- confused --}}
                            @php
                                $tabs = ['pending', 'approved', 'rejected'];
                            @endphp

                            @foreach ($tabs as $tab)
                                <a href="{{ route('company.app.transfer.index', ['status' => $tab]) }}"
                                    class="px-4 py-2  text-sm font-semibold
           {{ $status == $tab ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                                    {{ ucfirst($tab) }}
                                </a>
                            @endforeach

                        </div>
                        <div class="px-6 mt-4">
                            <form method="GET" action="{{ route('company.app.transfer.index') }}" class="flex space-x-2">

                                <input type="hidden" name="status" value="{{ $status }}">

                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search name, email, mobile..." class="border px-3 py-2 rounded w-64">

                                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                                    Search
                                </button>

                            </form>
                        </div>
                    </div>


                    <div class="flex-auto px-3 pt-3 pb-2 overflow-x-auto">
                        <table class="items-center w-full my-5 text-slate-500 align-top border-collapse">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                        ID</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                        User</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                        Request Amount</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                        Total Green Coins</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                        Total Rupees</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                        Requested At</th>

                                    <th class="px-6 py-3 font-bold text-center text-xxs uppercase opacity-70">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($tRequests ?? [] as $req)
                                    <tr>
                                        <td class="px-6 py-3 font-bold text-left text-xxs opacity-70">{{ $req->id }}
                                        </td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs opacity-70">
                                            {{ $req->user->name ?? '-' }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs opacity-70">
                                            {{ $req->request_amount ?? '-' }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs opacity-70">
                                            {{ $req->user->wallet?->green_balance ?? '--' }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs opacity-70">
                                            {{ $req->user->wallet?->rupee_balance ?? '--' }}
                                        </td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs opacity-70">
                                            {{ $req->created_at }}</td>
                                        <td class="px-6 py-3 font-bold text-right text-xxs opacity-70 space-x-2">
                                          @if($req->status == 'pending')
                                            <a data-url="{{ route('company.app.transfer.edit', $req->id) }}" href="#"
                                                class="open-drawer text-light btn btn-sm btn-success hover:underline"><i
                                                    class="bi bi-check"></i> Approve</a>
                                            <form action="{{ route('company.app.reviews.destroy', $req->id) }}"
                                                method="POST" class="inline-block" id="form_{{ $req->id }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" onclick="confirmDelete({{ $req->id }})"
                                                    class="w-full text-left text-light btn btn-danger btn-sm hover:underline px-4 py-2 text-xxs">
                                                    <i class="bi bi-x-lg"></i> Reject
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-3 font-bold text-center text-xxs uppercase opacity-70">No
                                            Transfer requests found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $tRequests->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            function toggleFields() {
                let value = $('#transaction_method').val();

                if (value === 'bank') {
                    $('#bank_details').show();
                    $('#upi_details').hide();
                } else if (value === 'upi') {
                    $('#bank_details').hide();
                    $('#upi_details').show();
                } else {
                    $('#bank_details').hide();
                    $('#upi_details').hide();
                }
            }

            // Run on page load (important for edit mode)
            toggleFields();

            // On change
            $('body').on('change', '#transaction_method', function() {
                toggleFields();
            });

        });
    </script>
@endpush
