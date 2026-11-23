<?php
declare(strict_types=1);

require_once __DIR__ . '/config/bootstrap.php';
require_once __DIR__ . '/config/database.php';

if (!is_logged_in()) {
    set_flash('warning', 'Please sign in to view your dashboard.');
    redirect('login.php');
}

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

try {
    $statement = db()->prepare(
        'SELECT Name, Email, Mobile, Created_At FROM users WHERE ID = :id LIMIT 1'
    );
    $statement->execute(['id' => $_SESSION['user_id']]);
    $user = $statement->fetch();
} catch (PDOException $exception) {
    error_log('Dashboard database error: ' . $exception->getMessage());
    http_response_code(503);
    $user = null;
    $loadError = 'Your profile could not be loaded right now. Please try again shortly.';
}

if ($user === false) {
    unset($_SESSION['user_id']);
    set_flash('warning', 'Your account could not be found. Please sign in again.');
    redirect('login.php');
}

$pageTitle = 'Your dashboard';
require __DIR__ . '/includes/header.php';
?>
<section class="dashboard-section">
    <div class="dashboard-heading">
        <div>
            <span class="eyebrow">YOUR PERSONAL SPACE</span>
            <h1>Your dashboard</h1>
            <p>Here are the contact details connected to your account.</p>
        </div>
        <div class="dashboard-status"><span class="online-dot"></span> Account active</div>
    </div>
    <?php if (isset($loadError)): ?>
        <div class="alert alert-danger" role="alert"><?= h($loadError) ?></div>
    <?php elseif (is_array($user)): ?>
        <div class="row g-4">
            <div class="col-lg-4">
                <article class="profile-summary">
                    <div class="profile-avatar"><?= h(strtoupper(substr($user['Name'], 0, 1))) ?></div>
                    <span class="eyebrow">STUDENT PROFILE</span>
                    <h2><?= h($user['Name']) ?></h2>
                    <p><?= h($user['Email']) ?></p>
                    <div class="member-since"><span>MEMBER SINCE</span><strong><?= h(date('F Y', strtotime($user['Created_At']))) ?></strong></div>
                </article>
            </div>
            <div class="col-lg-8">
                <article class="details-card">
                    <div class="details-card-heading"><div><span class="eyebrow">ACCOUNT DETAILS</span><h2>Your information</h2></div><span class="details-lock" aria-label="Private details">◈</span></div>
                    <div class="detail-item"><span class="detail-icon">01</span><div><small>FULL NAME</small><strong><?= h($user['Name']) ?></strong></div></div>
                    <div class="detail-item"><span class="detail-icon">02</span><div><small>EMAIL ADDRESS</small><strong><?= h($user['Email']) ?></strong></div></div>
                    <div class="detail-item"><span class="detail-icon">03</span><div><small>MOBILE NUMBER</small><strong><?= h($user['Mobile']) ?></strong></div></div>
                    <div class="detail-item"><span class="detail-icon">04</span><div><small>ACCOUNT CREATED</small><strong><?= h(date('F j, Y', strtotime($user['Created_At']))) ?></strong></div></div>
                    <div class="privacy-note"><span>✓</span> Your profile is private and only visible to you after signing in.</div>
                </article>
            </div>
        </div>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
