<?php

include "connection.php";

$sql = "INSERT INTO products (

category_id,
product_name,
slug,
model_no,
short_description,
description,
featured_image

)

VALUES

(

1,
'Electric ICU Bed',
'electric-icu-bed',
'ICU-001',
'Premium electric ICU bed',
'Full ICU Bed Description',
'bed.jpg'

)";

if(mysqli_query($conn, $sql)){

    echo "Dummy Product Inserted";

} else {

    echo mysqli_error($conn);

}

?>