@extends('layouts.home')
@section('content')
    <!-- PROFILE HERO -->
    <div class="profile-hero">
        <div class="ph-inner">
            <div class="ph-left">
                <a class="ph-back" onclick="history.back()"><i class="fas fa-arrow-left"></i> Back to Teachers</a>
                <div class="ph-top">
                    <div class="ph-avatar" id="ph_avatar">👨‍🏫</div>
                    <div class="ph-info">
                        <h1 id="ph_name">Loading...</h1>
                        <div class="ph-role" id="ph_role"></div>
                        <div class="ph-meta">
                            <span class="ph-meta-item"><i class="fas fa-briefcase"></i> <span id="ph_exp"></span></span>
                            <span class="ph-meta-item"><i class="fas fa-users"></i> <span id="ph_students"></span></span>
                            <span class="ph-meta-item"><i class="fas fa-map-marker-alt"></i> <span
                                    id="ph_location"></span></span>
                            <span class="ph-meta-item"><i class="fas fa-home"></i> <span id="ph_mode"></span></span>
                        </div>
                        <div class="ph-badges" id="ph_badges"></div>
                    </div>
                </div>
            </div>
            <div class="ph-right">
                <div class="ph-cta-card">
                    <div class="ph-price-row">
                        <div>
                            <div class="ph-price-label">Session fee</div>
                            <div class="ph-price" id="ctaPrice">₹200-800<sub>/hr</sub></div>
                        </div>
                        <span
                            style="background:var(--gp);color:var(--green);font-size:.75rem;font-weight:bold;padding:.3rem .8rem;border-radius:100px">Free
                            Demo</span>
                    </div>
                    <div class="ph-rating-big">
                        <div class="ph-rating-num" id="ctaRating">4.9</div>
                        <div>
                            <div class="ph-stars">★★★★★</div>
                            <div class="ph-review-count" id="ctaReviews">128 reviews</div>
                        </div>
                    </div>
                    <div class="ph-cta-btns">
                        <button class="btn btn-primary btn-lg" style="justify-content:center" onclick="bookNowWhatsApp()"><i
                                class="fab fa-whatsapp"></i> Book via WhatsApp</button>

                        <button class="btn btn-outline" style="justify-content:center;font-size:.88rem"
                            onclick="document.getElementById('booking').scrollIntoView({behavior:'smooth'})"><i
                                class="fas fa-play-circle"></i> Book Free Demo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABS -->
    <div class="profile-tabs">
        <div class="tabs-inner">
            <div class="tab active" onclick="showTab('about',this)">About</div>
            <div class="tab" onclick="showTab('subjects',this)">Subjects</div>
            <div class="tab" onclick="showTab('availability',this)">Availability</div>
            <div class="tab" onclick="showTab('reviews',this)">Reviews</div>
            <div class="tab" onclick="showTab('booking',this)">Book Class</div>
        </div>
    </div>

    <!-- PROFILE BODY -->
    <div class="profile-body">
        <div>
            <!-- ABOUT -->
            <div class="section-card" id="tab_about">
                <div class="sc-title"><i class="fas fa-user"></i> About</div>
                <p class="about-text" id="about_text"></p>
                <div style="margin-top:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                    <div style="background:var(--bg);padding:1rem;border-radius:12px;border:1px solid var(--border)">
                        <div
                            style="font-size:.75rem;color:var(--muted);font-weight: bold;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.4rem">
                            Teaching Mode</div>
                        <div style="font-weight: bold;color:var(--green)" id="ab_mode"></div>
                    </div>
                    <div style="background:var(--bg);padding:1rem;border-radius:12px;border:1px solid var(--border)">
                        <div
                            style="font-size:.75rem;color:var(--muted);font-weight: bold;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.4rem">
                            Location</div>
                        <div style="font-weight:bold" id="ab_loc"></div>
                    </div>
                    <div style="background:var(--bg);padding:1rem;border-radius:12px;border:1px solid var(--border)">
                        <div
                            style="font-size:.75rem;color:var(--muted);font-weight: bold;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.4rem">
                            Experience</div>
                        <div style="font-weight:bold" id="ab_exp"></div>
                    </div>
                    <div style="background:var(--bg);padding:1rem;border-radius:12px;border:1px solid var(--border)">
                        <div
                            style="font-size:.75rem;color:var(--muted);font-weight: bold;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.4rem">
                            Boards</div>
                        <div style="font-weight:bold" id="ab_board"></div>
                    </div>
                </div>
            </div>

            <!-- SUBJECTS -->
            <div class="section-card" id="tab_subjects">
                <div class="sc-title"><i class="fas fa-book-open"></i> Subjects & Grade</div>
                <div style="margin-bottom:1rem">
                    <div
                        style="font-size:.8rem;color:var(--muted);font-weight: bold;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.5rem">
                        Subjects Taught</div>
                    <div class="tags-row" id="subjects_tags"></div>
                </div>
                <div>
                    <div
                        style="font-size:.8rem;color:var(--muted);font-weight: bold;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.5rem">
                        Grade / Level</div>
                    <div style="font-weight:600;font-size:.95rem" id="grade_tag"></div>
                </div>
                <div style="margin-top:1.25rem">
                    <div
                        style="font-size:.8rem;color:var(--muted);font-weight: bold;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.5rem">
                        Boards Covered</div>
                    <div class="tags-row" id="boards_tags"></div>
                </div>
            </div>

            <!-- QUALIFICATIONS -->
            <div class="section-card">
                <div class="sc-title"><i class="fas fa-graduation-cap"></i> Qualifications</div>
                <div class="qual-list" id="qual_list"></div>
            </div>

            <!-- AVAILABILITY -->
            <div class="section-card" id="tab_availability">
                <div class="sc-title"><i class="fas fa-calendar-alt"></i> Weekly Availability</div>
                <div class="avail-grid" id="avail_grid"></div>
                <p style="font-size:.78rem;color:var(--muted);margin-top:1rem;text-align:center"><span
                        style="display:inline-block;width:12px;height:12px;background:var(--gp);border:1px solid var(--gl);border-radius:3px;margin-right:.35rem"></span>Available
                    &nbsp; <span
                        style="display:inline-block;width:12px;height:12px;background:#f5f5f5;border:1px solid #ddd;border-radius:3px;margin-right:.35rem"></span>Unavailable
                </p>
            </div>

            <!-- REVIEWS -->
            <div class="section-card" id="tab_reviews">
                <div class="sc-title"><i class="fas fa-star"></i> Student Reviews</div>
                <div class="review-summary">
                    <div class="rs-big">
                        <div class="rs-num" id="rev_num">4.9</div>
                        <div class="rs-stars">★★★★★</div>
                        <div class="rs-count" id="rev_count">128 reviews</div>
                    </div>
                    <div class="rs-bars">
                        <div class="bar-row"><span class="bar-label">5</span>
                            <div class="bar-track">
                                <div class="bar-fill" style="width:85%"></div>
                            </div><span class="bar-pct">85%</span>
                        </div>
                        <div class="bar-row"><span class="bar-label">4</span>
                            <div class="bar-track">
                                <div class="bar-fill" style="width:10%"></div>
                            </div><span class="bar-pct">10%</span>
                        </div>
                        <div class="bar-row"><span class="bar-label">3</span>
                            <div class="bar-track">
                                <div class="bar-fill" style="width:4%"></div>
                            </div><span class="bar-pct">4%</span>
                        </div>
                        <div class="bar-row"><span class="bar-label">2</span>
                            <div class="bar-track">
                                <div class="bar-fill" style="width:1%"></div>
                            </div><span class="bar-pct">1%</span>
                        </div>
                        <div class="bar-row"><span class="bar-label">1</span>
                            <div class="bar-track">
                                <div class="bar-fill" style="width:0%"></div>
                            </div><span class="bar-pct">0%</span>
                        </div>
                    </div>
                </div>
                <div class="reviews-list" id="reviews_list"></div>
            </div>
        </div>

        <!-- BOOKING PANEL -->
        <div class="booking-panel" id="booking">
            <div class="book-card">
                <div class="book-title"><i class="fas fa-calendar-plus" style="color:var(--green)"></i> Book a Class
                </div>
                <div class="book-form">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" id="bk_name" placeholder="Parent / Student name"
                            oninput="updatePreview()">
                    </div>
                    <div class="form-group">
                        <label>Grade / Class</label>
                        <select id="bk_grade" onchange="updatePreview()">
                            <option value="">Select grade</option>
                            <option>Class 1–5 (Primary)</option>
                            <option>Upper Primary (6–8)</option>
                            <option>Class 9–10 (Secondary)</option>
                            <option>Class 11–12 (Senior)</option>
                            <option>JEE Preparation</option>
                            <option>NEET Preparation</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Board</label>
                        <select id="bk_board" onchange="updatePreview()">
                            <option value="">Select board</option>
                            <option>CBSE</option>
                            <option>ICSE</option>
                            <option>IB</option>
                            <option>State Board</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Subject(s)</label>
                        <input type="text" id="bk_subject" placeholder="e.g. Mathematics, Physics"
                            oninput="updatePreview()">
                    </div>
                    <div class="form-group">
                        <label>Mode</label>
                        <select id="bk_mode" onchange="updatePreview()">
                            <option value="">Select mode</option>
                            <option>Home Tuition (Tutor visits you)</option>
                            <option>Online (Video session)</option>
                        </select>
                    </div>
                    <div
                        style="font-size:.8rem;color:var(--muted);font-weight: bold;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.4rem">
                        WhatsApp Message Preview</div>
                    <div class="wa-preview" id="waPreview">Hello BookMyTeacher Team 👋
                        I'm looking for a teacher.
                        Grade: -
                        Board: -
                        Subjects: -
                        Mode: -
                        Please assist me.</div>
                    <button class="btn btn-whatsapp btn-lg" style="width:100%;justify-content:center"
                        onclick="sendBookingWhatsApp()">
                        <i class="fab fa-whatsapp"></i> Send Booking via WhatsApp
                    </button>
                    <p class="book-note"><i class="fas fa-info-circle"></i> Our team will confirm your booking within 30
                        minutes
                    </p>
                </div>
            </div>

            <!-- SIMILAR TEACHERS -->
            <div class="section-card" style="margin-top:1.5rem">
                <div class="sc-title"><i class="fas fa-users"></i> Similar Teachers</div>
                <div id="similar_teachers"></div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const ALL_TEACHERS = [{
                id: 1,
                name: "Rahul Menon",
                role: "Mathematics & Physics Expert",
                subjects: ["Mathematics", "Physics", "JEE Prep", "Science"],
                emoji: "👨‍🏫",
                grade: "Class 9–12, JEE",
                board: ["CBSE", "ICSE", "State"],
                exp: 8,
                rating: 4.9,
                reviews: 128,
                mode: "Home & Online",
                gender: "male",
                price: "₹200-800/hr",
                location: "Kochi, Kerala",
                bio: "8 years of teaching experience with 320+ successful students across Kerala. Specialises in JEE preparation, board exams, and building strong conceptual foundations. Former JEE student himself, understands the exact struggles students face and addresses them systematically.",
                qualifications: ["B.Tech, NIT Calicut (2014)", "M.Sc Mathematics, Calicut University (2016)",
                    "8 Years Teaching Experience", "JEE Advanced Cleared (2012)"
                ],
                reviews: [{
                    name: "Priya M",
                    grade: "Class 12, CBSE",
                    rating: 5,
                    text: "Rahul sir is absolutely brilliant. He explained integration concepts in a way no one ever had before. My son went from 60% to 92% in Maths. We continue with him for JEE prep too."
                }, {
                    name: "Arun K",
                    grade: "JEE Student",
                    rating: 5,
                    text: "The best maths teacher I've ever had. Patient, clear, and incredibly thorough. JEE Maths now feels achievable thanks to him!"
                }, {
                    name: "Rekha T",
                    grade: "Class 10, CBSE",
                    rating: 5,
                    text: "Excellent teacher. Very punctual for home tuition visits. My daughter loves the sessions and her confidence has improved dramatically."
                }]
            },
            {
                id: 2,
                name: "Priya Krishnan",
                role: "Chemistry & Biology Specialist",
                subjects: ["Chemistry", "Biology", "NEET Prep", "Science"],
                emoji: "👩‍🏫",
                grade: "Class 9–12, NEET",
                board: ["CBSE", "ICSE"],
                exp: 6,
                rating: 4.8,
                reviews: 97,
                mode: "Home & Online",
                gender: "female",
                price: "₹200-750/hr",
                location: "Thrissur, Kerala",
                bio: "NEET specialist with 6 years of experience and 245+ successful students. Her engaging teaching style with visual explanations, mnemonics, and real-world examples makes even the most complex biochemical processes easy to understand.",
                qualifications: ["M.Sc Biochemistry, Kerala University (2017)", "B.Ed, CUSAT (2018)",
                    "6 Years NEET Coaching", "245+ NEET Successful Students"
                ],
                reviews: [{
                    name: "Sreelekha V",
                    grade: "NEET 2024",
                    rating: 5,
                    text: "Priya ma'am's teaching is exceptional. She uses visual diagrams and stories to explain biology. I cleared NEET in my first attempt!"
                }, {
                    name: "Anil R",
                    grade: "Class 11 Parent",
                    rating: 5,
                    text: "Our daughter's chemistry marks improved from 54% to 87% in 4 months of online sessions. Highly dedicated teacher."
                }]
            },
            {
                id: 3,
                name: "Arjun Nair",
                role: "English & Social Studies",
                subjects: ["English", "History", "Social Studies", "Civics"],
                emoji: "🧑‍🏫",
                grade: "Class 6–12",
                board: ["CBSE", "ICSE", "IB", "State"],
                exp: 5,
                rating: 4.9,
                reviews: 74,
                mode: "Online",
                gender: "male",
                price: "₹200-600/hr",
                location: "Kozhikode, Kerala",
                bio: "English literature graduate who is passionate about making social subjects engaging through storytelling. Specialises in essay writing, comprehension, and making history come alive through narrative approaches.",
                qualifications: ["MA English Literature, Calicut University (2018)",
                    "5 Years Online Teaching Experience", "IB Curriculum Specialist"
                ],
                reviews: [{
                    name: "Meena J",
                    grade: "Class 9 Parent",
                    rating: 5,
                    text: "Arjun sir transformed my son's essay writing skills. He now actually enjoys writing. The improvement in his English grades has been remarkable."
                }, {
                    name: "Hari P",
                    grade: "Class 12, IB",
                    rating: 5,
                    text: "Superb English teacher. Really understands the IB curriculum and helped me score a 6 in English Literature."
                }]
            },
            {
                id: 4,
                name: "Sneha Pillai",
                role: "Computer Science & Coding",
                subjects: ["Computer Science", "Mathematics", "Physics"],
                emoji: "👩‍💻",
                grade: "Class 8–12",
                board: ["CBSE", "ICSE"],
                exp: 7,
                rating: 5.0,
                reviews: 112,
                mode: "Home & Online",
                gender: "female",
                price: "₹200-900/hr",
                location: "Kochi, Kerala",
                bio: "Software engineer turned educator with 7 years of experience teaching CS theory and programming. Makes Python and web development accessible to school students with project-based learning approaches.",
                qualifications: ["B.Tech CS, IIT Bombay (2016)", "7 Years Teaching + Industry Experience",
                    "Python, Web Dev, CS Theory Expert"
                ],
                reviews: [{
                    name: "Rohit S",
                    grade: "Class 12, CBSE",
                    rating: 5,
                    text: "Sneha ma'am is the reason I fell in love with programming. She explains everything so clearly. Got A1 in CS board exam!"
                }, {
                    name: "Divya M",
                    grade: "Class 10 Parent",
                    rating: 5,
                    text: "Our son is now building websites on his own after just 3 months! Amazing teacher who makes coding fun."
                }]
            },
        ];

        let currentTeacher = null;

        function loadTeacher() {
            const params = new URLSearchParams(window.location.search);
            const id = parseInt(params.get('id')) || 1;
            const t = ALL_TEACHERS.find(x => x.id === id) || ALL_TEACHERS[0];
            currentTeacher = t;

            document.title = t.name + ' – BookMyTeacher';
            document.getElementById('ph_avatar').textContent = t.emoji;
            document.getElementById('ph_name').textContent = t.name;
            document.getElementById('ph_role').textContent = t.role;
            document.getElementById('ph_exp').textContent = t.exp + ' years experience';
            document.getElementById('ph_students').textContent = t.reviews.length + '+ students';
            document.getElementById('ph_location').textContent = t.location;
            document.getElementById('ph_mode').textContent = t.mode;
            document.getElementById('ctaPrice').innerHTML = t.price.replace('/hr', '<sub>/hr</sub>');
            document.getElementById('ctaRating').textContent = parseFloat(t.rating);
            document.getElementById('ctaReviews').textContent = t.reviews.length + ' reviews';
            document.getElementById('about_text').textContent = t.bio;
            document.getElementById('ab_mode').textContent = t.mode;
            document.getElementById('ab_loc').textContent = t.location;
            document.getElementById('ab_exp').textContent = t.exp + ' years';
            document.getElementById('ab_board').textContent = t.board.join(', ');
            document.getElementById('rev_num').textContent = parseFloat(t.rating);
            document.getElementById('rev_count').textContent = t.reviews + ' reviews';

            // Badges
            const badges = [];
            if (t.mode.includes('Home')) badges.push('🏠 Home Tuition');
            if (t.mode.includes('Online')) badges.push('💻 Online');
            badges.push('✓ Verified');
            document.getElementById('ph_badges').innerHTML = badges.map(b => `<span class="ph-badge">${b}</span>`).join('');

            // Subjects
            document.getElementById('subjects_tags').innerHTML = t.subjects.map(s => `<span class="tag">${s}</span>`).join(
                '');
            document.getElementById('grade_tag').textContent = t.grade;
            document.getElementById('boards_tags').innerHTML = t.board.map(b => `<span class="tag">${b}</span>`).join('');

            // Qualifications
            document.getElementById('qual_list').innerHTML = (t.qualifications || []).map(q => `
    <div class="qual-item">
      <div class="qual-icon"><i class="fas fa-graduation-cap"></i></div>
      <div><div class="qual-title">${q}</div></div>
    </div>`).join('');

            // Availability
            const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            const slots = ['6AM', '9AM', '12PM', '3PM', '6PM', '8PM'];
            const avGrid = document.getElementById('avail_grid');
            avGrid.innerHTML = days.map(d => `<div class="avail-day">${d}</div>`).join('') +
                slots.flatMap(s => days.map((d, di) => {
                    const avail = Math.random() > .35;
                    return `<div class="avail-slot ${avail ? 'available' : 'unavailable'}" onclick="selectSlot(this)">${s}</div>`;
                })).join('');

            // Reviews
            document.getElementById('reviews_list').innerHTML = (t.reviews_data || t.reviews_arr || sampleReviews(t)).map(
                r => `
    <div class="review-item">
      <div class="ri-header">
        <div class="ri-av">${r.name.charAt(0)}</div>
        <div><div class="ri-name">${r.name}</div><div class="ri-meta">${r.grade}</div><div class="ri-stars">★★★★★</div></div>
      </div>
      <div class="ri-text">${r.text}</div>
    </div>`).join('');

            // Similar
            const similar = ALL_TEACHERS.filter(x => x.id !== t.id && x.subjects.some(s => t.subjects.includes(s))).slice(0,
                3);
            document.getElementById('similar_teachers').innerHTML = similar.map(s => `
    <div class="similar-card" onclick="location.href='teacher-profile.html?id=${s.id}'">
      <div class="sim-av">${s.emoji}</div>
      <div><div class="sim-name">${s.name}</div><div class="sim-role">${s.role}</div><div class="sim-rating">⭐ ${s.rating} · ${s.price}</div></div>
    </div>`).join('');

            updatePreview();
        }

        function sampleReviews(t) {
            return (t.reviews || []).slice && t.reviews.length ? t.reviews : [{
                name: "Happy Parent",
                grade: "Student",
                rating: 5,
                text: "Excellent teacher! Very patient and knowledgeable. My child's grades improved significantly."
            }];
        }

        function selectSlot(el) {
            if (el.classList.contains('unavailable')) return;
            document.querySelectorAll('.avail-slot.selected').forEach(s => s.classList.remove('selected'));
            el.classList.add('selected');
        }

        function updatePreview() {
            const name = document.getElementById('bk_name').value || '-';
            const grade = document.getElementById('bk_grade').value || '-';
            const board = document.getElementById('bk_board').value || '-';
            const subject = document.getElementById('bk_subject').value || '-';
            const mode = document.getElementById('bk_mode').value || '-';
            const tName = currentTeacher ? currentTeacher.name : 'the teacher';
            document.getElementById('waPreview').textContent =
                `Hello BookMyTeacher Team 👋
I'm looking for a teacher.
Teacher: ${tName}
Name: ${name}
Grade: ${grade}
Board: ${board}
Subjects: ${subject}
Mode: ${mode}
Please assist me.`;
        }

        function sendBookingWhatsApp() {
            const msg = document.getElementById('waPreview').textContent;
            window.open(`https://wa.me/918594000413?text=${encodeURIComponent(msg)}`, '_blank');
        }

        function bookNowWhatsApp() {
            if (!currentTeacher) return;
            const msg = `Hello BookMyTeacher Team 👋
I want to book a class with ${currentTeacher.name} (${currentTeacher.role}).
Mode: ${currentTeacher.mode}
Please assist me.`;
            window.open(`https://wa.me/918594000413?text=${encodeURIComponent(msg)}`, '_blank');
        }

        function showTab(tabId, el) {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('tab_' + tabId)?.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        window.addEventListener('scroll', () => document.getElementById('navbar').classList.toggle('scrolled', scrollY >
            50));

        function toggleMenu() {
            document.getElementById('navLinks').classList.toggle('open');
        }
        loadTeacher();
    </script>

    <script>
        (function() {
            const t = localStorage.getItem('bmt_theme') || 'light';
            document.documentElement.setAttribute('data-theme', t);
        })();

        function toggleTheme() {
            const cur = document.documentElement.getAttribute('data-theme') || 'light';
            const nxt = cur === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', nxt);
            localStorage.setItem('bmt_theme', nxt);
        }
    </script>
@endpush
