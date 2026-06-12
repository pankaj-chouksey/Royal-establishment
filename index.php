<?php include "header.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Home | Royal Establishment</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">


<style>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body{
    background: #f4f7fa;
    color: #111;
    overflow-x: hidden;
     min-height: 100vh;
    
}

/* =========================
PURE CSS SCROLL-DRIVEN ANIMATIONS
========================= */
@keyframes slideFromLeft {
    from { opacity: 0; transform: translateX(-80px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes slideFromRight {
    from { opacity: 0; transform: translateX(80px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes slideFadeUp {
    from { opacity: 0; transform: translateY(60px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-left, .animate-right, .animate-fade {
    animation-timeline: view();
    animation-range: entry 10% cover 40%;
    animation-fill-mode: both;
    animation-duration: 1s;
}

.animate-left { animation-name: slideFromLeft; }
.animate-right { animation-name: slideFromRight; }
.animate-fade { animation-name: slideFadeUp; }

/* =========================
HERO SLIDER
========================= */
.hero-wrapper {
    background: #e8e8e8;
    padding: 24px 40px 32px;
}

.hero-slider {
    position: relative;
    width: 100%;
    height: 580px;
    border-radius: 20px;
    overflow: hidden;
}

.hero-slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.8s ease;
    background-size: cover;
    background-position: center;
}

.hero-slide.active { opacity: 1; }

.hero-slide-1 { background-image: url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=1920'); }
.hero-slide-2 { background-image: url('https://images.unsplash.com/photo-1586773860418-d37222d8fce3?q=80&w=1920'); }
.hero-slide-3 { background-image: url('https://images.unsplash.com/photo-1516549655169-df83a0774514?q=80&w=1920'); }

/* Arrow buttons â€” floating on the sides */
.hero-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: rgba(255,255,255,0.85);
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #333;
    transition: background 0.2s ease, transform 0.2s ease;
    backdrop-filter: blur(4px);
}

.hero-arrow:hover {
    background: #fff;
    transform: translateY(-50%) scale(1.08);
}

.hero-arrow-prev { left: 20px; }
.hero-arrow-next { right: 20px; }

/* Dot indicators */
.hero-dots {
    position: absolute;
    bottom: 18px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
    z-index: 10;
}

.hero-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,0.55);
    cursor: pointer;
    transition: background 0.3s, transform 0.3s;
    border: none;
}

.hero-dot.active {
    background: #fff;
    transform: scale(1.3);
}

/* CTA buttons used elsewhere */
.btn-primary,
.btn-secondary {
    height: 50px;
    padding: 0 28px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50px;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    transition: .3s ease;
}

.btn-primary {
    background: #57B847;
    color: #fff;
}

.btn-primary:hover { background: #45a337; }

.btn-secondary {
    border: 2px solid #57B847;
    color: #57B847;
}

.btn-secondary:hover {
    background: #57B847;
    color: #fff;
}

@media (max-width: 768px) {
    .hero-wrapper { padding: 16px 16px 24px; }
    .hero-slider   { height: 260px; border-radius: 14px; }
    .hero-arrow    { width: 36px; height: 36px; font-size: 14px; }
}

/* =========================
SERVICES / CATEGORIES SECTION
========================= */
.services-section {
    padding: 80px 5%;
    background: #f8f9fa;
}

.section-title {
    text-align: center;
    max-width: 700px;
    margin: 0 auto 60px auto;
}

.section-title h2 {
    font-size: 38px;
    font-family: 'Poppins', sans-serif;
    color: #111;
    margin-bottom: 15px;
}

.section-title p {
    font-size: 16px;
    color: #666;
    line-height: 1.6;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 35px;
    max-width: 1200px;
    margin: 0 auto;
}

.service-card {
    background: #fff;
    border-radius: 16px;
    padding: 40px 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    transition: .3s ease;
    border-top: 4px solid #57B847;
}

.service-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 35px rgba(87,184,71,0.12);
}

.service-header h3 {
    font-size: 22px;
    color: #57B847;
    font-weight: 700;
    line-height: 1.3;
}

.service-line {
    border: 0;
    height: 1px;
    background: #e2e8f0;
    margin-top: 12px;
}

.sub-links-list {
    list-style: none;
}

.sub-links-list li {
    margin-bottom: 14px;
}

.sub-links-list a {
    text-decoration: none;
    color: #333;
    font-size: 15px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: .2s ease;
}

.sub-links-list a i {
    font-size: 12px;
    color: #a0aec0;
}

.sub-links-list a:hover {
    color: #57B847;
}

.sub-links-list a:hover i {
    color: #57B847;
    transform: translateX(3px);
}

/* =========================
TRUSTED PARTNERS & CLIENTS
========================= */
.partners-section {
    background: #e8e8e8;
    padding: 52px 40px 60px;
    overflow: hidden;
}

.partners-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 24px;
    margin-bottom: 40px;
}

.partners-header-left h2 {
    font-size: 38px;
    font-weight: 700;
    color: #111;
    letter-spacing: -0.8px;
    line-height: 1.1;
    margin-bottom: 10px;
}

.partners-header-left p {
    font-size: 14px;
    color: #666;
    line-height: 1.6;
    max-width: 380px;
}

.partners-count-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    height: 40px;
    padding: 0 20px;
    background: #57B847;
    color: #fff;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
    flex-shrink: 0;
    margin-bottom: 2px;
}

.partners-count-pill i { font-size: 14px; }

/* Marquee wrapper â€” fade edges */
.partners-marquee-wrap {
    position: relative;
    overflow: hidden;
}

.partners-marquee-wrap::before,
.partners-marquee-wrap::after {
    content: '';
    position: absolute;
    top: 0; bottom: 0;
    width: 80px;
    z-index: 2;
    pointer-events: none;
}

.partners-marquee-wrap::before {
    left: 0;
    background: linear-gradient(to right, #e8e8e8 10%, transparent);
}

.partners-marquee-wrap::after {
    right: 0;
    background: linear-gradient(to left, #e8e8e8 10%, transparent);
}

/* Track */
.partners-marquee-track {
    display: flex;
    width: fit-content;
    gap: 16px;
    padding: 8px 0;
    animation: partnersScroll 28s linear infinite;
}

.partners-marquee-track:hover {
    animation-play-state: paused;
}

@keyframes partnersScroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

/* Logo card */
.partner-logo-box {
    flex-shrink: 0;
    width: 160px;
    height: 80px;
    background: #fff;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 14px 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,.05);
    transition: box-shadow .25s, transform .25s;
}

.partner-logo-box:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,.10);
    transform: translateY(-3px);
}

.partner-logo-box img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    filter: grayscale(100%);
    opacity: 0.55;
    transition: filter .3s, opacity .3s;
}

.partner-logo-box:hover img {
    filter: grayscale(0%);
    opacity: 1;
}

@media (max-width: 768px) {
    .partners-section { padding: 36px 20px 44px; }
    .partners-header { flex-direction: column; align-items: flex-start; gap: 14px; }
    .partners-header-left h2 { font-size: 26px; }
    .partner-logo-box { width: 130px; height: 68px; }
}

/* =========================
STATS / ANALYTICS SECTION
========================= */
.royal-counter-section {
    background: #e8e8e8;
    padding: 0 40px 60px;
}

.royal-counter-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
}

.royal-counter-card {
    background: #fff;
    border-radius: 18px;
    padding: 36px 24px 32px;
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 10px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    transition: transform .25s, box-shadow .25s;
    position: relative;
    overflow: hidden;
}

.royal-counter-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: #57B847;
    border-radius: 18px 18px 0 0;
    transform: scaleX(0);
    transition: transform .3s ease;
    transform-origin: left;
}

.royal-counter-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(0,0,0,.10);
}

