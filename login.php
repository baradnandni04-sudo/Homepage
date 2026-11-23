<?php
declare(strict_types=1);

require_once __DIR__ . '/config/bootstrap.php';
require_once __DIR__ . '/config/database.php';

if (is_logged_in()) {
    redirect('dashboard.php');
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if (!csrf_is_valid($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Your form session expired. Please try again.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $errors[] = 'Enter a valid email address and password.';
    } else {
        try {
            $statement = db()->prepare('SELECT ID, Password FROM users WHERE Email = :email LIMIT 1');
            $statement->execute(['email' => $email]);
            $user = $statement->fetch();

            if (!$user || !password_verify($password, $user['Password'])) {
                $errors[] = 'The email or password you entered is incorrect.';
            } else {
                session_regenerate_id(true);
                $_SESSION['user_id'] = (int) $user['ID'];
                unset($_SESSION['csrf_token']);
                set_flash('success', 'Welcome back. You are signed in.');
                redirect('dashboard.php');
            }
        } catch (PDOException $exception) {
            error_log('Login database error: ' . $exception->getMessage());
            $errors[] = 'We could not sign you in right now. Please try again shortly.';
        }
    }
}

$pageTitle = 'Sign in';
require __DIR__ . '/includes/header.php';
?>
<section class="auth-section">
    <div class="auth-shell login-shell">
        <div class="auth-aside login-aside">
            <span class="eyebrow eyebrow-light">WELCOME BACK</span>
            <h1>Good to have you here.</h1>
            <p>Sign in to pick up right where you left off and see your personal student profile.</p>
            <div class="login-quote">
                <span class="quote-mark">“</span>
                <p>A little more clarity makes a big difference.</p>
                <span class="quote-caption">YOUR BRIGHTLEDGER ACCOUNT</span>
            </div>
            <div class="aside-decoration" aria-hidden="true">B</div>
        </div>
        <div class="auth-form-panel">
            <div class="auth-form-inner login-form-inner">
                <span class="eyebrow">YOUR ACCOUNT</span>
                <h2>Sign in</h2>
                <p class="form-intro">Enter your account details to continue.</p>
                <?php if ($errors !== []): ?>
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0 ps-3"><?php foreach ($errors as $error): ?><li><?= h($error) ?></li><?php endforeach; ?></ul>
                    </div>
                <?php endif; ?>
                <form method="post" action="login.php">
                    <input type="hidden" name="csrf_token" value="<?= h(csrf_token()) ?>">
                    <div class="mb-3">
                        <label class="form-label" for="email">Email address</label>
                        <input class="form-control" id="email" name="email" type="email" autocomplete="email" maxlength="190" placeholder="you@example.com" value="<?= h($email) ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control" id="password" name="password" type="password" autocomplete="current-password" placeholder="Your password" required>
                    </div>
                    <button class="btn btn-primary w-100 btn-submit" type="submit">Sign in securely <span aria-hidden="true">→</span></button>
                </form>
                <p class="auth-switch">New to BrightLedger? <a href="register.php">Create an account</a></p>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
