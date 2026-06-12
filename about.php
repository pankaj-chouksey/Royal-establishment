<?php include "header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Royal Establishment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fb;
            color: #1a1a2e;
            overflow-x: hidden;
        }

        /* =========================
        ANIMATION 12: CUSTOM SCROLLBAR
        ========================= */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #57B847;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #3a9b2e;
        }

        /* =========================
        ANIMATION 5: PROGRESS BAR
        ========================= */
        .progress-bar-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: transparent;
            z-index: 10000;
        }
        .progress-bar-fill {
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, #57B847, #22C55E);
            transition: width 0.3s ease;
        }

        /* =========================
        ANIMATION 11: SCROLL TO TOP BUTTON
        ========================= */
        .scroll-top-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: #57B847;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 9999;
            box-shadow: 0 5px 20px rgba(87,184,71,0.3);
        }
        .scroll-top-btn.show {
            opacity: 1;
            visibility: visible;
        }
        .scroll-top-btn:hover {
            background: #3a9b2e;
            transform: translateY(-5px);
        }
        .scroll-top-btn i {
            color: #fff;
            font-size: 20px;
        }

        /* =========================
        ANIMATION 7: FLOATING ANIMATION
        ========================= */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        .float-element {
            animation: float 3s ease-in-out infinite;
        }

        /* =========================
        ANIMATION 8: GLOW EFFECT
        ========================= */
        @keyframes glow {
            0%, 100% { text-shadow: 0 0 5px rgba(87,184,71,0.3); }
            50% { text-shadow: 0 0 20px rgba(87,184,71,0.6), 0 0 30px rgba(87,184,71,0.4); }
        }
        .glow-text {
            animation: glow 2s ease-in-out infinite;
        }

        /* =========================
        ANIMATION 2: PAGE SCROLL ANIMATION (FADE/SLIDE)
        ========================= */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes scaleUp {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
        .scroll-animate {
            opacity: 0;
            transition: all 0.8s ease;
        }
        .scroll-animate.visible {
            opacity: 1;
        }
        .fade-up.visible { animation: fadeInUp 0.8s forwards; }
        .fade-left.visible { animation: fadeInLeft 0.8s forwards; }
        .fade-right.visible { animation: fadeInRight 0.8s forwards; }
        .scale-up.visible { animation: scaleUp 0.8s forwards; }

        /* =========================
        ANIMATION 10: 3D HOVER EFFECT
        ========================= */
        .tilt-card {
            transition: transform 0.3s ease;
            transform-style: preserve-3d;
        }
        .tilt-card:hover {
            transform: perspective(1000px) rotateX(5deg) rotateY(5deg) translateY(-10px);
        }

        /* =========================
        GLASSMORPHISM STYLES
        ========================= */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(87, 184, 71, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
        }
        .glass-card-dark {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(87, 184, 71, 0.3);
        }

        /* =========================
        HERO SECTION
        ========================= */
        .about-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 120px 0 100px;
            position: relative;
            overflow: hidden;
        }
        .about-hero h1 {
            font-size: 64px;
            font-weight: 800;
            color: #fff;
            font-family: 'Poppins', sans-serif;
        }
        .typing-text {
            font-size: 24px;
            color: #57B847;
            font-weight: 600;
            margin-top: 20px;
        }
        .typing-text .typed {
            border-right: 3px solid #57B847;
            padding-right: 5px;
        }

        /* =========================
        COUNTER SECTION
        ========================= */
        .counter-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .counter-number {
            font-size: 48px;
            font-weight: 800;
            color: #57B847;
        }

        /* =========================
        TESTIMONIAL CAROUSEL (Infinite Scroll)
        ========================= */
        .testimonial-carousel {
            overflow: hidden;
            position: relative;
            padding: 20px 0;
        }
        .testimonial-track {
            display: flex;
            gap: 30px;
            width: fit-content;
            animation: scrollTestimonials 25s linear infinite;
        }
        .testimonial-track:hover {
            animation-play-state: paused;
        }
        @keyframes scrollTestimonials {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .testimonial-card {
            width: 350px;
            flex-shrink: 0;
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        /* =========================
        PARALLAX BACKGROUND
        ========================= */
        .parallax-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=1600');
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            padding: 80px 0;
            color: #fff;
        }

        /* =========================
        RESPONSIVE
        ========================= */
        @media (max-width: 768px) {
            .about-hero h1 { font-size: 40px; }
            .typing-text { font-size: 18px; }
            .counter-number { font-size: 32px; }
        }
    </style>
</head>
<body>

<!-- ANIMATION 5: PROGRESS BAR -->
<div class="progress-bar-container">
    <div class="progress-bar-fill" id="progressBar"></div>
</div>

<!-- ANIMATION 11: SCROLL TO TOP BUTTON -->
<div class="scroll-top-btn" id="scrollTopBtn">
    <i class="fa-solid fa-arrow-up"></i>
</div>

<!-- HERO SECTION WITH TYPING EFFECT & GLOW -->
<section class="about-hero">
    <div class="container text-center">
        <div class="hero-badge float-element">EST. 2023</div>
        <h1 class="glow-text">About <span style="color:#57B847;">Royal Establishment</span></h1>
        <div class="typing-text">
            We are <span class="typed" id="typedText"></span>
        </div>
    </div>
</section>

<!-- COUNTER ANIMATION SECTION -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 col-6 scroll-animate fade-up">
                <div class="counter-card tilt-card">
                    <i class="fa-solid fa-calendar-alt" style="font-size: 40px; color:#57B847;"></i>
                    <div class="counter-number" data-target="25">0</div>
                    <div>Years Experience</div>
                </div>
            </div>
            <div class="col-md-3 col-6 scroll-animate fade-up delay-1">
                <div class="counter-card tilt-card">
                    <i class="fa-solid fa-box" style="font-size: 40px; color:#57B847;"></i>
                    <div class="counter-number" data-target="500">0</div>
                    <div>Products Delivered</div>
                </div>
            </div>
            <div class="col-md-3 col-6 scroll-animate fade-up delay-2">
                <div class="counter-card tilt-card">
                    <i class="fa-solid fa-hospital-user" style="font-size: 40px; color:#57B847;"></i>
                    <div class="counter-number" data-target="150">0</div>
                    <div>Happy Clients</div>
                </div>
            </div>
            <div class="col-md-3 col-6 scroll-animate fade-up delay-3">
                <div class="counter-card tilt-card">
                    <i class="fa-solid fa-trophy" style="font-size: 40px; color:#57B847;"></i>
                    <div class="counter-number" data-target="50">0</div>
                    <div>Projects Completed</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- COMPANY BACKGROUND - GLASS CARD -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0 scroll-animate fade-left">
                <div class="glass-card p-4 rounded-4">
                    <h2 class="mb-4">Company <span style="color:#57B847;">Background</span></h2>
                    <p>Royal Establishment was officially established in 2023 with a vision to provide high-quality healthcare infrastructure, medical equipment, and biomedical engineering solutions at competitive prices. The foundation of the company is built upon more than two decades of industry experience.</p>
                    <p>Under the leadership of <strong>Mr. Javed Akhtar</strong>, the company has evolved into a comprehensive solution partner for hospitals, healthcare institutions, government organizations, and private medical facilities.</p>
                </div>
            </div>
            <div class="col-lg-6 scroll-animate fade-right">
                <div class="glass-card p-3 rounded-4">
                    <img src="images/RE-building.png" class="w-100 rounded-3" style="height: 350px; object-fit: cover;" alt="Royal Establishment">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOUNDER SECTION -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 scroll-animate fade-up">
            <h2>Our <span style="color:#57B847;">Founder</span></h2>
            <p>The visionary leader behind Royal Establishment's success</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10 scroll-animate scale-up">
                <div class="glass-card rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-5">
                            <img src="" alt="Founder" class="w-100" style="height: 100%; object-fit: cover;" alt="Mr. Javed Akhtar">
                        </div>
                        <div class="col-md-7">
                            <div class="p-4 p-lg-5">
                                <h3 class="mb-2">Mr. Javed Akhtar</h3>
                                <p class="text-success mb-3">Founder & Managing Director</p>
                                <p>Mr. Javed Akhtar has over <strong>25+ years of experience</strong> in the healthcare and biomedical industry. He began his journey in the radiology sector and later expanded into medical equipment trading.</p>
                                <p>In <strong>2016</strong>, he entered the Biomedical Equipment Maintenance and Management (BMEM) sector. In <strong>2019</strong>, he established Royal Establishment, a manufacturing unit for premium hospital furniture.</p>
                                <div class="mt-3">
                                    <i class="fa-solid fa-quote-left text-success me-2"></i> Quality is not just a standard, it's a commitment.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PARALLAX BACKGROUND SECTION -->
<section class="parallax-section">
    <div class="container text-center">
        <div class="scroll-animate fade-up">
            <h2 class="mb-3">25+ Years of Excellence</h2>
            <p class="mb-4">Serving the healthcare industry with dedication and innovation</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <span class="badge bg-success px-4 py-2 m-1">ISO Certified</span>
                <span class="badge bg-success px-4 py-2 m-1">Quality Assured</span>
                <span class="badge bg-success px-4 py-2 m-1">24/7 Support</span>
            </div>
        </div>
    </div>
</section>

<!-- EXPERTISE SECTION - 3D HOVER CARDS -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 scroll-animate fade-up">
            <h2>Our Core <span style="color:#57B847;">Expertise</span></h2>
            <p>End-to-end healthcare solutions tailored to modern medical needs</p>
        </div>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6 scroll-animate scale-up">
                <div class="glass-card p-4 text-center rounded-4 tilt-card">
                    <div class="float-element"><i class="fa-solid fa-microscope" style="font-size: 48px; color:#57B847;"></i></div>
                    <h5 class="mt-3">Biomedical Maintenance</h5>
                    <p class="small">Comprehensive equipment maintenance programs</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 scroll-animate scale-up delay-1">
                <div class="glass-card p-4 text-center rounded-4 tilt-card">
                    <div class="float-element"><i class="fa-solid fa-truck-medical" style="font-size: 48px; color:#57B847;"></i></div>
                    <h5 class="mt-3">Medical Equipment Supply</h5>
                    <p class="small">Quality equipment supply and installation</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 scroll-animate scale-up delay-2">
                <div class="glass-card p-4 text-center rounded-4 tilt-card">
                    <div class="float-element"><i class="fa-solid fa-building" style="font-size: 48px; color:#57B847;"></i></div>
                    <h5 class="mt-3">Infrastructure Development</h5>
                    <p class="small">Complete hospital infrastructure solutions</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 scroll-animate scale-up delay-3">
                <div class="glass-card p-4 text-center rounded-4 tilt-card">
                    <div class="float-element"><i class="fa-solid fa-file-signature" style="font-size: 48px; color:#57B847;"></i></div>
                    <h5 class="mt-3">Government Tenders</h5>
                    <p class="small">Expert tender participation management</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- INFINITE SCROLL TESTIMONIAL CAROUSEL -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5 scroll-animate fade-up">
            <h2>What <span style="color:#57B847;">Clients Say</span></h2>
            <p>Trusted by healthcare institutions across India</p>
        </div>
        <div class="testimonial-carousel">
            <div class="testimonial-track" id="testimonialTrack">
                <!-- Testimonials will be duplicated via JS -->
            </div>
        </div>
    </div>
</section>

<!-- MANUFACTURING CAPABILITY -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0 scroll-animate fade-left">
                <div class="glass-card p-4 rounded-4">
                    <h2 class="mb-4">Manufacturing <span style="color:#57B847;">Capability</span></h2>
                    <p>Royal Establishment manufactures premium hospital furniture with strict quality standards.</p>
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <span class="badge bg-success px-3 py-2">ICU Beds</span>
                        <span class="badge bg-success px-3 py-2">Hospital Beds</span>
                        <span class="badge bg-success px-3 py-2">OT Tables</span>
                        <span class="badge bg-success px-3 py-2">Stretchers</span>
                        <span class="badge bg-success px-3 py-2">Patient Lockers</span>
                        <span class="badge bg-success px-3 py-2">Bedside Cabinets</span>
                        <span class="badge bg-success px-3 py-2">Medical Trolleys</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 scroll-animate fade-right">
                <div class="glass-card p-3 rounded-4">
                    <img src="https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?q=80&w=1600" class="w-100 rounded-3" style="height: 350px; object-fit: cover;" alt="Manufacturing">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- VISION & MISSION - GLASS CARDS -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6 scroll-animate fade-left">
                <div class="glass-card p-4 p-lg-5 rounded-4 text-center">
                    <i class="fa-solid fa-eye float-element" style="font-size: 48px; color:#57B847;"></i>
                    <h3 class="mt-3">Our Vision</h3>
                    <p>"To become one of India's most trusted healthcare infrastructure partners by delivering innovative, reliable, and affordable healthcare solutions."</p>
                </div>
            </div>
            <div class="col-md-6 scroll-animate fade-right">
                <div class="glass-card p-4 p-lg-5 rounded-4 text-center">
                    <i class="fa-solid fa-bullseye float-element" style="font-size: 48px; color:#57B847;"></i>
                    <h3 class="mt-3">Our Mission</h3>
                    <p>"To provide high-quality medical equipment, hospital furniture, and biomedical engineering services through innovation and exceptional customer support."</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CORE VALUES -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 scroll-animate fade-up">
            <h2>Our Core <span style="color:#57B847;">Values</span></h2>
            <p>The principles that guide everything we do</p>
        </div>
        <div class="row g-4">
            <div class="col-md-2 col-6 scroll-animate scale-up">
                <div class="glass-card p-3 text-center rounded-4">
                    <i class="fa-solid fa-medal" style="font-size: 32px; color:#57B847;"></i>
                    <p class="mt-2 fw-bold mb-0">Quality</p>
                </div>
            </div>
            <div class="col-md-2 col-6 scroll-animate scale-up delay-1">
                <div class="glass-card p-3 text-center rounded-4">
                    <i class="fa-solid fa-heart" style="font-size: 32px; color:#57B847;"></i>
                    <p class="mt-2 fw-bold mb-0">Commitment</p>
                </div>
            </div>
            <div class="col-md-2 col-6 scroll-animate scale-up delay-2">
                <div class="glass-card p-3 text-center rounded-4">
                    <i class="fa-solid fa-lightbulb" style="font-size: 32px; color:#57B847;"></i>
                    <p class="mt-2 fw-bold mb-0">Innovation</p>
                </div>
            </div>
            <div class="col-md-2 col-6 scroll-animate scale-up delay-3">
                <div class="glass-card p-3 text-center rounded-4">
                    <i class="fa-solid fa-handshake" style="font-size: 32px; color:#57B847;"></i>
                    <p class="mt-2 fw-bold mb-0">Integrity</p>
                </div>
            </div>
            <div class="col-md-2 col-6 scroll-animate scale-up delay-4">
                <div class="glass-card p-3 text-center rounded-4">
                    <i class="fa-solid fa-star" style="font-size: 32px; color:#57B847;"></i>
                    <p class="mt-2 fw-bold mb-0">Excellence</p>
                </div>
            </div>
            <div class="col-md-2 col-6 scroll-animate scale-up delay-5">
                <div class="glass-card p-3 text-center rounded-4">
                    <i class="fa-solid fa-users" style="font-size: 32px; color:#57B847;"></i>
                    <p class="mt-2 fw-bold mb-0">Teamwork</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// =========================
// ANIMATION 1: TYPING EFFECT
// =========================
const words = ["Healthcare Experts", "Quality Manufacturers", "Trusted Partners", "Innovation Leaders"];
let wordIndex = 0;
let charIndex = 0;
let isDeleting = false;
const typedElement = document.getElementById("typedText");

function typeEffect() {
    const currentWord = words[wordIndex];
    if (isDeleting) {
        typedElement.textContent = currentWord.substring(0, charIndex - 1);
        charIndex--;
    } else {
        typedElement.textContent = currentWord.substring(0, charIndex + 1);
        charIndex++;
    }
    
    if (!isDeleting && charIndex === currentWord.length) {
        isDeleting = true;
        setTimeout(typeEffect, 2000);
    } else if (isDeleting && charIndex === 0) {
        isDeleting = false;
        wordIndex = (wordIndex + 1) % words.length;
        setTimeout(typeEffect, 500);
    } else {
        setTimeout(typeEffect, isDeleting ? 50 : 100);
    }
}
typeEffect();

// =========================
// ANIMATION 2: SCROLL ANIMATION (INTERSECTION OBSERVER)
// =========================
const observerOptions = { threshold: 0.1 };
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, observerOptions);
document.querySelectorAll('.scroll-animate').forEach(el => observer.observe(el));

