<div class="">

    <h2 class="text-xl font-semibold mb-4">
        {{ 'Transfer Request Process' }}
    </h2>

    <form method="POST"
        action="{{ route('company.app.transfer.update', $item->id) }}">

        @csrf
        @if (isset($item))
            @method('PUT')
        @endif

        <div>
            <label class="font-medium">User</label>
            <div class=" p-2">
                {{ $item->user->name ?? 'N/A' }}
            </div>
            <label class="font-medium">Transfer Amount</label>
            <div class="p-2">
                {{ $item->request_amount ?? 'N/A' }}
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium">Transaction Method</label>
                <select name="transaction_method" id="transaction_method" class="border w-full p-2 rounded">
                    <option value="bank"
                        {{ old('transaction_method', $item->transaction_method ?? '') == 'bank' ? 'selected' : '' }}>
                        Bank
                    </option>
                    <option value="upi"
                        {{ old('transaction_method', $item->transaction_method ?? '') == 'upi' ? 'selected' : '' }}>UPI
                    </option>
                </select>
            </div>

        </div>
        <div class="bank-details" id="bank_details">

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

        </div>
        <div class="upi-details" id="upi_details" style="display: none">

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

        </div>
        <button class="mt-6 px-6 py-2 bg-blue-600 text-white rounded">
            {{ isset($item) ? 'Update' : 'Create' }}
        </button>

    </form>

</div>