.royal-counter-card:hover::before {
    transform: scaleX(1);
}

.royal-counter-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #f0faf0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #57B847;
    margin-bottom: 4px;
}

.royal-counter-number {
    font-size: 44px;
    font-weight: 800;
    color: #111;
    letter-spacing: -2px;
    line-height: 1;
}

.royal-counter-number .counter-suffix {
    font-size: 28px;
    font-weight: 700;
    letter-spacing: -1px;
}

.royal-counter-label {
    font-size: 13.5px;
    font-weight: 500;
    color: #777;
    letter-spacing: 0.1px;
}

@media (max-width: 900px) {
    .royal-counter-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 480px) {
    .royal-counter-section { padding: 0 20px 44px; }
    .royal-counter-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .royal-counter-card { padding: 24px 18px; }
    .royal-counter-number { font-size: 34px; }
}

/* =========================
GET IN TOUCH SECTION
========================= */
.git-section {
    background: #e8e8e8;
    padding: 64px 40px 72px;
}

.git-inner {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: start;
}

/* â”€â”€ Left panel â”€â”€ */
.git-eyebrow {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #888;
    margin-bottom: 20px;
}

.git-title {
    font-size: 40px;
    font-weight: 700;
    color: #111;
    line-height: 1.1;
    letter-spacing: -1px;
    margin-bottom: 20px;
}