// =========================
// ANIMATION 5: PROGRESS BAR
// =========================
window.addEventListener('scroll', () => {
    const winScroll = document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    document.getElementById('progressBar').style.width = scrolled + '%';
});

// =========================
// ANIMATION 6: COUNTER ANIMATION
// =========================
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counters = entry.target.querySelectorAll('.counter-number');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                let current = 0;
                const increment = target / 50;
                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.textContent = Math.ceil(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };
                updateCounter();
            });
            counterObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });
document.querySelectorAll('.row.g-4').forEach(el => counterObserver.observe(el));

// =========================
// ANIMATION 9: PARTICLE EFFECT ON CLICK
// =========================
document.addEventListener('click', (e) => {
    for (let i = 0; i < 10; i++) {
        const particle = document.createElement('div');
        particle.style.position = 'fixed';
        particle.style.left = e.clientX + 'px';
        particle.style.top = e.clientY + 'px';
        particle.style.width = '5px';
        particle.style.height = '5px';
        particle.style.background = '#57B847';
        particle.style.borderRadius = '50%';
        particle.style.pointerEvents = 'none';
        particle.style.zIndex = '99999';
        particle.style.animation = 'float 1s ease-out forwards';
        document.body.appendChild(particle);
        setTimeout(() => particle.remove(), 1000);
    }
});

