<form method="POST" action="{{ route('company.hrms.payroll.advance.store', $user->id) }}">
    @csrf
    <div class="grid gap-3 md:grid-cols-3">
        <input type="number" step="0.01" name="amount" placeholder="Amount" required class="form-input w-full border-gray-300 rounded-md">
        <input type="text" name="reason" placeholder="Reason" class="form-input w-full border-gray-300 rounded-md">
        <input type="date" name="date" class="form-input w-full border-gray-300 rounded-md">
    </div>
    <div class="mt-4 flex justify-end">
        <button class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600">Add Advance</button>
    </div>
</form>
