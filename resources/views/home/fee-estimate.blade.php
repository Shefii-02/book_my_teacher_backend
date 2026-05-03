@extends('home.layouts')
@section('content')
    <!-- HERO + CALCULATOR -->
    <div class="fee-hero">
        <div class="fh-inner">
            <div class="fh-left">
                <span class="section-tag" style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.9)">Fee
                    Calculator</span>
                <h1>Know Your <span>Tuition Fee</span><br>Before You Book</h1>
                <p>Use our instant fee estimator to get a transparent cost breakdown for home or online tutoring — based on
                    your
                    subject, grade, and location. No hidden charges, ever.</p>
                <div class="fh-stats">
                    <div class="fh-stat">
                        <div class="num">₹299</div>
                        <div class="lbl">Starting per session</div>
                    </div>
                    <div class="fh-stat">
                        <div class="num">0</div>
                        <div class="lbl">Hidden charges</div>
                    </div>
                    <div class="fh-stat">
                        <div class="num">Free</div>
                        <div class="lbl">First demo class</div>
                    </div>
                </div>
            </div>

            <!-- CALCULATOR -->
            <div class="calc-card">
                <div class="calc-title">Fee Estimator</div>
                <div class="calc-sub">Adjust the options below to get your personalised estimate</div>

                <div class="calc-step">
                    <div class="calc-label"><i class="fas fa-graduation-cap"></i> Grade / Level</div>
                    <div class="calc-options">
                        <span class="calc-opt sel" data-group="grade" data-val="primary" onclick="selectOpt(this)">Class
                            1–5</span>
                        <span class="calc-opt" data-group="grade" data-val="middle" onclick="selectOpt(this)">Class
                            6–8</span>
                        <span class="calc-opt" data-group="grade" data-val="secondary" onclick="selectOpt(this)">Class
                            9–10</span>
                        <span class="calc-opt" data-group="grade" data-val="senior" onclick="selectOpt(this)">Class
                            11–12</span>
                        <span class="calc-opt" data-group="grade" data-val="competitive" onclick="selectOpt(this)">JEE /
                            NEET</span>
                    </div>
                </div>

                <div class="calc-step">
                    <div class="calc-label"><i class="fas fa-book-open"></i> Subject Type</div>
                    <div class="calc-options">
                        <span class="calc-opt sel" data-group="subject" data-val="general" onclick="selectOpt(this)">General
                            (Maths,
                            Science)</span>
                        <span class="calc-opt" data-group="subject" data-val="language" onclick="selectOpt(this)">Language
                            (Eng/Mal/Hindi)</span>
                        <span class="calc-opt" data-group="subject" data-val="competitive"
                            onclick="selectOpt(this)">Competitive
                            (JEE/NEET)</span>
                        <span class="calc-opt" data-group="subject" data-val="coding" onclick="selectOpt(this)">Coding /
                            CS</span>
                    </div>
                </div>

                <div class="calc-step">
                    <div class="calc-label"><i class="fas fa-home"></i> Mode</div>
                    <div class="calc-options">
                        <span class="calc-opt" data-group="mode" data-val="online" onclick="selectOpt(this)">💻
                            Online</span>
                        <span class="calc-opt sel" data-group="mode" data-val="home" onclick="selectOpt(this)">🏠 Home
                            Tuition</span>
                    </div>
                </div>

                <div class="calc-step">
                    <div class="calc-label"><i class="fas fa-calendar-alt"></i> Sessions per Week: <span id="sessLabel"
                            style="color:var(--green);margin-left:.25rem">3 sessions</span></div>
                    <div class="range-wrap">
                        <span style="font-size:.78rem;color:var(--muted)">1</span>
                        <input type="range" min="1" max="7" value="3" id="sessSlider"
                            oninput="updateCalc()">
                        <span style="font-size:.78rem;color:var(--muted)">7</span>
                        <span class="range-val" id="sessValDisplay">3x/wk</span>
                    </div>
                </div>

                <div class="calc-step">
                    <div class="calc-label"><i class="fas fa-clock"></i> Session Duration: <span id="durLabel"
                            style="color:var(--green);margin-left:.25rem">60 min</span></div>
                    <div class="calc-options">
                        <span class="calc-opt" data-group="dur" data-val="45" onclick="selectOpt(this)">45 min</span>
                        <span class="calc-opt sel" data-group="dur" data-val="60" onclick="selectOpt(this)">60
                            min</span>
                        <span class="calc-opt" data-group="dur" data-val="90" onclick="selectOpt(this)">90 min</span>
                    </div>
                </div>

                <!-- RESULT -->
                <div class="calc-result" id="calcResult">
                    <div class="cr-row"><span class="cr-label">Sessions / Month</span><span class="cr-val"
                            id="crSessions">12</span></div>
                    <div class="cr-row"><span class="cr-label">Registration (one-time)</span><span class="cr-val">₹0 —
                            Free</span>
                    </div>
                </div>

                <div style="display:flex;gap:.75rem;margin-top:1.25rem">
                    <button class="btn btn-primary btn-lg" style="flex:1;justify-content:center" onclick="sendFeeWA()"><i
                            class="fab fa-whatsapp"></i> Get Exact Quote</button>
                    <!-- <a href="teachers.html" class="btn btn-primary btn-lg" style="flex:1;justify-content:center"><i
                  class="fas fa-search"></i> Find Tutors</a> -->
                </div>
            </div>
        </div>
    </div>

    <!-- PRICING PLANS -->
    <!-- <section style="background:var(--bg)">
        <div style="max-width:1200px;margin:0 auto">
          <div class="center" style="margin-bottom:3rem">
            <span class="section-tag">Our Plans</span>
            <h2 class="section-title">Transparent Monthly Plans</h2>
            <p class="section-sub">All plans include a free first demo session. No registration fee. No lock-in contracts.
            </p>
          </div>
          <div class="pricing-grid-fee">
            <div class="pf-card anim">
              <div class="pf-mode"><i class="fas fa-wifi"></i> Online</div>
              <div class="pf-name">Online Starter</div>
              <div style="font-size:.82rem;color:var(--muted);margin-bottom:.3rem">1 subject · perfect for trial</div>
              <div class="pf-price"><sup>₹</sup>499<span style="font-size:.9rem;font-weight:400">/mo</span></div>
              <div class="pf-period">4 sessions/month · 60 min each</div>
              <div class="pf-divider"></div>
              <ul class="pf-features">
                <li><i class="fas fa-check"></i> 1-on-1 live video sessions</li>
                <li><i class="fas fa-check"></i> Interactive digital whiteboard</li>
                <li><i class="fas fa-check"></i> Session recordings</li>
                <li><i class="fas fa-check"></i> Basic progress report</li>
                <li><i class="fas fa-check"></i> Doubt clearing via chat</li>
                <li class="off"><i class="fas fa-times"></i> Home visit</li>
                <li class="off"><i class="fas fa-times"></i> Priority tutor matching</li>
              </ul>
              <a href="contact.html" class="btn btn-outline" style="width:100%;justify-content:center">Get Started</a>
            </div>
            <div class="pf-card featured anim">
              <div class="pf-popular">Most Popular</div>
              <div class="pf-mode"><i class="fas fa-home"></i> Home &amp; Online</div>
              <div class="pf-name">Pro Learner</div>
              <div style="font-size:.82rem;color:rgba(255,255,255,.55);margin-bottom:.3rem">Up to 3 subjects · best results
              </div>
              <div class="pf-price"><sup>₹</sup>1,499<span
                  style="font-size:.9rem;font-weight:400;color:rgba(255,255,255,.5)">/mo</span></div>
              <div class="pf-period">12 sessions/month · 60 min each</div>
              <div class="pf-divider"></div>
              <ul class="pf-features" style="color:#fff">
                <li><i class="fas fa-check"></i> Home or online — your choice</li>
                <li><i class="fas fa-check"></i> Up to 3 subjects</li>
                <li><i class="fas fa-check"></i> Detailed weekly progress report</li>
                <li><i class="fas fa-check"></i> Priority tutor matching</li>
                <li><i class="fas fa-check"></i> Session recordings</li>
                <li><i class="fas fa-check"></i> Parent app access</li>
                <li><i class="fas fa-check"></i> Doubt clearing 24/7 (chat)</li>
              </ul>
              <a href="contact.html" class="btn btn-accent btn-lg" style="width:100%;justify-content:center">Get Started</a>
            </div>
            <div class="pf-card anim">
              <div class="pf-mode"><i class="fas fa-users"></i> Family</div>
              <div class="pf-name">Family Plan</div>
              <div style="font-size:.82rem;color:var(--muted);margin-bottom:.3rem">Up to 3 children</div>
              <div class="pf-price"><sup>₹</sup>2,999<span style="font-size:.9rem;font-weight:400">/mo</span></div>
              <div class="pf-period">Unlimited sessions · all subjects</div>
              <div class="pf-divider"></div>
              <ul class="pf-features">
                <li><i class="fas fa-check"></i> Up to 3 children covered</li>
                <li><i class="fas fa-check"></i> All subjects, all grades</li>
                <li><i class="fas fa-check"></i> Dedicated relationship manager</li>
                <li><i class="fas fa-check"></i> Home &amp; online sessions</li>
                <li><i class="fas fa-check"></i> Premium progress analytics</li>
                <li><i class="fas fa-check"></i> Exam-specific crash courses</li>
                <li><i class="fas fa-check"></i> Priority escalation support</li>
              </ul>
              <a href="contact.html" class="btn btn-primary" style="width:100%;justify-content:center">Get Started</a>
            </div>
          </div>
          <p style="text-align:center;font-size:.82rem;color:var(--muted);margin-top:1.75rem"><i class="fas fa-info-circle"
              style="color:var(--green)"></i> All plans include a <strong>free 30-minute demo session</strong>. GST extra as
            applicable. Prices for standard subjects &amp; grades — competitive exam prep (JEE/NEET) may be priced higher.
          </p>
        </div>
      </section> -->

    <!-- SUBJECT RATE TABLE -->
    <section style="background:var(--card)">
        <div style="max-width:1100px;margin:0 auto">
            <div class="center" style="margin-bottom:2.75rem">
                <span class="section-tag">Subject Rates</span>
                <h2 class="section-title">Per-Session Rate Guide</h2>
                <p class="section-sub">Indicative per-session rates based on subject and grade. Final rates depend on tutor
                    experience and your location.</p>
            </div>
            <div style="border-radius:20px;overflow:hidden;border:1.5px solid var(--border);box-shadow:var(--sh)">
                <table class="rate-table">
                    <thead>
                        <tr>
                            <th>Subject / Category</th>
                            <th>Primary (1–5)</th>
                            <th>Middle (6–8)</th>
                            <th>Secondary (9–10)</th>
                            <th>Senior (11–12)</th>
                            <th>JEE / NEET</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Mathematics</strong> <span class="rate-badge">Popular</span></td>
                            <td>₹250–350</td>
                            <td>₹350–450</td>
                            <td>₹450–600</td>
                            <td>₹600–800</td>
                            <td>₹800–1,200</td>
                        </tr>
                        <tr>
                            <td><strong>Science / Physics</strong></td>
                            <td>₹250–350</td>
                            <td>₹350–450</td>
                            <td>₹450–600</td>
                            <td>₹600–800</td>
                            <td>₹800–1,200</td>
                        </tr>
                        <tr>
                            <td><strong>Chemistry</strong></td>
                            <td>—</td>
                            <td>₹350–450</td>
                            <td>₹450–600</td>
                            <td>₹600–800</td>
                            <td>₹850–1,300</td>
                        </tr>
                        <tr>
                            <td><strong>Biology / NEET Bio</strong></td>
                            <td>—</td>
                            <td>₹350–450</td>
                            <td>₹450–600</td>
                            <td>₹600–800</td>
                            <td>₹900–1,400</td>
                        </tr>
                        <tr>
                            <td><strong>English Language</strong></td>
                            <td>₹220–320</td>
                            <td>₹300–400</td>
                            <td>₹380–500</td>
                            <td>₹450–600</td>
                            <td>—</td>
                        </tr>
                        <tr>
                            <td><strong>Malayalam / Hindi</strong></td>
                            <td>₹200–300</td>
                            <td>₹280–380</td>
                            <td>₹320–450</td>
                            <td>₹380–500</td>
                            <td>—</td>
                        </tr>
                        <tr>
                            <td><strong>Social Studies</strong></td>
                            <td>₹220–300</td>
                            <td>₹300–380</td>
                            <td>₹380–480</td>
                            <td>₹430–550</td>
                            <td>—</td>
                        </tr>
                        <tr>
                            <td><strong>Computer Science</strong> <span class="rate-badge">Trending</span></td>
                            <td>₹280–380</td>
                            <td>₹380–500</td>
                            <td>₹480–650</td>
                            <td>₹600–850</td>
                            <td>—</td>
                        </tr>
                        <tr>
                            <td><strong>Accountancy / Commerce</strong></td>
                            <td>—</td>
                            <td>—</td>
                            <td>₹400–550</td>
                            <td>₹550–750</td>
                            <td>—</td>
                        </tr>
                        <tr>
                            <td><strong>JEE Full Package</strong></td>
                            <td>—</td>
                            <td>—</td>
                            <td>—</td>
                            <td>₹800–1,000</td>
                            <td>₹1,000–1,500</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p style="font-size:.78rem;color:var(--muted);margin-top:.85rem;text-align:center">* Rates are per 60-minute
                session. Home tuition rates are ₹100–200 higher than online rates. Rates may vary by city and tutor
                experience
                level.</p>
        </div>
    </section>

    <!-- COMPARISON: BMT vs Others -->
    <section style="background:var(--bg)">
        <div style="max-width:900px;margin:0 auto">
            <div class="center" style="margin-bottom:2.75rem">
                <span class="section-tag">Why Choose Us</span>
                <h2 class="section-title">BookMyTeacher vs Others</h2>
            </div>
            <div class="compare-grid anim">
                <div class="cg-head">Feature</div>
                <div class="cg-head best"><i class="fas fa-star" style="margin-right:.3rem"></i> BookMyTeacher</div>
                <div class="cg-head">Other Platforms</div>

                <div class="cg-cell">Home tuition (tutor visits)</div>
                <div class="cg-cell best"><span class="cg-check">✓ Yes — our speciality</span></div>
                <div class="cg-cell"><span class="cg-cross">✗ Rarely offered</span></div>

                <div class="cg-cell">Free demo session</div>
                <div class="cg-cell best"><span class="cg-check">✓ Always free</span></div>
                <div class="cg-cell">Often paid or limited</div>

                <div class="cg-cell">Tutor background check</div>
                <div class="cg-cell best"><span class="cg-check">✓ 3-step verification</span></div>
                <div class="cg-cell">Basic or none</div>

                <div class="cg-cell">Transparent pricing</div>
                <div class="cg-cell best"><span class="cg-check">✓ No hidden fees</span></div>
                <div class="cg-cell">Often unclear</div>

                <div class="cg-cell">WhatsApp-based booking</div>
                <div class="cg-cell best"><span class="cg-check">✓ Instant &lt;10 min</span></div>
                <div class="cg-cell">Form + wait days</div>

                <div class="cg-cell">Kerala &amp; Middle East focus</div>
                <div class="cg-cell best"><span class="cg-check">✓ Specialised</span></div>
                <div class="cg-cell">Pan-India generic</div>

                <div class="cg-cell">Free tutor change</div>
                <div class="cg-cell best"><span class="cg-check">✓ Unlimited</span></div>
                <div class="cg-cell">Limited or paid</div>
            </div>
        </div>
    </section>

    <!-- FEE FAQ -->
    <section style="background:var(--card)">
        <div style="max-width:760px;margin:0 auto">
            <div class="center" style="margin-bottom:2.5rem">
                <span class="section-tag">Fee FAQ</span>
                <h2 class="section-title">Fee &amp; Pricing Questions</h2>
            </div>
            <div class="fee-faq-item open">
                <div class="fee-faq-q" onclick="toggleFeeFaq(this)">Are there any registration or joining fees? <i
                        class="fas fa-chevron-down"></i></div>
                <div class="fee-faq-a">
                    <div class="fee-faq-a-inner">Zero registration fees. Zero joining fees. You only pay for the sessions
                        you
                        book. Your first demo session is completely free — no credit card needed.</div>
                </div>
            </div>
            <div class="fee-faq-item">
                <div class="fee-faq-q" onclick="toggleFeeFaq(this)">How is the fee calculated for home tuition? <i
                        class="fas fa-chevron-down"></i></div>
                <div class="fee-faq-a">
                    <div class="fee-faq-a-inner">Home tuition rates are typically ₹100–200 per session higher than online,
                        as
                        tutors travel to your home. The exact amount depends on your location, subject, grade, and the
                        specific
                        tutor's experience level.</div>
                </div>
            </div>
            <div class="fee-faq-item">
                <div class="fee-faq-q" onclick="toggleFeeFaq(this)">Can I pay session-by-session instead of monthly? <i
                        class="fas fa-chevron-down"></i></div>
                <div class="fee-faq-a">
                    <div class="fee-faq-a-inner">Yes! We offer both per-session billing and monthly plans. Monthly plans
                        offer a
                        discount of 10–15% compared to paying per session. Talk to our counsellor to choose the right option
                        for
                        you.</div>
                </div>
            </div>
            <div class="fee-faq-item">
                <div class="fee-faq-q" onclick="toggleFeeFaq(this)">What payment methods are accepted? <i
                        class="fas fa-chevron-down"></i></div>
                <div class="fee-faq-a">
                    <div class="fee-faq-a-inner">We accept UPI (GPay, PhonePe, Paytm), bank transfer (NEFT/IMPS), and
                        credit/debit
                        cards. For parents in UAE, Qatar, Oman and other GCC countries, international bank transfer is
                        supported.
                    </div>
                </div>
            </div>
            <div class="fee-faq-item">
                <div class="fee-faq-q" onclick="toggleFeeFaq(this)">Is GST included in the prices shown? <i
                        class="fas fa-chevron-down"></i></div>
                <div class="fee-faq-a">
                    <div class="fee-faq-a-inner">The prices shown in our estimator and plan cards are excluding GST. GST at
                        the
                        applicable rate will be added to your invoice as per government regulations. Educational services
                        may be
                        exempt — our team will clarify this for your specific case.</div>
                </div>
            </div>
            <div class="fee-faq-item">
                <div class="fee-faq-q" onclick="toggleFeeFaq(this)">What is the refund policy? <i
                        class="fas fa-chevron-down"></i></div>
                <div class="fee-faq-a">
                    <div class="fee-faq-a-inner">We offer a 100% refund for any session cancelled by the tutor. For
                        student-initiated cancellations with 24+ hours notice, credits are added to your account. We have a
                        satisfaction guarantee — if you're not happy with your tutor after 3 sessions, we'll refund unused
                        session
                        fees and rematch you for free.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- BOTTOM CTA -->
    <section style="background:linear-gradient(135deg,var(--dark) 0%,#0f5a2a 100%);position:relative;overflow:hidden">
        <div
            style="position:absolute;inset:0;background-image:radial-gradient(circle,rgba(255,255,255,.05) 1px,transparent 1px);background-size:28px 28px">
        </div>
        <div style="max-width:720px;margin:0 auto;text-align:center;position:relative;z-index:1;color:#fff">
            <div style="font-size:3rem;margin-bottom:1rem">🎓</div>
            <h2 class="section-title" style="color:#fff">Ready to Start?</h2>
            <p style="color:rgba(255,255,255,.72);margin-bottom:2rem;font-size:1rem;line-height:1.75">Book your free
                30-minute
                demo session today. Our counsellor will confirm the exact fee for your requirement within 30 minutes.</p>
            <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
                <button class="btn btn-primary btn-lg" onclick="sendFeeWA()"><i class="fab fa-whatsapp"></i> Get Free
                    Quote via
                    WhatsApp</button>
                <a href="teachers.html" class="btn btn-lg"
                    style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.3)"><i
                        class="fas fa-search"></i> Browse Tutors</a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
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
        window.addEventListener('scroll', function() {
            document.getElementById('navbar').classList.toggle('scrolled', scrollY > 50);
        });

        function toggleMenu() {
            document.getElementById('navLinks').classList.toggle('open');
        }
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (e.isIntersecting) {
                    e.target.style.opacity = '1';
                    e.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: .08
        });
        document.querySelectorAll('.anim').forEach(function(el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(26px)';
            el.style.transition = 'opacity .5s ease,transform .5s ease';
            obs.observe(el);
        });
    </script>
    <script>
        // CALCULATOR ENGINE
        var STATE = {
            grade: 'primary',
            subject: 'general',
            mode: 'home',
            sessions: 3,
            dur: 60
        };
        var BASE = {
            primary: {
                general: 299,
                language: 249,
                competitive: 0,
                coding: 320
            },
            middle: {
                general: 399,
                language: 320,
                competitive: 0,
                coding: 420
            },
            secondary: {
                general: 499,
                language: 400,
                competitive: 0,
                coding: 520
            },
            senior: {
                general: 699,
                language: 480,
                competitive: 0,
                coding: 700
            },
            competitive: {
                general: 0,
                language: 0,
                competitive: 1000,
                coding: 0
            }
        };
        var MODE_ADD = {
            home: 150,
            online: 0
        };
        var DUR_MUL = {
            45: 0.8,
            60: 1.0,
            90: 1.4
        };

        function calcFee() {
            var g = STATE.grade,
                s = STATE.subject;
            if (g === 'competitive') s = 'competitive';
            var base = (BASE[g] && BASE[g][s]) ? BASE[g][s] : 499;
            if (base === 0) base = 999;
            var perSession = Math.round((base + MODE_ADD[STATE.mode]) * DUR_MUL[STATE.dur]);
            var sessPerMonth = STATE.sessions * 4;
            var total = perSession * sessPerMonth;
            document.getElementById('crPerSession').textContent = '₹' + perSession.toLocaleString('en-IN');
            document.getElementById('crSessions').textContent = sessPerMonth + ' sessions';
            document.getElementById('crTotal').textContent = '₹' + total.toLocaleString('en-IN');
        }

        function selectOpt(el) {
            var g = el.dataset.group;
            var v = el.dataset.val;
            document.querySelectorAll('[data-group="' + g + '"]').forEach(function(o) {
                o.classList.remove('sel', 'sel-accent');
            });
            el.classList.add('sel');
            STATE[g] = v;
            if (g === 'dur') document.getElementById('durLabel').textContent = v + ' min';
            calcFee();
        }

        function updateCalc() {
            var v = document.getElementById('sessSlider').value;
            STATE.sessions = parseInt(v);
            document.getElementById('sessLabel').textContent = v + ' session' + (v > 1 ? 's' : '');
            document.getElementById('sessValDisplay').textContent = v + 'x/wk';
            calcFee();
        }

        function sendFeeWA() {
            var perS = document.getElementById('crPerSession').textContent;
            var total = document.getElementById('crTotal').textContent;
            var msg = "Hello BookMyTeacher Team 👋
            I 'd like a fee quote for tuition.
            Grade: "+STATE.grade+"
            Subject: "+STATE.subject+"
            Mode: "+STATE.mode+"
            Sessions / week: "+STATE.sessions+"
            Duration: "+STATE.dur+"
            min
            Estimated fee: "+total+" / month
            Please confirm the exact fee and help me book.
            ";
            window.open('https://wa.me/918594000413?text=' + encodeURIComponent(msg), '_blank');
        }

        function toggleFeeFaq(el) {
            var item = el.parentElement;
            var isOpen = item.classList.contains('open');
            document.querySelectorAll('.fee-faq-item').forEach(function(i) {
                i.classList.remove('open');
            });
            if (!isOpen) item.classList.add('open');
        }

        calcFee();
    </script>
@endpush
