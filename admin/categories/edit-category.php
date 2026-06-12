<?php
session_start();
include "../../database/connection.php";

// Check admin login
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: view-categories.php");
    exit;
}

// Get category data
$query = mysqli_query($conn, "SELECT * FROM product_categories WHERE id='$id'");
$category = mysqli_fetch_assoc($query);

if (!$category) {
    header("Location: view-categories.php");
    exit;
}

$success = "";
$error = "";

// Auto-generate slug from name
function createSlug($string) {
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return trim($string, '-');
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_category'])) {
    
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $category_slug = mysqli_real_escape_string($conn, $_POST['category_slug']);
    $category_page = mysqli_real_escape_string($conn, $_POST['category_page']);
    $category_description = mysqli_real_escape_string($conn, $_POST['category_description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    if (empty($category_name)) {
        $error = "Category name is required!";
    } else {
        // Auto-generate slug if empty
        if (empty($category_slug)) {
            $category_slug = createSlug($category_name);
        }
        
        // Check if slug already exists for other category
        $checkSlug = mysqli_query($conn, "SELECT id FROM product_categories WHERE category_slug='$category_slug' AND id != '$id'");
        if(mysqli_num_rows($checkSlug) > 0){
            $category_slug = $category_slug . '-' . $id;
        }
        
        // Handle image upload
        $category_image = $category['category_image'];
        if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == 0) {
            $upload_dir = "../../uploads/categories/";
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            // Delete old image
            if (!empty($category_image) && file_exists($upload_dir . $category_image)) {
                unlink($upload_dir . $category_image);
            }
            $image_name = time() . '_' . basename($_FILES['category_image']['name']);
            move_uploaded_file($_FILES['category_image']['tmp_name'], $upload_dir . $image_name);
            $category_image = $image_name;
        }
        
        // Update database
        $updateQuery = "UPDATE product_categories SET 
                        category_name='$category_name',
                        category_slug='$category_slug',
                        category_page='$category_page',
                        category_description='$category_description',
                        category_image='$category_image',
                        status='$status'
                        WHERE id='$id'";
        
        if (mysqli_query($conn, $updateQuery)) {
            $success = "Category updated successfully!";
            // Refresh category data
            $query = mysqli_query($conn, "SELECT * FROM product_categories WHERE id='$id'");
            $category = mysqli_fetch_assoc($query);
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}

// Handle delete image
if (isset($_GET['delete_image'])) {
    $upload_dir = "../../uploads/categories/";
    if (!empty($category['category_image']) && file_exists($upload_dir . $category['category_image'])) {
        unlink($upload_dir . $category['category_image']);
    }
    mysqli_query($conn, "UPDATE product_categories SET category_image='' WHERE id='$id'");
    header("Location: edit-category.php?id=$id");
    exit;
}
?>

<?php include "../../header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: #f5f7fb;
            font-family: 'Segoe UI', sans-serif;
        }
        .form-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin: 30px auto;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .btn-update {
            background: #1ca037;
            color: white;
            padding: 12px 30px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
        }
        .btn-update:hover {
            background: #157d2a;
        }
        .image-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #ddd;
            margin-top: 10px;
        }
        .current-image {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1"><i class="fas fa-edit text-success me-2"></i>Edit Category</h4>
                <p class="text-muted mb-0 small">Update category information</p>
            </div>
            <a href="view-categories.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Categories
            </a>
        </div>
        
        <?php if($success): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i> <?php echo $success; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-triangle me-2"></i> <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                
                <!-- Category Name -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="category_name" class="form-control" 
                           value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
                </div>
                
                <!-- Category Slug (Unique) -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category Slug (URL)</label>
                    <input type="text" name="category_slug" class="form-control" 
                           value="<?php echo htmlspecialchars($category['category_slug'] ?? ''); ?>">
                    <small class="text-muted">Unique URL identifier for this category</small>
                </div>
                
                <!-- Category Page -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category Page</label>
                    <input type="text" name="category_page" class="form-control" 
                           value="<?php echo htmlspecialchars($category['category_page'] ?? ''); ?>">
                    <small class="text-muted">Template file name (e.g., product-list-template.php)</small>
                </div>
                
                <!-- Category Image -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category Image</label>
                    
                    <?php if(!empty($category['category_image'])): ?>
                        <div class="current-image">
                            <strong>Current Image:</strong><br>
                            <img src="../../uploads/categories/<?php echo $category['category_image']; ?>" 
                                 class="image-preview">
                            <br>
                            <a href="?delete_image=1&id=<?php echo $id; ?>" 
                               class="btn btn-danger btn-sm mt-2"
                               onclick="return confirm('Delete this image?')">
                                <i class="fas fa-trash me-1"></i> Remove Image
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <input type="file" name="category_image" class="form-control" accept="image/*" id="imageInput">
                    <small class="text-muted">Leave empty to keep current image</small>
                    <img id="imagePreview" class="image-preview" style="display:none;">
                </div>
                
                <!-- Status -->
                <div class="col-md-12 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" <?php echo $category['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo $category['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                
                <!-- Description -->
                <div class="col-md-12 mb-3">
                    <label class="form-label">Category Description</label>
                    <textarea name="category_description" class="form-control" rows="4"><?php 
                        echo htmlspecialchars($category['category_description'] ?? ''); 
                    ?></textarea>
                </div>
                
                <!-- Submit Button -->
                <div class="col-12 mt-3">
                    <button type="submit" name="update_category" class="btn-update">
                        <i class="fas fa-save me-2"></i> Update Category
                    </button>
                    <a href="view-categories.php" class="btn btn-secondary ms-2">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                </div>
                
            </div>
        </form>
        
    </div>
</div>

<script>
    // Image preview
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include "../../footer.php"; ?>