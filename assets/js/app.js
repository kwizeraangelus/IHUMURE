function qs(sel, root = document) { return root.querySelector(sel); }
function qsa(sel, root = document) { return [...root.querySelectorAll(sel)]; }

// 1. Clean & Professional Navigation & Mobile Toggle
const navToggle = qs('[data-nav-toggle]');
const navLinks = qs('[data-nav-links]');
const siteHeader = qs('#siteHeader');

if (navToggle && navLinks) {
  navToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    const isOpen = navLinks.classList.toggle('open');
    navToggle.classList.toggle('open', isOpen);
    navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });

  // Close menu on clicking outside
  document.addEventListener('click', (e) => {
    if (navLinks.classList.contains('open') && !siteHeader.contains(e.target)) {
      navLinks.classList.remove('open');
      navToggle.classList.remove('open');
      navToggle.setAttribute('aria-expanded', 'false');
    }
  });

  // Close menu on Escape key press
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && navLinks.classList.contains('open')) {
      navLinks.classList.remove('open');
      navToggle.classList.remove('open');
      navToggle.setAttribute('aria-expanded', 'false');
    }
  });

  // Close menu on navigation link click (e.g. hash links)
  qsa('a', navLinks).forEach(link => {
    link.addEventListener('click', () => {
      navLinks.classList.remove('open');
      navToggle.classList.remove('open');
      navToggle.setAttribute('aria-expanded', 'false');
    });
  });
}

// 1b. Header Scroll Elevation
if (siteHeader) {
  const onScroll = () => {
    if (window.scrollY > 12) {
      siteHeader.classList.add('scrolled');
    } else {
      siteHeader.classList.remove('scrolled');
    }
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
}

// 2. Generic Tab Groups
qsa('[data-tabs]').forEach(group => {
  const tabs = qsa('[data-tab]', group);
  const panes = qsa('[data-pane]', group.parentElement);
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('on'));
      tab.classList.add('on');
      const id = tab.dataset.tab;
      panes.forEach(p => p.hidden = p.dataset.pane !== id);
    });
  });
});

// 3. Hero Background Image Slider Controller
const heroSliderSection = qs('[data-hero-slider]');
if (heroSliderSection) {
  const slides = qsa('[data-hero-slide]', heroSliderSection);
  const dots = qsa('[data-hero-dot]', heroSliderSection);
  const prevBtn = qs('[data-hero-prev]', heroSliderSection);
  const nextBtn = qs('[data-hero-next]', heroSliderSection);
  let currentIndex = 0;
  let timer = null;

  const goToSlide = (index) => {
    slides.forEach((slide, i) => {
      slide.classList.toggle('active', i === index);
    });
    dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === index);
    });
    currentIndex = index;
  };

  const nextSlide = () => {
    const next = (currentIndex + 1) % slides.length;
    goToSlide(next);
  };

  const prevSlide = () => {
    const prev = (currentIndex - 1 + slides.length) % slides.length;
    goToSlide(prev);
  };

  const startAutoSlide = () => {
    stopAutoSlide();
    timer = setInterval(nextSlide, 6500);
  };

  const stopAutoSlide = () => {
    if (timer) clearInterval(timer);
  };

  if (nextBtn) nextBtn.addEventListener('click', () => { nextSlide(); startAutoSlide(); });
  if (prevBtn) prevBtn.addEventListener('click', () => { prevSlide(); startAutoSlide(); });

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      goToSlide(i);
      startAutoSlide();
    });
  });

  heroSliderSection.addEventListener('mouseenter', stopAutoSlide);
  heroSliderSection.addEventListener('mouseleave', startAutoSlide);

  startAutoSlide();
}

// 4. Interactive Middle Showcase Controller (Side-by-side Image & Text)
const interactiveSection = qs('[data-interactive-showcase]');
if (interactiveSection) {
  const tabButtons = qsa('[data-interactive-tab]', interactiveSection);
  const panes = qsa('[data-interactive-pane]', interactiveSection);
  const prevStepBtn = qs('[data-interactive-prev]', interactiveSection);
  const nextStepBtn = qs('[data-interactive-next]', interactiveSection);
  let currentStep = 0;

  const showStep = (idx) => {
    if (idx < 0) idx = panes.length - 1;
    if (idx >= panes.length) idx = 0;
    currentStep = idx;

    panes.forEach((p, i) => p.classList.toggle('active', i === currentStep));
    tabButtons.forEach((b, i) => b.classList.toggle('active', i === currentStep));
  };

  tabButtons.forEach((btn, i) => {
    btn.addEventListener('click', () => showStep(i));
    btn.addEventListener('mouseenter', () => showStep(i)); // user requested hover interaction
  });

  if (prevStepBtn) {
    prevStepBtn.addEventListener('click', () => showStep(currentStep - 1));
  }
  if (nextStepBtn) {
    nextStepBtn.addEventListener('click', () => showStep(currentStep + 1));
  }

  // Also support slide buttons inside each pane if present
  qsa('[data-pane-prev]', interactiveSection).forEach(btn => {
    btn.addEventListener('click', () => showStep(currentStep - 1));
  });
  qsa('[data-pane-next]', interactiveSection).forEach(btn => {
    btn.addEventListener('click', () => showStep(currentStep + 1));
  });
}

// 5. AUDIT Screening Wizard
const screening = qs('[data-screening]');
if (screening) {
  const cards = qsa('.q-card', screening);
  const bar = qs('[data-progress]', screening);
  let step = 0;
  const show = () => {
    cards.forEach((c, i) => c.classList.toggle('on', i === step));
    if (bar) bar.style.width = ((step + 1) / cards.length * 100) + '%';
    const stepLabel = qs('[data-step-label]', screening);
    if (stepLabel) stepLabel.textContent = `Question ${step + 1} of ${cards.length}`;
    qs('[data-prev]', screening).disabled = step === 0;
    qs('[data-next]', screening).hidden = step === cards.length - 1;
    qs('[data-submit]', screening).hidden = step !== cards.length - 1;
  };
  qs('[data-next]', screening).addEventListener('click', () => {
    const selected = qs('input:checked', cards[step]);
    if (!selected) {
      alert('Please choose an answer to continue.');
      return;
    }
    step = Math.min(cards.length - 1, step + 1);
    show();
  });
  qs('[data-prev]', screening).addEventListener('click', () => {
    step = Math.max(0, step - 1);
    show();
  });
  show();
}

// 6. Real-time Consultation Chat Polling
const chatBox = qs('[data-chat]');
if (chatBox) {
  const thread = qs('[data-msgs]', chatBox);
  const form = qs('form', chatBox);
  const url = chatBox.dataset.chat;
  const poll = async () => {
    try {
      const res = await fetch(url, { headers: { 'X-Requested-With': 'fetch' } });
      const html = await res.text();
      if (html && html !== thread.innerHTML) {
        const atBottom = thread.scrollHeight - thread.scrollTop - thread.clientHeight < 80;
        thread.innerHTML = html;
        if (atBottom) thread.scrollTop = thread.scrollHeight;
      }
    } catch (e) { /* ignore brief network gaps */ }
  };
  setInterval(poll, 3000);
  thread.scrollTop = thread.scrollHeight;
  if (form) {
    form.addEventListener('submit', async (ev) => {
      ev.preventDefault();
      const data = new FormData(form);
      await fetch(form.action, { method: 'POST', body: data });
      form.querySelector('input[name="body"]').value = '';
      poll();
    });
  }
}
