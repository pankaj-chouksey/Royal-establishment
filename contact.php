<?php include "header.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Contact Us | Royal Establishment</title>

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
color:#111;
}

/* =========================
PAGE BANNER
========================= */

.contact-banner{
background:linear-gradient(rgba(0,0,0,.65),rgba(0,0,0,.65)),
url('https://images.unsplash.com/photo-1581093458791-9d42e0f2f0a1?q=80&w=1600');

background-size:cover;
background-position:center;

padding:120px 5%;
text-align:center;
color:#fff;
}

.contact-banner h1{
font-size:52px;
margin-bottom:15px;
font-weight:700;
}

.contact-banner p{
font-size:18px;
color:#ddd;
}

/* =========================
CONTACT SECTION
========================= */

.contact-section{
padding:90px 5%;
}

.contact-container{
display:grid;
grid-template-columns:1.1fr .9fr;
gap:40px;
align-items:start;
}

/* =========================
CONTACT FORM
========================= */

.contact-form-box{
background:#fff;
padding:45px;
border-radius:24px;
box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.section-title{
font-size:34px;
font-weight:700;
margin-bottom:15px;
color:#111;
}

.section-subtitle{
font-size:16px;
color:#666;
margin-bottom:35px;
line-height:1.7;
}

/* FORM */

.contact-form{
display:grid;
gap:22px;
}

.form-row{
display:grid;
grid-template-columns:1fr 1fr;
gap:20px;
}

.contact-form input,
.contact-form textarea{
width:100%;

padding:16px 20px;

border:2px solid #e5e5e5;
border-radius:14px;

font-size:15px;
outline:none;

transition:.3s;
}

.contact-form input:focus,
.contact-form textarea:focus{
border-color:#57B847;
}

.contact-form textarea{
height:160px;
resize:none;
}

/* BUTTON */

.submit-btn{
display:inline-flex;
align-items:center;
justify-content:center;
gap:10px;

height:58px;
padding:0 32px;

background:#57B847;
color:#fff;

border:none;
border-radius:50px;

font-size:16px;
font-weight:600;

cursor:pointer;
transition:.3s;
}

.submit-btn:hover{
background:#111;
transform:translateY(-3px);
}

/* =========================
CONTACT INFO
========================= */

.contact-info{
display:grid;
gap:24px;
}

/* CARD */

.info-card{
background:#fff;
padding:28px;
border-radius:22px;

box-shadow:0 10px 30px rgba(0,0,0,.08);

display:flex;
align-items:flex-start;
gap:18px;

transition:.3s;
}

.info-card:hover{
transform:translateY(-5px);
}

.info-icon{
width:62px;
height:62px;

border-radius:18px;
background:#57B847;

display:flex;
justify-content:center;
align-items:center;

flex-shrink:0;
}

.info-icon i{
font-size:24px;
color:#fff;
}

.info-content h3{
font-size:22px;
margin-bottom:10px;
color:#111;
}

.info-content p,
.info-content a{
font-size:15px;
line-height:1.8;
color:#666;
text-decoration:none;
}

/* =========================
SOCIAL ICONS
========================= */

.contact-social{
display:flex;
gap:12px;
margin-top:15px;
}

.contact-social a{
width:42px;
height:42px;

border-radius:50%;
background:#57B847;

display:flex;
justify-content:center;
align-items:center;

color:#fff;
text-decoration:none;

transition:.3s;
}

.contact-social a:hover{
background:#111;
transform:translateY(-4px);
}

/* =========================
MAP SECTION
========================= */

.map-section{
padding:0 5% 90px;
}

.map-box{
width:100%;
height:450px;

border-radius:28px;
overflow:hidden;

box-shadow:0 10px 30px rgba(0,0,0,.08);

border:3px solid #57B847;
}

.map-box iframe{
width:100%;
height:100%;
border:0;
}

/* =========================
RESPONSIVE
========================= */

@media(max-width:1100px){

.contact-container{
grid-template-columns:1fr;
}

}

@media(max-width:768px){

.contact-banner{
padding:90px 5%;
}

.contact-banner h1{
font-size:40px;
}

.contact-form-box{
padding:30px;
}

.form-row{
grid-template-columns:1fr;
}

.section-title{
font-size:28px;
}

.map-box{
height:320px;
}

}

</style>

</head>

<body>

<!-- =========================
BANNER
========================= -->

<section class="contact-banner">

<h1>Contact Us</h1>

<p>
Home / Contact Us
</p>

</section>

<!-- =========================
CONTACT SECTION
========================= -->

<section class="contact-section">

<div class="contact-container">

<!-- CONTACT FORM -->

<div class="contact-form-box">

<h2 class="section-title">
Get In Touch
</h2>

<p class="section-subtitle">

Feel free to contact Royal Establishment for any inquiries related
to hospital equipment, healthcare solutions, and business partnerships.

</p>

<form class="contact-form">

<div class="form-row">

<input type="text" placeholder="Your Name">

<input type="email" placeholder="Your Email">

</div>

<div class="form-row">

<input type="tel" placeholder="Phone Number">

<input type="text" placeholder="Subject">

</div>

<textarea placeholder="Write Your Message"></textarea>

<button type="submit" class="submit-btn">

<i class="fa-solid fa-paper-plane"></i>

Send Message

</button>

</form>

</div>

<!-- CONTACT INFO -->

<div class="contact-info">

<!-- CARD -->

<div class="info-card">

<div class="info-icon">
<i class="fa-solid fa-location-dot"></i>
</div>

<div class="info-content">

<h3>Office Address</h3>

<p>
PLOT/ SHED NO.48A, INDUSTRIAL AREA/GROWTH CENTRE, MSME ACHARPURA, BHOPAL, <br>
MADHYA PRADESH, INDIA
</p>

</div>

</div>

<!-- CARD -->

<div class="info-card">

<div class="info-icon">
<i class="fa-solid fa-phone-volume"></i>
</div>

<div class="info-content">

<h3>Phone Number</h3>

<p>+91 7000019954</p>

</div>

</div>

<!-- CARD -->

<div class="info-card">

<div class="info-icon">
<i class="fa-solid fa-envelope"></i>
</div>

<div class="info-content">

<h3>Email Address</h3>

<p>info@royalestablishment.com</p>

</div>

</div>

<!-- CARD -->

<div class="info-card">

<div class="info-icon">
<i class="fa-solid fa-globe"></i>
</div>

<div class="info-content">

<h3>Website</h3>

<a href="#">
www.royalestablishment.com
</a>

<div class="contact-social">

<a href="https://www.facebook.com/profile.php?id=61590323727679">
<i class="fab fa-facebook-f"></i>
</a>

<a href="https://www.instagram.com/royal_establishment/">
<i class="fab fa-instagram"></i>
</a>

<a href="https://www.linkedin.com/company/123414159/admin/dashboard/">
<i class="fab fa-linkedin-in"></i>
</a>

<!-- <a href="#">
<i class="fab fa-youtube"></i>
</a> -->

</div>

</div>

</div>

</div>

</div>

</section>

<!-- =========================
GOOGLE MAP
========================= -->

<section class="map-section">

<div class="map-box">

<iframe
src="https://www.google.com/maps?q=Bhopal&output=embed"
allowfullscreen=""
loading="lazy">
</iframe>

</div>

</section>

</body>
</html>
<?php include "footer.php" ?>