<?php
declare(strict_types=1);

require_once __DIR__ . '/config/bootstrap.php';
require_once __DIR__ . '/config/database.php';

if (is_logged_in()) {
    redirect('dashboard.php');
}

$errors = [];
$name = '';
$email = '';
$mobile = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $mobile = trim((string) ($_POST['mobile'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $confirmPassword = (string) ($_POST['confirm_password'] ?? '');

    if (!csrf_is_valid($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Your form session expired. Please try again.';
    }
    if (!preg_match('/^.{2,100}$/us', $name)) {
        $errors[] = 'Full name must be between 2 and 100 characters.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 190) {
        $errors[] = 'Enter a valid email address (maximum 190 characters).';
    }
    $mobileDigits = preg_replace('/\D/', '', $mobile);
    if (!preg_match('/^\+?[0-9\s().-]{7,20}$/', $mobile) || strlen((string) $mobileDigits) < 7 || strlen((string) $mobileDigits) > 15) {
        $errors[] = 'Enter a valid mobile number with 7 to 15 digits.';
    }
    if (strlen($password) < 8 || strlen($password) > 72) {
        $errors[] = 'Password must be between 8 and 72 bytes long.';
    }
    if ($password !== $confirmPassword) {
        $errors[] = 'The passwords do not match.';
    }

    if ($errors === []) {
        try {
            $pdo = db();
            $check = $pdo->prepare('SELECT ID FROM users WHERE Email = :email LIMIT 1');
            $check->execute(['email' => $email]);
            if ($check->fetch()) {
                $errors[] = 'An account with that email already exists. Please sign in instead.';
            } else {
                $insert = $pdo->prepare(
                    'INSERT INTO users (Name, Email, Mobile, Password) VALUES (:name, :email, :mobile, :password)'
                );
                $insert->execute([
                    'name' => $name,
                    'email' => $email,
                    'mobile' => $mobile,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                ]);
                set_flash('success', 'Your account is ready. Sign in to view your dashboard.');
                redirect('login.php');
            }
        } catch (PDOException $exception) {
            if (($exception->errorInfo[1] ?? null) === 1062) {
                $errors[] = 'An account with that email already exists. Please sign in instead.';
            } else {
                error_log('Registration database error: ' . $exception->getMessage());
                $errors[] = 'We could not create your account right now. Please try again shortly.';
            }
        }
    }
}

$pageTitle = 'Create account';
require __DIR__ . '/includes/header.php';
?>
<section class="auth-section">
    <div class="auth-shell">
        <div class="auth-aside register-aside">
            <span class="eyebrow eyebrow-light">A BETTER WAY TO GET STARTED</span>
            <h1>Your next step starts here.</h1>
            <p>Create an account to keep your student contact details secure and close at hand.</p>
            <div class="aside-points">
                <div><span>✓</span><span><strong>Just the essentials</strong><small>A quick, straightforward setup</small></span></div>
                <div><span>✓</span><span><strong>Private profile</strong><small>Your account details stay yours</small></span></div>
                <div><span>✓</span><span><strong>Secure password</strong><small>Protected with industry-standard hashing</small></span></div>
            </div>
            <div class="aside-decoration" aria-hidden="true">B</div>
        </div>
        <div class="auth-form-panel">
            <div class="auth-form-inner">
                <span class="eyebrow">GET STARTED</span>
                <h2>Create your account</h2>
                <p class="form-intro">Fill in your details below. All fields are required.</p>
                <?php if ($errors !== []): ?>
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0 ps-3"><?php foreach ($errors as $error): ?><li><?= h($error) ?></li><?php endforeach; ?></ul>
                    </div>
                <?php endif; ?>
                <form method="post" action="register.php" id="registerForm">
                    <input type="hidden" name="csrf_token" value="<?= h(csrf_token()) ?>">
                    <div class="mb-3">
                        <label class="form-label" for="name">Full name</label>
                        <input class="form-control" id="name" name="name" type="text" autocomplete="name" minlength="2" maxlength="100" placeholder="e.g. Alex Morgan" value="<?= h($name) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email address</label>
                        <input class="form-control" id="email" name="email" type="email" autocomplete="email" maxlength="190" placeholder="you@example.com" value="<?= h($email) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="mobile">Mobile number</label>
                        <input class="form-control" id="mobile" name="mobile" type="tel" autocomplete="tel" maxlength="20" placeholder="+1 (555) 123-4567" value="<?= h($mobile) ?>" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label" for="password">Password</label>
                            <input class="form-control" id="password" name="password" type="password" autocomplete="new-password" minlength="8" maxlength="72" placeholder="8 to 72 characters" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="confirm_password">Confirm password</label>
                            <input class="form-control" id="confirm_password" name="confirm_password" type="password" autocomplete="new-password" minlength="8" maxlength="72" placeholder="Enter it again" required>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 btn-submit mt-4" type="submit">Create account <span aria-hidden="true">→</span></button>
                </form>
                <p class="auth-switch">Already have an account? <a href="login.php">Sign in</a></p>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
