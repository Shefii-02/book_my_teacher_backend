@extends('layouts.layout')

@push('styles')
    <style>
        .avatar-xl {
            width: 110px;
            height: 110px;
            border-radius: 16px;
            object-fit: cover;
        }

        .student-header-premium {
            background: #fff;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .metric-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .metric-card p {
            font-size: 15px !important;
            margin-bottom: 0 !important;
        }

        .metric-card h3 {
            font-size: 18px !important;
            font-weight: 800;
        }

        .tab-content {
            margin-top: 20px;
        }

        .timeline-enterprise {
            position: relative;
            margin-left: 20px;
            padding-left: 20px;
            border-left: 2px solid #e5e7eb;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
            padding-left: 10px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -31px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #3b82f6;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #e5e7eb;
        }

        .timeline-card {
            background: #fff;
            border-radius: 12px;
            padding: 14px 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: 0.2s ease;
        }

        .timeline-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        .timeline-title {
            font-weight: 600;
            font-size: 14px;
        }

        .timeline-desc {
            font-size: 12px;
            color: #6b7280;
        }

        .timeline-time {
            font-size: 11px;
            color: #9ca3af;
        }

        .timeline-item.login::before {
            background: #3b82f6;
        }

        .timeline-item.class::before {
            background: #10b981;
        }

        .timeline-item.payment::before {
            background: #f59e0b;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4">

        <!-- ================= HEADER ================= -->
        <div class="student-header-premium mb-3">
            <div class="d-flex justify-content-between flex-wrap">

                <div class="d-flex gap-3">
                    <img src="{{ $student->avatar_url }}" class="avatar-xl">

                    <div>
                        <h4 class="fw-bold mb-1">{{ $student->name }}</h4>
                        <small>ID: {{ $student->referral_code }}</small><br>
                        <small>{{ $student->email }} | {{ $student->mobile }}</small>

                        <div class="mt-2">
                            <p>Registered On: {{ formatDateTime($student->created_at) }} </p>
                            <p>Last Active: {{ timeAgo($student->last_active) }} </p>
                            <p>Last Payment: {{ formatDateTime($overview->last_payment) }} </p>

                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <h5 class="fw-bold">₹{{ number_format($overview->total_spent) }}</h5>
                    <small>Total Spent</small>
                </div>

            </div>
        </div>

        <!-- ================= TABS ================= -->
        <ul class="nav nav-tabs">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab"
                    data-bs-target="#overview">Overview</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#personal">Personal
                    Info</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#academics">Academic
                </button></li>
            {{-- <li class="nav-item"><button class="nav-link" data-bs-toggle="tab"
                    data-bs-target="#performance">Performance</button></li> --}}
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#payments">Payments</button>
            </li>

            <!-- NEW -->
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#wallet">Wallet</button></li>

            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#activity_log">Activity
                    Log</button>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews">Reviews</button>
            </li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#security">
                    Login Devices</button></li>

        </ul>

        <div class="tab-content">

            <!-- ================= OVERVIEW ================= -->
            <div class="tab-pane fade show active" id="overview">
                <div class="row g-4 mb-5">

                    <div class="col-lg-3">
                        <div class="metric-card">
                            <p>Total Spend Amount</p>
                            <h3>{{ $overview->total_spent ?? 0 }}</h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="metric-card info">
                            <p>Courses Entrolled</p>
                            <h3>{{ $overview->courses ?? 0 }}</h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="metric-card info">
                            <p>Attended Webinars</p>
                            <h3>{{ $overview->webinars ?? 0 }}</h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="metric-card info">
                            <p>Attended Workshops</p>
                            <h3>{{ $overview->workshops ?? 0 }}</h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="metric-card success">
                            <p>Total Referrals</p>
                            <h3>{{ $overview->referrals ?? 0 }} </h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="metric-card success">
                            <p>Total Referral Bonus</p>
                            <h3>{{ $overview->referral_bonus ?? 0 }} </h3>
                        </div>
                    </div>


                    <div class="col-lg-3">
                        <div class="metric-card warning">
                            <p>Wallet Balance</p>
                            <h3>₹{{ number_format($student->wallet_balance ?? 0) }}</h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="metric-card success">
                            <p>Total Attendance</p>
                            <h3>{{ $overview->attended ?? 0 }} </h3>
                        </div>
                    </div>


                </div>
                {{-- <div class="row g-4 mt-2">
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
                </div> --}}
            </div>

            <!-- ================= Personal ================= -->
            <div class="tab-pane fade" id="personal">

                <!-- 🔥 HEADER ACTION -->
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary btn-sm">Edit Profile</button>
                </div>


                <div class="row g-4 mb-5">

                    <!-- BASIC INFO -->
                    <div class="col-md-6">
                        <div class="wallet-card">
                            <h6 class="fw-bold mb-3">Basic Information</h6>

                            <p><b>Full Name:</b> {{ $student->name }}</p>
                            <p><b>Email:</b> {{ $student->email }}</p>
                            <p><b>Mobile:</b> {{ $student->mobile }}</p>
                            <p><b>Referral Code:</b> {{ $student->referral_code }}</p>
                            <p><b>Status:</b>
                                <span class="badge {{ $student->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $student->status ? 'Active' : 'Inactive' }}
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

                            <p><b>Date of Birth:</b> {{ $student->dob ?? 'N/A' }}</p>
                            <p><b>Gender:</b> {{ ucfirst($student->gender ?? 'N/A') }}</p>
                            <p><b>Blood Group:</b> {{ $student->blood_group ?? 'N/A' }}</p>
                            <p><b>Nationality:</b> {{ $student->nationality ?? 'Indian' }}</p>
                            <p><b>Languages Known:</b>
                                {{ implode(', ', $student->speaking_languages ?? ['English', 'Malayalam']) }}</p>
                        </div>
                    </div>

                    <!-- ADDRESS -->
                    <div class="col-md-6">
                        <div class="wallet-card">
                            <h6 class="fw-bold mb-3">Address Details</h6>

                            <p><b>Address:</b> {{ $student->address ?? 'N/A' }}</p>
                            <p><b>City:</b> {{ $student->city ?? 'N/A' }}</p>
                            <p><b>State:</b> {{ $student->state ?? 'Kerala' }}</p>
                            <p><b>Country:</b> {{ $student->country ?? 'India' }}</p>
                            <p><b>Pincode:</b> {{ $student->postal_code ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <!-- PROFESSIONAL SNAPSHOT -->
                    <div class="col-md-6">
                        <div class="wallet-card">
                            <h6 class="fw-bold mb-3">Professional Snapshot</h6>

                            <p><b>Qualification:</b> {{ $student->qualifications ?? 'N/A' }}</p>
                            <p><b>Experience:</b>
                                <span>Offline :{{ $student->professionalInfo->offline_exp ?? 0 }} Years</span>,
                                <span>Online :{{ $student->professionalInfo->online_exp ?? 0 }} Years</span>,
                                <span>Home :{{ $student->professionalInfo->home_exp ?? 0 }} Years</span>
                            </p>
                            <p><b>Profession:</b> {{ $student->professionalInfo->profession ?? 'N/A' }}</p>
                            <p><b>Ready to Work:</b> {{ $student->ready_to_work ?? 'N/A' }}</p>
                            <p><b>Teaching Mode:</b>
                                <span class="badge bg-info text-dark">
                                    {{ ucfirst($student->professionalInfo->teaching_mode ?? 'Online') }}
                                </span>
                            </p>
                            <p><b>Price Per Hour:</b> ₹{{ number_format($student->price_per_hour ?? 0) }}</p>
                        </div>
                    </div>

                </div>

            </div>

            <!-- ================= Academics ================= -->
            <div class="tab-pane fade" id="academics">
                <div class="mb-5">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Course</th>
                                    <th>Type</th>
                                    <th>Teachers</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Grand Total</th>
                                    <th>Classes</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses ?? [] as $course)
                                    <tr>
                                        <td>
                                            <b>{{ $course->title }}</b><br>
                                            <small class="text-muted">{{ $course->subject }}</small>
                                            <br>
                                            <small>
                                                Joined Date : {{ formatDateTime($course->joined_date) }}<br>
                                                Start
                                                :{{ formatDateTime($course->start_date) }}</small><br>
                                            <small>End :{{ formatDateTime($course->end_date) }}</small>
                                        </td>

                                        <td class="text-start">
                                            <span class="badge text-left mb-1 bg-success text-light">
                                                {!! $course->type !!}
                                            </span><br>
                                            <small>
                                                {{ $course->is_renewable ? 'Renewable' : 'One Time' }}
                                            </small>
                                        </td>

                                        <td>{{ $course->teachers ?? 'N/A' }}</td>

                                        <td>₹{{ number_format($course->price) }}</td>

                                        <td>
                                            ₹{{ number_format($course->discount) }}
                                        </td>
                                        <td class="text-success fw-bold">₹{{ number_format($course->grand_total) }}</td>
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
            </div>

            <!-- ================= PERFORMANCE ================= -->
            <div class="tab-pane fade" id="performance">
                <!-- 🔥 TOP KPIs -->
                <div class="row g-4 mb-5">

                    <div class="col-md-3">
                        <div class="metric-card success">
                            <p>Avg Activity</p>
                            <h3>{{ $performance->avg_activity }}</h3>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="metric-card info">
                            <p>Watch Time</p>
                            <h3>{{ $performance->watch_time }}</h3>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="metric-card warning">
                            <p>Spend Time</p>
                            <h3>{{ $performance->spend_time }}</h3>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="metric-card">
                            <p>Completion Rate</p>
                            <h3>{{ $performance->completion_rate }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="payments">

                <div class="mb-5">

                    <!-- 🔥 SUMMARY -->
                    <div class="row g-4 mb-3">

                        <div class="col-md-3">
                            <div class="metric-card success">
                                <p>Total Paid</p>
                                <h4 class="text-success">₹{{ number_format($paymentsSummary->total_paid) }}</h4>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="metric-card warning">
                                <p>Pending Payout</p>
                                <h4 class="text-warning">₹{{ number_format($paymentsSummary->pending) }}</h4>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="metric-card success">
                                <p>Failed Payments</p>
                                <h4 class="text-danger">₹{{ number_format($paymentsSummary->failed) }}</h4>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="metric-card info">
                                <p>Last Payout</p>
                                <h6>{{ $paymentsSummary->last_payout_date }}</h6>
                            </div>
                        </div>

                    </div>


                    <!-- ================= TRANSACTIONS ================= -->
                    {{-- <div id="installments">

                            <div class="mb-4">
                                <h5 class="fw-bold">Collect Cash</h5>

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

                        </div> --}}
                    <div id="transactions">
                        <!-- 🔥 PAYMENT HISTORY -->
                        <div class="mb-3">
                            <h5 class="fw-bold">Payment Transactions</h5>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Txn ID</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Course</th>
                                        <th>Mode</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions ?? [] as $key => $transaction)
                                        <tr>
                                            <td
                                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                <span>#{{ $transaction->id }}</span>
                                            </td>

                                            <td
                                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                <span>{{ dateTimeFormat($transaction->created_at) }}</span>
                                            </td>
                                            <td
                                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                Price : <span>{{ $transaction->price }} </span><br>
                                                Discount : <span>{{ $transaction->discount_amount }} </span><br>
                                                Tax : <span>{{ $transaction->tax_percent }}%
                                                    {{ $transaction->grand_total }}</span><br>
                                                Grand Total : <span>{{ $transaction->grand_total }} </span>
                                            </td>

                                            <td
                                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                <span>{{ $transaction->course->title }} </span>

                                            </td>
                                            <td
                                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                Method : <span>{{ $transaction->payment_method }} </span><br>
                                                Source : <span>{{ $transaction->payment_source }} </span>
                                            </td>
                                            <td
                                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                                @if ($transaction->status == 'pending')
                                                    <span
                                                        class="bg-gradient-to-tl capitalize  from-slate-600 to-slate-300  px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">
                                                        Unpaid</span>
                                                @elseif($transaction->status == 'paid')
                                                    <span
                                                        class="bg-gradient-to-tl capitalize from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Paid</span>
                                                @elseif($transaction->status == 'rejected')
                                                    <span
                                                        class="bg-gradient-to-tl capitalize from-red-200 to-red-600 px-2.5 text-xs rounded-1.8 py-1.4 inline-block  text-center align-baseline font-bold  leading-none text-white">Rejected</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>

            <!-- ================= WALLET ================= -->
            <div class="tab-pane fade" id="wallet">

                <!-- 🔥 TOP SUMMARY -->
                <div class="row g-4 mb-3">

                    <div class="col-md-3">
                        <div class="metric-card success">
                            <p>Total Rupee Earnings</p>
                            <h4 class="text-success">₹{{ number_format($student->wallet_rupees_total_earning) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="metric-card success">
                            <p>Total Green Coin Earnings</p>
                            <h4 class="text-success">{{ $student->wallet_green_coin_total ?? 0 }}</h4>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="metric-card warning">
                            <p>Available Balance</p>
                            <h4 class="text-primary">₹{{ number_format($student->wallet?->balance) }}</h4>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="metric-card danger">
                            <p>Total Withdrawn</p>
                            <h4 class="text-danger">₹{{ number_format($student->wallet_rupees_withdrawn) }}</h4>
                        </div>
                    </div>

                </div>
                <div class="mb-3">
                    <h5 class="fw-bold">Wallet Transactions</h5>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Amount/Coin</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($walletHistories ?? [] as $key => $wallet)
                                <tr>
                                    <td
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        <span>{{ $wallet->title }}</span>
                                        <span>{{ $wallet->wallet_type }}</span>
                                    </td>

                                    <td
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        <span>{{ dateTimeFormat($wallet->created_at) }}</span>
                                    </td>
                                    <td
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        {{ $wallet->type }}
                                    </td>
                                    <td
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        {{ $wallet->amount }}
                                    </td>

                                    <td
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        <span>{{ $wallet->status }} </span>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>




            </div>


            <!-- ================= ACTIVITY ================= -->
            <div class="tab-pane fade" id="activity_log">

                <!-- 🔥 FILTER -->
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="fw-bold">Activity Timeline</h5>

                </div>

                <!-- 🔥 TIMELINE -->
                <div class="timeline-enterprise">


                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Date</th>
                                <th>Device</th>
                                <th>Platform</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $act)
                                <tr>
                                    <td
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        <span>{{ $act->action }}</span>
                                    </td>

                                    <td
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        <span>{{ dateTimeFormat($act->created_at) }}</span>
                                    </td>
                                    <td
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        {{ $act->device }}
                                    </td>
                                    <td
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        {{ $act->platform }}
                                    </td>

                                    <td
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        <span>{{ $act->ip_address }} </span>

                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center text-muted py-4">
                                    <td colspan="5">
                                        No activity found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>


                </div>

            </div>


            <div class="tab-pane fade" id="reviews">

                <!-- 🔥 REVIEWS LIST -->
                <div class="mt-3">
                    <h5 class="fw-bold mb-3">Reviews</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Comments</th>
                                <th>Rating</th>
                                <th>Created at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviews as $review)
                                <tr>
                                    <td
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        <span>{{ $review->course?->title }}</span>
                                    </td>

                                    <td
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        <span>{{ $review->comments }} </span>
                                    </td>
                                    <td
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        {{ $review->rating }}
                                    </td>
                                    <td
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                                        <span>{{ dateTimeFormat($review->created_at) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center text-muted py-4">
                                    <td colspan="5">
                                        No Reviews found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>



            <!-- ================= SECURITY ================= -->
            <div class="tab-pane fade" id="security">

                <div class="d-flex justify-content-between mb-3">
                    <h5 class="fw-bold">Login Activity</h5>
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



        </div>

    </div>
@endsection
