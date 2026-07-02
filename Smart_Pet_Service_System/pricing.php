<?php
/**
 * Pricing — Three colourful animated tiers localized for Sri Lanka.
 */
$pageTitle = 'Pricing — Smart Pet Service System';
$activeNav = 'pricing';
require_once __DIR__ . '/includes/header.php';
?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="section-title display-5 mb-3">Plans for every tail</h1>
            <p class="section-sub mx-auto">Starter visits to full sparkle bundles — upgrade anytime.</p>
        </div>
        <div class="row g-4 justify-content-center align-items-stretch">
            
            <!-- BASIC TIER -->
            <div class="col-lg-4" data-aos="fade-up">
                <div class="pricing-card p-4 p-lg-5 h-100 d-flex flex-column bg-white border rounded-4 shadow-sm">
                    <p class="text-uppercase fw-bold text-muted small mb-2">Basic Plan</p>
                    <p class="price-tag mb-1 fw-black text-dark h1" style="font-weight: 800;">Rs. 2,900</p>
                    <p class="text-muted mb-4">per visit</p>
                    <ul class="list-unstyled flex-grow-1 small">
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>30-minute walk or drop-in</li>
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Fresh water &amp; feeding notes</li>
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>SMS / Text update</li>
                    </ul>
                    <!-- Pre-selects Dog Walking package via clean URL encoding string parameter -->
                    <a href="booking.php?service=Dog+Walking" class="btn btn-outline-primary rounded-pill fw-semibold mt-3 btn-animate">Book Now</a>
                </div>
            </div>
            
            <!-- STANDARD TIER (FEATURED) -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="120">
                <div class="pricing-card featured p-4 p-lg-5 h-100 d-flex flex-column bg-white border border-primary border-2 rounded-4 shadow">
                    <span class="badge text-white align-self-start rounded-pill px-3 mb-2" style="background: linear-gradient(90deg,#6366f1,#ec4899);">Popular</span>
                    <p class="text-uppercase fw-bold text-muted small mb-2">Standard Plan</p>
                    <p class="price-tag mb-1 fw-black text-primary h1" style="font-weight: 800;">Rs. 5,900</p>
                    <p class="text-muted mb-4">per session</p>
                    <ul class="list-unstyled flex-grow-1 small">
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>60-minute adventure walk</li>
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Grooming touch-up</li>
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Photo update bundle</li>
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Priority scheduling</li>
                    </ul>
                    <!-- Pre-selects Pet Grooming package directly via URL link query state hook -->
                    <a href="booking.php?service=Pet+Grooming" class="btn btn-gradient text-white rounded-pill fw-semibold mt-3 btn-animate" style="background: linear-gradient(135deg, #6366f1, #4f46e5);">Book Now</a>
                </div>
            </div>
            
            <!-- PREMIUM TIER -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="240">
                <div class="pricing-card p-4 p-lg-5 h-100 d-flex flex-column bg-white border rounded-4 shadow-sm">
                    <p class="text-uppercase fw-bold text-muted small mb-2">Premium Plan</p>
                    <p class="price-tag mb-1 fw-black text-dark h1" style="font-weight: 800;">Rs. 12,900</p>
                    <p class="text-muted mb-4">overnight bundle</p>
                    <ul class="list-unstyled flex-grow-1 small">
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>12-hour overnight boarding</li>
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Training tune-up</li>
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Luxury groom add-on</li>
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Pet concierge live chat</li>
                    </ul>
                    <!-- Pre-selects Pet Boarding package matching the billing configuration array exactly -->
                    <a href="booking.php?service=Pet+Boarding" class="btn btn-outline-primary rounded-pill fw-semibold mt-3 btn-animate">Book Now</a>
                </div>
            </div>
            
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>