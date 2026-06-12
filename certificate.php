<?php include "header.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Certificates | Royal Establishment</title>

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

.certificate-hero{
height:380px;

background:
linear-gradient(rgba(0,0,0,.65),rgba(0,0,0,.65)),
url('https://images.unsplash.com/photo-1581093458791-9d42e0f2f0a1?q=80&w=1600');

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

.certificate-hero h1{
font-size:58px;
font-weight:700;
margin-bottom:15px;
}

.certificate-hero p{
font-size:18px;
color:#ddd;
}

/* =========================
CERTIFICATE SECTION
========================= */

.certificate-section{
padding:90px 5%;
}

.section-title{
text-align:center;
margin-bottom:60px;
}

.section-title h2{
font-size:42px;
font-weight:700;
color:#111;
margin-bottom:15px;
}

.section-title p{
font-size:17px;
color:#666;
max-width:750px;
margin:auto;
line-height:1.8;
}

/* =========================
GRID
========================= */

.certificate-grid{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:35px;
}

/* CARD */

.certificate-card{
background:#fff;

border:3px solid #57B847;
border-radius:18px;

overflow:hidden;

cursor:pointer;

transition:.35s;

box-shadow:0 10px 25px rgba(0,0,0,.06);
}

.certificate-card:hover{
transform:translateY(-8px);
box-shadow:0 18px 35px rgba(0,0,0,.12);
}

/* IMAGE */

.certificate-card img{
width:100%;
height:100%;
display:block;

transition:.4s;
}

.certificate-card:hover img{
transform:scale(1.04);
}

/* =========================
LIGHTBOX
========================= */

.lightbox{
position:fixed;
top:0;
left:0;

width:100%;
height:100%;

background:rgba(0,0,0,.9);

display:flex;
justify-content:center;
align-items:center;

opacity:0;
visibility:hidden;

transition:.3s;

z-index:99999;
}

.lightbox.active{
opacity:1;
visibility:visible;
}

.lightbox img{
max-width:90%;
max-height:90%;

border-radius:12px;
border:4px solid #57B847;

background:#fff;
}

.close-lightbox{
position:absolute;
top:30px;
right:40px;

font-size:42px;
color:#fff;

cursor:pointer;
transition:.3s;
}

.close-lightbox:hover{
color:#57B847;
transform:rotate(90deg);
}

/* =========================
RESPONSIVE
========================= */

@media(max-width:1100px){

.certificate-grid{
grid-template-columns:repeat(2,1fr);
}

}

@media(max-width:768px){

.certificate-hero{
height:300px;
}

.certificate-hero h1{
font-size:42px;
}

.section-title h2{
font-size:32px;
}

.certificate-grid{
grid-template-columns:1fr;
}

.close-lightbox{
top:20px;
right:25px;
font-size:34px;
}

}

</style>

</head>

<body>

<!-- =========================
HERO SECTION
========================= -->

<section class="certificate-hero">

<h1>Our Certifications</h1>

<p>
Trusted Quality. Certified Excellence.
</p>

</section>

<!-- =========================
CERTIFICATE GALLERY
========================= -->

<section class="certificate-section">

<div class="section-title">

<h2>Certified & Trusted</h2>

<p>
Royal Establishment is committed to delivering high-quality
medical equipment with international quality standards
and certified healthcare solutions.
</p>

</div>

<div class="certificate-grid">

<!-- CERTIFICATE 1 -->

<div class="certificate-card">

<img src="Images/certificates/1.jpg" alt="Certificate">

</div>

<!-- CERTIFICATE 2 -->

<div class="certificate-card">

<img src="Images/certificates/2.jpg" alt="Certificate">

</div>

<!-- CERTIFICATE 3 -->

<div class="certificate-card">

<img src="Images/certificates/3.jpg" alt="Certificate">

</div>

<!-- CERTIFICATE 4 -->

<div class="certificate-card">

<img src="Images/certificates/4.jpg" alt="Certificate">

</div>

<!-- CERTIFICATE 5 -->

<div class="certificate-card">

<img src="Images/certificates/5.jpg" alt="Certificate">

</div>

<!-- CERTIFICATE 6 -->

<div class="certificate-card">

<img src="Images/certificates/6.jpg" alt="Certificate">

</div>

<!-- CERTIFICATE 7 -->

<div class="certificate-card">

<img src="Images/certificates/7.jpg" alt="Certificate">

</div>

</div>

</section>

<!-- =========================
LIGHTBOX
========================= -->

<div class="lightbox" id="lightbox">

<span class="close-lightbox" id="closeLightbox">
&times;
</span>

<img src="" id="lightboxImg">

</div>

<!-- =========================
JAVASCRIPT
========================= -->

<script>

/* SELECT ELEMENTS */

const cards = document.querySelectorAll('.certificate-card img');

const lightbox = document.getElementById('lightbox');

const lightboxImg = document.getElementById('lightboxImg');

const closeLightbox = document.getElementById('closeLightbox');

/* OPEN LIGHTBOX */

cards.forEach(card => {

card.addEventListener('click', () => {

lightbox.classList.add('active');

lightboxImg.src = card.src;

});

});

/* CLOSE LIGHTBOX */

closeLightbox.addEventListener('click', () => {

lightbox.classList.remove('active');

});

/* CLOSE ON OUTSIDE CLICK */

lightbox.addEventListener('click', (e) => {

if(e.target !== lightboxImg){

lightbox.classList.remove('active');

}

});

</script>

</body>
</html>
<?php include "footer.php" ?>