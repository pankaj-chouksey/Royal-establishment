<?php

include "../../database/connection.php";

/* SEARCH */

$search = "";

if(isset($_GET['search'])){

    $search = $_GET['search'];

    $query = mysqli_query($conn,

    "

    SELECT products.*,
    product_categories.category_name

    FROM products

    LEFT JOIN product_categories

    ON products.category_id =
    product_categories.id

    WHERE

    products.product_name LIKE '%$search%'

    ORDER BY products.id DESC

    "

    );

} else {

    $query = mysqli_query($conn,

    "

    SELECT products.*,
    product_categories.category_name

    FROM products

    LEFT JOIN product_categories

    ON products.category_id =
    product_categories.id

    ORDER BY products.id DESC

    "

    );

}

?>

<?php include "../../header.php"; ?>

<style>

body{
    background:#f4f7fb;
}

/* PAGE */

.admin-products-page{
    padding:50px 0;
    min-height:100vh;
}

/* CARD */

.admin-card{
    background:#fff;
    border-radius:18px;
    padding:30px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
    overflow:hidden;
}

/* HEADER */

.page-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;
    margin-bottom:30px;
}

.page-title{
    font-size:32px;
    font-weight:700;
    color:#1e293b;
}

/* BUTTON */

.add-btn{
    background:#16a34a;
    color:#fff;
    padding:12px 22px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
    display:inline-flex;
    align-items:center;
    gap:8px;
}

.add-btn:hover{
    background:#15803d;
    color:#fff;
}

/* SEARCH */

.search-box{
    margin-bottom:25px;
}

.search-form{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.search-input{
    flex:1;
    min-width:250px;
    border:1px solid #d1d5db;
    border-radius:10px;
    padding:12px 15px;
    font-size:15px;
}

.search-btn{
    background:#2563eb;
    color:#fff;
    border:none;
    padding:12px 22px;
    border-radius:10px;
    font-weight:600;
}

/* TABLE */

.table-responsive{
    overflow-x:auto;
}

.products-table{
    width:100%;
    border-collapse:collapse;
}

.products-table thead{
    background:#111827;
}

.products-table th{
    color:#fff;
    padding:16px;
    font-size:15px;
    text-align:left;
}

.products-table td{
    padding:15px;
    border-bottom:1px solid #e5e7eb;
    vertical-align:middle;
}

/* PRODUCT IMAGE */

.product-image{
    width:75px;
    height:75px;
    object-fit:cover;
    border-radius:12px;
    border:2px solid #e5e7eb;
}

/* PRODUCT NAME */

.product-name{
    font-weight:600;
    color:#111827;
}

/* CATEGORY */

.category-badge{
    background:#eff6ff;
    color:#2563eb;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
    display:inline-block;
}

/* STATUS */

.status-active{
    background:#dcfce7;
    color:#15803d;
    padding:7px 15px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}

.status-inactive{
    background:#fee2e2;
    color:#dc2626;
    padding:7px 15px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}

/* ACTION BUTTONS */

.action-buttons{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

.action-btn{
    width:40px;
    height:40px;
    border:none;
    border-radius:10px;
    color:#fff;
    display:flex;
    justify-content:center;
    align-items:center;
    text-decoration:none;
    transition:0.3s;
}

.edit-btn{
    background:#2563eb;
}

.edit-btn:hover{
    background:#1d4ed8;
    color:#fff;
}

.status-btn{
    background:#f59e0b;
}

.status-btn:hover{
    background:#d97706;
    color:#fff;
}

.delete-btn{
    background:#dc2626;
}

.delete-btn:hover{
    background:#b91c1c;
    color:#fff;
}

/* EMPTY */

.empty-data{
    text-align:center;
    padding:50px;
    color:#6b7280;
    font-size:18px;
}

/* MOBILE */

@media(max-width:768px){

    .page-title{
        font-size:24px;
    }

    .admin-card{
        padding:20px;
    }

    .products-table th,
    .products-table td{
        padding:12px;
    }

}

</style>

<div class="admin-products-page">

<div class="container">

<div class="admin-card">

<!-- TOP -->

<div class="page-top">

<h1 class="page-title">

<i class="fa-solid fa-box-open"></i>

All Products

</h1>

<a
href="add-product.php"
class="add-btn"
>

<i class="fa-solid fa-plus"></i>

Add Product

</a>

</div>

<!-- SEARCH -->

<div class="search-box">

<form method="GET" class="search-form">

<input
type="text"
name="search"
class="search-input"
placeholder="Search product..."
value="<?php echo $search; ?>"
>

<button
type="submit"
class="search-btn"
>

<i class="fa-solid fa-magnifying-glass"></i>

Search

</button>

</form>

</div>

<!-- TABLE -->

<div class="table-responsive">

<table class="products-table">

<thead>

<tr>

<th>ID</th>
<th>Image</th>
<th>Product</th>
<th>Category</th>
<th>Status</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($query) > 0){

while($row = mysqli_fetch_assoc($query)){

?>

<tr>

<td>

#<?php echo $row['id']; ?>

</td>

<td>

<img
src="../../uploads/products/<?php echo $row['featured_image']; ?>"
class="product-image"
>

</td>

<td>

<div class="product-name">

<?php echo $row['product_name']; ?>

</div>

</td>

<td>

<span class="category-badge">

<?php echo $row['category_name']; ?>

</span>

</td>

<td>

<?php if($row['status'] == 'active'){ ?>

<span class="status-active">

Active

</span>

<?php } else { ?>

<span class="status-inactive">

Inactive

</span>

<?php } ?>

</td>

<td>

<div class="action-buttons">

<!-- EDIT -->

<a
href="edit-product.php?id=<?php echo $row['id']; ?>"
class="action-btn edit-btn"
title="Edit Product"
>

<i class="fa-solid fa-pen"></i>

</a>

<!-- STATUS -->

<a
href="toggle-status.php?id=<?php echo $row['id']; ?>"
class="action-btn status-btn"
title="Toggle Status"
>

<i class="fa-solid fa-power-off"></i>

</a>

<!-- DELETE -->

<a
href="delete-product.php?id=<?php echo $row['id']; ?>"
class="action-btn delete-btn"
title="Delete Product"
onclick="return confirm('Delete this product?')"
>

<i class="fa-solid fa-trash"></i>

</a>

</div>

</td>

</tr>

<?php

}

} else {

?>

<tr>

<td colspan="6">

<div class="empty-data">

<i class="fa-solid fa-box-open fa-2x mb-3"></i>

<br>

No Products Found

</div>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<?php include "../../footer.php"; ?>