.git-desc {
    font-size: 14px;
    color: #666;
    line-height: 1.75;
    margin-bottom: 44px;
    max-width: 380px;
}

.git-contact-items {
    display: flex;
    flex-direction: column;
    gap: 28px;
}

.git-contact-item {}

.git-contact-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #888;
    margin-bottom: 5px;
}

.git-contact-value {
    font-size: 15px;
    font-weight: 500;
    color: #111;
    text-decoration: none;
    transition: color .2s;
}

.git-contact-value:hover { color: #57B847; }

/* â”€â”€ Right form â”€â”€ */
.git-form {
    display: flex;
    flex-direction: column;
    gap: 0;
}

.git-field {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 28px;
}

.git-field label {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #444;
}

.git-field input,
.git-field textarea,
.git-field select {
    background: transparent;
    border: none;
    border-bottom: 1.5px solid #999;
    border-radius: 0;
    padding: 10px 0;
    font-size: 15px;
    color: #111;
    font-family: 'Poppins', sans-serif;
    outline: none;
    width: 100%;
    transition: border-color .2s;
    -webkit-appearance: none;
}

.git-field input::placeholder,
.git-field textarea::placeholder {
    color: #777;
    font-weight: 400;
    font-family: 'Poppins', sans-serif;
}

.git-field input:focus,
.git-field textarea:focus,
.git-field select:focus {
    border-bottom-color: #111;
}

.git-field textarea {
    resize: none;
    min-height: 72px;
}

/* Phone row â€” flag + code + number */
.git-phone-row {
    display: flex;
    gap: 10px;
    align-items: flex-end;
    border-bottom: 1.5px solid #999;
    transition: border-color .2s;
}

.git-phone-row:focus-within {
    border-bottom-color: #111;
}

.git-phone-row select {
    border: none;
    border-bottom: none;
    width: 90px;
    flex-shrink: 0;
    padding: 10px 0;
    font-size: 14px;
    color: #111;
    background: transparent;
    font-family: 'Poppins', sans-serif;
    outline: none;
    cursor: pointer;
}

.git-phone-row input {
    border: none;
    border-bottom: none;
    flex: 1;
    padding: 10px 0;
    font-size: 15px;
    font-family: 'Poppins', sans-serif;
    color: #111;
}

.git-phone-row input:focus,
.git-phone-row select:focus {
    border-bottom: none;
}

.git-submit {
    margin-top: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 50px;
    padding: 0 32px;
    background: #111;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
    transition: background .2s, transform .2s;
    width: fit-content;
}

.git-submit:hover {
    background: #57B847;
    transform: translateY(-2px);
}

@media (max-width: 860px) {
    .git-inner { grid-template-columns: 1fr; gap: 48px; }
    .git-title  { font-size: 32px; }
}

@media (max-width: 768px) {
    .git-section { padding: 48px 20px 56px; }
    .git-title   { font-size: 26px; }
}

/* =========================
RESPONSIVE
========================= */
@media(max-width: 1024px){
    .services-grid, .royal-counter-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .why-choose-container {
        grid-template-columns: 1fr;
    }
}

@media(max-width: 768px) {
    .services-grid, .industries-grid, .royal-counter-grid {
        grid-template-columns: 1fr;
    }
    .enquiry-container {
        grid-template-columns: 1fr;
    }

    html, body {
        max-width: 100%;
        overflow-x: hidden;
    }

    .btn-primary,
    .btn-secondary {
        width: 85%;
        text-align: center;
        justify-content: center;
    }

    .philosophy-section,
    .services-section,
    .partners-section,
    .royal-counter-section,
    .git-section {
        padding-left: 20px;
        padding-right: 20px;
        overflow-x: hidden;
    }

    .royal-counter-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .royal-counter-number {
        font-size: 36px;
    }

    .enquiry-form-box {
        padding: 20px;
    }

    /* --- Mobile pe logo thoda chhota --- */
    .partner-logo-box {
        width: 120px;
        margin: 0 18px;
    }

    .partner-logo-box img {
        max-width: 100px;
        height: 45px;
    }

    .section-title h2,
    .why-choose-content-box h2,
    .enquiry-text h2 {
        font-size: 26px;
    }
}
</style>
</head>
<body>

<!-- HERO SLIDER -->
<div class="hero-wrapper">
    <div class="hero-slider" id="heroSlider">

        <div class="hero-slide hero-slide-1 active"></div>
        <div class="hero-slide hero-slide-2"></div>
        <div class="hero-slide hero-slide-3"></div>

        <!-- Prev / Next -->
        <button class="hero-arrow hero-arrow-prev" id="heroPrev" aria-label="Previous slide">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button class="hero-arrow hero-arrow-next" id="heroNext" aria-label="Next slide">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

        <!-- Dots -->
        <div class="hero-dots">
            <button class="hero-dot active" data-index="0" aria-label="Slide 1"></button>
            <button class="hero-dot" data-index="1" aria-label="Slide 2"></button>
            <button class="hero-dot" data-index="2" aria-label="Slide 3"></button>
        </div>
    </div>
</div>

<script>
(function () {
    const slides = document.querySelectorAll('.hero-slide');
    const dots   = document.querySelectorAll('.hero-dot');
    let current  = 0;
    let timer;

    function goTo(n) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = (n + slides.length) % slides.length;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
    }

    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }

    function startAuto() {
        timer = setInterval(next, 5000);
    }

    function resetAuto() {
        clearInterval(timer);
        startAuto();
    }

    document.getElementById('heroNext').addEventListener('click', () => { next(); resetAuto(); });
    document.getElementById('heroPrev').addEventListener('click', () => { prev(); resetAuto(); });

    dots.forEach(dot => {
        dot.addEventListener('click', () => { goTo(+dot.dataset.index); resetAuto(); });
    });

    // Pause on hover
    document.getElementById('heroSlider').addEventListener('mouseenter', () => clearInterval(timer));
    document.getElementById('heroSlider').addEventListener('mouseleave', startAuto);

    startAuto();
})();
</script>


