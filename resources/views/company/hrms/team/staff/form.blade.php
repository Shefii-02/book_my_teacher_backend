@extends('layouts.hrms-layout')
@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white " href="javascript:;">Home</a>
            </li>
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Staff {{ isset($staff) ? 'Edit' : 'Create' }}</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Staff {{ isset($staff) ? 'Edit' : 'Create' }}</h6>
    </nav>
@endsection
@section('content')
    <div class="container">
        <div class="card bg-white dark:bg-slate-850 dark:shadow-dark-xl rounded-3 my-3">
            <div class="card-title p-3 my-3">
                <div class="flex justify-between">
                    <h5 class="font-bold dark:text-white">{{ isset($staff) ? 'Edit' : 'Create' }} a staff</h5>
                    <a href="{{ route('admin.hrms.teams.index') }}"
                        class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded-full text-sm">Back</a>
                </div>

            </div>
        </div>

        <div
            class="form-container relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

            <form
                action="{{ isset($staff) ? route('admin.hrms.teams.update', $staff->id) : route('admin.hrms.teams.store') }}"
                method="POST" enctype="multipart/form-data" id="staffForm"
                class="bg-white rounded-2xl shadow p-6 space-y-6">
                @if(isset($staff))
                  @method('PUT')
                @endif

                @csrf
                <!-- Basic Details -->
                <div class="border-b pb-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Basic Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Image -->
                        <div class="col-span-2">

                            <label class="block text-gray-700 mb-2">Profile Image</label>
                            <img id="imgPreview"
                                src="{{ isset($staff) ? $staff->avatar_url : asset('storage/uploads/avatar/avatar.png') }}"
                                alt="Profile Preview" class="w-24 h-24 rounded-lg border mb-3">
                            <input type="file" name="profile" id="imgSelect" accept="image/*"
                                class="block text-sm text-gray-500  w-50 border rounded-lg cursor-pointer focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('title', $staff->name ?? '') }}" placeholder="Enter full name" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('title', $staff->email ?? '') }}" placeholder="Enter email address" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">Mobile <span class="text-red-500">*</span></label>
                            <input type="number" name="mobile" maxlength="15"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('title', $staff->mobile ?? '') }}" placeholder="Enter mobile number" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">Designation <span class="text-red-500">*</span></label>
                            <select
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                name="designation" placeholder="Enter mobile number" required>
                                @foreach ($designations ?? [] as $designation)
                                    <option {{ $staff->role_name == $designation->name ? 'selected' : '' }}
                                        value="{{ $designation->id }}">{{ $designation->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 mt-5">
                        <input id="active_status" type="checkbox" name="is_active"
                            {{ $staff->status == 1 ? 'checked' : '' }} value="1"
                            class="w-5 h-5 text-blue-600 border rounded">
                        <label for="active_status" class="block text-gray-700">Active</label>
                    </div>
                </div>

                <!-- Address Details -->
                <div class="border-b pb-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Address Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 mb-2">Address <span class="text-red-500">*</span></label>
                            <textarea name="address" rows="2"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                            placeholder="Enter address" required>{{ old('address', $staff->address ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">City <span class="text-red-500">*</span></label>
                            <input type="text" name="city"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('city', $staff->city ?? '') }}" placeholder="Enter city" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">District <span class="text-red-500">*</span></label>
                            <input type="text" name="district"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('district', $staff->district ?? '') }}" placeholder="Enter district"
                                required>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">State <span class="text-red-500">*</span></label>
                            <input type="text" name="state"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('state', $staff->state ?? '') }}" placeholder="Enter state" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">Postal Code <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="postal_code" maxlength="10"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('postal_code', $staff->postal_code ?? '') }}"
                                placeholder="Enter postal/zip code" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">Country <span class="text-red-500">*</span></label>
                            <input type="text" name="country"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('country', $staff->country ?? '') }}" placeholder="Enter country" required>
                        </div>
                    </div>
                </div>

                <!-- Payroll Details -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Payroll Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 mb-2">Salary Type <span
                                    class="text-red-500">*</span></label>
                            <select name="salary_type" id="payrollType"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('salary_type', $staff->salary_type ?? '') }}" required>
                                <option value="">Select Type</option>
                                <option
                                    {{ isset($staff) && $staff->payroll && $staff->payroll->salary_type == 'monthly' ? 'selected' : '' }}
                                    value="monthly">Monthly</option>
                                <option
                                    {{ isset($staff) && $staff->payroll && $staff->payroll->salary_type == 'hourly' ? 'selected' : '' }}
                                    value="hourly">Hourly</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">Basic Salary <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="basic_salary" id="basicSalary"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('basic_salary', $staff->payroll->basic_salary ?? '') }}"
                                placeholder="Enter salary" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">Allowances <span class="text-red-500">*</span></label>
                            <input type="number" name="allowances" id="basicSalary"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('allowances', $staff->payroll->allowances ?? '') }}"
                                placeholder="Enter Allowances" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">Deductions <span class="text-red-500">*</span></label>
                            <input type="number" name="deductions" id="basicSalary"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('deductions', $staff->payroll->deductions ?? '') }}"
                                placeholder="Enter Deductions" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">Joining date <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="joining_date" id="basicSalary"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('joining_date', $staff->payroll->joining_date ?? '') }}" required>
                        </div>



                        <div id="hourlyRateField" class="hidden">
                            <label class="block text-gray-700 mb-2">Hourly Rate</label>
                            <input type="number" name="hourly_rate"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('hourly_rate', $staff->payroll->hourly_rate ?? '') }}"
                                placeholder="Enter hourly rate">
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">Payment Mode</label>
                            <select name="payment_mode"
                                class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                value="{{ old('payment_mode', $staff->payment_mode ?? '') }}">
                                <option value="">Select Mode</option>
                                <option
                                    {{ isset($staff) && $staff->payroll && $staff->payroll->payment_mode == 'bank_transfer' ? 'selected' : '' }}
                                    value="bank_transfer">Bank Transfer</option>
                                <option
                                    {{ isset($staff) && $staff->payroll && $staff->payroll->payment_mode == 'cash' ? 'selected' : '' }}
                                    value="cash">Cash</option>
                                <option
                                    {{ isset($staff) && $staff->payroll && $staff->payroll->payment_mode == 'upi' ? 'selected' : '' }}
                                    value="upi">UPI</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg">
                        {{ isset($staff) ? 'Update Staff' : 'Create Staff' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const imgSelect = document.getElementById('imgSelect');
            const imgPreview = document.getElementById('imgPreview');
            const payrollType = document.getElementById('payrollType');
            const hourlyField = document.getElementById('hourlyRateField');
            const basicSalaryField = document.querySelector('input[name="basic_salary"]');

            // Image preview
            imgSelect?.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = e => imgPreview.src = e.target.result;
                reader.readAsDataURL(file);
            });

            // Payroll Type Toggle
            payrollType?.addEventListener('change', () => {
                const type = payrollType.value;

                if (type === 'hourly') {
                    hourlyField.classList.remove('hidden');
                    hourlyField.querySelector('input').required = true;

                    // disable basic salary
                    basicSalaryField.removeAttribute('required');
                    basicSalaryField.setAttribute('disabled', true);
                    basicSalaryField.value = '';
                } else {
                    hourlyField.classList.add('hidden');
                    hourlyField.querySelector('input').required = false;

                    // enable basic salary
                    basicSalaryField.removeAttribute('disabled');
                    basicSalaryField.setAttribute('required', true);
                }
            });
        });
    </script>
@endpush
