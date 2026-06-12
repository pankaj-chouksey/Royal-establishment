<?php
include "connection.php";
$sql = "CREATE TABLE IF NOT EXISTS product_categories (

    id INT AUTO_INCREMENT PRIMARY KEY,

    category_name VARCHAR(255) NOT NULL,

    category_slug VARCHAR(255) UNIQUE,

    category_page VARCHAR(255),

    category_image VARCHAR(255),

    category_description TEXT,

    status ENUM('active','inactive') DEFAULT 'active',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)";

if(mysqli_query($conn, $sql)){
    echo "product_categories table created <br>";
} else {
    echo "Error : " . mysqli_error($conn);
}

?>