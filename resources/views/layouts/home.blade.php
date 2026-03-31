<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>BookMyTeacher – India's #1 Home &amp; Online Tutoring Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/web/assets/css/main.css" />
    @stack('styles')
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar" id="navbar">
        <div class="nav-logo"><a href="{{ route('home.index') }}">
                <img src="/web/assets/logo/BookMyTeacher.png" alt="BookMyTeacher" id="navLogoImg"
                    data-light="/web/assets/logo/BookMyTeacher.png"
                    data-dark="/web/assets/logo/BookMyTeacher-white.png">
        </div>
        <div class="nav-links" id="navLinks">
            <a href="{{ route('home.index') }}" class="active">Home</a>
            <a href="{{ route('home.teachers') }}">Find Teachers</a>
            <a href="{{ route('home.fee-estimate') }}">Fee Estimate</a>
            <a href="{{ route('home.blogs') }}">Blogs</a>
            <a href="{{ route('home.about-us') }}">About Us</a>
            <a href="{{ route('home.contact-us') }}">Contact Us</a>
        </div>
        <div class="nav-cta" id="navCta">
            <button class="theme-toggle" onclick="toggleTheme()" title="Toggle theme"><i class="fas fa-moon"
                    id="themeIcon"></i></button>
            <a href="#enquiry" class="btn btn-outline btn-sm">Enquire</a>
            <a href="{{ route('home.teachers') }}" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Find
                Tutor</a>
        </div>
        <div class="hamburger" id="hamburger" onclick="toggleMenu()"><span></span><span></span><span></span></div>
    </nav>

    @yield('content')

    <!-- FOOTER -->
    <footer>
        <div style="max-width:1200px;margin:0 auto">
            <div class="footer-grid">
                <div>
                    <div class="footer-logo">
                        <img src="/web/assets/logo/BookMyTeacher-white.png"
                            data-light="/web/assets/logo/BookMyTeacher.png"
                            data-dark="/web/assets/logo/BookMyTeacher-white.png" alt="BookMyTeacher">
                    </div>
                    <p class="footer-desc">
                        India's leading home &amp; online tutoring platform. Connecting students with
                        verified
                        expert tutors for personalised 1-on-1 sessions. Serving 2L+ students across India and the Middle
                        East.
                    </p>
                    <div class="footer-social">
                        <a class="social-btn"><i class="fab fa-facebook-f"></i></a>
                        <a class="social-btn"><i class="fab fa-instagram"></i></a>
                        <a class="social-btn"><i class="fab fa-youtube"></i></a>
                        <a class="social-btn"><i class="fab fa-linkedin-in"></i></a>
                        <a class="social-btn"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Get Tuitions</h4>
                    <div class="footer-links">
                        <a href="{{ route('home.teachers') }}"><i class="fas fa-chevron-right" style="font-size:.68rem"></i>
                            Find
                            Teachers</a>
                        <a href="{{ route('home.index') }}"><i class="fas fa-chevron-right"
                                style="font-size:.68rem"></i> Fee
                            Estimate</a>
                        <a href="{{ route('home.index') }}"><i class="fas fa-chevron-right"
                                style="font-size:.68rem"></i> Subjects</a>
                        <a href="{{ route('home.index') }}"><i class="fas fa-chevron-right"
                                style="font-size:.68rem"></i> Pricing</a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Company</h4>
                    <div class="footer-links">
                        <a href="{{ route('home.about-us') }}"><i class="fas fa-chevron-right"
                                style="font-size:.68rem"></i> About Us</a>
                        <a href="{{ route('home.blogs') }}"><i class="fas fa-chevron-right"
                                style="font-size:.68rem"></i> Blog</a>
                        <a href="{{ route('home.contact-us') }}"><i class="fas fa-chevron-right"
                                style="font-size:.68rem"></i> Contact
                            Us</a>
                        <a href="#faq"><i class="fas fa-chevron-right" style="font-size:.68rem"></i> FAQ</a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Contact Us</h4>
                    <div class="footer-contact">
                        <div class="contact-item"><i class="fas fa-map-marker-alt"></i><span>Devi Building,
                                Kadavanthra,Kochi,
                                Kerala, India</span></div>
                        <div class="contact-item"><i
                                class="fas fa-envelope"></i><span>contact@bookmyteacher.co.in</span>
                        </div>
                        <div class="contact-item"><i class="fas fa-phone"></i><span>+91 7510 11 55 44</span></div>
                        <div class="contact-item"><i class="fas fa-clock"></i><span>Mon–Sat: 9AM–7PM IST</span></div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} BookMyTeacher. All rights reserved.</span>
                <div style="display:flex;gap:1.25rem"><a href="#">Privacy Policy</a><a href="#">Terms
                        &amp; Conditions</a><a href="#">Refund Policy</a></div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <script>
        // ── THEME ──────────────────────────────────────────────────────────
        (function() {
            var t = localStorage.getItem('bmt_theme') || 'light';
            document.documentElement.setAttribute('data-theme', t);
            var ic = document.getElementById('themeIcon');
            if (ic) ic.className = 'fas ' + (t === 'dark' ? 'fa-sun' : 'fa-moon');
            var logo = document.getElementById('navLogoImg');
            if (logo && t === 'dark') logo.src = logo.dataset.dark;
        })();

        function toggleTheme() {
            var cur = document.documentElement.getAttribute('data-theme') || 'light';
            var nxt = cur === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', nxt);
            localStorage.setItem('bmt_theme', nxt);
            var ic = document.getElementById('themeIcon');
            if (ic) ic.className = 'fas ' + (nxt === 'dark' ? 'fa-sun' : 'fa-moon');
            var logo = document.getElementById('navLogoImg');
            if (logo) logo.src = nxt === 'dark' ? logo.dataset.dark : logo.dataset.light;
        }

        // ── NAVBAR SCROLL + HAMBURGER ──────────────────────────────────────
        window.addEventListener('scroll', function() {
            var nb = document.getElementById('navbar');
            if (nb) nb.classList.toggle('scrolled', window.scrollY > 50);
        });

        function toggleMenu() {
            var nl = document.getElementById('navLinks');
            if (nl) nl.classList.toggle('open');
        }

        // ── FAQ ────────────────────────────────────────────────────────────
        function toggleFaq(el) {
            var item = el.parentElement;
            var wasOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach(function(i) {
                i.classList.remove('open');
            });
            if (!wasOpen) item.classList.add('open');
        }

        // ── TEACHERS DATA ──────────────────────────────────────────────────
        var TEACHERS = [{
                id: 1,
                name: "Rahul Menon",
                role: "Mathematics & Physics",
                subjects: ["Mathematics", "Physics", "JEE Prep", "Science"],
                emoji: "/assets/mobile-app/asit-t.png",
                rating: 4.9,
                exp: 8,
                mode: "Home & Online"
            },
            {
                id: 2,
                name: "Priya Krishnan",
                role: "Chemistry & Biology",
                subjects: ["Chemistry", "Biology", "NEET Prep", "Science"],
                emoji: "/assets/mobile-app/asit-t.png",
                rating: 4.8,
                exp: 6,
                mode: "Home & Online"
            },
            {
                id: 3,
                name: "Arjun Nair",
                role: "English & Social Studies",
                subjects: ["English", "History", "Social Studies", "Civics"],
                emoji: "/assets/mobile-app/asit-t.png",
                rating: 4.9,
                exp: 5,
                mode: "Online"
            },
            {
                id: 4,
                name: "Sneha Pillai",
                role: "Computer Science",
                subjects: ["Computer Science", "Mathematics", "Physics"],
                emoji: "/assets/mobile-app/asit-t.png",
                rating: 5.0,
                exp: 7,
                mode: "Home & Online"
            },
            {
                id: 5,
                name: "Anil Kumar",
                role: "Mathematics Specialist",
                subjects: ["Mathematics", "Accountancy", "Economics"],
                emoji: "/assets/mobile-app/asit-t.png",
                rating: 4.7,
                exp: 10,
                mode: "Home & Online"
            },
            {
                id: 6,
                name: "Meera Suresh",
                role: "Malayalam & Hindi",
                subjects: ["Malayalam", "Hindi", "English"],
                emoji: "/assets/mobile-app/asit-t.png",
                rating: 4.9,
                exp: 4,
                mode: "Home & Online"
            },
            {
                id: 7,
                name: "Deepak Varma",
                role: "Social Science Expert",
                subjects: ["Social Studies", "History", "Geography", "Economics"],
                emoji: "/assets/mobile-app/asit-t.png",
                rating: 4.8,
                exp: 6,
                mode: "Home & Online"
            },
            {
                id: 8,
                name: "Fathima Anwar",
                role: "Science & Biology",
                subjects: ["Biology", "Chemistry", "Science"],
                emoji: "/assets/mobile-app/asit-t.png",
                rating: 4.9,
                exp: 7,
                mode: "Online"
            }
        ];

        var SUBJECTS_LIST = ["Mathematics", "Physics", "Chemistry", "Biology", "English", "Science", "Social Studies",
            "Computer Science", "Hindi", "Malayalam", "History", "Economics", "JEE Prep", "NEET Prep", "Accountancy",
            "Geography", "Home Tuition"
        ];

        // ── SEARCH ─────────────────────────────────────────────────────────
        function handleSearch(val) {
            var d = document.getElementById('searchDropdown');
            if (!val) {
                d.classList.remove('show');
                return;
            }
            var q = val.toLowerCase();
            var results = [];
            SUBJECTS_LIST.forEach(function(s) {
                if (s.toLowerCase().indexOf(q) !== -1)
                    results.push({
                        type: 'subject',
                        name: s,
                        sub: 'Browse teachers for ' + s
                    });
            });
            TEACHERS.forEach(function(t) {
                var match = t.name.toLowerCase().indexOf(q) !== -1 ||
                    t.role.toLowerCase().indexOf(q) !== -1 ||
                    t.subjects.some(function(s) {
                        return s.toLowerCase().indexOf(q) !== -1;
                    });
                if (match) results.push({
                    type: 'teacher',
                    name: t.name,
                    sub: t.role,
                    id: t.id
                });
            });
            results = results.slice(0, 8);
            if (!results.length) {
                d.classList.remove('show');
                return;
            }
            d.innerHTML = results.map(function(r) {
                var icon = r.type === 'teacher' ? 'user-graduate' : 'book';
                var href = r.type === 'teacher' ? 'teacher-profile?id=' + r.id : '';
                return '<div class="sd-item" onclick="selectResult(\'' + r.type + '\',\'' + r.name.replace(/'/g,
                        "\\'") + '\',' + (r.id || 0) + ')">' +
                    '<i class="fas fa-' + icon + '"></i>' +
                    '<div><div class="sd-name">' + r.name + '</div>' +
                    '<div class="sd-sub">' + r.sub + '</div></div></div>';
            }).join('');
            d.classList.add('show');
        }

        function showDropdown() {
            var v = document.getElementById('searchInput').value;
            if (v) handleSearch(v);
        }

        function hideDropdown() {
            var d = document.getElementById('searchDropdown');
            if (d) d.classList.remove('show');
        }

        function selectResult(type, name, id) {
            if (type === 'teacher') {
                location.href = 'teacher-profile.html?id=' + id;
            } else {
                document.getElementById('searchInput').value = name;
                doSearch();
            }
        }

        function doSearch() {
            var v = document.getElementById('searchInput').value;
            if (v) location.href = 'teachers?q=' + encodeURIComponent(v);
        }

        function searchPill(s) {
            document.getElementById('searchInput').value = s;
            document.querySelectorAll('.pill').forEach(function(p) {
                p.classList.toggle('active', p.textContent.trim().indexOf(s) !== -1);
            });
            doSearch();
        }

        // ── SUBJECT CLICK ──────────────────────────────────────────────────
        function selectSubject(el) {
            document.querySelectorAll('.subject-pill').forEach(function(p) {
                p.classList.remove('active');
            });
            el.classList.add('active');

            var subject = el.dataset.subject;
            var panel = document.getElementById('subjectPanel');
            var title = document.getElementById('stpTitle');
            var grid = document.getElementById('miniTeachers');

            title.textContent = 'Teachers for ' + subject;

            var matched = TEACHERS.filter(function(t) {
                return t.subjects.indexOf(subject) !== -1;
            });

            if (!matched.length) {
                grid.innerHTML =
                    '<p style="color:var(--muted);font-size:.88rem">No teachers listed for this subject yet. ' +
                    '<a href="#enquiry" style="color:var(--green);font-weight:600">Enquire and we\'ll find one!</a></p>';
            } else {
                grid.innerHTML = matched.map(function(t) {
                    return '<div class="mini-card" onclick="location.href=\'teacher-profile?id=' + t.id +
                        '\'">' +
                        '<div class="mini-avatar"><img  src="' + t.emoji + '" /></div>' +
                        '<div>' +
                        '<div class="mini-name">' + t.name + '</div>' +
                        '<div class="mini-role">' + t.role + '</div>' +
                        '<div class="mini-rating">&#9733; ' + t.rating + ' &middot; ' + t.exp + ' yrs &middot; ' + t
                        .mode + '</div>' +
                        '</div></div>';
                }).join('');
            }

            panel.classList.add('show');
            panel.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }

        // ── ENQUIRY → WHATSAPP ─────────────────────────────────────────────
        function sendToWhatsApp() {
            var name = document.getElementById('eq_name').value || '(not provided)';
            var phone = document.getElementById('eq_phone').value || '(not provided)';
            var grade = document.getElementById('eq_grade').value || '(not selected)';
            var board = document.getElementById('eq_board').value || '(not selected)';
            var subject = document.getElementById('eq_subject').value || '(not selected)';
            var mode = document.getElementById('eq_mode').value || '(not selected)';
            var city = document.getElementById('eq_city').value || '(not provided)';
            var msg = "Hello BookMyTeacher Team \uD83D\uDC4B\n" +
                "I'm looking for a teacher.\n" +
                "Name: " + name + "\n" +
                "Phone: " + phone + "\n" +
                "Grade: " + grade + "\n" +
                "Board: " + board + "\n" +
                "Subjects: " + subject + "\n" +
                "Mode: " + mode + "\n" +
                "City: " + city + "\n" +
                "Please assist me.";
            window.open('https://wa.me/917510115544?text=' + encodeURIComponent(msg), '_blank');
        }

        function handleSubmit() {
            alert('Thank you for enquiring! Our academic counsellor will call you within 30 minutes. \uD83C\uDF93');
        }

        // ── YOUTUBE SCROLL ─────────────────────────────────────────────────
        function ytScroll(dir) {
            var track = document.getElementById('ytTrackHome');
            if (track) {
                track.scrollBy({
                    left: dir * 365,
                    behavior: 'smooth'
                });
            }
            setTimeout(updateYtDots, 400);
        }

        function ytGoTo(idx) {
            var track = document.getElementById('ytTrackHome');
            if (track) {
                track.scrollTo({
                    left: idx * 365,
                    behavior: 'smooth'
                });
            }
            setTimeout(updateYtDots, 400);
        }

        function updateYtDots() {
            var track = document.getElementById('ytTrackHome');
            if (!track) return;
            var idx = Math.round(track.scrollLeft / 365);
            document.querySelectorAll('#ytDotsHome .yt-dot').forEach(function(d, i) {
                var active = (i === idx);
                d.classList.toggle('active', active);
                d.style.width = active ? '22px' : '8px';
                d.style.borderRadius = active ? '4px' : '50%';
                d.style.background = active ? 'var(--green)' : 'var(--border)';
            });
        }

        // ── SCROLL ANIMATIONS ──────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', function() {
            // YT dots sync
            var track = document.getElementById('ytTrackHome');
            if (track) track.addEventListener('scroll', updateYtDots);

            // Intersection observer
            var obs = new IntersectionObserver(function(entries) {
                entries.forEach(function(e) {
                    if (e.isIntersecting) {
                        e.target.style.opacity = '1';
                        e.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.08
            });

            var selectors = [
                '.step-card', '.tutor-card', '.testi-card',
                '.price-card', '.feat-item', '.benefit',
                '.ht-step', '.country-card', '.stat-item'
            ];
            document.querySelectorAll(selectors.join(',')).forEach(function(el) {
                el.style.opacity = '0';
                el.style.transform = 'translateY(28px)';
                el.style.transition = 'opacity .55s ease, transform .55s ease';
                obs.observe(el);
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
