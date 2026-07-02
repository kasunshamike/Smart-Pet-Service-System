<?php
/**
 * Pet Actions Controller — Secure Deletions & File Purges from img/uploads/
 */
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/db/database.php';

$pdo = get_db();
$userId = $_SESSION['user_id'];

// Handle Record Deletion
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $petId = intval($_GET['id']);

    // Fetch image reference path before drop sequence
    $stmt = $pdo->prepare('SELECT image FROM pets WHERE id = :id AND user_id = :uid');
    $stmt->execute([':id' => $petId, ':uid' => $userId]);
    $pet = $stmt->fetch();

    if ($pet) {
        // Delete disk asset from img/uploads/ if it exists
        if (!empty($pet['image']) && file_exists(__DIR__ . '/' . $pet['image'])) {
            @unlink(__DIR__ . '/' . $pet['image']);
        }

        // Delete Database Entry Row Reference
        $deleteStmt = $pdo->prepare('DELETE FROM pets WHERE id = :id AND user_id = :uid');
        $deleteStmt->execute([':id' => $petId, ':uid' => $userId]);
    }
    
    header('Location: pet_profile.php?msg=deleted');
    exit;
}

header('Location: pet_profile.php');
exit;