<?php
/* ─────────────────────────────────────────────
   HOME – MEDICAL EQUIPMENTS SECTION
───────────────────────────────────────────── */
if(!defined('BASE_URL')) include_once __DIR__."/includes/config.php";

/* Use the global $conn (set by database/connection.php via header.php) */
if(empty($conn) || !$conn){
    $conn = mysqli_connect("localhost","root","","royalestablishment");
    if($conn) mysqli_set_charset($conn,"utf8");
}

$_pp_rows = [];

$_ppQ = mysqli_query($conn,
    "SELECT p.id, p.product_name, p.short_description,
            p.featured_image, pc.category_name
     FROM products p
     LEFT JOIN product_categories pc ON pc.id = p.category_id
     ORDER BY p.id DESC
     LIMIT 16");
if($_ppQ){
    while($row = mysqli_fetch_assoc($_ppQ)) $_pp_rows[] = $row;
    mysqli_free_result($_ppQ);
}
?>

<section class="me-section">

    <!-- Header -->
    <div class="me-header">
        <div>
            <h2 class="me-title">Medical Equipment's</h2>
            <p class="me-sub">Browse our best-in-class hospital furniture and biomedical equipment</p>
        </div>
        <a href="<?= BASE_URL ?>products.php" class="me-view-all">View all</a>
    </div>

    <?php if(count($_pp_rows) > 0): ?>

    <!-- Marquee wrapper -->
    <div class="me-marquee-wrap">
        <div class="me-marquee-track" id="meMarqueeTrack">

            <?php
            /* Render twice for seamless infinite loop */
            for($pass = 0; $pass < 2; $pass++):
                foreach($_pp_rows as $p):
                    $name  = htmlspecialchars($p['product_name'] ?? '');
                    $cat   = htmlspecialchars($p['category_name'] ?? '');
                    $id    = (int)$p['id'];
                    $img   = !empty($p['featured_image'])
                             ? BASE_URL.'uploads/products/'.htmlspecialchars($p['featured_image'])
                             : BASE_URL.'Images/no-image.png';
            ?>
            <a href="<?= BASE_URL ?>product/view_product.php?id=<?= $id ?>" class="me-card">
                <img src="<?= $img ?>" alt="<?= $name ?>"
                     loading="lazy"
                     onerror="this.src='<?= BASE_URL ?>Images/no-image.png'">
                <div class="me-card-overlay">
                    <span class="me-card-cat"><?= $cat ?></span>
                    <h3 class="me-card-name"><?= $name ?></h3>
                </div>
            </a>
            <?php
                endforeach;
            endfor;
            ?>

        </div>
    </div>

    <?php else: ?>
    <p style="text-align:center;color:#888;padding:40px;">No products available.</p>
    <?php endif; ?>

</section>

<style>
/* ── Section ── */
.me-section {
    background: #e8e8e8;
    padding: 52px 40px 0;
    overflow: hidden;
}

/* ── Header ── */
.me-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 24px;
    margin-bottom: 32px;
}

.me-title {
    font-size: 40px;
    font-weight: 700;
    color: #111;
    letter-spacing: -0.8px;
    line-height: 1.1;
    margin-bottom: 10px;
}

.me-sub {
    font-size: 14.5px;
    color: #666;
    line-height: 1.6;
}

.me-view-all {
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    height: 44px;
    padding: 0 26px;
    background: #111;
    color: #fff;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: background .2s, transform .2s;
    white-space: nowrap;
    margin-bottom: 2px;
}

.me-view-all:hover {
    background: #333;
    color: #fff;
    transform: translateY(-2px);
}

/* ── Marquee wrapper ── */
.me-marquee-wrap {
    overflow: hidden;
    /* bleed slightly past section padding on both sides for edge peek */
    margin-left:  -40px;
    margin-right: -40px;
    position: relative;
}

/* fade edges */
.me-marquee-wrap::before,
.me-marquee-wrap::after {
    content: '';
    position: absolute;
    top: 0; bottom: 0;
    width: 80px;
    z-index: 2;
    pointer-events: none;
}
.me-marquee-wrap::before {
    left: 0;
    background: linear-gradient(to right, #e8e8e8 10%, transparent);
}
.me-marquee-wrap::after {
    right: 0;
    background: linear-gradient(to left, #e8e8e8 10%, transparent);
}

/* ── Track ── */
.me-marquee-track {
    display: flex;
    gap: 16px;
    width: max-content;
    padding: 8px 40px;
    animation: meScroll 40s linear infinite;
    will-change: transform;
}

.me-marquee-track:hover {
    animation-play-state: paused;
}

@keyframes meScroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

/* ── Card ── */
.me-card {
    flex-shrink: 0;
    width: 260px;
    /* tall portrait — matches the reference image */
    aspect-ratio: 3 / 4;
    border-radius: 18px;
    overflow: hidden;
    text-decoration: none;
    color: #fff;
    display: block;
    position: relative;
    box-shadow: 0 4px 20px rgba(0,0,0,.15);
    transition: transform .3s ease, box-shadow .3s ease;
}

.me-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 16px 40px rgba(0,0,0,.25);
}

/* full-bleed image */
.me-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .5s ease;
    pointer-events: none;
}

.me-card:hover img {
    transform: scale(1.06);
}

/* bottom gradient overlay */
.me-card-overlay {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 40px 14px 14px;
    background: linear-gradient(to top,
        rgba(0,0,0,.80) 0%,
        rgba(0,0,0,.40) 60%,
        transparent 100%);
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.me-card-cat {
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .8px;
    color: rgba(255,255,255,.75);
    line-height: 1;
}

.me-card-name {
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin: 0;
}

.me-card-price {
    font-size: 11.5px;
    color: rgba(255,255,255,.80);
    margin: 2px 0 0;
}

.me-card-price span {
    font-weight: 700;
    color: #fff;
}

/* ── Responsive ── */
@media (max-width: 768px) {
    .me-section { padding: 36px 20px 44px; }
    .me-marquee-wrap { margin-left: -20px; margin-right: -20px; }
    .me-marquee-track { padding: 8px 20px; gap: 12px; }
    .me-title  { font-size: 26px; }
    .me-sub    { font-size: 13px; }
    .me-card   { width: 200px; }
    .me-header { flex-direction: column; align-items: flex-start; gap: 14px; }
    .me-view-all { align-self: flex-start; }
}

@media (max-width: 480px) {
    .me-card { width: 180px; }
}
</style>
