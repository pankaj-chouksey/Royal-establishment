<?php

include "../database/connection.php";

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($product_id <= 0){
    die("<div class='alert alert-danger m-5'>Invalid Product ID!</div>");
}

/* PRODUCT */
$productQuery = mysqli_query($conn, "SELECT * FROM products WHERE id='$product_id'");
$product = mysqli_fetch_assoc($productQuery);

if(!$product){
    die("<div class='alert alert-danger m-5'>Product not found!</div>");
}

/* FEATURED IMAGE - FIXED */
$featured_image_path = "";
if(!empty($product['featured_image']) && file_exists("../uploads/products/" . $product['featured_image'])){
    $featured_image_path = "../uploads/products/" . $product['featured_image'];
} else {
    $featured_image_path = "../Images/no-image.png";
}

?>

<?php include "../header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name'] ?? 'Product Details'); ?></title>
    <style>
        body {
            background: #f5f7fa;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        .product-page {
            padding: 60px 0;
        }

        .product-card {
            background: #fff;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .product-gallery {
            display: flex;
            gap: 15px;
        }

        .thumbnail-wrapper {
            width: 90px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .thumbnail-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            cursor: pointer;
            transition: 0.3s;
            background: #fff;
        }

        .thumbnail-image:hover {
            border-color: #16a34a;
        }

        .main-image-wrapper {
            flex: 1;
        }

        .main-product-image {
            width: 100%;
            height: 500px;
            object-fit: contain;
            border-radius: 15px;
            border: 1px solid #e5e7eb;
            background: #fff;
            padding: 15px;
        }

        .product-title {
            font-size: 42px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 32px;
            font-weight: 700;
            color: #16a34a;
            margin-bottom: 15px;
        }

        .product-model {
            font-size: 18px;
            color: #6b7280;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        .product-description {
            color: #374151;
            line-height: 1.9;
            font-size: 16px;
        }

        .spec-box {
            background: #f9fafb;
            border-radius: 12px;
            padding: 25px;
            margin-top: 30px;
        }

        .spec-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .spec-table {
            width: 100%;
            border-collapse: collapse;
        }

        .spec-table tr {
            border-bottom: 1px solid #e5e7eb;
        }

        .spec-table td {
            padding: 14px;
            font-size: 15px;
        }

        .spec-name {
            width: 40%;
            font-weight: 600;
            color: #111827;
        }

        .spec-value {
            color: #4b5563;
        }

        .product-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .inquiry-btn {
            background: #2563eb;
            color: #fff;
            padding: 14px 28px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }

        .inquiry-btn:hover {
            background: #1d4ed8;
            color: #fff;
        }

        .whatsapp-btn {
            background: #16a34a;
            color: #fff;
            padding: 14px 28px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }

        .whatsapp-btn:hover {
            background: #15803d;
            color: #fff;
        }

        .youtube-link {
            background: #dc2626;
            color: #fff;
            padding: 14px 28px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }

        .youtube-link:hover {
            background: #b91c1c;
            color: #fff;
        }

        @media(max-width:992px) {
            .product-title {
                font-size: 32px;
            }
            .main-product-image {
                height: 350px;
            }
        }

        @media(max-width:768px) {
            .product-gallery {
                flex-direction: column;
            }
            .thumbnail-wrapper {
                width: 100%;
                flex-direction: row;
            }
            .thumbnail-image {
                width: 70px;
                height: 70px;
            }
            .main-product-image {
                height: 300px;
            }
            .product-title {
                font-size: 28px;
            }
            .product-card {
                padding: 20px;
            }
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #9ca3af;
        }
    </style>
</head>
<body>

