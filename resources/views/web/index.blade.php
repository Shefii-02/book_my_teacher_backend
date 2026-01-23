<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BookMyTeacher::Home</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --brand: #4CAF50;
            --brand2: #6ec172;
            --dark: #0f172a;
            --muted: #64748b;
            --card: rgba(255, 255, 255, 0.75);
            --border: rgba(15, 23, 42, 0.08);
        }

        body {
            font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial, "Helvetica Neue", sans-serif;
            color: var(--dark);
            background: #f6f8ff;
        }

        /* Navbar */
        .navbar {
            transition: all .25s ease;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.92) !important;
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        .nav-link {
            color: var(--dark) !important;
            opacity: .85;
            font-weight: 600;
        }

        .nav-link.active,
        .nav-link:hover {
            opacity: 1;
            color: var(--brand) !important;
        }

        /* Hero */
        .hero {
            position: relative;
            overflow: hidden;
            padding: 110px 0 80px;
            background: radial-gradient(1100px 500px at 10% 10%, rgba(45, 108, 255, 0.22), transparent 60%),
                radial-gradient(900px 450px at 90% 25%, rgba(124, 58, 237, 0.18), transparent 55%),
                linear-gradient(180deg, #ffffff, #f6f8ff);
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(45, 108, 255, 0.10);
            color: var(--brand);
            border: 1px solid rgba(45, 108, 255, 0.20);
            padding: 8px 12px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 14px;
        }

        .hero h1 {
            font-size: clamp(32px, 4vw, 52px);
            line-height: 1.1;
            letter-spacing: -0.02em;
        }

        .hero p {
            color: var(--muted);
            font-size: 18px;
            line-height: 1.7;
        }

        .btn-brand {
            background: linear-gradient(135deg, var(--brand), var(--brand2));
            border: none;
            color: #fff;
            font-weight: 700;
            padding: 12px 18px;
            border-radius: 14px;
            box-shadow: 0 12px 30px rgba(45, 108, 255, 0.25);
        }

        .btn-brand:hover {
            opacity: .95;
            transform: translateY(-1px);
        }

        .btn-outline-brand {
            border: 1px solid rgba(45, 108, 255, 0.35);
            color: var(--brand);
            font-weight: 700;
            padding: 12px 18px;
            border-radius: 14px;
            background: #fff;
        }

        .btn-outline-brand:hover {
            border-color: var(--brand);
            color: var(--brand);
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
        }

        .hero-card {
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 18px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.06);
        }

        .mini-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.04);
            border: 1px solid rgba(15, 23, 42, 0.06);
            font-weight: 700;
            font-size: 13px;
            color: var(--dark);
        }

        .mini-pill i {
            color: var(--brand);
        }

        .floating-shape {
            position: absolute;
            inset: auto auto -120px -120px;
            width: 260px;
            height: 260px;
            border-radius: 60px;
            background: linear-gradient(135deg, rgb(22 214 29), rgba(124, 58, 237, 0.20));
            filter: blur(0px);
            transform: rotate(18deg);
            opacity: .9;
        }

        .floating-shape.two {
            inset: -140px -140px auto auto;
            width: 300px;
            height: 300px;
            border-radius: 80px;
            transform: rotate(-12deg);
            opacity: .7;
        }

        /* Sections */
        section {
            padding: 80px 0;
        }

        .section-title small {
            color: var(--brand);
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .section-title h2 {
            font-size: clamp(26px, 3vw, 40px);
            letter-spacing: -0.02em;
            margin-top: 6px;
        }

        .section-title p {
            color: var(--muted);
            max-width: 720px;
            margin: 14px auto 0;
            line-height: 1.7;
        }

        /* Stats */
        .stat-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.05);
        }

        .stat-value {
            font-size: 34px;
            font-weight: 900;
            letter-spacing: -0.02em;
        }

        .stat-label {
            color: var(--muted);
            font-weight: 700;
        }

        /* Feature Cards */
        .feature-card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 22px;
            height: 100%;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.05);
            transition: all .25s ease;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 22px 55px rgba(15, 23, 42, 0.08);
        }

        .feature-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(45, 108, 255, 0.12);
            color: var(--brand);
            font-size: 22px;
            margin-bottom: 12px;
        }

        .feature-card h5 {
            font-weight: 900;
            margin-bottom: 8px;
        }

        .feature-card p {
            color: var(--muted);
            margin-bottom: 0;
            line-height: 1.6;
        }

        /* Persona cards */
        .persona-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 18px;
            transition: all .25s ease;
            cursor: pointer;
            height: 100%;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
        }

        .persona-card:hover {
            transform: translateY(-3px);
            border-color: rgba(45, 108, 255, 0.35);
        }

        .persona-card.active {
            outline: 2px solid rgba(45, 108, 255, 0.45);
            box-shadow: 0 22px 55px rgba(45, 108, 255, 0.12);
        }

        .persona-card h6 {
            font-weight: 900;
            margin: 0;
        }

        .persona-card p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        /* CTA */
        .cta {
            background: linear-gradient(135deg, rgba(45, 108, 255, 0.14), rgba(124, 58, 237, 0.14));
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 28px;
            padding: 42px 26px;
        }

        /* Footer */
        footer {
            padding: 35px 0;
            color: var(--muted);
        }

        .glass {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(15, 23, 42, 0.06);
        }
    </style>

    <style>
        /* Pricing */
        .pricing-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid var(--border);
            border-radius: 26px;
            padding: 28px;
            height: 100%;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .06);
            transition: all .25s ease;
            position: relative;
        }

        .pricing-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 26px 65px rgba(15, 23, 42, .1);
        }

        .pricing-badge {
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, var(--brand), var(--brand2));
            color: #fff;
            font-weight: 800;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
        }

        .price-old {
            text-decoration: line-through;
            color: #94a3b8;
            font-weight: 700;
        }

        .price-new {
            font-size: 36px;
            font-weight: 900;
        }

        .pricing-list li {
            margin-bottom: 10px;
            font-weight: 600;
        }

        .pricing-list i {
            color: var(--brand);
        }

        /* FAQ */
        .faq-card {
            background: rgba(255, 255, 255, .9);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 18px;
            box-shadow: 0 14px 35px rgba(15, 23, 42, .05);
        }

        /* Growth Image */
        .growth-box {
            background: linear-gradient(135deg, rgba(45, 108, 255, .12), rgba(124, 58, 237, .12));
            border-radius: 30px;
            padding: 40px;
            border: 1px solid var(--border);
        }

        /* =========================
   ADDON SECTIONS CSS
========================= */

        /* Top Offer Bar */
        .offer-topbar {
            background: linear-gradient(135deg, rgba(45, 108, 255, .12), rgba(124, 58, 237, .12));
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        }

        .offer-topbar .badge {
            background: linear-gradient(135deg, var(--brand), var(--brand2));
        }

        /* Trusted Logos */
        .trusted-strip {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 22px;
            padding: 18px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, .05);
        }

        .logo-pill {
            background: rgba(15, 23, 42, 0.03);
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 999px;
            padding: 10px 14px;
            font-weight: 800;
            color: var(--dark);
            display: inline-flex;
            gap: 10px;
            align-items: center;
            white-space: nowrap;
        }

        .logo-pill i {
            color: var(--brand);
        }

        /* How it works */
        .step-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 24px;
            padding: 22px;
            height: 100%;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .06);
            transition: all .25s ease;
        }

        .step-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 26px 65px rgba(15, 23, 42, .10);
        }

        .step-no {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: #fff;
            background: linear-gradient(135deg, var(--brand), var(--brand2));
            box-shadow: 0 14px 30px rgba(45, 108, 255, .25);
        }

        .step-card p {
            color: var(--muted);
            margin-bottom: 0;
            line-height: 1.65;
        }

        /* App Screenshots / Mockup */
        .mockup-wrap {
            background: rgba(255, 255, 255, 0.65);
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 30px;
            padding: 26px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .06);
        }

        .phone-mock {
            width: 290px;
            max-width: 100%;
            border-radius: 34px;
            border: 8px solid rgba(15, 23, 42, 0.85);
            box-shadow: 0 26px 70px rgba(15, 23, 42, .18);
            overflow: hidden;
            background: #000;
        }

        .phone-topbar {
            height: 22px;
            background: rgba(255, 255, 255, 0.06);
        }

        .mock-thumbs .thumb-btn {
            border: 1px solid rgba(15, 23, 42, 0.08);
            background: #fff;
            border-radius: 18px;
            padding: 14px;
            width: 100%;
            text-align: left;
            font-weight: 800;
            transition: all .2s ease;
        }

        .mock-thumbs .thumb-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(15, 23, 42, .08);
        }

        .mock-thumbs .thumb-btn.active {
            border-color: rgba(45, 108, 255, 0.35);
            outline: 2px solid rgba(45, 108, 255, 0.25);
        }

        .mock-thumbs small {
            color: var(--muted);
            font-weight: 600;
        }

        /* Comparison Table */
        .compare-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 26px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .06);
            overflow: hidden;
        }

        .compare-head {
            padding: 18px 22px;
            background: linear-gradient(135deg, rgba(45, 108, 255, .10), rgba(124, 58, 237, .10));
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        }

        .compare-table th,
        .compare-table td {
            vertical-align: middle;
            padding: 14px 16px;
        }

        .badge-yes {
            background: rgba(34, 197, 94, 0.12);
            color: #16a34a;
            border: 1px solid rgba(34, 197, 94, 0.25);
            font-weight: 900;
        }

        .badge-no {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.25);
            font-weight: 900;
        }

        .badge-best {
            background: linear-gradient(135deg, var(--brand), var(--brand2));
            color: #fff;
            font-weight: 900;
        }

        /* Footer */
        .footer-pro {
            background: #0b1222;
            color: rgba(255, 255, 255, 0.85);
        }

        .footer-pro a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
        }

        .footer-pro a:hover {
            color: #095524;
        }

        .footer-card {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.10);
            border-radius: 20px;
            padding: 18px;
        }

        .footer-title {
            font-weight: 900;
            color: #fff;
        }

        /* WhatsApp Floating Button */
        .whatsapp-float {
            position: fixed;
            right: 18px;
            bottom: 18px;
            z-index: 9999;
            width: 58px;
            height: 58px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #25D366;
            color: #fff;
            box-shadow: 0 18px 45px rgba(0, 0, 0, .25);
            border: 2px solid rgba(255, 255, 255, 0.25);
            transition: transform .2s ease;
        }

        .whatsapp-float:hover {
            transform: translateY(-3px);
            color: #fff;
        }

        /* Offer Popup Modal */
        .offer-modal .modal-content {
            border-radius: 26px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .offer-modal-head {
            background: linear-gradient(135deg, rgba(45, 108, 255, .12), rgba(124, 58, 237, .12));
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top bg-transparent">
        <div class="container">
            <a class="navbar-brand fw-bold w-25" href="#">
                <img src="{{ asset('/assets/images/logo/BookMyTeacher-black.png') }}" class="w-75" />
                {{-- <span style="color:var(--brand)">Book</span><span style="color:var(--brand2)">MyTeacher</span> --}}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto gap-lg-2">
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#who">Who is it for?</a></li>
                    <li class="nav-item"><a class="nav-link" href="#stats">Stats</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>

                <div class="d-flex ms-lg-3 mt-3 mt-lg-0 gap-2">
                    <a class="btn btn-outline-brand" href="#contact">Book a Demo</a>
                    <a class="btn btn-outline-brand" href="{{ route('login') }}">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <header class="hero" id="top">
        <div class="floating-shape"></div>
        <div class="floating-shape two"></div>

        <div class="container position-relative">
            <div class="row align-items-center g-4">
                <div class="col-lg-6" data-aos="fade-up">
                    <span class="hero-badge">
                        <i class="bi bi-stars"></i> Launch your own branded teaching platform
                    </span>

                    <h1 class="mt-3 fw-black">
                        Build your online brand identity with
                        <span
                            style="background: linear-gradient(135deg,var(--brand),var(--brand2)); -webkit-background-clip:text; color:transparent;">
                            BookMyTeacher
                        </span>
                    </h1>

                    <p class="mt-3">
                        Get your own brand’s teaching app, create your own website & sell courses.
                        Manage students, run live classes, chat support, polls, and secure payments — all in one place.
                    </p>

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <a href="#contact" class="btn btn-brand">
                            <i class="bi bi-rocket-takeoff me-1"></i> Get Started Free
                        </a>
                        <a href="#features" class="btn btn-outline-brand">
                            <i class="bi bi-play-circle me-1"></i> See Features
                        </a>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <span class="mini-pill"><i class="bi bi-check-circle-fill"></i> Live + Recorded Classes</span>
                        <span class="mini-pill"><i class="bi bi-check-circle-fill"></i> Chat & Doubts</span>
                        <span class="mini-pill"><i class="bi bi-check-circle-fill"></i> Payments</span>
                        <span class="mini-pill"><i class="bi bi-check-circle-fill"></i> Reports</span>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="150">
                    <div class="hero-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <div class="fw-bold">Your Institute Dashboard</div>
                                <div class="text-muted small">Students • Batches • Courses</div>
                            </div>
                            <span class="badge text-bg-success rounded-pill">LIVE</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <div class="stat-card">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-people-fill fs-5 text-success"></i>
                                        <div>
                                            <div class="stat-value counter" data-target="5000">0</div>
                                            <div class="stat-label">Students</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="stat-card">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-camera-video-fill fs-5 text-success"></i>
                                        <div>
                                            <div class="stat-value counter" data-target="120">0</div>
                                            <div class="stat-label">Classes</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="stat-card">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="fw-bold">Today’s Session</div>
                                            <div class="text-muted small">English Speaking Challenge - Day 12</div>
                                        </div>
                                        <a href="https://wa.me/917510115544" class="btn btn-brand btn-sm">
                                            Request to Join Now <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="stat-card">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="fw-bold">Revenue</div>
                                            <div class="text-muted small">Auto tracking with payments</div>
                                        </div>
                                        <div class="fw-black fs-4 font-weight-bold">₹ 1,25,000</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-muted small text-center">
                                <i class="bi bi-shield-check me-1"></i> Secure login • Fast support • Easy setup
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Stats -->
    <section id="stats">
        <div class="container">
            <div class="row text-center g-3">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="stat-card">
                        <div class="stat-value"><span class="counter" data-target="3300">0</span>+</div>
                        <div class="stat-label">Cities</div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-card">
                        <div class="stat-value"><span class="counter" data-target="100000">0</span>+</div>
                        <div class="stat-label">Teachers</div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-card">
                        <div class="stat-value"><span class="counter" data-target="50000000">0</span>+</div>
                        <div class="stat-label">Students</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features">
        <div class="container">
            <div class="text-center section-title" data-aos="fade-up">
                <small>Features</small>
                <h2 class="fw-black">Everything you need to run your classes online</h2>
                <p>From live classes to payments, chat support and performance tracking — manage everything from one
                    simple dashboard.</p>
            </div>

            <div class="row g-4 mt-4">
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-phone"></i></div>
                        <h5>Branded App</h5>
                        <p>Your logo, your name, your identity — build your own teaching app like a premium institute.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-camera-video"></i></div>
                        <h5>Live + Recorded Classes</h5>
                        <p>Host live sessions and upload recordings so students can learn anytime.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-chat-dots"></i></div>
                        <h5>Chat + Doubt Support</h5>
                        <p>Instant messaging for students, parents and teachers — smooth communication built-in.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-journal-bookmark"></i></div>
                        <h5>Courses & Batches</h5>
                        <p>Create courses, schedule classes, manage batches and track attendance easily.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-credit-card"></i></div>
                        <h5>Secure Payments</h5>
                        <p>Collect fees with UPI/cards/netbanking and track payments automatically.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <h5>Reports & Analytics</h5>
                        <p>Student progress, test results and performance tracking in one dashboard.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Who is it for -->
    <section id="who">
        <div class="container">
            <div class="text-center section-title" data-aos="fade-up">
                <small>Choose Your Path</small>
                <h2 class="fw-black">Ready to take the first step?</h2>
                <p>Choose what best defines you. We’ll customize the setup for your goal.</p>
            </div>

            <div class="row g-4 mt-4">
                <div class="col-md-6 col-lg-3" data-aos="fade-up">
                    <div class="persona-card active" data-persona="coaching">
                        <h6><i class="bi bi-building me-2 text-success"></i>I run a coaching centre</h6>
                        <p>Manage students, batches, teachers, fee collection & performance tracking.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="persona-card" data-persona="youtuber">
                        <h6><i class="bi bi-youtube me-2 text-danger"></i>I am a YouTuber</h6>
                        <p>Convert followers to paid students and sell premium course content.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="persona-card" data-persona="school">
                        <h6><i class="bi bi-mortarboard me-2 text-success"></i>I teach in a school</h6>
                        <p>Take online classes, share notes and track student performance easily.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="persona-card" data-persona="student">
                        <h6><i class="bi bi-person-heart me-2 text-success"></i>I am a student</h6>
                        <p>Join live classes, access recordings and chat with teachers.</p>
                    </div>
                </div>
            </div>

            <div class="mt-4" data-aos="fade-up">
                <div class="cta glass">
                    <div class="row align-items-center g-3">
                        <div class="col-lg-8">
                            <h4 class="fw-black mb-1">Start your branded app + website today 🚀</h4>
                            <div class="text-muted">No technical knowledge required. Setup is fast & support is
                                available.</div>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <a href="#contact" class="btn btn-brand w-100 w-lg-auto">
                                Get Started Now <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <div class="offer-topbar py-2">
        <div class="container d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2 fw-semibold">
                <span class="badge rounded-pill px-3 py-2">
                    🎉 Limited Offer
                </span>
                <span class="text-dark">
                    New Year Offer – Save <b>₹5,000</b> if you pay today!
                </span>
            </div>
            <a href="#pricing" class="btn btn-sm btn-brand">
                View Pricing <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    <section id="trusted" class="pt-5">
        <div class="container" data-aos="fade-up">
            <div class="trusted-strip">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="fw-black">
                        Trusted by <span class="text-success">500+</span> institutes
                    </div>

                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        <span class="logo-pill"><i class="bi bi-patch-check-fill"></i>Bright Academy</span>
                        <span class="logo-pill"><i class="bi bi-patch-check-fill"></i>Smart Tuition</span>
                        <span class="logo-pill"><i class="bi bi-patch-check-fill"></i>EduPro Coaching</span>
                        <span class="logo-pill"><i class="bi bi-patch-check-fill"></i>NextGen Classes</span>
                        <span class="logo-pill"><i class="bi bi-patch-check-fill"></i>Success Hub</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="how-it-works">
        <div class="container">
            <div class="text-center section-title" data-aos="fade-up">
                <small>How it works</small>
                <h2 class="fw-black">Start in 3 simple steps</h2>
                <p>Launch your coaching business online in minutes.</p>
            </div>

            <div class="row g-4 mt-4">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="step-card">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="step-no">1</span>
                            <h5 class="fw-black mb-0">Create your institute</h5>
                        </div>
                        <p>Setup your brand name, logo and basic details to launch your own learning platform.</p>
                    </div>
                </div>

                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="step-card">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="step-no">2</span>
                            <h5 class="fw-black mb-0">Upload courses / start live</h5>
                        </div>
                        <p>Add recorded courses, schedule live classes, share notes and handle doubts smoothly.</p>
                    </div>
                </div>

                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="step-card">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="step-no">3</span>
                            <h5 class="fw-black mb-0">Sell & manage students</h5>
                        </div>
                        <p>Collect payments, manage enrollments and track performance using smart reports.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="pricing">
        <div class="container">
            <div class="text-center section-title" data-aos="fade-up">
                <small>Pricing</small>
                <h2 class="fw-black">Best pricing, designed for you</h2>
                <p>Simple, transparent plans that grow with your teaching business.</p>
            </div>

            <div class="row g-4 mt-4">

                <!-- 1 Year Plan -->
                <div class="col-lg-6" data-aos="fade-up">
                    <div class="pricing-card text-center">
                        <div class="pricing-badge">Most Popular</div>

                        <h4 class="fw-black mt-3">Standard Plan – 1 Year</h4>
                        <p class="text-muted">Recommended for educators & content creators</p>

                        <div class="my-3">
                            <span class="price-old">₹24,999/-</span>
                            <div class="price-new text-primary">₹5,999/-</div>
                        </div>

                        <ul class="list-unstyled pricing-list text-start mt-4">
                            <li><i class="bi bi-check-circle-fill me-2"></i>Android App</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>Website</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>Admin Portal</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>Unlimited Recorded Courses</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>Unlimited Live Classes</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>Unlimited Student Enrolments</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>Unlimited Storage</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>A.I. Powered Leads</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>And much more</li>
                        </ul>

                        <a href="{{ route('phonepe.checkout',5999) }}" class="btn btn-brand w-100 mt-3">Pay Now</a>
                    </div>
                </div>

                <!-- 2 Year Plan -->
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="150">
                    <div class="pricing-card text-center">
                        <h4 class="fw-black">Pro Plan – 2 Years</h4>
                        <p class="text-muted">Recommended for medium & large coaching centres</p>

                        <div class="my-3">
                            <span class="price-old">₹44,999/-</span>
                            <div class="price-new text-primary">₹10,999/-</div>
                        </div>

                        <ul class="list-unstyled pricing-list text-start mt-4">
                            <li><i class="bi bi-check-circle-fill me-2"></i>Android App</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>Website</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>Admin Portal</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>Unlimited Recorded Courses</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>Unlimited Live Classes</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>Unlimited Student Enrolments</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>Unlimited Storage</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>A.I. Powered Leads</li>
                            <li><i class="bi bi-check-circle-fill me-2"></i>And much more</li>
                        </ul>

                        <a href="#contact" class="btn btn-brand w-100 mt-3">Pay Now</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="app-screens">
        <div class="container">
            <div class="text-center section-title" data-aos="fade-up">
                <small>App Preview</small>
                <h2 class="fw-black">See how your app looks</h2>
                <p>Professional UI that builds trust & increases conversions.</p>
            </div>

            <div class="mockup-wrap mt-4" data-aos="fade-up" data-aos-delay="150">
                <div class="row align-items-center g-4">

                    <!-- Left: Mock Phone -->
                    <div class="col-lg-5 d-flex justify-content-center">
                        <div class="phone-mock">
                            <div class="phone-topbar"></div>
                            <img id="mockPreview" src="https://via.placeholder.com/500x900?text=Student+Home"
                                class="w-100" alt="App Mock Preview">
                        </div>
                    </div>

                    <!-- Right: Screen Buttons -->
                    <div class="col-lg-7">
                        <div class="row g-3 mock-thumbs justify-content-center">

                            <div class="col-md-6">
                                <button class="thumb-btn active"
                                    data-img="https://via.placeholder.com/500x900?text=Student+Home">
                                    <div class="fw-black"><i class="bi bi-house-door me-2 text-success"></i>Student
                                        Home</div>
                                    <small>Course list + upcoming classes</small>
                                </button>
                            </div>

                            <div class="col-md-6">
                                <button class="thumb-btn"
                                    data-img="https://via.placeholder.com/500x900?text=Live+Class">
                                    <div class="fw-black"><i class="bi bi-camera-video me-2 text-success"></i>Live
                                        Class</div>
                                    <small>Streaming + attendance + engagement</small>
                                </button>
                            </div>

                            <div class="col-md-6">
                                <button class="thumb-btn" data-img="https://via.placeholder.com/500x900?text=Chat">
                                    <div class="fw-black"><i class="bi bi-chat-dots me-2 text-success"></i>Chat</div>
                                    <small>Doubts + announcements + support</small>
                                </button>
                            </div>

                            <div class="col-md-6">
                                <button class="thumb-btn"
                                    data-img="https://via.placeholder.com/500x900?text=Payment+Page">
                                    <div class="fw-black"><i class="bi bi-credit-card me-2 text-success"></i>Payment
                                        Page</div>
                                    <small>UPI/cards + fee tracking</small>
                                </button>
                            </div>

                            <div class="col-md-6">
                                <button class="thumb-btn"
                                    data-img="https://via.placeholder.com/500x900?text=Dashboard">
                                    <div class="fw-black"><i
                                            class="bi bi-speedometer2 me-2 text-success"></i>Dashboard</div>
                                    <small>Reports + analytics + performance</small>
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button class="thumb-btn"
                                    data-img="https://via.placeholder.com/500x900?text=Dashboard">
                                    <div class="fw-black"><i
                                            class="bi bi-speedometer2 me-2 text-success"></i>Dashboard</div>
                                    <small>Reports + analytics + performance</small>
                                </button>
                            </div>

                            <div class="col-md-6">
                                <div class="step-card">
                                    <div class="d-flex gap-2 align-items-center mb-1">
                                        <i class="bi bi-shield-check text-success fs-5"></i>
                                        <div class="fw-black">Premium Experience</div>
                                    </div>
                                    <p class="mb-0">Fast UI, smooth navigation, and a professional look that boosts
                                        student trust.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="comparison">
        <div class="container">
            <div class="text-center section-title" data-aos="fade-up">
                <small>Why choose us</small>
                <h2 class="fw-black">Better than other providers</h2>
                <p>Strong points that make your institute more professional & scalable.</p>
            </div>

            <div class="compare-card mt-4" data-aos="fade-up" data-aos-delay="150">
                <div class="compare-head d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="fw-black">Feature Comparison</div>
                    <span class="badge badge-best rounded-pill px-3 py-2">
                        Your App = Full Control ✅
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0 compare-table">
                        <thead>
                            <tr>
                                <th style="min-width:240px;">Feature</th>
                                <th style="min-width:220px;">Other Providers</th>
                                <th style="min-width:220px;">Your App</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="fw-semibold">Your Own Brand Identity</td>
                                <td><span class="badge badge-no rounded-pill px-3 py-2">Limited</span></td>
                                <td><span class="badge badge-yes rounded-pill px-3 py-2">Full Branding</span></td>
                            </tr>

                            <tr>
                                <td class="fw-semibold">Unlimited Live Classes</td>
                                <td><span class="badge badge-no rounded-pill px-3 py-2">Extra Charges</span></td>
                                <td><span class="badge badge-yes rounded-pill px-3 py-2">Unlimited</span></td>
                            </tr>

                            <tr>
                                <td class="fw-semibold">Unlimited Storage</td>
                                <td><span class="badge badge-no rounded-pill px-3 py-2">Limited</span></td>
                                <td><span class="badge badge-yes rounded-pill px-3 py-2">Unlimited</span></td>
                            </tr>

                            <tr>
                                <td class="fw-semibold">AI Powered Leads</td>
                                <td><span class="badge badge-no rounded-pill px-3 py-2">Not Available</span></td>
                                <td><span class="badge badge-yes rounded-pill px-3 py-2">Included</span></td>
                            </tr>

                            <tr>
                                <td class="fw-semibold">Admin Portal + Reports</td>
                                <td><span class="badge badge-no rounded-pill px-3 py-2">Basic</span></td>
                                <td><span class="badge badge-yes rounded-pill px-3 py-2">Advanced</span></td>
                            </tr>

                            <tr>
                                <td class="fw-semibold">Payments & Auto Tracking</td>
                                <td><span class="badge badge-no rounded-pill px-3 py-2">Manual</span></td>
                                <td><span class="badge badge-yes rounded-pill px-3 py-2">Auto</span></td>
                            </tr>

                            <tr>
                                <td class="fw-semibold">Student Engagement Tools</td>
                                <td><span class="badge badge-no rounded-pill px-3 py-2">Limited</span></td>
                                <td><span class="badge badge-yes rounded-pill px-3 py-2">Chat + Poll + Support</span>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact">
        <div class="container">
            <div class="text-center section-title" data-aos="fade-up">
                <small>Contact</small>
                <h2 class="fw-black">Get a free demo & launch your app</h2>
                <p>Fill your details and our team will contact you shortly.</p>
            </div>

            <div class="row justify-content-center mt-4">
                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="150">
                    <div class="hero-card">
                        <form id="leadForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Your Name</label>
                                    <input type="text" class="form-control form-control-lg"
                                        placeholder="Enter your name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Phone Number</label>
                                    <input type="tel" class="form-control form-control-lg"
                                        placeholder="+91 98765 43210" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control form-control-lg"
                                        placeholder="you@example.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">You are a</label>
                                    <select class="form-select form-select-lg" required>
                                        <option value="">Select</option>
                                        <option>Coaching Centre</option>
                                        <option>YouTuber</option>
                                        <option>School Teacher</option>
                                        <option>Student</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Message (Optional)</label>
                                    <textarea class="form-control" rows="4" placeholder="Tell us your requirements..."></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-brand w-100 btn-lg" type="submit">
                                        Submit & Get Demo <i class="bi bi-send ms-1"></i>
                                    </button>
                                    <div id="formMsg" class="text-center mt-3 small text-muted"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <footer class="footer-pro pt-5 pb-4">
        <div class="container">
            <div class="row g-4">

                <!-- Brand -->
                <div class="col-lg-4">
                    <div class="footer-card">
                        <div class="footer-title fs-4 mb-5">
                            <img src="{{ asset('/assets/images/logo/BookMyTeacher-white.png') }}" class="w-75" />
                        </div>
                        <p class="mt-2 mb-0">
                            Build your online teaching brand with your own app, website, and powerful tools to manage
                            students.
                        </p>
                    </div>
                </div>

                <!-- Contact -->
                <div class="col-lg-4">
                    <div class="footer-card">
                        <div class="footer-title mb-2">Contact</div>
                        <div class="d-flex flex-column gap-2">
                            <div><i class="bi bi-telephone-fill me-2"></i> +91 7510 115544</div>
                            <div><a target="_blank" href="htpps://wa.me/+917510115544"><i
                                        class="bi bi-whatsapp me-2"></i> WhatsApp Support Available</a></div>
                            <div><a target="_blank" href="htpps://wa.me/+917510115544"><i
                                        class="bi bi-envelope-fill me-2"></i> support@bookmyteacher.com</a></div>
                            <div><i class="bi bi-geo-alt-fill me-2"></i> Devi Building,2nd Floor,Ponneth Temple
                                Road,Near Giridhar Hospital,Kadavanthara,Cochin -682020</div>
                        </div>
                    </div>
                </div>

                <!-- Social + Legal -->
                <div class="col-lg-4">
                    <div class="footer-card">
                        <div class="footer-title mb-2 text-center">Follow Us</div>
                        <div class="d-flex gap-2 flex-wrap justify-content-center">
                            <a class="btn btn-outline-light rounded-4 px-3" href="#" target="_blank">
                                <i class="bi bi-instagram me-1"></i> Instagram
                            </a>
                            <a class="btn btn-outline-light rounded-4 px-3" href="#" target="_blank">
                                <i class="bi bi-youtube me-1"></i> YouTube
                            </a>
                            <a class="btn btn-outline-light rounded-4 px-3" href="#" target="_blank">
                                <i class="bi bi-facebook me-1"></i> Facebook
                            </a>
                        </div>

                        <hr class="border-light opacity-25 my-3">

                        <div class="d-flex gap-3 flex-wrap small justify-content-center">
                            <a href="{{ url('privacy-policy') }}">Privacy Policy</a>
                            <a href="{{ url('terms-conditions') }}">Terms & Conditions</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4 small opacity-75">
                <div class="small">© <span id="year"></span> BookMyTeacher. All rights reserved.</div>. All
                rights reserved.
            </div>
        </div>
    </footer>
    <a class="whatsapp-float"
        href="https://wa.me/919876543210?text=Hi%20Team%2C%20I%20want%20a%20demo%20for%20my%20teaching%20app."
        target="_blank" aria-label="WhatsApp">
        <i class="bi bi-whatsapp fs-3"></i>
    </a>
    <div class="modal fade offer-modal" id="offerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header offer-modal-head border-0">
                    <h5 class="modal-title fw-black">
                        🎉 New Year Offer!
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h4 class="fw-black mb-2">Save ₹5,000 if you pay today!</h4>
                    <p class="text-muted mb-3">
                        Limited time discount available. Choose a plan and launch your branded teaching platform now.
                    </p>

                    <div class="d-flex gap-2">
                        <a href="#pricing" class="btn btn-brand w-100" data-bs-dismiss="modal">
                            View Pricing
                        </a>
                        <a href="#contact" class="btn btn-outline-brand w-100" data-bs-dismiss="modal">
                            Get Demo
                        </a>
                    </div>

                    <div class="text-muted small mt-3">
                        *Offer valid for today only. Terms apply.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // App mockup switcher
        $(document).on("click", ".thumb-btn", function() {
            $(".thumb-btn").removeClass("active");
            $(this).addClass("active");
            $("#mockPreview").attr("src", $(this).data("img"));
        });
    </script>
    <script>
        // Offer popup on page load (once per session)
        $(document).ready(function() {
            const shown = sessionStorage.getItem("offerModalShown");

            if (!shown) {
                setTimeout(function() {
                    const modal = new bootstrap.Modal(document.getElementById('offerModal'));
                    modal.show();
                    sessionStorage.setItem("offerModalShown", "true");
                }, 900); // delay for better UX
            }
        });
    </script>


    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 900,
            once: true,
            offset: 70
        });

        // Navbar Scroll Effect
        $(window).on("scroll", function() {
            if ($(this).scrollTop() > 40) {
                $(".navbar").addClass("scrolled");
            } else {
                $(".navbar").removeClass("scrolled");
            }
        });

        // Smooth Scroll + Active Link
        $('a.nav-link, a[href^="#"]').on("click", function(e) {
            const target = $(this).attr("href");
            if (target && target.startsWith("#") && $(target).length) {
                e.preventDefault();
                $("html, body").animate({
                    scrollTop: $(target).offset().top - 75
                }, 600);
            }
        });

        // Persona selection
        $(".persona-card").on("click", function() {
            $(".persona-card").removeClass("active");
            $(this).addClass("active");
        });

        // Counter animation (simple)
        function animateCounters() {
            $(".counter").each(function() {
                const $this = $(this);
                const target = parseInt($this.attr("data-target"), 10);

                if ($this.data("done")) return;
                const top = $this.offset().top;
                const winTop = $(window).scrollTop() + $(window).height();

                if (winTop > top + 40) {
                    $this.data("done", true);
                    let count = 0;
                    const step = Math.max(1, Math.floor(target / 120));

                    const timer = setInterval(() => {
                        count += step;
                        if (count >= target) {
                            count = target;
                            clearInterval(timer);
                        }
                        $this.text(count.toLocaleString("en-IN"));
                    }, 14);
                }
            });
        }

        $(window).on("scroll", animateCounters);
        $(document).ready(function() {
            animateCounters();
            $("#year").text(new Date().getFullYear());
        });

        // Form submit fake
        $("#leadForm").on("submit", function(e) {
            e.preventDefault();
            $("#formMsg").html("✅ Thank you! Our team will contact you shortly.");
            this.reset();
        });
    </script>

</body>

</html>
