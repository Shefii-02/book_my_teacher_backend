@extends('layouts.layout')

@push('styles')
    <style>
        .form-container {
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
            padding: 32px;
        }
    </style>
@endpush

@section('nav-options')
    <nav>
        <!-- Breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-sm">
                <a class="text-white hover:underline" href="{{ route('admin.dashboard') }}">Home</a>
            </li>
            <li
                class="text-sm pl-2 capitalize text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                Dashboard
            </li>
            <li
                class="text-sm pl-2 font-semibold capitalize text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">
                Profile
            </li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Profile Management</h6>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="form-container space-y-10">
            <!-- Profile Update -->
            <div class="card rounded-xl border border-gray-200 shadow-md">
                <div class="card-header border-b px-6 py-4">
                    <h5 class="font-semibold text-lg text-gray-700">Update Profile</h5>
                </div>
                <div class="card-body p-6">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="flex items-center gap-6">
                            <!-- Avatar Upload -->
                            <div class="flex flex-col items-center text-center">
                                <img class="w-24 h-24 object-cover rounded-full border-4 border-indigo-200"
                                    src="{{ auth()->user()->avatar_url }}" id="imagePreview" alt="Profile Picture">
                                <label
                                    class="mt-3 cursor-pointer px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow">
                                    Change Picture
                                    <input type="file" id="avatarInput" accept="image/*" class="hidden" name="avatar"
                                        onchange="previewImage(event)">
                                </label>
                                @error('avatar')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- User Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 flex-1">
                                <div>
                                    <label for="first_name"
                                        class="block mb-2 text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" id="first_name" name="name"
                                        value="{{ auth()->user()->name }}"
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('first_name')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email"
                                        class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" id="email" name="email" value="{{ auth()->user()->email }}"
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2.5 bg-emerald-500/50 hover:bg-emerald-700 text-white rounded-lg shadow font-medium">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card rounded-xl border border-gray-200 shadow-md mt-5">
                <div class="card-header border-b px-6 py-4">
                    <h5 class="font-semibold text-lg text-gray-700">Change Password</h5>
                </div>
                <div class="card-body p-6">
                    <form action="{{ route('admin.profile.changePassword') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="new_password"
                                    class="block mb-2 text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" id="new_password" name="new_password"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Enter new password" required>
                                @error('new_password')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="new_password_confirmation"
                                    class="block mb-2 text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Confirm new password" required>
                                @error('new_password_confirmation')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2.5 bg-emerald-500/50 hover:bg-indigo-700 text-white rounded-lg shadow font-medium">
                                Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush
