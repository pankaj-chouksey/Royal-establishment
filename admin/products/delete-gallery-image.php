<?php
include "../../database/connection.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

if($id > 0){
    
    // ✅ Automatically detect image column name
    $result = mysqli_query($conn, "SHOW COLUMNS FROM product_images");
    $image_column = null;
    $possible_names = ['image_path', 'image', 'path', 'image_name', 'file_name', 'img_path', 'photo', 'picture'];
    
    while($col = mysqli_fetch_assoc($result)){
        if(in_array($col['Field'], $possible_names)){
            $image_column = $col['Field'];
            break;
        }
    }
    
    // If no matching column found, use first column as fallback
    if(!$image_column){
        mysqli_data_seek($result, 0);
        $first_col = mysqli_fetch_assoc($result);
        $image_column = $first_col['Field'];
    }
    
    // Get image path
    $imgQuery = mysqli_query($conn, "SELECT `$image_column` FROM product_images WHERE id='$id'");
    $img = mysqli_fetch_assoc($imgQuery);
    
    if($img && !empty($img[$image_column])){
        $file_path = "../../uploads/products/gallery/" . $img[$image_column];
        if(file_exists($file_path)){
            unlink($file_path);
        }
    }
    
    // Delete from database
    mysqli_query($conn, "DELETE FROM product_images WHERE id='$id'");
}

header("Location: edit-product.php?id=$product_id");
exit;
?>