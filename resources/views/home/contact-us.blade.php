@extends('layouts.home')
@section('content')

  <!-- HERO WITH INLINE FORM -->
  <div class="contact-hero">
    <div class="ch-inner">
      <div class="ch-left">
        <span class="section-tag" style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.9)">Get In
          Touch</span>
        <h1>We're Here to <span>Help Your<br>Child Excel</span></h1>
        <p>Our academic counsellors are available Monday to Saturday, 9AM–7PM IST. Reach out via WhatsApp, phone, email,
          or the form — we respond within 30 minutes.</p>
        <div class="ch-contact-items">
          <div class="ch-item" onclick="window.open('tel:+918594000413')">
            <div class="ch-item-icon"><i class="fas fa-phone"></i></div>
            <div>
              <div class="ch-item-title">Call Us</div>
              <div class="ch-item-sub">+91 8594 000 413 · Mon–Sat, 9AM–7PM</div>
            </div>
          </div>
          <div class="ch-item" onclick="window.open('https://wa.me/918594000413','_blank')">
            <div class="ch-item-icon"><i class="fab fa-whatsapp"></i></div>
            <div>
              <div class="ch-item-title">WhatsApp</div>
              <div class="ch-item-sub">Chat directly with our team — fastest response</div>
            </div>
          </div>
          <div class="ch-item" onclick="window.open('mailto:contact@bookmyteacher.com')">
            <div class="ch-item-icon"><i class="fas fa-envelope"></i></div>
            <div>
              <div class="ch-item-title">Email Us</div>
              <div class="ch-item-sub"><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                  data-cfemail="94f7fbfae0f5f7e0d4f6fbfbfff9ede0f1f5f7fcf1e6baf7fbf9">[email&#160;protected]</a></div>
            </div>
          </div>
        </div>
      </div>
      <!-- ENQUIRY FORM -->
      <div class="contact-form-card">
        <h3 class="cf-title">Book a Free Demo</h3>
        <p class="cf-sub">Fill in your details and we'll call you back within 30 minutes!</p>
        <div class="form-row">
          <div class="form-group"><label>Parent's Name</label><input type="text" id="ct_name" placeholder="Your name"
              oninput="updateContactPreview()"></div>
          <div class="form-group"><label>Mobile / WhatsApp</label><input type="tel" id="ct_phone"
              placeholder="+91 XXXXX XXXXX" oninput="updateContactPreview()"></div>
        </div>
        <div class="form-group"><label>Student's Grade</label>
          <select id="ct_grade" onchange="updateContactPreview()">
            <option value="">Select Grade</option>
            <option>Class 1–5 (Primary)</option>
            <option>Upper Primary (6–8)</option>
            <option>Class 9–10 (Secondary)</option>
            <option>Class 11–12 (Senior Secondary)</option>
            <option>JEE Preparation</option>
            <option>NEET Preparation</option>
          </select>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Board</label>
            <select id="ct_board" onchange="updateContactPreview()">
              <option value="">Select Board</option>
              <option>CBSE</option>
              <option>ICSE</option>
              <option>IB</option>
              <option>State Board</option>
            </select>
          </div>
          <div class="form-group"><label>Subject</label>
            <select id="ct_subject" onchange="updateContactPreview()">
              <option value="">Select Subject</option>
              <option>Mathematics</option>
              <option>Physics</option>
              <option>Chemistry</option>
              <option>Biology</option>
              <option>English</option>
              <option>Malayalam</option>
              <option>Social Science</option>
              <option>Computer Science</option>
              <option>Other</option>
            </select>
          </div>
        </div>
        <div class="form-group"><label>Mode</label>
          <select id="ct_mode" onchange="updateContactPreview()">
            <option value="">Select Mode</option>
            <option>Home Tuition (Tutor visits you)</option>
            <option>Online (Video session)</option>
            <option>Both are fine</option>
          </select>
        </div>
        <div class="form-group"><label>City / Country</label><input type="text" id="ct_city"
            placeholder="e.g. Kochi, Kerala or Dubai, UAE" oninput="updateContactPreview()"></div>
        <!-- WA PREVIEW -->
        <div class="d-none"
          style="font-size:.78rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.4rem">
          Message Preview</div>
        <div class="wa-msg-preview d-none" id="ctPreview">Hello BookMyTeacher Team 👋
          I'm looking for a teacher.
          Grade: -
          Board: -
          Subjects: -
          Mode: -
          Please assist me.</div>
        <button class="btn btn-primary btn-lg" style="width:100%;justify-content:center;margin-bottom:.65rem"
          onclick="sendContactWA()">
          <i class="fab fa-whatsapp"></i> Send via WhatsApp
        </button>
        <button class="btn btn-primary btn-lg" style="width:100%;justify-content:center;background:var(--green)"
          onclick="submitContact()">
          <i class="fas fa-paper-plane"></i> Request Callback
        </button>
        <p style="text-align:center;font-size:.74rem;color:var(--muted);margin-top:.65rem"><i class="fas fa-lock"></i>
          Your info is safe and private.</p>
      </div>
    </div>
  </div>

  <!-- BODY -->
  <div class="contact-body">
    <!-- INFO CARDS -->
    <div class="info-grid">
      <div class="info-card anim">
        <div class="ic-icon" style="background:#e8f5ee;color:var(--green)"><i class="fas fa-phone"></i></div>
        <div class="ic-title">Phone</div>
        <div class="ic-value"><a href="tel:+918594000413">+91 8594 000 413</a><br>Mon–Sat, 9AM–7PM IST</div>
      </div>
      <div class="info-card anim">
        <div class="ic-icon" style="background:#e8f0fe;color:#5c6bc0"><i class="fas fa-envelope"></i></div>
        <div class="ic-title">Email</div>
        <div class="ic-value"><a
            href="/cdn-cgi/l/email-protection#d5b6babba1b4b6a195b7bababeb8aca1b0b4b6bdb0a7fbb6bab8"><span
              class="__cf_email__"
              data-cfemail="8be8e4e5ffeae8ffcbe9e4e4e0e6f2ffeeeae8e3eef9a5e8e4e6">[email&#160;protected]</span></a><br>Reply
          within 2 hours</div>
      </div>
      <div class="info-card anim">
        <div class="ic-icon" style="background:#e8f5e9;color:#25d366"><i class="fab fa-whatsapp"></i></div>
        <div class="ic-title">WhatsApp</div>
        <div class="ic-value"><a href="https://wa.me/917510115544" target="_blank">+91 7510 115544</a><br>Available
          8AM–9PM IST</div>
      </div>
      <div class="info-card anim">
        <div class="ic-icon" style="background:#fff3e0;color:#e67e22"><i class="fas fa-map-marker-alt"></i></div>
        <div class="ic-title">Office</div>
        <div class="ic-value">Kadavanthra Devi Building<br>Kochi, Kerala 655220</div>
      </div>
    </div>

    <!-- MAP + HOURS -->
    <div class="office-section">
      <div class="map-embed">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62376.08823505565!2d75.7665!3d11.2588!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba65938563d4747%3A0x323333e4e5b2b0c3!2sKozhikode%2C%20Kerala!5e0!3m2!1sen!2sin!4v1700000000000"
          allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"
          title="BookMyTeacher Office Location">
        </iframe>
      </div>
      <div>
        <span class="section-tag">Our Office</span>
        <h2 class="section-title">Visit Us in Kozhikode</h2>
        <p style="color:var(--muted);line-height:1.75;margin-bottom:1.75rem">Our main office is located in Kozhikode,
          Kerala. We welcome parents and students who want to walk in and discuss tuition requirements in person.</p>
        <div style="display:flex;flex-direction:column;gap:.85rem">
          <div style="display:flex;gap:1rem;align-items:flex-start">
            <div
              style="width:40px;height:40px;border-radius:10px;background:var(--gp);color:var(--green);display:flex;align-items:center;justify-content:center;flex-shrink:0">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div>
              <div style="font-weight:700;font-size:.9rem">Address</div>
              <div style="font-size:.85rem;color:var(--muted)"> Devi Building, Kadavanthra,Kochi, Kerala 673016
              </div>
            </div>
          </div>
          <div style="display:flex;gap:1rem;align-items:flex-start">
            <div
              style="width:40px;height:40px;border-radius:10px;background:var(--gp);color:var(--green);display:flex;align-items:center;justify-content:center;flex-shrink:0">
              <i class="fas fa-clock"></i>
            </div>
            <div>
              <div style="font-weight:700;font-size:.9rem">Working Hours</div>
              <div style="font-size:.85rem;color:var(--muted)">Monday – Saturday: 9:00 AM – 7:00 PM<br>Sunday: 10:00 AM
                – 2:00 PM</div>
            </div>
          </div>
          <div style="display:flex;gap:1rem;align-items:flex-start">
            <div
              style="width:40px;height:40px;border-radius:10px;background:var(--gp);color:var(--green);display:flex;align-items:center;justify-content:center;flex-shrink:0">
              <i class="fas fa-reply"></i>
            </div>
            <div>
              <div style="font-weight:700;font-size:.9rem">Response Time</div>
              <div style="font-size:.85rem;color:var(--muted)">WhatsApp: Under 10 minutes<br>Phone &amp; Email: Under 30
                minutes</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- SOCIAL -->
    <div style="margin-bottom:4rem">
      <div style="text-align:center;margin-bottom:2rem">
        <span class="section-tag">Follow Us</span>
        <h2 class="section-title">Connect on Social Media</h2>
      </div>
      <div class="social-links-grid">
        <div class="social-link-card" onclick="window.open('#','_blank')">
          <div class="sl-icon" style="background:#1877f2"><i class="fab fa-facebook-f"></i></div>
          <div>
            <div class="sl-name">Facebook</div>
            <div class="sl-handle">@BookMyTeacher</div>
          </div>
        </div>
        <div class="social-link-card" onclick="window.open('#','_blank')">
          <div class="sl-icon" style="background:linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888)"><i
              class="fab fa-instagram"></i></div>
          <div>
            <div class="sl-name">Instagram</div>
            <div class="sl-handle">@bookmyteacher_official</div>
          </div>
        </div>
        <div class="social-link-card" onclick="window.open('#','_blank')">
          <div class="sl-icon" style="background:#ff0000"><i class="fab fa-youtube"></i></div>
          <div>
            <div class="sl-name">YouTube</div>
            <div class="sl-handle">BookMyTeacher</div>
          </div>
        </div>
        <div class="social-link-card" onclick="window.open('https://wa.me/918594000413','_blank')">
          <div class="sl-icon" style="background:#25d366"><i class="fab fa-whatsapp"></i></div>
          <div>
            <div class="sl-name">WhatsApp</div>
            <div class="sl-handle">+91 8594 000 413</div>
          </div>
        </div>
      </div>
    </div>

    <!-- FAQ -->
    <div class="faq-quick">
      <div style="text-align:center;margin-bottom:2rem">
        <span class="section-tag">Quick Answers</span>
        <h2 class="section-title">Frequently Asked Questions</h2>
      </div>
      <div style="max-width:720px;margin:0 auto">
        <div class="fq-item open">
          <div class="fq-q" onclick="toggleFQ(this)">How quickly will someone respond to my enquiry? <i
              class="fas fa-chevron-down"></i></div>
          <div class="fq-a">
            <div class="fq-a-inner">WhatsApp responses are typically within 10 minutes during working hours. Phone
              callbacks within 30 minutes. Email responses within 2 hours on weekdays.</div>
          </div>
        </div>
        <div class="fq-item">
          <div class="fq-q" onclick="toggleFQ(this)">Is the first demo session really free? <i
              class="fas fa-chevron-down"></i></div>
          <div class="fq-a">
            <div class="fq-a-inner">Yes — 100% free. Your child gets a full 30-minute 1-on-1 session with a verified
              tutor. No credit card, no commitment required.</div>
          </div>
        </div>
        <div class="fq-item">
          <div class="fq-q" onclick="toggleFQ(this)">Can I contact you from outside India? <i
              class="fas fa-chevron-down"></i></div>
          <div class="fq-a">
            <div class="fq-a-inner">Absolutely! We serve UAE, Qatar, Oman, Saudi Arabia, Bahrain, and Kuwait. WhatsApp
              is the best channel for international parents. Our tutors teach online and cover Indian curriculum
              regardless of your location.</div>
          </div>
        </div>
        <div class="fq-item">
          <div class="fq-q" onclick="toggleFQ(this)">What information should I have ready before contacting? <i
              class="fas fa-chevron-down"></i></div>
          <div class="fq-a">
            <div class="fq-a-inner">It helps to know your child's grade, board (CBSE/ICSE/IB/State), subject(s) needed,
              preferred mode (home or online), and your city. Our counsellors will handle everything else.</div>
          </div>
        </div>
        <div class="fq-item">
          <div class="fq-q" onclick="toggleFQ(this)">How do I become a tutor on BookMyTeacher? <i
              class="fas fa-chevron-down"></i></div>
          <div class="fq-a">
            <div class="fq-a-inner">Email your CV and qualifications to <a href="/cdn-cgi/l/email-protection"
                class="__cf_email__"
                data-cfemail="1d696869726f6e5d7f727276706469787c7e75786f337e7270">[email&#160;protected]</a> with the
              subject "Tutor Application". Our team will review your profile and schedule a demo session if you meet our
              standards.</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- SUCCESS TOAST -->
  <div class="success-toast" id="successToast">
    <i class="fas fa-check-circle"></i> Message sent! We'll call you within 30 minutes.
  </div>

@endsection

  {{-- <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
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
    function updateContactPreview() {
      const name = document.getElementById('ct_name').value || '-';
      const phone = document.getElementById('ct_phone').value || '-';
      const grade = document.getElementById('ct_grade').value || '-';
      const board = document.getElementById('ct_board').value || '-';
      const subject = document.getElementById('ct_subject').value || '-';
      const mode = document.getElementById('ct_mode').value || '-';
      const city = document.getElementById('ct_city').value || '-';
      document.getElementById('ctPreview').textContent =
        `Hello BookMyTeacher Team 👋
I'm looking for a teacher.
Name: ${name}
Phone: ${phone}
Grade: ${grade}
Board: ${board}
Subjects: ${subject}
Mode: ${mode} --}}
