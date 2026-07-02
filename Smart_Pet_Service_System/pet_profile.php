<?php
/**
 * Pet Profile Dashboard Manager — Secure CRUD with Existing img/ Folder Integration
 */
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/db/database.php';

$pdo = get_db();
$userId = $_SESSION['user_id'];
$errors = [];
$successMessage = '';

// Setup Target Path to use your existing img/ folder
$uploadDir = __DIR__ . '/img/uploads/';

// Check for URL-based message triggers
if (($htmlGetMsg = $_GET['msg'] ?? '') === 'deleted') {
    $successMessage = 'Pet profile tracking data dropped successfully.';
}

// Capture Editing Targets Mode Routing Parameters
$editMode = false;
$editPetId = null;
$fields = ['name' => '', 'type' => 'Dog', 'breed' => ''];

if (isset($_GET['edit_id'])) {
    $editPetId = intval($_GET['edit_id']);
    $editStmt = $pdo->prepare('SELECT * FROM pets WHERE id = :id AND user_id = :uid');
    $editStmt->execute([':id' => $editPetId, ':uid' => $userId]);
    $currentPetData = $editStmt->fetch();

    if ($currentPetData) {
        $editMode = true;
        $fields['name'] = $currentPetData['name'];
        $fields['type'] = $currentPetData['type'];
        $fields['breed'] = $currentPetData['breed'];
    }
}

// Process Submission Data Loops
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields['name'] = trim($_POST['name'] ?? '');
    $fields['type'] = trim($_POST['type'] ?? 'Dog');
    $fields['breed'] = trim($_POST['breed'] ?? '');
    
    if (empty($fields['name']) || strlen($fields['name']) < 2) {
        $errors[] = 'Please provide a valid companion tracking name label context.';
    }

    // Process Upload File Object Matrix into img/ folder
    $imagePathResult = null;
    if (isset($_FILES['pet_photo']) && $_FILES['pet_photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['pet_photo']['tmp_name'];
        $fileName = $_FILES['pet_photo']['name'];
        $fileSize = $_FILES['pet_photo']['size'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            $errors[] = 'Invalid image extension pattern. Please upload JPG, PNG, or WEBP only.';
        } elseif ($fileSize > 3 * 1024 * 1024) { // 3MB Limit
            $errors[] = 'File scale bounds exceeded limit payload restrictions (Max 3MB).';
        } else {
            // Generate a unique file name to avoid namespace collisions in your img/ folder
            $newFileName = uniqid('pet_', true) . '.' . $fileExtension;
            $destFileAbsolutePath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destFileAbsolutePath)) {
                $imagePathResult = 'img/uploads/' . $newFileName; // Relative path stored in database
            } else {
                $errors[] = 'File target location storage writing stream failure occurred.';
            }
        }
    }

    if (empty($errors)) {
        if ($editMode) {
            // Update Existing Profile Context Setup
            if ($imagePathResult) {
                // Purge old historical profile image from your img/ folder to prevent clutter
                $oldImgStmt = $pdo->prepare('SELECT image FROM pets WHERE id = :id AND user_id = :uid');
                $oldImgStmt->execute([':id' => $editPetId, ':uid' => $userId]);
                $oldImgPath = $oldImgStmt->fetchColumn();
                if (!empty($oldImgPath) && file_exists(__DIR__ . '/' . $oldImgPath)) {
                    @unlink(__DIR__ . '/' . $oldImgPath);
                }

                $updateSql = 'UPDATE pets SET name = :name, type = :type, breed = :breed, image = :img WHERE id = :id AND user_id = :uid';
                $bindParams = [':name' => $fields['name'], ':type' => $fields['type'], ':breed' => $fields['breed'], ':img' => $imagePathResult, ':id' => $editPetId, ':uid' => $userId];
            } else {
                $updateSql = 'UPDATE pets SET name = :name, type = :type, breed = :breed WHERE id = :id AND user_id = :uid';
                $bindParams = [':name' => $fields['name'], ':type' => $fields['type'], ':breed' => $fields['breed'], ':id' => $editPetId, ':uid' => $userId];
            }
            $stmt = $pdo->prepare($updateSql);
            $stmt->execute($bindParams);
            $successMessage = 'Pet record structure properties changed successfully.';
            $editMode = false;
        } else {
            // Write Fresh Instance Record Row Setup
            $stmt = $pdo->prepare('INSERT INTO pets (user_id, name, type, breed, image) VALUES (:uid, :name, :type, :breed, :img)');
            $stmt->execute([
                ':uid'   => $userId,
                ':name'  => $fields['name'],
                ':type'  => $fields['type'],
                ':breed' => $fields['breed'],
                ':img'   => $imagePathResult
            ]);
            $successMessage = 'New companion data layout structure registered successfully.';
        }

        // Reset fields array reference parameters
        $fields = ['name' => '', 'type' => 'Dog', 'breed' => ''];
    }
}

