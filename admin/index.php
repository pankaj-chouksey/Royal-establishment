<?php
session_start();

// Secret key - source me visible nahi hoga
$secret_key = "royaladmin";
$error_message = "";
$success_message = "";

// AJAX request handle karo alag se
if(
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST['verify_code']) &&
    isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
){
    header('Content-Type: application/json');

    $user_input = trim($_POST['verify_code']);

    if($user_input === $secret_key){
        // Session set karo taaki login.php pe verify ho sake
        $_SESSION['admin_verified'] = true;
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Access Denied']);
    }
    exit;
}

// Normal POST (non-AJAX) bhi handle karo fallback ke liye
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify_code'])){
    $user_input = trim($_POST['verify_code']);
    if($user_input === $secret_key){
        $_SESSION['admin_verified'] = true;
        header("Location: login.php");
        exit;
    } else {
        $error_message = "Access Denied";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Royal Establishment | Admin Panel</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a, #111827, #1e293b);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Particles Background */
        #particlesCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        /* Floating icons animation */
        .floating-icon {
            position: fixed;
            font-size: 2rem;
            opacity: 0.1;
            z-index: 0;
            pointer-events: none;
            animation: floatAround 20s infinite ease-in-out;
        }

        @keyframes floatAround {
            0% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -50px) rotate(10deg); }
            66% { transform: translate(-20px, 40px) rotate(-10deg); }
            100% { transform: translate(0, 0) rotate(0deg); }
        }

        /* Main content wrapper */
        .main-wrapper {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            padding: 3rem 1.5rem 2rem;
            background: rgba(15, 23, 42, 0.3);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(87, 184, 71, 0.2);
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #57B847, #22C55E, #4ade80);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 30px rgba(87, 184, 71, 0.3);
            letter-spacing: -0.02em;
        }

        .hero-subtitle {
            font-size: 1rem;
            color: #94a3b8;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 500;
            margin-top: 0.5rem;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(87, 184, 71, 0.15);
            backdrop-filter: blur(5px);
            padding: 0.5rem 1.2rem;
            border-radius: 40px;
            font-size: 0.85rem;
            color: #57B847;
            font-weight: 600;
            border: 1px solid rgba(87, 184, 71, 0.3);
        }

        /* Glass Card */
        .glass-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(16px);
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(87, 184, 71, 0.1);
            transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        .glass-card:hover {
            transform: translateY(-8px);
            border-color: rgba(87, 184, 71, 0.5);
            box-shadow: 0 35px 55px rgba(0, 0, 0, 0.4), 0 0 0 2px rgba(87, 184, 71, 0.2);
        }

        /* Icon wrapper */
        .icon-wrapper {
            width: 85px;
            height: 85px;
            background: linear-gradient(135deg, rgba(87, 184, 71, 0.2), rgba(34, 197, 94, 0.1));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem;
            border: 2px solid rgba(87, 184, 71, 0.4);
            animation: pulseGlow 2s infinite;
        }

        @keyframes pulseGlow {
            0% { box-shadow: 0 0 0 0 rgba(87, 184, 71, 0.4); border-color: rgba(87, 184, 71, 0.4); }
            50% { box-shadow: 0 0 0 15px rgba(87, 184, 71, 0); border-color: rgba(87, 184, 71, 0.8); }
            100% { box-shadow: 0 0 0 0 rgba(87, 184, 71, 0); border-color: rgba(87, 184, 71, 0.4); }
        }

        .icon-wrapper i {
            font-size: 3rem;
            color: #57B847;
        }

        /* Verification Form */
        .verify-btn {
            background: linear-gradient(135deg, #57B847, #22C55E);
            border: none;
            padding: 0.9rem 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 60px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(87, 184, 71, 0.3);
        }

        .verify-btn:hover {
            transform: scale(1.02);
            background: linear-gradient(135deg, #4aa63f, #1eb350);
            box-shadow: 0 8px 25px rgba(87, 184, 71, 0.5);
        }

        .verify-btn:active {
            transform: scale(0.98);
        }

        .verify-btn.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .verify-btn.loading .btn-text {
            display: none;
        }

        .verify-btn.loading .btn-spinner {
            display: inline-block;
        }

        .btn-spinner {
            display: none;
            width: 1.2rem;
            height: 1.2rem;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Hidden input container animation */
        .hidden-form-container {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hidden-form-container.show {
            max-height: 200px;
            opacity: 1;
            margin-top: 1.5rem;
        }

        .custom-input {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(87, 184, 71, 0.4);
            border-radius: 60px;
            padding: 0.8rem 1.5rem;
            color: #f1f5f9;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .custom-input:focus {
            background: rgba(30, 41, 59, 1);
            border-color: #57B847;
            box-shadow: 0 0 0 3px rgba(87, 184, 71, 0.2);
            outline: none;
            color: white;
        }

        .custom-input::placeholder {
            color: #64748b;
            font-weight: 400;
        }

        .submit-access-btn {
            background: linear-gradient(135deg, #0F172A, #1e293b);
            border: 1px solid #57B847;
            color: #57B847;
            border-radius: 60px;
            padding: 0.8rem 1.8rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .submit-access-btn:hover {
            background: #57B847;
            color: white;
            border-color: #57B847;
            transform: translateY(-2px);
        }

        /* Alert messages */
        .alert-custom {
            border-radius: 60px;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            border: none;
            font-weight: 500;
            animation: slideDown 0.4s ease-out;
        }

        .alert-danger-custom {
            background: rgba(220, 38, 38, 0.2);
            border-left: 4px solid #ef4444;
            color: #fecaca;
        }

        .alert-success-custom {
            background: rgba(34, 197, 94, 0.2);
            border-left: 4px solid #22C55E;
            color: #bbf7d0;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
            
            .glass-card {
                margin: 1rem;
                padding: 2rem 1rem !important;
            }
            
            .hero-section {
                padding: 1.8rem 1rem;
            }
        }

        /* Footer adjustment */
        footer {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(87, 184, 71, 0.2);
            margin-top: auto;
        }
    </style>
</head>
<body>

<canvas id="particlesCanvas"></canvas>

<!-- Floating Icons -->
<div class="floating-icon" style="top: 10%; left: 5%; animation-duration: 18s;"><i class="fas fa-shield-alt"></i></div>
<div class="floating-icon" style="bottom: 15%; right: 8%; animation-duration: 22s;"><i class="fas fa-lock"></i></div>
<div class="floating-icon" style="top: 30%; right: 12%; animation-duration: 25s;"><i class="fas fa-key"></i></div>
<div class="floating-icon" style="bottom: 25%; left: 10%; animation-duration: 20s;"><i class="fas fa-database"></i></div>
<div class="floating-icon" style="top: 70%; left: 20%; animation-duration: 17s;"><i class="fas fa-server"></i></div>

<div class="main-wrapper">
    <!-- Header include -->
    <?php include "header.php"; ?>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="hero-badge mb-3">
                <i class="fas fa-crown me-2"></i> SECURE ACCESS
            </div>
            <h1 class="hero-title">ROYAL ESTABLISHMENT<br>ADMIN PANEL</h1>
            <p class="hero-subtitle mt-3">
                <i class="fas fa-shield-hart me-2"></i> Secure Product Management System
            </p>
        </div>
    </div>

    <!-- Page Content -->
    <div class="container my-5 py-3">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-11">
                
                <!-- Glass Card -->
                <div class="glass-card p-4 p-md-5 text-center">
                    <div class="icon-wrapper">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    
                    <h2 class="text-white fw-bold mb-2" style="letter-spacing: -0.3px;">Admin Verification</h2>
                    <p class="text-secondary mb-4">Enter your Date Of Birth to continue</p>
                    
                    <!-- Verify Access Button -->
                    <button class="verify-btn text-white border-0 w-100" id="showFormBtn">
                        <span class="btn-text"><i class="fas fa-fingerprint me-2"></i>Verify Access</span>
                        <span class="btn-spinner"></span>
                    </button>
                    
                    <!-- Hidden Verification Form -->
                    <div class="hidden-form-container" id="hiddenFormContainer">
                        <form method="POST" action="" id="verificationForm">
                            <input type="text" name="verify_code" class="form-control custom-input w-100 mb-3" 
                                   placeholder="Enter DOB or Secret Text" 
                                   autocomplete="off" id="secretInput">
                            <button type="submit" class="submit-access-btn w-100" id="submitBtn">
                                <i class="fas fa-arrow-right-to-bracket me-2"></i>Submit & Continue
                            </button>
                        </form>
                    </div>
                    
                    <!-- Error / Success Message Area -->
                    <div id="messageArea" class="mt-3">
                        <?php if ($error_message): ?>
                            <div class="alert alert-custom alert-danger-custom text-center py-2">
                                <i class="fas fa-triangle-exclamation me-2"></i> <?php echo htmlspecialchars($error_message); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- BUG FIX: Demo credential hint hata diya -->
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Footer include -->
    <?php include "footer.php"; ?>
</div>

<script>
    // Particles Background Animation
    const canvas = document.getElementById('particlesCanvas');
    const ctx = canvas.getContext('2d');
    let particles = [];
    let animationId;

    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }

    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 2.5 + 0.5;
            this.speedX = (Math.random() - 0.5) * 0.5;
            this.speedY = (Math.random() - 0.5) * 0.3;
            this.opacity = Math.random() * 0.4 + 0.1;
            this.color = `rgba(87, 184, 71, ${this.opacity})`;
        }
        
        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            
            if (this.x < 0) this.x = canvas.width;
            if (this.x > canvas.width) this.x = 0;
            if (this.y < 0) this.y = canvas.height;
            if (this.y > canvas.height) this.y = 0;
        }
        
        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fillStyle = this.color;
            ctx.fill();
        }
    }

    function initParticles() {
        particles = [];
        const particleCount = Math.min(120, Math.floor(window.innerWidth * 0.1));
        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle());
        }
    }

    function animateParticles() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(particle => {
            particle.update();
            particle.draw();
        });
        animationId = requestAnimationFrame(animateParticles);
    }

    window.addEventListener('resize', () => {
        resizeCanvas();
        initParticles();
    });

    resizeCanvas();
    initParticles();
    animateParticles();

    // ========== VERIFICATION LOGIC ==========
    const showFormBtn = document.getElementById('showFormBtn');
    const hiddenContainer = document.getElementById('hiddenFormContainer');
    const verificationForm = document.getElementById('verificationForm');
    const submitBtn = document.getElementById('submitBtn');
    const secretInput = document.getElementById('secretInput');
    const messageArea = document.getElementById('messageArea');
    
    showFormBtn.addEventListener('click', function(e) {
        e.preventDefault();
        showFormBtn.classList.add('loading');
        
        setTimeout(() => {
            hiddenContainer.classList.toggle('show');
            showFormBtn.classList.remove('loading');
            
            if (hiddenContainer.classList.contains('show')) {
                setTimeout(() => { secretInput.focus(); }, 200);
                showFormBtn.innerHTML = '<span class="btn-text"><i class="fas fa-chevron-up me-2"></i>Hide Form</span><span class="btn-spinner"></span>';
            } else {
                showFormBtn.innerHTML = '<span class="btn-text"><i class="fas fa-fingerprint me-2"></i>Verify Access</span><span class="btn-spinner"></span>';
                if (!messageArea.innerHTML.includes('Verification Successful')) {
                    messageArea.innerHTML = '';
                }
            }
        }, 300);
    });
    
    // BUG FIX: Ab JSON parse karke sahi response check ho raha hai
    verificationForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const userInput = secretInput.value.trim();
        if (!userInput) {
            showMessage('Please enter your DOB or secret text.', 'danger');
            return;
        }
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Verifying...';
        
        const formData = new FormData();
        formData.append('verify_code', userInput);
        
        try {
            const response = await fetch(window.location.href, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            // BUG FIX: JSON parse karo, string match nahi
            const data = await response.json();

            if(data.status === 'success'){
                showMessage('Verification Successful! Redirecting...', 'success');
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 1500);
            } else {
                showMessage('Access Denied', 'danger');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-arrow-right-to-bracket me-2"></i>Submit & Continue';
                secretInput.value = '';
                secretInput.focus();
            }

        } catch (error) {
            showMessage('Network error. Please try again.', 'danger');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-arrow-right-to-bracket me-2"></i>Submit & Continue';
        }
    });
    
    function showMessage(msg, type) {
        const isSuccess = (type === 'success');
        const icon = isSuccess ? '<i class="fas fa-check-circle me-2"></i>' : '<i class="fas fa-times-circle me-2"></i>';
        const alertClass = isSuccess ? 'alert-success-custom' : 'alert-danger-custom';
        
        messageArea.innerHTML = `
            <div class="alert alert-custom ${alertClass} text-center py-2">
                ${icon} ${msg}
            </div>
        `;
        
        if (!isSuccess) {
            setTimeout(() => {
                messageArea.innerHTML = '';
            }, 3000);
        }
        
        messageArea.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    
    <?php if ($error_message): ?>
    setTimeout(() => {
        const msgDiv = document.querySelector('#messageArea .alert');
        if (msgDiv) {
            msgDiv.style.transition = 'opacity 0.5s';
            msgDiv.style.opacity = '0';
            setTimeout(() => { messageArea.innerHTML = ''; }, 500);
        }
    }, 3000);
    <?php endif; ?>
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>