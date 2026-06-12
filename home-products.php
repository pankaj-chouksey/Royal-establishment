<?php
/* ─────────────────────────────────────────────
   HOME – MEDICAL EQUIPMENTS SECTION
───────────────────────────────────────────── */
$_pp = mysqli_connect("localhost","root","","royalestablishment");
if($_pp) mysqli_set_charset($_pp,"utf8");
if(!defined('BASE_URL')) include_once __DIR__."/includes/config.php";

$_pp_rows = [];
if($_pp){
    $r = mysqli_query($_pp,
        "SELECT p.id, p.product_name, p.short_description,
                p.featured_image, pc.category_name
         FROM   products p
         LEFT JOIN product_categories pc ON pc.id = p.category_id
         WHERE  p.status = 'active'
         ORDER  BY p.id DESC
         LIMIT  12");
    if($r) while($row = mysqli_fetch_assoc($r)) $_pp_rows[] = $row;
    mysqli_close($_pp);
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

    <!-- Scroll track -->
    <div class="me-viewport" id="meViewport">
        <div class="me-track" id="meTrack">
            <?php foreach($_pp_rows as $p):
                $name = htmlspecialchars($p['product_name'] ?? '');
                $cat  = htmlspecialchars($p['category_name'] ?? '');
                $desc = htmlspecialchars(mb_substr($p['short_description'] ?? '', 0, 90));
                $id   = (int)$p['id'];
                $img  = !empty($p['featured_image'])
                        ? BASE_URL.'uploads/products/'.htmlspecialchars($p['featured_image'])
                        : BASE_URL.'Images/no-image.png';
            ?>
            <a href="<?= BASE_URL ?>product/view_product.php?id=<?= $id ?>" class="me-card">
                <div class="me-img">
                    <img src="<?= $img ?>" alt="<?= $name ?>" loading="lazy"
                         onerror="this.src='<?= BASE_URL ?>Images/no-image.png'">
                    <?php if($cat): ?>
                    <span class="me-tag"><?= $cat ?></span>
                    <?php endif; ?>
                </div>
                <div class="me-body">
                    <h3 class="me-name"><?= $name ?></h3>
                    <p  class="me-desc"><?= $desc ?>...</p>
                    <span class="me-link">View Details <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php else: ?>
    <p style="text-align:center;color:#888;padding:40px;">No products available.</p>
    <?php endif; ?>

</section>

<style>
/* ─── Section ─────────────────────────────── */
.me-section {
    background: #e8e8e8;
    padding: 56px 40px 64px;
    overflow: hidden;
}

/* ─── Header ─────────────────────────────── */
.me-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 24px;
    margin-bottom: 36px;
}

.me-title {
    font-size: 42px;
    font-weight: 700;
    color: #111;
    letter-spacing: -1px;
    line-height: 1.1;
    margin-bottom: 10px;
}

.me-sub {
    font-size: 15px;
    color: #666;
    line-height: 1.6;
    max-width: 400px;
}

.me-view-all {
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    height: 44px;
    padding: 0 26px;
    background: #57B847;
    color: #fff;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    transition: background .2s, transform .2s;
    margin-bottom: 2px;
}

.me-view-all:hover {
    background: #45a337;
    color: #fff;
    transform: translateY(-2px);
}

/* ─── Viewport clips overflow & shows peek ── */
.me-viewport {
    overflow: hidden;
    /* extend right to bleed past section padding — shows card peek */
    margin-right: -40px;
    cursor: grab;
    -webkit-user-select: none;
    user-select: none;
}

.me-viewport:active { cursor: grabbing; }

/* ─── Track ──────────────────────────────── */
.me-track {
    display: flex;
    gap: 20px;
    flex-wrap: nowrap;
    width: max-content;
    /* extra right pad so last card has breathing room */
    padding-right: 80px;
    will-change: transform;
}

/* ─── Card ───────────────────────────────── */
.me-card {
    flex-shrink: 0;
    width: 240px;
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    transition: transform .28s, box-shadow .28s;
}

.me-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(0,0,0,.11);
}

/* ─── Image ──────────────────────────────── */
.me-img {
    position: relative;
    width: 100%;
    aspect-ratio: 4 / 3;
    background: #f0f0f0;
    overflow: hidden;
    flex-shrink: 0;
}

.me-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s ease;
    pointer-events: none;
    display: block;
}

.me-card:hover .me-img img { transform: scale(1.06); }

