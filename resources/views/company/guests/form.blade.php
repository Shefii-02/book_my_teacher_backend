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
                <a class="text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Guest {{ isset($guest) ? 'Edit' : 'Create' }}</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Guest {{ isset($guest) ? 'Edit' : 'Create' }}</h6>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="card bg-white rounded-3 mb-3">
            <div class="card-title p-2 m-2">
                <h5 class="font-bold">{{ isset($guest) ? 'Edit' : 'Create' }} a Guest</h5>
            </div>
        </div>

        <div class="form-container">
            <form
                action="{{ isset($guest) ? route('admin.guest.update', $guest->id) : route('admin.guest.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($guest))
                    @method('PUT')
                @else
                    @method('POST')
                @endif
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <!-- Avatar -->
                    <div class="flex justify-center flex-col">
                        <p>
                            <img id="imgPreview" width="100" src="{{ old('avatar', isset($guest) ?  $guest->avatar_url : '' ?? '') }}" class="rounded w-16 h-16 ms-5">
                        </p>
                        <label for="imgSelect" class="mb-2">Select an Avatar</label>
                        <input type="file" id="imgSelect" name="avatar" accept="image/*"
                            {{ isset($guest) ? '' : 'required' }} ?>
                        @error('avatar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>

                    </div>
                    <div class="flex justify-center flex-col">

                    </div>
                </div>


                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="title"
                        class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                        value="{{ old('title', $guest->name ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email"
                        class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                        value="{{ old('title', $guest->email ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mobile</label>
                    <input type="text" name="mobile"
                        class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                        value="{{ old('title', $guest->mobile ?? '') }}" required>
                </div>

                <div class="flex justify-center">
                    <button
                        class="px-5 py-2.5 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg">{{ isset($guest) ? 'Update' : 'Create' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#imgSelect").change(function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imgPreview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endpush
