@extends('layouts.mobile-layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white" href="javascript:;">Home</a>
            </li>
            <li class="text-sm pl-2 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="javascript:;">Dashboard</a>
            </li>
            <li class="text-sm pl-2 font-bold text-white capitalize before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Deleted Accounts List</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Deleted Accounts List</h6>
    </nav>
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3 mt-4">
            <div class="flex-none w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white shadow-xl rounded-2xl">

                    <div class="p-6 pb-0 mb-3 border-b border-transparent rounded-t-2xl">
                        <div class="flex justify-between">
                            <h6>Deleted Accounts List</h6>
                            <a href="{{ route('company.app.delete-accounts.index') }}"
                                class="bg-emerald-500/50 rounded-full text-sm text-white px-4 fw-bold py-1">
                                <i class="bi bi-arrow-left me-1 "></i>
                                Back
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative flex flex-col min-w-0 my-6 break-words bg-white shadow-xl rounded-2xl">
                    <div class="flex-auto py-5 px-3 overflow-x-auto">


                        <table class="items-center w-full my-4 text-slate-500 border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xxs uppercase opacity-70">ID</th>
                                    <th class="px-6 py-3 text-left text-xxs uppercase opacity-70">Name</th>
                                    <th class="px-6 py-3 text-left text-xxs uppercase opacity-70">Email</th>
                                    <th class="px-6 py-3 text-left text-xxs uppercase opacity-70">Deleted At</th>
                                    <th class="px-6 py-3 text-left text-xxs uppercase opacity-70">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deletedUsers as $user)
                                    <tr>
                                        <td class="px-6 py-3 text-sm">{{ $user->id }}</td>
                                        <td class="px-6 py-3 text-sm">{{ $user->name ?? '---' }}</td>
                                        <td class="px-6 py-3 text-sm">{{ $user->email ?? '---' }}</td>
                                        <td class="px-6 py-3 text-sm">{{ $user->deleted_at }}</td>
                                        <td class="px-6 py-3 font-bold text-left text-xxs uppercase opacity-70">
                                            <form action="{{ route('company.app.delete_accounts.restore', $user->id) }}"
                                                method="POST">
                                                @csrf
                                                <button class="bg-green-500 text-white px-2 py-1 rounded show-details-btn"
                                                    type="submit">
                                                    <i class="bi bi-arrow-clockwise"></i> Restore
                                                </button>
                                            </form>
                                            <form action="{{ route('company.app.delete_accounts.force.destroy', $user->id) }}"
                                                id="form_{{ $user->id }}" method="POST">
                                                @csrf @method('DELETE')
                                                <a role="button" href="javascript:;"
                                                    class="bg-green-500 text-white px-2 py-1 rounded show-details-btn"
                                                    onclick="confirmDelete({{ $user->id }})">Delete</a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($deletedUsers->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center py-4">No deleted accounts found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>





                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
