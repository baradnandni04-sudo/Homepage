<?php
declare(strict_types=1);

require_once __DIR__ . '/config/bootstrap.php';

$pageTitle = 'Welcome';
require __DIR__ . '/includes/header.php';
?>
<section class="hero-section">
    <div class="hero-glow hero-glow-one"></div>
    <div class="hero-glow hero-glow-two"></div>
    <div class="container hero-content">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="eyebrow"><span class="eyebrow-dot"></span> YOUR STUDENT ACCOUNT, SIMPLIFIED</span>
                <h1 class="hero-title">A clearer way to stay on top of <span>your fees.</span></h1>
                <p class="hero-copy">Create your secure account and keep your student details together in one calm, convenient place.</p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <?php if (is_logged_in()): ?>
                        <a class="btn btn-primary btn-lg" href="dashboard.php">Go to your dashboard <span aria-hidden="true">→</span></a>
                    <?php else: ?>
                        <a class="btn btn-primary btn-lg" href="register.php">Create your account <span aria-hidden="true">→</span></a>
                        <a class="btn btn-outline-secondary btn-lg hero-login" href="login.php">Sign in</a>
                    <?php endif; ?>
                </div>
                <div class="hero-trust"><span class="trust-check">✓</span> Private by design <span class="trust-divider">·</span> Your password is securely protected</div>
            </div>
            <div class="col-lg-5">
                <div class="preview-card">
                    <div class="preview-topline">
                        <div>
                            <span class="preview-label">STUDENT OVERVIEW</span>
                            <h2 class="preview-heading">Everything in one place</h2>
                        </div>
                        <span class="preview-mark">✦</span>
                    </div>
                    <div class="preview-profile">
                        <span class="avatar-circle">S</span>
                        <div><strong>Your student profile</strong><small>Personal details, securely stored</small></div>
                        <span class="status-pill">READY</span>
                    </div>
                    <div class="preview-row"><span class="preview-symbol">01</span><span>Quick, simple registration</span><span class="preview-arrow">↗</span></div>
                    <div class="preview-row"><span class="preview-symbol">02</span><span>Sign in whenever you need</span><span class="preview-arrow">↗</span></div>
                    <div class="preview-row"><span class="preview-symbol">03</span><span>Your details, only for you</span><span class="preview-arrow">↗</span></div>
                    <div class="preview-foot"><span class="secure-icon">◈</span> Protected with encrypted password storage</div>
                </div>
                <div class="floating-note"><span class="floating-check">✓</span><span><strong>Account secured</strong><small>Ready when you are</small></span></div>
            </div>
        </div>
    </div>
</section>
<section class="benefits-section">
    <div class="container">
        <div class="section-heading text-center">
            <span class="eyebrow">MADE FOR A BETTER START</span>
            <h2>Simple from day one.</h2>
            <p>Everything you need to get started, without the extra steps.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4"><article class="benefit-card"><span class="benefit-number">01</span><h3>Set up in minutes</h3><p>Create your profile with a few details and get straight to your personal dashboard.</p></article></div>
            <div class="col-md-4"><article class="benefit-card"><span class="benefit-number">02</span><h3>Private and protected</h3><p>Your password is hashed before it is stored, and your profile is only shown after sign-in.</p></article></div>
            <div class="col-md-4"><article class="benefit-card"><span class="benefit-number">03</span><h3>Your details, at a glance</h3><p>Review the contact information connected to your account whenever you need it.</p></article></div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
