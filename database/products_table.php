<?php
include "connection.php";
$sql = "CREATE TABLE IF NOT EXISTS products (

    id INT AUTO_INCREMENT PRIMARY KEY,

    category_id INT NOT NULL,

    product_name VARCHAR(255) NOT NULL,

    slug VARCHAR(255) UNIQUE,

    model_no VARCHAR(255),

    short_description TEXT,

    description LONGTEXT,

    featured_image VARCHAR(255),

    brochure VARCHAR(255),

    youtube_link VARCHAR(255),

    meta_title VARCHAR(255),

    meta_description TEXT,

    meta_keywords TEXT,

    status ENUM('active','inactive') DEFAULT 'active',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (category_id)
    REFERENCES product_categories(id)
    ON DELETE CASCADE

)";

if(mysqli_query($conn, $sql)){
    echo "products table created <br>";
} else {
    echo "Error : " . mysqli_error($conn);
}

?>