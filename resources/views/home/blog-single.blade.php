<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Article – BookMyTeacher Blog</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="/web/assets/css/main.css" />
</head>

<body>
  <div class="progress-bar" id="progressBar"></div>

  <!-- NAVBAR -->
  <nav class="navbar" id="navbar">
    <div class="nav-logo"><a href="index.html">
        <img src="/web/assets/logo/BookMyTeacher.png" alt="BookMyTeacher" id="navLogoImg"
          data-light="/web/assets/logo/BookMyTeacher.png" data-dark="/web/assets/logo/BookMyTeacher-white.png">
    </div>
    <div class="nav-links" id="navLinks">
      <a href="index.html" class="active">Home</a>
      <a href="teachers.html">Find Teachers</a>
      <a href="fee-estimate.html">Fee Estimate</a>
      <a href="blog.html">Blog</a>
      <a href="about.html">About</a>
      <a href="contact.html">Contact</a>
    </div>
    <div class="nav-cta" id="navCta">
      <button class="theme-toggle" onclick="toggleTheme()" title="Toggle theme"><i class="fas fa-moon"
          id="themeIcon"></i></button>
      <a href="contact.html" class="btn btn-outline btn-sm">Enquire</a>
      <a href="teachers.html" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Find Tutor</a>
    </div>
    <div class="hamburger" id="hamburger" onclick="toggleMenu()"><span></span><span></span><span></span></div>
  </nav>

  <!-- ARTICLE HERO (populated by JS) -->
  <div class="article-hero">
    <div class="ah-inner">
      <a class="ah-back" onclick="history.back()"><i class="fas fa-arrow-left"></i> Back to Blog</a>
      <div id="ah_cat" class="ah-cat">Loading...</div>
      <div id="ah_emoji" class="ah-emoji"></div>
      <h1 class="ah-title" id="ah_title">Loading article...</h1>
      <div class="ah-meta" id="ah_meta"></div>
    </div>
  </div>

  <div class="article-layout">
    <div class="article-content">
      <!-- SHARE -->
      <div class="share-row">
        <span class="share-label">Share:</span>
        <div class="share-btn" style="background:#1877f2" onclick="shareFB()"><i class="fab fa-facebook-f"></i></div>
        <div class="share-btn" style="background:#1da1f2" onclick="shareTwitter()"><i class="fab fa-twitter"></i></div>
        <div class="share-btn" style="background:#25d366" onclick="shareWA()"><i class="fab fa-whatsapp"></i></div>
        <div class="share-btn" style="background:#0077b5" onclick="shareLinkedIn()"><i class="fab fa-linkedin-in"></i>
        </div>
      </div>
      <!-- ARTICLE BODY -->
      <div class="prose" id="articleBody"></div>
      <!-- AUTHOR -->
      <div class="author-box" id="authorBox"></div>
      <!-- CTA -->
      <div
        style="background:var(--gp);border:1.5px solid var(--border);border-radius:20px;padding:2rem;text-align:center;margin:2rem 0">
        <div style="font-size:2.5rem;margin-bottom:.75rem">🎓</div>
        <h3 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:.5rem">Want to improve your child's
          grades?</h3>
        <p style="color:var(--muted);font-size:.9rem;margin-bottom:1.25rem">Get matched with a verified expert tutor for
          home or online sessions. Free demo available!</p>
        <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap">
          <a href="teachers.html" class="btn btn-primary btn-lg"><i class="fas fa-search"></i> Find a Tutor</a>
          <a href="contact.html" class="btn btn-outline btn-lg"><i class="fas fa-phone"></i> Talk to Us</a>
        </div>
      </div>
    </div>

    <!-- SIDEBAR -->
    <aside class="article-sidebar">
      <div class="toc">
        <div class="toc-title"><i class="fas fa-list" style="color:var(--green)"></i> Table of Contents</div>
        <div id="tocLinks"></div>
      </div>
      <div class="cta-box">
        <div style="font-size:2rem;margin-bottom:.5rem">📚</div>
        <h4>Free Demo Class</h4>
        <p>Book a free 30-minute session with a top tutor today.</p>
        <a href="index.html#enquiry" class="btn btn-accent" style="width:100%;justify-content:center">Book Free Demo</a>
      </div>
      <div style="background:var(--card);border:1.5px solid var(--border);border-radius:var(--r);padding:1.4rem">
        <div class="toc-title"><i class="fas fa-newspaper" style="color:var(--green)"></i> Related Articles</div>
        <div id="relatedPosts"></div>
      </div>
    </aside>
  </div>

  <!-- YOUTUBE TESTIMONIALS SECTION (Horizontal Scroll) -->
  <section style="background:var(--dark);padding:4rem 0;position:relative;overflow:hidden">
    <div
      style="position:absolute;inset:0;background-image:radial-gradient(circle,rgba(255,255,255,.04) 1px,transparent 1px);background-size:28px 28px">
    </div>
    <div style="max-width:1200px;margin:0 auto;padding:0 5%;position:relative;z-index:1">
      <div style="text-align:center;margin-bottom:2.5rem">
        <span class="section-tag" style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.9)">Student
          Stories</span>
        <h2 class="section-title" style="color:#fff">Real Students, Real Results</h2>
        <p style="color:rgba(255,255,255,.65);max-width:480px;margin:0 auto;font-size:.95rem">Watch what our students
          and parents say about their BookMyTeacher experience.</p>
      </div>
      <!-- SCROLL CONTAINER -->
      <div style="position:relative">
        <button class="yt-nav yt-prev" onclick="scrollTestimonials(-1)" style="left:-12px">‹</button>
        <button class="yt-nav yt-next" onclick="scrollTestimonials(1)" style="right:-12px">›</button>
        <div class="yt-scroll-track" id="ytTrack">
          <!-- YouTube iframes -->
          <div class="yt-card">
            <div class="yt-frame-wrap">
              <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ?rel=0&modestbranding=1"
                title="Student Testimonial 1" frameborder="0"
                allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture"
                allowfullscreen loading="lazy"></iframe>
            </div>
            <div class="yt-info"><span class="yt-cat">NEET Success</span>
              <p class="yt-desc">"Cleared NEET in first attempt with BookMyTeacher home tuition"</p>
              <div class="yt-student">Anjali Nair · Tamil Nadu</div>
            </div>
          </div>
          <div class="yt-card">
            <div class="yt-frame-wrap">
              <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ?rel=0&modestbranding=1"
                title="Student Testimonial 2" frameborder="0"
                allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture"
                allowfullscreen loading="lazy"></iframe>
            </div>
            <div class="yt-info"><span class="yt-cat">JEE Rank</span>
              <p class="yt-desc">"Scored 97 percentile in JEE Maths — top 3%!"</p>
              <div class="yt-student">Vivek R · Chennai</div>
            </div>
          </div>
          <div class="yt-card">
            <div class="yt-frame-wrap">
              <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ?rel=0&modestbranding=1" title="Parent Testimonial"
                frameborder="0"
                allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture"
                allowfullscreen loading="lazy"></iframe>
            </div>
            <div class="yt-info"><span class="yt-cat">Parent Review</span>
              <p class="yt-desc">"Best home tutor service — punctual, professional, results-driven"</p>
              <div class="yt-student">Sunita P · Bangalore</div>
            </div>
          </div>
          <div class="yt-card">
            <div class="yt-frame-wrap">
              <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ?rel=0&modestbranding=1"
                title="Online class testimonial" frameborder="0"
                allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture"
                allowfullscreen loading="lazy"></iframe>
            </div>
            <div class="yt-info"><span class="yt-cat">Online Classes</span>
              <p class="yt-desc">"Online tutor from India for my child in Dubai — works perfectly!"</p>
              <div class="yt-student">Mohammed K · Dubai UAE</div>
            </div>
          </div>
          <div class="yt-card">
            <div class="yt-frame-wrap">
              <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ?rel=0&modestbranding=1" title="Board exam success"
                frameborder="0"
                allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture"
                allowfullscreen loading="lazy"></iframe>
            </div>
            <div class="yt-info"><span class="yt-cat">Board Exams</span>
              <p class="yt-desc">"Went from 58% to 91% in CBSE boards after 3 months"</p>
              <div class="yt-student">Ramesh S · Kerala</div>
            </div>
          </div>
        </div>
      </div>
      <!-- DOTS -->
      <div style="display:flex;justify-content:center;gap:.5rem;margin-top:1.5rem" id="ytDots"></div>
    </div>
  </section>

  <style>
    .yt-scroll-track {
      display: flex;
      gap: 1.25rem;
      overflow-x: auto;
      scroll-snap-type: x mandatory;
      scroll-behavior: smooth;
      padding: .5rem .25rem 1rem;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none
    }

    .yt-scroll-track::-webkit-scrollbar {
      display: none
    }

    .yt-card {
      flex: 0 0 340px;
      background: rgba(255, 255, 255, .06);
      border: 1px solid rgba(255, 255, 255, .12);
      border-radius: 20px;
      overflow: hidden;
      scroll-snap-align: start;
      transition: all .3s
    }

    .yt-card:hover {
      background: rgba(255, 255, 255, .1);
      transform: translateY(-4px)
    }

    .yt-frame-wrap {
      position: relative;
      width: 100%;
      padding-top: 56.25%;
      background: #000
    }

    .yt-frame-wrap iframe {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      border: none
    }

    .yt-info {
      padding: 1.1rem
    }

    .yt-cat {
      background: rgba(29, 185, 84, .2);
      color: var(--gl);
      font-size: .72rem;
      font-weight: 700;
      padding: .22rem .65rem;
      border-radius: 100px;
      text-transform: uppercase;
      letter-spacing: .06em
    }

    .yt-desc {
      color: rgba(255, 255, 255, .85);
      font-size: .88rem;
      line-height: 1.55;
      margin: .6rem 0 .4rem;
      font-style: italic
    }

    .yt-student {
      font-size: .76rem;
      color: rgba(255, 255, 255, .5)
    }

    .yt-nav {
      position: absolute;
      top: 50%;
      transform: translateY(-80%);
      z-index: 10;
      width: 42px;
      height: 42px;
      background: rgba(255, 255, 255, .15);
      border: 1px solid rgba(255, 255, 255, .25);
      color: #fff;
      border-radius: 50%;
      cursor: pointer;
      font-size: 1.4rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all .2s;
      backdrop-filter: blur(8px)
    }

    .yt-nav:hover {
      background: var(--green);
      border-color: var(--green)
    }

    .yt-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .2);
      cursor: pointer;
      transition: all .2s
    }

    .yt-dot.active {
      background: var(--gl);
      width: 22px;
      border-radius: 4px
    }
  </style>


  <footer>
    <div style="max-width:1200px;margin:0 auto">
      <div class="footer-grid">
        <div>
          <div class="footer-logo"><img
              src="data:image/png;base64,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"
              alt="BookMyTeacher"></div>
          <p class="footer-desc">India's leading home &amp; online tutoring platform. Expert tutors for every subject,
            every grade. Serving 2L+ students across India and the Middle East.</p>
          <div class="footer-social">
            <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-btn"><i class="fab fa-youtube"></i></a>
            <a href="#" class="social-btn"><i class="fab fa-whatsapp"></i></a>
          </div>
        </div>
        <div class="footer-col">
          <h4>Platform</h4>
          <div class="footer-links">
            <a href="teachers.html"><i class="fas fa-chevron-right" style="font-size:.65rem"></i> Find Teachers</a>
            <a href="index.html#subjects"><i class="fas fa-chevron-right" style="font-size:.65rem"></i> Subjects</a>
            <a href="index.html#pricing"><i class="fas fa-chevron-right" style="font-size:.65rem"></i> Pricing</a>
            <a href="fee-estimate.html">Fee Estimate</a><a href="about.html">About</a><a href="blog.html"><i
                class="fas fa-chevron-right" style="font-size:.65rem"></i> Blog</a>
          </div>
        </div>
        <div class="footer-col">
          <h4>Company</h4>
          <div class="footer-links">
            <a href="contact.html"><i class="fas fa-chevron-right" style="font-size:.65rem"></i> Contact Us</a>
            <a href="#"><i class="fas fa-chevron-right" style="font-size:.65rem"></i> About Us</a>
            <a href="#"><i class="fas fa-chevron-right" style="font-size:.65rem"></i> Become a Tutor</a>
            <a href="index.html#faq"><i class="fas fa-chevron-right" style="font-size:.65rem"></i> FAQ</a>
          </div>
        </div>
        <div class="footer-col">
          <h4>Contact</h4>
          <div class="footer-links" style="gap:.7rem">
            <span style="opacity:.7;font-size:.8rem;display:flex;gap:.5rem"><i class="fas fa-phone"
                style="color:var(--gl);margin-top:.1rem"></i>+91 8594 000 413</span>
            <span style="opacity:.7;font-size:.8rem;display:flex;gap:.5rem"><i class="fas fa-envelope"
                style="color:var(--gl);margin-top:.1rem"></i><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                data-cfemail="9ffcf0f1ebfefcebdffdf0f0f4f2e6ebfafefcf7faedb1fcf0f2">[email&#160;protected]</a></span>
            <span style="opacity:.7;font-size:.8rem;display:flex;gap:.5rem"><i class="fas fa-map-marker-alt"
                style="color:var(--gl);margin-top:.1rem"></i>Kozhikode, Kerala, India</span>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <span>© 2025 BookMyTeacher. All rights reserved.</span>
        <div style="display:flex;gap:1.2rem"><a href="#">Privacy</a><a href="#">Terms</a><a href="#">Refund Policy</a>
        </div>
      </div>
    </div>
  </footer>

  <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
  <script>
    // THEME
    const savedTheme = localStorage.getItem('bmt_theme') || 'light';
    applyTheme(savedTheme);
    function applyTheme(t) {
      document.documentElement.setAttribute('data-theme', t);
      localStorage.setItem('bmt_theme', t);
      const icon = t === 'dark' ? 'fa-sun' : 'fa-moon';
      document.querySelectorAll('#themeIcon,#themeIconMob').forEach(el => { if (el) { el.className = 'fas ' + icon } });
      // Swap logo
      const img = document.getElementById('navLogoImg');
      if (img) { img.src = t === 'dark' ? img.dataset.dark : img.dataset.light; }
    }
    function toggleTheme() {
      const cur = document.documentElement.getAttribute('data-theme') || 'light';
      applyTheme(cur === 'dark' ? 'light' : 'dark');
    }
    // NAV
    window.addEventListener('scroll', () => document.getElementById('navbar')?.classList.toggle('scrolled', scrollY > 50));
    function toggleMenu() {
      document.getElementById('navLinks').classList.toggle('open');
    }
    // SCROLL ANIMATE
    const obs = new IntersectionObserver(entries => entries.forEach(e => {
      if (e.isIntersecting) { e.target.style.opacity = '1'; e.target.style.transform = 'translateY(0)'; }
    }), { threshold: .08 });
    document.querySelectorAll('.anim').forEach(el => {
      el.style.opacity = '0'; el.style.transform = 'translateY(28px)';
      el.style.transition = 'opacity .55s ease,transform .55s ease';
      obs.observe(el);
    });
  </script>
  <script>
    const POSTS_DATA = [{ 'id': 1, 'title': '10 Proven Techniques to Score 90%+ in CBSE Board Exams', 'cat': 'Study Tips', 'excerpt': "Board exams are stressful, but with the right strategy they become manageable. From time-table planning to revision cycles — here's the complete playbook used by our top-scoring students.", 'author': 'Rahul Menon', 'date': 'March 12, 2025', 'read': '7 min', 'img_color': 'linear-gradient(135deg,#0f7a3c,#1db954)', 'emoji': '📚' }, { 'id': 2, 'title': 'Complete NEET 2025 Biology Revision Strategy — Chapter-wise Weightage', 'cat': 'NEET Prep', 'excerpt': 'Biology makes up 50% of NEET. Our specialist tutor Priya Krishnan breaks down which chapters to prioritise and how to cover them in the last 60 days before the exam.', 'author': 'Priya Krishnan', 'date': 'February 28, 2025', 'read': '9 min', 'img_color': 'linear-gradient(135deg,#6c63ff,#a855f7)', 'emoji': '🧬' }, { 'id': 3, 'title': 'Home Tuition vs Online Classes: Which Is Better for Your Child?', 'cat': 'Home Tuition', 'excerpt': "A detailed comparison of both modes — covering learning effectiveness, cost, convenience, and long-term impact. Plus how to choose the right mode based on your child's learning style.", 'author': 'BMT Team', 'date': 'February 15, 2025', 'read': '6 min', 'img_color': 'linear-gradient(135deg,#f59e0b,#ef4444)', 'emoji': '🏠' }, { 'id': 4, 'title': 'JEE Mains 2025: Last 30-Day Strategy From IIT Alumni Tutors', 'cat': 'JEE Prep', 'excerpt': 'With a month to go, every hour counts. Our IIT alumni tutors share the exact 30-day sprint plan that helps students gain 30–50 percentile points in the final stretch.', 'author': 'Mohammed Farouk', 'date': 'January 30, 2025', 'read': '11 min', 'img_color': 'linear-gradient(135deg,#0ea5e9,#0f7a3c)', 'emoji': '🎯' }, { 'id': 5, 'title': "How to Find the Right Tutor for Your Child — A Parent's Complete Guide", 'cat': 'Parenting', 'excerpt': 'Not all tutors are alike. Learn what qualifications to look for, how to assess teaching style compatibility, and what questions to ask before finalising a home or online tutor.', 'author': 'BMT Team', 'date': 'January 18, 2025', 'read': '8 min', 'img_color': 'linear-gradient(135deg,#10b981,#059669)', 'emoji': '👨\u200d👩\u200d👧' }, { 'id': 6, 'title': 'The Pomodoro Technique: How 25-Minute Study Blocks Boost Retention', 'cat': 'Study Tips', 'excerpt': "Science-backed time management for students. Our tutors have seen this technique improve focus and retention dramatically. Here's exactly how to implement it for school subjects.", 'author': 'Arjun Nair', 'date': 'January 5, 2025', 'read': '5 min', 'img_color': 'linear-gradient(135deg,#f97316,#ea580c)', 'emoji': '⏱️' }, { 'id': 7, 'title': "How BookMyTeacher's Interactive Whiteboard Makes Online Classes Better", 'cat': 'Technology', 'excerpt': "Traditional video calls aren't enough for effective tutoring. Learn how our built-in whiteboard, screen sharing, and session recording transform online learning.", 'author': 'Sneha Pillai', 'date': 'December 20, 2024', 'read': '6 min', 'img_color': 'linear-gradient(135deg,#8b5cf6,#ec4899)', 'emoji': '💻' }, { 'id': 8, 'title': 'Best CBSE Schools in Kochi and How to Choose the Right Tutor to Complement', 'cat': 'Kerala Education', 'excerpt': "A look at top CBSE schools across Kochi and how finding the right home tutor that matches your school's curriculum can make a significant difference in results.", 'author': 'BMT Team', 'date': 'December 10, 2024', 'read': '7 min', 'img_color': 'linear-gradient(135deg,#14b8a6,#0d9488)', 'emoji': '🏫' }, { 'id': 9, 'title': 'Indian Curriculum Tutors in Dubai: What Parents Need to Know', 'cat': 'Middle East', 'excerpt': 'For Indian expat families in UAE, finding tutors who understand CBSE and ICSE curriculum can be challenging. BMT solves this with online tutoring that bridges the gap.', 'author': 'BMT Team', 'date': 'November 28, 2024', 'read': '5 min', 'img_color': 'linear-gradient(135deg,#f43f5e,#be123c)', 'emoji': '🇦🇪' }];
    const AUTHORS = {
      "Rahul Menon": { emoji: "👨‍🏫", role: "Mathematics & Physics Tutor", bio: "8 years of teaching experience. IIT-trained educator passionate about making complex concepts accessible to every student." },
      "Priya Krishnan": { emoji: "👩‍🏫", role: "NEET Biology Specialist", bio: "MSc Biochemistry. NEET specialist with 6 years of experience and 245+ successful students." },
      "Arjun Nair": { emoji: "🧑‍🏫", role: "English & Social Studies Expert", bio: "MA English Literature. Passionate about making social subjects engaging through storytelling and narrative teaching." },
      "Sneha Pillai": { emoji: "👩‍💻", role: "Computer Science & Coding Expert", bio: "B.Tech CS from IIT Bombay. Software engineer turned educator, making programming accessible to school students." },
      "Mohammed Farouk": { emoji: "🧑‍💻", role: "JEE Mathematics Champion", bio: "IIT Delhi alumnus with 11 years of JEE coaching. Students have achieved top-1000 national ranks." },
      "BMT Team": { emoji: "📚", role: "BookMyTeacher Editorial", bio: "Our team of education experts and experienced tutors share insights on effective learning, exam strategy, and career planning." },
    };

    const ARTICLE_CONTENT = `
<h2>Introduction</h2>
<p>Getting excellent marks in board exams doesn't require studying 18 hours a day. What it requires is smart, structured, consistent preparation — combined with the right guidance from experienced tutors. In this comprehensive guide, we share the exact strategies our top-performing students have used to achieve 90%+ consistently.</p>

<div class="highlight-box">
  <h4>📌 Quick Stats</h4>
  <p>Students who follow a structured study plan with regular tutor check-ins score <strong>23% higher</strong> on average compared to those who study alone without guidance.</p>
</div>

<h2>1. Build a Realistic Study Timetable</h2>
<p>The foundation of exam success is a well-planned timetable. Most students make the mistake of creating an overly ambitious schedule they can never follow. Instead, start with what is actually achievable.</p>
<ul>
  <li>Allocate 45–60 minutes per subject per day, not more</li>
  <li>Include dedicated revision slots every 3 days</li>
  <li>Keep at least one hour of free time daily for mental recovery</li>
  <li>Schedule your hardest subject when your focus is sharpest (often mornings)</li>
</ul>

<h2>2. Use Active Recall, Not Passive Reading</h2>
<p>Passive re-reading is one of the least effective study methods. Active recall — testing yourself on what you've just read — dramatically improves retention.</p>
<blockquote>"After every chapter, close the book and write down everything you remember. What you can't recall is what you need to study again." — Rahul Menon, Mathematics Tutor</blockquote>

<h2>3. The 5-Subject Rotation Method</h2>
<p>Studying the same subject for too long causes diminishing returns. Our tutors recommend rotating between subjects every 45–50 minutes to maintain high concentration and prevent burnout.</p>
<div class="tips-grid">
  <div class="tip-card"><div class="tip-num">01</div><div class="tip-title">Maths — 50 min</div><div class="tip-desc">Focus on problem-solving, not theory reading</div></div>
  <div class="tip-card"><div class="tip-num">02</div><div class="tip-title">Science — 50 min</div><div class="tip-desc">Diagrams, definitions, experiment steps</div></div>
  <div class="tip-card"><div class="tip-num">03</div><div class="tip-title">Language — 40 min</div><div class="tip-desc">Grammar rules, writing practice, comprehension</div></div>
  <div class="tip-card"><div class="tip-num">04</div><div class="tip-title">Social Studies — 45 min</div><div class="tip-desc">Maps, timelines, cause-and-effect relationships</div></div>
</div>

<h2>4. Past Paper Practice — The #1 Exam Strategy</h2>
<p>Nothing prepares you for board exams better than solving past question papers under timed conditions. This builds speed, reveals weak areas, and makes you familiar with the examiner's question style.</p>
<ul>
  <li>Start solving past papers at least 8 weeks before exams</li>
  <li>Use official CBSE/ICSE sample papers from the last 5 years</li>
  <li>Correct your paper immediately and note every mistake</li>
  <li>Re-solve questions you got wrong within 24 hours</li>
</ul>

<h2>5. Get a Tutor for Weak Subjects</h2>
<p>Every student has one or two subjects that feel like a brick wall. Rather than hoping it will improve on its own, the fastest solution is 1-on-1 tutoring targeted at that specific subject.</p>
<p>A good tutor doesn't just re-explain what the textbook says — they identify exactly where your understanding breaks down and rebuild from that point. Students who add targeted tutor sessions for their weakest subject typically see a 15–25 percentage point improvement within 6–8 weeks.</p>

<h2>Conclusion</h2>
<p>High scores in board exams are absolutely achievable with the right approach. Build your timetable, use active learning techniques, practice past papers, and don't hesitate to get expert help for subjects you find difficult. At BookMyTeacher, we have verified tutors who specialise in exactly this — helping students go from average to exceptional.</p>
`;

    function loadArticle() {
      const params = new URLSearchParams(window.location.search);
      const id = parseInt(params.get('id')) || 1;
      const post = POSTS_DATA.find(p => p.id === id) || POSTS_DATA[0];
      document.title = post.title + ' – BMT Blog';
      document.getElementById('ah_cat').textContent = post.cat;
      document.getElementById('ah_emoji').textContent = post.emoji;
      document.getElementById('ah_emoji').style.background = post.img_color;
      document.getElementById('ah_title').textContent = post.title;
      document.getElementById('ah_meta').innerHTML = `
    <span><i class="fas fa-user"></i>${post.author}</span>
    <span><i class="fas fa-calendar"></i>${post.date}</span>
    <span><i class="fas fa-clock"></i>${post.read} read</span>`;
      document.getElementById('articleBody').innerHTML = ARTICLE_CONTENT;
      // Author
      const a = AUTHORS[post.author] || AUTHORS['BMT Team'];
      document.getElementById('authorBox').innerHTML = `
    <div class="author-av">${a.emoji}</div>
    <div><div class="author-name">${post.author}</div><div class="author-role">${a.role}</div><div class="author-bio">${a.bio}</div></div>`;
      // TOC
      const headings = [...document.querySelectorAll('.prose h2')];
      document.getElementById('tocLinks').innerHTML = headings.map((h, i) =>
        `<div class="toc-link" onclick="h${i}.scrollIntoView({behavior:'smooth'})" id="toc${i}">${h.textContent}</div>`).join('');
      headings.forEach((h, i) => h.id = 'h' + i);
      // Related
      const related = POSTS_DATA.filter(p => p.id !== id && p.cat === post.cat).slice(0, 3);
      const rel2 = related.length < 3 ? [...related, ...POSTS_DATA.filter(p => p.id !== id && !related.includes(p)).slice(0, 3 - related.length)] : related;
      document.getElementById('relatedPosts').innerHTML = rel2.map(p => `
    <div class="related-card" onclick="location.href='blog-single.html?id=${p.id}'">
      <div class="rc-thumb" style="background:${p.img_color}">${p.emoji}</div>
      <div><div class="rc-cat">${p.cat}</div><div class="rc-title">${p.title.slice(0, 65)}...</div></div>
    </div>`).join('');
    }

    // Progress bar
    window.addEventListener('scroll', () => {
      const total = document.body.scrollHeight - window.innerHeight;
      document.getElementById('progressBar').style.width = (scrollY / total * 100) + '%';
    });

    // YT scroll
    function scrollTestimonials(dir) {
      const track = document.getElementById('ytTrack');
      track.scrollBy({ left: dir * 360, behavior: 'smooth' });
      updateDots();
    }
    function updateDots() {
      const track = document.getElementById('ytTrack');
      const cards = track.querySelectorAll('.yt-card');
      const idx = Math.round(track.scrollLeft / 360);
      document.querySelectorAll('.yt-dot').forEach((d, i) => d.classList.toggle('active', i === idx));
    }
    window.addEventListener('DOMContentLoaded', () => {
      loadArticle();
      const cards = document.querySelectorAll('.yt-card');
      const dotsEl = document.getElementById('ytDots');
      dotsEl.innerHTML = [...cards].map((_, i) => `<div class="yt-dot${i === 0 ? ' active' : ''}"></div>`).join('');
      document.getElementById('ytTrack').addEventListener('scroll', updateDots);
    });

    function shareFB() { window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(location.href), '_blank'); }
    function shareTwitter() { window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(location.href), '_blank'); }
    function shareWA() { window.open('https://wa.me/?te