@extends('home.layouts')
@section('content')
  <!-- HERO -->
  <div class="blog-hero">
    <div class="bh-inner">
      <span class="section-tag" style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.9)">Our Blog</span>
      <h1>Learning Insights &amp;<br><span>Expert Advice</span></h1>
      <p>Study tips, exam strategies, parenting guides, and more from our expert tutors and education specialists.</p>
    </div>
  </div>

  <!-- CONTROLS -->
  <div class="blog-controls">
    <div class="bc-inner">
      <div class="blog-search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="blogSearch" placeholder="Search articles..." oninput="filterPosts()">
      </div>
      <div class="cat-pills" id="catPills">
        <span class="cat-pill active" onclick="filterCat(this,'All')">All</span><span class="cat-pill"
          onclick="filterCat(this,'Study Tips')">Study Tips</span><span class="cat-pill"
          onclick="filterCat(this,'NEET Prep')">NEET Prep</span><span class="cat-pill"
          onclick="filterCat(this,'JEE Prep')">JEE Prep</span><span class="cat-pill"
          onclick="filterCat(this,'Home Tuition')">Home Tuition</span><span class="cat-pill"
          onclick="filterCat(this,'Parenting')">Parenting</span><span class="cat-pill"
          onclick="filterCat(this,'Technology')">Technology</span><span class="cat-pill"
          onclick="filterCat(this,'Kerala Education')">Kerala Education</span><span class="cat-pill"
          onclick="filterCat(this,'Middle East')">Middle East</span>
      </div>
    </div>
  </div>

  <div class="blog-layout">
    <div>
      <!-- FEATURED -->
      <div id="featuredSection">

        <div class="blog-featured anim" onclick="location.href='blog-single.html?id=1'">
          <div class="bf-img" style="background:linear-gradient(135deg,#0f7a3c,#1db954)"><span
              class="bf-emoji">📚</span></div>
          <div class="bf-body">
            <span class="blog-cat">Study Tips</span>
            <h2 class="bf-title">10 Proven Techniques to Score 90%+ in CBSE Board Exams</h2>
            <p class="bf-excerpt">Board exams are stressful, but with the right strategy they become manageable. From
              time-table planning to revision cycles — here's the complete playbook used by our top-scoring students.
            </p>
            <div class="bf-meta">
              <span><i class="fas fa-user"></i> Rahul Menon</span>
              <span><i class="fas fa-calendar"></i> March 12, 2025</span>
              <span><i class="fas fa-clock"></i> 7 min read</span>
            </div>
            <a href="blog-single.html?id=1" class="btn btn-primary" style="margin-top:1.25rem">Read Article <i
                class="fas fa-arrow-right"></i></a>
          </div>
        </div>
        <div class="blog-featured anim" onclick="location.href='blog-single.html?id=2'">
          <div class="bf-img" style="background:linear-gradient(135deg,#6c63ff,#a855f7)"><span
              class="bf-emoji">🧬</span></div>
          <div class="bf-body">
            <span class="blog-cat">NEET Prep</span>
            <h2 class="bf-title">Complete NEET 2025 Biology Revision Strategy — Chapter-wise Weightage</h2>
            <p class="bf-excerpt">Biology makes up 50% of NEET. Our specialist tutor Priya Krishnan breaks down which
              chapters to prioritise and how to cover them in the last 60 days before the exam.</p>
            <div class="bf-meta">
              <span><i class="fas fa-user"></i> Priya Krishnan</span>
              <span><i class="fas fa-calendar"></i> February 28, 2025</span>
              <span><i class="fas fa-clock"></i> 9 min read</span>
            </div>
            <a href="blog-single.html?id=2" class="btn btn-primary" style="margin-top:1.25rem">Read Article <i
                class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
      <!-- GRID -->
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem">
        <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.05rem">Latest Articles</div>
        <span id="postCount" style="font-size:.85rem;color:var(--muted)"></span>
      </div>
      <div class="blog-grid" id="blogGrid">

        <div class="blog-card anim" data-cat="Home Tuition" onclick="location.href='blog-single.html?id=3'">
          <div class="bc-img" style="background:linear-gradient(135deg,#f59e0b,#ef4444)"><span
              class="bc-emoji">🏠</span></div>
          <div class="bc-body">
            <span class="blog-cat">Home Tuition</span>
            <h3 class="bc-title">Home Tuition vs Online Classes: Which Is Better for Your Child?</h3>
            <p class="bc-excerpt">A detailed comparison of both modes — covering learning effectiveness, cost,
              convenience, and long-term impact. Plus how to choose the right mode based on your child's learning style.
            </p>
            <div class="bc-meta">
              <span><i class="fas fa-user"></i> BMT Team</span>
              <span><i class="fas fa-clock"></i> 6 min</span>
            </div>
          </div>
        </div>
        <div class="blog-card anim" data-cat="JEE Prep" onclick="location.href='blog-single.html?id=4'">
          <div class="bc-img" style="background:linear-gradient(135deg,#0ea5e9,#0f7a3c)"><span
              class="bc-emoji">🎯</span></div>
          <div class="bc-body">
            <span class="blog-cat">JEE Prep</span>
            <h3 class="bc-title">JEE Mains 2025: Last 30-Day Strategy From IIT Alumni Tutors</h3>
            <p class="bc-excerpt">With a month to go, every hour counts. Our IIT alumni tutors share the exact 30-day
              sprint plan that helps students gain 30–50 percentile points in the final stretch.</p>
            <div class="bc-meta">
              <span><i class="fas fa-user"></i> Mohammed Farouk</span>
              <span><i class="fas fa-clock"></i> 11 min</span>
            </div>
          </div>
        </div>
        <div class="blog-card anim" data-cat="Parenting" onclick="location.href='blog-single.html?id=5'">
          <div class="bc-img" style="background:linear-gradient(135deg,#10b981,#059669)"><span
              class="bc-emoji">👨‍👩‍👧</span></div>
          <div class="bc-body">
            <span class="blog-cat">Parenting</span>
            <h3 class="bc-title">How to Find the Right Tutor for Your Child — A Parent's Complete Guide</h3>
            <p class="bc-excerpt">Not all tutors are alike. Learn what qualifications to look for, how to assess
              teaching style compatibility, and what questions to ask before finalising a home or online tutor.</p>
            <div class="bc-meta">
              <span><i class="fas fa-user"></i> BMT Team</span>
              <span><i class="fas fa-clock"></i> 8 min</span>
            </div>
          </div>
        </div>
        <div class="blog-card anim" data-cat="Study Tips" onclick="location.href='blog-single.html?id=6'">
          <div class="bc-img" style="background:linear-gradient(135deg,#f97316,#ea580c)"><span
              class="bc-emoji">⏱️</span></div>
          <div class="bc-body">
            <span class="blog-cat">Study Tips</span>
            <h3 class="bc-title">The Pomodoro Technique: How 25-Minute Study Blocks Boost Retention</h3>
            <p class="bc-excerpt">Science-backed time management for students. Our tutors have seen this technique
              improve focus and retention dramatically. Here's exactly how to implement it for school subjects.</p>
            <div class="bc-meta">
              <span><i class="fas fa-user"></i> Arjun Nair</span>
              <span><i class="fas fa-clock"></i> 5 min</span>
            </div>
          </div>
        </div>
        <div class="blog-card anim" data-cat="Technology" onclick="location.href='blog-single.html?id=7'">
          <div class="bc-img" style="background:linear-gradient(135deg,#8b5cf6,#ec4899)"><span
              class="bc-emoji">💻</span></div>
          <div class="bc-body">
            <span class="blog-cat">Technology</span>
            <h3 class="bc-title">How BookMyTeacher's Interactive Whiteboard Makes Online Classes Better</h3>
            <p class="bc-excerpt">Traditional video calls aren't enough for effective tutoring. Learn how our built-in
              whiteboard, screen sharing, and session recording transform online learning.</p>
            <div class="bc-meta">
              <span><i class="fas fa-user"></i> Sneha Pillai</span>
              <span><i class="fas fa-clock"></i> 6 min</span>
            </div>
          </div>
        </div>
        <div class="blog-card anim" data-cat="Kerala Education" onclick="location.href='blog-single.html?id=8'">
          <div class="bc-img" style="background:linear-gradient(135deg,#14b8a6,#0d9488)"><span
              class="bc-emoji">🏫</span></div>
          <div class="bc-body">
            <span class="blog-cat">Kerala Education</span>
            <h3 class="bc-title">Best CBSE Schools in Kochi and How to Choose the Right Tutor to Complement</h3>
            <p class="bc-excerpt">A look at top CBSE schools across Kochi and how finding the right home tutor that
              matches your school's curriculum can make a significant difference in results.</p>
            <div class="bc-meta">
              <span><i class="fas fa-user"></i> BMT Team</span>
              <span><i class="fas fa-clock"></i> 7 min</span>
            </div>
          </div>
        </div>
        <div class="blog-card anim" data-cat="Middle East" onclick="location.href='blog-single.html?id=9'">
          <div class="bc-img" style="background:linear-gradient(135deg,#f43f5e,#be123c)"><span
              class="bc-emoji">🇦🇪</span></div>
          <div class="bc-body">
            <span class="blog-cat">Middle East</span>
            <h3 class="bc-title">Indian Curriculum Tutors in Dubai: What Parents Need to Know</h3>
            <p class="bc-excerpt">For Indian expat families in UAE, finding tutors who understand CBSE and ICSE
              curriculum can be challenging. BMT solves this with online tutoring that bridges the gap.</p>
            <div class="bc-meta">
              <span><i class="fas fa-user"></i> BMT Team</span>
              <span><i class="fas fa-clock"></i> 5 min</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- SIDEBAR -->
    <aside class="blog-sidebar">
      <div class="sidebar-widget">
        <div class="sw-title"><i class="fas fa-fire"></i> Popular Posts</div>
        <div class="recent-post" onclick="location.href='blog-single.html?id=1'">
          <div class="rp-thumb" style="background:linear-gradient(135deg,#0f7a3c,#1db954)">📚</div>
          <div>
            <div class="rp-title">10 Proven Techniques to Score 90%+ in CBSE Board Exams...</div>
            <div class="rp-date">March 12, 2025</div>
          </div>
        </div>
        <div class="recent-post" onclick="location.href='blog-single.html?id=2'">
          <div class="rp-thumb" style="background:linear-gradient(135deg,#6c63ff,#a855f7)">🧬</div>
          <div>
            <div class="rp-title">Complete NEET 2025 Biology Revision Strategy — Chapter-wise ...</div>
            <div class="rp-date">February 28, 2025</div>
          </div>
        </div>
        <div class="recent-post" onclick="location.href='blog-single.html?id=3'">
          <div class="rp-thumb" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">🏠</div>
          <div>
            <div class="rp-title">Home Tuition vs Online Classes: Which Is Better for Your Chi...</div>
            <div class="rp-date">February 15, 2025</div>
          </div>
        </div>
        <div class="recent-post" onclick="location.href='blog-single.html?id=4'">
          <div class="rp-thumb" style="background:linear-gradient(135deg,#0ea5e9,#0f7a3c)">🎯</div>
          <div>
            <div class="rp-title">JEE Mains 2025: Last 30-Day Strategy From IIT Alumni Tutors...</div>
            <div class="rp-date">January 30, 2025</div>
          </div>
        </div>
        <div class="recent-post" onclick="location.href='blog-single.html?id=5'">
          <div class="rp-thumb" style="background:linear-gradient(135deg,#10b981,#059669)">👨‍👩‍👧</div>
          <div>
            <div class="rp-title">How to Find the Right Tutor for Your Child — A Parent's Comp...</div>
            <div class="rp-date">January 18, 2025</div>
          </div>
        </div>
      </div>
      <div class="sidebar-widget">
        <div class="sw-title"><i class="fas fa-tags"></i> Topics</div>
        <div class="tag-cloud">
          <span class="tag-cloud-item" onclick="filterCat(null,'Study Tips')">Study Tips</span><span
            class="tag-cloud-item" onclick="filterCat(null,'NEET Prep')">NEET Prep</span><span class="tag-cloud-item"
            onclick="filterCat(null,'JEE Prep')">JEE Prep</span><span class="tag-cloud-item"
            onclick="filterCat(null,'Home Tuition')">Home Tuition</span><span class="tag-cloud-item"
            onclick="filterCat(null,'Parenting')">Parenting</span><span class="tag-cloud-item"
            onclick="filterCat(null,'Technology')">Technology</span><span class="tag-cloud-item"
            onclick="filterCat(null,'Kerala Education')">Kerala Education</span><span class="tag-cloud-item"
            onclick="filterCat(null,'Middle East')">Middle East</span>
        </div>
      </div>
      <div class="sidebar-widget">
        <div class="sw-title"><i class="fas fa-envelope"></i> Newsletter</div>
        <p style="font-size:.83rem;color:var(--muted);margin-bottom:1rem">Get study tips and exam strategies in your
          inbox.</p>
        <div class="newsletter-form">
          <input type="email" placeholder="Your email address">
          <button class="btn btn-primary" style="justify-content:center">Subscribe <i
              class="fas fa-paper-plane"></i></button>
        </div>
      </div>
      <div class="sidebar-widget" style="background:linear-gradient(135deg,var(--dark),#0f5a2a);border:none">
        <div style="color:#fff;text-align:center">
          <div style="font-size:2.5rem;margin-bottom:.75rem">🎓</div>
          <div style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:.5rem">Find a Top Tutor</div>
          <p style="font-size:.82rem;opacity:.7;margin-bottom:1.1rem">500+ verified tutors. Home &amp; Online.</p>
          <a href="teachers.html" class="btn btn-accent" style="width:100%;justify-content:center">Browse Tutors</a>
        </div>
      </div>
    </aside>
  </div>


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
    const ALL_POSTS = [{ 'id': 1, 'title': '10 Proven Techniques to Score 90%+ in CBSE Board Exams', 'cat': 'Study Tips', 'excerpt': "Board exams are stressful, but with the right strategy they become manageable. From time-table planning to revision cycles — here's the complete playbook used by our top-scoring students.", 'author': 'Rahul Menon', 'date': 'March 12, 2025', 'read': '7 min', 'img_color': 'linear-gradient(135deg,#0f7a3c,#1db954)', 'emoji': '📚', 'featured': True }, { 'id': 2, 'title': 'Complete NEET 2025 Biology Revision Strategy — Chapter-wise Weightage', 'cat': 'NEET Prep', 'excerpt': 'Biology makes up 50% of NEET. Our specialist tutor Priya Krishnan breaks down which chapters to prioritise and how to cover them in the last 60 days before the exam.', 'author': 'Priya Krishnan', 'date': 'February 28, 2025', 'read': '9 min', 'img_color': 'linear-gradient(135deg,#6c63ff,#a855f7)', 'emoji': '🧬', 'featured': True }, { 'id': 3, 'title': 'Home Tuition vs Online Classes: Which Is Better for Your Child?', 'cat': 'Home Tuition', 'excerpt': "A detailed comparison of both modes — covering learning effectiveness, cost, convenience, and long-term impact. Plus how to choose the right mode based on your child's learning style.", 'author': 'BMT Team', 'date': 'February 15, 2025', 'read': '6 min', 'img_color': 'linear-gradient(135deg,#f59e0b,#ef4444)', 'emoji': '🏠', 'featured': False }, { 'id': 4, 'title': 'JEE Mains 2025: Last 30-Day Strategy From IIT Alumni Tutors', 'cat': 'JEE Prep', 'excerpt': 'With a month to go, every hour counts. Our IIT alumni tutors share the exact 30-day sprint plan that helps students gain 30–50 percentile points in the final stretch.', 'author': 'Mohammed Farouk', 'date': 'January 30, 2025', 'read': '11 min', 'img_color': 'linear-gradient(135deg,#0ea5e9,#0f7a3c)', 'emoji': '🎯', 'featured': False }, { 'id': 5, 'title': "How to Find the Right Tutor for Your Child — A Parent's Complete Guide", 'cat': 'Parenting', 'excerpt': 'Not all tutors are alike. Learn what qualifications to look for, how to assess teaching style compatibility, and what questions to ask before finalising a home or online tutor.', 'author': 'BMT Team', 'date': 'January 18, 2025', 'read': '8 min', 'img_color': 'linear-gradient(135deg,#10b981,#059669)', 'emoji': '👨\u200d👩\u200d👧', 'featured': False }, { 'id': 6, 'title': 'The Pomodoro Technique: How 25-Minute Study Blocks Boost Retention', 'cat': 'Study Tips', 'excerpt': "Science-backed time management for students. Our tutors have seen this technique improve focus and retention dramatically. Here's exactly how to implement it for school subjects.", 'author': 'Arjun Nair', 'date': 'January 5, 2025', 'read': '5 min', 'img_color': 'linear-gradient(135deg,#f97316,#ea580c)', 'emoji': '⏱️', 'featured': False }, { 'id': 7, 'title': "How BookMyTeacher's Interactive Whiteboard Makes Online Classes Better", 'cat': 'Technology', 'excerpt': "Traditional video calls aren't enough for effective tutoring. Learn how our built-in whiteboard, screen sharing, and session recording transform online learning.", 'author': 'Sneha Pillai', 'date': 'December 20, 2024', 'read': '6 min', 'img_color': 'linear-gradient(135deg,#8b5cf6,#ec4899)', 'emoji': '💻', 'featured': False }, { 'id': 8, 'title': 'Best CBSE Schools in Kochi and How to Choose the Right Tutor to Complement', 'cat': 'Kerala Education', 'excerpt': "A look at top CBSE schools across Kochi and how finding the right home tutor that matches your school's curriculum can make a significant difference in results.", 'author': 'BMT Team', 'date': 'December 10, 2024', 'read': '7 min', 'img_color': 'linear-gradient(135deg,#14b8a6,#0d9488)', 'emoji': '🏫', 'featured': False }, { 'id': 9, 'title': 'Indian Curriculum Tutors in Dubai: What Parents Need to Know', 'cat': 'Middle East', 'excerpt': 'For Indian expat families in UAE, finding tutors who understand CBSE and ICSE curriculum can be challenging. BMT solves this with online tutoring that bridges the gap.', 'author': 'BMT Team', 'date': 'November 28, 2024', 'read': '5 min', 'img_color': 'linear-gradient(135deg,#f43f5e,#be123c)', 'emoji': '🇦🇪', 'featured': False }];
    let activeCat = 'All';

    function filterPosts() {
      const q = document.getElementById('blogSearch').value.toLowerCase();
      let filtered = ALL_POSTS.filter(p => !p.featured);
      if (activeCat !== 'All') filtered = filtered.filter(p => p.cat === activeCat);
      if (q) filtered = filtered.filter(p => p.title.toLowerCase().includes(q) || p.cat.toLowerCase().includes(q));
      document.getElementById('blogGrid').innerHTML = filtered.length
        ? filtered.map(p => `
      <div class="blog-card anim" onclick="location.href='blog-single.html?id=${p.id}'">
        <div class="bc-img" style="background:${p.img_color}"><span class="bc-emoji">${p.emoji}</span></div>
        <div class="bc-body">
          <span class="blog-cat">${p.cat}</span>
          <h3 class="bc-title">${p.title}</h3>
          <p class="bc-excerpt">${p.excerpt}</p>
          <div class="bc-meta">
            <span><i class="fas fa-user"></i>${p.author}</span>
            <span><i class="fas fa-clock"></i>${p.read}</span>
          </div>
        </div>
      </div>`).join('')
        : '<div class="no-posts"><div style="font-size:2.5rem;margin-bottom:.75rem">🔍</div><h3>No articles found</h3><p>Try a different search or category.</p></div>';
      document.getElementById('featuredSection').style.display = (activeCat === 'All' && !q) ? 'block' : 'none';
      document.getElementById('postCount').textContent = filtered.length + ' article' + (filtered.length !== 1 ? 's' : '');
      // Re-observe for animation
      document.querySelectorAll('.blog-card.anim').forEach(el => {
        el.style.opacity = '0'; el.style.transform = 'translateY(24px)';
        el.style.transition = 'opacity .45s ease,transform .45s ease';
        obs.observe(el);
      });
    }
    // function filterCat(el, cat) {
    //   activeCat = cat;
    //   document.querySelectorAll('.cat-pill').forEach(p => p.classList.remove('active'));
    //   if (el) el.classList
</script>
@endsection
