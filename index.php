<?php
require_once __DIR__ . '/includes/init.php';
$page_title = 'National Alcohol Abuse Prevention & Recovery Support';
include __DIR__ . '/includes/header.php';
?>

<!-- 1. DYNAMIC HERO BACKGROUND IMAGE SLIDER -->
<section class="hero-slider-section" data-hero-slider>
  <div class="hero-slider-track">
    <!-- Slide 1: The Struggle with Alcohol Abuse -->
    <div class="hero-slide active" style="background-image: url('<?= e(asset('images/hero_struggle.jpg')) ?>');" data-hero-slide="0">
      <div class="hero-slide-overlay"></div>
      <div class="wrap hero-content-wrap">
        <div class="hero-card-glass">
          <span class="hero-kicker-pill pill-red">
            <span>&bull;</span> Confidential Care &middot; Zero Stigma
          </span>
          <h1>From the darkness of alcohol dependency to the light of recovery.</h1>
          <p class="hero-desc">Alcohol abuse hurts families, careers, mental well-being, and physical health. You do not have to walk this journey alone. Begin with a 100% private clinical screening—no names, no judgment, and immediate access to accredited care.</p>
          <div class="hero-actions-row">
            <a class="btn btn-primary btn-lg" href="<?= e(url('screening.php')) ?>">
              <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              Take 10-Question AUDIT Screening
            </a>
            <a class="btn btn-ghost-white btn-lg" href="<?= e(url('start.php')) ?>">
              Start Anonymously
            </a>
            <a class="btn btn-danger" href="tel:112">
              24/7 Crisis Hotline
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Slide 2: Clinical Counselling & Doctor Consultation -->
    <div class="hero-slide" style="background-image: url('<?= e(asset('images/hero_counselling.jpg')) ?>');" data-hero-slide="1">
      <div class="hero-slide-overlay"></div>
      <div class="wrap hero-content-wrap">
        <div class="hero-card-glass">
          <span class="hero-kicker-pill pill-green">
            <span>&bull;</span> Certified Medical &amp; Clinical Professionals
          </span>
          <h1>Empathetic doctor counselling tailored to your journey.</h1>
          <p class="hero-desc">Speak privately with verified clinical psychologists, addiction specialists, and public healthcare counsellors across Rwanda. Verified by health authorities, our practitioners guide you from detox to lifelong sobriety.</p>
          <div class="hero-actions-row">
            <a class="btn btn-primary btn-lg" href="<?= e(url('counsellors.php')) ?>">
              <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
              Connect with a Counsellor
            </a>
            <a class="btn btn-ghost-white btn-lg" href="<?= e(url('awareness.php')) ?>">
              Clinical FAQ &amp; Guides
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Slide 3: Group Support & Community Recovery -->
    <div class="hero-slide" style="background-image: url('<?= e(asset('images/hero_community.jpg')) ?>');" data-hero-slide="2">
      <div class="hero-slide-overlay"></div>
      <div class="wrap hero-content-wrap">
        <div class="hero-card-glass">
          <span class="hero-kicker-pill pill-yellow">
            <span>&bull;</span> Thriving Community &amp; Peer Healing
          </span>
          <h1>Rebuilding lives, healthy families, and shared strength.</h1>
          <p class="hero-desc">Sustainable rehabilitation combines medical guidance, peer support circles, balanced daily nutrition, and physical activity. Step into a supportive community where your dignity and privacy always come first.</p>
          <div class="hero-actions-row">
            <a class="btn btn-primary btn-lg" href="#recovery">
              <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
              Explore Recovery Pillars
            </a>
            <a class="btn btn-ghost-white btn-lg" href="<?= e(url('stories.php')) ?>">
              Real Recovery Stories
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Hero Carousel Controls -->
  <div class="hero-slide-nav">
    <div class="wrap hero-nav-inner">
      <div class="hero-dots">
        <button class="hero-dot active" aria-label="Slide 1: Struggle with Alcohol" data-hero-dot="0"></button>
        <button class="hero-dot" aria-label="Slide 2: Clinical Doctor Counselling" data-hero-dot="1"></button>
        <button class="hero-dot" aria-label="Slide 3: Community & Recovery" data-hero-dot="2"></button>
      </div>
      <div class="hero-arrows">
        <button class="hero-arrow-btn" aria-label="Previous Slide" data-hero-prev>&#10094;</button>
        <button class="hero-arrow-btn" aria-label="Next Slide" data-hero-next>&#10095;</button>
      </div>
    </div>
  </div>
