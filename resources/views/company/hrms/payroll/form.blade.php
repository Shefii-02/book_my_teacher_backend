@extends('layouts.backend-app')

@section('content')
<div class="container mx-auto px-6 py-6">
    <div class="bg-white shadow-lg rounded-2xl p-6">
        <h2 class="text-xl font-semibold mb-4">Payroll Setup for {{ $user->name }}</h2>

        <form method="POST" action="{{ route('admin.hrms.payroll.store', $user->id) }}">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block font-medium mb-1">Salary Type</label>
                    <select name="salary_type" class="form-select w-full border-gray-300 rounded-md">
                        <option value="monthly">Monthly</option>
                        <option value="hourly">Hourly</option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium mb-1">Basic Salary</label>
                    <input type="number" step="0.01" name="basic_salary" class="form-input w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block font-medium mb-1">Hourly Rate</label>
                    <input type="number" step="0.01" name="hourly_rate" class="form-input w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block font-medium mb-1">Total Hours</label>
                    <input type="number" step="0.1" name="total_hours" class="form-input w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block font-medium mb-1">Allowances</label>
                    <input type="number" step="0.01" name="allowances" class="form-input w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block font-medium mb-1">Deductions</label>
                    <input type="number" step="0.01" name="deductions" class="form-input w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block font-medium mb-1">Payment Mode</label>
                    <select name="payment_mode" class="form-select w-full border-gray-300 rounded-md">
                        <option value="cash">Cash</option>
                        <option value="bank">Bank Transfer</option>
                        <option value="upi">UPI</option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium mb-1">Joining Date</label>
                    <input type="date" name="joining_date" class="form-input w-full border-gray-300 rounded-md">
                </div>
            </div>

            <div class="mt-5 flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Save Payroll
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
