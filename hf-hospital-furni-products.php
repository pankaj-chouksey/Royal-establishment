<?php
/* ─────────────────────────────────────────────
   HOSPITAL FURNITURE SECTION
───────────────────────────────────────────── */
if(!defined('BASE_URL')) include_once __DIR__."/includes/config.php";

/* Use existing $conn or open a fresh one */
if(empty($conn) || !$conn){
    $conn = mysqli_connect("localhost","root","","royalestablishment");
    if($conn) mysqli_set_charset($conn,"utf8");
}

$_hf_rows = [];
$_hfQ = mysqli_query($conn,
    "SELECT p.id, p.product_name, p.short_description,
            p.featured_image, pc.category_name
     FROM products p
     LEFT JOIN product_categories pc ON pc.id = p.category_id
     WHERE p.status = 'active'
       AND pc.id BETWEEN 16 AND 24
     ORDER BY pc.id ASC, p.id DESC"
);
if($_hfQ) while($row = mysqli_fetch_assoc($_hfQ)) $_hf_rows[] = $row;

/* Fallback if no HF products found */
if(empty($_hf_rows)){
    $_hfQ2 = mysqli_query($conn,
        "SELECT p.id, p.product_name, p.short_description,
                p.featured_image, pc.category_name
         FROM products p
         LEFT JOIN product_categories pc ON pc.id = p.category_id
         WHERE p.status = 'active'
         ORDER BY p.id DESC
         LIMIT 12"
    );
    if($_hfQ2) while($row = mysqli_fetch_assoc($_hfQ2)) $_hf_rows[] = $row;
}

$_hf_total = count($_hf_rows);
?>

<!-- HOSPITAL FURNITURE SECTION -->
<section class="hf-section">

    <div class="hf-inner">

        <!-- ── Left info panel ── -->
        <div class="hf-left">
            <h2 class="hf-title">Hospital<br>Furniture's</h2>
            <p class="hf-sub">Browse our best-in-class hospital furniture and biomedical equipment</p>
            <a href="<?= BASE_URL ?>products.php?section=furniture" class="hf-view-all">View all</a>
        </div>

        <!-- ── Right cards + nav ── -->
        <div class="hf-right">

            <!-- Card viewport -->
            <div class="hf-viewport" id="hfViewport">
                <div class="hf-track" id="hfTrack">
                    <?php foreach($_hf_rows as $p):
                        $name = htmlspecialchars($p['product_name'] ?? '');
                        $cat  = htmlspecialchars($p['category_name'] ?? '');
                        $desc = htmlspecialchars(mb_substr($p['short_description'] ?? '', 0, 85));
                        $id   = (int)$p['id'];
                        $img  = !empty($p['featured_image'])
                                ? BASE_URL.'uploads/products/'.htmlspecialchars($p['featured_image'])
                                : BASE_URL.'Images/no-image.png';
                    ?>
                    <a href="<?= BASE_URL ?>product/view_product.php?id=<?= $id ?>" class="hf-card">
                        <div class="hf-img">
                            <img src="<?= $img ?>" alt="<?= $name ?>" loading="lazy"
                                 onerror="this.src='<?= BASE_URL ?>Images/no-image.png'">
                        </div>
                        <div class="hf-body">
                            <h3 class="hf-name"><?= $name ?></h3>
                            <?php if($cat): ?>
                            <p class="hf-cat-label"><?= $cat ?></p>
                            <?php endif; ?>
                            <p class="hf-desc"><?= $desc ?>...</p>
                            <div class="hf-btns">
                                <span class="hf-btn-secondary">Enquire</span>
                                <span class="hf-btn-primary">View Details</span>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Prev / Next arrows — bottom right -->
            <div class="hf-nav">
                <button class="hf-arrow" id="hfPrev" aria-label="Previous">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button class="hf-arrow" id="hfNext" aria-label="Next">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>

        </div><!-- /hf-right -->

    </div><!-- /hf-inner -->

</section>

<style>
/* ─── Section ─────────────────────────────── */
.hf-section {
    background: #e8e8e8;
    padding: 48px 40px 48px;
    overflow: hidden;
}

/* ─── Inner: left info col + right cards ── */
.hf-inner {
    display: grid;
    /* left col fixed, right takes rest */
    grid-template-columns: 220px 1fr;
    gap: 40px;
    align-items: stretch; /* both cols same height */
}

/* ─── Left panel — fills full height, space-between layout */
.hf-left {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    padding: 4px 0 0;
}