<?php include "home-products.php" ?>

<?php include "hf-hospital-furni-products.php" ?>

<!-- OUR EXPERTISE SECTION -->
<section class="exp-section" id="services">
    <div class="exp-grid">

        <!-- Block 1: Title -->
        <div class="exp-card exp-card--title">
            <h2 class="exp-title">Our<br>Expertise</h2>
            <p class="exp-sub">Browse our best-in-class hospital furniture and biomedical equipment</p>
        </div>

        <!-- Block 2: Hospital Furniture -->
        <a href="<?= BASE_URL ?>Hospital_Furniture.php" class="exp-card">
            <div class="exp-icon">
                <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="8" y="34" width="64" height="18" rx="4" stroke="#333" stroke-width="4"/>
                    <rect x="8" y="24" width="24" height="14" rx="3" stroke="#333" stroke-width="4"/>
                    <rect x="12" y="27" width="16" height="8" rx="2" fill="#ddd" stroke="#333" stroke-width="2.5"/>
                    <line x1="16" y1="52" x2="16" y2="64" stroke="#333" stroke-width="4" stroke-linecap="round"/>
                    <line x1="64" y1="52" x2="64" y2="64" stroke="#333" stroke-width="4" stroke-linecap="round"/>
                </svg>
            </div>
            <span class="exp-card-name">Hospital Furniture's</span>
        </a>

        <!-- Block 3: Modular OT -->
        <a href="<?= BASE_URL ?>Moduler_OT.php" class="exp-card">
            <div class="exp-icon">
                <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="40" cy="17" r="8" stroke="#333" stroke-width="4"/>
                    <line x1="40" y1="25" x2="40" y2="37" stroke="#333" stroke-width="3.5" stroke-linecap="round"/>
                    <line x1="32" y1="30" x2="27" y2="35" stroke="#333" stroke-width="2.5" stroke-linecap="round"/>
                    <line x1="48" y1="30" x2="53" y2="35" stroke="#333" stroke-width="2.5" stroke-linecap="round"/>
                    <rect x="14" y="37" width="52" height="11" rx="3" stroke="#333" stroke-width="4"/>
                    <line x1="22" y1="48" x2="22" y2="60" stroke="#333" stroke-width="4" stroke-linecap="round"/>
                    <line x1="58" y1="48" x2="58" y2="60" stroke="#333" stroke-width="4" stroke-linecap="round"/>
                    <line x1="18" y1="60" x2="26" y2="60" stroke="#333" stroke-width="3.5" stroke-linecap="round"/>
                    <line x1="54" y1="60" x2="62" y2="60" stroke="#333" stroke-width="3.5" stroke-linecap="round"/>
                </svg>
            </div>
            <span class="exp-card-name">Modular OT Solutions</span>
        </a>

        <!-- Block 4: Gas Pipeline -->
        <a href="<?= BASE_URL ?>Gas_Pipeline_Solution.php" class="exp-card">
            <div class="exp-icon">
                <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="10" y1="40" x2="33" y2="40" stroke="#333" stroke-width="5" stroke-linecap="round"/>
                    <line x1="47" y1="40" x2="70" y2="40" stroke="#333" stroke-width="5" stroke-linecap="round"/>
                    <rect x="33" y="30" width="14" height="20" rx="3" stroke="#333" stroke-width="4"/>
                    <line x1="40" y1="22" x2="40" y2="30" stroke="#333" stroke-width="4" stroke-linecap="round"/>
                    <line x1="35" y1="22" x2="45" y2="22" stroke="#333" stroke-width="3.5" stroke-linecap="round"/>
                    <rect x="56" y="44" width="10" height="18" rx="3" stroke="#333" stroke-width="3.5"/>
                    <rect x="58" y="40" width="6" height="6" rx="2" stroke="#333" stroke-width="3"/>
                </svg>
            </div>
            <span class="exp-card-name">Medical Gas Pipeline &amp; Oxygen Plant</span>
        </a>

        <!-- Block 5: Cold Room -->
        <a href="<?= BASE_URL ?>BBR_Maintenance.php" class="exp-card">
            <div class="exp-icon">
                <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="40" y1="10" x2="40" y2="70" stroke="#333" stroke-width="4" stroke-linecap="round"/>
                    <line x1="10" y1="40" x2="70" y2="40" stroke="#333" stroke-width="4" stroke-linecap="round"/>
                    <line x1="18.6" y1="18.6" x2="61.4" y2="61.4" stroke="#333" stroke-width="4" stroke-linecap="round"/>
                    <line x1="61.4" y1="18.6" x2="18.6" y2="61.4" stroke="#333" stroke-width="4" stroke-linecap="round"/>
                    <line x1="40" y1="10" x2="34" y2="18" stroke="#333" stroke-width="3" stroke-linecap="round"/>
                    <line x1="40" y1="10" x2="46" y2="18" stroke="#333" stroke-width="3" stroke-linecap="round"/>
                    <line x1="40" y1="70" x2="34" y2="62" stroke="#333" stroke-width="3" stroke-linecap="round"/>
                    <line x1="40" y1="70" x2="46" y2="62" stroke="#333" stroke-width="3" stroke-linecap="round"/>
                    <line x1="10" y1="40" x2="18" y2="34" stroke="#333" stroke-width="3" stroke-linecap="round"/>
                    <line x1="10" y1="40" x2="18" y2="46" stroke="#333" stroke-width="3" stroke-linecap="round"/>
                    <line x1="70" y1="40" x2="62" y2="34" stroke="#333" stroke-width="3" stroke-linecap="round"/>
                    <line x1="70" y1="40" x2="62" y2="46" stroke="#333" stroke-width="3" stroke-linecap="round"/>
                    <circle cx="40" cy="40" r="5" fill="#333"/>
                </svg>
            </div>
            <span class="exp-card-name">Cold Room Maintenance &amp; Solutions</span>
        </a>

        <!-- Block 6: Bio Medical Maintenance -->
        <a href="<?= BASE_URL ?>Critical_Equipments_Repair.php" class="exp-card">
            <div class="exp-icon">
                <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="10" y="14" width="46" height="34" rx="4" stroke="#333" stroke-width="4"/>
                    <polyline points="16,31 22,31 27,20 32,42 37,26 42,31 50,31" stroke="#333" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="33" y1="48" x2="33" y2="58" stroke="#333" stroke-width="4" stroke-linecap="round"/>
                    <line x1="24" y1="58" x2="42" y2="58" stroke="#333" stroke-width="4" stroke-linecap="round"/>
                    <path d="M62 20 C68 24 72 32 68 40 C65 46 60 48 57 46" stroke="#333" stroke-width="3.5" stroke-linecap="round" fill="none"/>
                    <circle cx="56" cy="48" r="3.5" stroke="#333" stroke-width="3"/>
                </svg>
            </div>
            <span class="exp-card-name">Bio Medical Equipment Maintenance</span>
        </a>

        <!-- Block 7: Calibration & PMS -->
        <a href="<?= BASE_URL ?>Bio-medical_Equipment_Calibration.php" class="exp-card">
            <div class="exp-icon">
                <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 54 A26 26 0 1 1 64 54" stroke="#333" stroke-width="4" stroke-linecap="round"/>
                    <line x1="40" y1="12" x2="40" y2="19" stroke="#333" stroke-width="3" stroke-linecap="round"/>
                    <line x1="18" y1="20" x2="23" y2="25" stroke="#333" stroke-width="3" stroke-linecap="round"/>
                    <line x1="62" y1="20" x2="57" y2="25" stroke="#333" stroke-width="3" stroke-linecap="round"/>
                    <line x1="12" y1="42" x2="19" y2="42" stroke="#333" stroke-width="3" stroke-linecap="round"/>
                    <line x1="61" y1="42" x2="68" y2="42" stroke="#333" stroke-width="3" stroke-linecap="round"/>
                    <line x1="40" y1="40" x2="27" y2="27" stroke="#333" stroke-width="3.5" stroke-linecap="round"/>
                    <circle cx="40" cy="40" r="4" fill="#333"/>
                    <polyline points="50,58 54,64 65,50" stroke="#57B847" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <span class="exp-card-name">Calibration &amp; PMS Solutions</span>
        </a>

        <!-- Block 8: Neonatal Care -->
        <a href="<?= BASE_URL ?>products.php" class="exp-card">
            <div class="exp-icon">
                <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="10" y="32" width="60" height="30" rx="6" stroke="#333" stroke-width="4"/>
                    <path d="M20 32 Q20 16 40 16 Q60 16 60 32" stroke="#333" stroke-width="4" stroke-linecap="round" fill="none"/>
                    <circle cx="40" cy="42" r="6" stroke="#333" stroke-width="3"/>
                    <path d="M34 54 Q34 48 40 48 Q46 48 46 54" stroke="#333" stroke-width="3" stroke-linecap="round" fill="none"/>
                    <line x1="20" y1="62" x2="20" y2="70" stroke="#333" stroke-width="4" stroke-linecap="round"/>
                    <line x1="60" y1="62" x2="60" y2="70" stroke="#333" stroke-width="4" stroke-linecap="round"/>
                    <circle cx="17" cy="47" r="3.5" stroke="#333" stroke-width="2.5"/>
                    <circle cx="63" cy="47" r="3.5" stroke="#333" stroke-width="2.5"/>
                </svg>
            </div>
            <span class="exp-card-name">Neonatal Care Products</span>
        </a>

    </div>