<div class="product-page">
    <div class="container">
        <div class="product-card">
            <div class="row g-5 align-items-start">
                
                <!-- LEFT - GALLERY SECTION -->
                <div class="col-lg-6">
                    <div class="product-gallery">
                        
                        <!-- THUMBNAILS -->
                        <div class="thumbnail-wrapper">
                            <!-- FEATURED IMAGE -->
                            <img src="<?php echo $featured_image_path; ?>" 
                                 class="thumbnail-image" 
                                 onclick="changeImage(this)"
                                 alt="thumbnail">
                            
                            <?php
                            // ✅ FIXED: Use correct column name 'image_path' not 'image_name'
                            $imageQuery = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id='$product_id'");
                            
                           while($gallery = mysqli_fetch_assoc($imageQuery)){

    $gallery_image =
    "../uploads/products/" .
    $gallery['image_name'];

    if(
        empty($gallery['image_name']) ||
        !file_exists($gallery_image)
    ){

        $gallery_image =
        "../Images/no-image.png";

    }

?>
                                <img src="<?php echo $gallery_image; ?>" 
                                     class="thumbnail-image" 
                                     onclick="changeImage(this)"
                                     alt="gallery image">
                            <?php } ?>
                        </div>
                        
                        <!-- MAIN IMAGE -->
                        <div class="main-image-wrapper">
                            <img id="mainProductImage" 
                                 src="<?php echo $featured_image_path; ?>" 
                                 class="main-product-image"
                                 alt="product image">
                        </div>
                        
                    </div>
                </div>
                
                <!-- RIGHT - PRODUCT INFO -->
                <div class="col-lg-6">
                    
                    <h1 class="product-title">
                        <?php echo htmlspecialchars($product['product_name'] ?? 'N/A'); ?>
                    </h1>
                    
                    <?php if(isset($product['price']) && $product['price'] > 0): ?>
                    <div class="product-price">
                        ₹ <?php echo number_format($product['price'], 2); ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="product-model">
                        <strong>Model No:</strong> <?php echo htmlspecialchars($product['model_no'] ?? 'N/A'); ?>
                        <?php if(!empty($product['tag'])): ?>
                            <br><strong>Tag:</strong> <?php echo htmlspecialchars($product['tag']); ?>
                        <?php endif; ?>
                    </div>
                    
                    <!-- SHORT DESCRIPTION -->
                    <?php if(!empty($product['short_description'])): ?>
                    <div class="product-description">
                        <h4>Short Description</h4>
                        <p><?php echo nl2br(htmlspecialchars($product['short_description'])); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <!-- FULL DESCRIPTION -->
                    <?php if(!empty($product['description'])): ?>
                    <div class="product-description">
                        <h4>Description</h4>
                        <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <!-- SPECIFICATIONS -->
                    <div class="spec-box">
                        <h2 class="spec-title">Technical Specifications</h2>
                        <table class="spec-table">
                            <?php
                            $featureQuery = mysqli_query($conn, "SELECT * FROM product_features WHERE product_id='$product_id'");
                            
                            if(mysqli_num_rows($featureQuery) > 0){
                                while($feature = mysqli_fetch_assoc($featureQuery)){
                            ?>
                                <tr>
                                    <td class="spec-name">
                                        <?php echo htmlspecialchars($feature['feature_name'] ?? 'N/A'); ?>
                                    </td>
                                    <td class="spec-value">
                                        <?php echo htmlspecialchars($feature['feature_value'] ?? 'N/A'); ?>
                                    </td>
                                </tr>
                            <?php 
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="2" class="no-data">No specifications available</td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    
                    <!-- BUTTONS -->
                    <div class="product-buttons">
                        <a href="#" class="inquiry-btn" onclick="sendInquiry()">
                            <i class="fas fa-envelope"></i> Send Inquiry
                        </a>
                        <a href="https://wa.me/919876543210?text=Hi, I'm interested in <?php echo urlencode($product['product_name'] ?? ''); ?>" 
                           target="_blank" class="whatsapp-btn">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <?php if(!empty($product['youtube_link'])): ?>
                        <a href="<?php echo $product['youtube_link']; ?>" target="_blank" class="youtube-link">
                            <i class="fab fa-youtube"></i> Watch Video
                        </a>
                        <?php endif; ?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function changeImage(imageElement) {
    document.getElementById("mainProductImage").src = imageElement.src;
}

function sendInquiry() {
    let productName = "<?php echo addslashes($product['product_name'] ?? ''); ?>";
    let productModel = "<?php echo addslashes($product['model_no'] ?? ''); ?>";
    let body = `I am interested in ${productName} (Model: ${productModel})`;
    window.location.href = `mailto:admin@royalestablishment.com?subject=Product Inquiry - ${productName}&body=${encodeURIComponent(body)}`;
}
</script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</body>
</html>

<?php include "../footer.php"; ?>