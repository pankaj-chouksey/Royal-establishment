<?php

include "connection.php";

$sql = "CREATE TABLE IF NOT EXISTS product_images (

    id INT AUTO_INCREMENT PRIMARY KEY,

    product_id INT NOT NULL,

    image_name VARCHAR(255),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (product_id)
    REFERENCES products(id)
    ON DELETE CASCADE

)";

if(mysqli_query($conn, $sql)){
    echo "product_images table created <br>";
} else {
    echo "Error : " . mysqli_error($conn);
}

?>