</section>

<style>
.exp-section {
    background: #e8e8e8;
    padding: 48px 40px 56px;
}
.exp-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
}
.exp-card {
    background: #f4f4f4;
    border-radius: 20px;
    padding: 20px 16px 18px;
    text-decoration: none;
    color: #111;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    aspect-ratio: 5 / 4;
    transition: background .25s, transform .25s, box-shadow .25s;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.exp-card:hover {
    background: #fff;
    transform: translateY(-5px);
    box-shadow: 0 14px 40px rgba(0,0,0,.10);
    color: #111;
}
.exp-card--title {
    background: #ebebeb;
    justify-content: flex-end;
    align-items: flex-start;
    text-align: left;
    gap: 10px;
    cursor: default;
    padding: 20px 20px;
}
.exp-card--title:hover {
    background: #ebebeb;
    transform: none;
    box-shadow: none;
}
.exp-title {
    font-size: 34px;
    font-weight: 700;
    color: #111;
    line-height: 1.1;
    letter-spacing: -1px;
    margin: 0;
}
.exp-sub {
    font-size: 12.5px;
    color: #666;
    line-height: 1.65;
    margin: 0;
}
.exp-icon {
    width: 54px;
    height: 54px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: transform .3s ease;
}
.exp-icon svg { width: 100%; height: 100%; }
.exp-card:hover .exp-icon { transform: scale(1.1); }
.exp-card-name {
    font-size: 13px;
    font-weight: 600;
    line-height: 1.35;
    color: #222;
}
@media (max-width: 1024px) {
    .exp-title { font-size: 28px; }
    .exp-icon  { width: 56px; height: 56px; }
}
@media (max-width: 860px) {
    .exp-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .exp-section { padding: 36px 20px 44px; }
    .exp-grid    { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .exp-card    { aspect-ratio: 1/1; padding: 20px 14px; }
    .exp-title   { font-size: 24px; }
    .exp-icon    { width: 48px; height: 48px; }
    .exp-card-name { font-size: 12px; }
}
@media (max-width: 480px) {
    .exp-icon  { width: 42px; height: 42px; }
    .exp-title { font-size: 20px; }
}
</style>

<!-- TRUSTED PARTNERS & CLIENTS SECTION -->
<section class="partners-section">

    <div class="partners-header">
        <div class="partners-header-left">
            <h2>Trusted Partners &amp; Clients</h2>
            <p>Collaborating with top institutional brands to scale medical infrastructure standards globally.</p>
        </div>
        <span class="partners-count-pill">
            <i class="fa-solid fa-handshake"></i>
            9+ Partners
        </span>
    </div>

    <div class="partners-marquee-wrap">
        <div class="partners-marquee-track">
            <!-- Set 1 -->
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/partners/anant.jpg" alt="Anant Hospital"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/ab-hospital.png" alt="AB Hospital"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/logo2.gif" alt="Partner"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/rkdf-medical-college-bhopal-1--500x500.webp" alt="RKDF Medical College"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/knp.webp" alt="KNP"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/qt=q_95.webp" alt="Partner"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/university-logo1.png" alt="University"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/JaesLogo.png" alt="JAES"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/HOSPITAL-LOGO-1.webp" alt="Hospital"></div>
            <!-- Set 2 â€” duplicate for seamless loop -->
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/partners/anant.jpg" alt="Anant Hospital"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/ab-hospital.png" alt="AB Hospital"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/logo2.gif" alt="Partner"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/rkdf-medical-college-bhopal-1--500x500.webp" alt="RKDF Medical College"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/knp.webp" alt="KNP"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/qt=q_95.webp" alt="Partner"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/university-logo1.png" alt="University"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/JaesLogo.png" alt="JAES"></div>
            <div class="partner-logo-box"><img src="<?= BASE_URL ?>Images/Partners/HOSPITAL-LOGO-1.webp" alt="Hospital"></div>
        </div>
    </div>

</section>

<!-- STATS / ANALYTICS SECTION -->
<section class="royal-counter-section">
    <div class="royal-counter-grid animate-fade">

        <div class="royal-counter-card">
            <div class="royal-counter-icon"><i class="fa-solid fa-calendar-check"></i></div>
            <div class="royal-counter-number" data-target="15">0<span class="counter-suffix">+</span></div>
            <div class="royal-counter-label">Years Experience</div>
        </div>

        <div class="royal-counter-card">
            <div class="royal-counter-icon"><i class="fa-solid fa-box-open"></i></div>
            <div class="royal-counter-number" data-target="500">0<span class="counter-suffix">+</span></div>
            <div class="royal-counter-label">Medical Products</div>
        </div>

        <div class="royal-counter-card">
            <div class="royal-counter-icon"><i class="fa-solid fa-hospital-user"></i></div>
            <div class="royal-counter-number" data-target="100">0<span class="counter-suffix">+</span></div>
            <div class="royal-counter-label">Trusted Clients</div>
        </div>

        <div class="royal-counter-card">
            <div class="royal-counter-icon"><i class="fa-solid fa-headset"></i></div>
            <div class="royal-counter-number">24<span class="counter-suffix">/7</span></div>
            <div class="royal-counter-label">Technical Support</div>
        </div>

    </div>
</section>

<!-- GET IN TOUCH SECTION -->
<section class="git-section" id="contact">
    <div class="git-inner">

        <!-- Left: info -->
        <div class="git-left">
            <p class="git-eyebrow">Get in touch</p>
            <h2 class="git-title">Partner with Royal<br>Establishment</h2>
            <p class="git-desc">Have a project requirement, infrastructure setup, or maintenance enquiry? We're always open to discussing medical engineering projects and turnkey hospital solutions.</p>

            <div class="git-contact-items">
                <div class="git-contact-item">
                    <div class="git-contact-label">Mail us</div>
                    <a href="mailto:info@royalestablishment.in" class="git-contact-value">info@royalestablishment.in</a>
                </div>
                <div class="git-contact-item">
                    <div class="git-contact-label">Call us</div>
                    <a href="tel:+917869XXXXXX" class="git-contact-value">+91 78691 XXXXX</a>
                </div>
                <div class="git-contact-item">
                    <div class="git-contact-label">Location</div>
                    <span class="git-contact-value">Bhopal, Madhya Pradesh, India</span>
                </div>
            </div>
        </div>

        <!-- Right: form -->
        <div class="git-right">
            <form class="git-form" action="#" method="POST">

                <!-- Name -->
                <div class="git-field">
                    <label for="git_name">Name</label>
                    <input type="text" id="git_name" name="name" placeholder="Your name" required>
                </div>

                <!-- Email -->
                <div class="git-field">
                    <label for="git_email">Email</label>
                    <input type="email" id="git_email" name="email" placeholder="your@email.com" required>
                </div>

                <!-- Phone with country code -->
                <div class="git-field">
                    <label>Phone Number</label>
                    <div class="git-phone-row">
                        <select name="country_code" aria-label="Country code">
                            <option value="+91">ðŸ‡®ðŸ‡³ +91</option>
                            <option value="+1">ðŸ‡ºðŸ‡¸ +1</option>
                            <option value="+44">ðŸ‡¬ðŸ‡§ +44</option>
                            <option value="+971">ðŸ‡¦ðŸ‡ª +971</option>
                            <option value="+966">ðŸ‡¸ðŸ‡¦ +966</option>
                            <option value="+252">ðŸ‡¸ðŸ‡´ +252</option>
                            <option value="+33">ðŸ‡«ðŸ‡· +33</option>
                            <option value="+49">ðŸ‡©ðŸ‡ª +49</option>
                            <option value="+61">ðŸ‡¦ðŸ‡º +61</option>
                        </select>
                        <input type="tel" name="phone" placeholder="Phone number" required>
                    </div>
                </div>

                <!-- Facility -->
                <div class="git-field">
                    <label for="git_facility">Hospital / Facility</label>
                    <input type="text" id="git_facility" name="facility" placeholder="Hospital or facility name" required>
                </div>

                <!-- Description (optional) -->
                <div class="git-field">
                    <label for="git_desc">Description <span style="font-weight:400;text-transform:none;letter-spacing:0;font-size:11px;color:#bbb;">(optional)</span></label>
                    <textarea id="git_desc" name="description" placeholder="Tell us about your project or requirement..."></textarea>
                </div>

                <button type="submit" class="git-submit">Send message</button>

            </form>
        </div>

    </div>
</section>

<!-- COUNTER SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const counterElements = document.querySelectorAll(".royal-counter-number[data-target]");

    const countUp = (element) => {
        const target  = parseInt(element.getAttribute("data-target"), 10);
        const suffix  = element.querySelector('.counter-suffix');
        const suffixHTML = suffix ? suffix.outerHTML : '';
        let current = 0;
        const duration = 1800;
        const steps    = 60;
        const stepTime = Math.floor(duration / steps);
        const increment = Math.ceil(target / steps);

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.innerHTML = target + suffixHTML;
                clearInterval(timer);
            } else {
                element.innerHTML = current + suffixHTML;
            }
        }, stepTime);
    };

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                countUp(entry.target);
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });

    counterElements.forEach(el => observer.observe(el));
});
</script>

<?php include "footer.php" ?>

</body>
</html>