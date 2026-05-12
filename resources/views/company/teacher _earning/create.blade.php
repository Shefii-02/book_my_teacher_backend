@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

        <div class="card-header bg-gradient-primary py-4 border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="text-white mb-1">Create Teacher Earning</h4>
                    <p class="text-white opacity-8 mb-0">Add new teacher earning details</p>
                </div>

                <a href="{{ route('admin.teacher-earnings.index') }}" class="btn btn-white btn-sm">
                    Back
                </a>
            </div>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('admin.teacher-earnings.store') }}" method="POST">
                @csrf

                <div class="row">

                    <div class="col-lg-6 mb-4">
                        <label class="form-label fw-bold">Teacher</label>

                        <select name="teacher_id" class="form-select">
                            <option value="">Select Teacher</option>

                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}"
                                    {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('teacher_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label class="form-label fw-bold">Type</label>

                        <select name="type" id="type" class="form-select">
                            <option value="">Select Type</option>
                            <option value="course">Course</option>
                            <option value="class">Class</option>
                            <option value="subscription">Subscription</option>
                            <option value="referral">Referral</option>
                            <option value="demo">Demo</option>
                            <option value="manual">Manual</option>
                        </select>

                        @error('type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-6 mb-4 d-none" id="course_section">
                        <label class="form-label fw-bold">Course</label>

                        <select name="source_id" class="form-select">
                            <option value="">Select Course</option>

                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">
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
                               placeholder="Enter title"
                               value="{{ old('title') }}">

                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label class="form-label fw-bold">Amount</label>

                        <input type="number"
                               step="0.01"
                               min="0"
                               name="amount"
                               class="form-control"
                               placeholder="0.00"
                               value="{{ old('amount') }}">

                        @error('amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label class="form-label fw-bold">Status</label>

                        <select name="status" class="form-select">
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label class="form-label fw-bold">Earned Date</label>

                        <input type="datetime-local"
                               name="earned_at"
                               class="form-control"
                               value="{{ old('earned_at') }}">
                    </div>

                    <div class="col-12 mb-4">
                        <label class="form-label fw-bold">Remarks</label>

                        <textarea name="remarks"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Enter remarks">{{ old('remarks') }}</textarea>
                    </div>

                </div>

                <div class="text-end">
                    <button type="submit" class="btn bg-gradient-primary px-5">
                        Save Earning
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>
@endsection

@push('script')
<script>

    function handleTypeChange() {

        let type = $('#type').val();

        if(type === 'course') {
            $('#course_section').removeClass('d-none');
        } else {
            $('#course_section').addClass('d-none');
        }
    }

    $(document).ready(function() {

        handleTypeChange();

        $('#type').change(function() {
            handleTypeChange();
        });

    });

</script>
@endpush
