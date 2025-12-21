@extends('layouts.layout')

@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white " href="javascript:;">Home</a>
            </li>
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('company.dashboard') }}">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Role {{ isset($role) ? 'Edit' : 'Create' }}</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Role {{ isset($role) ? 'Edit' : 'Create' }}</h6>
    </nav>
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="card bg-white dark:bg-slate-850 dark:shadow-dark-xl rounded-3 my-3 shadow-md p-5">
            <div class="flex justify-between items-center mb-5">
                <h5 class="font-bold text-gray-700 dark:text-white">
                    {{ isset($role) ? 'Edit' : 'Create' }} Role
                </h5>
                <a href="{{ route('company.hrms.roles.index') }}"
                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400 text-white rounded-full text-sm">
                    Back
                </a>
            </div>

            <form
                action="{{ isset($role) ? route('company.hrms.roles.update', $role->id) : route('company.hrms.roles.store') }}"
                method="POST">
                @csrf
                @if (isset($role))
                    @method('PUT')
                @endif

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium">Role Name</label>
                    <input type="text" name="name"
                        value="{{ old('name', $role->name ?? '') }}"
                        required
                        class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                    @error('name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Permissions Section -->
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium">Permissions</label>

                    @if ($permissions->count())
                        <div class="flex items-center mb-4">
                            <input type="checkbox" id="checkAll" class="w-4 h-4 border-gray-300 rounded text-blue-600 focus:ring-blue-500">
                            <label for="checkAll" class="ml-2 text-sm font-medium text-gray-700">Check All</label>
                        </div>

                        @foreach ($permissions->groupBy('section') as $section => $permissionGroup)
                            <div class="border rounded-lg mb-4 p-3 bg-gray-50 dark:bg-slate-900">
                                <h6 class="text-gray-800 dark:text-white font-semibold mb-2">{{ $section }}</h6>
                                <div class="grid md:grid-cols-3 gap-2">
                                    @foreach ($permissionGroup as $perm)
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                                                class="permission-checkbox w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                {{ isset($role) && $role->permissions->contains($perm->id) ? 'checked' : '' }}>
                                            <span class="text-sm text-gray-700 dark:text-white capitalize">{{ $perm->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-sm">No permissions found.</p>
                    @endif
                </div>

                <div class="text-center">
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg">
                        {{ isset($role) ? 'Update Role' : 'Create Role' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Vanilla JS "Check All" toggle
    document.addEventListener('DOMContentLoaded', () => {
        const checkAll = document.getElementById('checkAll');
        const boxes = document.querySelectorAll('.permission-checkbox');

        checkAll?.addEventListener('change', (e) => {
            boxes.forEach(box => box.checked = e.target.checked);
        });
    });
</script>
@endpush
