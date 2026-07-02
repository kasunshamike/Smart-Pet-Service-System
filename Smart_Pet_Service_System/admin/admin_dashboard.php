<?php
/**
 * Admin dashboard — stats, users, bookings (delete), contact messages.
 */
require_once __DIR__ . '/../includes/admin_auth.php';
require_once __DIR__ . '/../db/database.php';

$pdo = get_db();
$flash = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_booking_id'])) {
    $bid = filter_var($_POST['delete_booking_id'], FILTER_VALIDATE_INT);
    if ($bid && $bid > 0) {
        $del = $pdo->prepare('DELETE FROM bookings WHERE id = :id');
        $del->execute([':id' => $bid]);
        $flash = $del->rowCount() ? 'Booking #' . $bid . ' deleted.' : 'No booking removed.';
    }
}

$userCount = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$bookingCount = (int) $pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn();
$contactCount = (int) $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();

$users = $pdo->query('SELECT id, name, email, created_at FROM users ORDER BY id ASC')->fetchAll();
$sqlBookings = 'SELECT b.*, u.email AS user_email, u.name AS user_name
                FROM bookings b INNER JOIN users u ON u.id = b.user_id
                ORDER BY b.booking_date DESC, b.id DESC';
$bookings = $pdo->query($sqlBookings)->fetchAll();
$contacts = $pdo->query('SELECT id, name, email, message, created_at FROM contacts ORDER BY created_at DESC')->fetchAll();

$pageTitle = 'Overview — Admin';
require_once __DIR__ . '/../includes/admin_layout_start.php';
?>

<?php if ($flash !== ''): ?>
    <div class="alert alert-info shadow-sm rounded-3"><?php echo htmlspecialchars($flash); ?></div>
<?php endif; ?>

<div class="row g-3 mb-4">
    <div class="col-md-4" data-aos="fade-up">
        <div class="card p-3 border-0 shadow-sm h-100 border-start border-4 border-primary">
            <small class="text-muted text-uppercase fw-bold">Users</small>
            <p class="display-6 fw-bold mb-0"><?php echo $userCount; ?></p>
        </div>
    </div>
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="50">
        <div class="card p-3 border-0 shadow-sm h-100 border-start border-4 border-success">
            <small class="text-muted text-uppercase fw-bold">Bookings</small>
            <p class="display-6 fw-bold mb-0"><?php echo $bookingCount; ?></p>
        </div>
    </div>
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card p-3 border-0 shadow-sm h-100 border-start border-4 border-warning">
            <small class="text-muted text-uppercase fw-bold">Messages</small>
            <p class="display-6 fw-bold mb-0"><?php echo $contactCount; ?></p>
        </div>
    </div>
</div>

<section id="section-users" class="mb-5">
    <div class="card" data-aos="fade-up">
        <div class="card-header bg-white fw-bold py-3"><i class="fa-solid fa-users text-primary me-2"></i>Registered users</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-light small">
                    <tr><th>#</th><th>Name</th><th>Email</th><th>Joined</th></tr>
                    </thead>
                    <tbody>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="4" class="text-muted p-4">No users yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?php echo (int) $u['id']; ?></td>
                                <td><?php echo htmlspecialchars($u['name']); ?></td>
                                <td><?php echo htmlspecialchars($u['email']); ?></td>
                                <td class="small"><?php echo htmlspecialchars($u['created_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<section id="section-bookings" class="mb-5">
    <div class="card" data-aos="fade-up">
        <div class="card-header bg-white fw-bold py-3"><i class="fa-solid fa-calendar-check text-success me-2"></i>All bookings</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-striped mb-0 align-middle">
                    <thead class="table-dark small">
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Owner</th>
                        <th>Phone</th>
                        <th>Pet</th>
                        <th>Type</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Note</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($bookings)): ?>
                        <tr><td colspan="10" class="text-muted p-4">No bookings.</td></tr>
                    <?php else: ?>
                        <?php foreach ($bookings as $b): ?>
                            <tr>
                                <td><?php echo (int) $b['id']; ?></td>
                                <td><small><?php echo htmlspecialchars($b['user_name']); ?><br><span class="text-muted"><?php echo htmlspecialchars($b['user_email']); ?></span></small></td>
                                <td><?php echo htmlspecialchars($b['owner_name']); ?></td>
                                <td><?php echo htmlspecialchars($b['phone']); ?></td>
                                <td><?php echo htmlspecialchars($b['pet_name']); ?></td>
                                <td><?php echo htmlspecialchars($b['pet_type']); ?></td>
                                <td><?php echo htmlspecialchars($b['service']); ?></td>
                                <td><?php echo htmlspecialchars($b['booking_date']); ?></td>
                                <td><small><?php
                                    $mp = (string) ($b['message'] ?? '');
                                    echo htmlspecialchars(strlen($mp) > 40 ? substr($mp, 0, 40) . '…' : $mp);
                                ?></small></td>
                                <td>
                                    <form method="post" action="admin_dashboard.php#section-bookings" class="d-inline" onsubmit="return confirm('Delete this booking?');">
                                        <input type="hidden" name="delete_booking_id" value="<?php echo (int) $b['id']; ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<section id="section-contacts" class="mb-3">
    <div class="card" data-aos="fade-up">
        <div class="card-header bg-white fw-bold py-3"><i class="fa-solid fa-envelope text-warning me-2"></i>Contact messages</div>
        <div class="card-body">
            <?php if (empty($contacts)): ?>
                <p class="text-muted mb-0">No messages.</p>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($contacts as $c): ?>
                        <div class="col-12">
                            <div class="border rounded-3 p-3 bg-light">
                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                    <strong><?php echo htmlspecialchars($c['name']); ?></strong>
                                    <small class="text-muted"><?php echo htmlspecialchars($c['created_at']); ?></small>
                                </div>
                                <a href="mailto:<?php echo htmlspecialchars($c['email']); ?>" class="small d-block mb-2"><?php echo htmlspecialchars($c['email']); ?></a>
                                <p class="mb-0 small"><?php echo nl2br(htmlspecialchars($c['message'])); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/admin_layout_end.php'; ?>