// Collect total historical listing profile sets for validation views
$listStmt = $pdo->prepare('SELECT * FROM pets WHERE user_id = :uid ORDER BY id DESC');
$listStmt->execute([':uid' => $userId]);
$registeredPets = $listStmt->fetchAll();

$pageTitle = 'Manage Companions Profiles Framework — Admin Suite';
$activeNav = 'pets';
require_once __DIR__ . '/includes/header.php';
?>

<section class="py-5 dashboard-bg">
    <div class="container">
        
        <div class="text-center mb-5">
            <h1 class="section-title display-6 mb-2"><i class="fa-solid fa-paw text-primary me-2"></i>My Family Companions</h1>
            <p class="text-muted">Register structural database mapping context identities with file attachments profiles safely.</p>
        </div>

        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success shadow border-0 rounded-4 p-3 mb-4 text-center">
                <i class="fa-solid fa-circle-check fs-5 me-2 align-middle"></i> <strong>Operation Complete:</strong> <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger shadow border-0 rounded-4 mb-4">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                <span class="fw-bold">Fix processing constraints variables:</span>
                <ul class="mb-0 mt-1 ps-3 small">
                    <?php foreach ($errors as $msg): ?><li><?php echo htmlspecialchars($msg); ?></li><?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="glass-panel p-4 sticky-top" style="top: 2rem; z-index: 10;">
                    <h2 class="h5 fw-bold text-dark mb-3">
                        <i class="fa-solid <?php echo $editMode ? 'fa-pen-to-square text-warning' : 'fa-circle-plus text-primary'; ?> me-2"></i>
                        <?php echo $editMode ? 'Edit Target Companion' : 'Register New Companion'; ?>
                    </h2>
                    
                    <form method="post" action="pet_profile.php<?php echo $editMode ? '?edit_id=' . $editPetId : ''; ?>" enctype="multipart/form-data" autocomplete="off">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary" for="name">Pet Name *</label>
                            <input class="form-control rounded-4" type="text" id="name" name="name" required placeholder="e.g., Milo" autocomplete="off" value="<?php echo htmlspecialchars($fields['name']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary" for="type">Species Group Class Category *</label>
                            <select class="form-select rounded-4" id="type" name="type" required>
                                <option value="Dog" <?php echo $fields['type'] === 'Dog' ? 'selected' : ''; ?>>Dog Canine Unit</option>
                                <option value="Cat" <?php echo $fields['type'] === 'Cat' ? 'selected' : ''; ?>>Cat Feline Unit</option>
                                <option value="Bird" <?php echo $fields['type'] === 'Bird' ? 'selected' : ''; ?>>Bird Avian Unit</option>
                                <option value="Other" <?php echo $fields['type'] === 'Other' ? 'selected' : ''; ?>>Other Special Variant</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary" for="breed">Breed Framework Strain Information</label>
                            <input class="form-control rounded-4" type="text" id="breed" name="breed" placeholder="e.g., Golden Retriever" autocomplete="off" value="<?php echo htmlspecialchars($fields['breed']); ?>">
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary" for="pet_photo">Profile Photograph File Attachment</label>
                            <input class="form-control rounded-4 small" type="file" id="pet_photo" name="pet_photo" accept="image/png, image/jpeg, image/jpg, image/webp">
                            <div class="form-text text-muted" style="font-size: 0.75rem;">Saving straight to your <code>img/uploads</code> directory. Supported: JPG, PNG, WEBP (Max: 3MB).</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn <?php echo $editMode ? 'btn-warning' : 'btn-primary'; ?> rounded-pill fw-bold text-white shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i><?php echo $editMode ? 'Apply Updates Change' : 'Commit Registration'; ?>
                            </button>
                            <?php if ($editMode): ?>
                                <a href="pet_profile.php" class="btn btn-light rounded-pill btn-sm text-secondary border">Cancel Adjustments</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="glass-panel p-4">
                    <h2 class="h5 fw-bold text-dark mb-4"><i class="fa-solid fa-list text-primary me-2"></i>Active Registered Profiles Data Fleet</h2>

                    <?php if (empty($registeredPets)): ?>
                        <div class="text-center py-5 border rounded-4 bg-white bg-opacity-40">
                            <div class="fs-1 text-muted opacity-40 mb-2"><i class="fa-solid fa-folder-open"></i></div>
                            <h3 class="h6 text-secondary fw-bold">No Records Managed Yet</h3>
                            <p class="text-muted small mb-0">Use the left input deployment block parameters panel to register information frameworks directly.</p>
                        </div>
                    <?php else: ?>
                        <div class="row g-3">
                            <?php foreach ($registeredPets as $p): ?>
                                <div class="col-md-6">
                                    <div class="card h-100 border rounded-4 shadow-sm overflow-hidden bg-white">
                                        <div class="position-relative bg-light text-center d-flex align-items-center justify-content-center overflow-hidden" style="height: 160px; border-bottom: 1px solid #f1f5f9;">
                                            <?php if (!empty($p['image']) && file_exists(__DIR__ . '/' . $p['image'])): ?>
                                                <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="Pet Photo" class="w-100 h-100" style="object-fit: cover;">
                                            <?php else: ?>
                                                <div class="text-secondary opacity-20 display-4">
                                                    <i class="fa-solid <?php echo ($p['type'] === 'Cat') ? 'fa-cat' : (($p['type'] === 'Dog') ? 'fa-dog' : 'fa-paw'); ?>"></i>
                                                </div>
                                            <?php endif; ?>
                                            <span class="position-absolute badge bg-dark bg-opacity-70 text-white rounded-pill px-2 py-1 small" style="font-size: 0.7rem; letter-spacing: 0.5px; right: 10px; top: 10px;">
                                                <?php echo htmlspecialchars($p['type']); ?>
                                            </span>
                                        </div>

                                        <div class="p-3">
                                            <h3 class="h5 fw-black text-dark text-truncate mb-1" style="font-weight: 700;"><?php echo htmlspecialchars($p['name']); ?></h3>
                                            <p class="small text-muted mb-3 text-truncate">
                                                <i class="fa-solid fa-dna text-primary opacity-50 me-1"></i>
                                                <?php echo empty($p['breed']) ? 'Unspecified Variant Strain' : htmlspecialchars($p['breed']); ?>
                                            </p>

                                            <div class="d-flex justify-content-between align-items-center border-top pt-2 mt-2">
                                                <a href="pet_profile.php?edit_id=<?php echo $p['id']; ?>" class="btn btn-outline-warning btn-sm rounded-pill px-3 fw-bold" style="font-size: 0.8rem;">
                                                    <i class="fa-regular fa-pen-to-square me-1"></i>Edit
                                                </a>
                                                <a href="pet_actions.php?action=delete&id=<?php echo $p['id']; ?>" 
                                                   class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold" 
                                                   style="font-size: 0.8rem;" 
                                                   onclick="return confirm('Are you sure you want to delete this pet profile? This will delete its associated image from your img/ directory and cannot be undone.');">
                                                    <i class="fa-regular fa-trash-can me-1"></i>Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>