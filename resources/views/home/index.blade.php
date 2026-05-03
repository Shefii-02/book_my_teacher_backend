@extends('home.layouts')
@section('content')
    <!-- HERO -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-dots"></div>
        <div class="hero-content">
            <div class="hero-badge"><span class="dot"></span>India's #1 Home &amp; Online Tutoring</div>
            <h1>Expert Tutors<br><span class="hl">At Your Home</span><br>or <span class="hl2">Online</span></h1>
            <p>Connect with 500+ verified expert tutors for personalised 1-on-1 live sessions — at home or online. Boost
                grades, build confidence, excel in every subject.</p>
            <div class="hero-actions">
                <a href="#enquiry" class="btn btn-accent btn-lg"><i class="fas fa-home"></i> Book Home Tuition</a>
                <a href="teachers" class="btn btn-lg"
                    style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.3)"><i
                        class="fas fa-laptop"></i> Find Online Tutor</a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="num">{{ $data['students_count'] }}+</div>
                    <div class="lbl">Students</div>
                </div>
                <div class="hero-stat">
                    <div class="num">{{ $data['teachers_count'] }}+</div>
                    <div class="lbl">Expert Tutors</div>
                </div>
                <div class="hero-stat">
                    <div class="num">{{ $data['avg_rating'] }}★</div>
                    <div class="lbl">Avg Rating</div>
                </div>
                <div class="hero-stat">
                    <div class="num">{{ $data['country_count'] }}+</div>
                    <div class="lbl">Countries</div>
                </div>
            </div>
        </div>
        <div class="hero-visual">
            <div class="phone-float">
                <img src="{{ asset('web/assets/images/img1.png') }}" alt="App">
                <div class="float-card float-card1">
                    <div class="fc-icon" style="background:#e8f5ee">🎯</div>
                    <div>
                        <div class="fc-title">Class Booked!</div>
                        <div class="fc-sub">Maths · Today 5PM</div>
                    </div>
                </div>
                <div class="float-card float-card2">
                    <div class="fc-icon" style="background:#fff3cd">⭐</div>
                    <div>
                        <div class="fc-title">5.0 Rating</div>
                        <div class="fc-sub">Just rated</div>
                    </div>
                </div>
                <div class="float-card float-card3">
                    <div class="fc-icon" style="background:#e8eaf6">📈</div>
                    <div>
                        <div class="fc-title">Score +22%</div>
                        <div class="fc-sub">After 4 sessions</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SEARCH -->
    <div class="search-section" id="searchSection">
        <div class="search-wrap">
            <div style="position:relative">
                <div class="search-box" id="searchBox">
                    <span class="search-icon"><i class="fas fa-search"></i></span>
                    <input class="search-input" id="searchInput" type="text"
                        placeholder="Search for Maths teacher, English tutor, NEET expert..." autocomplete="off"
                        oninput="handleSearch(this.value)" onfocus="showDropdown()" onblur="setTimeout(hideDropdown,200)">
                    <button class="search-btn" onclick="doSearch()">Search Tutors</button>
                </div>
                <div class="search-dropdown" id="searchDropdown"></div>
            </div>
            <div class="search-pills">
                <span>Popular:</span>
                @foreach ($data['popular_search'] ?? [] as $searchVal)
                    <span class="pill" onclick="searchPill('{{ $searchVal }}')">{{ $searchVal }}</span>
                @endforeach

                <span class="pill" onclick="searchPill('Home Tuition')">🏠 Home Tuition</span>
            </div>
        </div>
    </div>

    <!-- TRUST BAR -->
    <div class="trust-bar">
        <div class="trust-inner">
            <div class="trust-item"><i class="fas fa-shield-check"></i>
                <div><strong>100% Verified</strong> Tutors</div>
            </div>
            <div class="trust-item"><i class="fas fa-home"></i>
                <div><strong>Home &amp; Online</strong> Sessions</div>
            </div>
            <div class="trust-item"><i class="fas fa-calendar-check"></i>
                <div><strong>Flexible</strong> Scheduling</div>
            </div>
            <div class="trust-item"><i class="fas fa-gift"></i>
                <div><strong>Free</strong> First Demo</div>
            </div>
            <div class="trust-item"><i class="fas fa-globe"></i>
                <div>Serving <strong>{{ $data['country_count'] }}+ Countries</strong></div>
            </div>
        </div>
    </div>



    <!-- HOW IT WORKS -->
    <section style="background:var(--bg)" id="how-it-works">
        <div style="max-width:1200px;margin:0 auto">
            <div class="center" style="margin-bottom:3.5rem">
                <span class="section-tag">Simple Process</span>
                <h2 class="section-title">Start Learning in 4 Easy Steps</h2>
                <p class="section-sub" style="margin-inline:auto">From signup to your first lesson in less than 5 minutes.
                </p>
            </div>
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-num">1</div>
                    <h3>Create Account</h3>
                    <p>Sign up free with your mobile number. Quick OTP — done in seconds.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">2</div>
                    <h3>Choose Subject</h3>
                    <p>Browse 15+ subjects across all grades. Filter by board, budget &amp; location.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">3</div>
                    <h3>Pick Your Tutor</h3>
                    <p>View profiles, ratings, experience. Book a free 30-min demo session first.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">4</div>
                    <h3>Start Learning</h3>
                    <p>Join live 1-on-1 class at home or online. Whiteboard, notes &amp; recordings included.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Scroll Area -->
    <section class="py-5 testimonials"
        style="background: var(--dark);color: #fff;position: relative;overflow: hidden;padding: 5rem 5%;">
        <div class="container">

            <!-- Heading -->
            <div class="text-center mb-5">
                <h6 class="text-uppercase text-muted">
                    Review from our BMT Family
                </h6>
            </div>

            <div class="d-flex align-items-center">

                <!-- Left Rating Section -->
                <div class="d-none d-md-block col-md-2">
                    <div class="p-3">
                        <h5 class="fw-bold mb-1">Excellent</h5>
                        <div class="text-warning mb-1">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <small class="text-muted">
                            Based on <span class="text-success fw-bold">App</span>
                        </small>
                    </div>
                </div>
                <!-- Scroll Area -->
                <div class="col-12 col-md-10 overflow-auto" style="scrollbar-width: none;">
                    <div class="d-flex flex-nowrap gap-3 pb-3" style="scroll-behavior: smooth;">

                        @foreach ($app_reviews ?? [] as $appReview)
                            @php
                                $ratingText = $appReview->rating;

                                if ($ratingText == 'Happy') {
                                    $rating = 5;
                                } elseif ($ratingText == 'Good') {
                                    $rating = 4;
                                } elseif ($ratingText == 'Average') {
                                    $rating = 3;
                                } elseif ($ratingText == 'Below Average') {
                                    $rating = 2;
                                } elseif ($ratingText == 'Very Bad') {
                                    $rating = 1;
                                } else {
                                    $rating = 0;
                                }

                            @endphp
                            <!-- Card -->
                            <div class="card  rounded-4 flex-shrink-0" style="width: 200px;">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ $appReview->user?->avatar_url }}"
                                            class="rounded-circle me-3 border border-success" width="50"
                                            height="50">
                                        <div>
                                            <h6 class="fw-bold mb-0 text-black">{{ $appReview->user?->name }}</h6>
                                            <small class="text-warning">
                                                @for ($i = 0; $i < $rating; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                            </small>
                                        </div>
                                    </div>
                                    <p class="text-muted fst-italic small capitalize text-capitalize text-limit">
                                        "{{ $appReview->feedback }}"
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- HOME TUITION HIGHLIGHT -->
    <section style="background:var(--bg);padding:5rem 5%" id="home-tuition">
        <div class="ht-grid">
            <div style="position:relative">
                <div class="ht-main-card">
                    <div class="ht-icon-big">🏠</div>
                    <h3>Tutor Comes To You</h3>
                    <p>Our verified tutors travel to your home for personalised face-to-face sessions — no commute for your
                        child.
                    </p>
                    <div style="margin-top:1.5rem;display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap">
                        <span
                            style="background:var(--gp);color:var(--green);font-size:.8rem;font-weight:600;padding:.35rem .9rem;border-radius:100px;border:1px solid var(--border)">✓
                            Safe &amp; Verified</span>
                        <span
                            style="background:var(--gp);color:var(--green);font-size:.8rem;font-weight:600;padding:.35rem .9rem;border-radius:100px;border:1px solid var(--border)">✓
                            Background Checked</span>
                    </div>
                </div>
                <div class="ht-float-badge ht-badge1">📍 Tutor Near You</div>
                <div class="ht-float-badge ht-badge2">⏰ Your Preferred Time</div>
            </div>
            <div>
                <span class="section-tag">Our Highlight</span>
                <h2 class="section-title">We Bring the Classroom<br>To Your <span style="color:var(--green)">Front
                        Door</span>
                </h2>
                <p style="color:var(--muted);margin-bottom:2rem;line-height:1.7">Unlike platforms that only offer online
                    sessions, BookMyTeacher provides highly qualified tutors who come directly to your child's home.</p>
                <div class="row gap-2">
                    <div class="col-lg-5 ht-step mb-3">
                        <div class="ht-step-icon" style="background:#e8f5ee;color:var(--green)"><i
                                class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <h4>Local Verified Tutors</h4>
                            <p>Tutors in your neighbourhood — within 5km of your home.</p>
                        </div>
                    </div>
                    <div class="col-lg-5 ht-step mb-3">
                        <div class="ht-step-icon" style="background:#fff3e0;color:#e67e22"><i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h4>Your Schedule, Your Home</h4>
                            <p>Morning, evening, weekends — the tutor comes when it suits your family.</p>
                        </div>
                    </div>
                    <div class="col-lg-5 ht-step mb-3">
                        <div class="ht-step-icon" style="background:#e8eaf6;color:#5c6bc0"><i
                                class="fas fa-user-check"></i></div>
                        <div>
                            <h4>Parent-Supervised Sessions</h4>
                            <p>All home sessions are transparent. Parents can sit in and observe.</p>
                        </div>
                    </div>
                    <div class="col-lg-5 ht-step mb-3">
                        <div class="ht-step-icon" style="background:#fce4ec;color:#e91e63"><i
                                class="fas fa-book-open"></i></div>
                        <div>
                            <h4>Curriculum-Aligned Teaching</h4>
                            <p>Tutors follow CBSE, ICSE, State Board, or IB — matching your child's school syllabus.</p>
                        </div>
                    </div>
                </div>
                <div style="margin-top:2rem;display:flex;gap:.85rem;flex-wrap:wrap">
                    <a href="#enquiry" class="btn btn-primary btn-lg"><i class="fas fa-home"></i> Book Home Tutor</a>
                    <a href="teachers" class="btn btn-outline btn-lg">Browse All Tutors</a>
                </div>
            </div>
        </div>
    </section>

    <!-- SUBJECTS -->
    <section style="background:var(--card)" id="subjects">
        <div style="max-width:1200px;margin:0 auto">
            <div class="center" style="margin-bottom:2.5rem">
                <span class="section-tag">All Subjects</span>
                <h2 class="section-title">We Cover Every Subject You Need</h2>
                <p class="section-sub" style="margin-inline:auto">Click any subject to see available teachers instantly.
                </p>
            </div>
            <div class="subjects-grid">

                @foreach ($subjects ?? [] as $subject)
                    <div class="subject-pill" data-subject="{{ $subject->name }}" onclick="selectSubject(this)">
                        <span class="s-icon">📘</span><span class="s-name">{{ $subject->name }}</span>
                    </div>
                @endforeach

                {{-- <div class="subject-pill" data-subject="Physics" onclick="selectSubject(this)"><span
                        class="s-icon">⚛️</span><span class="s-name">Physics</span></div>
                <div class="subject-pill" data-subject="Chemistry" onclick="selectSubject(this)"><span
                        class="s-icon">🧪</span><span class="s-name">Chemistry</span></div>
                <div class="subject-pill" data-subject="Biology" onclick="selectSubject(this)"><span
                        class="s-icon">🧬</span><span class="s-name">Biology</span></div>
                <div class="subject-pill" data-subject="English" onclick="selectSubject(this)"><span
                        class="s-icon">📖</span><span class="s-name">English</span></div>
                <div class="subject-pill" data-subject="Science" onclick="selectSubject(this)"><span
                        class="s-icon">🔬</span><span class="s-name">Science</span></div>
                <div class="subject-pill" data-subject="Social Studies" onclick="selectSubject(this)"><span
                        class="s-icon">🗺️</span><span class="s-name">Social Studies</span></div>
                <div class="subject-pill" data-subject="Computer Science" onclick="selectSubject(this)"><span
                        class="s-icon">💻</span><span class="s-name">Computer Sci.</span></div>
                <div class="subject-pill" data-subject="Hindi" onclick="selectSubject(this)"><span
                        class="s-icon">🎭</span><span class="s-name">Hindi</span></div>
                <div class="subject-pill" data-subject="Malayalam" onclick="selectSubject(this)"><span
                        class="s-icon">✍️</span><span class="s-name">Malayalam</span></div>
                <div class="subject-pill" data-subject="History" onclick="selectSubject(this)"><span
                        class="s-icon">🏛️</span><span class="s-name">History</span></div>
                <div class="subject-pill" data-subject="Economics" onclick="selectSubject(this)"><span
                        class="s-icon">📊</span><span class="s-name">Economics</span></div>
                <div class="subject-pill" data-subject="JEE Prep" onclick="selectSubject(this)"><span
                        class="s-icon">🎓</span><span class="s-name">JEE Prep</span></div>
                <div class="subject-pill" data-subject="NEET Prep" onclick="selectSubject(this)"><span
                        class="s-icon">🩺</span><span class="s-name">NEET Prep</span></div>
                <div class="subject-pill" data-subject="Accountancy" onclick="selectSubject(this)"><span
                        class="s-icon">📐</span><span class="s-name">Accountancy</span></div>
                <div class="subject-pill" data-subject="Geography" onclick="selectSubject(this)"><span
                        class="s-icon">🌍</span><span class="s-name">Geography</span></div> --}}
            </div>
            <div class="subject-teachers-panel" id="subjectPanel">
                <div class="stp-header">
                    <div class="stp-title" id="stpTitle">Teachers</div>
                    <a href="teachers" class="btn btn-primary btn-sm">View All <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="mini-teachers" id="miniTeachers"></div>
            </div>
        </div>
    </section>

    <!-- WORLDWIDE -->
    <div class="worldwide" id="worldwide">
        <div class="ww-inner">
            <div class="center">
                <span class="section-tag" style="background:rgba(255,255,255,.15);color:#fff">Global Reach</span>
                <h2 class="section-title" style="color:#fff">BookMyTeacher serves students <span
                        style="color:var(--gl)">worldwide</span></h2>
                <p style="color:rgba(255,255,255,.7);max-width:600px;margin-inline:auto;line-height:1.7">No matter where
                    you are
                    — your child gets expert Indian-curriculum tutors, personalised lessons, right from home.</p>
            </div>
            <div class="countries-grid">
                <div class="country-card"><span class="country-flag">🇮🇳</span>
                    <div>
                        <div class="country-name">India</div>
                        <div class="country-count">200+ Tutors</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- YOUTUBE TESTIMONIALS -->
    <section style="background:var(--bg);overflow:hidden" id="video-testimonials">
        <div style="max-width:1200px;margin:0 auto">
            <div class="center" style="margin-bottom:2.5rem">
                <span class="section-tag">Video Stories</span>
                <h2 class="section-title">Watch Real Student Success Stories</h2>
                <p class="section-sub" style="margin-inline:auto">Hear directly from students and parents about their
                    BookMyTeacher experience.</p>
            </div>
            <div style="position:relative">
                <h6 class="my-5 text-center">No Data Found</h6>
                {{-- <div
          style="display:flex;justify-content:space-between;align-items:center;position:absolute;top:38%;left:-10px;right:-10px;z-index:10;pointer-events:none">
          <button class="yt-nav" onclick="ytScroll(-1)" style="pointer-events:all">&#8249;</button>
          <button class="yt-nav" onclick="ytScroll(1)" style="pointer-events:all">&#8250;</button>
        </div>
        <div class="yt-scroll-track" id="ytTrackHome"> --}}

                {{-- <div class="yt-card">
            <div class="yt-frame-wrap"><iframe src="https://www.youtube.com/embed/vML991fMZ9o?rel=0&modestbranding=1"
                title="NEET Success" frameborder="0" allowfullscreen loading="lazy"></iframe></div>
            <div class="yt-info"><span class="yt-cat">NEET Success</span>
              <p class="yt-desc">"Cleared NEET on first attempt with home tuition!"</p>
              <div class="yt-student">Anjali Nair · Tamil Nadu</div>
            </div>
          </div>
          <div class="yt-card">
            <div class="yt-frame-wrap"><iframe src="https://www.youtube.com/embed/vML991fMZ9o?rel=0&modestbranding=1"
                title="JEE Rank" frameborder="0" allowfullscreen loading="lazy"></iframe></div>
            <div class="yt-info"><span class="yt-cat">JEE Prep</span>
              <p class="yt-desc">"Scored 97 percentile in JEE Maths — top 3%!"</p>
              <div class="yt-student">Vivek Raghunathan · Chennai</div>
            </div>
          </div>
          <div class="yt-card">
            <div class="yt-frame-wrap"><iframe src="https://www.youtube.com/embed/vML991fMZ9o?rel=0&modestbranding=1"
                title="Parent Review" frameborder="0" allowfullscreen loading="lazy"></iframe></div>
            <div class="yt-info"><span class="yt-cat">Parent Review</span>
              <p class="yt-desc">"Best home tutor service — punctual and results-driven!"</p>
              <div class="yt-student">Sunita Pillai · Bangalore</div>
            </div>
          </div>
          <div class="yt-card">
            <div class="yt-frame-wrap"><iframe src="https://www.youtube.com/embed/vML991fMZ9o?rel=0&modestbranding=1"
                title="Online UAE" frameborder="0" allowfullscreen loading="lazy"></iframe></div>
            <div class="yt-info"><span class="yt-cat">Online · UAE</span>
              <p class="yt-desc">"Indian curriculum tutor from Dubai — works perfectly online!"</p>
              <div class="yt-student">Mohammed Khan · Dubai</div>
            </div>
          </div>
          <div class="yt-card">
            <div class="yt-frame-wrap"><iframe src="https://www.youtube.com/embed/vML991fMZ9o?rel=0&modestbranding=1"
                title="Board Exam" frameborder="0" allowfullscreen loading="lazy"></iframe></div>
            <div class="yt-info"><span class="yt-cat">Board Exams</span>
              <p class="yt-desc">"From 58% to 91% in CBSE boards — incredible!"</p>
              <div class="yt-student">Ramesh Sharma · Kerala</div>
            </div>
          </div> --}}
                {{-- </div> --}}
                {{-- <div style="display:flex;justify-content:center;gap:.5rem;margin-top:1rem" id="ytDotsHome">
          <div class="yt-dot active" onclick="ytGoTo(0)"></div>
          <div class="yt-dot" onclick="ytGoTo(1)"></div>
          <div class="yt-dot" onclick="ytGoTo(2)"></div>
          <div class="yt-dot" onclick="ytGoTo(3)"></div>
          <div class="yt-dot" onclick="ytGoTo(4)"></div>
        </div> --}}
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section style="background:var(--card)" id="features">
        <div class="feat-grid">
            <div class="features-img-wrap">
                <img src="{{ asset('web/assets/images/img2.png') }}" alt="App Preview">
                <div class="feat-badge">
                    <div class="big">98%</div>
                    <div class="small">Student<br>Satisfaction</div>
                </div>
            </div>
            <div>
                <span class="section-tag">Why BookMyTeacher</span>
                <h2 class="section-title">Everything Your Child Needs to Succeed</h2>
                <p style="color:var(--muted);margin-bottom:2.25rem;line-height:1.7">Expert tutors + smart technology +
                    personalised learning = exceptional results.</p>
                <div class="feat-list">
                    <div class="feat-item">
                        <div class="feat-icon" style="background:#e8f5ee;color:var(--green)"><i
                                class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <h4>Verified Expert Tutors</h4>
                            <p>Background-checked, minimum 3 years experience. You always get quality.</p>
                        </div>
                    </div>
                    <div class="feat-item">
                        <div class="feat-icon" style="background:#fff3e0;color:#e67e22"><i
                                class="fas fa-chalkboard-user"></i></div>
                        <div>
                            <h4>Interactive Live Sessions</h4>
                            <p>Virtual whiteboard, screen sharing, instant doubt resolution — at home or online.</p>
                        </div>
                    </div>
                    <div class="feat-item">
                        <div class="feat-icon" style="background:#e8eaf6;color:#5c6bc0"><i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <h4>Progress Tracking</h4>
                            <p>Detailed reports after every session. Parents monitor improvement in real time.</p>
                        </div>
                    </div>
                    <div class="feat-item">
                        <div class="feat-icon" style="background:#fce4ec;color:#e91e63"><i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h4>Flexible Scheduling</h4>
                            <p>Book sessions morning, evening, weekends. Reschedule with 4 hours notice.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS -->
    <section style="background:var(--bg)">
        <div style="max-width:1200px;margin:0 auto">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-num">2,00,000+</div>
                    <div class="stat-lbl">Students Enrolled</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">500+</div>
                    <div class="stat-lbl">Verified Tutors</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">15+</div>
                    <div class="stat-lbl">Subjects</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">7+</div>
                    <div class="stat-lbl">Countries</div>
                </div>
            </div>
        </div>
    </section>

    <!-- TOP TUTORS -->
    <section style="background:var(--card)" id="tutors">
        <div style="max-width:1200px;margin:0 auto">
            <div
                style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:1rem;margin-bottom:2.5rem">
                <div><span class="section-tag">Our Experts</span>
                    <h2 class="section-title" style="margin-bottom:0">Meet Top-Rated Tutors</h2>
                </div>
                <a href="teachers" class="btn btn-outline">View All <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="tutors-grid">
                @foreach ($top_teachers ?? [] as $teacher)
                    <div class="tutor-card" onclick="location.href='teacher-profile?id=1'">
                        <div class="tutor-cover" style="background:linear-gradient(135deg,#0f7a3c,#1db954)">
                            <img src="{{ $teacher->thumbnail_url }}" class=" mx-auto" style="height: 216px">
                        </div>
                        <div class="tutor-body">
                            <div class="tutor-name">{{ $teacher->name }}</div>
                            <div class=" small text-info">{!! $teacher->ranking > 0  ?  'Ranking :' . $teacher->ranking : '<br>' !!}</div>
                            <div class="tutor-role">{{ $teacher->qualifications }}</div>
                            <div class="tutor-meta"><span><i class="fas fa-briefcase"></i> {{ $teacher->year_exp }}
                                    yrs</span><span><i class="fas fa-video"></i> {{ $teacher->total_courses?->count() }}
                                    Courses</span><span class="text-capitalize"><i class="fas fa-home"></i>
                                    {{ $teacher->professionalInfo?->teaching_mode }}</span></div>
                            <div class="tutor-tags">
                                @foreach ($teacher->teachingSubjects ?? [] as $subject)
                                    <span class="tag">{{ $subject->name }}</span>
                                @endforeach
                            </div>
                            <div class="tutor-footer">
                                <div class="rating"><span class="stars">@for($i=0;$i<$teacher->rating;$i++){{ '★' }}@endfor</span> {{ $teacher->reviews->count() > 0 ? $teacher->reviews->count() : '' }}</div><a
                                    href="teacher-profile?id=1" class="btn btn-primary btn-sm"
                                    onclick="event.stopPropagation()">Book Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="testimonials" id="testimonials">
        <div style="max-width:1200px;margin:0 auto">
            <div class="center" style="margin-bottom:3rem;position:relative;z-index:1">
                <span class="section-tag" style="background:rgba(255,255,255,.15);color:#fff">What Students Say Our
                    Service</span>
                <h2 class="section-title" style="color:#fff">Real Results, Real Stories</h2>
                <p style="color:rgba(255,255,255,.7);margin-inline:auto;max-width:500px">Over 2 lakh students trust
                    BookMyTeacher for their learning journey.</p>
            </div>
            <div class="testi-grid">

                <div class="testi-card">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">"My son went from 58% to 89% in Maths within 3 months. The tutor was patient and
                        knew
                        exactly how to explain each concept."</p>
                    <div class="testi-author">
                        <div class="testi-av">RS</div>
                        <div>
                            <div class="testi-name">Ramesh Sharma</div>
                            <div class="testi-role">Parent · Class 10 · Kerala</div>
                        </div>
                    </div>
                </div>
                <div class="testi-card">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">"Cleared NEET on my first attempt! The Chemistry sessions were so structured. The
                        home
                        tutor visited every evening."</p>
                    <div class="testi-author">
                        <div class="testi-av">AN</div>
                        <div>
                            <div class="testi-name">Anjali Nair</div>
                            <div class="testi-role">Student · NEET 2024 · Tamil Nadu</div>
                        </div>
                    </div>
                </div>
                <div class="testi-card">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">"As a parent in Dubai, finding an Indian curriculum tutor was a challenge.
                        BookMyTeacher
                        solved that completely!"</p>
                    <div class="testi-author">
                        <div class="testi-av">MK</div>
                        <div>
                            <div class="testi-name">Mohammed Khan</div>
                            <div class="testi-role">Parent · Class 8 · Dubai, UAE</div>
                        </div>
                    </div>
                </div>
                <div class="testi-card">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">"The home tutor visits daily after school. The app lets me track exactly what is
                        being
                        covered each session."</p>
                    <div class="testi-author">
                        <div class="testi-av">SP</div>
                        <div>
                            <div class="testi-name">Sunita Pillai</div>
                            <div class="testi-role">Parent · Class 12 · Bangalore</div>
                        </div>
                    </div>
                </div>
                <div class="testi-card">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">"I was struggling with JEE Maths. The tutor broke every topic step by step.
                        Scored 97
                        percentile in Maths!"</p>
                    <div class="testi-author">
                        <div class="testi-av">VR</div>
                        <div>
                            <div class="testi-name">Vivek Raghunathan</div>
                            <div class="testi-role">Student · JEE 2024 · Chennai</div>
                        </div>
                    </div>
                </div>
                <div class="testi-card">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">"After 8 sessions with her home tutor, my daughter's English writing improved
                        dramatically. Even her school teacher noticed!"</p>
                    <div class="testi-author">
                        <div class="testi-av">LM</div>
                        <div>
                            <div class="testi-name">Lakshmi Menon</div>
                            <div class="testi-role">Parent · Class 9 · Kochi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- APP -->
    <section class="app-section" style="padding:5rem 5%">
        <div class="app-grid">
            <div class="app-phone"><img src="{{ asset('web/assets/images/img3.png') }}" alt="App Preview"></div>
            <div class="app-content">
                <span class="section-tag" style="background:rgba(255,255,255,.15);color:rgba(255,255,255,.9)">Mobile
                    App</span>
                <h2>Learning On The Go</h2>
                <p>Book sessions, join live classes, track progress, and connect with tutors — all from our free mobile app.
                </p>
                <div class="app-btns">
                    <a href="https://apps.apple.com/cl/app/book-my-teacher/id6757139924" target="_blank"
                        class="store-btn"><i class="fab fa-apple"></i>
                        <div class="store-btn-text">
                            <div class="small">Download on</div>
                            <div class="big">App Store</div>
                        </div>
                    </a>
                    <a target="_blank"
                        href="https://play.google.com/store/apps/details?id=coin.bookmyteacher.app&pcampaignid=web_share"
                        class="store-btn"><i class="fab fa-google-play"></i>
                        <div class="store-btn-text">
                            <div class="small">Get it on</div>
                            <div class="big">Google Play</div>
                        </div>
                    </a>
                </div>
                <div class="app-feats">
                    <div class="app-feat"><i class="fas fa-check-circle"></i> Live 1-on-1 video with interactive
                        whiteboard</div>
                    <div class="app-feat"><i class="fas fa-check-circle"></i> Session recordings available anytime</div>
                    <div class="app-feat"><i class="fas fa-check-circle"></i> Real-time progress tracking for parents
                    </div>
                    <div class="app-feat"><i class="fas fa-check-circle"></i> Instant tutor chat &amp; doubt resolution
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ENQUIRY -->
    <section style="background:var(--bg)" id="enquiry">
        <div class="enquiry-grid">
            <div>
                <span class="section-tag">Get Started Today</span>
                <h2 class="section-title">Book a Free Demo Session for Your Child</h2>
                <p style="color:var(--muted);margin-bottom:2rem;line-height:1.7">No commitments. Our counsellors will
                    understand
                    your needs and match your child with the perfect tutor within 30 minutes.</p>
                <div class="benefits">
                    <div class="benefit">
                        <div class="benefit-icon"><i class="fas fa-gift"></i></div>
                        <div>
                            <h4>100% Free First Session</h4>
                            <p>Full 30-minute demo with a top tutor — completely free, no credit card needed.</p>
                        </div>
                    </div>
                    <div class="benefit">
                        <div class="benefit-icon"><i class="fas fa-home"></i></div>
                        <div>
                            <h4>Home or Online — Your Choice</h4>
                            <p>We offer both home visits and online sessions. You decide what works best.</p>
                        </div>
                    </div>
                    <div class="benefit">
                        <div class="benefit-icon"><i class="fas fa-phone-volume"></i></div>
                        <div>
                            <h4>Call Back in 30 Minutes</h4>
                            <p>Our counsellors call you within 30 minutes to understand your requirements.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="enquiry-form">
                <h4 style="font-family:'Syne',sans-serif;font-weight:bold;font-size:1.35rem;margin-bottom:.4rem">Enquire
                    Now
                </h4>
                <p style="font-size:.85rem;color:var(--muted);margin-bottom:1.5rem">We'll get back to you in 30 minutes!
                </p>
                <div class="form-row">
                    <div class="form-group"><label>Parent's Name</label><input type="text" id="eq_name"
                            placeholder="e.g. Ramesh Kumar"></div>
                    <div class="form-group"><label>Mobile Number</label><input type="tel" id="eq_phone"
                            placeholder="+91 XXXXX XXXXX"></div>
                </div>
                <div class="form-group"><label>Student's Grade</label>
                    <select id="eq_grade">
                        <option value="">Select Grade</option>
                        @foreach ($grades ?? [] as $grade)
                        <option value="{{ $grade->name }}">{{ $grade->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Board</label>
                        <select id="eq_board">
                            <option value="">Select Board</option>
                            @foreach ($boards ?? [] as $board)
                              <option value="{{ $board->name }}">{{ $board->name }}</option>
                            @endforeach


                        </select>
                    </div>
                    <div class="form-group"><label>Subject Needed</label>
                        <select id="eq_subject">
                            <option value="">Select Subject</option>
                            @foreach ($subjects ?? [] as $subject)
                            <option value="{{ $subject->name }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group"><label>Mode</label>
                    <select id="eq_mode">
                        <option value="">Select Mode</option>
                        <option value="Home Tuition">Home Tuition (Tutor visits you)</option>
                        <option value="Online">Online (Video session)</option>
                        <option value="Both are fine">Both are fine</option>
                    </select>
                </div>
                <div class="form-group"><label>City / Country</label><input type="text" id="eq_city"
                        placeholder="e.g. Kochi, Kerala or Dubai, UAE"></div>
                <button class="btn btn-lg"
                    style="width:100%;justify-content:center;font-size:1rem;margin-bottom:.65rem;background:#25d366;color:#fff;border:none;cursor:pointer;border-radius:100px;font-family:'DM Sans',sans-serif;font-weight:600"
                    onclick="sendToWhatsApp()">
                    <i class="fab fa-whatsapp"></i> Send via WhatsApp
                </button>
                {{-- <button class="btn btn-outline btn-lg" style="width:100%;justify-content:center"
                    onclick="handleSubmit()">
                    <i class="fas fa-paper-plane"></i> Submit Enquiry
                </button> --}}
                <p style="text-align:center;font-size:.75rem;color:var(--muted);margin-top:.65rem"><i
                        class="fas fa-lock"></i>
                    Your info is safe and will never be shared.</p>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section style="background:var(--card)" id="faq">
        <div class="faq-wrap">
            <div>
                <span class="section-tag">FAQ</span>
                <h2 class="section-title">Questions?<br>We Have Answers.</h2>
                <p style="color:var(--muted);line-height:1.7;margin-bottom:2rem">Still unsure? Our team is happy to help.
                </p>
                <a href="mailto:contact@bookmyteacher.com" class="btn btn-primary"><i class="fas fa-envelope"></i> Email
                    Us</a>
                <div
                    style="margin-top:1.25rem;display:flex;align-items:center;gap:.7rem;font-size:.85rem;color:var(--muted)">
                    <i class="fas fa-phone" style="color:var(--green)"></i>
                    <span>+91 7510 11 55 44 · Mon–Sat, 9AM–7PM</span>
                </div>
            </div>
            <div class="faq-list">
                <div class="faq-item open">
                    <div class="faq-q" onclick="toggleFaq(this)">Is the first demo session really free? <i
                            class="fas fa-chevron-down"></i></div>
                    <div class="faq-a">
                        <div class="faq-a-inner">Yes! Your child gets a full 30-minute live session with a tutor at zero
                            cost. No
                            credit card needed. Try before you commit.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-q" onclick="toggleFaq(this)">Do tutors come to our home? <i
                            class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-a">
                        <div class="faq-a-inner">Yes! Home tuition is our flagship offering. Our verified tutors travel to
                            your
                            location. We match you with tutors within 5km of your address. All tutors are
                            background-verified for your
                            safety.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-q" onclick="toggleFaq(this)">How are tutors verified? <i
                            class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-a">
                        <div class="faq-a-inner">All tutors go through a 3-step process: academic qualification check,
                            teaching
                            demo, and background verification. Only the top 5% of applicants are accepted.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-q" onclick="toggleFaq(this)">What if my child doesn't like the tutor? <i
                            class="fas fa-chevron-down"></i></div>
                    <div class="faq-a">
                        <div class="faq-a-inner">No problem! We offer free tutor changes with no questions asked. We will
                            rematch
                            them with another tutor immediately at no extra cost.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-q" onclick="toggleFaq(this)">Can I access sessions from outside India? <i
                            class="fas fa-chevron-down"></i></div>
                    <div class="faq-a">
                        <div class="faq-a-inner">Yes! We serve UAE, Qatar, Oman, Saudi Arabia, Bahrain, and Kuwait via
                            online
                            sessions. Our tutors specialise in Indian curriculum regardless of where you live.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function loadTeachersBySubject(el) {

            let subjectId = el.getAttribute('data-id');
            let subjectName = el.getAttribute('data-name');

            // UI highlight
            document.querySelectorAll('.subject-pill').forEach(e => e.classList.remove('active'));
            el.classList.add('active');

            // Show panel
            document.getElementById('subjectPanel').style.display = 'block';
            document.getElementById('stpTitle').innerText = subjectName + " Teachers";

            // Loader
            document.getElementById('miniTeachers').innerHTML = "Loading...";

            fetch(`/get-teachers-by-subject/${subjectId}`)
                .then(res => res.json())
                .then(res => {

                    let html = '';

                    if (res.data.length === 0) {
                        html = `<p>No teachers found</p>`;
                    }

                    res.data.forEach(t => {

                        let subjects = t.subjects.map(s => s.name).join(', ');

                        html += `
                    <div class="mini-teacher-card" onclick="location.href='teacher-profile?id=${t.id}'">

                        <img src="${t.avatar ?? '/default.png'}" class="mini-avatar">

                        <div class="mini-info">
                            <div class="mini-name">${t.name}</div>
                            <div class="mini-subjects">${subjects}</div>

                            <div class="mini-meta">
                                ⭐ ${t.reviews_avg_rating ?? '0'}
                                · ${t.students_count} students
                            </div>
                        </div>

                    </div>
                `;
                    });

                    document.getElementById('miniTeachers').innerHTML = html;

                })
                .catch(err => {
                    document.getElementById('miniTeachers').innerHTML = "Error loading data";
                });
        }
    </script>
@endsection
