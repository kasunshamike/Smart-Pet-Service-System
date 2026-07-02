</main>
<footer class="site-footer text-white mt-auto">
    <div class="footer-gradient py-5">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6 text-center text-lg-start" data-aos="fade-up">
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-2 mb-3">
                        <span class="brand-icon footer-brand"><i class="fa-solid fa-paw"></i></span>
                        <span class="fs-4 fw-bold">Smart Pet Service System</span>
                    </div>
                    <p class="text-white-50 mb-0 small">Trusted pet sitting for busy families — colourful care, calm pets, happy tails.</p>
                </div>
                <div class="col-lg-6 text-center text-lg-end" data-aos="fade-up" data-aos-delay="100">
                    <p class="small text-white-50 mb-2">Follow us</p>
                    <div class="social-icons justify-content-center justify-content-lg-end">
                        <a href="#" class="social-btn" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="social-btn" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="social-btn" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="social-btn" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary opacity-25 my-4">
            <p class="text-center small text-white-50 mb-0">&copy; <?php echo date('Y'); ?> Smart Pet Service System</p>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<?php
// Resolve JS path from admin subfolder
$jsBase = (basename(dirname($_SERVER['SCRIPT_FILENAME'])) === 'admin') ? '../' : '';
?>
<script src="<?php echo $jsBase; ?>js/animations.js"></script>
</body>
</html>
