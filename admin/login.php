<?php
session_start();

// Hardcoded admin credentials
$admin_email = "admin@gmail.com";
$admin_password = "admin7777";

$error_message = "";

// Check if user is already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Validate credentials
    if ($email === $admin_email && $password === $admin_password) {
        // Set session variables
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $email;
        $_SESSION['login_time'] = time();
        
        // Regenerate session ID for security
        session_regenerate_id(true);
        
        // Redirect to dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        $error_message = "Invalid email or password. Please try again.";
        // Log failed attempt (optional security measure)
        error_log("Failed login attempt for email: " . $email . " from IP: " . $_SERVER['REMOTE_ADDR']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Royal Establishment</title>
    
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
            font-size: 2.5rem;
            opacity: 0.08;
            z-index: 0;
            pointer-events: none;
            animation: floatAround 25s infinite ease-in-out;
        }

        @keyframes floatAround {
            0% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(40px, -60px) rotate(12deg); }
            66% { transform: translate(-30px, 50px) rotate(-12deg); }
            100% { transform: translate(0, 0) rotate(0deg); }
        }

        /* Main wrapper */
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
            padding: 2.5rem 1.5rem 1.5rem;
            background: rgba(15, 23, 42, 0.3);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(87, 184, 71, 0.2);
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #57B847, #22C55E, #4ade80);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 30px rgba(87, 184, 71, 0.3);
        }

        .hero-subtitle {
            font-size: 0.9rem;
            color: #94a3b8;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 500;
        }

        /* Glass Card */
        .glass-card {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(16px);
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(87, 184, 71, 0.1);
            transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        .glass-card:hover {
            transform: translateY(-5px);
            border-color: rgba(87, 184, 71, 0.5);
            box-shadow: 0 35px 55px rgba(0, 0, 0, 0.4);
        }

        /* Icon wrapper */
        .icon-wrapper {
            width: 80px;
            height: 80px;
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
            0% { box-shadow: 0 0 0 0 rgba(87, 184, 71, 0.4); }
            50% { box-shadow: 0 0 0 15px rgba(87, 184, 71, 0); }
            100% { box-shadow: 0 0 0 0 rgba(87, 184, 71, 0); }
        }

        .icon-wrapper i {
            font-size: 2.8rem;
            color: #57B847;
        }

        /* Form inputs */
        .custom-input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .custom-input {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(87, 184, 71, 0.3);
            border-radius: 60px;
            padding: 0.9rem 1.5rem 0.9rem 3rem;
            color: #f1f5f9;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
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

        .input-icon {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: #57B847;
            font-size: 1.1rem;
            z-index: 1;
        }

        .password-toggle {
            position: absolute;
            right: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #64748b;
            transition: color 0.3s ease;
            z-index: 1;
        }

        .password-toggle:hover {
            color: #57B847;
        }

        /* Login Button */
        .login-btn {
            background: linear-gradient(135deg, #57B847, #22C55E);
            border: none;
            padding: 0.9rem 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 60px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(87, 184, 71, 0.3);
            width: 100%;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #4aa63f, #1eb350);
            box-shadow: 0 8px 25px rgba(87, 184, 71, 0.5);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .login-btn.loading .btn-text {
            display: none;
        }

        .login-btn.loading .btn-spinner {
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

        /* Security badge */
        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(0, 0, 0, 0.4);
            padding: 0.5rem 1rem;
            border-radius: 60px;
            font-size: 0.75rem;
            color: #94a3b8;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .glass-card {
                margin: 1rem;
                padding: 2rem 1.2rem !important;
            }
            
            .hero-section {
                padding: 1.5rem 1rem;
            }
        }

        /* Footer */
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

<!-- Floating Icons for visual appeal -->
<div class="floating-icon" style="top: 8%; left: 3%; animation-duration: 20s;"><i class="fas fa-shield-alt"></i></div>
<div class="floating-icon" style="bottom: 12%; right: 5%; animation-duration: 18s;"><i class="fas fa-lock"></i></div>
<div class="floating-icon" style="top: 25%; right: 8%; animation-duration: 22s;"><i class="fas fa-key"></i></div>
<div class="floating-icon" style="bottom: 30%; left: 7%; animation-duration: 24s;"><i class="fas fa-user-shield"></i></div>
<div class="floating-icon" style="top: 65%; left: 15%; animation-duration: 19s;"><i class="fas fa-fingerprint"></i></div>

<div class="main-wrapper">
    <!-- Header include -->
    <?php include "header.php"; ?>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="security-badge mx-auto mb-3" style="width: fit-content;">
                <i class="fas fa-shield-hart"></i>
                <span>SECURE ADMIN ACCESS</span>
                <i class="fas fa-lock"></i>
            </div>
            <h1 class="hero-title">ROYAL ESTABLISHMENT<br>ADMIN PANEL</h1>
            <p class="hero-subtitle mt-2">
                <i class="fas fa-gem me-2"></i> Premium Management System
            </p>
        </div>
    </div>

    <!-- Login Form Section -->
    <div class="container my-5 py-4">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-11">
                
                <!-- Glass Card -->
                <div class="glass-card p-4 p-md-5">
                    <div class="icon-wrapper">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    
                    <h3 class="text-white fw-bold text-center mb-2">Admin Login</h3>
                    <p class="text-secondary text-center mb-4">Enter your credentials to continue</p>
                    
                    <!-- Error Message -->
                    <?php if ($error_message): ?>
                        <div class="alert alert-custom alert-danger-custom text-center py-2 mb-4" id="errorMessage">
                            <i class="fas fa-exclamation-triangle me-2"></i> <?php echo htmlspecialchars($error_message); ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Login Form -->
                    <form method="POST" action="" id="loginForm">
                        <!-- Email Field -->
                        <div class="custom-input-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" class="custom-input" 
                                   placeholder="admin@gmail.com" required autocomplete="email"
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>
                        
                        <!-- Password Field -->
                        <div class="custom-input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" class="custom-input" id="passwordInput"
                                   placeholder="Enter password" required autocomplete="current-password">
                            <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                        </div>
                        
                        <!-- Login Button -->
                        <button type="submit" name="login" class="login-btn text-white" id="loginBtn">
                            <span class="btn-text"><i class="fas fa-arrow-right-to-bracket me-2"></i>Login to Dashboard</span>
                            <span class="btn-spinner"></span>
                        </button>
                    </form>
                    
                    <!-- Security Notice -->
                    <div class="text-center mt-4">
                        <small class="text-secondary">
                            <i class="fas fa-shield-alt me-1"></i> 
                            Secure SSL Encrypted Connection
                        </small>
                        <div class="mt-2 small">
                            <span class="text-success">●</span> 
                            <span class="text-secondary">Authorized access only</span>
                        </div>
                    </div>
                </div>
                
                <!-- Demo Credentials Hint -->
                <div class="text-center mt-3">
                    <div class="security-badge mx-auto" style="width: fit-content; background: rgba(87,184,71,0.1);">
                        <i class="fas fa-info-circle text-success"></i>
                        <span class="text-secondary">Demo: </span>
                        <span class="text-success">admin@gmail.com</span>
                        <span class="text-secondary mx-1">|</span>
                        <span class="text-success">admin7777</span>
                    </div>
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

    // Password Toggle Visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('passwordInput');
    
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

    // Form submission with loading effect
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    
    loginForm.addEventListener('submit', function(e) {
        // Add loading state to button
        loginBtn.classList.add('loading');
        
        // Allow form to submit naturally
        // The loading state will be removed after page reload or error
    });
    
    // Auto-hide error message after 4 seconds
    const errorMessage = document.getElementById('errorMessage');
    if (errorMessage) {
        setTimeout(() => {
            errorMessage.style.transition = 'opacity 0.5s';
            errorMessage.style.opacity = '0';
            setTimeout(() => {
                if (errorMessage && errorMessage.parentNode) {
                    errorMessage.style.display = 'none';
                }
            }, 500);
        }, 4000);
    }
    
    // Prevent multiple form submissions
    let submitted = false;
    loginForm.addEventListener('submit', function() {
        if (submitted) {
            return false;
        }
        submitted = true;
        return true;
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>