.hf-title {
    font-size: 36px;
    font-weight: 700;
    color: #111;
    line-height: 1.15;
    letter-spacing: -0.8px;
    margin-bottom: 14px;
}

.hf-sub {
    font-size: 13.5px;
    color: #666;
    line-height: 1.65;
    margin-bottom: 24px;
}

.hf-view-all {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 44px;
    padding: 0 24px;
    background: #111;
    color: #fff;
    border-radius: 50px;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none;
    transition: background .2s, transform .2s;
    white-space: nowrap;
    width: fit-content;
    margin-top: 0;
}

.hf-view-all:hover {
    background: #333;
    color: #fff;
    transform: translateY(-2px);
}

/* ─── Right container ────────────────────── */
.hf-right {
    display: flex;
    flex-direction: column;
    gap: 16px;
    min-width: 0;
}

/* ─── Viewport — clips & bleeds right edge ── */
.hf-viewport {
    overflow: hidden;
    margin-right: -40px;   /* bleed past section padding → peek effect */
    cursor: grab;
    -webkit-user-select: none;
    user-select: none;
    flex: 1;
}

.hf-viewport:active { cursor: grabbing; }

/* ─── Track ──────────────────────────────── */
.hf-track {
    display: flex;
    gap: 16px;
    flex-wrap: nowrap;
    width: max-content;
    padding-right: 80px;   /* breathing room for peek */
    height: 100%;
    will-change: transform;
}

/* ─── Card ───────────────────────────────── */
.hf-card {
    flex-shrink: 0;
    width: calc((100vw - 220px - 40px - 40px - 80px) / 3.4);
    min-width: 200px;
    max-width: 290px;
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    box-shadow: 0 2px 16px rgba(0,0,0,.07);
    transition: transform .28s ease, box-shadow .28s ease;
    padding: 12px 12px 16px;
}

.hf-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 44px rgba(0,0,0,.13);
}

.hf-img {
    position: relative;
    width: 100%;
    aspect-ratio: 4 / 3;
    background: #e8e8e8;
    overflow: hidden;
    flex-shrink: 0;
    border-radius: 14px;
    margin-bottom: 14px;
}

.hf-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s ease;
    pointer-events: none;
    display: block;
}

.hf-card:hover .hf-img img { transform: scale(1.05); }

.hf-tag {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(255,255,255,.9);
    color: #222;
    font-size: 9.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .7px;
    padding: 3px 10px;
    border-radius: 50px;
    backdrop-filter: blur(6px);
    white-space: nowrap;
    max-width: calc(100% - 20px);
    overflow: hidden;
    text-overflow: ellipsis;
    box-shadow: 0 1px 4px rgba(0,0,0,.08);
}

