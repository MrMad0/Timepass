<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$leaderboard = getLeaderboard();
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getTranslation('Leaderboard', $_SESSION['language']); ?> - InvestorEdu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-chart-line me-2"></i>
                <?php echo getTranslation('InvestorEdu', $_SESSION['language']); ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="modules.php">
                            <i class="fas fa-graduation-cap me-1"></i>
                            <?php echo getTranslation('Learn', $_SESSION['language']); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="trading.php">
                            <i class="fas fa-chart-bar me-1"></i>
                            <?php echo getTranslation('Trading Simulator', $_SESSION['language']); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="leaderboard.php">
                            <i class="fas fa-trophy me-1"></i>
                            <?php echo getTranslation('Leaderboard', $_SESSION['language']); ?>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-globe me-1"></i>
                            <?php echo getLanguageName($_SESSION['language']); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?lang=en">English</a></li>
                            <li><a class="dropdown-item" href="?lang=hi">हिंदी</a></li>
                            <li><a class="dropdown-item" href="?lang=ta">தமிழ்</a></li>
                            <li><a class="dropdown-item" href="?lang=te">తెలుగు</a></li>
                            <li><a class="dropdown-item" href="?lang=bn">বাংলা</a></li>
                        </ul>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="fas fa-user me-1"></i>
                                <?php echo getTranslation('Dashboard', $_SESSION['language']); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <i class="fas fa-sign-out-alt me-1"></i>
                                <?php echo getTranslation('Logout', $_SESSION['language']); ?>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="fas fa-sign-in-alt me-1"></i>
                                <?php echo getTranslation('Login', $_SESSION['language']); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">
                                <i class="fas fa-user-plus me-1"></i>
                                <?php echo getTranslation('Register', $_SESSION['language']); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Leaderboard Header -->
    <div class="bg-gradient-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-trophy me-3"></i>
                        <?php echo getTranslation('Leaderboard', $_SESSION['language']); ?>
                    </h1>
                    <p class="lead mb-4">
                        <?php echo getTranslation('See how you rank among other learners. Complete modules, earn badges, and climb to the top!', $_SESSION['language']); ?>
                    </p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-medal display-1 text-light opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaderboard Content -->
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-ranking-star text-warning me-2"></i>
                            <?php echo getTranslation('Top Learners', $_SESSION['language']); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($leaderboard)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-users text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3">
                                    <?php echo getTranslation('No users found. Be the first to complete modules!', $_SESSION['language']); ?>
                                </p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($leaderboard as $index => $user): ?>
                                <div class="leaderboard-item">
                                    <div class="d-flex align-items-center">
                                        <div class="leaderboard-rank <?php echo $index < 3 ? 'top-3' : ''; ?>">
                                            <?php echo $index + 1; ?>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1"><?php echo htmlspecialchars($user['username']); ?></h6>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <small class="text-muted">
                                                        <i class="fas fa-graduation-cap me-1"></i>
                                                        <?php echo $user['modules_completed']; ?> <?php echo getTranslation('Modules', $_SESSION['language']); ?>
                                                    </small>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted">
                                                        <i class="fas fa-chart-line me-1"></i>
                                                        <?php echo round($user['avg_score'] ?? 0); ?>% <?php echo getTranslation('Avg Score', $_SESSION['language']); ?>
                                                    </small>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted">
                                                        <i class="fas fa-trophy me-1"></i>
                                                        <?php echo $user['badges_earned']; ?> <?php echo getTranslation('Badges', $_SESSION['language']); ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($index < 3): ?>
                                            <div class="ms-3">
                                                <?php if ($index == 0): ?>
                                                    <i class="fas fa-crown text-warning" style="font-size: 1.5rem;"></i>
                                                <?php elseif ($index == 1): ?>
                                                    <i class="fas fa-medal text-secondary" style="font-size: 1.5rem;"></i>
                                                <?php elseif ($index == 2): ?>
                                                    <i class="fas fa-award text-warning" style="font-size: 1.5rem;"></i>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- How to Rank -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle text-info me-2"></i>
                            <?php echo getTranslation('How to Rank Higher', $_SESSION['language']); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                    <div>
                                        <strong><?php echo getTranslation('Complete Modules', $_SESSION['language']); ?></strong>
                                        <br><small class="text-muted"><?php echo getTranslation('Finish all 8 educational modules', $_SESSION['language']); ?></small>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                    <div>
                                        <strong><?php echo getTranslation('Score High on Quizzes', $_SESSION['language']); ?></strong>
                                        <br><small class="text-muted"><?php echo getTranslation('Aim for 100% on all quizzes', $_SESSION['language']); ?></small>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                    <div>
                                        <strong><?php echo getTranslation('Earn Badges', $_SESSION['language']); ?></strong>
                                        <br><small class="text-muted"><?php echo getTranslation('Complete achievements to earn badges', $_SESSION['language']); ?></small>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                    <div>
                                        <strong><?php echo getTranslation('Practice Trading', $_SESSION['language']); ?></strong>
                                        <br><small class="text-muted"><?php echo getTranslation('Use the virtual trading simulator', $_SESSION['language']); ?></small>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-rocket text-primary me-2"></i>
                            <?php echo getTranslation('Get Started', $_SESSION['language']); ?>
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <p class="text-muted mb-3">
                                <?php echo getTranslation('Ready to climb the leaderboard?', $_SESSION['language']); ?>
                            </p>
                            <a href="modules.php" class="btn btn-primary mb-2">
                                <i class="fas fa-graduation-cap me-2"></i>
                                <?php echo getTranslation('Start Learning', $_SESSION['language']); ?>
                            </a>
                            <a href="trading.php" class="btn btn-outline-primary">
                                <i class="fas fa-chart-line me-2"></i>
                                <?php echo getTranslation('Practice Trading', $_SESSION['language']); ?>
                            </a>
                        <?php else: ?>
                            <p class="text-muted mb-3">
                                <?php echo getTranslation('Join thousands of learners!', $_SESSION['language']); ?>
                            </p>
                            <a href="register.php" class="btn btn-primary mb-2">
                                <i class="fas fa-user-plus me-2"></i>
                                <?php echo getTranslation('Create Account', $_SESSION['language']); ?>
                            </a>
                            <a href="login.php" class="btn btn-outline-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                <?php echo getTranslation('Sign In', $_SESSION['language']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><?php echo getTranslation('InvestorEdu', $_SESSION['language']); ?></h5>
                    <p class="text-muted">
                        <?php echo getTranslation('Empowering retail investors through education and virtual trading practice.', $_SESSION['language']); ?>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted">
                        <?php echo getTranslation('Inspired by SEBI\'s investor education initiatives', $_SESSION['language']); ?>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
