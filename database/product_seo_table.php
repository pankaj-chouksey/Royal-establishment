<?php
include "connection.php";
$sql = "CREATE TABLE IF NOT EXISTS product_seo (

    id INT AUTO_INCREMENT PRIMARY KEY,

    product_id INT NOT NULL,

    meta_title VARCHAR(255),

    meta_description TEXT,

    meta_keywords TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (product_id)
    REFERENCES products(id)
    ON DELETE CASCADE

)";

if(mysqli_query($conn, $sql)){
    echo "product_seo table created <br>";
} else {
    echo "Error : " . mysqli_error($conn);
}

?>