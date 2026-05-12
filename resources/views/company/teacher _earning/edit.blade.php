@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

        <div class="card-header bg-gradient-warning py-4 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="text-white mb-1">Edit Teacher Earning</h4>
                    <p class="text-white opacity-8 mb-0">Update earning details</p>
                </div>

                <a href="{{ route('admin.teacher-earnings.index') }}" class="btn btn-white btn-sm">
                    Back
                </a>
            </div>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('admin.teacher-earnings.update', $earning->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-lg-6 mb-4">
                        <label class="form-label fw-bold">Teacher</label>

                        <select name="teacher_id" class="form-select">
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}"
                                    {{ old('teacher_id', $earning->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label class="form-label fw-bold">Type</label>

                        <select name="type" id="type" class="form-select">
                            <option value="course" {{ $earning->type == 'course' ? 'selected' : '' }}>Course</option>
                            <option value="class" {{ $earning->type == 'class' ? 'selected' : '' }}>Class</option>
                            <option value="subscription" {{ $earning->type == 'subscription' ? 'selected' : '' }}>Subscription</option>
                            <option value="referral" {{ $earning->type == 'referral' ? 'selected' : '' }}>Referral</option>
                            <option value="demo" {{ $earning->type == 'demo' ? 'selected' : '' }}>Demo</option>
                            <option value="manual" {{ $earning->type == 'manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>

                    <div class="col-lg-6 mb-4 {{ $earning->type != 'course' ? 'd-none' : '' }}" id="course_section">
                        <label class="form-label fw-bold">Course</label>

                        <select name="source_id" class="form-select">
                            <option value="">Select Course</option>

                            @foreach($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ $earning->source_id == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label class="form-label fw-bold">Title</label>

                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $earning->title) }}">
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label class="form-label fw-bold">Amount</label>

                        <input type="number"
                               step="0.01"
                               name="amount"
                               class="form-control"
                               value="{{ old('amount', $earning->amount) }}">
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label class="form-label fw-bold">Status</label>

                        <select name="status" class="form-select">
                            <option value="pending" {{ $earning->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $earning->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $earning->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $earning->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="refunded" {{ $earning->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    <div class="col-12 mb-4">
                        <label class="form-label fw-bold">Remarks</label>

                        <textarea name="remarks"
                                  rows="4"
                                  class="form-control">{{ old('remarks', $earning->remarks) }}</textarea>
                    </div>

                </div>

                <div class="text-end">
                    <button type="submit" class="btn bg-gradient-warning px-5">
                        Update Earning
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>
@endsection
