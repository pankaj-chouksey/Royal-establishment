<?php include "header.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Infrastructure | Royal Establishment</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#f8f9fa;
overflow-x:hidden;
}

/* =========================
HERO SECTION
========================= */

.infrastructure-hero{

height:360px;

background:
linear-gradient(rgba(0,0,0,.65),rgba(0,0,0,.65)),
url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=1600');

background-size:cover;
background-position:center;

display:flex;
justify-content:center;
align-items:center;
flex-direction:column;

text-align:center;
padding:0 5%;

color:#fff;
}

.infrastructure-hero h1{

font-size:58px;
font-weight:700;
margin-bottom:15px;

}

.infrastructure-hero p{

font-size:18px;
color:#ddd;

}

/* =========================
INFRASTRUCTURE SECTION
========================= */

.infrastructure-section{

padding:90px 5%;

}

/* GRID */

.infrastructure-grid{

display:grid;
grid-template-columns:repeat(2,1fr);
gap:28px;

}

/* CARD */

.infrastructure-card{

background:#fff;

border:3px solid #57B847;

border-radius:18px;

overflow:hidden;

box-shadow:0 8px 25px rgba(0,0,0,.06);

transition:.35s;

}

.infrastructure-card:hover{

transform:translateY(-8px);

box-shadow:0 18px 35px rgba(87,184,71,.20);

}

/* VIDEO */

.infrastructure-card iframe{

width:100%;
height:380px;

border:0;
display:block;

}

/* IMAGE */

.infrastructure-card img{

width:100%;
height:380px;

object-fit:cover;

display:block;

}

/* TITLE BAR */

.infrastructure-title{

background:#57B847;

color:#fff;

text-align:center;

padding:18px 20px;

font-size:30px;
font-weight:500;

}

/* =========================
RESPONSIVE
========================= */

@media(max-width:992px){

.infrastructure-grid{

grid-template-columns:1fr;

}

}

@media(max-width:768px){

.infrastructure-hero{

height:280px;

}

.infrastructure-hero h1{

font-size:42px;

}

.infrastructure-card iframe,
.infrastructure-card img{

height:280px;

}

.infrastructure-title{

font-size:22px;

}

}
/* =========================
PRODUCTION HOUSE
========================= */

.production-section{

padding:90px 5%;

background:#f8f9fa;

}

.production-heading{

text-align:center;

margin-bottom:55px;

}

.production-heading h2{

font-size:44px;
font-weight:700;

color:#111;

margin-bottom:18px;

}

.heading-line{

width:90px;
height:4px;

background:#57B847;

margin:auto;

border-radius:50px;

}

/* GRID */

.production-grid{

display:grid;
grid-template-columns:repeat(2,1fr);

gap:28px;

}

/* CARD */

.production-card{

background:#fff;

border:3px solid #57B847;

border-radius:20px;

overflow:hidden;

box-shadow:0 8px 25px rgba(0,0,0,.06);

transition:.35s;

}

.production-card:hover{

transform:translateY(-8px);

box-shadow:0 18px 35px rgba(87,184,71,.20);

}

/* IMAGE */

.production-card img{

width:100%;
height:420px;

object-fit:cover;

display:block;

transition:.4s;

}

.production-card:hover img{

transform:scale(1.04);

}

/* RESPONSIVE */

@media(max-width:992px){

.production-grid{

grid-template-columns:1fr;

}

}

@media(max-width:768px){

.production-heading h2{

font-size:34px;

}

.production-card img{

height:280px;

}

}

</style>

</head>

<body>

<!-- HERO -->

<section class="infrastructure-hero">

<h1>Infrastructure</h1>

<p>
Advanced Manufacturing & Corporate Facilities
</p>

</section>

<!-- INFRASTRUCTURE -->

<section class="infrastructure-section">

<div class="infrastructure-grid">

<!-- VIDEO CARD -->

<div class="infrastructure-card">

<iframe
src="https://www.youtube.com/embed/tgbNymZ7vqY"
allowfullscreen>
</iframe>

<div class="infrastructure-title">
Manufacturing Unit
</div>

</div>

<!-- IMAGE CARD -->

<div class="infrastructure-card">

<img src="Images/office.jpg" alt="Corporate Office">

<div class="infrastructure-title">
Corporate Office, Noida
</div>

</div>

</div>

</section>
<!-- =========================
PRODUCTION HOUSE SECTION
========================= -->

<section class="production-section">

<div class="production-heading">

<h2>Production House</h2>

<div class="heading-line"></div>

</div>

<div class="production-grid">

<!-- IMAGE 1 -->

<div class="production-card">

<img src="Images/production1.jpg" alt="Production">

</div>

<!-- IMAGE 2 -->

<div class="production-card">

<img src="Images/production2.jpg" alt="Production">

</div>

<!-- IMAGE 3 -->

<div class="production-card">

<img src="Images/production3.jpg" alt="Production">

</div>

<!-- IMAGE 4 -->

<div class="production-card">

<img src="Images/production4.jpg" alt="Production">

</div>

</div>

</section>
</body>
</html>
<?php include "footer.php" ?>