</section>

<!-- 2. QUICK PLATFORM METRICS -->
<section class="section" style="padding: 2.8rem 0; background: #ffffff; border-bottom: 1px solid var(--line);">
  <div class="wrap">
    <div class="grid-4">
      <div class="stat">
        <b>10</b>
        <span>Validated WHO AUDIT Clinical Questions</span>
      </div>
      <div class="stat">
        <b>4</b>
        <span>Structured Clinical Risk Zones &amp; Care Paths</span>
      </div>
      <div class="stat">
        <b>100%</b>
        <span>Anonymous &amp; Stigma-Free Identity Shield</span>
      </div>
      <div class="stat">
        <b>24/7</b>
        <span>Emergency Healthcare &amp; Crisis Support</span>
      </div>
    </div>
  </div>
</section>

<!-- 3. INTERACTIVE MIDDLE SHOWCASE: EXPLANATORY BOXES WITH SIDE IMAGE & TEXT -->
<section class="section interactive-section" data-interactive-showcase>
  <div class="wrap">
    <div class="section-head">
      <span class="kicker">Interactive System Architecture</span>
      <h2>How Ihumure Guides You from Vulnerability to Strength</h2>
      <p class="lede">Explore the core pillars of Rwanda's dedicated alcohol rehabilitation and counselling ecosystem. Hover or click any section to view its clinical workflow.</p>
    </div>

    <!-- Interactive Selector Tabs Bar -->
    <div class="interactive-tabs-bar">
      <button class="interactive-tab-btn active" data-interactive-tab="0">
        <span class="tab-num">1</span>
        <span>Confidential AUDIT Screening</span>
      </button>
      <button class="interactive-tab-btn" data-interactive-tab="1">
        <span class="tab-num">2</span>
        <span>Direct Verified Doctor Matching</span>
      </button>
      <button class="interactive-tab-btn" data-interactive-tab="2">
        <span class="tab-num">3</span>
        <span>Zero-Stigma Anonymous Identity</span>
      </button>
      <button class="interactive-tab-btn" data-interactive-tab="3">
        <span class="tab-num">4</span>
        <span>Holistic Rehabilitation Roadmap</span>
      </button>
    </div>

    <!-- Interactive Box Wrapper -->
    <div class="interactive-box-wrapper">
      
      <!-- PANE 1: Confidential AUDIT Screening -->
      <div class="interactive-pane active" data-interactive-pane="0">
        <div class="interactive-split-grid">
          <div class="interactive-img-side">
            <span class="interactive-img-badge badge-green">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
              WHO Gold Standard Diagnostic
            </span>
            <img src="<?= e(asset('images/showcase_audit.jpg')) ?>" alt="Person privately filling out WHO AUDIT screening on mobile device">
          </div>
          <div class="interactive-text-side">
            <div>
              <div class="interactive-text-header">
                <span class="kicker kicker-green">Step 1 &middot; Clinical Self-Evaluation</span>
                <h3>10-Question WHO AUDIT Self-Screening</h3>
              </div>
              <p class="lead-text">Developed by the World Health Organization and validated globally, the AUDIT screening evaluates consumption patterns, drinking frequency, tolerance, and alcohol-related physical or social harm.</p>
              <ul class="interactive-checklist">
                <li>
                  <svg class="check-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                  <span><strong>Clinically Validated:</strong> 10 standardized questions scored between 0 and 40 points.</span>
                </li>
                <li>
                  <svg class="check-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                  <span><strong>Immediate Tiered Analysis:</strong> Instant assignment into one of 4 international WHO risk zones.</span>
                </li>
                <li>
                  <svg class="check-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                  <span><strong>Zero Profile Exposure:</strong> Answer honestly without risk of employer or family discovery.</span>
                </li>
              </ul>
            </div>
            <div class="interactive-bottom-controls">
              <a class="btn btn-primary" href="<?= e(url('screening.php')) ?>">Start Private Screening Now</a>
              <div class="interactive-slide-buttons">
                <button class="slide-step-btn" title="Previous Topic" data-pane-prev>&#10094;</button>
                <button class="slide-step-btn" title="Next Topic" data-pane-next>&#10095;</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- PANE 2: Direct Verified Doctor & Counsellor Matching -->
      <div class="interactive-pane" data-interactive-pane="1">
        <div class="interactive-split-grid">
          <div class="interactive-img-side">
            <span class="interactive-img-badge badge-green">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
              Accredited Clinical Network
            </span>
            <img src="<?= e(asset('images/hero_counselling.jpg')) ?>" alt="Doctor in consultation room listening attentively to client">
          </div>
          <div class="interactive-text-side">
            <div>
              <div class="interactive-text-header">
                <span class="kicker kicker-green">Step 2 &middot; Professional Referral</span>
                <h3>Direct Verified Doctor &amp; Counsellor Matching</h3>
              </div>
              <p class="lead-text">Higher AUDIT risk scores warrant experienced guidance. Ihumure connects you with certified mental health practitioners in public hospitals, private clinics, and specialised rehabilitation programmes across Rwanda.</p>
              <ul class="interactive-checklist">
                <li>
                  <svg class="check-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                  <span><strong>Vetted Credentials:</strong> Every counsellor is manually validated with verified medical and counselling certificates.</span>
                </li>
                <li>
                  <svg class="check-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                  <span><strong>District-Level Proximity:</strong> Filter specialists by Kigali, Northern, Southern, Eastern, or Western Provinces.</span>
                </li>
                <li>
                  <svg class="check-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                  <span><strong>Tiered Care Options:</strong> Free public clinical care or affordable private consultations.</span>
                </li>
              </ul>
            </div>
            <div class="interactive-bottom-controls">
              <a class="btn btn-primary" href="<?= e(url('counsellors.php')) ?>">Browse Verified Counsellors</a>
              <div class="interactive-slide-buttons">
                <button class="slide-step-btn" title="Previous Topic" data-pane-prev>&#10094;</button>
                <button class="slide-step-btn" title="Next Topic" data-pane-next>&#10095;</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- PANE 3: Zero-Stigma Anonymous Privacy Shield -->
      <div class="interactive-pane" data-interactive-pane="2">
        <div class="interactive-split-grid">
          <div class="interactive-img-side">
            <span class="interactive-img-badge badge-yellow">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
              Strict Cryptographic Privacy
            </span>
            <img src="<?= e(asset('images/hero_community.jpg')) ?>" alt="Support group in comfortable safe wellness space">
          </div>
          <div class="interactive-text-side">
            <div>
              <div class="interactive-text-header">
                <span class="kicker kicker-yellow">Step 3 &middot; Zero-Stigma Access</span>
                <h3>Protected Anonymous Identity Shield</h3>
              </div>
              <p class="lead-text">Fear of social stigma, workplace reprimand, or community gossip prevents 80% of individuals with alcohol struggles from ever seeking help. Ihumure solves this at the structural level.</p>
              <ul class="interactive-checklist">
                <li>
                  <svg class="check-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                  <span><strong>No Real Name Required:</strong> Instant cryptographic ID (e.g., <code style="color:var(--teal-dark);font-weight:700">IH-4F8K2A</code>) and private PIN.</span>
                </li>
                <li>
                  <svg class="check-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                  <span><strong>Encrypted 1-on-1 Consultation:</strong> Chat directly with your assigned specialist via your private ID.</span>
                </li>
                <li>
                  <svg class="check-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                  <span><strong>Complete Data Sovereignty:</strong> Phone numbers and personal identification remain strictly optional.</span>
                </li>
              </ul>
            </div>
            <div class="interactive-bottom-controls">
              <a class="btn btn-primary" href="<?= e(url('start.php')) ?>">Get Your Private ID</a>
              <div class="interactive-slide-buttons">
                <button class="slide-step-btn" title="Previous Topic" data-pane-prev>&#10094;</button>
                <button class="slide-step-btn" title="Next Topic" data-pane-next>&#10095;</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- PANE 4: Holistic Rehabilitation Roadmap -->
      <div class="interactive-pane" data-interactive-pane="3">
        <div class="interactive-split-grid">
          <div class="interactive-img-side">
            <span class="interactive-img-badge badge-green">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
              Holistic Recovery Blueprint
            </span>
            <img src="<?= e(asset('images/recovery_sports.jpg')) ?>" alt="People running in lush green outdoor park">
          </div>
          <div class="interactive-text-side">
            <div>
              <div class="interactive-text-header">
                <span class="kicker kicker-green">Step 4 &middot; Sustained Sobriety</span>
                <h3>Comprehensive Rehabilitation &amp; Relapse Prevention</h3>
              </div>
              <p class="lead-text">Sobriety is not simply stopping consumption—it is constructing a healthy, fulfilling lifestyle where alcohol is no longer needed to cope with emotional distress or fatigue.</p>
              <ul class="interactive-checklist">
                <li>
                  <svg class="check-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                  <span><strong>Physical Resets:</strong> Structured athletics, morning sunlight, and endorphin activation.</span>
                </li>
                <li>
                  <svg class="check-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                  <span><strong>Nutritional Detox:</strong> Restoring depleted micronutrients, liver cellular rejuvenation, and hydration.</span>
                </li>
                <li>
                  <svg class="check-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                  <span><strong>Peer Sobriety Circles:</strong> Moderated community groups and inspiring real recovery testimonies.</span>
                </li>
              </ul>
            </div>
            <div class="interactive-bottom-controls">
              <a class="btn btn-primary" href="#recovery">View Holistic Pillars Below</a>
              <div class="interactive-slide-buttons">
                <button class="slide-step-btn" title="Previous Topic" data-pane-prev>&#10094;</button>
                <button class="slide-step-btn" title="Next Topic" data-pane-next>&#10095;</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- 4. DEDICATED RECOVERY & WELLNESS SECTION (SPORTS, BALANCED DIET, MINDFULNESS) -->
