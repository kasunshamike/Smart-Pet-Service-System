<?php
// 1. Enable Error Reporting to guarantee no blank page symptoms occur on fatal conditions
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/db/database.php';

$pdo = get_db();
$userId = $_SESSION['user_id'];
$errors = [];
$flashOk = false;

// Fetch the logged-in user's registration name to populate the Owner field automatically
$userStmt = $pdo->prepare('SELECT name FROM users WHERE id = :uid LIMIT 1');
$userStmt->execute([':uid' => $userId]);
$userData = $userStmt->fetch();
$registeredOwnerName = $userData ? $userData['name'] : '';

// Fetch registered pets for this user along with their uploaded image paths
$petStmt = $pdo->prepare('SELECT id, name, type, breed, image FROM pets WHERE user_id = :uid ORDER BY id DESC');
$petStmt->execute([':uid' => $userId]);
$myPets = $petStmt->fetchAll();

// Pricing map configuration tiers (Localized to Sri Lankan Rupees matching pricing.php)
$servicePricing = [
    'Dog Walking'   => 2900,
    'Pet Grooming'  => 5900,
    'Pet Boarding'  => 12900,
    'Pet Training'  => 5900
];

// Check if a service package was requested via the pricing page URL parameter link
$urlPreselectedService = $_GET['service'] ?? '';

$fields = [
    'pet_id'     => '',
    'owner_name' => $registeredOwnerName, // Automatically loaded default registration string
    'phone'      => '',
    'service'    => array_key_exists($urlPreselectedService, $servicePricing) ? $urlPreselectedService : '',
    'date'       => '',
    'message'    => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($fields as $key => $_v) {
        $fields[$key] = trim($_POST[$key] ?? '');
    }
    
    // Security override fallback: enforce the registration session name on server submission
    $fields['owner_name'] = $registeredOwnerName;

    if (empty($fields['pet_id'])) {
        $errors[] = 'Please select a registered pet profile to initialize booking.';
    }
    if (empty($fields['owner_name'])) {
        $errors[] = 'Owner profile identity context missing.';
    }
    if (empty($fields['phone']) || !preg_match('/^[\d\s\-+().]{10,}$/', $fields['phone'])) {
        $errors[] = 'Please enter a valid phone number (at least 10 digits).';
    }
    if (!array_key_exists($fields['service'], $servicePricing)) {
        $errors[] = 'Please choose an authorized service package tier.';
    }
    if (empty($fields['date'])) {
        $errors[] = 'Please choose a target calendar date placement.';
    }

    if (empty($errors)) {
        // Double-check ownership of selected companion entry
        $findPet = $pdo->prepare('SELECT name, type FROM pets WHERE id = :pid AND user_id = :uid');
        $findPet->execute([':pid' => $fields['pet_id'], ':uid' => $userId]);
        $petDetails = $findPet->fetch();

        if ($petDetails) {
            $stmt = $pdo->prepare(
                'INSERT INTO bookings (user_id, owner_name, phone, pet_name, pet_type, service, booking_date, message)
                 VALUES (:user_id, :owner_name, :phone, :pet_name, :pet_type, :service, :booking_date, :message)'
            );
            $stmt->execute([
                ':user_id'      => $userId,
                ':owner_name'   => $fields['owner_name'],
                ':phone'        => $fields['phone'],
                ':pet_name'     => $petDetails['name'],
                ':pet_type'     => $petDetails['type'],
                ':service'      => $fields['service'],
                ':booking_date' => $fields['date'],
                ':message'      => $fields['message'] === '' ? null : $fields['message'],
            ]);
            $flashOk = true;
            
            // Reset input form data states except original owner identification context string
            foreach (array_keys($fields) as $k) { 
                if ($k !== 'owner_name') { $fields[$k] = ''; } 
            }
        } else {
            $errors[] = 'Selected pet structural reference assignment is invalid.';
        }
    }
}

$pageTitle = 'Configure Appointment Booking — Smart Pet Service System';
$activeNav = 'booking';
require_once __DIR__ . '/includes/header.php';
?>

