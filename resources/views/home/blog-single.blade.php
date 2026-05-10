@extends('home.layouts')
@section('content')

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
      const rel2 = related.length <script 3 ? [...related, ...POSTS_DATA.filter(p => p.id !== id && !related.includes(p)).slice(0, 3 - related.length)] : related;
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
    // function shareWA() { window.open('https://wa.me/?te

    </script>
    @endsection