<section class="section recovery-section" id="recovery">
  <div class="wrap">
    <div class="section-head">
      <span class="kicker">The Science of Sobriety</span>
      <h2>Pillars of Sustainable Recovery &amp; Healthy Living</h2>
      <p class="lede">Clinical therapy achieves its greatest breakthroughs when reinforced by daily physical movement, restorative nutrition, and mental grounding. Reclaim your vitality through these three essential lifestyle pillars.</p>
    </div>

    <div class="grid-3">
      <!-- Pillar 1: Sports & Physical Exercise -->
      <article class="recovery-card">
        <div class="recovery-card-media">
          <span class="recovery-tag tag-sports">Pillar 1 &middot; Physical Sports</span>
          <img src="<?= e(asset('images/recovery_sports.jpg')) ?>" alt="Energetic people jogging and doing sports together in a sunny park">
        </div>
        <div class="recovery-card-body">
          <div>
            <h3>Active Sports &amp; Endorphin Restoration</h3>
            <p>Chronic alcohol use blunts natural dopamine production. Engaging in regular cardio, jogging, team football, or athletic training stimulates brain neurogenesis, restores natural dopamine balance, and dramatically alleviates anxiety and insomnia.</p>
          </div>
          <div class="recovery-routine-box">
            <strong>Recommended Athletic Protocol:</strong>
            <span>30–45 minutes of moderate aerobic exercise 4–5 days weekly. Exercise in morning sunlight to reset your circadian rhythm and sleep quality.</span>
          </div>
        </div>
      </article>

      <!-- Pillar 2: Balanced Diet & Liver Detoxification -->
      <article class="recovery-card">
        <div class="recovery-card-media">
          <span class="recovery-tag tag-diet">Pillar 2 &middot; Balanced Diet</span>
          <img src="<?= e(asset('images/recovery_diet.jpg')) ?>" alt="Colorful balanced diet plate with vegetables, lean protein, avocado, and clean water">
        </div>
        <div class="recovery-card-body">
          <div>
            <h3>Balanced Nutrition &amp; Liver Regeneration</h3>
            <p>Alcohol severely drains the body of Vitamin B-complex, magnesium, zinc, and hydration. A nutrient-dense diet rich in antioxidants, clean proteins, and healthy fatty acids accelerates liver cellular recovery and stops sugar cravings.</p>
          </div>
          <div class="recovery-routine-box">
            <strong>Dietary Healing Protocol:</strong>
            <span>Incorporate leafy greens, cruciferous vegetables, whole grains, lean poultry/fish, and drink at least 2.5 to 3 litres of clean water daily.</span>
          </div>
        </div>
      </article>

      <!-- Pillar 3: Mindfulness & Emotional Resilience -->
      <article class="recovery-card">
        <div class="recovery-card-media">
          <span class="recovery-tag tag-mind">Pillar 3 &middot; Mental Health</span>
          <img src="<?= e(asset('images/recovery_mindfulness.jpg')) ?>" alt="Person meditating serenely in lush garden by peaceful pond">
        </div>
        <div class="recovery-card-body">
          <div>
            <h3>Mindfulness &amp; Craving Regulation</h3>
            <p>Cravings are neurochemical waves that peak and dissipate within 15–20 minutes. Mindfulness meditation, diaphragmatic breathwork, and structured stress management empower you to ride out impulses without relapsing.</p>
          </div>
          <div class="recovery-routine-box">
            <strong>Mental Wellness Protocol:</strong>
            <span>10 minutes of daily morning meditation. Use the "Urge Surfing" breathing technique whenever cravings strike. Prioritize 8 hours of restful sleep.</span>
          </div>
        </div>
      </article>
    </div>

    <!-- Practical Daily Sobriety Rules -->
    <div style="margin-top: 2.8rem; background: #ffffff; border: 1px solid var(--green-border); border-radius: var(--radius); padding: 1.8rem 2rem; box-shadow: var(--shadow-sm);">
      <div style="display: flex; align-items: center; gap: .8rem; margin-bottom: 1rem;">
        <span style="background: var(--teal); color: #fff; width: 32px; height: 32px; border-radius: 50%; display: grid; place-items: center; font-weight: 800;">&check;</span>
        <h3 style="margin: 0; font-size: 1.3rem;">Four Golden Rules for Sobriety Protection</h3>
      </div>
      <div class="grid-4" style="gap: 1rem;">
        <div style="background: var(--green-tint); padding: 1rem; border-radius: 12px; border: 1px solid var(--green-border);">
          <strong style="color: var(--teal-dark); display: block; margin-bottom: .25rem;">1. Never Skip Meals</strong>
          <span class="small muted">Low blood sugar frequently masquerades as alcohol craving. Keep balanced protein snacks accessible.</span>
        </div>
        <div style="background: var(--green-tint); padding: 1rem; border-radius: 12px; border: 1px solid var(--green-border);">
          <strong style="color: var(--teal-dark); display: block; margin-bottom: .25rem;">2. The 20-Minute Delay</strong>
          <span class="small muted">When an urge surfaces, drink a tall glass of cold water and change your physical location.</span>
        </div>
        <div style="background: var(--green-tint); padding: 1rem; border-radius: 12px; border: 1px solid var(--green-border);">
          <strong style="color: var(--teal-dark); display: block; margin-bottom: .25rem;">3. Find a Sober Partner</strong>
          <span class="small muted">Identify one family member, friend, or counsellor you can message without hesitation.</span>
        </div>
        <div style="background: var(--green-tint); padding: 1rem; border-radius: 12px; border: 1px solid var(--green-border);">
          <strong style="color: var(--teal-dark); display: block; margin-bottom: .25rem;">4. Guard Your Evenings</strong>
          <span class="small muted">Replace drinking hours with football, evening walks, reading, or recovery group discussions.</span>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- 5. CLINICAL RISK ZONES & ATTENTION RESTRICTIONS (GREEN, YELLOW, AMBER, RED) -->
