<?php

include "database/connection.php";

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

<?php include "header.php"; ?>

<style>

body{
    background:#f4f7fb;
}

/* PAGE */

.admin-products-page{
    padding:50px 0;
    min-height:100vh;
}

/* CARD WRAPPER */

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

/* =========================
PRODUCT CARDS GRID
========================= */

.product-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
    gap:22px;
}

.product-card{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:16px;
    overflow:hidden;
    transition:.3s;
    display:flex;
    flex-direction:column;
}

.product-card:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 25px rgba(0,0,0,0.10);
}

/* IMAGE WRAP */

.pc-image-wrap{
    position:relative;
    width:100%;
    height:170px;
    background:#f3f4f6;
}

.pc-image-wrap img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

/* ID BADGE */

.pc-id-badge{
    position:absolute;
    top:10px;
    left:10px;
    background:rgba(17,24,39,0.75);
    color:#fff;
    font-size:12px;
    font-weight:600;
    padding:4px 10px;
    border-radius:20px;
}

/* STATUS BADGE on image */

.pc-status{
    position:absolute;
    top:10px;
    right:10px;
    font-size:12px;
    font-weight:600;
    padding:5px 12px;
    border-radius:20px;
}

.status-active{
    background:#dcfce7;
    color:#15803d;
}

.status-inactive{
    background:#fee2e2;
    color:#dc2626;
}

/* CARD BODY */

.pc-body{
    padding:16px;
    display:flex;
    flex-direction:column;
    gap:8px;
    flex:1;
}

.pc-name{
    font-weight:700;
    font-size:16px;
    color:#111827;
    line-height:1.4;
    min-height:44px;
}

/* CATEGORY */

.category-badge{
    background:#eff6ff;
    color:#2563eb;
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    display:inline-block;
    width:fit-content;
}

/* ACTION BUTTONS */

.action-buttons{
    display:flex;
    gap:8px;
    margin-top:auto;
    padding-top:10px;
}

.action-btn{
    flex:1;
    height:40px;
    border:none;
    border-radius:10px;
    color:#fff;
    display:flex;
    justify-content:center;
    align-items:center;
    text-decoration:none;
    transition:0.3s;
    font-size:14px;
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
    grid-column:1/-1;
}

/* MOBILE */

@media(max-width:768px){

    .page-title{
        font-size:24px;
    }

    .admin-card{
        padding:20px;
    }

    .product-grid{
        grid-template-columns:repeat(auto-fill,minmax(160px,1fr));
        gap:14px;
    }

    .pc-image-wrap{
        height:130px;
    }

    .pc-name{
        font-size:14px;
        min-height:auto;
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

<!-- <a
href="add-product.php"
class="add-btn"
>

<i class="fa-solid fa-plus"></i>

Add Product

</a> -->

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

<!-- PRODUCT GRID -->

<div class="product-grid">

<?php

if(mysqli_num_rows($query) > 0){

while($row = mysqli_fetch_assoc($query)){

?>

<div class="product-card">

    <!-- IMAGE -->
    <div class="pc-image-wrap">

        <img
        src="uploads/products/<?php echo $row['featured_image']; ?>"
        alt="<?php echo htmlspecialchars($row['product_name']); ?>"
        >

        <?php if($row['status'] == 'active'){ ?>

        <span class="pc-status status-active">
            Active
        </span>

        <?php } else { ?>

        <span class="pc-status status-inactive">
            Inactive
        </span>

        <?php } ?>

    </div>

    <!-- BODY -->
    <div class="pc-body">

        <div class="pc-name">
            <?php echo $row['product_name']; ?>
        </div>

        <span class="category-badge">
            <?php echo $row['category_name']; ?>
        </span>

    </div>

</div>

<?php

}

} else {

?>

<div class="empty-data">

    <i class="fa-solid fa-box-open fa-2x mb-3"></i>
    <br>
    No Products Found

</div>

<?php } ?>

</div><!-- end .product-grid -->

</div>

</div>

</div>

<?php include "footer.php"; ?>