/* category pill */
.me-tag {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(255,255,255,.88);
    color: #333;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .6px;
    padding: 3px 10px;
    border-radius: 50px;
    backdrop-filter: blur(4px);
    white-space: nowrap;
    max-width: calc(100% - 20px);
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ─── Body ───────────────────────────────── */
.me-body {
    padding: 18px 18px 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.me-name {
    font-size: 14px;
    font-weight: 700;
    color: #111;
    line-height: 1.35;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 38px;
}

.me-desc {
    font-size: 12.5px;
    color: #777;
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex: 1;
    margin-bottom: 14px;
}

.me-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 600;
    color: #57B847;
    transition: gap .2s;
}

.me-card:hover .me-link { gap: 8px; }
.me-link i { font-size: 11px; }

/* ─── Responsive ─────────────────────────── */
@media (max-width: 1100px) {
    .me-card  { width: 220px; }
    .me-title { font-size: 34px; }
}

@media (max-width: 768px) {
    .me-section   { padding: 40px 20px 48px; }
    .me-viewport  { margin-right: -20px; }
    .me-title     { font-size: 26px; }
    .me-sub       { font-size: 13px; }
    .me-card      { width: 200px; }
    .me-header    { flex-direction: column; align-items: flex-start; gap: 14px; }
    .me-track     { gap: 14px; }
}

@media (max-width: 480px) {
    .me-card { width: 72vw; }
}
</style>

<script>
(function () {
    var vp    = document.getElementById('meViewport');
    var track = document.getElementById('meTrack');
    if (!vp || !track) return;

    var dragging    = false;
    var startX      = 0;
    var startTX     = 0;
    var currentTX   = 0;
    var velX        = 0;
    var lastX       = 0;
    var lastTime    = 0;
    var rafId       = null;

    function getTX() {
        var m = new DOMMatrix(getComputedStyle(track).transform);
        return m.m41;
    }

    function maxTX() {
        return -(track.scrollWidth - vp.offsetWidth);
    }

    function applyTX(x, smooth) {
        track.style.transition = smooth ? 'transform .45s cubic-bezier(.25,.46,.45,.94)' : 'none';
        track.style.transform  = 'translateX(' + x + 'px)';
        currentTX = x;
    }

    function clamp(v, lo, hi) { return Math.max(lo, Math.min(hi, v)); }

    /* momentum glide */
    function glide() {
        velX *= 0.92;
        var nx = clamp(currentTX + velX, maxTX() - 30, 30);
        track.style.transition = 'none';
        track.style.transform  = 'translateX(' + nx + 'px)';
        currentTX = nx;

        if (Math.abs(velX) > 0.5) {
            rafId = requestAnimationFrame(glide);
        } else {
            /* snap into bounds */
            applyTX(clamp(currentTX, maxTX(), 0), true);
        }
    }

    function startDrag(x) {
        cancelAnimationFrame(rafId);
        dragging  = true;
        startX    = x;
        startTX   = getTX();
        currentTX = startTX;
        velX      = 0;
        lastX     = x;
        lastTime  = Date.now();
        track.style.transition = 'none';
    }

    function moveDrag(x) {
        if (!dragging) return;
        var now = Date.now();
        var dt  = now - lastTime || 1;
        velX    = (x - lastX) / dt * 16;
        lastX   = x;
        lastTime = now;
        var nx  = clamp(startTX + (x - startX), maxTX() - 60, 60);
        track.style.transform = 'translateX(' + nx + 'px)';
        currentTX = nx;
    }

    function endDrag() {
        if (!dragging) return;
        dragging = false;
        if (Math.abs(velX) > 1) {
            rafId = requestAnimationFrame(glide);
        } else {
            applyTX(clamp(currentTX, maxTX(), 0), true);
        }
    }

    /* Mouse */
    vp.addEventListener('mousedown',  function(e){ startDrag(e.clientX); });
    window.addEventListener('mousemove', function(e){ moveDrag(e.clientX); });
    window.addEventListener('mouseup',   endDrag);

    /* Touch */
    vp.addEventListener('touchstart', function(e){ startDrag(e.touches[0].clientX); }, { passive: true });
    window.addEventListener('touchmove',  function(e){ if(dragging) moveDrag(e.touches[0].clientX); }, { passive: true });
    window.addEventListener('touchend',   endDrag);

    /* Prevent link clicks during drag */
    vp.addEventListener('click', function(e){
        if (Math.abs(getTX() - startTX) > 6) e.preventDefault();
    });
})();
</script>
