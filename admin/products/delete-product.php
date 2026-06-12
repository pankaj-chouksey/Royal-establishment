<?php

include "../../database/connection.php";

$id = $_GET['id'];

/* PRODUCT FETCH */

$productQuery = mysqli_query($conn,

"

SELECT * FROM products
WHERE id='$id'

"

);

$product = mysqli_fetch_assoc($productQuery);

/* DELETE FEATURED IMAGE */

if($product){

    $featured_image =
    "../../uploads/products/" .
    $product['featured_image'];

    if(file_exists($featured_image)){

        unlink($featured_image);

    }

}

/* DELETE GALLERY IMAGES */

$galleryQuery = mysqli_query($conn,

"

SELECT * FROM product_images
WHERE product_id='$id'

"

);

while($gallery = mysqli_fetch_assoc($galleryQuery)){

    $gallery_image =
    "../../uploads/products/" .
    $gallery['image_name'];

    if(file_exists($gallery_image)){

        unlink($gallery_image);

    }

}

/* DELETE FEATURES */

mysqli_query($conn,

"

DELETE FROM product_features
WHERE product_id='$id'

"

);

/* DELETE GALLERY RECORDS */

mysqli_query($conn,

"

DELETE FROM product_images
WHERE product_id='$id'

"

);

/* DELETE PRODUCT */

mysqli_query($conn,

"

DELETE FROM products
WHERE id='$id'

"

);

/* REDIRECT */

header("Location: view-products.php");

?>