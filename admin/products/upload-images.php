<?php

session_start();
include "../../database/connection.php";

// FIX 1: Session check
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../login.php");
    exit;
}

$message = "";

/* PRODUCT ID */

if(!isset($_GET['id'])){
    die("Product ID Missing");
}

// FIX 2: intval se SQL injection band
$product_id = intval($_GET['id']);

/* PRODUCT */

$productQuery = mysqli_query($conn,

"

SELECT * FROM products
WHERE id='$product_id'

"

);

$product = mysqli_fetch_assoc($productQuery);

/* UPLOAD */

if(isset($_POST['upload_images'])){

    $total_files =
    count($_FILES['gallery_images']['name']);

    for($i=0; $i<$total_files; $i++){

        // FIX 3 & 4: error check + uniqid
        if($_FILES['gallery_images']['error'][$i] === 0){

            $image_name =
            uniqid() . "_" .
            basename($_FILES['gallery_images']['name'][$i]);

            $tmp_name =
            $_FILES['gallery_images']['tmp_name'][$i];

            move_uploaded_file(

                $tmp_name,

                "../../uploads/products/" .
                $image_name

            );

            mysqli_query($conn,

            "

            INSERT INTO product_images(

                product_id,
                image_name

            )

            VALUES(

                '$product_id',
                '$image_name'

            )

            "

            );

        }

    }

    $message =
    "Gallery Images Uploaded Successfully";

}

?>

<?php include "../../header.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"
>

<title>

Upload Gallery Images

</title>

<style>

body{
    background:#f4f7fb;
}

/* PAGE */

.gallery-page{
    padding:60px 0;
}

/* CARD */

.gallery-card{
    background:#fff;
    padding:35px;
    border-radius:18px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

/* TITLE */

.page-title{
    font-size:34px;
    font-weight:700;
    margin-bottom:10px;
    color:#111827;
}

.product-name{
    color:#6b7280;
    margin-bottom:30px;
    font-size:18px;
}

/* ALERT */

.alert-box{
    background:#dcfce7;
    color:#166534;
    padding:14px 20px;
    border-radius:10px;
    margin-bottom:25px;
    font-weight:600;
}

/* FORM */

.upload-box{
    border:2px dashed #cbd5e1;
    padding:40px;
    border-radius:15px;
    text-align:center;
    background:#f8fafc;
}

.upload-box input{
    margin-top:20px;
}

/* BUTTON */

.upload-btn{
    background:#16a34a;
    color:#fff;
    border:none;
    padding:14px 30px;
    border-radius:10px;
    font-size:16px;
    font-weight:600;
    margin-top:20px;
    cursor:pointer;
}

.upload-btn:hover{
    background:#15803d;
}

/* GALLERY */

.gallery-grid{
    display:grid;
    grid-template-columns:
    repeat(auto-fit, minmax(200px,1fr));
    gap:20px;
    margin-top:40px;
}

.gallery-item{
    background:#fff;
    border-radius:15px;
    overflow:hidden;
    border:1px solid #e5e7eb;
    position:relative;
}

.gallery-image{
    width:100%;
    height:220px;
    object-fit:cover;
}

/* DELETE */

.delete-btn{
    position:absolute;
    top:10px;
    right:10px;
    background:#dc2626;
    color:#fff;
    width:40px;
    height:40px;
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    text-decoration:none;
    font-size:18px;
}

.delete-btn:hover{
    background:#b91c1c;
    color:#fff;
}

/* MOBILE */

@media(max-width:768px){

    .gallery-card{
        padding:20px;
    }

    .page-title{
        font-size:28px;
    }

}

</style>

</head>

<body>

<div class="gallery-page">

<div class="container">

<div class="gallery-card">

<h1 class="page-title">

Product Gallery

</h1>

<div class="product-name">

<?php echo htmlspecialchars($product['product_name']); ?>

</div>

<?php if($message != ""){ ?>

<div class="alert-box">

<?php echo $message; ?>

</div>

<?php } ?>

<!-- FORM -->

<form
method="POST"
enctype="multipart/form-data"
>

<div class="upload-box">

<h3>

Select Multiple Images

</h3>

<input
type="file"
name="gallery_images[]"
multiple
required
>

<br>

<button
type="submit"
name="upload_images"
class="upload-btn"
>

Upload Images

</button>

</div>

</form>

<!-- GALLERY -->

<div class="gallery-grid">

<?php

$imageQuery = mysqli_query($conn,

"

SELECT * FROM product_images
WHERE product_id='$product_id'

ORDER BY id DESC

"

);

while($image = mysqli_fetch_assoc($imageQuery)){

?>

<div class="gallery-item">

<img
src="../../uploads/products/<?php echo htmlspecialchars($image['image_name']); ?>"
class="gallery-image"
>

<a
href="delete-image.php?id=<?php echo $image['id']; ?>&product_id=<?php echo $product_id; ?>"
class="delete-btn"
onclick="return confirm('Delete Image?')"
>

×

</a>

</div>

<?php } ?>

</div>

</div>

</div>

</div>

</body>

</html>

<?php include "../../footer.php"; ?>