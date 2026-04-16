@extends('layouts.mobile-layout')
@push('styles')
    <style>
        .avatar-xl {
            width: 120px;
            height: 120px;
            border-radius: 20px;
            object-fit: cover;
        }

        .student-header-premium {
            background: #fff;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .metric-card {
            background: #fff;
            padding: 20px;
            border-radius: 14px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .metric-card.success {
            border-left: 5px solid #28a745;
        }

        .metric-card.warning {
            border-left: 5px solid #ffc107;
        }

        .metric-card.info {
            border-left: 5px solid #17a2b8;
        }

        .chart-card {
            background: #fff;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .wallet-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
        }

        .timeline-enterprise .timeline-item {
            padding: 12px;
            border-left: 3px solid #007bff;
            margin-bottom: 10px;
            background: #f9fbff;
        }
    </style>
@endpush

@php


@endphp
@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm">
                <a class="text-white " href="javascript:;">Home</a>
            </li>
            <li
                class="ltext-sm pl-2 capitalize text-neutral-900 text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                <a class="text-white" href="{{ route('company.app.teachers.index') }}">Teachers</a>
            </li>
            <li class="text-sm pl-2  font-bold capitalize  text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Teacher {{ $teacher->name }}</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Teacher {{ $teacher->name }}</h6>
    </nav>
@endsection

@section('content')
    <div class="enterprise-student mt-4">

        <!-- ================= HEADER ================= -->
        <div class="student-header-premium m-5">

            <div class="d-flex justify-content-between flex-wrap">

                <div class="d-flex align-items-center gap-4">
                    <img src="{{ $teacher->user->avatar_url ?? 'https://i.pravatar.cc/150' }}" class="avatar-xl">

                    <div>
                        <h3 class="fw-bold mb-1">{{ $teacher->user->name }}</h3>
                        <p class="text-muted mb-1">ID: {{ $teacher->user->referral_code }}</p>
                        <p class="text-muted mb-1">Mobile: {{ $teacher->user->mobile }}</p>
                        <p class="text-muted mb-1">Email: {{ $teacher->user->email }}</p>

                        <div class="d-flex gap-2 flex-wrap mt-4">
                            Grades : @foreach ($teacher->teachingGrades as $grade)
                                <span class="badge bg-primary">{{ $grade->name }}</span>
                            @endforeach

                        </div>

                        <div class="d-flex gap-2 flex-wrap mt-4">
                            Boards : @foreach ($teacher->teachingBoards ?? [] as $board)
                                <span class="badge bg-warning text-dark">{{ $board->name }}</span>
                            @endforeach
                        </div>
                        <div class="d-flex gap-2 flex-wrap mt-4">
                            Subjects : @foreach ($teacher->teachingSubjects ?? [] as $subject)
                                <span class="badge bg-secondary">{{ $subject->name }}</span>
                            @endforeach
                        </div>

                    </div>
                </div>

                <div class="admin-actions gap-2 d-flex  items-start">
                    <div class="flex flex-col gap-2 items-end">
                        <span
                            class="badge {{ $teacher->user->status == 1 ? 'bg-success' : 'bg-danger' }}">{{ $teacher->user->status == 1 ? 'Active' : 'Deactive' }}</span>

                        <button class="text-primary"><b>Last Active:</b>
                            {{ timeAgo($teacher->user->last_activation) }}</button>
                        <button class="text-success"><b>Registered On:</b>
                            {{ formatDateTime($teacher->user->created_at) }}</button>
                    </div>
                    {{-- <a href="{{ route('company.app.teachers.edit', $teacher->id) }}"
                        class="bg-emerald-500/50 rounded-1.8  text-white px-3 py-2"><i class="bi bi-pencil"></i>
                        Edit</a>
                    <a href="{{ route('company.app.teachers.index') }}"
                        class="bg-emerald-500/50 rounded-1.8  text-white px-3 py-2"> <i
                            class="bi bi-arrow-left"></i>Back</a> --}}
                </div>
            </div>
            <!-- AI Insight -->
            <div class="ai-box mt-4">
                <h6 class="fw-bold">AI Insights</h6>
                <div class="row g-3">
                    <div class="col-md-3"><b>Engagement Score:</b> <span
                            class="badge bg-success">{{ $teacher->user->performance_score }}%</span></div>
                    <div class="col-md-3"><b>Performance:</b> <span
                            class="badge bg-primary">{{ $teacher->user->performance }}</span></div>
                    <div class="col-md-3 text-capitalize"><b>Learning Style:</b>
                        <span class="badge bg-info">{{ $teacher->professionalInfo->teaching_mode }}</span>
                    </div>
                    <div class="col-md-3"><b>Ranking:</b>
                        <span class="badge bg-secondary">{{ $teacher->user->ranking }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="my-5">

        <!-- ================= TABS ================= -->
        <ul class="nav nav-tabs enterprise-tabs mt-4 border-bottom" id="studentTabs">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab"
                    data-bs-target="#overview">Overview</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#personal">Personal
                    Info</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab"
                    data-bs-target="#academics">Academics</button>
            </li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab"
                    data-bs-target="#performance">Performance</button>
            </li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#wallet">Wallet</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#payments">Payments</button>
            </li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#activity">Activity
                    Log</button>
            </li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews">Reviews
                </button>
            </li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab"
                    data-bs-target="#documents">Documents</button>
            </li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#security">Login
                    Devices</button>
            </li>
        </ul>

        <div class="tab-content mt-4 px-4 mb-5">

            <!-- ================= OVERVIEW ================= -->
            <div class="tab-pane fade show active" id="overview">
                <div class="row g-4">

                    <div class="col-lg-3">
                        <div class="metric-card">
                            <p>Total Watch Time</p>
                            <h3>{{ $teacher->user->total_watch_hours ?? 0 }} hrs</h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="metric-card success">
                            <p>Total Spend Time</p>
                            <h3>{{ $teacher->user->total_teaching_hours ?? 0 }} hrs</h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="metric-card warning">
                            <p>Wallet Balance</p>
                            <h3>₹{{ number_format($teacher->user->wallet_balance ?? 0) }}</h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="metric-card info">
                            <p>Courses Launched</p>
                            <h3>{{ $teacher->user->courses_launched_count ?? 0 }}</h3>
                        </div>
                    </div>

                </div>
                <div class="row g-4 mt-2">
                    <div class="col-lg-4">
                        <div class="chart-card">
                            <h6>Average Rating</h6>
                            <div id="watchChartOverview"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="chart-card">
                            <h6>Spend Time</h6>
                            <div id="spendChartOverview"></div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="chart-card">
                            <h6>watch Chart</h6>
                            <div id="watchChartAnalytics"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="chart-card">
                            <h6>Spend Chart</h6>
                            <div id="spendChartAnalytics"></div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="chart-card">
                            <h6>subject Chart</h6>
                            <div id="subjectChart"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="chart-card">
                            <h6>Payment Chart</h6>
                            <div id="paymentChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= Personal ================= -->
            <div class="tab-pane fade" id="personal">

                <!-- 🔥 HEADER ACTION -->
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary btn-sm">Edit Profile</button>
                </div>


                <div class="row g-4">

                    <!-- BASIC INFO -->
                    <div class="col-md-6">
                        <div class="wallet-card">
                            <h6 class="fw-bold mb-3">Basic Information</h6>

                            <p><b>Full Name:</b> {{ $teacher->user->name }}</p>
                            <p><b>Email:</b> {{ $teacher->user->email }}</p>
                            <p><b>Mobile:</b> {{ $teacher->user->mobile }}</p>
                            <p><b>Referral Code:</b> {{ $teacher->user->referral_code }}</p>
                            <p><b>Status:</b>
                                <span class="badge {{ $teacher->user->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $teacher->user->status ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                            <p><b>Profile Completion:</b>
                                <span class="badge bg-success">85%</span>
                            </p>
                        </div>
                    </div>

                    <!-- PERSONAL INFO -->
                    <div class="col-md-6">
                        <div class="wallet-card">
                            <h6 class="fw-bold mb-3">Personal Information</h6>

                            <p><b>Date of Birth:</b> {{ $teacher->dob ?? 'N/A' }}</p>
                            <p><b>Gender:</b> {{ ucfirst($teacher->gender ?? 'N/A') }}</p>
                            <p><b>Blood Group:</b> {{ $teacher->blood_group ?? 'N/A' }}</p>
                            <p><b>Nationality:</b> {{ $teacher->nationality ?? 'Indian' }}</p>
                            <p><b>Languages Known:</b>
                                {{ implode(', ', $teacher->speaking_languages ?? ['English', 'Malayalam']) }}</p>
                        </div>
                    </div>

                    <!-- ADDRESS -->
                    <div class="col-md-6">
                        <div class="wallet-card">
                            <h6 class="fw-bold mb-3">Address Details</h6>

                            <p><b>Address:</b> {{ $teacher->user->address ?? 'N/A' }}</p>
                            <p><b>City:</b> {{ $teacher->user->city ?? 'N/A' }}</p>
                            <p><b>State:</b> {{ $teacher->user->state ?? 'Kerala' }}</p>
                            <p><b>Country:</b> {{ $teacher->user->country ?? 'India' }}</p>
                            <p><b>Pincode:</b> {{ $teacher->user->postal_code ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <!-- PROFESSIONAL SNAPSHOT -->
                    <div class="col-md-6">
                        <div class="wallet-card">
                            <h6 class="fw-bold mb-3">Professional Snapshot</h6>

                            <p><b>Qualification:</b> {{ $teacher->qualifications ?? 'N/A' }}</p>
                            <p><b>Experience:</b>
                                <span>Offline :{{ $teacher->professionalInfo->offline_exp ?? 0 }} Years</span>,
                                <span>Online :{{ $teacher->professionalInfo->online_exp ?? 0 }} Years</span>,
                                <span>Home :{{ $teacher->professionalInfo->home_exp ?? 0 }} Years</span>
                            </p>
                            <p><b>Profession:</b> {{ $teacher->professionalInfo->profession ?? 'N/A' }}</p>
                            <p><b>Ready to Work:</b> {{ $teacher->ready_to_work ?? 'N/A' }}</p>
                            <p><b>Teaching Mode:</b>
                                <span class="badge bg-info text-dark">
                                    {{ ucfirst($teacher->professionalInfo->teaching_mode ?? 'Online') }}
                                </span>
                            </p>
                            <p><b>Price Per Hour:</b> ₹{{ number_format($teacher->price_per_hour ?? 0) }}</p>
                        </div>
                    </div>

                </div>



            </div>

            <!-- ================= Academics ================= -->
            <div class="tab-pane fade" id="academics">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Course</th>
                                <th>Type</th>
                                <th>Students</th>
                                <th>Price</th>
                                <th>Revenue</th>
                                <th>Company Profit</th>
                                <th>Teacher Earnings</th>
                                <th>Classes</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $course)
                                <tr>
                                    <td>
                                        <b>{{ $course->title }}</b><br>
                                        <small class="text-muted">{{ $course->subject }}</small>
                                        <br>
                                        <small>Start
                                            :{{ \Carbon\Carbon::parse($course->start_date)->format('d M Y') }}</small><br>
                                        <small>End :{{ \Carbon\Carbon::parse($course->end_date)->format('d M Y') }}</small>
                                    </td>

                                    <td class="text-start">
                                        <span class="badge bg-success text-light">
                                            {!! $course->type !!}
                                        </span><br>
                                        <small>
                                            {{ $course->is_renewable ? 'Renewable' : 'One Time' }}
                                        </small>
                                    </td>

                                    <td>{{ $course->students_count }}</td>

                                    <td>₹{{ number_format($course->price) }}</td>

                                    <td class="text-success fw-bold">
                                        ₹{{ number_format($course->revenue) }}
                                    </td>

                                    <td class="text-danger">
                                        ₹{{ number_format($course->company_profit) }}
                                    </td>

                                    <td class="text-primary">
                                        ₹{{ number_format($course->teacher_earning) }}
                                    </td>


                                    <td>
                                        <small>
                                            ✔ Completed: {{ $course->classes_completed }} <br>
                                            ⏳ Pending: {{ $course->classes_pending }} <br>
                                            📅 Total: {{ $course->classes_total }}
                                        </small>
                                    </td>


                                    <td>
                                        <span
                                            class="badge
                            {{ $course->status == 'completed'
                                ? 'bg-success'
                                : ($course->status == 'ongoing'
                                    ? 'bg-warning'
                                    : 'bg-secondary') }}">
                                            {{ ucfirst($course->status) }}
                                        </span>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted">
                                        No courses found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- ================= PERFORMANCE ================= -->
            <div class="tab-pane fade" id="performance">


                <!-- 🔥 TOP KPIs -->
                <div class="row g-4 mb-3">

                    <div class="col-md-3">
                        <div class="metric-card success">
                            <p>Avg Rating</p>
                            <h3>⭐ {{ $performance->avg_rating ?? 4.5 }}</h3>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="metric-card info">
                            <p>Completion Rate</p>
                            <h3>{{ $performance->completion_rate ?? 82 }}%</h3>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="metric-card warning">
                            <p>Student Retention</p>
                            <h3>{{ $performance->retention_rate ?? 75 }}%</h3>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="metric-card">
                            <p>Conversion Rate</p>
                            <h3>{{ $performance->conversion_rate ?? 60 }}%</h3>
                        </div>
                    </div>

                </div>

                <!-- 🔥 CHARTS -->
                <div class="row g-4">

                    <div class="col-lg-6">
                        <div class="chart-card">
                            <h6>Weekly Teaching Hours</h6>
                            <div id="teachingHoursChart"></div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="chart-card">
                            <h6>Student Growth</h6>
                            <div id="studentGrowthChart"></div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="chart-card">
                            <h6>Revenue Trend</h6>
                            <div id="revenueChart"></div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="chart-card">
                            <h6>Class Completion Ratio</h6>
                            <div id="completionChart"></div>
                        </div>
                    </div>

                </div>

                <!-- 🔥 PERFORMANCE TABLE -->
                <div class="mt-4">
                    <h5 class="fw-bold">Course Performance</h5>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Rating</th>
                                <th>Students</th>
                                <th>Completion %</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coursePerformance as $cp)
                                <tr>
                                    <td>{{ $cp->title }}</td>
                                    <td>⭐ {{ $cp->rating }}</td>
                                    <td>{{ $cp->students }}</td>
                                    <td>{{ $cp->completion }}%</td>
                                    <td>₹{{ number_format($cp->revenue) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>

            <!-- ================= WALLET ================= -->
            <div class="tab-pane fade" id="wallet">

                <!-- 🔥 TOP SUMMARY -->
                <div class="row g-4 mb-3">

                    <div class="col-md-3">
                        <div class="wallet-card">
                            <p>Total Earnings</p>
                            <h4 class="text-success">₹{{ number_format($wallet->total_earned) }}</h4>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="wallet-card">
                            <p>Available Balance</p>
                            <h4 class="text-primary">₹{{ number_format($wallet->balance) }}</h4>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="wallet-card">
                            <p>Total Withdrawn</p>
                            <h4 class="text-danger">₹{{ number_format($wallet->withdrawn) }}</h4>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="wallet-card">
                            <p>Pending Payout</p>
                            <h4 class="text-warning">₹{{ number_format($wallet->pending) }}</h4>
                        </div>
                    </div>

                </div>

                <!-- 🔥 EARNINGS BREAKDOWN -->
                <div class="row g-4 mb-4">

                    <div class="col-md-4">
                        <div class="wallet-card">
                            <p>Class Earnings</p>
                            <h5>₹{{ number_format($wallet->class_earnings) }}</h5>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="wallet-card">
                            <p>Referral Earnings</p>
                            <h5>₹{{ number_format($wallet->referral_earnings) }}</h5>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="wallet-card">
                            <p>Bonuses</p>
                            <h5>₹{{ number_format($wallet->bonus) }}</h5>
                        </div>
                    </div>

                </div>

                <!-- 🔥 TRANSACTION HISTORY -->
                <div>
                    <h5 class="fw-bold mb-3">Transaction History</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $txn)
                                    <tr>
                                        <td>{{ $txn->date }}</td>

                                        <td>
                                            <span
                                                class="badge
                                    {{ $txn->type == 'credit' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($txn->type) }}
                                            </span>
                                        </td>

                                        <td>{{ $txn->description }}</td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ ucfirst($txn->category) }}
                                            </span>

                                            <br>
                                            <small class="text-muted">
                                                {{ ucfirst(str_replace('_', ' ', $txn->sub_type)) }}
                                            </small>
                                        </td>
                                        <td class="{{ $txn->type == 'credit' ? 'text-success' : 'text-danger' }}">
                                            {{ $txn->type == 'credit' ? '+' : '-' }}
                                            ₹{{ number_format($txn->amount) }}
                                        </td>

                                        <td>
                                            <span
                                                class="badge
                                    {{ $txn->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                                {{ ucfirst($txn->status) }}
                                            </span>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            No transactions found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="tab-pane fade" id="payments">

                <!-- 🔥 SUMMARY -->
                <div class="row g-4 mb-3">

                    <div class="col-md-3">
                        <div class="wallet-card">
                            <p>Total Paid</p>
                            <h4 class="text-success">₹{{ number_format($paymentsSummary->total_paid) }}</h4>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="wallet-card">
                            <p>Pending Payout</p>
                            <h4 class="text-warning">₹{{ number_format($paymentsSummary->pending) }}</h4>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="wallet-card">
                            <p>Failed Payments</p>
                            <h4 class="text-danger">₹{{ number_format($paymentsSummary->failed) }}</h4>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="wallet-card">
                            <p>Last Payout</p>
                            <h6>{{ $paymentsSummary->last_payout_date ?? 'N/A' }}</h6>
                        </div>
                    </div>

                </div>

                <!-- 🔥 BANK DETAILS -->
                <div class="mb-4">
                    <h5 class="fw-bold">Bank Details</h5>

                    <div class="wallet-card">
                        <p><b>Account Holder:</b> {{ $bank->name }}</p>
                        <p><b>Bank:</b> {{ $bank->bank_name }}</p>
                        <p><b>Account No:</b> ****{{ substr($bank->account_number, -4) }}</p>
                        <p><b>IFSC:</b> {{ $bank->ifsc }}</p>
                    </div>
                </div>

                <!-- 🔥 PAYOUT REQUESTS -->
                <div class="mb-4">
                    <h5 class="fw-bold">Payout Requests</h5>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Reference</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payouts as $payout)
                                <tr>
                                    <td>{{ $payout->date }}</td>
                                    <td>₹{{ number_format($payout->amount) }}</td>
                                    <td>{{ $payout->method }}</td>
                                    <td>
                                        <span
                                            class="badge
                            {{ $payout->status == 'completed' ? 'bg-success' : ($payout->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ ucfirst($payout->status) }}
                                        </span>
                                    </td>
                                    <td>#{{ $payout->reference }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- 🔥 PAYMENT HISTORY -->
                <div>
                    <h5 class="fw-bold">Payment History</h5>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Txn ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $pay)
                                <tr>
                                    <td>{{ $pay->date }}</td>
                                    <td>₹{{ number_format($pay->amount) }}</td>
                                    <td>{{ $pay->type }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $pay->status }}</span>
                                    </td>
                                    <td>#{{ $pay->txn_id }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- ================= ACTIVITY ================= -->
            <div class="tab-pane fade" id="activity">

                <!-- 🔥 FILTER -->
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="fw-bold">Activity Timeline</h5>

                </div>

                <!-- 🔥 TIMELINE -->
                <div class="timeline-enterprise">

                    @forelse($activities as $act)
                        <div class="timeline-item">

                            <div class="d-flex justify-content-between">
                                <div>
                                    <b>{{ $act->title }}</b><br>

                                    <small class="text-muted">
                                        {{ $act->description }}
                                    </small>
                                </div>

                                <div class="text-end">
                                    <span
                                        class="badge
                            {{ $act->type == 'login'
                                ? 'bg-primary'
                                : ($act->type == 'class'
                                    ? 'bg-success'
                                    : ($act->type == 'payment'
                                        ? 'bg-warning'
                                        : 'bg-secondary')) }}">
                                        {{ ucfirst($act->type) }}
                                    </span>

                                    <br>
                                    <small class="text-muted">
                                        {{ $act->time }}
                                    </small>
                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="text-center text-muted">
                            No activity found
                        </div>
                    @endforelse

                </div>

            </div>

            <!-- ================= SECURITY ================= -->
            <div class="tab-pane fade" id="security">

                <div class="d-flex justify-content-between mb-3">
                    <h5 class="fw-bold">Login Activity</h5>
                    <span class="text-muted">Last login: {{ $lastLogin ?? 'N/A' }}</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>IP Address</th>
                                <th>Device</th>
                                <th>Location</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logins as $login)
                                <tr>
                                    <td>{{ $login->date }}</td>
                                    <td>{{ $login->ip }}</td>
                                    <td>{{ $login->device }}</td>
                                    <td>{{ $login->location }}</td>
                                    <td>
                                        <span
                                            class="badge
                            {{ $login->status == 'safe' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($login->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No login activity found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="tab-pane fade" id="reviews">

                <!-- 🔥 SUMMARY -->
                <div class="row g-4 mb-4">

                    <div class="col-md-3">
                        <div class="metric-card success">
                            <p>Average Rating</p>
                            <h3>⭐ {{ $reviewStats->avg_rating }}</h3>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="metric-card">
                            <p>Total Reviews</p>
                            <h3>{{ $reviewStats->total_reviews }}</h3>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="metric-card">
                            <p>Rating Distribution</p>

                            @foreach ($reviewStats->distribution as $star => $count)
                                <div class="d-flex justify-content-between">
                                    <span>{{ $star }} ⭐</span>
                                    <span>{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <!-- 🔥 REVIEWS LIST -->
                <div class="mt-3">
                    <h5 class="fw-bold mb-3">Student Reviews</h5>

                    @forelse($reviews as $review)
                        <div class="border rounded p-3 mb-3">

                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ $review->student }}</strong><br>
                                    <small class="text-muted">{{ $review->date }}</small>
                                </div>

                                <div>
                                    ⭐ {{ $review->rating }}/5
                                </div>
                            </div>

                            <p class="mt-2 mb-1">{{ $review->comment }}</p>

                            <small class="text-muted">
                                Course: {{ $review->course }}
                            </small>

                        </div>
                    @empty
                        <p class="text-muted">No reviews yet</p>
                    @endforelse
                </div>

            </div>


            <div class="tab-pane fade" id="documents">

                <!-- 🔥 PERSONAL INFO -->
                <div class="mb-4">

                    <div class="wallet-card">
                        <p><b>Name:</b> {{ $teacher->user->name }}</p>
                        <p><b>Email:</b> {{ $teacher->user->email }}</p>
                        <p><b>Mobile:</b> {{ $teacher->user->mobile }}</p>
                        <p><b>DOB:</b> {{ $teacher->dob ?? 'N/A' }}</p>
                        <p><b>Gender:</b> {{ $teacher->gender ?? 'N/A' }}</p>
                        <p><b>Address:</b> {{ $teacher->address ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- 🔥 PROFESSIONAL INFO -->
                <div class="mb-4">
                    <h5 class="fw-bold">Professional Details</h5>

                    <div class="wallet-card">
                        <p><b>Qualification:</b> {{ $teacher->qualification }}</p>
                        <p><b>Experience:</b> {{ $teacher->experience }} years</p>
                        <p><b>Specialization:</b> {{ $teacher->specialization }}</p>
                    </div>
                </div>

                <!-- 🔥 DOCUMENTS -->
                <div>
                    <h5 class="fw-bold">Uploaded Documents</h5>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Document</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($documents as $doc)
                                <tr>
                                    <td>{{ $doc->name }}</td>
                                    <td>{{ $doc->type }}</td>

                                    <td>
                                        <span
                                            class="badge
                            {{ $doc->status == 'approved' ? 'bg-success' : ($doc->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ ucfirst($doc->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        <a href="{{ $doc->file_url }}" target="_blank" class="btn btn-sm btn-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>


        </div>

    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // WATCH CHART (Overview)
                new ApexCharts(document.querySelector("#watchChartOverview"), {
                    chart: {
                        type: 'line',
                        height: 300
                    },
                    series: [{
                        name: 'Watch Time',
                        data: [0, 0, 0, 0, 0, 0, 0]
                    }],
                    xaxis: {
                        categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                    }
                }).render();


                // SPEND CHART (Overview)
                new ApexCharts(document.querySelector("#spendChartOverview"), {
                    chart: {
                        type: 'area',
                        height: 300
                    },
                    series: [{
                        name: 'Teaching Time',
                        data: [0, 0, 0, 0, 0, 0, 0]
                    }],
                    xaxis: {
                        categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                    }
                }).render();


                // WATCH ANALYTICS
                new ApexCharts(document.querySelector("#watchChartAnalytics"), {
                    chart: {
                        type: 'bar',
                        height: 300
                    },
                    series: [{
                        name: 'Watch',
                        data: [0, 0, 0, 0, 0, 0, 0]
                    }],
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                    }
                }).render();


                // SPEND ANALYTICS
                new ApexCharts(document.querySelector("#spendChartAnalytics"), {
                    chart: {
                        type: 'line',
                        height: 200
                    },
                    series: [{
                        name: 'Spend',
                        data: [0, 0, 0, 0, 0, 0]
                    }]
                }).render();


                // SUBJECT PIE
                new ApexCharts(document.querySelector("#subjectChart"), {
                    chart: {
                        type: 'pie',
                        height: 300
                    },
                    series: [0, 0, 0, 0],
                    labels: ['Math', 'Science', 'English', 'Physics']
                }).render();


                // PAYMENT CHART
                new ApexCharts(document.querySelector("#paymentChart"), {
                    chart: {
                        type: 'area'
                    },
                    series: [{
                        name: 'Payments',
                        data: [0, 0, 0, 0, 0, 0]
                    }],
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                    }
                }).render();

            });
        </script>
    @endpush
@endpush
