<?php

// ✅ Cross-Platform Path Detection (Windows + Mac)
$root_path = dirname(dirname(dirname(__FILE__)));
include $root_path . "/database/connection.php";

$message = "";
$error_message = "";

// ✅ Cross-Platform Upload Path
$upload_path = dirname(dirname(dirname(__FILE__))) . "/uploads/products/";
$upload_path = str_replace('\\', '/', $upload_path);

// ✅ Create folder if not exists
if (!file_exists($upload_path)) {
    mkdir($upload_path, 0777, true);
}

// ✅ Debug: Check if folder is writable
$is_writable = is_writable($upload_path);
$debug_path = $upload_path;

if(isset($_POST['add_product'])){

    // ✅ SQL Injection Protection
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']);
    $model_no = mysqli_real_escape_string($conn, $_POST['model_no']);
    $short_description = mysqli_real_escape_string($conn, $_POST['short_description']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $youtube_link = mysqli_real_escape_string($conn, $_POST['youtube_link']);
    $meta_title = mysqli_real_escape_string($conn, $_POST['meta_title']);
    $meta_description = mysqli_real_escape_string($conn, $_POST['meta_description']);
    $meta_keywords = mysqli_real_escape_string($conn, $_POST['meta_keywords']);

    // ✅ FEATURED IMAGE UPLOAD
    $image_name = "";
    if(isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] == 0 && $_FILES['featured_image']['name'] != ""){
        
        // Check file size (max 5MB)
        if($_FILES['featured_image']['size'] > 5 * 1024 * 1024){
            $error_message = "Featured image is too large. Max 5MB allowed.";
        } else {
            // Safe filename
            $original_name = pathinfo($_FILES['featured_image']['name'], PATHINFO_FILENAME);
            $original_name = preg_replace('/[^a-zA-Z0-9]/', '', $original_name);
            $ext = strtolower(pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION));
            
            // Allow only image extensions
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if(!in_array($ext, $allowed_ext)){
                $error_message = "Only JPG, PNG, GIF, WEBP images allowed";
            } else {
                $image_name = uniqid() . "_" . time() . "." . $ext;
                $tmp_name = $_FILES['featured_image']['tmp_name'];
                $target_file = $upload_path . $image_name;
                
                // Try move_uploaded_file first
                if(move_uploaded_file($tmp_name, $target_file)){
                    // Success
                    chmod($target_file, 0644);
                } 
                // If move fails, try copy method
                else if(copy($tmp_name, $target_file)){
                    unlink($tmp_name);
                    chmod($target_file, 0644);
                }
                else {
                    $error_message = "Failed to upload featured image. Please check folder permissions.";
                    $image_name = "";
                }
            }
        }
    } else {
        if(empty($error_message)){
            $error_message = "Please select a featured image";
        }
    }

    if($image_name != "" && empty($error_message)){

        $sql = "INSERT INTO products (

            category_id,
            product_name,
            slug,
            model_no,
            short_description,
            description,
            featured_image,
            youtube_link,
            meta_title,
            meta_description,
            meta_keywords

        ) VALUES (

            '$category_id',
            '$product_name',
            '$slug',
            '$model_no',
            '$short_description',
            '$description',
            '$image_name',
            '$youtube_link',
            '$meta_title',
            '$meta_description',
            '$meta_keywords'

        )";

        if(mysqli_query($conn, $sql)){

            $product_id = mysqli_insert_id($conn);

            // ✅ GALLERY IMAGES UPLOAD
            if(isset($_FILES['gallery_images']) && !empty($_FILES['gallery_images']['name'][0])){
                
                for($i = 0; $i < count($_FILES['gallery_images']['name']); $i++){
                    
                    if($_FILES['gallery_images']['error'][$i] == 0 && $_FILES['gallery_images']['name'][$i] != ""){
                        
                        // Check file size
                        if($_FILES['gallery_images']['size'][$i] > 5 * 1024 * 1024){
                            continue; // Skip large files
                        }
                        
                        $original_name = pathinfo($_FILES['gallery_images']['name'][$i], PATHINFO_FILENAME);
                        $original_name = preg_replace('/[^a-zA-Z0-9]/', '', $original_name);
                        $ext = strtolower(pathinfo($_FILES['gallery_images']['name'][$i], PATHINFO_EXTENSION));
                        
                        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                        if(!in_array($ext, $allowed_ext)){
                            continue;
                        }
                        
                        $gallery_name = uniqid() . "_" . time() . "_" . $i . "." . $ext;
                        $tmp_name = $_FILES['gallery_images']['tmp_name'][$i];
                        $target_file = $upload_path . $gallery_name;
                        
                        if(move_uploaded_file($tmp_name, $target_file) || copy($tmp_name, $target_file)){
                            if(file_exists($tmp_name)) unlink($tmp_name);
                            chmod($target_file, 0644);
                            
                            mysqli_query($conn, "
                                INSERT INTO product_images(product_id, image_name)
                                VALUES('$product_id', '$gallery_name')
                            ");
                        }
                    }
                }
            }

            // ✅ PRODUCT FEATURES
            if(isset($_POST['feature_name']) && !empty($_POST['feature_name'])){
                $feature_names = $_POST['feature_name'];
                $feature_values = $_POST['feature_value'];
                
                foreach($feature_names as $key => $feature){
                    if(!empty($feature_names[$key])){
                        $feature_name = mysqli_real_escape_string($conn, $feature_names[$key]);
                        $feature_value = mysqli_real_escape_string($conn, $feature_values[$key]);
                        
                        mysqli_query($conn, "
                            INSERT INTO product_features(product_id, feature_name, feature_value)
                            VALUES('$product_id', '$feature_name', '$feature_value')
                        ");
                    }
                }
            }

            $message = "Product Added Successfully";
            
            // Optional: Redirect to clear form
            // echo "<script>setTimeout(function(){ window.location.href = 'add-product.php'; }, 2000);</script>";
            
        } else {
            $error_message = mysqli_error($conn);
        }
    }
}

