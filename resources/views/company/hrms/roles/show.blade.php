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
                <a class="text-white" href="javascript:;">Dashboard</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Role : {{ $role->name }}</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Role : {{ $role->name }}</h6>
    </nav>
@endsection

@section('content')
    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <div class="flex">
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                            </div>
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                            </div>
                            <div class="w-full text-right max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-2/4">

                                <a href="{{ route('admin.hrms.roles.index') }}"
                                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded-full text-sm">Back</a>

                            </div>
                        </div>
                    </div>
                    <div class="flex-auto px-0 pt-3 pb-2 min-h-75">
                        <div class="px-3 overflow-x-auto">
                            <div class="container">
                                <h2 class="text-lg font-bold mb-4">Permissions for Role: {{ $role->name }}</h2>

                                <table class="table-auto w-full border">
                                    <thead>
                                        <tr class="bg-gray-200">
                                            <th colspan="2" class="px-4 py-2 border">Permission Name</th>
                                            <th class="px-4 py-2 border">Has Permission?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allPermissions->groupBy('section') as $section => $permission)
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    <strong>{{ $section }}</strong>
                                                </td>
                                            </tr>
                                            @foreach ($permission ?? [] as $permission_section)
                                                <tr>
                                                    <td colspan="2" class="px-4 py-2 border text-capitalize">
                                                        {{ $permission_section->name }}
                                                    </td>
                                                    <td class="px-4 py-2 border text-center">
                                                        @if ($role->hasPermissionTo($permission_section->name))
                                                            ✅
                                                        @else
                                                            ❌
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
