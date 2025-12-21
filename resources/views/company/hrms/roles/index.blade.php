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
                aria-current="page">Roles List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Roles List</h6>
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
                                <h6 class="dark:text-white">Roles List</h6>
                            </div>
                            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">

                            </div>
                            <div class="w-full text-right max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-2/4">

                                <a href="{{ route('company.hrms.roles.create') }}"
                                    class="px-4 py-2 bg-gradient-to-tl from-emerald-500 to-teal-400  text-white rounded-full text-sm">Create</a>

                            </div>
                        </div>
                    </div>
                    <div class="flex-auto px-0 pt-3 pb-2 min-h-75">
                        <div class="px-3 overflow-x-auto">
                            <table
                                class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                                <thead class="align-bottom">

                                    <tr>
                                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">#</th>
                                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Designation </th>
                                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Permissions </th>
                                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $key => $role)
                                        <tr class="font-style">
                                           <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                {{ $key+1 }}</td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                {{ $role->name }}</td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                @for ($j = 0; $j < count($role->permissions()->pluck('name')); $j++)
                                                    <span
                                                        class="badge rounded-pill bg-primary text-capitalize">{{ $role->permissions()->pluck('name')[$j] }}</span>
                                                @endfor
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                <button id="dropdownBottomButton"
                                                    data-dropdown-toggle="dropdownBottom_{{ $key }}"
                                                    data-dropdown-placement="bottom" class="" type="button">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                            d="M12 6h.01M12 12h.01M12 18h.01" />
                                                    </svg>
                                                </button>
                                                <!-- Dropdown menu -->
                                                <div id="dropdownBottom_{{ $key }}"
                                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                        aria-labelledby="dropdownBottomButton">
                                                        <li>
                                                            <a href="{{ route('company.hrms.roles.show', $role->id) }}"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Show</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('company.hrms.roles.edit', $role->id) }}"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Edit</a>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('company.hrms.roles.destroy', $role->id) }}"
                                                                id="form_{{ $role->id }}" method="POST"
                                                                class="d-inline-block  w-full">
                                                                @csrf @method('DELETE')
                                                                <a role="button" href="javascript:;"
                                                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white"
                                                                    onclick="confirmDelete({{ $role->id }})">Delete</a>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
