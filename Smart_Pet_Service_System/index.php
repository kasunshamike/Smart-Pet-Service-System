<?php
/**
 * Home — hero, features, testimonials.
 */
$pageTitle = 'Trusted Pet Sitting Services — Smart Pet Service System';
$activeNav = 'home';
require_once __DIR__ . '/includes/header.php';
?>

<section class="container py-4 py-lg-5">
    <div class="hero-wrap px-3 px-md-5 py-5">
        <div class="float-layer" aria-hidden="true">
            <span class="float-shape s1"><i class="fa-solid fa-bone"></i></span>
            <span class="float-shape s2"><i class="fa-solid fa-paw"></i></span>
            <span class="float-shape s3"><i class="fa-solid fa-heart"></i></span>
        </div>
        <div class="row align-items-center hero-inner">
            <div class="col-lg-7 mb-5 mb-lg-0" data-aos="fade-right">
                <div class="hero-glass">
                    <p class="text-white-50 fw-semibold mb-2"><i class="fa-solid fa-wand-magic-sparkles me-2"></i>Premium care · Loving sitters</p>
                    <h1 class="display-4 hero-title mb-4">Trusted Pet Sitting Services</h1>
                    <p class="lead text-white mb-4 opacity-90">
                        Colourful days, cosy nights — walks, grooming, boarding, and training with updates that keep you smiling.
                    </p>
                    <div class="d-flex flex-wrap gap-3 hero-cta-wrap">
                        <!-- Smart Dynamic Action Button context switch depending on active user state -->
                        <?php if (!empty($_SESSION['user_id'])): ?>
                            <a href="pet_profile.php" class="btn btn-light btn-lg rounded-pill px-4 fw-semibold shadow btn-animate"><i class="fa-solid fa-shield-cat me-2"></i>Manage My Pets</a>
                        <?php else: ?>
                            <a href="register.php" class="btn btn-light btn-lg rounded-pill px-4 fw-semibold shadow btn-animate"><i class="fa-solid fa-feather me-2"></i>Get started</a>
                        <?php endif; ?>
                        <a href="booking.php" class="btn btn-outline-light btn-lg rounded-pill px-4 btn-animate"><i class="fa-regular fa-calendar-days me-2"></i>Book now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 text-center" data-aos="fade-left">
                <div class="position-relative">
                    <img src="./img/cat.jpeg" class="img-fluid rounded-4 shadow-lg border border-light border-3" alt="Happy dog">
                    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-n3 glass-card px-4 py-2 small fw-semibold text-dark">
                        <i class="fa-solid fa-star text-warning me-1"></i> 4.9 / 5 pet parent rating
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title display-6 mb-3">Why pets love us</h2>
            <p class="section-sub mx-auto">Soft schedules, loud wagging tails — modern pet care with heart and hustle.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                <div class="glass-card p-4 h-100 text-center">
                    <div class="service-icon icon-walk mx-auto"><i class="fa-solid fa-shield-heart"></i></div>
                    <h3 class="h5 fw-bold">Vetted sitters</h3>
                    <p class="text-muted small mb-0">Background-checked team trained for calm, confident visits.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="glass-card p-4 h-100 text-center">
                    <div class="service-icon icon-groom mx-auto"><i class="fa-solid fa-bell"></i></div>
                    <h3 class="h5 fw-bold">Live updates</h3>
                    <p class="text-muted small mb-0">Photos and notes after every walk or drop-in.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="glass-card p-4 h-100 text-center">
                    <div class="service-icon icon-board mx-auto"><i class="fa-solid fa-house-chimney"></i></div>
                    <h3 class="h5 fw-bold">Home routines</h3>
                    <p class="text-muted small mb-0">Feeding charts, meds, and favourite toys — always respected.</p>
                </div>
            </div>
            <!-- Replaced feature card column focusing layout specifically on Pet Profile utility mapping -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <a href="pet_profile.php" class="text-decoration-none text-dark h-100 d-block">
                    <div class="glass-card p-4 h-100 text-center border border-primary border-opacity-10 position-relative">
                        <div class="service-icon icon-train mx-auto"><i class="fa-solid fa-id-card-clip"></i></div>
                        <h3 class="h5 fw-bold">Smart Pet Profiles</h3>
                        <p class="text-muted small mb-0">Store custom dietary rules, medical triggers, quirks, and photos effortlessly.</p>
                        <span class="d-block mt-2 text-primary small fw-semibold">Configure profiles <i class="fa-solid fa-arrow-right scale-sm ms-1"></i></span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-transparent">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title display-6 mb-3">Happy tails · honest words</h2>
            <p class="section-sub mx-auto">Stories from families who finally took that vacation stress-free.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4" data-aos="zoom-in-up">
                <div class="testimonial-card p-4 h-100">
                    <div class="text-warning mb-2"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="mb-4">“Boarding felt like a puppy holiday — daily clips of Olive playing made our trip!”</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=120&q=80" class="rounded-circle" width="48" height="48" alt="">
                        <div><strong>Maya L.</strong><br><span class="small text-muted">Cat &amp; dog parent</span></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="zoom-in-up" data-aos-delay="100">
                <div class="testimonial-card p-4 h-100">
                    <div class="text-warning mb-2"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></div>
                    <p class="mb-4">“Grooming day is now spa day — fluffy, shiny, and ridiculously cute photos.”</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80" class="rounded-circle" width="48" height="48" alt="">
                        <div><strong>Jordan P.</strong><br><span class="small text-muted">Poodle crew</span></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="zoom-in-up" data-aos-delay="200">
                <div class="testimonial-card p-4 h-100">
                    <div class="text-warning mb-2"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="mb-4">“Training sessions turned chaos into cues — our rescue finally heels on busy streets.”</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=120&q=80" class="rounded-circle" width="48" height="48" alt="">
                        <div><strong>Ava R.</strong><br><span class="small text-muted">Rescue advocate</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container text-center" data-aos="fade-up">
        <div class="glass-panel p-5">
            <h2 class="section-title h3 mb-3">Ready when you are</h2>
            <p class="text-muted mb-4">Create a free account to book colourful care in minutes.</p>
            <a href="register.php" class="btn btn-gradient btn-lg rounded-pill px-5 btn-animate">Join Smart Pet Service System</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>