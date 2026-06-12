<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$admin_name = $_SESSION['admin_email'] ?? 'Admin';
$admin_name_display = explode('@', $admin_name)[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Royal Establishment Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f5f7fb; overflow-x: hidden; }
        .sidebar { position: fixed; left: 0; top: 0; width: 280px; height: 100%; background: #ffffff; box-shadow: 0 0 30px rgba(0,0,0,0.05); z-index: 1000; transition: all 0.3s ease; overflow-y: auto; border-right: 1px solid #e9ecef; }
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-track { background: #f1f1f1; }
        .sidebar::-webkit-scrollbar-thumb { background: #57B847; border-radius: 5px; }
        .sidebar-header { padding: 1.5rem; border-bottom: 1px solid #e9ecef; text-align: center; }
        .sidebar-header h3 { font-size: 1.3rem; font-weight: 700; background: linear-gradient(135deg, #57B847, #3a9b2e); -webkit-background-clip: text; background-clip: text; color: transparent; margin-bottom: 0; }
        .sidebar-header p { font-size: 0.75rem; color: #6c757d; margin-top: 0.25rem; }
        .nav-menu { padding: 1.2rem 0; }
        .nav-item { list-style: none; margin-bottom: 0.3rem; }
        .nav-link-custom { display: flex; align-items: center; padding: 0.85rem 1.5rem; color: #4a5568; text-decoration: none; transition: all 0.3s ease; font-weight: 500; gap: 12px; margin: 0 10px; border-radius: 12px; }
        .nav-link-custom i { width: 24px; font-size: 1.1rem; color: #a0aec0; transition: all 0.3s ease; }
        .nav-link-custom:hover { background: #f0fdf4; color: #57B847; }
        .nav-link-custom:hover i { color: #57B847; }
        .nav-link-custom.active { background: linear-gradient(135deg, #57B847, #4aa63f); color: white; }
        .nav-link-custom.active i { color: white; }
        .nav-divider { height: 1px; background: #e9ecef; margin: 1rem 1.5rem; }
        .nav-title { padding: 0.5rem 1.8rem; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: #a0aec0; font-weight: 600; }
        .main-content { margin-left: 280px; padding: 1.5rem; transition: all 0.3s ease; }
        .top-navbar { background: #ffffff; border-radius: 20px; padding: 0.8rem 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e9ecef; }
        .stat-card { background: #ffffff; border-radius: 20px; padding: 1.5rem; border: 1px solid #e9ecef; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .stat-icon { width: 55px; height: 55px; background: #f0fdf4; border-radius: 15px; display: flex; align-items: center; justify-content: center; }
        .stat-icon i { font-size: 1.8rem; color: #57B847; }
        .stat-title { font-size: 0.85rem; color: #6c757d; font-weight: 500; }
        .stat-value { font-size: 1.8rem; font-weight: 700; color: #1a202c; }
        .quick-action-btn { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 16px; padding: 1.2rem; text-align: center; text-decoration: none; transition: all 0.3s ease; display: block; }
        .quick-action-btn:hover { background: #f0fdf4; border-color: #57B847; transform: translateY(-3px); }
        .quick-action-btn i { font-size: 2rem; color: #57B847; margin-bottom: 0.8rem; display: block; }
        .quick-action-btn span { font-size: 0.9rem; font-weight: 600; color: #2d3748; }
        .recent-table { background: #ffffff; border-radius: 20px; border: 1px solid #e9ecef; overflow: hidden; }
        .recent-table th { background: #f8f9fa; color: #4a5568; font-weight: 600; border-bottom: 1px solid #e9ecef; padding: 1rem; }
        .recent-table td { padding: 1rem; color: #4a5568; vertical-align: middle; }
        .mobile-menu-btn { display: none; position: fixed; top: 1rem; left: 1rem; z-index: 1100; background: #57B847; border: none; color: white; width: 45px; height: 45px; border-radius: 12px; font-size: 1.2rem; }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999; }
        .welcome-badge { background: #f0fdf4; padding: 0.4rem 1rem; border-radius: 40px; display: inline-flex; align-items: center; gap: 8px; }
        .logout-btn { background: #fef2f2; color: #dc2626; }
        .logout-btn:hover { background: #dc2626; color: white; }
        .logout-btn:hover i { color: white; }
        /* Spinner */
        .stat-value.loading::after { content: ''; display: inline-block; width: 20px; height: 20px; border: 3px solid #e9ecef; border-top-color: #57B847; border-radius: 50%; animation: spin 0.7s linear infinite; vertical-align: middle; }
        @keyframes spin { to { transform: rotate(360deg); } }
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .mobile-menu-btn { display: block; }
            .sidebar-overlay.show { display: block; }
        }
        @media (max-width: 768px) {
            .main-content { padding: 1rem; padding-top: 4.5rem; }
            .stat-value { font-size: 1.3rem; }
        }
    </style>
</head>
<body>

<button class="mobile-menu-btn" id="mobileMenuBtn"><i class="fas fa-bars"></i></button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3><i class="fas fa-crown me-2"></i>Royal Establishment</h3>
        <p>Admin Panel v2.0</p>
    </div>
    <div class="nav-menu">
        <div class="nav-title">MAIN MENU</div>
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link-custom active">
                <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
            </a>
        </li>
        <div class="nav-divider"></div>
        <div class="nav-title">PRODUCTS MANAGEMENT</div>
        <li class="nav-item">
            <a href="products/view-products.php" class="nav-link-custom">
                <i class="fas fa-box"></i><span>All Products</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="products/add-product.php" class="nav-link-custom">
                <i class="fas fa-plus-circle"></i><span>Add New Product</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="products/manage-gallery.php" class="nav-link-custom">
                <i class="fas fa-images"></i><span>Product Gallery</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="products/upload-images.php" class="nav-link-custom">
                <i class="fas fa-upload"></i><span>Upload Images</span>
            </a>
        </li>
        <div class="nav-divider"></div>
        <div class="nav-title">CATEGORIES</div>
        <li class="nav-item">
            <a href="categories/view-categories.php" class="nav-link-custom">
                <i class="fas fa-tags"></i><span>All Categories</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="categories/add-category.php" class="nav-link-custom">
                <i class="fas fa-plus-circle"></i><span>Add Category</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="categories/edit-category.php" class="nav-link-custom">
                <i class="fas fa-edit"></i><span>Edit Category</span>
            </a>
        </li>
        <div class="nav-divider"></div>
        <li class="nav-item">
            <a href="logout.php" class="nav-link-custom logout-btn">
                <i class="fas fa-sign-out-alt"></i><span>Logout</span>
            </a>
        </li>
    </div>
</div>

<div class="main-content">
    <div class="top-navbar d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-semibold text-dark">Welcome back, <?php echo htmlspecialchars($admin_name_display); ?>!</h5>
            <p class="mb-0 text-muted small">Here's what's happening with your store today</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="welcome-badge">
                <i class="fas fa-calendar-alt text-success"></i>
                <span class="small text-dark" id="currentDate"></span>
            </div>
            <div class="dropdown">
                <button class="btn btn-light rounded-circle p-2" style="width:40px;height:40px;" data-bs-toggle="dropdown">
                    <i class="fas fa-bell text-secondary"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end p-3" style="min-width:280px;">
                    <h6 class="mb-2">Notifications</h6>
                    <hr class="my-2">
                    <p class="small text-muted mb-0">No new notifications</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-title">Total Products</div>
                        <div class="stat-value loading" id="totalProducts"></div>
                        <div class="small text-success mt-1">
                            <i class="fas fa-check-circle"></i> <span id="activeProducts">--</span> active
                        </div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-box"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-title">Total Categories</div>
                        <div class="stat-value loading" id="totalCategories"></div>
                        <div class="small text-success mt-1">
                            <i class="fas fa-tag"></i> <span id="activeCategories">--</span> active
                        </div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-tags"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-title">Total Images</div>
                        <div class="stat-value loading" id="totalImages"></div>
                        <div class="small text-success mt-1">
                            <i class="fas fa-image"></i> In gallery
                        </div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-images"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-title">Last Login</div>
                        <div class="stat-value" style="font-size:1rem;" id="lastLogin">Today</div>
                        <div class="small text-success mt-1">
                            <i class="fas fa-clock"></i> Session active
                        </div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-clock"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="recent-table p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-chart-line text-success me-2"></i>Products Added (Last 6 Months)</h6>
                </div>
                <canvas id="productsChart" height="200"></canvas>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="recent-table p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-chart-pie text-success me-2"></i>Category Distribution</h6>
                </div>
                <canvas id="categoryChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-4">
        <h6 class="fw-bold mb-3"><i class="fas fa-bolt text-success me-2"></i>Quick Actions</h6>
        <div class="row g-3">
            <div class="col-md-3 col-6">
                <a href="products/add-product.php" class="quick-action-btn">
                    <i class="fas fa-plus-circle"></i><span>Add Product</span>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="categories/add-category.php" class="quick-action-btn">
                    <i class="fas fa-folder-plus"></i><span>Add Category</span>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="products/upload-images.php" class="quick-action-btn">
                    <i class="fas fa-cloud-upload-alt"></i><span>Upload Images</span>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="products/view-products.php" class="quick-action-btn">
                    <i class="fas fa-eye"></i><span>View Products</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Current Date
    const today = new Date();
    document.getElementById('currentDate').innerText = today.toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' });

    // Last Login
    let lastLogin = localStorage.getItem('lastLogin');
    if (!lastLogin) {
        lastLogin = new Date().toLocaleString();
        localStorage.setItem('lastLogin', lastLogin);
    }
    document.getElementById('lastLogin').innerHTML = lastLogin.substring(0, 16);

    // Mobile Menu
    document.getElementById('mobileMenuBtn').addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    });
    document.getElementById('sidebarOverlay').addEventListener('click', () => {
        document.getElementById('sidebar').classList.remove('show');
        document.getElementById('sidebarOverlay').classList.remove('show');
    });

    let productsChart, categoryChart;

    // Counter animation
    function animateCount(el, target) {
        el.classList.remove('loading');
        let current = 0;
        const duration = 1000;
        const stepTime = Math.max(Math.floor(duration / target), 10);
        const timer = setInterval(() => {
            current += Math.ceil(target / (duration / stepTime));
            if (current >= target) {
                el.innerText = target;
                clearInterval(timer);
            } else {
                el.innerText = current;
            }
        }, stepTime);
    }

    function buildCharts(data) {
        if (productsChart) productsChart.destroy();
        if (categoryChart) categoryChart.destroy();

        // Line Chart — real monthly data
        const ctx1 = document.getElementById('productsChart').getContext('2d');
        productsChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: data.monthLabels,
                datasets: [{
                    label: 'Products Added',
                    data: data.monthlyProducts,
                    borderColor: '#57B847',
                    backgroundColor: 'rgba(87,184,71,0.08)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#57B847',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });

        // Doughnut Chart — real category data
        const ctx2 = document.getElementById('categoryChart').getContext('2d');
        categoryChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: data.categoryLabels,
                datasets: [{
                    data: data.categoryCounts,
                    backgroundColor: ['#57B847','#22C55E','#86efac','#4ade80','#bbf7d0','#a3e635'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
                }
            }
        });
    }

    async function loadDashboardStats() {
        try {
            const response = await fetch('/Royalestablishment/api/dashboard-stats.php', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!response.ok) throw new Error('API error');

            const data = await response.json();

            // Animate real counts
            animateCount(document.getElementById('totalProducts'), data.totalProducts);
            animateCount(document.getElementById('totalCategories'), data.totalCategories);
            animateCount(document.getElementById('totalImages'), data.totalImages);

            document.getElementById('activeProducts').innerText = data.activeProducts;
            document.getElementById('activeCategories').innerText = data.activeCategories;

            buildCharts(data);

        } catch (e) {
            // Fallback — sab loading spinner hata do aur 0 dikhao
            ['totalProducts','totalCategories','totalImages'].forEach(id => {
                const el = document.getElementById(id);
                el.classList.remove('loading');
                el.innerText = '0';
            });
            document.getElementById('activeProducts').innerText = '0';
            document.getElementById('activeCategories').innerText = '0';

            // Empty charts
            buildCharts({
                monthLabels: ['Jan','Feb','Mar','Apr','May','Jun'],
                monthlyProducts: [0,0,0,0,0,0],
                categoryLabels: ['No Data'],
                categoryCounts: [1]
            });
        }
    }

    loadDashboardStats();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>