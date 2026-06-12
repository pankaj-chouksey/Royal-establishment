<?php
include "connection.php";
$sql = "CREATE TABLE IF NOT EXISTS inquiries (

    id INT AUTO_INCREMENT PRIMARY KEY,

    product_id INT,

    customer_name VARCHAR(255),

    customer_phone VARCHAR(50),

    customer_email VARCHAR(255),

    message TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)";

if(mysqli_query($conn, $sql)){
    echo "inquiries table created <br>";
} else {
    echo "Error : " . mysqli_error($conn);
}

?>