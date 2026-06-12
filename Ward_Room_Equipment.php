<?php include "header.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>ICU Beds | Royal Establishment</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body{
    background: #f8f9fa;
    color: #111;
    overflow-x: hidden;
}

/* =========================
PRODUCT HERO
========================= */
.product-hero{
    height: 260px;
    background: linear-gradient(rgba(0,0,0,.65), rgba(0,0,0,.65)), url('https://images.unsplash.com/photo-1586773860418-d37222d8fce3?q=80&w=1600');
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    text-align: center;
    padding: 0 5%;
    color: #fff;
}

.product-hero h1{
    font-size: 42px;
    font-weight: 700;
    margin-bottom: 12px;
}

.product-hero p{
    font-size: 15px;
    color: #ddd;
}

.product-hero p a{
    color: #57B847; 
    text-decoration: none;
}

/* =========================
PRODUCT SECTION
========================= */
.product-section{
    padding: 60px 5% 30px 5%;
}

.product-container{
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: 50px;
    align-items: start;
}

/* IMAGE */
.product-image{
    background: #fff;
    border: 3px solid #57B847; 
    border-radius: 24px;
    padding: 30px;
    box-shadow: 0 12px 30px rgba(0,0,0,.06);
}

.product-image img{
    width: 100%;
    display: block;
    height: auto;
}

/* DETAILS */
.product-details .model-number{
    font-size: 26px;
    color: #57B847; 
    margin-bottom: 4px;
    font-weight: 700;
    display: inline-block;
}

.product-details .model-number span {
    color: #333;
    font-weight: 400;
}

.product-details h2{
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #4a5568;
    border-bottom: 1px solid #cbd5e0;
    padding-bottom: 10px;
}

.product-details h3{
    font-size: 20px;
    margin-bottom: 18px;
    color: #111;
    font-weight: 700;
}

.features-list li{
    list-style: none;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 14px;
    font-size: 15px;
    line-height: 1.6;
    color: #2d3748;
}

.features-list i{
    width: 8px;
    height: 8px;
    background: #57B847; 
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: transparent;
    margin-top: 8px;
    flex-shrink: 0;
}

/* BUTTONS */
.product-buttons{
    display: flex;
    gap: 16px;
    margin-top: 30px;
    flex-wrap: wrap;
}

.product-btn,
.product-btn-outline{
    height: 50px;
    padding: 0 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50px;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    transition: .3s;
}

.product-btn{
    background: #57B847; 
    color: #fff;
}

.product-btn:hover{
    background: #111;
}

.product-btn-outline{
    border: 2px solid #57B847; 
    color: #57B847;
}

.product-btn-outline:hover{
    background: #57B847;
    color: #fff;
}

/* =========================
ROYAL PRODUCT OPTIONS & SPECS
========================= */
.royal-product-options{
    padding: 30px 5% 60px 5%;
    background: #f8f9fa;
}

/* Changed grids layout to 1fr 1fr for perfect balancing */
.royal-options-grid,
.royal-specs-split-grid{
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}

.royal-specs-split-grid {
    margin-top: 20px;
}

.royal-option-title{
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #111;
    font-family: 'Poppins', sans-serif;
}

/* PANEL GRID */
.royal-panel-grid{
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
}

.royal-panel-card{
    width: 110px;
    height: 85px;
    background: #fff;
    border: 2px solid #57B847; 
    border-radius: 14px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 6px;
    transition: .3s;
}

.royal-panel-card:hover{
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(87,184,71,.12);
}

.royal-panel-card img{
    width: 100%;
    height: 100%;
    object-fit: contain;
}

/* COLOR OPTIONS */
.royal-color-grid{
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
}

.royal-color{
    width: 56px;
    height: 56px;
    border-radius: 14px;
    border: 3px solid #fff;
    box-shadow: 0 8px 16px rgba(0,0,0,.08);
}

