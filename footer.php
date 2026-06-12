<?php include "includes/config.php"; ?>

<style>
/* ── Footer ── */
.footer {
    background: #1a1a1a;
    padding: 64px 40px 0;
    margin-top: 0;
}

/* ── Main grid: 4 columns ── */
.footer-container {
    display: grid;
    grid-template-columns: 1.6fr 1fr 1fr 1fr;
    gap: 48px;
    padding-bottom: 56px;
    border-bottom: 1px solid rgba(255,255,255,.08);
}

/* ── Brand column ── */
.footer-logo img {
    height: 56px;
    margin-bottom: 20px;
    display: block;
    /* invert logo so it shows on dark bg */
    filter: brightness(0) invert(1);
}

.footer-about p {
    font-size: 13.5px;
    line-height: 1.8;
    color: #aaa;
    margin-bottom: 28px;
    max-width: 300px;
}

/* Social icons */
.footer-social {
    display: flex;
    gap: 10px;
    margin-bottom: 28px;
}

.footer-social a {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,.15);
    background: transparent;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #aaa;
    font-size: 14px;
    text-decoration: none;
    transition: background .2s, color .2s, border-color .2s, transform .2s;
}

.footer-social a:hover {
    background: #57B847;
    border-color: #57B847;
    color: #fff;
    transform: translateY(-3px);
}

/* Catalog download button */
.footer-catalog {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    height: 42px;
    padding: 0 20px;
    background: #57B847;
    color: #fff;
    text-decoration: none;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    transition: background .2s, transform .2s;
}

.footer-catalog:hover {
    background: #45a337;
    color: #fff;
    transform: translateY(-2px);
}

.footer-catalog i { font-size: 14px; }

/* ── Column titles ── */
.footer-title {
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 24px;
}

/* ── Links ── */
.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.footer-links li a {
    text-decoration: none;
    color: #999;
    font-size: 14px;
    transition: color .2s, padding-left .2s;
}

.footer-links li a:hover {
    color: #57B847;
    padding-left: 6px;
}

/* ── Contact list ── */
.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.footer-contact li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 14px;
    color: #999;
    line-height: 1.6;
}

.footer-contact i {
    color: #57B847;
    font-size: 15px;
    margin-top: 2px;
    flex-shrink: 0;
}

.footer-contact a {
    color: #999;
    text-decoration: none;
    transition: color .2s;
}

.footer-contact a:hover { color: #57B847; }

/* ── Bottom bar ── */
.footer-bottom {
    padding: 22px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.footer-bottom p {
    font-size: 13px;
    color: #666;
}

.footer-bottom-links {
    display: flex;
    gap: 24px;
}

.footer-bottom-links a {
    text-decoration: none;
    color: #666;
    font-size: 13px;
    transition: color .2s;
}

.footer-bottom-links a:hover { color: #57B847; }

/* ── Responsive ── */
@media (max-width: 1100px) {
    .footer-container { grid-template-columns: 1fr 1fr; gap: 36px; }
}

@media (max-width: 768px) {
    .footer { padding: 48px 20px 0; }
    .footer-container { grid-template-columns: 1fr; gap: 32px; }
    .footer-bottom { flex-direction: column; text-align: center; gap: 12px; }
    .footer-bottom-links { justify-content: center; }
}
</style>

<footer class="footer">

    <div class="footer-container">

        <!-- ── Brand ── -->
        <div class="footer-about">
            <div class="footer-logo">
                <img src="<?= BASE_URL ?>Images/logo.png" alt="Royal Establishment">
            </div>
            <p>Royal Establishment is a trusted supplier of premium hospital furniture and medical equipment, delivering high-quality healthcare infrastructure solutions with reliability and excellence.</p>

            <div class="footer-social">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            </div>

            <a href="<?= BASE_URL ?>ROYAL ESTABLISHMENT pdf.pdf" download class="footer-catalog">
                <i class="fa-solid fa-file-arrow-down"></i>
                Download Catalog
            </a>
        </div>

        <!-- ── Quick Links ── -->
        <div>
            <h3 class="footer-title">Quick Links</h3>
            <ul class="footer-links">
                <li><a href="<?= BASE_URL ?>index.php">Home</a></li>
                <li><a href="<?= BASE_URL ?>about.php">About Us</a></li>
                <li><a href="<?= BASE_URL ?>products.php">Products</a></li>
                <li><a href="<?= BASE_URL ?>certificate.php">Certificates</a></li>
                <li><a href="<?= BASE_URL ?>infrastructure.php">Infrastructure</a></li>
                <li><a href="<?= BASE_URL ?>contact.php">Contact Us</a></li>
            </ul>
        </div>

        <!-- ── Our Expertise ── -->
        <div>
            <h3 class="footer-title">Our Expertise</h3>
            <ul class="footer-links">
                <li><a href="<?= BASE_URL ?>Hospital_Furniture.php">Hospital Furniture</a></li>
                <li><a href="<?= BASE_URL ?>Moduler_OT.php">Modular OT Solutions</a></li>
                <li><a href="<?= BASE_URL ?>Gas_Pipeline_Solution.php">Medical Gas Pipeline</a></li>
                <li><a href="<?= BASE_URL ?>Autoclaves.php">Autoclaves</a></li>
                <li><a href="<?= BASE_URL ?>BBR_Maintenance.php">Cold Room Solutions</a></li>
                <li><a href="<?= BASE_URL ?>Bio-medical_Equipment_Calibration.php">Calibration &amp; PMS</a></li>
            </ul>
        </div>

        <!-- ── Contact ── -->
        <div>
            <h3 class="footer-title">Contact</h3>
            <ul class="footer-contact">
                <li>
                    <i class="fa-solid fa-phone-volume"></i>
                    <a href="tel:+919876543210">+91 98765 43210</a>
                </li>
                <li>
                    <i class="fa-solid fa-envelope"></i>
                    <a href="mailto:info@royalestablishment.in">info@royalestablishment.in</a>
                </li>
                <li>
                    <i class="fa-solid fa-globe"></i>
                    <a href="#">www.royalestablishment.in</a>
                </li>
                <li>
                    <i class="fa-solid fa-clock"></i>
                    <span>Mon – Sat, 9:00 AM – 6:00 PM</span>
                </li>
            </ul>
        </div>

    </div>

    <!-- ── Bottom bar ── -->
    <div class="footer-bottom">
        <p>© <?= date('Y') ?> Royal Establishment. All Rights Reserved.</p>
        <div class="footer-bottom-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms &amp; Conditions</a>
            <a href="<?= BASE_URL ?>contact.php">Support</a>
        </div>
    </div>

</footer>
