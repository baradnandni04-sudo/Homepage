<?php
$pageTitle = $pageTitle ?? 'BrightLedger';
$flash = take_flash();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f6f7fb">
    <title><?= h($pageTitle) ?> | BrightLedger</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg app-navbar">
    <div class="container">
        <a class="navbar-brand brand-mark" href="index.php"><span class="brand-icon">B</span> BrightLedger</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavigation">
            <div class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <a class="nav-link" href="index.php">Home</a>
                <?php if (is_logged_in()): ?>
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                    <form action="logout.php" method="post" class="d-inline">
                        <input type="hidden" name="csrf_token" value="<?= h(csrf_token()) ?>">
                        <button class="btn btn-nav" type="submit">Sign out</button>
                    </form>
                <?php else: ?>
                    <a class="nav-link" href="login.php">Sign in</a>
                    <a class="btn btn-primary-soft ms-lg-2" href="register.php">Create account</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<main>
    <div class="container">
        <?php if ($flash !== null): ?>
            <div class="alert alert-<?= h($flash['type']) ?> alert-dismissible fade show flash-message" role="alert">
                <?= h($flash['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>
