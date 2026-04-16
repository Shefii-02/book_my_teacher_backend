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
            background: #fff;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .tab-content {
            margin-top: 20px;
        }
    </style>
@endpush

@php
    // ================= STUDENT =================


    // ================= OVERVIEW =================
    $overview = (object) [
        'courses' => 8,
        'completed' => 5,
        'pending' => 3,
        'certificates' => 4,

        'watch_time' => 120,
        'daily_avg' => 2,
        'last_active' => '2 hours ago',

        'total_spent' => 15000,
        'last_payment' => '10 Apr 2026',
        'payment_mode' => 'UPI',

        'score' => 85,
        'assignments' => 40,
        'tests' => 20,

        'attendance' => 90,
        'attended' => 90,
        'missed' => 10,

        'referrals' => 5,
        'referral_bonus' => 1000,

        'avg_rating' => 4.5,
    ];

    // ================= COURSES =================
    $courses = [
        (object) [
            'name' => 'Mathematics',
            'teacher' => 'John Sir',
            'progress' => 80,
            'status' => 'Active',
            'start_date' => '01 Mar 2026',
        ],
        (object) [
            'name' => 'Physics',
            'teacher' => 'Anil Sir',
            'progress' => 60,
            'status' => 'Active',
            'start_date' => '15 Feb 2026',
        ],
        (object) [
            'name' => 'Chemistry',
            'teacher' => 'Meera Ma’am',
            'progress' => 100,
            'status' => 'Completed',
            'start_date' => '01 Jan 2026',
        ],
    ];

    // ================= ACTIVITY =================
    $activities = [
        'Completed Lesson 5 in Mathematics',
        'Paid ₹2000 for Physics course',
        'Joined Chemistry course',
        'Earned certificate in Chemistry',
        'Referred a friend',
    ];

    $wallet = (object) [
        'balance' => 1200,
        'credited' => 5000,
        'debited' => 3800,
    ];

    $transactions = [
        (object) ['date' => '10 Apr', 'type' => 'Add', 'amount' => 2000, 'status' => 'Success'],
        (object) ['date' => '08 Apr', 'type' => 'Purchase', 'amount' => 1500, 'status' => 'Success'],
    ];

    $reviewStats = (object) [
        'avg' => 4.5,
        'total' => 12,
    ];

    $reviews = [
        (object) [
            'course' => 'Math',
            'rating' => 5,
            'comment' => 'Great course!',
            'date' => '10 Apr',
        ],
    ];

    $devices = [
        (object) [
            'date' => 'Today',
            'ip' => '103.xxx',
            'device' => 'Android',
            'location' => 'Kerala',
            'status' => 'safe',
        ],
    ];
