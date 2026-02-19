@extends('layouts.layout')
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

@section('content')
    <div class="enterprise-student mt-4">

        <!-- ================= HEADER ================= -->
        <div class="student-header-premium">

            <div class="d-flex justify-content-between flex-wrap">

                <div class="d-flex align-items-center gap-4">
                    <img src="https://i.pravatar.cc/150" class="avatar-xl">

                    <div>
                        <h3 class="fw-bold mb-1">Rahul Sharma</h3>
                        <p class="text-muted mb-1">ID: STU-10241</p>

                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge bg-success">Active</span>
                            <span class="badge bg-primary">Grade 10 - CBSE</span>
                            <span class="badge bg-warning text-dark">VIP Student</span>
                            <span class="badge bg-danger">Low Engagement</span>
                        </div>
                    </div>
                </div>

                <div class="admin-actions">
                    <button class="btn btn-outline-primary">Message</button>
                    <button class="btn btn-outline-warning">Adjust Wallet</button>
                    <button class="btn btn-danger">Block</button>
                </div>

            </div>

            <!-- AI Insight -->
            <div class="ai-box mt-4">
                <h6 class="fw-bold">AI Insights</h6>
                <div class="row g-3">
                    <div class="col-md-3"><b>Engagement Score:</b> 62%</div>
                    <div class="col-md-3"><b>Drop Risk:</b> Medium</div>
                    <div class="col-md-3"><b>Learning Style:</b> Video-first</div>
                    <div class="col-md-3 text-primary"><b>Suggestion:</b> Send reminder</div>
                </div>
            </div>
        </div>

        <!-- ================= TABS ================= -->
        <ul class="nav nav-tabs enterprise-tabs mt-4 border-bottom" id="studentTabs">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab"
                    data-bs-target="#overview">Overview</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab"
                    data-bs-target="#academics">Academics</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab"
                    data-bs-target="#analytics">Analytics</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#wallet">Wallet</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#payments">Payments</button>
            </li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#activity">Activity Log</button>
            </li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#security">Login Devices</button>
            </li>
        </ul>

        <div class="tab-content mt-4">

            <!-- ================= OVERVIEW ================= -->
            <div class="tab-pane fade show active" id="overview">
                <div class="row g-4">

                    <div class="col-lg-3">
                        <div class="metric-card">
                            <p>Total Watch Time</p>
                            <h3>240 hrs</h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="metric-card success">
                            <p>Total Spend Time</p>
                            <h3>180 hrs</h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="metric-card warning">
                            <p>Wallet Balance</p>
                            <h3>₹1,240</h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="metric-card info">
                            <p>Courses Enrolled</p>
                            <h3>12</h3>
                        </div>
                    </div>

                </div>
            </div>

             <!-- ================= Academics ================= -->
            <div class="tab-pane fade" id="academics">
                <div class="row g-4">
                    <h4>No Data Found</h4>
                </div>
            </div>



            <!-- ================= ANALYTICS ================= -->
            <div class="tab-pane fade" id="analytics">

                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="chart-card">
                            <h6>Watch Time Trend</h6>
                            <div id="watchChart"></div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="chart-card">
                            <h6>Spend Time Trend</h6>
                            <div id="spendChart"></div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="chart-card">
                            <h6>Subjects Distribution</h6>
                            <div id="subjectChart"></div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="chart-card">
                            <h6>Monthly Payments</h6>
                            <div id="paymentChart"></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ================= WALLET ================= -->
            <div class="tab-pane fade" id="wallet">
                <div class="row g-4">

                    <div class="col-md-4">
                        <div class="wallet-card">
                            <p>Total Earned</p>
                            <h4>₹5,200</h4>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="wallet-card">
                            <p>Referral Earnings</p>
                            <h4>₹1,200</h4>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="wallet-card danger">
                            <p>Withdrawals</p>
                            <h4>₹3,000</h4>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ================= ACTIVITY ================= -->
            <div class="tab-pane fade" id="activity">
                <div class="timeline-enterprise">
                    <div class="timeline-item">Logged in from mobile - Today</div>
                    <div class="timeline-item">Completed Science Class</div>
                    <div class="timeline-item">Referred a friend</div>
                    <div class="timeline-item">Wallet withdrawal requested</div>
                </div>
            </div>

            <!-- ================= SECURITY ================= -->
            <div class="tab-pane fade" id="security">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>IP</th>
                            <th>Device</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>19 Feb 2026</td>
                            <td>103.xxx.xxx</td>
                            <td>Android</td>
                            <td><span class="badge bg-success">Safe</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
