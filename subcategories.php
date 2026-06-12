<?php

include "../includes/config.php";
include "../database/connection.php";

header('Content-Type: application/json');

$category = isset($_GET['category']) ? trim($_GET['category']) : '';

if(empty($category)){
    echo json_encode([]);
    exit;
}

// Sanitize
$category = mysqli_real_escape_string($conn, $category);

/*
 * Products table mein jo subcategories hain us category ke liye fetch karo.
 * Assumption: products table mein subcategory column hai
 * Jo subcategory ke products DB mein hain sirf wahi aayenge
 */
$query = mysqli_query($conn, "
    SELECT DISTINCT p.subcategory AS name
    FROM products p
    INNER JOIN product_categories pc ON p.category_id = pc.id
    WHERE pc.category_name = '$category'
    AND p.status = 'active'
    AND p.subcategory IS NOT NULL
    AND p.subcategory != ''
    ORDER BY p.subcategory ASC
");

$result = [];

if($query && mysqli_num_rows($query) > 0){
    while($row = mysqli_fetch_assoc($query)){
        $result[] = ['name' => $row['name']];
    }
}

echo json_encode($result);
exit;