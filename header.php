<?php include "includes/config.php"; ?>
<?php include "database/connection.php"; ?>

<?php

/* ==============================================
HOSPITAL FURNITURE — 9 SUBCATEGORIES
DB se products fetch karenge flyout ke liye
============================================== */

$hospitalFurniture = [
'Hospital Beds',
'Tables',
'Chairs',
'Trolleys',
'Cabinets & Storage',
'Stools',
'Screens & Partitions',
'Stands & Supports',
'Accessories'
];

/* Har subcategory ke liye products fetch karo */
$hospitalProducts = [];

foreach($hospitalFurniture as $subcat){

    /* Category ID dhundo category_name se */
    $safe = mysqli_real_escape_string($conn, $subcat);

    $catQ = mysqli_query($conn,
        "SELECT id FROM product_categories
         WHERE LOWER(TRIM(category_name)) = LOWER(TRIM('$safe'))
         AND status='active'
         LIMIT 1"
    );

    if($catQ && mysqli_num_rows($catQ) > 0){

        $catRow  = mysqli_fetch_assoc($catQ);
        $cat_id  = $catRow['id'];

        /* Us category ke products */
        $prodQ = mysqli_query($conn,
            "SELECT id, product_name, featured_image
             FROM products
             WHERE category_id='$cat_id'
             AND status='active'
             ORDER BY id DESC"
        );

        $products = [];
        if($prodQ){
            while($p = mysqli_fetch_assoc($prodQ)){
                $products[] = $p;
            }
        }

        $hospitalProducts[$subcat] = [
            'category_id' => $cat_id,
            'products'    => $products
        ];

    } else {

        $hospitalProducts[$subcat] = [
            'category_id' => 0,
            'products'    => []
        ];

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Royal Establishment</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{ background:#e8e8e8; }

/* =========================
ADMIN PAGE
========================= */

.admin-page-wrapper{
    background:#f5f5f5;
    padding:50px 0;
    min-height:100vh;
}

.admin-card{
    background:#fff;
    padding:30px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

@media(max-width:768px){
    .admin-card{ padding:20px; }
}

/* =========================
HEADER
========================= */

header{
    width:100%;
    background:#e8e8e8;
    padding:0 40px;
    position:sticky;
    top:0;
    z-index:1000;
    transition: padding .3s ease, box-shadow .3s ease;
}

header.scrolled{
    box-shadow:0 4px 24px rgba(0,0,0,.10);
    background:#e2e2e2;
}

.navbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:24px;
    width:100%;
    height:80px;
    transition: height .3s ease;
}

header.scrolled .navbar{
    height:72px;
}

.logo{ flex-shrink:0; }
.logo img{
    height:80px;
    display:block;
    transition: height .3s ease;
}

header.scrolled .logo img{ height:64px; }

/* =========================
NAV LINKS  (centre)
========================= */

.nav-links{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:2px;
    list-style:none;
    margin:0;
    padding:0;
    flex:1;
}

.nav-links > li > a{
    text-decoration:none;
    font-size:14px;
    font-weight:500;
    color:#333;
    padding:7px 16px;
    border-radius:50px;
    transition:.2s;
    white-space:nowrap;
    display:flex;
    align-items:center;
    gap:6px;
}

.nav-links > li > a:hover,
.nav-links > li > a.active-link{
    color:#111;
    background:rgba(0,0,0,.08);
}

/* =========================
RIGHT BUTTONS
========================= */

.right-buttons{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:8px;
    flex-shrink:0;
}

/* =========================
LANGUAGE SWITCHER
========================= */

.language-switcher{ position:relative; }

.lang-btn{
    display:flex;
    align-items:center;
    gap:7px;
    height:38px;
    padding:0 16px;
    background:#222;
    border:none;
    border-radius:50px;
    cursor:pointer;
    font-size:13px;
    font-weight:600;
    color:#fff;
    transition:.2s;
    white-space:nowrap;
}

.lang-btn:hover{ background:#333; }

.lang-btn img{ width:20px; height:14px; object-fit:cover; border-radius:2px; }
.lang-btn .chevron{ font-size:10px; transition:transform .25s; opacity:.7; }
.language-switcher.active .lang-btn .chevron{ transform:rotate(180deg); }

.lang-dropdown{
    position:absolute;
    top:calc(100% + 8px);
    right:0;
    width:170px;
    background:#fff;
    border-radius:14px;
    box-shadow:0 10px 30px rgba(0,0,0,.14);
    border:1px solid #eee;
    padding:6px;
    opacity:0;
    visibility:hidden;
    transform:translateY(8px);
    transition:.25s;
    z-index:9999;
}

.language-switcher.active .lang-dropdown{
    opacity:1;
    visibility:visible;
    transform:translateY(0);
}

.lang-dropdown a{
    display:flex;
    align-items:center;
    gap:10px;
    padding:9px 12px;
    text-decoration:none;
    color:#333;
    font-size:13px;
    font-weight:500;
    border-radius:8px;
    transition:.2s;
}

.lang-dropdown a:hover{ background:#f5f5f5; color:#111; }
.lang-dropdown img{ width:20px; height:14px; object-fit:cover; border-radius:2px; }

/* =========================
CATALOG BUTTON
========================= */

.catalog-btn{
    display:flex;
    align-items:center;
    gap:7px;
    height:38px;
    padding:0 18px;
    background:#222;
    border-radius:50px;
    text-decoration:none;
    transition:.2s;
    flex-shrink:0;
    font-size:13px;
    font-weight:600;
    color:#fff;
}

.catalog-btn i{ font-size:14px; opacity:.85; }
.catalog-btn:hover{ background:#333; color:#fff; }

/* =========================
CALL BUTTON
========================= */

.call-box{
    display:flex;
    align-items:center;
    gap:7px;
    height:38px;
    padding:0 18px;
    background:#57B847;
    border-radius:50px;
    color:#fff;
    white-space:nowrap;
    flex-shrink:0;
    text-decoration:none;
    font-size:13px;
    font-weight:700;
    transition:.2s;
}

.call-box:hover{ background:#45a337; color:#fff; }
.call-box i{ font-size:14px; }

/* =========================
MOBILE MENU BUTTON
========================= */

.menu-btn{
    display:none;
    width:38px;
    height:38px;
    align-items:center;
    justify-content:center;
    border-radius:50px;
    border:none;
    cursor:pointer;
    flex-shrink:0;
    transition:.2s;
    background:#222;
}

.menu-btn:hover{ background:#333; }

.menu-btn .bar{
    display:block;
    width:18px;
    height:2px;
    background:#fff;
    border-radius:2px;
    transition:.3s;
    position:relative;
}

.menu-btn .bar::before,
.menu-btn .bar::after{
    content:'';
    position:absolute;
    width:18px;
    height:2px;
    background:#fff;
    border-radius:2px;
    transition:.3s;
    left:0;
}

.menu-btn .bar::before{ top:-6px; }
.menu-btn .bar::after{ top:6px; }

/* X state */
.menu-btn.open .bar{ background:transparent; }
.menu-btn.open .bar::before{ transform:rotate(45deg); top:0; }
.menu-btn.open .bar::after{ transform:rotate(-45deg); top:0; }

/* =========================
MOBILE OVERLAY
========================= */

.mobile-overlay{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.4);
    z-index:998;
    opacity:0;
    transition:opacity .3s;
}

.mobile-overlay.active{
    display:block;
    opacity:1;
}

/* =========================
DESKTOP: 1200px tweaks
========================= */

@media(max-width:1200px){
    header{ padding:0 24px; }
    .nav-links{ gap:0; }
    .nav-links > li > a{ font-size:13px; padding:7px 12px; }
    .right-buttons{ gap:6px; }
}

/* =========================
MOBILE NAV
========================= */

@media(max-width:992px){

    header{ padding:0 20px; }
    .navbar{ justify-content:space-between; }
    .menu-btn{ display:flex; }

    .nav-links{
        position:fixed;
        top:0;
        left:-100%;
        width:82%;
        max-width:340px;
        height:100vh;
        background:#fff;
        flex-direction:column;
        align-items:stretch;
        padding:80px 20px 30px;
        box-shadow:4px 0 30px rgba(0,0,0,.12);
        z-index:999;
        overflow-y:auto;
        transition:left .35s cubic-bezier(.4,0,.2,1);
        gap:0;
    }

    .nav-links.active{ left:0; }

    .nav-links > li > a{
        padding:13px 16px;
        border-radius:12px;
        font-size:15px;
        justify-content:space-between;
        color:#222;
    }

    .right-buttons{
        position:fixed;
        bottom:0;
        left:-100%;
        width:82%;
        max-width:340px;
        background:#fff;
        padding:16px 20px;
        flex-direction:column;
        align-items:stretch;
        gap:10px;
        z-index:999;
        border-top:1px solid #f0f0f0;
        transition:left .35s cubic-bezier(.4,0,.2,1);
    }

    .right-buttons.active{ left:0; }

    .call-box, .catalog-btn, .lang-btn{
        justify-content:center;
        height:46px;
        font-size:15px;
        border-radius:14px;
    }
}

/* =========================
MEGA MENU
========================= */

/* The mega-menu-parent sits inside .right-buttons which is on the right,
   so we anchor the mega panel to the right edge of the trigger */
.mega-menu-parent{ position:static; }

/* header acts as the positioning parent */
header{ position:sticky; }

.mega-menu{
    position:fixed;
    left:50%;
    top:72px; /* matches navbar height */
    transform:translateX(-50%);
    width:94vw;
    max-width:1400px;
    background:#fff;
    padding:36px 40px;
    border-top:3px solid #57B847;
    border-radius:0 0 20px 20px;
    box-shadow:0 20px 50px rgba(0,0,0,.10);
    display:grid;
    grid-template-columns:repeat(7,1fr);
    gap:28px;
    opacity:0;
    visibility:hidden;
    transition:opacity .25s ease, visibility .25s ease, transform .25s ease;
    transform:translateX(-50%) translateY(6px);
    z-index:99999;
}

header.scrolled .mega-menu{ top:60px; }

.mega-menu-parent:hover .mega-menu{
    opacity:1;
    visibility:visible;
    transform:translateX(-50%) translateY(0);
}

.mega-column h3{
    font-size:13px;
    font-weight:700;
    color:#57B847;
    margin-bottom:14px;
    padding-bottom:10px;
    border-bottom:2px solid #e8f5e9;
    line-height:1.4;
    text-transform:uppercase;
    letter-spacing:.5px;
    display:flex;
    align-items:center;
    gap:7px;
}

.mega-column h3 i{
    font-size:14px;
    opacity:.8;
}

.mega-column ul{ list-style:none; padding:0; margin:0; }
.mega-column ul li{ margin-bottom:2px; }

.mega-column ul li a{
    display:flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    font-size:13.5px;
    color:#444;
    padding:7px 10px;
    border-radius:7px;
    line-height:1.5;
    transition:.2s;
}

.mega-column ul li a::before{
    content:'';
    width:5px;
    height:5px;
    border-radius:50%;
    background:#cbd5e0;
    flex-shrink:0;
    transition:.2s;
}

.mega-column ul li a:hover{
    color:#57B847;
    background:#f0faf0;
}

.mega-column ul li a:hover::before{
    background:#57B847;
}

/* =========================
HOSPITAL FURNITURE COLUMN
========================= */

.hospital-flyout-column{
    grid-column: span 1;
    position: relative;
}

.hospital-flyout-column h3{
    font-size:13px;
    font-weight:700;
    color:#57B847;
    margin-bottom:14px;
    padding-bottom:10px;
    border-bottom:2px solid #e8f5e9;
    text-transform:uppercase;
    letter-spacing:.5px;
    display:flex;
    align-items:center;
    gap:7px;
}

.hospital-main-list{
    list-style:none;
    padding:0;
    margin:0;
    max-height:220px;
    overflow-y:auto;
}

.hospital-main-list::-webkit-scrollbar{ width:3px; }
.hospital-main-list::-webkit-scrollbar-thumb{
    background:#c8e6c9;
    border-radius:10px;
}

.hospital-main-list li a{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:8px 10px;
    font-size:13.5px;
    color:#444;
    text-decoration:none;
    transition:.2s;
    cursor:pointer;
    border-radius:7px;
}

.hospital-main-list li a:hover{ color:#57B847; background:#f0faf0; }
.hospital-main-list li a i{ font-size:10px; color:#bbb; flex-shrink:0; }
.hospital-main-list li a:hover i{ color:#57B847; }

/* =========================
FLYOUT PANEL
========================= */

.hospital-sub-panel{
    position:absolute;
    top:0;
    left:calc(100% + 12px);
    width:320px;
    background:#fff;
    border:1px solid #e8f5e9;
    border-radius:12px;
    padding:16px 18px;
    box-shadow:0 8px 30px rgba(0,0,0,.10);
    z-index:999999;
    opacity:0;
    visibility:hidden;
    pointer-events:none;
    transition:opacity .2s ease, visibility .2s ease;
}

.hospital-flyout-column:hover .hospital-sub-panel{
    opacity:1;
    visibility:visible;
    pointer-events:auto;
}

.hospital-sub-panel .sub-heading{
    font-size:12px;
    font-weight:700;
    color:#57B847;
    margin-bottom:10px;
    padding-bottom:7px;
    border-bottom:1px solid #e8f5e9;
    text-transform:uppercase;
    letter-spacing:.5px;
}

.hospital-sub-group{ display:none; }
.hospital-sub-group.hf-show{ display:block; }

.hf-product-list{
    list-style:none;
    padding:0;
    margin:0;
    max-height:240px;
    overflow-y:auto;
}

.hf-product-list::-webkit-scrollbar{ width:3px; }
.hf-product-list::-webkit-scrollbar-thumb{
    background:#c8e6c9;
    border-radius:10px;
}

.hf-product-list li a{
    display:flex;
    align-items:center;
    gap:10px;
    padding:7px 8px;
    font-size:13px;
    color:#444;
    text-decoration:none;
    border-radius:7px;
    transition:.2s;
}

.hf-product-list li a:hover{
    color:#57B847;
    background:#f0faf0;
}

.hf-thumb{
    width:36px;
    height:36px;
    object-fit:cover;
    border-radius:6px;
    flex-shrink:0;
    border:1px solid #eee;
    background:#f5f5f5;
}

.hf-no-product{
    text-align:center;
    padding:20px 10px;
    color:#aaa;
    font-size:13px;
}

.hf-no-product i{
    display:block;
    font-size:26px;
    margin-bottom:8px;
    color:#ddd;
}

.hf-view-all{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    margin-top:10px;
    padding:8px;
    background:#f0faf0;
    color:#57B847;
    font-size:13px;
    font-weight:600;
    text-decoration:none;
    border-radius:8px;
    transition:.2s;
}

.hf-view-all:hover{
    background:#57B847;
    color:#fff;
}

/* =========================
LARGE SCREEN
========================= */

@media(max-width:1450px){
    .mega-menu{
        grid-template-columns:repeat(4,1fr);
        width:95%;
        gap:24px;
    }
}

@media(max-width:1200px){
    .mega-menu{
        grid-template-columns:repeat(3,1fr);
    }
}

/* =========================
TABLET / MOBILE MEGA MENU
========================= */

@media(max-width:992px){

    #productsNav{
        width:100%;
        flex-direction:column;
    }

    #productsNav > li > a{
        padding:13px 16px;
        border-radius:12px;
        font-size:15px;
        justify-content:space-between;
        color:#222;
        background:#f5f5f5;
    }

    .mega-menu-parent{ position:relative; }

    .mega-menu{
        position:relative;
        top:0; left:0;
        transform:none;
        width:100%;
        display:none;
        grid-template-columns:1fr;
        padding:16px;
        margin-top:4px;
        border-radius:12px;
        box-shadow:0 5px 15px rgba(0,0,0,.07);
        opacity:1;
        visibility:visible;
        gap:4px;
        border-top:2px solid #57B847;
    }

    .mega-menu-parent.active .mega-menu{ display:grid; }
    .mega-menu-parent:hover .mega-menu{ opacity:1; visibility:visible; }

    .hospital-flyout-column{ grid-column:span 1; }

    .hospital-sub-panel{
        position:static;
        width:100%;
        margin-top:8px;
        box-shadow:none;
        border:1px solid #e8f5e9;
        opacity:1;
        visibility:visible;
        pointer-events:auto;
    }

    .hf-product-list{ max-height:none; }
}

@media(max-width:768px){
    .mega-menu{ grid-template-columns:1fr; padding:12px; }
}

.mega-menu-parent > a{
    display:flex;
    align-items:center;
    gap:6px;
    white-space:nowrap;
    line-height:1;
}

</style>

</head>

<body>

<!-- MOBILE OVERLAY -->
<div class="mobile-overlay" id="mobileOverlay"></div>

<header id="siteHeader">

<div class="navbar">

<!-- LOGO -->
<div class="logo">
    <a href="<?= BASE_URL ?>index.php">
        <img src="<?= BASE_URL ?>Images/logofinal.jpeg" alt="Royal Establishment">
    </a>
</div>

<!-- CENTRE LINKS -->
<ul class="nav-links" id="navLinks">
    <li><a href="<?= BASE_URL ?>index.php" class="<?= (basename($_SERVER['PHP_SELF'])=='index.php')?'active-link':'' ?>">Home</a></li>
    <li><a href="<?= BASE_URL ?>about.php" class="<?= (basename($_SERVER['PHP_SELF'])=='about.php')?'active-link':'' ?>">About</a></li>
    <li><a href="<?= BASE_URL ?>certificate.php" class="<?= (basename($_SERVER['PHP_SELF'])=='certificate.php')?'active-link':'' ?>">Certificates</a></li>
    <li><a href="<?= BASE_URL ?>infrastructure.php" class="<?= (basename($_SERVER['PHP_SELF'])=='infrastructure.php')?'active-link':'' ?>">Infrastructure</a></li>
    <li><a href="<?= BASE_URL ?>contact.php" class="<?= (basename($_SERVER['PHP_SELF'])=='contact.php')?'active-link':'' ?>">Contact</a></li>
</ul>

<!-- RIGHT BUTTONS -->
<div class="right-buttons" id="rightButtons">

    <!-- PRODUCTS DROPDOWN -->
    <ul class="nav-links" style="flex:0;gap:0;" id="productsNav">
        <li class="mega-menu-parent">
            <a href="javascript:void(0)">
                Products
                <i class="fa-solid fa-chevron-down" style="font-size:10px;opacity:.7;"></i>
            </a>
            <div class="mega-menu">

                <!-- COLUMN 1 — HOSPITAL FURNITURE -->
                <div class="mega-column hospital-flyout-column">
                    <h3><i class="fa-solid fa-bed-pulse"></i> Hospital Furniture</h3>
                    <ul class="hospital-main-list">
                        <?php foreach($hospitalFurniture as $subcat){
                            $uid = md5($subcat);
                            $data = $hospitalProducts[$subcat];
                            $count = count($data['products']);
                        ?>
                        <li>
                            <a href="javascript:void(0)" id="hftab-<?= $uid ?>" onmouseenter="showHospitalSub('<?= $uid ?>')">
                                <?= $subcat ?>
                                <?php if($count > 0){ ?>
                                <span style="background:#e8f5e9;color:#57B847;font-size:11px;padding:2px 7px;border-radius:20px;font-weight:600;margin-left:auto;"><?= $count ?></span>
                                <?php } else { ?>
                                <i class="fa-solid fa-angle-right"></i>
                                <?php } ?>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>

                    <div class="hospital-sub-panel">
                        <?php $firstPanel = true;
                        foreach($hospitalFurniture as $subcat){
                            $uid  = md5($subcat);
                            $data = $hospitalProducts[$subcat];
                            $cat_id   = $data['category_id'];
                            $products = $data['products'];
                        ?>
                        <div class="hospital-sub-group <?= $firstPanel ? 'hf-show' : '' ?>" id="hfpanel-<?= $uid ?>">
                            <div class="sub-heading"><?= $subcat ?></div>
                            <?php if(count($products) > 0){ ?>
                            <ul class="hf-product-list">
                                <?php foreach($products as $prod){ ?>
                                <li>
                                    <a href="<?= BASE_URL ?>product/view_product.php?id=<?= $prod['id'] ?>">
                                        <img src="<?= BASE_URL ?>uploads/products/<?= $prod['featured_image'] ?>"
                                             alt="<?= htmlspecialchars($prod['product_name']) ?>"
                                             class="hf-thumb"
                                             onerror="this.src='<?= BASE_URL ?>Images/no-image.png'">
                                        <?= htmlspecialchars($prod['product_name']) ?>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php if($cat_id > 0){ ?>
                            <a href="<?= BASE_URL ?>products.php?category_id=<?= $cat_id ?>" class="hf-view-all">
                                View All <?= $subcat ?> <i class="fa-solid fa-arrow-right"></i>
                            </a>
                            <?php } ?>
                            <?php } else { ?>
                            <div class="hf-no-product">
                                <i class="fa-solid fa-box-open"></i>
                                No products found
                            </div>
                            <?php if($cat_id > 0){ ?>
                            <a href="<?= BASE_URL ?>products.php?category_id=<?= $cat_id ?>" class="hf-view-all">
                                View <?= $subcat ?> <i class="fa-solid fa-arrow-right"></i>
                            </a>
                            <?php } ?>
                            <?php } ?>
                        </div>
                        <?php $firstPanel = false; } ?>
                    </div>
                </div>

                <!-- COLUMN 2 — AUTOCLAVE -->
                <div class="mega-column">
                    <h3><i class="fa-solid fa-fire-flame-curved"></i> Autoclave</h3>
                    <ul>
                        <li><a href="<?= BASE_URL ?>Autoclaves.php">Autoclaves</a></li>
                    </ul>
                </div>

                <!-- COLUMN 3 — MODULAR OT -->
                <div class="mega-column">
                    <h3><i class="fa-solid fa-scalpel"></i> Modular OT</h3>
                    <ul>
                        <li><a href="<?= BASE_URL ?>Basic_OT.php">Basic OT</a></li>
                        <li><a href="<?= BASE_URL ?>Moduler_OT.php">Modular OT</a></li>
                    </ul>
                </div>

                <!-- COLUMN 4 — GAS PIPELINE -->
                <div class="mega-column">
                    <h3><i class="fa-solid fa-pipe-section"></i> Gas Pipeline</h3>
                    <ul>
                        <li><a href="<?= BASE_URL ?>Gas_Pipeline_Solution.php">Gas Pipeline Solution</a></li>
                        <li><a href="<?= BASE_URL ?>Oxygen_Plant_Maintenance.php">Oxygen Plant Maintenance</a></li>
                    </ul>
                </div>

                <!-- COLUMN 5 — COLDROOM -->
                <div class="mega-column">
                    <h3><i class="fa-solid fa-snowflake"></i> Coldroom</h3>
                    <ul>
                        <li><a href="<?= BASE_URL ?>BBR_Maintenance.php">BBR Maintenance</a></li>
                        <li><a href="<?= BASE_URL ?>Vaclue.php">Vaclue</a></li>
                        <li><a href="<?= BASE_URL ?>ILR.php">ILR</a></li>
                    </ul>
                </div>

                <!-- COLUMN 6 — B.M.E.M. -->
                <div class="mega-column">
                    <h3><i class="fa-solid fa-stethoscope"></i> B.M.E.M.</h3>
                    <ul>
                        <li><a href="<?= BASE_URL ?>Critical_Equipments_Repair.php">Critical Equipment Repair</a></li>
                        <li><a href="<?= BASE_URL ?>Non-Critical_Equipments_Repair.php">Non-Critical Equipment Repair</a></li>
                    </ul>
                </div>

                <!-- COLUMN 7 — CALIBRATION & QA -->
                <div class="mega-column">
                    <h3><i class="fa-solid fa-circle-check"></i> Calibration &amp; QA</h3>
                    <ul>
                        <li><a href="<?= BASE_URL ?>Bio-medical_Equipment_Calibration.php">Bio-medical Calibration</a></li>
                        <li><a href="<?= BASE_URL ?>Radiology_Equipment_QA.php">Radiology Equipment QA</a></li>
                    </ul>
                </div>

            </div><!-- end .mega-menu -->
        </li>
    </ul>

    <!-- CATALOG -->
    <a href="<?= BASE_URL ?>ROYAL ESTABLISHMENT pdf.pdf" download class="catalog-btn">
        <i class="fa-solid fa-file-arrow-down"></i>
        Catalog
    </a>

    <!-- LANGUAGE SWITCHER -->
    <div class="language-switcher" id="languageSwitcher">
        <button class="lang-btn" id="selectedLang">
            <img src="https://flagcdn.com/w40/gb.png" id="selectedFlag" alt="EN">
            <span id="selectedText">EN</span>
            <i class="fa-solid fa-chevron-down chevron"></i>
        </button>
        <div class="lang-dropdown">
            <a href="#" onclick="changeLanguage('en')"><img src="https://flagcdn.com/w40/gb.png" alt=""> English</a>
            <a href="#" onclick="changeLanguage('ar')"><img src="https://flagcdn.com/w40/sa.png" alt=""> Arabic</a>
            <a href="#" onclick="changeLanguage('fr')"><img src="https://flagcdn.com/w40/fr.png" alt=""> French</a>
            <a href="#" onclick="changeLanguage('so')"><img src="https://flagcdn.com/w40/so.png" alt=""> Somali</a>
        </div>
    </div>

</div>

<!-- MOBILE MENU BUTTON -->
<div class="menu-btn" id="menuBtn" aria-label="Toggle menu">
    <span class="bar"></span>
</div>

</div>

</header>

<!-- GOOGLE TRANSLATE -->
<div id="google_translate_element" style="display:none;"></div>

<script>
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage:'en',
        includedLanguages:'en,ar,fr,so',
        autoDisplay:false
    }, 'google_translate_element');
}
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>

/* =========================
STICKY SCROLL SHRINK
========================= */

window.addEventListener('scroll', function(){
    var header = document.getElementById('siteHeader');
    if(window.scrollY > 40){
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

/* =========================
HOSPITAL FURNITURE FLYOUT
========================= */

function showHospitalSub(uid) {
    document.querySelectorAll('.hospital-sub-group').forEach(function(el){
        el.classList.remove('hf-show');
    });
    var panel = document.getElementById('hfpanel-' + uid);
    if(panel) panel.classList.add('hf-show');
}

/* =========================
LANGUAGE DROPDOWN
========================= */

var switcher = document.getElementById("languageSwitcher");

document.getElementById("selectedLang").addEventListener("click", function(e){
    e.stopPropagation();
    switcher.classList.toggle("active");
});

function changeLanguage(lang) {
    event.preventDefault();
    var combo = document.querySelector('.goog-te-combo');
    if(combo){
        combo.value = lang;
        combo.dispatchEvent(new Event('change'));
    }
    var selectedText = document.getElementById("selectedText");
    var selectedFlag = document.getElementById("selectedFlag");
    var labels = { en:['EN','gb'], ar:['AR','sa'], fr:['FR','fr'], so:['SO','so'] };
    if(labels[lang]){
        selectedText.innerHTML = labels[lang][0];
        selectedFlag.src = "https://flagcdn.com/w40/" + labels[lang][1] + ".png";
    }
    switcher.classList.remove("active");
}

window.addEventListener("click", function(e){
    if(!switcher.contains(e.target)){
        switcher.classList.remove("active");
    }
});

/* =========================
MOBILE DRAWER
========================= */

var menuBtn      = document.getElementById("menuBtn");
var navLinks     = document.getElementById("navLinks");
var rightButtons = document.getElementById("rightButtons");
var overlay      = document.getElementById("mobileOverlay");

function openDrawer(){
    navLinks.classList.add("active");
    rightButtons.classList.add("active");
    overlay.classList.add("active");
    menuBtn.classList.add("open");
    document.body.style.overflow = "hidden";
}

function closeDrawer(){
    navLinks.classList.remove("active");
    rightButtons.classList.remove("active");
    overlay.classList.remove("active");
    menuBtn.classList.remove("open");
    document.body.style.overflow = "";
}

menuBtn.addEventListener("click", function(e){
    e.stopPropagation();
    navLinks.classList.contains("active") ? closeDrawer() : openDrawer();
});

overlay.addEventListener("click", closeDrawer);

/* Close drawer on resize to desktop */
window.addEventListener("resize", function(){
    if(window.innerWidth > 992){ closeDrawer(); }
});

/* =========================
PRODUCTS DROPDOWN — MOBILE
========================= */

var productsBtn = document.querySelector(".mega-menu-parent > a");
var megaParent  = document.querySelector(".mega-menu-parent");

if(productsBtn && megaParent){
    productsBtn.addEventListener("click", function(e){
        if(window.innerWidth <= 992){
            e.preventDefault();
            e.stopPropagation();
            megaParent.classList.toggle("active");
        }
    });
}
</script>