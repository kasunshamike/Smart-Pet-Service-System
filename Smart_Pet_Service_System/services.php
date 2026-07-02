<?php
/**
 * Services — animated cards for four offerings with responsive visual imagery.
 */
$pageTitle = 'Services — Smart Pet Service System';
$activeNav = 'services';
require_once __DIR__ . '/includes/header.php';
?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="section-title display-5 mb-3">Our services</h1>
            <p class="section-sub mx-auto">Tailored experiences with playful energy and pro-level polish.</p>
        </div>
        
        <div class="row g-4">
            
            <!-- SERVICE 1: DOG WALKING -->
            <div class="col-md-6 col-xl-3" data-aos="fade-up">
                <article class="glass-card h-100 overflow-hidden d-flex flex-column bg-white border rounded-4 shadow-sm transition-all card-hover">
                    <!-- Service Imagery Asset Wrapper -->
                    <div class="position-relative w-100 overflow-hidden bg-light border-bottom" style="height: 180px;">
                        <img src="https://images.unsplash.com/photo-1544568100-847a948585b9?auto=format&fit=crop&q=80&w=600" alt="Dog Walking Service" class="w-100 h-100 img-zoom-effect" style="object-fit: cover;">
                        <div class="service-icon icon-walk position-absolute bottom-0 start-0 m-3 shadow"><i class="fa-solid fa-person-walking"></i></div>
                    </div>
                    <!-- Service Description Metadata Text -->
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h2 class="h4 fw-bold mb-3 text-dark">Dog Walking</h2>
                            <p class="text-muted small mb-4">Neighbourhood strolls with hydration checks, potty stops, and upbeat cardio for energetic pups.</p>
                        </div>
                        <a href="booking.php?service=Dog+Walking" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold mt-2">Book Visit</a>
                    </div>
                </article>
            </div>
            
            <!-- SERVICE 2: PET GROOMING -->
            <div class="col-md-6 col-xl-3" data-aos="fade-up" data-aos-delay="80">
                <article class="glass-card h-100 overflow-hidden d-flex flex-column bg-white border rounded-4 shadow-sm transition-all card-hover">
                    <!-- Service Imagery Asset Wrapper -->
                    <div class="position-relative w-100 overflow-hidden bg-light border-bottom" style="height: 180px;">
                        <img src="https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?auto=format&fit=crop&q=80&w=600" alt="Pet Grooming Service" class="w-100 h-100 img-zoom-effect" style="object-fit: cover;">
                        <div class="service-icon icon-groom position-absolute bottom-0 start-0 m-3 shadow"><i class="fa-solid fa-scissors"></i></div>
                    </div>
                    <!-- Service Description Metadata Text -->
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h2 class="h4 fw-bold mb-3 text-dark">Pet Grooming</h2>
                            <p class="text-muted small mb-4">Bath, brush, nail trims, and breed-aware styling — spa calm without the salon stress.</p>
                        </div>
                        <a href="booking.php?service=Pet+Grooming" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold mt-2">Book Session</a>
                    </div>
                </article>
            </div>
            
            <!-- SERVICE 3: PET BOARDING -->
            <div class="col-md-6 col-xl-3" data-aos="fade-up" data-aos-delay="160">
                <article class="glass-card h-100 overflow-hidden d-flex flex-column bg-white border rounded-4 shadow-sm transition-all card-hover">
                    <!-- Service Imagery Asset Wrapper -->
                    <div class="position-relative w-100 overflow-hidden bg-light border-bottom" style="height: 180px;">
                        <img src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?auto=format&fit=crop&q=80&w=600" alt="Pet Boarding Service" class="w-100 h-100 img-zoom-effect" style="object-fit: cover;">
                        <div class="service-icon icon-board position-absolute bottom-0 start-0 m-3 shadow"><i class="fa-solid fa-hotel"></i></div>
                    </div>
                    <!-- Service Description Metadata Text -->
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h2 class="h4 fw-bold mb-3 text-dark">Pet Boarding</h2>
                            <p class="text-muted small mb-4">Overnight stays with supervised play, cosy beds, and bedtime stories if that’s your ritual.</p>
                        </div>
                        <a href="booking.php?service=Pet+Boarding" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold mt-2">Book Stay</a>
                    </div>
                </article>
            </div>
            
            <!-- SERVICE 4: PET TRAINING -->
            <div class="col-md-6 col-xl-3" data-aos="fade-up" data-aos-delay="240">
                <article class="glass-card h-100 overflow-hidden d-flex flex-column bg-white border rounded-4 shadow-sm transition-all card-hover">
                    <!-- Service Imagery Asset Wrapper -->
                    <div class="position-relative w-100 overflow-hidden bg-light border-bottom" style="height: 180px;">
                        <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&q=80&w=600" alt="Pet Training Service" class="w-100 h-100 img-zoom-effect" style="object-fit: cover;">
                        <div class="service-icon icon-train position-absolute bottom-0 start-0 m-3 shadow"><i class="fa-solid fa-graduation-cap"></i></div>
                    </div>
                    <!-- Service Description Metadata Text -->
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h2 class="h4 fw-bold mb-3 text-dark">Pet Training</h2>
                            <p class="text-muted small mb-4">Positive reinforcement sessions for recall, leash manners, tricks, and shy pet confidence.</p>
                        </div>
                        <a href="booking.php?service=Pet+Training" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold mt-2">Book Class</a>
                    </div>
                </article>
            </div>
            
        </div>
        
        <!-- MAIN GENERIC CONTEXT SCHEDULER ENTRY CTA -->
        <div class="text-center mt-5" data-aos="zoom-in">
            <a href="booking.php" class="btn btn-gradient btn-lg rounded-pill px-5 btn-animate text-white fw-bold shadow-sm" style="background: linear-gradient(135deg, #6366f1, #4f46e5);"><i class="fa-solid fa-calendar-plus me-2"></i>Book a service</a>
        </div>
    </div>
</section>

<!-- Embedded styling classes to manage card-specific overlay badges and smooth magnification effects -->
<style>
.card-hover {
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
}
.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.08) !important;
}
.img-zoom-effect {
    transition: transform 0.5s ease;
}
.card-hover:hover .img-zoom-effect {
    transform: scale(1.06);
}
.service-icon {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #fff;
    color: #4f46e5;
    font-size: 1.1rem;
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>