// =========================
// ANIMATION 11: SCROLL TO TOP BUTTON
// =========================
const scrollBtn = document.getElementById('scrollTopBtn');
window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
        scrollBtn.classList.add('show');
    } else {
        scrollBtn.classList.remove('show');
    }
});
scrollBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// =========================
// ANIMATION 3: INFINITE SCROLL TESTIMONIALS
// =========================
const testimonials = [
    { text: "Excellent quality products and prompt service. Highly recommended!", name: "Dr. Sharma, City Hospital" },
    { text: "Royal Establishment delivered ICU beds on time with great quality.", name: "Medical College Indore" },
    { text: "Their after-sales support is exceptional. Very responsive team.", name: "District Hospital Bhopal" },
    { text: "Best hospital furniture manufacturer in the region.", name: "Healthcare Solutions Pvt Ltd" },
    { text: "Professional team and high-quality products. Will work again.", name: "Apollo Hospitals" },
    { text: "Great experience with their biomedical maintenance services.", name: "Fortis Healthcare" }
];

const track = document.getElementById('testimonialTrack');
function populateTestimonials() {
    let html = '';
    [...testimonials, ...testimonials].forEach(t => {
        html += `
            <div class="testimonial-card">
                <i class="fa-solid fa-quote-left" style="color:#57B847; font-size:24px;"></i>
                <p class="mt-3">${t.text}</p>
                <h6 class="mt-3 text-success">- ${t.name}</h6>
            </div>
        `;
    });
    track.innerHTML = html;
}
populateTestimonials();

// =========================
// ANIMATION 10: 3D HOVER (CSS already added)
// =========================
</script>

</body>
</html>

<?php include "footer.php"; ?>