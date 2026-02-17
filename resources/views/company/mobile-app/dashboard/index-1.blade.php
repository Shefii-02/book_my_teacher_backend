@extends('layouts.mobile-layout')

@section('content')
    <style>
        .premium-dashboard {
            font-family: Inter, sans-serif;
        }

        /* Card */
        .premium-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .premium-card:hover {
            transform: translateY(-3px);
        }

        /* Gradient Button */
        .btn-gradient {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            color: #fff;
            border-radius: 10px;
            padding: 8px 16px;
        }

        /* Stat Cards */
        .stat-card {
            color: #fff;
        }

        .stat-blue {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
        }

        .stat-green {
            background: linear-gradient(135deg, #10b981, #34d399);
        }

        .stat-purple {
            background: linear-gradient(135deg, #8b5cf6, #a78bfa);
        }

        .stat-orange {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
        }

        .icon-circle {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Avatar */
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        /* Timeline */
        .timeline {
            list-style: none;
            padding-left: 0;
        }

        .timeline li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 15px;
        }

        .timeline .dot {
            position: absolute;
            left: 0;
            top: 5px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        /* Alerts */
        .soft-alert {
            border: none;
            border-radius: 12px;
        }

        /* Chart placeholder */
        .chart-placeholder {
            height: 220px;
            background: repeating-linear-gradient(45deg,
                    #f3f4f6,
                    #f3f4f6 10px,
                    #e5e7eb 10px,
                    #e5e7eb 20px);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

    <div class="container-fluid py-4 premium-dashboard">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Dashboard Overview</h3>
                <p class="text-muted mb-0">Welcome back 👋 Manage everything from here</p>
            </div>

            <div>
                <button class="btn btn-gradient">+ Quick Action</button>
            </div>
        </div>

        <!-- STATS ROW -->
        <div class="row g-4 mb-4">

            @foreach ([['title' => 'Total Users', 'value' => '12,540', 'icon' => 'ri-user-3-line', 'color' => 'blue'], ['title' => 'Active Classes', 'value' => '84', 'icon' => 'ri-live-line', 'color' => 'green'], ['title' => 'Revenue', 'value' => '₹4.2L', 'icon' => 'ri-money-rupee-circle-line', 'color' => 'purple'], ['title' => 'Watch Time', 'value' => '1,240 hrs', 'icon' => 'ri-time-line', 'color' => 'orange']] as $stat)
                <div class="col-lg-3 col-md-6">
                    <div class="premium-card stat-card stat-{{ $stat['color'] }}">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted small mb-1">{{ $stat['title'] }}</p>
                                <h4 class="fw-bold mb-0">{{ $stat['value'] }}</h4>
                            </div>
                            <div class="icon-circle">
                                <i class="{{ $stat['icon'] }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- CHART + LEADERBOARD -->
        <div class="row g-4 mb-4">

            <!-- Revenue Chart -->
            <div class="col-lg-8">
                <div class="premium-card">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="fw-bold mb-0">Revenue Analytics</h5>
                        <span class="badge bg-light text-dark">Last 7 days</span>
                    </div>

                    <div class="chart-placeholder">
                        📊 Chart goes here
                    </div>
                </div>
            </div>

            <!-- Leaderboard -->
            <div class="col-lg-4">
                <div class="premium-card">
                    <h5 class="fw-bold mb-3">Top Teachers</h5>

                    @for ($i = 1; $i <= 5; $i++)
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <img src="https://i.pravatar.cc/40?img={{ $i }}" class="avatar me-2">
                                <div>
                                    <div class="fw-semibold">Teacher {{ $i }}</div>
                                    <small class="text-muted">4.9 ⭐ rating</small>
                                </div>
                            </div>
                            <span class="badge bg-success-soft">Top</span>
                        </div>
                    @endfor
                </div>
            </div>

        </div>

        <!-- ACTIVITY + ALERTS -->
        <div class="row g-4">

            <!-- Activity Timeline -->
            <div class="col-lg-6">
                <div class="premium-card">
                    <h5 class="fw-bold mb-3">Recent Activity</h5>

                    <ul class="timeline">
                        <li>
                            <span class="dot bg-success"></span>
                            New teacher joined platform
                            <small class="text-muted d-block">2 mins ago</small>
                        </li>
                        <li>
                            <span class="dot bg-primary"></span>
                            New course published
                            <small class="text-muted d-block">15 mins ago</small>
                        </li>
                        <li>
                            <span class="dot bg-warning"></span>
                            Withdrawal request pending
                            <small class="text-muted d-block">1 hour ago</small>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Alerts Panel -->
            <div class="col-lg-6">
                <div class="premium-card">
                    <h5 class="fw-bold mb-3">Priority Alerts</h5>

                    <div class="alert alert-warning soft-alert">
                        ⚠️ 5 withdrawal requests pending
                    </div>

                    <div class="alert alert-danger soft-alert">
                        🚨 2 reported reviews need attention
                    </div>

                    <div class="alert alert-info soft-alert">
                        ℹ️ Webinar starting in 20 mins
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
