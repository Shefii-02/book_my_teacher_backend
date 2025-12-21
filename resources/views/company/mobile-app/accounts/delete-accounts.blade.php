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
                aria-current="page">Delete Accounts List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Delete Accounts List</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="p-6 pb-0 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between">
                            <h6>Delete Accounts List</h6>
                            <a href="{{ route('company.app.delete_accounts.list') }}"
                                class="bg-emerald-500/50 rounded-full text-sm text-white px-4 fw-bold py-1">
                                <i class="bi bi-list me-1 "></i>
                                Deleted Accounts
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative flex flex-col min-w-0 my-6 break-words bg-white shadow-xl rounded-2xl">
                    <div class="flex-auto py-5 px-3 overflow-x-auto">

                        <table class="items-center w-full my-4 text-slate-500 align-top border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">ID</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">User</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Status</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Requested At
                                    </th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Approved At</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Rejected At</th>
                                    <th class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $req)
                                    <tr>
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                            {{ $req->id }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                            {{ $req->user->name ?? 'Deleted' }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                            {{ ucfirst($req->status ?? 'pending') }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                            {{ $req->created_at }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                            {{ $req->approved_at ?? '-' }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                            {{ $req->rejected_at ?? '-' }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                            <button class="bg-blue-500 text-white px-2 py-1 rounded show-details-btn"
                                                data-id="{{ $req->id }}"
                                                data-user="{{ $req->user->name ?? 'Deleted' }}"
                                                data-company="{{ $req->company->name ?? '-' }}"
                                                data-reason="{{ $req->reason }}"
                                                data-description="{{ $req->description }}"
                                                data-status="{{ ucfirst($req->status ?? 'pending') }}"
                                                data-created="{{ $req->created_at }}"
                                                data-approved="{{ $req->approved_at ?? '-' }}"
                                                data-rejected="{{ $req->rejected_at ?? '-' }}">
                                                View
                                            </button>




                                            @if (!$req->approved_at && !$req->rejected_at)
                                                <form
                                                    action="{{ route('company.app.delete_account_requests.approve', $req->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-green-500 text-white px-2 py-1 rounded">Approve</button>
                                                </form>
                                                <form
                                                    action="{{ route('company.app.delete_account_requests.reject', $req->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-red-500 text-white px-2 py-1 rounded">Reject</button>
                                                </form>

                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Modal -->
    <!-- Details Modal -->
    <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <h4 class="font-bold text-lg mb-3 text-center">Request Details</h4>
            <p><strong>User:</strong> <span id="modalUser"></span></p>
            <p><strong>Company:</strong> <span id="modalCompany"></span></p>
            <p><strong>Reason:</strong> <span id="modalReason"></span></p>
            <p><strong>Description:</strong> <span id="modalDescription"></span></p>
            <p><strong>Status:</strong> <span id="modalStatus"></span></p>
            <p><strong>Requested At:</strong> <span id="modalCreated"></span></p>
            <p><strong>Approved At:</strong> <span id="modalApproved"></span></p>
            <p><strong>Rejected At:</strong> <span id="modalRejected"></span></p>
            <button id="closeModal" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded">Close</button>
        </div>
    </div>
@endsection


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById('detailsModal');
    const closeModal = document.getElementById('closeModal');

    // Get all modal fields
    const fields = [ 'User', 'Company', 'Reason', 'Description', 'Status', 'Created', 'Approved', 'Rejected'];

    document.querySelectorAll('.show-details-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            fields.forEach(f => {
                const el = document.getElementById('modal' + f);
                if(el) el.textContent = this.dataset[f.toLowerCase()] || '-';
            });
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    closeModal.addEventListener('click', function() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    modal.addEventListener('click', function(e) {
        if(e.target === modal){
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });
});
</script>
@endpush
