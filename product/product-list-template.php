<?php

include "database/connection.php";

$current_page = basename($_SERVER['PHP_SELF']);

/* CATEGORY FIND */

$categoryQuery = mysqli_query($conn,

"

SELECT * FROM product_categories
WHERE LOWER(category_page) = LOWER('$current_page')
AND status='active'

"

);

/* QUERY ERROR */

if(!$categoryQuery){

    die("Category Query Failed : " . mysqli_error($conn));

}

/* CATEGORY FETCH */

$category = mysqli_fetch_assoc($categoryQuery);

/* CATEGORY CHECK */

if($category){

    $category_id = $category['id'];

    $category_name = $category['category_name'];

} else {

    $category_id = 0;

    $category_name = "All Products";

}

?>

<?php include "header.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>

<?php echo $category_name; ?>

</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{
    background:#f5f7fb;
    font-family:'Poppins',sans-serif;
}

/* PAGE */

.product-page{
    padding:60px 0;
}

/* TITLE */

.page-title{
    text-align:center;
    margin-bottom:50px;
}

.page-title h1{
    font-size:42px;
    font-weight:700;
    color:#111827;
}

.page-title p{
    color:#6b7280;
    margin-top:10px;
}

/* CARD */

.product-card{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
    transition:.3s;
    height:100%;
}

.product-card:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}

/* IMAGE */

.product-image{
    width:100%;
    height:280px;
    object-fit:cover;
    background:#f3f4f6;
}

/* CONTENT */

.product-content{
    padding:25px;
}

.product-name{
    font-size:22px;
    font-weight:700;
    color:#111827;
    margin-bottom:12px;
}

.product-desc{
    color:#6b7280;
    font-size:15px;
    line-height:1.8;
    margin-bottom:20px;
}

/* BUTTON */

.product-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;

    background:#16a34a;
    color:#fff;

    padding:12px 22px;

    border-radius:10px;

    text-decoration:none;

    font-weight:600;

    transition:.3s;
}

.product-btn:hover{
    background:#15803d;
    color:#fff;
}

/* NO PRODUCT */

.no-product{
    background:#fff;
    padding:60px 30px;
    border-radius:18px;
    text-align:center;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

.no-product i{
    font-size:70px;
    color:#d1d5db;
    margin-bottom:20px;
}

/* MOBILE */

@media(max-width:768px){

    .page-title h1{
        font-size:32px;
    }

    .product-image{
        height:220px;
    }

}

</style>

</head>

<body>

<div class="product-page">

<div class="container">

<!-- TITLE -->

<div class="page-title">

<h1>

<?php echo $category_name; ?>

</h1>

<p>

Browse Our Premium Healthcare Products

</p>

</div>

<!-- PRODUCTS -->

<div class="row g-4">

<?php

/* PRODUCT QUERY */

if($category_id > 0){

$productQuery = mysqli_query($conn,

"

SELECT * FROM products
WHERE category_id='$category_id'
AND status='active'
ORDER BY id DESC

"

);

} else {

$productQuery = mysqli_query($conn,

"

SELECT * FROM products
WHERE status='active'
ORDER BY id DESC

"

);

}

/* QUERY ERROR */

if(!$productQuery){

echo "

<div class='col-12'>

<div class='alert alert-danger'>

Product Query Failed :
" . mysqli_error($conn) . "

</div>

</div>

";

}

/* PRODUCT LOOP */

elseif(mysqli_num_rows($productQuery) > 0){

while($product = mysqli_fetch_assoc($productQuery)){

$product_id = $product['id'];

$product_name = $product['product_name'];

$short_description =
$product['short_description'];

$image = $product['featured_image'];

/* IMAGE CHECK */

$image_path =
"uploads/products/" . $image;

if(!file_exists($image_path)
|| empty($image)){

$image_path =
"Images/no-image.png";

}

?>

<div class="col-lg-4 col-md-6">

<div class="product-card">

<img
src="<?php echo $image_path; ?>"
class="product-image"
alt="<?php echo $product_name; ?>"
>

<div class="product-content">

<h3 class="product-name">

<?php echo $product_name; ?>

</h3>

<p class="product-desc">

<?php

echo substr(
strip_tags($short_description),
0,
120
);

?>

...

</p>

<a
href="product/view_product.php?id=<?php echo $product_id; ?>"
class="product-btn"
>

View Details

<i class="fa-solid fa-arrow-right"></i>

</a>

</div>

</div>

</div>

<?php

}

} else {

?>

<div class="col-12">

<div class="no-product">

<i class="fa-solid fa-box-open"></i>

<h3>

No Products Found

</h3>

<p class="text-muted mt-2">

Products will appear here soon.

</p>

</div>

</div>

<?php } ?>

</div>

</div>

</div>

</body>

</html>

<?php include "footer.php"; ?>