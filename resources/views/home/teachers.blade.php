@extends('layouts.home')
@section('content')
    <!-- SEARCH HERO -->
    <div class="search-hero">
        <div class="sh-inner">
            <h1>Find Your Perfect Teacher</h1>
            <p>Search from 500+ verified tutors by subject, grade, mode, and location</p>
            <div class="main-search">
                <span class="ms-icon"><i class="fas fa-search"></i></span>
                <input class="ms-input" id="mainSearch" type="text" placeholder="Search subject, teacher name..."
                    oninput="filterTeachers()" onkeydown="if(event.key==='Enter')filterTeachers()">
                <button class="ms-btn" onclick="filterTeachers()">Search</button>
            </div>
            <div class="quick-filters" id="quickFilters">
                <span class="qf" onclick="quickFilter(this,'Mathematics')">➕ Maths</span>
                <span class="qf" onclick="quickFilter(this,'Physics')">⚛️ Physics</span>
                <span class="qf" onclick="quickFilter(this,'Chemistry')">🧪 Chemistry</span>
                <span class="qf" onclick="quickFilter(this,'Biology')">🧬 Biology</span>
                <span class="qf" onclick="quickFilter(this,'English')">📖 English</span>
                <span class="qf" onclick="quickFilter(this,'JEE Prep')">🎓 JEE</span>
                <span class="qf" onclick="quickFilter(this,'NEET Prep')">🩺 NEET</span>
                <span class="qf" onclick="quickFilter(this,'Computer Science')">💻 CS</span>
                <span class="qf" onclick="quickFilter(this,'Malayalam')">✍️ Malayalam</span>
                <span class="qf home-filter" onclick="quickFilter(this,'Home')">🏠 Home Tuition</span>
            </div>
        </div>
    </div>

    <div class="teachers-layout">
        <!-- SIDEBAR FILTERS (desktop) -->
        <aside class="filters-sidebar" id="filtersSidebar">
            <div class="filter-header">
                <h3><i class="fas fa-sliders-h" style="color:var(--green);margin-right:.4rem"></i> Filters</h3>
                <a onclick="resetFilters()">Clear All</a>
            </div>

            <div class="filter-group">
                <div class="filter-label">Teaching Mode</div>
                <label class="filter-option"><input type="checkbox" value="Home" onchange="filterTeachers()"> <label>🏠
                        Home
                        Tuition</label><span class="count">12</span></label>
                <label class="filter-option"><input type="checkbox" value="Online" onchange="filterTeachers()"> <label>💻
                        Online</label><span class="count">28</span></label>
                <label class="filter-option"><input type="checkbox" value="Both" onchange="filterTeachers()"> <label>🌐
                        Both</label><span class="count">14</span></label>
            </div>

            <div class="filter-group">
                <div class="filter-label">Subject</div>
                <label class="filter-option"><input type="checkbox" value="Mathematics" class="subj-filter"
                        onchange="filterTeachers()"><label>Mathematics</label><span class="count">18</span></label>
                <label class="filter-option"><input type="checkbox" value="Physics" class="subj-filter"
                        onchange="filterTeachers()"><label>Physics</label><span class="count">14</span></label>
                <label class="filter-option"><input type="checkbox" value="Chemistry" class="subj-filter"
                        onchange="filterTeachers()"><label>Chemistry</label><span class="count">12</span></label>
                <label class="filter-option"><input type="checkbox" value="Biology" class="subj-filter"
                        onchange="filterTeachers()"><label>Biology</label><span class="count">10</span></label>
                <label class="filter-option"><input type="checkbox" value="English" class="subj-filter"
                        onchange="filterTeachers()"><label>English</label><span class="count">16</span></label>
                <label class="filter-option"><input type="checkbox" value="Computer Science" class="subj-filter"
                        onchange="filterTeachers()"><label>Computer Science</label><span class="count">8</span></label>
                <label class="filter-option"><input type="checkbox" value="Malayalam" class="subj-filter"
                        onchange="filterTeachers()"><label>Malayalam</label><span class="count">6</span></label>
                <label class="filter-option"><input type="checkbox" value="Social Studies" class="subj-filter"
                        onchange="filterTeachers()"><label>Social Studies</label><span class="count">9</span></label>
            </div>

            <div class="filter-group">
                <div class="filter-label">Grade / Class</div>
                <label class="filter-option"><input type="checkbox" value="Primary" class="grade-filter"
                        onchange="filterTeachers()"><label>Class 1–5 (Primary)</label></label>
                <label class="filter-option"><input type="checkbox" value="Middle" class="grade-filter"
                        onchange="filterTeachers()"><label>Class 6–8 (Middle)</label></label>
                <label class="filter-option"><input type="checkbox" value="Secondary" class="grade-filter"
                        onchange="filterTeachers()"><label>Class 9–10 (Secondary)</label></label>
                <label class="filter-option"><input type="checkbox" value="Senior" class="grade-filter"
                        onchange="filterTeachers()"><label>Class 11–12 (Senior)</label></label>
                <label class="filter-option"><input type="checkbox" value="JEE" class="grade-filter"
                        onchange="filterTeachers()"><label>JEE Prep</label></label>
                <label class="filter-option"><input type="checkbox" value="NEET" class="grade-filter"
                        onchange="filterTeachers()"><label>NEET Prep</label></label>
            </div>

            <div class="filter-group">
                <div class="filter-label">Board</div>
                <label class="filter-option"><input type="checkbox" value="CBSE" class="board-filter"
                        onchange="filterTeachers()"><label>CBSE</label></label>
                <label class="filter-option"><input type="checkbox" value="ICSE" class="board-filter"
                        onchange="filterTeachers()"><label>ICSE</label></label>
                <label class="filter-option"><input type="checkbox" value="IB" class="board-filter"
                        onchange="filterTeachers()"><label>IB (International)</label></label>
                <label class="filter-option"><input type="checkbox" value="State" class="board-filter"
                        onchange="filterTeachers()"><label>State Board</label></label>
            </div>

            <div class="filter-group">
                <div class="filter-label">Min Rating</div>
                <label class="filter-option"><input type="radio" name="rating" value="0"
                        onchange="filterTeachers()" checked><label>All Ratings</label></label>
                <label class="filter-option"><input type="radio" name="rating" value="4.5"
                        onchange="filterTeachers()"><label>4.5★ & above</label></label>
                <label class="filter-option"><input type="radio" name="rating" value="4.8"
                        onchange="filterTeachers()"><label>4.8★ & above</label></label>
                <label class="filter-option"><input type="radio" name="rating" value="5"
                        onchange="filterTeachers()"><label>5.0★
                        only</label></label>
            </div>

            <div class="filter-group">
                <div class="filter-label">Experience (years)</div>
                <input type="range" id="expRange" min="0" max="15" value="0"
                    oninput="document.getElementById('expVal').textContent=this.value+'+';filterTeachers()">
                <div class="range-row"><span>Any</span><span id="expVal">0+</span><span>15+</span></div>
            </div>

            <div class="filter-group">
                <div class="filter-label">Gender</div>
                <label class="filter-option"><input type="radio" name="gender" value=""
                        onchange="filterTeachers()" checked><label>Any</label></label>
                <label class="filter-option"><input type="radio" name="gender" value="male"
                        onchange="filterTeachers()"><label>Male</label></label>
                <label class="filter-option"><input type="radio" name="gender" value="female"
                        onchange="filterTeachers()"><label>Female</label></label>
            </div>
            <button class="apply-btn" onclick="filterTeachers()"><i class="fas fa-check"></i> Apply Filters</button>
        </aside>

        <!-- MAIN RESULTS -->
        <div>
            <button class="mobile-filter-btn" onclick="openDrawer()"><i class="fas fa-sliders-h"></i> Filters &amp;
                Sort</button>
            <div class="active-filters" id="activeFilters"></div>
            <div class="results-header">
                <div class="results-count" id="resultsCount">Showing <span>8</span> teachers</div>
                <div class="sort-row">
                    <label>Sort by:</label>
                    <select class="sort-select" id="sortSelect" onchange="filterTeachers()">
                        <option value="rating">Top Rated</option>
                        <option value="exp">Most Experienced</option>
                        <option value="reviews">Most Reviews</option>
                        <option value="name">Name A–Z</option>
                    </select>
                    <div class="view-toggle">
                        <button class="view-btn active" id="gridViewBtn" onclick="setView('grid')"><i
                                class="fas fa-th-large"></i></button>
                        <button class="view-btn" id="listViewBtn" onclick="setView('list')"><i
                                class="fas fa-list"></i></button>
                    </div>
                </div>
            </div>
            <div class="teachers-grid" id="teachersGrid"></div>
            <div class="pagination" id="pagination"></div>
        </div>
    </div>

    <!-- MOBILE FILTER DRAWER -->
    <div class="filter-overlay" id="filterOverlay" onclick="closeDrawer()"></div>
    <div class="filter-drawer" id="filterDrawer">
        <div class="drawer-handle"></div>
        <h3 style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:1.25rem"><i class="fas fa-sliders-h"
                style="color:var(--green);margin-right:.4rem"></i> Filters</h3>

        <div style="margin-bottom:1.25rem">
            <div
                style="font-weight:700;font-size:.82rem;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:.75rem">
                Teaching Mode</div>
            <div style="display:flex;gap:.5rem;flex-wrap:wrap">
                <label style="cursor:pointer"><input type="checkbox" class="mob-mode" value="Home"
                        onchange="filterTeachers()" style="display:none"><span class="qf" id="mob_home">🏠
                        Home</span></label>
                <label style="cursor:pointer"><input type="checkbox" class="mob-mode" value="Online"
                        onchange="filterTeachers()" style="display:none"><span class="qf" id="mob_online">💻
                        Online</span></label>
            </div>
        </div>
        <div style="margin-bottom:1.25rem">
            <div
                style="font-weight:700;font-size:.82rem;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:.75rem">
                Subject</div>
            <div style="display:flex;gap:.5rem;flex-wrap:wrap">
                <span class="qf" onclick="mobileSubjectToggle(this,'Mathematics')">Maths</span>
                <span class="qf" onclick="mobileSubjectToggle(this,'Physics')">Physics</span>
                <span class="qf" onclick="mobileSubjectToggle(this,'Chemistry')">Chemistry</span>
                <span class="qf" onclick="mobileSubjectToggle(this,'English')">English</span>
                <span class="qf" onclick="mobileSubjectToggle(this,'Biology')">Biology</span>
                <span class="qf" onclick="mobileSubjectToggle(this,'Computer Science')">CS</span>
                <span class="qf" onclick="mobileSubjectToggle(this,'Malayalam')">Malayalam</span>
            </div>
        </div>
        <div style="margin-bottom:1.5rem">
            <div
                style="font-weight:700;font-size:.82rem;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:.75rem">
                Min Rating</div>
            <div style="display:flex;gap:.5rem;flex-wrap:wrap">
                <span class="qf" onclick="setMobRating(this,'0')">All</span>
                <span class="qf" onclick="setMobRating(this,'4.5')">4.5+</span>
                <span class="qf" onclick="setMobRating(this,'4.8')">4.8+</span>
                <span class="qf active" onclick="setMobRating(this,'5')">5.0★</span>
            </div>
        </div>
        <div style="display:flex;gap:.75rem">
            <button class="apply-btn" style="flex:1" onclick="filterTeachers();closeDrawer()">Apply Filters</button>
            <button
                style="flex:0 0 auto;border:2px solid var(--green);background:transparent;color:var(--green);border-radius:12px;padding:.75rem 1.25rem;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif"
                onclick="resetFilters();closeDrawer()">Clear</button>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        // ALL TEACHERS DATA
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
                price: "₹800/hr",
                location: "Kochi, Kerala",
                bio: "8 years of teaching experience with 320+ students. Specialises in JEE preparation and board exams."
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
                price: "₹750/hr",
                location: "Thrissur, Kerala",
                bio: "NEET specialist with 245+ successful students. Engaging teaching style with visual explanations."
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
                price: "₹600/hr",
                location: "Kozhikode, Kerala",
                bio: "English literature graduate with a passion for making social subjects interesting and easy."
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
                price: "₹900/hr",
                location: "Kochi, Kerala",
                bio: "Software engineer turned educator. Specialises in CS theory, Python, and web development for school students."
            },
            {
                id: 5,
                name: "Anil Kumar",
                role: "Mathematics & Commerce",
                subjects: ["Mathematics", "Accountancy", "Economics"],
                emoji: "👨‍💼",
                grade: "Class 6–12",
                board: ["CBSE", "State", "ICSE"],
                exp: 10,
                rating: 4.7,
                reviews: 88,
                mode: "Home & Online",
                gender: "male",
                price: "₹700/hr",
                location: "Trivandrum, Kerala",
                bio: "Decade of experience in mathematics and commerce subjects. Known for patient, methodical teaching."
            },
            {
                id: 6,
                name: "Meera Suresh",
                role: "Malayalam & Hindi Teacher",
                subjects: ["Malayalam", "Hindi", "English"],
                emoji: "👩‍🎨",
                grade: "Class 1–10",
                board: ["CBSE", "ICSE", "State"],
                exp: 4,
                rating: 4.9,
                reviews: 64,
                mode: "Home & Online",
                gender: "female",
                price: "₹550/hr",
                location: "Kottayam, Kerala",
                bio: "Language specialist making regional language learning fun and effective for all grade levels."
            },
            {
                id: 7,
                name: "Deepak Varma",
                role: "Social Science Expert",
                subjects: ["Social Studies", "History", "Geography", "Economics"],
                emoji: "🧑‍🏫",
                grade: "Class 6–12",
                board: ["CBSE", "State", "IB"],
                exp: 6,
                rating: 4.8,
                reviews: 55,
                mode: "Home & Online",
                gender: "male",
                price: "₹650/hr",
                location: "Calicut, Kerala",
                bio: "Geography graduate with deep knowledge across all social science subjects and a storytelling approach."
            },
            {
                id: 8,
                name: "Fathima Anwar",
                role: "Science & Biology Expert",
                subjects: ["Biology", "Chemistry", "Science"],
                emoji: "👩‍🔬",
                grade: "Class 6–12",
                board: ["CBSE", "ICSE", "State"],
                exp: 7,
                rating: 4.9,
                reviews: 91,
                mode: "Online",
                gender: "female",
                price: "₹700/hr",
                location: "Malappuram, Kerala",
                bio: "MSc Biology with expertise in making complex biological concepts simple and memorable."
            },
            {
                id: 9,
                name: "Suresh Babu",
                role: "Physics & Science",
                subjects: ["Physics", "Science", "Mathematics"],
                emoji: "👨‍🔬",
                grade: "Class 8–12, JEE",
                board: ["CBSE", "ICSE"],
                exp: 9,
                rating: 4.8,
                reviews: 103,
                mode: "Home & Online",
                gender: "male",
                price: "₹850/hr",
                location: "Thrissur, Kerala",
                bio: "IIT graduate with 9 years of coaching JEE and board students. Expert in conceptual physics."
            },
            {
                id: 10,
                name: "Anjali Mohan",
                role: "English Literature Expert",
                subjects: ["English", "Social Studies"],
                emoji: "👩‍🏫",
                grade: "Class 5–12",
                board: ["CBSE", "ICSE", "IB", "State"],
                exp: 5,
                rating: 4.8,
                reviews: 72,
                mode: "Home & Online",
                gender: "female",
                price: "₹600/hr",
                location: "Kochi, Kerala",
                bio: "MA English Literature. Specialises in creative writing, essay composition, and reading comprehension."
            },
            {
                id: 11,
                name: "Krishnapriya R",
                role: "NEET Biology Champion",
                subjects: ["Biology", "Chemistry", "NEET Prep"],
                emoji: "👩‍⚕️",
                grade: "Class 11–12, NEET",
                board: ["CBSE", "ICSE"],
                exp: 8,
                rating: 5.0,
                reviews: 145,
                mode: "Online",
                gender: "female",
                price: "₹950/hr",
                location: "Chennai, Tamil Nadu",
                bio: "NEET AIR under 1000 holder turned educator. 8 years of proven NEET results with a 94% success rate."
            },
            {
                id: 12,
                name: "Mohammed Farouk",
                role: "Maths & JEE Specialist",
                subjects: ["Mathematics", "Physics", "JEE Prep"],
                emoji: "🧑‍💻",
                grade: "Class 9–12, JEE",
                board: ["CBSE", "ICSE"],
                exp: 11,
                rating: 4.9,
                reviews: 167,
                mode: "Home & Online",
                gender: "male",
                price: "₹1000/hr",
                location: "Kozhikode, Kerala",
                bio: "IIT Delhi alumnus. 11 years of JEE coaching. Students have achieved top 1000 ranks nationally."
            },
        ];

        let currentView = 'grid';
        let mobileRating = 0;
        let mobileSubjects = [];
        const COLORS = ['#0f7a3c,#1db954', '#6c63ff,#a855f7', '#f59e0b,#ef4444', '#0ea5e9,#0f7a3c', '#10b981,#059669',
            '#8b5cf6,#ec4899', '#f97316,#ea580c', '#06b6d4,#0891b2', '#84cc16,#65a30d', '#f43f5e,#be123c',
            '#6366f1,#7c3aed', '#14b8a6,#0d9488'
        ];

        function renderCard(t, idx) {
            const gradient = COLORS[idx % COLORS.length];
            const modeIcon = t.mode.includes('Home') ? '<i class="fas fa-home"></i>' : '<i class="fas fa-wifi"></i>';
            const modeColor = t.mode.includes('Home') ? 'color:var(--green)' : 'color:#6c63ff';
            return `<div class="teacher-card" onclick="location.href='teacher-profile.html?id=${t.id}'">
    <div class="tc-cover" style="background:linear-gradient(135deg,${gradient})">
      <div class="tc-avatar">${t.emoji}</div>
      <div class="tc-mode-badge" style="${modeColor}">${modeIcon} ${t.mode}</div>
    </div>
    <div class="tc-body">
      <div class="tc-name">${t.name}</div>
      <div class="tc-role">${t.role}</div>
      <div class="tc-meta">
        <span><i class="fas fa-briefcase"></i> ${t.exp} yrs</span>
        <span><i class="fas fa-users"></i> ${t.reviews}+</span>
        <span><i class="fas fa-map-marker-alt"></i> ${t.location.split(',')[0]}</span>
      </div>
      <div class="tc-subjects">${t.subjects.slice(0, 3).map(s => `<span class="tc-tag">${s}</span>`).join('')}</div>
      <div class="tc-footer">
        <div><div class="tc-rating"><span class="tc-stars">★★★★★</span> ${t.rating} (${t.reviews})</div><div style="font-size:.78rem;color:var(--muted);margin-top:.2rem">${t.price}</div></div>
        <div class="tc-actions">
          <button class="btn btn-whatsapp btn-sm" onclick="event.stopPropagation();bookViaWhatsApp(${t.id})"><i class="fab fa-whatsapp"></i> Book</button>
        </div>
      </div>
    </div>
  </div>`;
        }

        function getFilters() {
            const search = (document.getElementById('mainSearch').value || '').toLowerCase();
            const modes = [...document.querySelectorAll(
                '.filters-sidebar input[type=checkbox][value="Home"],.filters-sidebar input[type=checkbox][value="Online"],.filters-sidebar input[type=checkbox][value="Both"]'
            )].filter(c => c.checked).map(c => c.value);
            const subjects = [...document.querySelectorAll('.subj-filter:checked')].map(c => c.value);
            const boards = [...document.querySelectorAll('.board-filter:checked')].map(c => c.value);
            const minRating = parseFloat(document.querySelector('input[name="rating"]:checked')?.value || 0);
            const minExp = parseInt(document.getElementById('expRange')?.value || 0);
            const gender = document.querySelector('input[name="gender"]:checked')?.value || '';
            return {
                search,
                modes,
                subjects,
                boards,
                minRating,
                minExp,
                gender
            };
        }

        function filterTeachers() {
            const f = getFilters();
            const sort = document.getElementById('sortSelect').value;
            let results = [...ALL_TEACHERS];
            if (f.search) results = results.filter(t => t.name.toLowerCase().includes(f.search) || t.role.toLowerCase()
                .includes(f.search) || t.subjects.some(s => s.toLowerCase().includes(f.search)) || t.location
                .toLowerCase().includes(f.search));
            if (f.modes.length) results = results.filter(t => f.modes.some(m => t.mode.includes(m)));
            if (f.subjects.length) results = results.filter(t => f.subjects.some(s => t.subjects.includes(s)));
            if (f.boards.length) results = results.filter(t => f.boards.some(b => t.board.includes(b)));
            if (f.minRating > 0) results = results.filter(t => t.rating >= f.minRating);
            if (f.minExp > 0) results = results.filter(t => t.exp >= f.minExp);
            if (f.gender) results = results.filter(t => t.gender === f.gender);
            // Mobile extra filters
            if (mobileSubjects.length) results = results.filter(t => mobileSubjects.some(s => t.subjects.includes(s)));
            if (mobileRating > 0) results = results.filter(t => t.rating >= mobileRating);
            if (sort === 'rating') results.sort((a, b) => b.rating - a.rating);
            else if (sort === 'exp') results.sort((a, b) => b.exp - a.exp);
            else if (sort === 'reviews') results.sort((a, b) => b.reviews - a.reviews);
            else if (sort === 'name') results.sort((a, b) => a.name.localeCompare(b.name));
            renderResults(results);
        }

        function renderResults(results) {
            const grid = document.getElementById('teachersGrid');
            document.getElementById('resultsCount').innerHTML =
                `Showing <span>${results.length}</span> teacher${results.length !== 1 ? 's' : ''}`;
            if (!results.length) {
                grid.innerHTML =
                    `<div class="no-results" style="grid-column:1/-1"><div class="nr-icon">🔍</div><h3>No teachers found</h3><p>Try adjusting your filters or search terms. Or <a href="index.html#enquiry" style="color:var(--green);font-weight:600">enquire directly</a> and we'll find the perfect match.</p></div>`;
                document.getElementById('pagination').innerHTML = '';
                return;
            }
            grid.innerHTML = results.map((t, i) => renderCard(t, i)).join('');
            // Pagination
            const pages = Math.ceil(results.length / 8);
            if (pages > 1) document.getElementById('pagination').innerHTML = [...Array(pages)].map((_, i) =>
                `<button class="page-btn${i === 0 ? ' active' : ''}">${i + 1}</button>`).join('');
            else document.getElementById('pagination').innerHTML = '';
        }

        function setView(v) {
            currentView = v;
            const grid = document.getElementById('teachersGrid');
            grid.classList.toggle('list-view', v === 'list');
            document.getElementById('gridViewBtn').classList.toggle('active', v === 'grid');
            document.getElementById('listViewBtn').classList.toggle('active', v === 'list');
        }

        function quickFilter(el, subject) {
            el.classList.toggle('active');
            document.getElementById('mainSearch').value = subject;
            filterTeachers();
        }

        function resetFilters() {
            document.querySelectorAll('.filters-sidebar input[type=checkbox]').forEach(c => c.checked = false);
            document.querySelectorAll('input[name="rating"]')[0].checked = true;
            document.querySelectorAll('input[name="gender"]')[0].checked = true;
            document.getElementById('expRange').value = 0;
            document.getElementById('expVal').textContent = '0+';
            document.getElementById('mainSearch').value = '';
            document.querySelectorAll('.qf').forEach(q => q.classList.remove('active'));
            mobileSubjects = [];
            mobileRating = 0;
            filterTeachers();
        }

        function openDrawer() {
            document.getElementById('filterOverlay').classList.add('open');
            document.getElementById('filterDrawer').classList.add('open');
        }

        function closeDrawer() {
            document.getElementById('filterOverlay').classList.remove('open');
            document.getElementById('filterDrawer').classList.remove('open');
        }

        function mobileSubjectToggle(el, s) {
            el.classList.toggle('active');
            if (mobileSubjects.includes(s)) mobileSubjects = mobileSubjects.filter(x => x !== s);
            else mobileSubjects.push(s);
        }

        function setMobRating(el, r) {
            document.querySelectorAll('.filter-drawer .qf').forEach(q => q.classList.remove('active'));
            el.classList.add('active');
            mobileRating = parseFloat(r);
        }

        function bookViaWhatsApp(id) {
            const t = ALL_TEACHERS.find(x => x.id === id);
            if (!t) return;
            const msg = `Hello BookMyTeacher Team 👋
I'm interested in booking a class with ${t.name}.
Subject: ${t.subjects[0]}
Mode: ${t.mode}
Please assist me with booking.`;
            window.open(`https://wa.me/917510115544?text=${encodeURIComponent(msg)}`, '_blank');
        }

        // URL PARAM SEARCH
        window.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const q = params.get('q');
            if (q) {
                document.getElementById('mainSearch').value = q;
            }
            filterTeachers();
            window.addEventListener('scroll', () => document.getElementById('navbar').classList.toggle('scrolled',
                scrollY > 50));
        });

        function toggleMenu() {
            document.getElementById('navLinks').classList.toggle('open');
            document.getElementById('navCta').classList.toggle('open');
        }
    </script>
@endpush
