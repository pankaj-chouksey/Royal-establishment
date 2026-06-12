<?php

include "../../database/connection.php";

$product_id = $_GET['id'];

/* DELETE IMAGE */

if(isset($_GET['delete'])){

    $image_id = $_GET['delete'];

    $imgQuery = mysqli_query($conn,

    "

    SELECT * FROM product_images
    WHERE id='$image_id'

    "

    );

    $imgData = mysqli_fetch_assoc($imgQuery);

    $image_path =
    "../../uploads/products/" .
    $imgData['image_name'];

    if(file_exists($image_path)){

        unlink($image_path);

    }

    mysqli_query($conn,

    "

    DELETE FROM product_images
    WHERE id='$image_id'

    "

    );

    header("Location: manage-gallery.php?id=$product_id");

}

/* PRODUCT */

$productQuery = mysqli_query($conn,

"

SELECT * FROM products
WHERE id='$product_id'

"

);

$product = mysqli_fetch_assoc($productQuery);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Manage Gallery</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

body{
    background:#f4f7fb;
}

/* PAGE */

.gallery-page{
    padding:50px 0;
}

/* CARD */

.gallery-card{
    background:#fff;
    border-radius:20px;
    padding:35px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

/* TITLE */

.page-title{
    font-size:34px;
    font-weight:700;
    color:#0f172a;
    margin-bottom:10px;
}

.product-name{
    color:#64748b;
    margin-bottom:35px;
}

/* GRID */

.gallery-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
    gap:25px;
}

/* ITEM */

.gallery-item{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    border:1px solid #e5e7eb;
    transition:.3s;
    position:relative;
}

.gallery-item:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

/* IMAGE */

.gallery-item img{
    width:100%;
    height:220px;
    object-fit:cover;
    display:block;
}

/* ACTION */

.gallery-action{
    padding:18px;
    text-align:center;
}

/* DELETE BUTTON */

.delete-btn{
    background:#ef4444;
    color:#fff;
    border:none;
    border-radius:10px;
    padding:10px 18px;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:8px;
    font-weight:600;
    transition:.3s;
}

.delete-btn:hover{
    background:#dc2626;
    color:#fff;
}

/* EMPTY */

.empty-box{
    padding:70px 20px;
    text-align:center;
    border:2px dashed #d1d5db;
    border-radius:20px;
}

.empty-box i{
    font-size:60px;
    color:#cbd5e1;
    margin-bottom:20px;
}

.empty-box h3{
    font-size:28px;
    color:#475569;
}

.empty-box p{
    color:#94a3b8;
}

/* BACK */

.back-btn{
    display:inline-flex;
    align-items:center;
    gap:10px;
    margin-bottom:30px;
    text-decoration:none;
    font-weight:600;
    color:#2563eb;
}

.back-btn:hover{
    color:#1d4ed8;
}

</style>

</head>

<body>

<div class="gallery-page">

<div class="container">

<div class="gallery-card">

<a
href="view-products.php"
class="back-btn"
>

<i class="fa-solid fa-arrow-left"></i>

Back To Products

</a>

<h1 class="page-title">

Manage Gallery

</h1>

<div class="product-name">

<?php echo $product['product_name']; ?>

</div>

<?php

$imageQuery = mysqli_query($conn,

"

SELECT * FROM product_images
WHERE product_id='$product_id'
ORDER BY id DESC

"

);

if(mysqli_num_rows($imageQuery) > 0){

?>

<div class="gallery-grid">

<?php

while($image = mysqli_fetch_assoc($imageQuery)){

?>

<div class="gallery-item">

<img
src="../../uploads/products/<?php echo $image['image_name']; ?>"
>

<div class="gallery-action">

<a
href="?id=<?php echo $product_id; ?>&delete=<?php echo $image['id']; ?>"
class="delete-btn"
onclick="return confirm('Delete this image?')"
>

<i class="fa-solid fa-trash"></i>

Delete

</a>

</div>

</div>

<?php } ?>

</div>

<?php } else { ?>

<div class="empty-box">

<i class="fa-regular fa-image"></i>

<h3>No Gallery Images</h3>

<p>
This product has no gallery images yet.
</p>

</div>

<?php } ?>

</div>

</div>

</div>

</body>

</html>