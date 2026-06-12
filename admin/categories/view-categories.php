<?php
session_start();
include "../../database/connection.php";

// Check admin login
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit;
}

// Delete category
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    
    // Check if category has products
    $checkQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM products WHERE category_id='$delete_id'");
    $check = mysqli_fetch_assoc($checkQuery);
    
    if ($check['total'] > 0) {
        $error = "Cannot delete this category because it has " . $check['total'] . " products associated with it.";
    } else {
        mysqli_query($conn, "DELETE FROM product_categories WHERE id='$delete_id'");
        $success = "Category deleted successfully!";
    }
}

// Toggle status
if (isset($_GET['toggle_id'])) {
    $toggle_id = (int)$_GET['toggle_id'];
    $currentQuery = mysqli_query($conn, "SELECT status FROM product_categories WHERE id='$toggle_id'");
    $current = mysqli_fetch_assoc($currentQuery);
    $new_status = ($current['status'] == 'active') ? 'inactive' : 'active';
    mysqli_query($conn, "UPDATE product_categories SET status='$new_status' WHERE id='$toggle_id'");
    header("Location: view-categories.php");
    exit;
}

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Search
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$where = "";
if ($search) {
    $where = "WHERE category_name LIKE '%$search%'";
}

// Get total records
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM product_categories $where");
$totalRow = mysqli_fetch_assoc($totalQuery);
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// Get categories
$query = "SELECT * FROM product_categories $where ORDER BY id DESC LIMIT $offset, $limit";
$result = mysqli_query($conn, $query);
?>

<?php include "../../header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Categories - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: #f5f7fb;
            font-family: 'Segoe UI', sans-serif;
        }
        .page-header {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .table-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .table th {
            background: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
        }
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-active {
            background: #d1fae5;
            color: #059669;
        }
        .status-inactive {
            background: #fee2e2;
            color: #dc2626;
        }
        .action-btn {
            padding: 5px 10px;
            margin: 0 2px;
            border-radius: 8px;
            font-size: 12px;
        }
        .btn-add {
            background: #1ca037;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
        }
        .btn-add:hover {
            background: #157d2a;
            color: white;
        }
        .category-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container py-4">
    
    <!-- Header -->
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1"><i class="fas fa-tags text-success me-2"></i>Product Categories</h4>
            <p class="text-muted mb-0 small">Manage all your product categories</p>
        </div>
        <a href="add-category.php" class="btn-add">
            <i class="fas fa-plus me-2"></i>Add New Category
        </a>
    </div>
    
    <!-- Success/Error Messages -->
    <?php if(isset($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <!-- Search Bar -->
    <div class="table-container mb-3">
        <form method="GET" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Search categories..." 
                       value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-search me-1"></i> Search
                </button>
            </div>
            <div class="col-md-2">
                <a href="view-categories.php" class="btn btn-secondary w-100">
                    <i class="fas fa-sync-alt me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
    
    <!-- Categories Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="50">ID</th>
                        <th>Image</th>
                        <th>Category Name</th>
                        <th>Slug</th>
                        <th>Page</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td>
                                    <?php if(!empty($row['category_image'])): ?>
                                        <img src="../../uploads/categories/<?php echo $row['category_image']; ?>" 
                                             class="category-image" onerror="this.style.display='none'">
                                    <?php else: ?>
                                        <i class="fas fa-image text-muted fa-2x"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($row['category_name']); ?></strong>
                                </td>
                                <td>
                                    <code class="small"><?php echo htmlspecialchars($row['category_slug'] ?? '-'); ?></code>
                                </td>
                                <td>
                                    <code class="small"><?php echo htmlspecialchars($row['category_page'] ?? '-'); ?></code>
                                </td>
                                <td>
                                    <span class="status-badge <?php echo $row['status'] == 'active' ? 'status-active' : 'status-inactive'; ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td class="small">
                                    <?php echo date('d M Y', strtotime($row['created_at'] ?? 'now')); ?>
                                </td>
                                <td>
                                    <a href="edit-category.php?id=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-outline-primary action-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?toggle_id=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-outline-warning action-btn" title="Toggle Status">
                                        <i class="fas fa-power-off"></i>
                                    </a>
                                    <a href="?delete_id=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-outline-danger action-btn" 
                                       title="Delete"
                                       onclick="return confirm('Are you sure you want to delete this category?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted">No categories found.</p>
                                <a href="add-category.php" class="btn btn-success mt-2">Add Your First Category</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if($totalPages > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php if($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page-1; ?>&search=<?php echo urlencode($search); ?>">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php for($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
                
                <?php if($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page+1; ?>&search=<?php echo urlencode($search); ?>">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include "../../footer.php"; ?>