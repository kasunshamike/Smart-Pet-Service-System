<?php
/**
 * Dashboard Panel — Smart Pet Service System Suite
 */
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/db/database.php';

$pdo = get_db();
$userId = $_SESSION['user_id'];

// 1. Fetch User Companions Metrics and Profile Data
$petStmt = $pdo->prepare('SELECT * FROM pets WHERE user_id = :uid ORDER BY id DESC');
$petStmt->execute([':uid' => $userId]);
$registeredPets = $petStmt->fetchAll();
$totalPets = count($registeredPets);

// 2. Fetch User Recent Bookings Data Log Match Fleet
$bookingStmt = $pdo->prepare('SELECT * FROM bookings WHERE user_id = :uid ORDER BY id DESC');
$bookingStmt->execute([':uid' => $userId]);
$myBookings = $bookingStmt->fetchAll();
$totalBookings = count($myBookings);

$pageTitle = 'Dashboard — Smart Pet Service System';
$activeNav = 'dashboard';
require_once __DIR__ . '/includes/header.php';
?>

<section class="py-5 dashboard-bg">
    <div class="container">
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5" data-aos="fade-up">
            <div>
                <h1 class="display-6 fw-black text-dark mb-1" style="font-weight: 800;">Welcome Back!</h1>
                <p class="text-muted mb-0">Logged in securely as <strong class="text-primary"><?php echo htmlspecialchars($_SESSION['user_email'] ?? $_SESSION['user']); ?></strong></p>
            </div>
            <div class="mt-3 mt-md-0 d-flex gap-2">
                <a href="booking.php" class="btn btn-gradient rounded-pill px-4 fw-bold text-white shadow-sm btn-animate"><i class="fa-solid fa-calendar-plus me-2"></i>New Booking</a>
                <a href="pet_profile.php" class="btn btn-outline-primary rounded-pill px-4 fw-bold bg-white shadow-sm"><i class="fa-solid fa-plus me-2"></i>Add Companion</a>
            </div>
        </div>

        <div class="row g-4 mb-5" data-aos="fade-up" data-aos-delay="100">
            <div class="col-xl-3 col-sm-6">
                <div class="p-4 rounded-4 bg-white border shadow-sm h-100 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; flex-shrink: 0;">
                        <i class="fa-solid fa-paw fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small text-uppercase tracking-wider fw-bold mb-0">My Pets Fleet</p>
                        <h3 class="h2 text-dark fw-black mb-0" style="font-weight: 800;"><?php echo $totalPets; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="p-4 rounded-4 bg-white border shadow-sm h-100 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; flex-shrink: 0;">
                        <i class="fa-solid fa-receipt fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small text-uppercase tracking-wider fw-bold mb-0">Total Orders</p>
                        <h3 class="h2 text-dark fw-black mb-0" style="font-weight: 800;"><?php echo $totalBookings; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="p-4 rounded-4 bg-white border shadow-sm h-100 d-flex align-items-center gap-3">
                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; flex-shrink: 0;">
                        <i class="fa-solid fa-shield-cat fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small text-uppercase tracking-wider fw-bold mb-0">Protection Status</p>
                        <h3 class="h6 text-success fw-bold mb-0 mt-1"><i class="fa-solid fa-circle-check me-1"></i>Active Secure</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="p-4 rounded-4 bg-white border shadow-sm h-100 d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; flex-shrink: 0;">
                        <i class="fa-solid fa-headset fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small text-uppercase tracking-wider fw-bold mb-0">Care Support</p>
                        <a href="contact.php" class="small text-primary text-decoration-underline fw-semibold d-block mt-1">Open Priority Chat</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            
            <div class="col-12" data-aos="fade-up" data-aos-delay="200">
                <div class="glass-panel p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h5 fw-bold text-dark mb-0"><i class="fa-solid fa-shield-dog text-primary me-2"></i>My Registered Companions</h2>
                        <a href="pet_profile.php" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold"><i class="fa-solid fa-gear me-1"></i>Manage Profiles</a>
                    </div>

                    <?php if (empty($registeredPets)): ?>
                        <div class="text-center py-4 border rounded-4 bg-white bg-opacity-50">
                            <p class="text-muted small mb-0">No active profile sets detected. Head over to the profiles page to get started!</p>
                        </div>
                    <?php else: ?>
                        <div class="row g-3">
                            <?php foreach ($registeredPets as $p): ?>
                                <div class="col-md-4 col-sm-6">
                                    <div class="p-3 bg-white border rounded-4 shadow-sm d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center overflow-hidden bg-light border text-secondary shadow-inner" style="width: 52px; height: 52px; flex-shrink: 0;">
                                            <?php if (!empty($p['image']) && file_exists(__DIR__ . '/' . $p['image'])): ?>
                                                <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="Pet Thumbnail" class="w-100 h-100" style="object-fit: cover;">
                                            <?php else: ?>
                                                <i class="fa-solid <?php echo ($p['type'] === 'Cat') ? 'fa-cat' : (($p['type'] === 'Dog') ? 'fa-dog' : 'fa-paw'); ?> fs-5 opacity-40"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="overflow-hidden w-100">
                                            <h3 class="h6 text-dark fw-bold mb-0 text-truncate"><?php echo htmlspecialchars($p['name']); ?></h3>
                                            <p class="small text-muted mb-0 text-truncate"><?php echo htmlspecialchars($p['breed'] ?: $p['type']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-12" data-aos="fade-up" data-aos-delay="300">
                <div class="glass-panel p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h5 fw-bold text-dark mb-0"><i class="fa-regular fa-folder-open text-primary me-2"></i>Recent Appointment Bookings Ledger</h2>
                        <a href="booking.php" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold text-white shadow-sm">Schedule Another Visit</a>
                    </div>

                    <?php if (empty($myBookings)): ?>
                        <div class="text-center py-5 border rounded-4 bg-white bg-opacity-40">
                            <div class="fs-2 text-muted opacity-30 mb-2"><i class="fa-solid fa-calendar-xmark"></i></div>
                            <h3 class="h6 text-secondary fw-bold mb-1">No Active Appointments Placed</h3>
                            <p class="text-muted small mb-0 text-center px-3">You don't have any appointments set up right now. Click the button above to schedule your first visit!</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 custom-dashboard-table">
                                <thead class="table-light text-uppercase font-monospace small" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                    <tr>
                                        <th scope="col" class="border-0 ps-3">Companion Name</th>
                                        <th scope="col" class="border-0">Assigned Service</th>
                                        <th scope="col" class="border-0">Execution Target Date</th>
                                        <th scope="col" class="border-0">Client Contact Phone</th>
                                        <th scope="col" class="border-0 pe-3">Direct Handling Instructions</th>
                                    </tr>
                                </thead>
                                <tbody class="small border-top-0">
                                    <?php foreach ($myBookings as $b): ?>
                                        <tr>
                                            <td class="fw-bold text-dark ps-3">
                                                <i class="fa-solid fa-bone text-primary opacity-50 me-2"></i><?php echo htmlspecialchars($b['pet_name']); ?>
                                                <span class="badge bg-light text-secondary border rounded-pill font-monospace fw-normal ms-1" style="font-size: 0.65rem;"><?php echo htmlspecialchars($b['pet_type']); ?></span>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill px-3 py-1 fw-bold text-white shadow-xs" style="background: linear-gradient(135deg, #6366f1, #4f46e5); font-size: 0.75rem;">
                                                    <?php echo htmlspecialchars($b['service']); ?>
                                                </span>
                                            </td>
                                            <td class="text-dark font-monospace fw-semibold">
                                                <i class="fa-regular fa-calendar-check text-success me-1"></i><?php echo htmlspecialchars($b['booking_date']); ?>
                                            </td>
                                            <td class="text-secondary font-monospace">
                                                <?php echo htmlspecialchars($b['phone']); ?>
                                            </td>
                                            <td class="text-muted text-truncate pe-3" style="max-width: 240px;" title="<?php echo htmlspecialchars($b['message'] ?? ''); ?>">
                                                <?php echo !empty($b['message']) ? htmlspecialchars($b['message']) : '<span class="text-opacity-40 italic small">— No Special Notes Provided —</span>'; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </div>
</section>

<style>
.custom-dashboard-table tbody tr {
    transition: all 0.2s ease-in-out;
}
.custom-dashboard-table tbody tr:hover {
    background-color: rgba(99, 102, 241, 0.03) !important;
}
.shadow-inner {
    box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>