<section class="section" style="background: #ffffff; border-bottom: 1px solid var(--line);">
  <div class="wrap">
    <div class="section-head">
      <span class="kicker">Clinical Scoring Framework</span>
      <h2>Understanding the Four WHO AUDIT Risk Zones</h2>
      <p class="lede">Standardized clinical guidelines established by the World Health Organization (WHO) ensure every individual receives appropriate, non-judgmental guidance matched directly to their needs.</p>
    </div>

    <!-- Zone Cards Grid -->
    <div class="risk-zones-grid">
      <!-- Zone I: Low Risk (Green) -->
      <div class="zone-card zone-low">
        <span class="zone-score-badge">Zone I &middot; Score 0–7</span>
        <h3>Low Risk Drinking</h3>
        <p>Your drinking pattern is within low-risk limits or you abstain. Continued education and general wellness protect long-term health.</p>
        <div class="zone-action-note">&check; Recommended: Health &amp; lifestyle education</div>
      </div>

      <!-- Zone II: Hazardous (Yellow) -->
      <div class="zone-card zone-hazardous">
        <span class="zone-score-badge">Zone II &middot; Score 8–15</span>
        <h3>Hazardous Pattern</h3>
        <p>Drinking levels exceed low-risk health boundaries and increase risk of high blood pressure, liver strain, and social friction.</p>
        <div class="zone-action-note">&bull; Recommended: Brief intervention &amp; alcohol-free days</div>
      </div>

      <!-- Zone III: Harmful (Amber / Orange) -->
      <div class="zone-card zone-harmful">
        <span class="zone-score-badge">Zone III &middot; Score 16–19</span>
        <h3>Harmful Consumption</h3>
        <p>Clear physical or mental harm has begun to manifest. Relational or occupational challenges often accompany this zone.</p>
        <div class="zone-action-note">&bull; Recommended: Direct counselling &amp; structured support</div>
      </div>

      <!-- Zone IV: Dependence (Attention Red) -->
      <div class="zone-card zone-dependence">
        <span class="zone-score-badge">Zone IV &middot; Score 20–40</span>
        <h3>Likely Dependence</h3>
        <p>High probability of clinical alcohol addiction with physical tolerance and withdrawal symptoms. Immediate professional support needed.</p>
        <div class="zone-action-note">&excl; Recommended: Clinical referral &amp; specialist care</div>
      </div>
    </div>

    <!-- Red Alert: Acute Alcohol Toxicity & Restriction Warnings -->
    <div class="restrict-alert-card">
      <div class="restrict-alert-header">
        <div class="restrict-icon">!</div>
        <div>
          <h3>Emergency Restriction &amp; Acute Alcohol Poisoning Warnings</h3>
          <p style="margin: 0;">Alcohol overdose is a medical emergency that can be fatal. Restrict alcohol consumption immediately and seek immediate hospital care if you observe any of the following critical warning signs:</p>
        </div>
      </div>

      <div class="restrict-grid">
        <div class="restrict-item">
          <strong>Severe Respiratory Depression</strong>
          <span>Fewer than 8 breaths per minute or irregular breathing with gaps longer than 10 seconds between breaths.</span>
        </div>
        <div class="restrict-item">
          <strong>Loss of Consciousness &amp; Seizures</strong>
          <span>Inability to wake the individual, severe stupor, uncontrollable trembling, seizures, or violent convulsions.</span>
        </div>
        <div class="restrict-item">
          <strong>Hypothermia &amp; Skin Pallor</strong>
          <span>Pale, bluish, or clammy cold skin indicating circulatory failure and acute oxygen deprivation.</span>
        </div>
      </div>

      <div style="margin-top: 1.2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; border-top: 1px solid var(--danger-border); padding-top: 1.2rem;">
        <span style="font-weight: 700; color: var(--danger-deep);">Do not leave an unconscious person alone. Place them in the recovery position (on their side) and call emergency services.</span>
        <a class="btn btn-danger" href="tel:112">Call Emergency 112 (Toll Free)</a>
      </div>
    </div>

  </div>
</section>

<!-- 6. FINAL CALL TO ACTION -->
<section class="section" style="background: linear-gradient(135deg, #052e16 0%, #15803d 100%); color: #ffffff; text-align: center;">
  <div class="wrap" style="max-width: 720px;">
    <span class="hero-kicker-pill pill-green" style="background: rgba(255,255,255,0.18); color: #86efac; border-color: rgba(255,255,255,0.3);">
      Begin Your Journey Today
    </span>
    <h2 style="color: #ffffff; font-size: clamp(2rem, 3.5vw, 2.8rem); margin-bottom: 1rem;">Your First Step Toward Health and Freedom.</h2>
    <p style="color: #dcfce7; font-size: 1.15rem; line-height: 1.6; margin-bottom: 2rem;">Take the confidential 10-question self-screening now or connect immediately with a verified Rwandan counsellor. No real name is required.</p>
    <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
      <a class="btn btn-primary btn-lg" style="background: #ffffff; color: var(--teal-dark);" href="<?= e(url('screening.php')) ?>">
        Take the 10-Question Screening
      </a>
      <a class="btn btn-ghost-white btn-lg" href="<?= e(url('start.php')) ?>">
        Continue Anonymously
      </a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
