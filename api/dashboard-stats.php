<?php
session_start();
include "../database/connection.php";

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json');

// Total Products
$totalProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products"))['total'];

// Active Products
$activeProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products WHERE status='active'"))['total'];

// Total Categories
$totalCategories = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM product_categories"))['total'];

// Active Categories
$activeCategories = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM product_categories WHERE status='active'"))['total'];

// Total Gallery Images
$totalImages = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM product_images"))['total'];

// Category Distribution for Pie Chart
$catQuery = mysqli_query($conn, "
    SELECT pc.category_name, COUNT(p.id) as product_count
    FROM product_categories pc
    LEFT JOIN products p ON p.category_id = pc.id
    GROUP BY pc.id, pc.category_name
    ORDER BY product_count DESC
    LIMIT 6
");
$categoryLabels = [];
$categoryCounts = [];
while ($row = mysqli_fetch_assoc($catQuery)) {
    $categoryLabels[] = $row['category_name'];
    $categoryCounts[] = (int)$row['product_count'];
}

// Monthly Products Added (last 6 months)
$monthlyProducts = [];
$monthLabels = [];
for ($i = 5; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-$i months"));
    $label = date('M', strtotime("-$i months"));
    $monthLabels[] = $label;
    $count = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT COUNT(*) as total FROM products WHERE DATE_FORMAT(created_at, '%Y-%m') = '$month'"
    ))['total'];
    $monthlyProducts[] = (int)$count;
}

echo json_encode([
    'totalProducts'    => (int)$totalProducts,
    'activeProducts'   => (int)$activeProducts,
    'totalCategories'  => (int)$totalCategories,
    'activeCategories' => (int)$activeCategories,
    'totalImages'      => (int)$totalImages,
    'categoryLabels'   => $categoryLabels,
    'categoryCounts'   => $categoryCounts,
    'monthlyProducts'  => $monthlyProducts,
    'monthLabels'      => $monthLabels,
]);