@extends('layouts.home')
@section('content')
    <!-- ═══ HERO ═══════════════════════════════════════════════════ -->
    <div class="about-hero">
        <div class="ah-inner">
            <div class="ah-left">
                <span class="section-tag" style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.9)">Our Story</span>
                <h1>Transforming Education<br>One <span>Home at a Time</span></h1>
                <p>BookMyTeacher was born in Kerala with a simple belief: every child deserves personalised, expert teaching
                    —
                    at home or online. Today we serve over 2 lakh students across India and the Middle East.</p>
                <div class="ah-badges">
                    <span class="ah-badge"><i class="fas fa-map-marker-alt"></i> Founded in Kerala, 2018</span>
                    <span class="ah-badge"><i class="fas fa-globe"></i> Operating in 7+ Countries</span>
                    <span class="ah-badge"><i class="fas fa-award"></i> 500+ Verified Tutors</span>
                    <span class="ah-badge"><i class="fas fa-users"></i> 2 Lakh+ Students</span>
                </div>
            </div>
            <div class="ah-right">
                <div class="ah-stat-card">
                    <div class="ah-stat-num">2L+</div>
                    <div class="ah-stat-lbl">Students Taught</div>
                </div>
                <div class="ah-stat-card">
                    <div class="ah-stat-num">500+</div>
                    <div class="ah-stat-lbl">Expert Tutors</div>
                </div>
                <div class="ah-stat-card accent">
                    <div class="ah-stat-num">7+</div>
                    <div class="ah-stat-lbl">Countries Served</div>
                </div>
                <div class="ah-stat-card">
                    <div class="ah-stat-num">4.9★</div>
                    <div class="ah-stat-lbl">Average Rating</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══ OUR STORY ════════════════════════════════════════════════ -->
    <section style="background:var(--bg)">
        <div class="story-grid">
            <div class="story-img">
                <div class="story-main-box">
                    <div class="big-num">6+</div>
                    <p>Years of transforming how children learn across Kerala and beyond</p>
                    <div style="display:flex;justify-content:center;gap:1.5rem;margin-top:1.5rem;flex-wrap:wrap">
                        <div style="text-align:center">
                            <div style="font-family:'Syne',sans-serif;font-weight:bold;font-size:1.3rem;color:var(--gl)">98%
                            </div>
                            <div style="font-size:.72rem;opacity:.65">Satisfaction Rate</div>
                        </div>
                        <div style="text-align:center">
                            <div style="font-family:'Syne',sans-serif;font-weight:bold;font-size:1.3rem;color:var(--gl)">
                                30min</div>
                            <div style="font-size:.72rem;opacity:.65">Avg Response Time</div>
                        </div>
                        <div style="text-align:center">
                            <div style="font-family:'Syne',sans-serif;font-weight:bold;font-size:1.3rem;color:var(--gl)">15+
                            </div>
                            <div style="font-size:.72rem;opacity:.65">Subjects</div>
                        </div>
                    </div>
                </div>
                <div class="story-float story-float-1">
                    <div class="sf-icon">🏆</div>
                    <div class="sf-val">Kerala's #1</div>
                    <div class="sf-lbl">Home Tutoring Platform</div>
                </div>
                <div class="story-float story-float-2">
                    <div class="sf-icon">🚀</div>
                    <div class="sf-val">30 min</div>
                    <div class="sf-lbl">Fastest Tutor Matching</div>
                </div>
            </div>
            <div class="story-text">
                <span class="section-tag">Who We Are</span>
                <h2 class="section-title">Started with a Problem,<br>Built a Platform</h2>
                <p>In 2018, our founders noticed a common frustration in Kerala families: finding a reliable, qualified home
                    tutor was a time-consuming, unpredictable process. Parents relied on word-of-mouth. Tutors had no way to
                    reach
                    students beyond their neighbourhood.</p>
                <p>BookMyTeacher was created to solve this — a technology-first platform that makes it as easy to book an
                    expert
                    home tutor as it is to order food online. With verified tutor profiles, transparent pricing, WhatsApp
                    booking,
                    and real-time progress tracking, we changed how tutoring works.</p>
                <p>From one city in Kerala, we've grown to serve families across all major Kerala cities and Indian expat
                    communities in UAE, Qatar, Oman, Saudi Arabia, Bahrain, and Kuwait.</p>
                <div style="display:flex;gap:.85rem;margin-top:1.75rem;flex-wrap:wrap">
                    <a href="teachers.html" class="btn btn-primary btn-lg"><i class="fas fa-search"></i> Find a Tutor</a>
                    <a href="contact.html" class="btn btn-outline btn-lg"><i class="fas fa-phone"></i> Talk to Us</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ MISSION / VISION / VALUES ════════════════════════════════ -->
    <section style="background:var(--card)">
        <div style="max-width:1100px;margin:0 auto">
            <div class="center" style="margin-bottom:3rem">
                <span class="section-tag">Our Foundation</span>
                <h2 class="section-title">Mission, Vision &amp; Values</h2>
            </div>
            <div class="mvv-grid">
                <div class="mvv-card mission anim">
                    <div class="mvv-icon"><i class="fas fa-bullseye"></i></div>
                    <div class="mvv-title">Our Mission</div>
                    <p class="mvv-text">To make high-quality, personalised education accessible to every student —
                        regardless of
                        where they live — through verified expert tutors and technology.</p>
                    <div class="mvv-points">
                        <div class="mvv-point"><i class="fas fa-check"></i> 1-on-1 learning for every child</div>
                        <div class="mvv-point"><i class="fas fa-check"></i> Tutors available home &amp; online</div>
                        <div class="mvv-point"><i class="fas fa-check"></i> Affordable, transparent pricing</div>
                    </div>
                </div>
                <div class="mvv-card vision anim">
                    <div class="mvv-icon" style="background:#e8eaf6;color:#5c6bc0"><i class="fas fa-eye"></i></div>
                    <div class="mvv-title">Our Vision</div>
                    <p class="mvv-text">To become the most trusted tutoring ecosystem in South Asia and the Indian diaspora
                        —
                        where every family can find their child's perfect learning partner within minutes.</p>
                    <div class="mvv-points">
                        <div class="mvv-point"><i class="fas fa-check"></i> 50 countries by 2030</div>
                        <div class="mvv-point"><i class="fas fa-check"></i> 10 lakh students served</div>
                        <div class="mvv-point"><i class="fas fa-check"></i> AI-powered tutor matching</div>
                    </div>
                </div>
                <div class="mvv-card values anim">
                    <div class="mvv-icon" style="background:#fff3e0;color:#e67e22"><i class="fas fa-heart"></i></div>
                    <div class="mvv-title">Our Values</div>
                    <p class="mvv-text">Every decision we make is guided by five core principles that define who we are and
                        how we
                        work.</p>
                    <div class="mvv-points">
                        <div class="mvv-point"><i class="fas fa-check"></i> <strong>Trust</strong> — rigorous tutor
                            verification
                        </div>
                        <div class="mvv-point"><i class="fas fa-check"></i> <strong>Excellence</strong> — only top 5%
                            tutors pass
                        </div>
                        <div class="mvv-point"><i class="fas fa-check"></i> <strong>Transparency</strong> — no hidden
                            costs</div>
                        <div class="mvv-point"><i class="fas fa-check"></i> <strong>Empathy</strong> — student-first
                            always</div>
                        <div class="mvv-point"><i class="fas fa-check"></i> <strong>Inclusion</strong> — every grade,
                            every board
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ IMPACT NUMBERS ════════════════════════════════════════════ -->
    <section style="background:var(--bg)">
        <div style="max-width:1100px;margin:0 auto">
            <div class="center" style="margin-bottom:3rem">
                <span class="section-tag">Our Impact</span>
                <h2 class="section-title">Numbers That Matter</h2>
            </div>
            <div class="impact-grid">
                <div class="impact-item anim">
                    <div class="impact-num">2,00,000+</div>
                    <div class="impact-lbl">Students Enrolled</div>
                </div>
                <div class="impact-item anim">
                    <div class="impact-num">500+</div>
                    <div class="impact-lbl">Verified Expert Tutors</div>
                </div>
                <div class="impact-item anim">
                    <div class="impact-num">7+</div>
                    <div class="impact-lbl">Countries Served</div>
                </div>
                <div class="impact-item anim">
                    <div class="impact-num">15+</div>
                    <div class="impact-lbl">Subjects Covered</div>
                </div>
                <div class="impact-item anim">
                    <div class="impact-num">98%</div>
                    <div class="impact-lbl">Student Satisfaction</div>
                </div>
                <div class="impact-item anim">
                    <div class="impact-num">4.9★</div>
                    <div class="impact-lbl">Average Tutor Rating</div>
                </div>
                <div class="impact-item anim">
                    <div class="impact-num">6+</div>
                    <div class="impact-lbl">Years of Operation</div>
                </div>
                <div class="impact-item anim">
                    <div class="impact-num">30min</div>
                    <div class="impact-lbl">Avg Tutor Match Time</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ OUR JOURNEY / TIMELINE ════════════════════════════════════ -->
    <section style="background:var(--card)">
        <div style="max-width:1100px;margin:0 auto">
            <div class="center" style="margin-bottom:3.5rem">
                <span class="section-tag">Our Journey</span>
                <h2 class="section-title">From One City to Seven Countries</h2>
            </div>
            <div class="timeline">
                <div class="tl-item left anim">
                    <div class="tl-content">
                        <div class="tl-year">2018</div>
                        <div class="tl-event">🚀 BookMyTeacher Founded</div>
                        <div class="tl-desc">Launched in Kozhikode, Kerala with 12 tutors and a mission to make home
                            tuition booking
                            simple and reliable.</div>
                    </div>
                    <div class="tl-dot"></div>
                </div>
                <div class="tl-item right anim">
                    <div class="tl-dot"></div>
                    <div class="tl-content">
                        <div class="tl-year">2019</div>
                        <div class="tl-event">📱 Mobile App Launch</div>
                        <div class="tl-desc">Released Android &amp; iOS apps. Student base crossed 5,000. Expanded to
                            Thrissur and
                            Kochi.</div>
                    </div>
                </div>
                <div class="tl-item left anim">
                    <div class="tl-content">
                        <div class="tl-year">2020</div>
                        <div class="tl-event">💻 Online Tutoring Platform</div>
                        <div class="tl-desc">Launched video-based live tutoring with interactive whiteboard. Enabled
                            tutoring for
                            students during lockdown across all of Kerala.</div>
                    </div>
                    <div class="tl-dot"></div>
                </div>
                <div class="tl-item right anim">
                    <div class="tl-dot"></div>
                    <div class="tl-content">
                        <div class="tl-year">2021</div>
                        <div class="tl-event">🌏 Middle East Expansion</div>
                        <div class="tl-desc">Launched online tutoring for Indian expat families in UAE and Qatar. Crossed
                            25,000
                            students.</div>
                    </div>
                </div>
                <div class="tl-item left anim">
                    <div class="tl-content">
                        <div class="tl-year">2022</div>
                        <div class="tl-event">🏆 Kerala's #1 Tutoring Platform</div>
                        <div class="tl-desc">Ranked the most trusted tutoring platform in Kerala. Student base crossed 1
                            lakh. Added
                            Oman, Saudi Arabia and Bahrain.</div>
                    </div>
                    <div class="tl-dot"></div>
                </div>
                <div class="tl-item right anim">
                    <div class="tl-dot"></div>
                    <div class="tl-content">
                        <div class="tl-year">2023</div>
                        <div class="tl-event">🤖 Smart Matching &amp; Analytics</div>
                        <div class="tl-desc">Launched AI-assisted tutor matching and real-time parent progress dashboards.
                            Kuwait
                            added to GCC coverage.</div>
                    </div>
                </div>
                <div class="tl-item left anim">
                    <div class="tl-content">
                        <div class="tl-year">2024–25</div>
                        <div class="tl-event">🌟 2 Lakh Students &amp; Beyond</div>
                        <div class="tl-desc">Surpassed 2 lakh students, 500 tutors, expanded JEE/NEET crash courses and
                            introduced
                            Family Plans.</div>
                    </div>
                    <div class="tl-dot"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ WHY DIFFERENT ══════════════════════════════════════════════ -->
    <section style="background:var(--bg)">
        <div style="max-width:1100px;margin:0 auto">
            <div class="center" style="margin-bottom:3rem">
                <span class="section-tag">Our Difference</span>
                <h2 class="section-title">Why Families Choose BookMyTeacher</h2>
                <p class="section-sub">We're not just a tutor directory. We're an end-to-end learning partner that takes
                    ownership of your child's results.</p>
            </div>
            <div class="diff-grid">
                <div class="diff-card anim">
                    <div class="diff-icon" style="background:#e8f5ee;color:var(--green)"><i
                            class="fas fa-shield-check"></i></div>
                    <div>
                        <h4>3-Step Tutor Verification</h4>
                        <p>Every tutor goes through academic qualification review, a live teaching demo, and background
                            check. Only
                            top 5% are accepted.</p>
                    </div>
                </div>
                <div class="diff-card anim">
                    <div class="diff-icon" style="background:#fff3e0;color:#e67e22"><i class="fas fa-home"></i></div>
                    <div>
                        <h4>Genuine Home Tuition</h4>
                        <p>Our flagship offering — verified tutors travel to your home. No other platform in Kerala matches
                            our home
                            tuition network depth.</p>
                    </div>
                </div>
                <div class="diff-card anim">
                    <div class="diff-icon" style="background:#e8eaf6;color:#5c6bc0"><i class="fas fa-rupee-sign"></i>
                    </div>
                    <div>
                        <h4>Transparent Pricing</h4>
                        <p>No registration fees, no hidden charges. Our fee calculator shows you exactly what you'll pay
                            before you
                            book a single session.</p>
                    </div>
                </div>
                <div class="diff-card anim">
                    <div class="diff-icon" style="background:#fce4ec;color:#e91e63"><i class="fab fa-whatsapp"></i></div>
                    <div>
                        <h4>WhatsApp-First Booking</h4>
                        <p>Book, enquire, and communicate entirely via WhatsApp. No complicated apps or forms needed.
                            Response
                            within 10 minutes.</p>
                    </div>
                </div>
                <div class="diff-card anim">
                    <div class="diff-icon" style="background:#e0f2f1;color:#00897b"><i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h4>Real-Time Progress Tracking</h4>
                        <p>Parents get detailed session reports and monthly progress analytics. You always know exactly what
                            your
                            child is learning.</p>
                    </div>
                </div>
                <div class="diff-card anim">
                    <div class="diff-icon" style="background:#e8f5ee;color:var(--green)"><i class="fas fa-sync-alt"></i>
                    </div>
                    <div>
                        <h4>Free Tutor Change Guarantee</h4>
                        <p>Not happy with your tutor? We rematch you instantly — unlimited times, no questions asked, no
                            penalty.
                        </p>
                    </div>
                </div>
                <div class="diff-card anim">
                    <div class="diff-icon" style="background:#fff3e0;color:#e67e22"><i class="fas fa-globe-asia"></i>
                    </div>
                    <div>
                        <h4>Indian Curriculum Specialists</h4>
                        <p>Our tutors are experts in CBSE, ICSE, IB, and State Board curricula — perfect for Indian families
                            anywhere in the world.</p>
                    </div>
                </div>
                <div class="diff-card anim">
                    <div class="diff-icon" style="background:#e8eaf6;color:#5c6bc0"><i class="fas fa-gift"></i></div>
                    <div>
                        <h4>Always Free First Demo</h4>
                        <p>Every student gets a free 30-minute demo session with a verified tutor — no credit card, no
                            commitment
                            required.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ TEAM ═══════════════════════════════════════════════════════ -->
    <section style="background:var(--card)">
        <div style="max-width:1100px;margin:0 auto">
            <div class="center" style="margin-bottom:3rem">
                <span class="section-tag">Our Team</span>
                <h2 class="section-title">The People Behind BookMyTeacher</h2>
                <p class="section-sub">A passionate team of educators, technologists, and learners united by a common
                    mission.
                </p>
            </div>
            <div class="team-grid">
                <div class="team-card anim">
                    <div class="team-av">👨‍💼</div>
                    <div class="team-name">Arun Mohan</div>
                    <div class="team-role">Co-Founder &amp; CEO</div>
                    <p class="team-bio">Former educator with 12 years in the tutoring industry. Passionate about making
                        quality
                        education accessible to every family in Kerala.</p>
                </div>
                <div class="team-card anim">
                    <div class="team-av">👩‍💻</div>
                    <div class="team-name">Divya Krishnan</div>
                    <div class="team-role">Co-Founder &amp; CTO</div>
                    <p class="team-bio">B.Tech from IIT Bombay. Leads the product and technology team. Built BMT's tutor
                        matching
                        algorithm from the ground up.</p>
                </div>
                <div class="team-card anim">
                    <div class="team-av">👨‍🏫</div>
                    <div class="team-name">Suresh Kumar</div>
                    <div class="team-role">Head of Academics</div>
                    <p class="team-bio">MSc Education, 15 years CBSE/ICSE teaching. Oversees tutor quality, curriculum
                        alignment,
                        and student outcome tracking.</p>
                </div>
                <div class="team-card anim">
                    <div class="team-av">👩‍💼</div>
                    <div class="team-name">Fathima Shareef</div>
                    <div class="team-role">Head of Operations – GCC</div>
                    <p class="team-bio">Manages BookMyTeacher's Middle East operations from Dubai. Ensures seamless
                        tutoring
                        experiences for Indian expat families.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ STUDENT TESTIMONIALS ══════════════════════════════════════ -->
    <section style="background:linear-gradient(135deg,var(--dark) 0%,#0f5a2a 100%);position:relative;overflow:hidden">
        <div
            style="position:absolute;inset:0;background-image:radial-gradient(circle,rgba(255,255,255,.04) 1px,transparent 1px);background-size:28px 28px">
        </div>
        <div style="max-width:1100px;margin:0 auto;position:relative;z-index:1">
            <div class="center" style="margin-bottom:3rem">
                <span class="section-tag" style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.9)">What
                    Families
                    Say</span>
                <h2 class="section-title" style="color:#fff">Real Stories, Real Impact</h2>
            </div>
            <div class="testi-strip">
                <div class="ts-card anim" style="background:rgba(255,255,255,.07);border-color:rgba(255,255,255,.12)">
                    <div class="ts-stars">★★★★★</div>
                    <p class="ts-text" style="color:rgba(255,255,255,.8)">"My daughter went from 55% to 91% in Maths
                        within 3
                        months. The home tutor was patient, structured, and always on time. We've already enrolled our son
                        too!"</p>
                    <div class="ts-author">
                        <div class="ts-av">LP</div>
                        <div>
                            <div class="ts-name" style="color:#fff">Lakshmi Pillai</div>
                            <div class="ts-sub">Parent · Class 10 · Kochi</div>
                        </div>
                    </div>
                </div>
                <div class="ts-card anim" style="background:rgba(255,255,255,.07);border-color:rgba(255,255,255,.12)">
                    <div class="ts-stars">★★★★★</div>
                    <p class="ts-text" style="color:rgba(255,255,255,.8)">"As an expat in Qatar, finding an Indian
                        curriculum
                        tutor was impossible. BookMyTeacher's online tutors are brilliant and understand CBSE perfectly.
                        Highly
                        recommended!"</p>
                    <div class="ts-author">
                        <div class="ts-av">RA</div>
                        <div>
                            <div class="ts-name" style="color:#fff">Rahul Ansari</div>
                            <div class="ts-sub">Parent · Class 8 · Doha, Qatar</div>
                        </div>
                    </div>
                </div>
                <div class="ts-card anim" style="background:rgba(255,255,255,.07);border-color:rgba(255,255,255,.12)">
                    <div class="ts-stars">★★★★★</div>
                    <p class="ts-text" style="color:rgba(255,255,255,.8)">"Cleared NEET on my first attempt! The Biology
                        tutor was
                        exceptional — she knew exactly which chapters carry the most marks. I couldn't have done it without
                        BMT."
                    </p>
                    <div class="ts-author">
                        <div class="ts-av">AN</div>
                        <div>
                            <div class="ts-name" style="color:#fff">Anjali Nair</div>
                            <div class="ts-sub">Student · NEET 2024 · Tamil Nadu</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ ACCREDITATION / TRUST ════════════════════════════════════= -->
    <section style="background:var(--bg)">
        <div style="max-width:1100px;margin:0 auto;text-align:center">
            <div class="center" style="margin-bottom:2.5rem">
                <span class="section-tag">Trust &amp; Recognition</span>
                <h2 class="section-title">Trusted by Families Across India &amp; the Gulf</h2>
            </div>
            <div class="accred-strip">
                <div class="accred-badge anim"><i class="fas fa-shield-check"></i> CBSE Curriculum Experts</div>
                <div class="accred-badge anim"><i class="fas fa-star"></i> 4.9★ Average Rating</div>
                <div class="accred-badge anim"><i class="fas fa-users"></i> 2 Lakh+ Students</div>
                <div class="accred-badge anim"><i class="fas fa-home"></i> Kerala's #1 Home Tutoring Platform</div>
                <div class="accred-badge anim"><i class="fas fa-globe"></i> Serving 7+ Countries</div>
                <div class="accred-badge anim"><i class="fas fa-user-check"></i> 500+ Verified Tutors</div>
                <div class="accred-badge anim"><i class="fab fa-whatsapp"></i> WhatsApp Booking &lt;10min</div>
                <div class="accred-badge anim"><i class="fas fa-gift"></i> Free First Demo Always</div>
            </div>
        </div>
    </section>

    <!-- ═══ CTA ════════════════════════════════════════════════════════ -->
    <section class="about-cta">
        <div
            style="position:absolute;inset:0;background-image:radial-gradient(circle,rgba(255,255,255,.05) 1px,transparent 1px);background-size:30px 30px">
        </div>
        <div style="max-width:720px;margin:0 auto;text-align:center;color:#fff;position:relative;z-index:1">
            <div style="font-size:3rem;margin-bottom:1rem">🎓</div>
            <h2 class="section-title" style="color:#fff">Join the BookMyTeacher Family</h2>
            <p style="color:rgba(255,255,255,.72);margin-bottom:2rem;font-size:1rem;line-height:1.8">Whether you're a
                parent
                looking for the right tutor or a teacher wanting to make a bigger impact — BookMyTeacher is for you. Let's
                build
                a brighter future together.</p>
            <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
                <a href="teachers.html" class="btn btn-primary btn-lg"><i class="fas fa-search"></i> Find a Tutor</a>
                <a href="contact.html" class="btn btn-lg"
                    style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.3)"><i
                        class="fas fa-phone"></i> Talk to Us</a>
                <a href="#" class="btn btn-accent btn-lg"><i class="fas fa-chalkboard-teacher"></i> Become a
                    Tutor</a>
                <a href="#" class="store-btn"><i class="fab fa-apple"></i>
                    <div class="store-btn-text">
                        <div class="small">Download on</div>
                        <div class="big">App Store</div>
                    </div>
                </a>
                <a href="#" class="store-btn"><i class="fab fa-google-play"></i>
                    <div class="store-btn-text">
                        <div class="small">Get it on</div>
                        <div class="big">Google Play</div>
                    </div>
                </a>
            </div>

        </div>
    </section>
@endsection