?>

<?php include "../../header.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Product</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
/>
<style>

body{
    background:#f5f5f5;
}

.admin-card{
    background:#fff;
    padding:30px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

</style>

</head>

<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="admin-card">

                <h2 class="mb-4">
                    Add Product
                </h2>

                <?php if($message != ""){ ?>

                    <div class="alert alert-success">

                        <?php echo $message; ?>

                    </div>

                <?php } ?>

                <?php if($error_message != ""){ ?>

                    <div class="alert alert-danger">

                        <?php echo $error_message; ?>

                    </div>

                <?php } ?>

<form method="POST" enctype="multipart/form-data">

<div class="row">

<!-- CATEGORY -->

<div class="col-md-6 mb-3">

<label class="form-label">
Category
</label>

<select
name="category_id"
class="form-select"
required
>

<option value="">
Select Category
</option>

<?php

$categories = mysqli_query($conn,
"SELECT * FROM product_categories");

while($cat = mysqli_fetch_assoc($categories)){

?>

<option value="<?php echo $cat['id']; ?>">

<?php echo $cat['category_name']; ?>

</option>

<?php } ?>

</select>

</div>

<!-- PRODUCT NAME -->

<div class="col-md-6 mb-3">

<label class="form-label">
Product Name
</label>

<input
type="text"
name="product_name"
class="form-control"
required
>

</div>

<!-- SLUG -->

<div class="col-md-6 mb-3">

<label class="form-label">
Slug
</label>

<input
type="text"
name="slug"
class="form-control"
required
>

</div>

<!-- MODEL -->

<div class="col-md-6 mb-3">

<label class="form-label">
Model No
</label>

<input
type="text"
name="model_no"
class="form-control"
>

</div>

<!-- IMAGE -->



<div class="col-md-12 mb-3">

<label class="form-label">
Featured Image
</label>

<input
type="file"
name="featured_image"
class="form-control"
required
>

<div class="mt-3">

<label class="form-label">
Product Gallery Images
</label>

<input
type="file"
name="gallery_images[]"
class="form-control"
multiple
>

</div>

</div>


<!-- GALLERY IMAGES -->

<div class="col-md-12 mb-4">

<label class="form-label fw-bold">

Gallery Images

</label>

<input
type="file"
name="gallery_images[]"
class="form-control"
multiple
accept="image/*"
id="galleryInput"
>

<div id="galleryPreview" class="d-flex flex-wrap gap-3 mt-3"></div>

</div>



<!-- SHORT DESC -->

<div class="col-md-12 mb-3">

<label class="form-label">
Short Description
</label>

<textarea
name="short_description"
class="form-control"
rows="3"
></textarea>

</div>

<!-- FULL DESC -->

<div class="col-md-12 mb-3">

<label class="form-label">
Full Description
</label>

<textarea
name="description"
class="form-control"
rows="6"
></textarea>

</div>

<!-- YOUTUBE -->

<div class="col-md-12 mb-3">

<label class="form-label">
YouTube Link
</label>

<input
type="text"
name="youtube_link"
class="form-control"
>

</div>





<!-- PRODUCT FEATURES -->

<div class="col-12 mb-4">

<label class="form-label fw-bold fs-5">

<i class="fa-solid fa-list-check me-2"></i>

Product Features

</label>

<div
id="featureWrapper"
class="border rounded p-3 bg-light"
>

<div class="feature-item row g-2 align-items-center mb-3">

<div class="col-lg-5 col-md-5">

<input
type="text"
name="feature_name[]"
class="form-control"
placeholder="Feature Name"
>

</div>

<div class="col-lg-5 col-md-5">

<input
type="text"
name="feature_value[]"
class="form-control"
placeholder="Feature Value"
>

</div>

<div class="col-lg-2 col-md-2">

<button
type="button"
class="btn btn-success w-100"
onclick="addFeature()"
>

<i class="fa-solid fa-plus"></i>

</button>

</div>

</div>

</div>

</div>



<!-- SEO -->

<div class="col-md-12 mb-3">

<label class="form-label">
Meta Title
</label>

<input
type="text"
name="meta_title"
class="form-control"
>

</div>

<div class="col-md-12 mb-3">

<label class="form-label">
Meta Description
</label>

<textarea
name="meta_description"
class="form-control"
rows="3"
></textarea>

</div>

<div class="col-md-12 mb-3">

<label class="form-label">
Meta Keywords
</label>

<textarea
name="meta_keywords"
class="form-control"
rows="2"
></textarea>

</div>

<div class="col-md-12">

<button
type="submit"
name="add_product"
class="btn btn-success"
>

Add Product

</button>

</div>

</div>

</form>

            </div>

        </div>

    </div>

</div>

</body>
<script>

function addFeature(){

    let html = `

    <div class="feature-item row g-2 align-items-center mb-3">

        <div class="col-lg-5 col-md-5">

            <input
            type="text"
            name="feature_name[]"
            class="form-control"
            placeholder="Feature Name"
            >

        </div>

        <div class="col-lg-5 col-md-5">

            <input
            type="text"
            name="feature_value[]"
            class="form-control"
            placeholder="Feature Value"
            >

        </div>

        <div class="col-lg-2 col-md-2">

            <button
            type="button"
            class="btn btn-danger w-100"
            onclick="removeFeature(this)"
            >

            <i class="fa-solid fa-trash"></i>

            </button>

        </div>

    </div>

    `;

    document
    .getElementById("featureWrapper")
    .insertAdjacentHTML("beforeend", html);

}

function removeFeature(button){

    button.closest(".feature-item").remove();

}

// Gallery preview (works on both platforms)
document.getElementById('galleryInput').addEventListener('change', function(e) {
    const preview = document.getElementById('galleryPreview');
    preview.innerHTML = '';
    const files = e.target.files;
    
    for(let i = 0; i < files.length; i++) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = document.createElement('img');
            img.src = event.target.result;
            img.style.width = '80px';
            img.style.height = '80px';
            img.style.objectFit = 'cover';
            img.style.borderRadius = '8px';
            img.style.margin = '5px';
            img.style.border = '2px solid #ddd';
            preview.appendChild(img);
        }
        reader.readAsDataURL(files[i]);
    }
});
</script>

</html>
<?php include "../../footer.php"; ?>