.green1{ background: #57B847; }
.green2{ background: #76d86a; }
.green3{ background: #2f8d44; }

/* UNIFORM DESIGN FOR BOTH IMAGE WRAPPERS */
.spec-image-wrapper {
    background: #fff;
    border: 2px solid #57B847;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    min-height: 220px; /* Ensures consistent minimum vertical size alignment */
}

.spec-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
}

/* =========================
FULL WIDTH GREEN DIVIDER LINE
========================= */
.bed-divider {
    border: 0;
    height: 3px;
    background: linear-gradient(to right, transparent, rgba(87,184,71,0.6), transparent);
    margin: 60px 0;
    width: 100%;
}

/* RESPONSIVE */
@media(max-width: 992px){
    .product-container,
    .royal-options-grid,
    .royal-specs-split-grid{
        grid-template-columns: 1fr;
    }
    .spec-image-wrapper {
        min-height: auto;
    }
}

@media(max-width: 768px){
    .product-hero{
        height: 220px;
    }
    .product-hero h1{
        font-size: 32px;
    }
    .product-details h2{
        font-size: 22px;
    }
}
</style>

</head>
<body>

<!-- ===================================================
     BED 1 BLOCK START (WM-5176-7FC)
=================================================== -->
<section class="product-hero">
    <h1>Ward Room Equipment</h1>
    <p>
        <a href="index.php">Home</a> / 
        <a href="products.php">Products</a> / 
        Ward Room Equipment
    </p>
</section>

<section class="product-section">
    <div class="product-container">
        <div class="product-image">
            <img src="Images/Icubed/1.jpg" alt="Motorised ICU Bed Model WM-5176-7FC">
        </div>
        
       <div class="product-details">
    <div class="model-number">Model : <span>WM-5176-7FC</span></div>
    <h2>Motorised ICU Bed</h2>
    <h3>Features and Benefits</h3>
    
    <ul class="features-list">
        <li><i></i><span>Mattress area divided into 4 sections made up of CRCA Sheet.</span></li>
        <li><i></i><span>Detachable Polymer Molded Head & Foot Boards and Four sectional polymer molded safety side rails with angle indicators provide a soothing look.</span></li>
        <li><i></i><span>Dual Side Lever for Manual CPR and four Corner PU buffers to absorb impact and reduce damage during handling.</span></li>
        <li><i></i><span>Provided with Heavy duty telescopic IV Pole with two hooks having provision of fixing on four corners of the bed.</span></li>
        <li><i></i><span>Provided with Single/Twin wheel heavy duty Central Locking Castors Wheels of 125 mm dia for smooth mobility with control.</span></li>
        <li><i></i><span>The complete metal components are Pretreated and Epoxy powder coated.</span></li>
        <li><i></i><span><strong>Overall Dimensions : 2160 mm L X 1020 mm W</strong></span></li>
        <li><i></i><span><strong>Also Available in Diagonal Locking Wheel Option <span style="color:#57B847;">WM-5176-7FD</span></strong></span></li>
    </ul>
    
    <div class="product-buttons">
        <a href="#" class="product-btn">Send Enquiry</a>
        <a href="catalog.pdf" download class="product-btn-outline">Download Catalog</a>
    </div>
</div>
    </div>
</section>

<section class="royal-product-options">
    <div class="royal-options-grid">
        <div>
            <h2 class="royal-option-title">Panel & Railing Options</h2>
            <div class="royal-panel-grid">
                <div class="royal-panel-card"><img src="Images/Icubed/1.1.png" alt="Railing Panel 1"></div>
                <div class="royal-panel-card"><img src="Images/Icubed/1.2.png" alt="Railing Panel 2"></div>
                <div class="royal-panel-card"><img src="Images/Icubed/1.3.png" alt="Railing Panel 3"></div>
                <div class="royal-panel-card"><img src="Images/Icubed/1.4.png" alt="Railing Panel 4"></div>
            </div>
        </div>
        <div>
            <h2 class="royal-option-title">Color Options</h2>
            <div class="royal-color-grid">
                <div class="royal-color green1" role="img" aria-label="Standard Green"></div>
                <div class="royal-color green2" role="img" aria-label="Light Green"></div>
                <div class="royal-color green3" role="img" aria-label="Dark Green"></div>
            </div>
        </div>
    </div>

    <div class="royal-specs-split-grid" style="margin-top: 50px;">
        <!-- LEFT SIDE: MAJOR FEATURES IMAGE (BED 1) -->
        <div>
            <h2 class="royal-option-title">Major Features</h2>
            <div class="spec-image-wrapper">
                <img src="Images/Icubed/m1.png" alt="Major Features Sheet">
            </div>
        </div>

        <!-- RIGHT SIDE: OPTIONAL ACCESSORIES IMAGE (BED 1) -->
        <div>
            <h2 class="royal-option-title">Optional Accessories</h2>
            <div class="spec-image-wrapper">
                <img src="Images/Icubed/O1.png" alt="Optional Accessories Sheet">
            </div>
        </div>
    </div>
</section>
<!-- ===================================================
     BED 1 BLOCK END
=================================================== -->


<!-- GREEN GRADIENT FULL WIDTH DIVIDER -->
<hr class="bed-divider">


<!-- ===================================================
     BED 2 BLOCK START (SAME LAYOUT - NO HERO)
=================================================== -->
<section class="product-section" style="padding-top: 20px;">
    <div class="product-container">
        <div class="product-image">
            <img src="Images/Icubed/2.jpg" alt="Premium ICU Bed Model WM-9900-DX">
        </div>
        
        <div class="product-details">
    <div class="model-number">Model : <span>WM-5177-5FD</span></div>
    <h2>Motorised ICU Bed</h2>
    <h3>Features and Benefits</h3>
    
    <ul class="features-list">
        <li><i></i><span>Mattress area divided into 4 sections made up of CRCA Sheet.</span></li>
        <li><i></i><span>Detachable Polymer Molded Head & Foot Boards and four sectional polymer molded safety side rails with angle indicators provide a soothing look.</span></li>
        <li><i></i><span>Four Corner PU buffers to absorb impact and reduce damage during handling.</span></li>
        <li><i></i><span>Provided with Heavy duty telescopic IV Pole with two hooks having provision of fixing on four corners of the bed.</span></li>
        <li><i></i><span>Provided with Single wheel heavy duty diagonal Locking Castors Wheels of 125 mm dia for smooth mobility with control.</span></li>
        <li><i></i><span>The complete metal components are Pretreated and Epoxy powder coated.</span></li>
        <li><i></i><span><strong>Overall Dimensions: 2160 mm L X 1020 mm W</strong></span></li>
        <li><i></i><span><strong>"Also Available with central locking wheels. <span style="color:#57B847;">WM-5177-5FC</span></strong></span></li>
    </ul>
    
    <div class="product-buttons">
        <a href="#" class="product-btn">Send Enquiry</a>
        <a href="catalog-premium.pdf" download class="product-btn-outline">Download Catalog</a>
    </div>
</div>
    </div>
</section>

<section class="royal-product-options">
    <div class="royal-options-grid">
        <div>
            <h2 class="royal-option-title">Panel & Railing Options</h2>
            <div class="royal-panel-grid">
                <div class="royal-panel-card"><img src="Images/Icubed/2.1.png" alt="Railing Panel 1"></div>
                <div class="royal-panel-card"><img src="Images/Icubed/2.2.png" alt="Railing Panel 2"></div>
                <div class="royal-panel-card"><img src="Images/Icubed/2.3.png" alt="Railing Panel 3"></div>
                <div class="royal-panel-card"><img src="Images/Icubed/2.4.png" alt="Railing Panel 4"></div>
            </div>
        </div>
        <div>
            <h2 class="royal-option-title">Color Options</h2>
            <div class="royal-color-grid">
                <div class="royal-color green1" role="img" aria-label="Standard Green"></div>
                <div class="royal-color green3" role="img" aria-label="Dark Green"></div>
            </div>
        </div>
    </div>

    <div class="royal-specs-split-grid" style="margin-top: 50px;">
        <!-- LEFT SIDE: MAJOR FEATURES IMAGE (BED 2) -->
        <div>
            <h2 class="royal-option-title">Major Features</h2>
            <div class="spec-image-wrapper">
                <img src="Images/Icubed/m2.png" alt="Major Features Sheet">
            </div>
        </div>

        <!-- RIGHT SIDE: OPTIONAL ACCESSORIES IMAGE (BED 2) -->
        <div>
            <h2 class="royal-option-title">Optional Accessories</h2>
            <div class="spec-image-wrapper">
                <img src="Images/Icubed/O2.png" alt="Optional Accessories Sheet">
            </div>
        </div>
    </div>
</section>
<!-- ===================================================
     BED 2 BLOCK END
=================================================== -->

</body>
</html>
<?php include "footer.php" ?>