.hf-body {
    padding: 0 4px 4px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.hf-name {
    font-size: 15px;
    font-weight: 700;
    color: #111;
    line-height: 1.3;
    margin-bottom: 3px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.hf-cat-label {
    font-size: 12px;
    font-weight: 500;
    color: #888;
    margin-bottom: 10px;
}

.hf-desc {
    font-size: 12px;
    color: #999;
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex: 1;
    margin-bottom: 14px;
}

.hf-btns {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.hf-btn-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 34px;
    padding: 0 14px;
    background: #e8e8e8;
    color: #333;
    border-radius: 50px;
    font-size: 11.5px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    transition: background .2s;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
}

.hf-btn-secondary:hover { background: #d0d0d0; color: #111; }

.hf-btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 34px;
    padding: 0 14px;
    background: #222;
    color: #fff;
    border-radius: 50px;
    font-size: 11.5px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    transition: background .2s;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
}

.hf-btn-primary:hover { background: #57B847; color: #fff; }

/* ─── Nav arrows — bottom-right ─────────── */
.hf-nav {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
    padding-right: 40px;
    flex-shrink: 0;
}

.hf-arrow {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #fff;
    border: 1.5px solid #ccc;
    color: #555;
    font-size: 13px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: border-color .2s, color .2s, box-shadow .2s, transform .2s;
    box-shadow: 0 1px 6px rgba(0,0,0,.06);
}

.hf-arrow:hover {
    border-color: #333;
    color: #111;
    box-shadow: 0 4px 14px rgba(0,0,0,.12);
    transform: scale(1.08);
}

/* ─── Responsive ─────────────────────────── */
@media (max-width: 1200px) {
    .hf-card { width: calc((100vw - 220px - 40px - 40px - 60px) / 3.2); }
}

@media (max-width: 1024px) {
    .hf-inner { grid-template-columns: 190px 1fr; gap: 28px; }
    .hf-title { font-size: 30px; }
    .hf-card  { width: calc((100vw - 190px - 28px - 40px - 60px) / 2.6); }
}

@media (max-width: 860px) {
    .hf-inner { grid-template-columns: 1fr; gap: 24px; }
    .hf-left  { flex-direction: row; flex-wrap: wrap; align-items: center; gap: 12px 20px; }
    .hf-title { font-size: 26px; margin-bottom: 0; }
    .hf-sub   { display: none; }
    .hf-view-all { margin-top: 0; }
    .hf-card  { width: 200px; }
}

@media (max-width: 768px) {
    .hf-section  { padding: 36px 20px 44px; }
    .hf-viewport { margin-right: -20px; }
    .hf-nav      { padding-right: 20px; }
    .hf-card     { width: 185px; }
    .hf-title    { font-size: 22px; }
}

@media (max-width: 480px) {
    .hf-card { width: 68vw; min-width: unset; }
}
</style>

<script>
(function () {
    var vp    = document.getElementById('hfViewport');
    var track = document.getElementById('hfTrack');
    var prev  = document.getElementById('hfPrev');
    var next  = document.getElementById('hfNext');
    if (!vp || !track) return;

    var dragging  = false;
    var startX    = 0;
    var startTX   = 0;
    var currentTX = 0;
    var velX      = 0;
    var lastX     = 0;
    var lastTime  = 0;
    var rafId     = null;

    function getTX() {
        var m = new DOMMatrix(getComputedStyle(track).transform);
        return m.m41;
    }

    function maxTX() {
        return -(track.scrollWidth - vp.offsetWidth);
    }

    function clamp(v, lo, hi) { return Math.max(lo, Math.min(hi, v)); }

    function applyTX(x, smooth) {
        track.style.transition = smooth ? 'transform .42s cubic-bezier(.25,.46,.45,.94)' : 'none';
        track.style.transform  = 'translateX(' + x + 'px)';
        currentTX = x;
    }

    function glide() {
        velX *= 0.91;
        var nx = clamp(currentTX + velX, maxTX() - 30, 30);
        track.style.transition = 'none';
        track.style.transform  = 'translateX(' + nx + 'px)';
        currentTX = nx;
        if (Math.abs(velX) > 0.5) {
            rafId = requestAnimationFrame(glide);
        } else {
            applyTX(clamp(currentTX, maxTX(), 0), true);
        }
    }

    function startDrag(x) {
        cancelAnimationFrame(rafId);
        dragging  = true;
        startX    = x;
        startTX   = getTX();
        currentTX = startTX;
        velX = 0; lastX = x; lastTime = Date.now();
        track.style.transition = 'none';
    }

    function moveDrag(x) {
        if (!dragging) return;
        var now = Date.now(), dt = now - lastTime || 1;
        velX = (x - lastX) / dt * 16;
        lastX = x; lastTime = now;
        applyTX(clamp(startTX + (x - startX), maxTX() - 60, 60), false);
    }

    function endDrag() {
        if (!dragging) return;
        dragging = false;
        if (Math.abs(velX) > 1) { rafId = requestAnimationFrame(glide); }
        else { applyTX(clamp(currentTX, maxTX(), 0), true); }
    }

    /* Step by one card width */
    function cardW() {
        var c = track.querySelector('.hf-card');
        return c ? c.offsetWidth + 18 : 238;
    }

    function stepBy(dir) {
        var nx = clamp(getTX() + dir * cardW() * 3, maxTX(), 0);
        applyTX(nx, true);
        currentTX = nx;
    }

    prev && prev.addEventListener('click', function () { stepBy(1); });
    next && next.addEventListener('click', function () { stepBy(-1); });

    /* Mouse */
    vp.addEventListener('mousedown',   function(e){ startDrag(e.clientX); });
    window.addEventListener('mousemove',function(e){ moveDrag(e.clientX); });
    window.addEventListener('mouseup',  endDrag);

    /* Touch */
    vp.addEventListener('touchstart', function(e){ startDrag(e.touches[0].clientX); }, { passive:true });
    window.addEventListener('touchmove', function(e){ if(dragging) moveDrag(e.touches[0].clientX); }, { passive:true });
    window.addEventListener('touchend', endDrag);

    /* Block link-click if dragging */
    vp.addEventListener('click', function(e){
        if(Math.abs(getTX() - startTX) > 6) e.preventDefault();
    });
})();
</script>
