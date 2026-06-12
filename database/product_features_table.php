<?php

include "connection.php";

$sql = "CREATE TABLE IF NOT EXISTS product_features (

    id INT AUTO_INCREMENT PRIMARY KEY,

    product_id INT NOT NULL,

    feature_name VARCHAR(255),

    feature_value TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (product_id)
    REFERENCES products(id)
    ON DELETE CASCADE

)";

if(mysqli_query($conn, $sql)){
    echo "product_features table created <br>";
} else {
    echo "Error : " . mysqli_error($conn);
}

?>