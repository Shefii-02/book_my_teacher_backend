@extends('layouts.layout')

@push('styles')
    <style>
        .form-container {
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 24px;
        }
    </style>
@endpush

@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white " href="javascript:;">Home</a>
            </li>
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="javascript:;">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Teacher Login Security</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Teacher Login Security</h6>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="card bg-white rounded-3 mb-3">
            <div class="card-title p-2 m-2">
                <h5 class="font-bold">Teacher Login Security</h5>
            </div>
        </div>
        <div class="form-container">
            <form action="{{ route('company.teachers.login-security.change',$teacher->id) }}" method="POST">
              @method('POST')
              @csrf
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="login_email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" name="email" value="{{ isset($teacher) ? $teacher->email : '' }}" id="login_email" placeholder="example@email.com"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                    </div>
                    <div>
                        <label for="login_phone" class="block mb-2 text-sm font-medium text-gray-900">Phone</label>
                        <input type="text" name="mobile" value="{{ isset($teacher) ? $teacher->mobile : '' }}" id="login_phone" placeholder="9876543210"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                        <input type="password" name="password" autocomplete="new-password" id="password" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                    </div>
                </div>
                <div class="flex justify-between">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
