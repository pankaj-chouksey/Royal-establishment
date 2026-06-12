<?php
include "../../database/connection.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("<div class='alert alert-danger m-5'>Invalid Product ID! <a href='view-products.php'>Go Back</a></div>");
}

$productQuery = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
$product = mysqli_fetch_assoc($productQuery);

if (!$product) {
    die("<div class='alert alert-danger m-5'>Product not found! <a href='view-products.php'>Go Back</a></div>");
}

$message = "";

/* UPDATE PRODUCT */
if(isset($_POST['update_product'])){

    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']);
    $model_no = mysqli_real_escape_string($conn, $_POST['model_no']);
    $short_description = mysqli_real_escape_string($conn, $_POST['short_description']);
    $full_description = mysqli_real_escape_string($conn, $_POST['full_description']);
    $youtube_link = mysqli_real_escape_string($conn, $_POST['youtube_link']);
    $meta_title = mysqli_real_escape_string($conn, $_POST['meta_title']);
    $meta_description = mysqli_real_escape_string($conn, $_POST['meta_description']);
    $meta_keywords = mysqli_real_escape_string($conn, $_POST['meta_keywords']);

    // FEATURED IMAGE UPDATE
    $featured_image = $product['featured_image'];
    if(isset($_FILES['featured_image']) && $_FILES['featured_image']['name'] != ""){
        $image_name = time() . '_' . basename($_FILES['featured_image']['name']);
        $tmp_name = $_FILES['featured_image']['tmp_name'];
        move_uploaded_file($tmp_name, "../../uploads/products/" . $image_name);
        $featured_image = $image_name;
    }

    // UPDATE PRODUCT
    mysqli_query($conn, "
        UPDATE products SET 
            category_id='$category_id',
            product_name='$product_name',
            slug='$slug',
            model_no='$model_no',
            short_description='$short_description',
            description='$full_description',
            youtube_link='$youtube_link',
            featured_image='$featured_image',
            meta_title='$meta_title',
            meta_description='$meta_description',
            meta_keywords='$meta_keywords'
        WHERE id='$id'
    ");

    // DELETE OLD FEATURES
    mysqli_query($conn, "DELETE FROM product_features WHERE product_id='$id'");

    // INSERT FEATURES AGAIN
    if(isset($_POST['feature_name']) && is_array($_POST['feature_name'])){
        $feature_names = $_POST['feature_name'];
        $feature_values = $_POST['feature_value'];
        foreach($feature_names as $key => $feature){
            $feature_name = mysqli_real_escape_string($conn, $feature_names[$key]);
            $feature_value = mysqli_real_escape_string($conn, $feature_values[$key]);
            if($feature_name != ""){
                mysqli_query($conn, "
                    INSERT INTO product_features(product_id, feature_name, feature_value)
                    VALUES('$id', '$feature_name', '$feature_value')
                ");
            }
        }
    }

    // GALLERY IMAGES HANDLING
    if(isset($_FILES['gallery_images']) && $_FILES['gallery_images']['name'][0] != ""){
        $files = $_FILES['gallery_images'];
        for($i = 0; $i < count($files['name']); $i++){
            if($files['error'][$i] == 0){
                $gallery_name = time() . '_' . $i . '_' . basename($files['name'][$i]);
                move_uploaded_file($files['tmp_name'][$i], "../../uploads/products/gallery/" . $gallery_name);
                mysqli_query($conn, "INSERT INTO product_images(product_id, image_path) VALUES('$id', '$gallery_name')");
            }
        }
    }

    $message = "Product Updated Successfully";

    // REFRESH PRODUCT DATA
    $productQuery = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
    $product = mysqli_fetch_assoc($productQuery);
}

// GET CATEGORIES
$catQuery = mysqli_query($conn, "SELECT * FROM product_categories WHERE status='active'");

// GET FEATURES
$featureQuery = mysqli_query($conn, "SELECT * FROM product_features WHERE product_id='$id'");

// GET GALLERY IMAGES
$galleryQuery = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id='$id'");
?>

<?php include "../../header.php"; ?>

<style>
.edit-page{
    background:#f5f5f5;
    min-height:100vh;
    padding:50px 0;
}
.edit-card{
    background:#fff;
    padding:30px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}
.product-preview{
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:10px;
    margin-bottom:15px;
}
.feature-row{
    background:#f8f9fa;
    padding:15px;
    border-radius:10px;
    margin-bottom:15px;
}
.gallery-image{
    width:100px;
    height:100px;
    object-fit:cover;
    border-radius:8px;
    margin:5px;
    border:2px solid #ddd;
}
.section-title{
    border-left:4px solid #1ca037;
    padding-left:15px;
    margin:25px 0 20px;
    font-weight:700;
}
</style>

<div class="edit-page">
<div class="container">
<div class="edit-card">

<h2 class="mb-4">
    <i class="fa-solid fa-pen-to-square me-2"></i>
    Edit Product
    <a href="view-products.php" class="btn btn-secondary float-end">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Products
    </a>
</h2>

<?php if($message != ""){ ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fa-solid fa-check-circle me-2"></i> <?php echo $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php } ?>

<form method="POST" enctype="multipart/form-data">
    <div class="row">

        <!-- CATEGORY -->
        <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
            <select name="category_id" class="form-select" required>
                <option value="">Select Category</option>
                <?php while($cat = mysqli_fetch_assoc($catQuery)){ ?>
                    <option value="<?php echo $cat['id']; ?>" 
                        <?php echo ($cat['id'] == ($product['category_id'] ?? 0)) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['category_name']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- PRODUCT NAME -->
        <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
            <input type="text" name="product_name" class="form-control" required 
                   value="<?php echo htmlspecialchars($product['product_name'] ?? ''); ?>">
        </div>

        <!-- PRICE -->
        <!-- div class="col-md-4 mb-3">
            <label class="form-label fw-bold">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" 
                   value="<?php echo $product['price'] ?? 0; ?>">
        </div>< -->

        <!-- TAG / SLUG -->
        <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">Tag / Slug</label>
            <input type="text" name="slug" class="form-control" 
                   value="<?php echo htmlspecialchars($product['slug'] ?? ''); ?>"
                   placeholder="product-url-slug">
        </div>

        <!-- MODEL NO -->
        <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">Model No</label>
            <input type="text" name="model_no" class="form-control" 
                   value="<?php echo htmlspecialchars($product['model_no'] ?? ''); ?>">
        </div>

        <!-- FEATURED IMAGE -->
        <div class="col-md-12 mb-3">
            <label class="form-label fw-bold">Featured Image</label>
            <?php if(!empty($product['featured_image']) && file_exists("../../uploads/products/" . $product['featured_image'])): ?>
                <div class="current-image mb-2">
                    <strong>Current Image:</strong><br>
                    <img src="../../uploads/products/<?php echo $product['featured_image']; ?>" class="product-preview">
                </div>
            <?php endif; ?>
            <input type="file" name="featured_image" class="form-control" accept="image/*">
            <small class="text-muted">Leave empty to keep current image</small>
        </div>

        <!-- PRODUCT GALLERY IMAGES -->
        <div class="col-md-12 mb-3">
            <label class="form-label fw-bold">Product Gallery Images</label>
            
            <?php if(mysqli_num_rows($galleryQuery) > 0): ?>
                <div class="current-gallery mb-3">
                    <strong>Current Gallery Images:</strong><br>
                    <div class="d-flex flex-wrap">
                        <?php while($gallery = mysqli_fetch_assoc($galleryQuery)){ ?>
                            <div class="gallery-image-wrapper position-relative d-inline-block m-1">
<img
src="../../uploads/products/<?php echo $gallery['image_name']; ?>"
class="gallery-image"
style="width:100px;height:100px;object-fit:cover;border-radius:8px;"
onerror="this.src='../../Images/no-image.png'"
>                                <a href="delete-gallery-image.php?id=<?php echo $gallery['id']; ?>&product_id=<?php echo $id; ?>" 
                                   class="btn btn-danger btn-sm position-absolute top-0 end-0 rounded-circle"
                                   onclick="return confirm('Delete this image?')">
                                    <i class="fa-solid fa-times"></i>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>
            <small class="text-muted">You can select multiple images to add more</small>
        </div>

        <!-- SHORT DESCRIPTION -->
        <div class="col-md-12 mb-3">
            <label class="form-label fw-bold">Short Description</label>
            <textarea name="short_description" class="form-control" rows="3"><?php 
                echo htmlspecialchars($product['short_description'] ?? ''); 
            ?></textarea>
        </div>

        <!-- FULL DESCRIPTION -->
        <div class="col-md-12 mb-3">
            <label class="form-label fw-bold">Full Description</label>
            <textarea name="full_description" class="form-control" rows="6"><?php 
                echo htmlspecialchars($product['description'] ?? ''); 
            ?></textarea>
        </div>

        <!-- YOUTUBE LINK -->
        <div class="col-md-12 mb-3">
            <label class="form-label fw-bold">YouTube Link</label>
            <input type="url" name="youtube_link" class="form-control" 
                   value="<?php echo htmlspecialchars($product['youtube_link'] ?? ''); ?>"
                   placeholder="https://youtube.com/watch?v=...">
        </div>

        <!-- PRODUCT FEATURES SECTION -->
        <div class="col-12 mb-4">
            <h4 class="section-title">
                <i class="fa-solid fa-list-check me-2"></i>
                Product Features / Specifications
            </h4>
            <div id="featuresContainer">
                <?php 
                if(mysqli_num_rows($featureQuery) > 0){
                    while($feature = mysqli_fetch_assoc($featureQuery)){ 
                ?>
                    <div class="feature-row row">
                        <div class="col-md-5 mb-2 mb-md-0">
                            <input type="text" name="feature_name[]" class="form-control" 
                                   value="<?php echo htmlspecialchars($feature['feature_name'] ?? ''); ?>" 
                                   placeholder="Feature Name (e.g., Brand)">
                        </div>
                        <div class="col-md-5 mb-2 mb-md-0">
                            <input type="text" name="feature_value[]" class="form-control" 
                                   value="<?php echo htmlspecialchars($feature['feature_value'] ?? ''); ?>" 
                                   placeholder="Feature Value (e.g., Royal)">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger w-100 remove-feature">
                                <i class="fa-solid fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                <?php 
                    }
                } else { 
                ?>
                    <div class="feature-row row">
                        <div class="col-md-5 mb-2 mb-md-0">
                            <input type="text" name="feature_name[]" class="form-control" placeholder="Feature Name">
                        </div>
                        <div class="col-md-5 mb-2 mb-md-0">
                            <input type="text" name="feature_value[]" class="form-control" placeholder="Feature Value">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger w-100 remove-feature">
                                <i class="fa-solid fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <button type="button" class="btn btn-success mt-2" id="addFeature">
                <i class="fa-solid fa-plus me-1"></i> Add More Feature
            </button>
        </div>

        <!-- SEO SECTION -->
        <h4 class="section-title">
            <i class="fa-solid fa-chart-line me-2"></i>
            SEO Settings
        </h4>

        <div class="col-md-12 mb-3">
            <label class="form-label fw-bold">Meta Title</label>
            <input type="text" name="meta_title" class="form-control" 
                   value="<?php echo htmlspecialchars($product['meta_title'] ?? ''); ?>">
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label fw-bold">Meta Description</label>
            <textarea name="meta_description" class="form-control" rows="2"><?php 
                echo htmlspecialchars($product['meta_description'] ?? ''); 
            ?></textarea>
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label fw-bold">Meta Keywords</label>
            <input type="text" name="meta_keywords" class="form-control" 
                   value="<?php echo htmlspecialchars($product['meta_keywords'] ?? ''); ?>"
                   placeholder="keyword1, keyword2, keyword3">
        </div>

        <!-- SUBMIT BUTTON -->
        <div class="col-12 mt-3">
            <button type="submit" name="update_product" class="btn btn-primary btn-lg px-5">
                <i class="fa-solid fa-save me-2"></i> Update Product
            </button>
            <a href="view-products.php" class="btn btn-secondary btn-lg px-4 ms-2">
                <i class="fa-solid fa-times me-1"></i> Cancel
            </a>
        </div>

    </div>
</form>

</div>
</div>
</div>

<script>
// Add Feature Row
document.getElementById('addFeature').addEventListener('click', function() {
    const container = document.getElementById('featuresContainer');
    const newRow = document.createElement('div');
    newRow.className = 'feature-row row';
    newRow.innerHTML = `
        <div class="col-md-5 mb-2 mb-md-0">
            <input type="text" name="feature_name[]" class="form-control" placeholder="Feature Name">
        </div>
        <div class="col-md-5 mb-2 mb-md-0">
            <input type="text" name="feature_value[]" class="form-control" placeholder="Feature Value">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger w-100 remove-feature">
                <i class="fa-solid fa-trash"></i> Remove
            </button>
        </div>
    `;
    container.appendChild(newRow);
});

// Remove Feature Row
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-feature') || e.target.parentElement.classList.contains('remove-feature')) {
        const btn = e.target.classList.contains('remove-feature') ? e.target : e.target.parentElement;
        btn.closest('.feature-row').remove();
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include "../../footer.php"; ?>