@extends('layouts.layout')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-xl font-semibold mb-4">
        {{ isset($item) ? 'Edit Transfer' : 'Create Transfer' }}
    </h2>

    <form method="POST"
          action="{{ isset($item)
            ? route('admin.transfer.update', $item->id)
            : route('admin.transfer.store') }}">

        @csrf
        @if(isset($item))
            @method('PUT')
        @endif

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="font-medium">Company</label>
                <input type="number" name="company_id" class="border w-full p-2 rounded"
                       value="{{ old('company_id', $item->company_id ?? '') }}">
            </div>

            <div>
                <label class="font-medium">User</label>
                <input type="number" name="user_id" class="border w-full p-2 rounded"
                       value="{{ old('user_id', $item->user_id ?? '') }}">
            </div>

            <div>
                <label class="font-medium">Transfer Amount</label>
                <input type="number" step="0.01" class="border w-full p-2 rounded"
                       name="transfer_amount"
                       value="{{ old('transfer_amount', $item->transfer_amount ?? '') }}">
            </div>

            <div>
                <label class="font-medium">Transaction Source</label>
                <input type="text" class="border w-full p-2 rounded"
                       name="transaction_source"
                       value="{{ old('transaction_source', $item->transaction_source ?? '') }}">
            </div>

            <div>
                <label class="font-medium">Transaction Method</label>
                <select name="transaction_method" class="border w-full p-2 rounded">
                    <option value="bank" {{ old('transaction_method', $item->transaction_method ?? '')=='bank'? 'selected':'' }}>Bank</option>
                    <option value="upi"  {{ old('transaction_method', $item->transaction_method ?? '')=='upi'? 'selected':'' }}>UPI</option>
                </select>
            </div>

        </div>

        <h3 class="mt-6 mb-2 font-semibold">Bank Details</h3>
        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="font-medium">Account No</label>
                <input type="text" name="transfer_to_account_no" class="border w-full p-2 rounded"
                       value="{{ old('transfer_to_account_no', $item->transfer_to_account_no ?? '') }}">
            </div>

            <div>
                <label class="font-medium">IFSC</label>
                <input type="text" name="transfer_to_ifsc_no" class="border w-full p-2 rounded"
                       value="{{ old('transfer_to_ifsc_no', $item->transfer_to_ifsc_no ?? '') }}">
            </div>

            <div>
                <label class="font-medium">Holder Name</label>
                <input type="text" name="transfer_holder_name" class="border w-full p-2 rounded"
                       value="{{ old('transfer_holder_name', $item->transfer_holder_name ?? '') }}">
            </div>
        </div>

        <h3 class="mt-6 mb-2 font-semibold">UPI Details</h3>
        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="font-medium">UPI ID</label>
                <input type="text" name="transfer_upi_id" class="border w-full p-2 rounded"
                       value="{{ old('transfer_upi_id', $item->transfer_upi_id ?? '') }}">
            </div>

            <div>
                <label class="font-medium">UPI Number</label>
                <input type="text" name="transfer_upi_number" class="border w-full p-2 rounded"
                       value="{{ old('transfer_upi_number', $item->transfer_upi_number ?? '') }}">
            </div>

        </div>

        <button class="mt-6 px-6 py-2 bg-blue-600 text-white rounded">
            {{ isset($item) ? 'Update' : 'Create' }}
        </button>

    </form>

</div>
@endsection
