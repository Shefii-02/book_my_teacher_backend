@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')

@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
    @vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
    <div class="row">

        <div class="col-lg-12 col-md-12 order-1">
            <div class="row">
                @foreach ($analytics ?? [] as $data)
                    {{-- growth
                    growth_icon
                    growth_color --}}
                    <div class="col-lg-3 col-md-12 col-6 mb-6">
                        <a href="{{ url($data['url']) }}">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ $data['icon'] }}" alt="chart success" class="rounded">
                                        </div>
                                    </div>
                                    <p class="mb-1 fw-bold">{{ $data['title'] }}</p>
                                    <h4 class="card-title mb-3 text-sm">{{ $data['count'] }}</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-3">
                    <div class="d-flex gap-2">
                        <span class="align-content-center">Status</span>
                        <select name="status" class="form-control">
                            <option value="all">All</option>
                            <option value="pending">Pending</option>
                            <option value="selected">Selected</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="d-flex gap-2">
                        <span class="align-content-center ">WorkMode</span>
                        <select name="status" class="form-control">
                            <option value="all">All</option>
                            <option value="pending">Pending</option>
                            <option value="selected">Selected</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-capitalize">Teacher Name</th>
                        <th class="text-capitalize">Mobile</th>
                        <th class="text-capitalize">Email</th>
                        <th class="text-capitalize text-center">No:of Subjects</th>
                        <th class="text-capitalize">Status</th>
                        <th class="text-capitalize">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr>
                        <td>Albert Cook</td>
                        <td>3445345345</td>
                        <td>albert@gmail.com</td>
                        <td class="text-center">
                            5
                        </td>
                        <td><span class="badge bg-success text-white me-1">Active</span></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-show me-1"></i>
                                        Show</a>
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i>
                                        Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                        Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