<section class="py-5 dashboard-bg">
    <div class="container">
        
        <div class="text-center mb-5">
            <h1 class="section-title display-6 mb-2"><i class="fa-solid fa-calendar-check text-primary me-2"></i>Schedule a Service</h1>
            <p class="text-muted">Tailor dynamic appointment modules for your companions safely.</p>
        </div>

        <?php if ($flashOk): ?>
            <div class="alert alert-success shadow border-0 rounded-4 p-3 mb-4 text-center">
                <i class="fa-solid fa-circle-check fs-4 me-2 align-middle"></i> 
                <strong>Appointment Scheduled Successfully!</strong> Review deployment details inside your <a href="dashboard.php" class="alert-link text-decoration-underline">User Dashboard Panel</a>.
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger shadow border-0 rounded-4 mb-4">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                <span class="fw-bold">Fix the following errors:</span>
                <ul class="mb-0 mt-1 ps-3 small">
                    <?php foreach ($errors as $msg): ?><li><?php echo htmlspecialchars($msg); ?></li><?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- STEP 1: COMPANION SELECTION GRID MATRIX -->
        <div class="glass-panel p-4 mb-4">
            <h2 class="h5 fw-bold mb-3"><i class="fa-solid fa-circle-1 text-primary me-2"></i>Step 1: Select a Registered Pet Profile</h2>
            
            <?php if (empty($myPets)): ?>
                <div class="text-center py-5 border rounded-4 bg-white bg-opacity-60">
                    <div class="fs-1 text-secondary opacity-50 mb-3"><i class="fa-solid fa-paw"></i></div>
                    <h3 class="h5 text-dark fw-bold">No Active Profiles Detected</h3>
                    <p class="text-muted small px-3 mb-4">You must first create a pet profile framework before linking scheduling records.</p>
                    <a href="pet_profile.php" class="btn btn-primary rounded-pill px-4"><i class="fa-solid fa-plus me-1"></i> Add Pet Profile Details Now</a>
                </div>
            <?php else: ?>
                <p class="text-muted small mb-3">Click on a card profile panel wrapper below to choose a pet.</p>
                <div class="row g-3">
                    <?php foreach ($myPets as $p): ?>
                        <div class="col-sm-6 col-md-4">
                            <div class="pet-select-card p-3 bg-white border rounded-4 shadow-sm position-relative transition-all" 
                                 data-id="<?php echo $p['id']; ?>"
                                 onclick="selectPetForBooking(this, '<?php echo $p['id']; ?>')" 
                                 style="cursor: pointer; border: 2px solid #e2e8f0;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center overflow-hidden bg-light border text-secondary" style="width: 46px; height: 46px; flex-shrink: 0;">
                                        <?php if (!empty($p['image']) && file_exists(__DIR__ . '/' . $p['image'])): ?>
                                            <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="Selector Thumbnail" class="w-100 h-100" style="object-fit: cover;">
                                        <?php else: ?>
                                            <i class="fa-solid <?php echo ($p['type'] === 'Cat') ? 'fa-cat' : (($p['type'] === 'Dog') ? 'fa-dog' : 'fa-paw'); ?> fs-5"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="overflow-hidden w-100">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h3 class="h6 fw-bold mb-0 text-dark text-truncate pet-display-name"><?php echo htmlspecialchars($p['name']); ?></h3>
                                            <i class="fa-solid fa-circle-check text-success select-checkmark opacity-0"></i>
                                        </div>
                                        <p class="small text-muted mb-0 text-truncate"><?php echo htmlspecialchars($p['breed'] ?: $p['type']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- STEP 2: FORM CONFIGURATION WITH LOCKDOWN ATTRIBUTES -->
        <!-- Form hidden by default unless a pet card is selected or pre-selected on correction loops -->
        <div class="row justify-content-center <?php echo (empty($fields['pet_id']) && empty($errors)) ? 'd-none' : ''; ?>" id="bookingFormSectionBlock">
            <div class="col-xl-12">
                <div class="glass-panel p-4 p-md-5">
                    <h2 class="h5 fw-bold mb-4 text-dark"><i class="fa-solid fa-circle-2 text-primary me-2"></i>Step 2: Provide Service Metadata Configuration</h2>
                    
                    <form method="post" action="booking.php" class="row g-4" autocomplete="off">
                        <input type="hidden" name="pet_id" id="hidden_pet_id" value="<?php echo htmlspecialchars($fields['pet_id']); ?>">
                        
                        <div class="col-12">
                            <div class="p-3 rounded-4 bg-primary bg-opacity-10 text-primary fw-semibold small border border-primary border-opacity-20">
                                <i class="fa-solid fa-paw me-2"></i>Active Profile Processing Assignment: <span id="targetPetDisplayLabel" class="text-dark fw-bold">None Selected</span>
                            </div>
                        </div>

                        <!-- Automatically Populated & Read-Only Registered User Name Input Field -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input class="form-control rounded-4 bg-light text-muted" type="text" id="owner_name" name="owner_name" placeholder="Owner Name" readonly required style="cursor: not-allowed; font-weight: 500;" value="<?php echo htmlspecialchars($fields['owner_name']); ?>">
                                <label for="owner_name"><i class="fa-regular fa-user me-1 text-secondary"></i> Owner Full Name (Account Linked)</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input class="form-control rounded-4" type="tel" id="phone" name="phone" placeholder="Phone Number" autocomplete="tel" required maxlength="40" value="<?php echo htmlspecialchars($fields['phone']); ?>">
                                <label for="phone"><i class="fa-solid fa-phone me-1 text-primary"></i> Contact Phone Number *</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select rounded-4" id="service" name="service" onchange="calculateLivePricingQuote()" required>
                                    <option value="" disabled <?php echo empty($fields['service']) ? 'selected' : ''; ?>>Choose Care Module Variant Package...</option>
                                    <?php foreach ($servicePricing as $name => $cost): ?>
                                        <option value="<?php echo htmlspecialchars($name); ?>" data-cost="<?php echo $cost; ?>" <?php echo $fields['service'] === $name ? ' selected' : ''; ?>>
                                            <?php echo htmlspecialchars($name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="service"><i class="fa-solid fa-sliders me-1 text-primary"></i> Requested Care Service *</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input class="form-control rounded-4" type="date" id="date" name="date" autocomplete="off" required min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($fields['date']); ?>">
                                <label for="date"><i class="fa-regular fa-calendar me-1 text-primary"></i> Execution Date Placement *</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control rounded-4" id="message" name="message" placeholder="Special Routine Notes" autocomplete="off" style="height: 120px" maxlength="2000"><?php echo htmlspecialchars($fields['message']); ?></textarea>
                                <label for="message"><i class="fa-regular fa-comment-dots me-1 text-primary"></i> Direct Handling, Dietary or Entry Instructions <span class="text-muted">(Optional)</span></label>
                            </div>
                        </div>

                        <!-- LIVE PRICE BILLING TIER VIEW WIDGET (SRI LANKAN RUPEES) -->
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-white border shadow-sm d-none" id="pricingSummationPanelContainer">
                                <h3 class="h6 fw-bold text-uppercase tracking-wider text-muted mb-3"><i class="fa-solid fa-receipt me-2 text-success"></i>Estimated Session Ledger Summary</h3>
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2 small">
                                    <span class="text-secondary" id="ledgerServiceLabel">Service Package Rate</span>
                                    <span class="fw-bold text-dark" id="ledgerCostLabel">Rs. 0</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-1">
                                    <span class="fw-bold text-dark fs-5">Total Due Invoicing:</span>
                                    <span class="text-primary fw-black display-6 fs-4" id="ledgerGrandTotalLabel" style="font-weight: 800;">Rs. 0</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-gradient btn-lg rounded-pill px-5 btn-animate text-white fw-bold shadow-sm"><i class="fa-solid fa-paper-plane me-2"></i>Authorize Appointment Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
// Format pricing figures cleanly with commas for Sri Lankan standard display
function formatLKR(amount) {
    return "Rs. " + Number(amount).toLocaleString('en-LK');
}

function selectPetForBooking(cardElement, petId) {
    document.querySelectorAll('.pet-select-card').forEach(card => {
        card.style.borderColor = '#e2e8f0';
        card.querySelector('.select-checkmark').classList.add('opacity-0');
        card.classList.remove('shadow');
    });

    cardElement.style.borderColor = '#6366f1'; 
    cardElement.querySelector('.select-checkmark').classList.remove('opacity-0');
    cardElement.classList.add('shadow');

    document.getElementById('hidden_pet_id').value = petId;
    
    const petName = cardElement.querySelector('.pet-display-name').textContent;
    document.getElementById('targetPetDisplayLabel').textContent = petName;

    const configurationFormBox = document.getElementById('bookingFormSectionBlock');
    configurationFormBox.classList.remove('d-none');
    configurationFormBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function calculateLivePricingQuote() {
    const selectorDropdown = document.getElementById('service');
    const chosenInstanceOption = selectorDropdown.options[selectorDropdown.selectedIndex];
    
    const calculationWidgetPanel = document.getElementById('pricingSummationPanelContainer');
    const serviceLabel = document.getElementById('ledgerServiceLabel');
    const textCostDisplay = document.getElementById('ledgerCostLabel');
    const grandTotalDisplay = document.getElementById('ledgerGrandTotalLabel');

    if (!chosenInstanceOption || !chosenInstanceOption.value) {
        calculationWidgetPanel.classList.add('d-none');
        return;
    }

    const calculatedPrice = chosenInstanceOption.getAttribute('data-cost');
    const formattedPrice = formatLKR(calculatedPrice);

    serviceLabel.textContent = chosenInstanceOption.value + " Base Session";
    textCostDisplay.textContent = formattedPrice;
    grandTotalDisplay.textContent = formattedPrice;

    calculationWidgetPanel.classList.remove('d-none');
}

document.addEventListener("DOMContentLoaded", function() {
    // Check if form holds pre-loaded validation states or a service passed through the pricing redirect
    const hiddenIdTrackerField = document.getElementById('hidden_pet_id');
    const serviceSelector = document.getElementById('service');
    
    if (hiddenIdTrackerField && hiddenIdTrackerField.value) {
        const activeCard = document.querySelector(`.pet-select-card[data-id="${hiddenIdTrackerField.value}"]`);
        if (activeCard) selectPetForBooking(activeCard, hiddenIdTrackerField.value);
    }
    
    // Trigger calculation directly if a package redirect selection is active
    if (serviceSelector && serviceSelector.value) {
        calculateLivePricingQuote();
        // Unhide form layout to streamline the user redirection flow 
        document.getElementById('bookingFormSectionBlock').classList.remove('d-none');
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>