@endphp
@section('content')
    <div class="container mt-4">

        <!-- ================= HEADER ================= -->
        <div class="student-header-premium mb-3">
            <div class="d-flex justify-content-between flex-wrap">

                <div class="d-flex gap-3">
                    <img src="{{ $student->avatar }}" class="avatar-xl">

                    <div>
                        <h4 class="fw-bold mb-1">{{ $student->name }}</h4>
                        <small>ID: {{ $student->referral_code }}</small><br>
                        <small>{{ $student->email }} | {{ $student->mobile }}</small>

                        <div class="mt-2">
                            🎓 {{ $overview->courses }} |
                            ⭐ {{ $overview->avg_rating }} |
                            ⏱ {{ $overview->watch_time }} hrs
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
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#courses">Courses</button>
            </li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#learning">Learning</button>
            </li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab"
                    data-bs-target="#performance">Performance</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#payments">Payments</button>
            </li>

            <!-- NEW -->
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#personal">Personal
                    Info</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#wallet">Wallet</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews">Reviews</button>
            </li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#devices">Login
                    Devices</button></li>

            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#activity">Activity</button>
            </li>
        </ul>

        <div class="tab-content">

            <!-- ================= OVERVIEW ================= -->
            <div class="tab-pane fade show active" id="overview">

                <div class="row g-3">

                    <div class="col-md-3">
                        <div class="metric-card">Courses<br><b>{{ $overview->courses }}</b></div>
                    </div>
                    <div class="col-md-3">
                        <div class="metric-card text-success">Completed<br><b>{{ $overview->completed }}</b></div>
                    </div>
                    <div class="col-md-3">
                        <div class="metric-card text-warning">Pending<br><b>{{ $overview->pending }}</b></div>
                    </div>
                    <div class="col-md-3">
                        <div class="metric-card text-info">Certificates<br><b>{{ $overview->certificates }}</b></div>
                    </div>

                </div>

                <div class="row mt-3 g-3">
                    <div class="col-md-6">
                        <div class="card p-3">
                            <h6>Quick Info</h6>
                            <p>Last Active: {{ $overview->last_active }}</p>
                            <p>Avg Study: {{ $overview->daily_avg }} hrs</p>
                            <p>Attendance: {{ $overview->attendance }}%</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card p-3">
                            <h6>Financial</h6>
                            <p>Total Spent: ₹{{ $overview->total_spent }}</p>
                            <p>Referral Earned: ₹{{ $overview->referral_bonus }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="tab-pane fade" id="personal">
                <div class="card p-3">
                    <h5>Personal Information</h5>

                    <p><b>Name:</b> {{ $student->name }}</p>
                    <p><b>Email:</b> {{ $student->email }}</p>
                    <p><b>Mobile:</b> {{ $student->mobile }}</p>

                    <hr>

                    <p><b>Date of Birth:</b> {{ $student->dob ?? 'N/A' }}</p>
                    <p><b>Gender:</b> {{ $student->gender ?? 'N/A' }}</p>
                    <p><b>Address:</b> {{ $student->address ?? 'N/A' }}</p>
                    <p><b>City:</b> {{ $student->city ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="tab-pane fade" id="wallet">

                <div class="row g-3">

                    <div class="col-md-4">
                        <div class="metric-card">
                            Balance<br><b>₹{{ $wallet->balance }}</b>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="metric-card success">
                            Total Added<br><b>₹{{ $wallet->credited }}</b>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="metric-card warning">
                            Total Spent<br><b>₹{{ $wallet->debited }}</b>
                        </div>
                    </div>

                </div>

                <div class="card mt-3">
                    <div class="card-header">Transactions</div>
                    <div class="card-body table-responsive">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($transactions as $t)
                                    <tr>
                                        <td>{{ $t->date }}</td>
                                        <td>{{ $t->type }}</td>
                                        <td>₹{{ $t->amount }}</td>
                                        <td><span class="badge bg-success">{{ $t->status }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="reviews">

                <div class="card p-3 mb-3">
                    <h5>Review Summary</h5>
                    <p>Average Rating: ⭐ {{ $reviewStats->avg }}</p>
                    <p>Total Reviews: {{ $reviewStats->total }}</p>
                </div>

                @foreach ($reviews as $r)
                    <div class="card p-3 mb-2">
                        <div class="d-flex justify-content-between">
                            <b>{{ $r->course }}</b>
                            ⭐ {{ $r->rating }}
                        </div>
                        <p>{{ $r->comment }}</p>
                        <small>{{ $r->date }}</small>
                    </div>
                @endforeach

            </div>
            <div class="tab-pane fade" id="devices">

                <div class="card">
                    <div class="card-header">Login Devices</div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>IP</th>
                                    <th>Device</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($devices as $d)
                                    <tr>
                                        <td>{{ $d->date }}</td>
                                        <td>{{ $d->ip }}</td>
                                        <td>{{ $d->device }}</td>
                                        <td>{{ $d->location }}</td>
                                        <td>
                                            <span class="badge {{ $d->status == 'safe' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($d->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
            <!-- ================= COURSES ================= -->
            <div class="tab-pane fade" id="courses">

                <div class="card">
                    <div class="card-body table-responsive">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Teacher</th>
                                    <th>Progress</th>
                                    <th>Status</th>
                                    <th>Start</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($courses as $c)
                                    <tr>
                                        <td>{{ $c->name }}</td>
                                        <td>{{ $c->teacher }}</td>
                                        <td>{{ $c->progress }}%</td>
                                        <td><span class="badge bg-success">{{ $c->status }}</span></td>
                                        <td>{{ $c->start_date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>
                </div>

            </div>

            <!-- ================= LEARNING ================= -->
            <div class="tab-pane fade" id="learning">

                <div class="row g-3">

                    <div class="col-md-4">
                        <div class="metric-card">Watch Time<br><b>{{ $overview->watch_time }} hrs</b></div>
                    </div>
                    <div class="col-md-4">
                        <div class="metric-card">Daily Avg<br><b>{{ $overview->daily_avg }} hrs</b></div>
                    </div>
                    <div class="col-md-4">
                        <div class="metric-card">Last Active<br><b>{{ $overview->last_active }}</b></div>
                    </div>

                </div>

            </div>

            <!-- ================= PERFORMANCE ================= -->
            <div class="tab-pane fade" id="performance">

                <div class="row g-3">

                    <div class="col-md-4">
                        <div class="metric-card">Score<br><b>{{ $overview->score }}%</b></div>
                    </div>
                    <div class="col-md-4">
                        <div class="metric-card">Assignments<br><b>{{ $overview->assignments }}</b></div>
                    </div>
                    <div class="col-md-4">
                        <div class="metric-card">Tests<br><b>{{ $overview->tests }}</b></div>
                    </div>

                </div>

            </div>

            <!-- ================= PAYMENTS ================= -->
            <div class="tab-pane fade" id="payments">

                <div class="card p-3">
                    <p>Total Spent: ₹{{ $overview->total_spent }}</p>
                    <p>Last Payment: {{ $overview->last_payment }}</p>
                    <p>Mode: {{ $overview->payment_mode }}</p>
                </div>

            </div>

            <!-- ================= ACTIVITY ================= -->
            <div class="tab-pane fade" id="activity">

                <div class="timeline-enterprise">
                    @foreach ($activities as $act)
                        <div class="timeline-item">{{ $act }}</div>
                    @endforeach
                </div>

            </div>

        </div>

    </div>
@endsection
