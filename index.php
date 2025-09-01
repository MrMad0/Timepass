<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Set default language if not set
if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = 'en';
}

// Handle language change
if (isset($_GET['lang'])) {
    $_SESSION['language'] = $_GET['lang'];
    header('Location: index.php');
    exit();
}

// Get user progress if logged in
$userProgress = null;
if (isset($_SESSION['user_id'])) {
    $userProgress = getUserProgress($_SESSION['user_id']);
}
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getTranslation('Investor Education Platform', $_SESSION['language']); ?></title>
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
                        <a class="nav-link" href="leaderboard.php">
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

    <!-- Hero Section -->
    <div class="hero-section bg-gradient-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        <?php echo getTranslation('Master the Stock Market', $_SESSION['language']); ?>
                    </h1>
                    <p class="lead mb-4">
                        <?php echo getTranslation('Learn investing fundamentals, practice with virtual trading, and track your progress in multiple Indian languages.', $_SESSION['language']); ?>
                    </p>
                    <div class="d-flex gap-3">
                        <a href="modules.php" class="btn btn-light btn-lg">
                            <i class="fas fa-play me-2"></i>
                            <?php echo getTranslation('Start Learning', $_SESSION['language']); ?>
                        </a>
                        <a href="trading.php" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-chart-line me-2"></i>
                            <?php echo getTranslation('Try Trading', $_SESSION['language']); ?>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <i class="fas fa-chart-line display-1 text-light opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container my-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-graduation-cap text-primary"></i>
                        </div>
                        <h5 class="card-title"><?php echo getTranslation('Educational Modules', $_SESSION['language']); ?></h5>
                        <p class="card-text">
                            <?php echo getTranslation('Interactive tutorials covering stock market basics, risk assessment, and portfolio diversification.', $_SESSION['language']); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-gamepad text-success"></i>
                        </div>
                        <h5 class="card-title"><?php echo getTranslation('Gamified Learning', $_SESSION['language']); ?></h5>
                        <p class="card-text">
                            <?php echo getTranslation('Take quizzes, earn badges, and compete on leaderboards to stay motivated.', $_SESSION['language']); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-chart-bar text-warning"></i>
                        </div>
                        <h5 class="card-title"><?php echo getTranslation('Virtual Trading', $_SESSION['language']); ?></h5>
                        <p class="card-text">
                            <?php echo getTranslation('Practice trading with virtual money using real market data without any risk.', $_SESSION['language']); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Section (if logged in) -->
    <?php if ($userProgress): ?>
    <div class="bg-light py-5">
        <div class="container">
            <h3 class="text-center mb-4"><?php echo getTranslation('Your Learning Progress', $_SESSION['language']); ?></h3>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-primary"><?php echo $userProgress['modules_completed']; ?>/8</h4>
                            <p class="text-muted"><?php echo getTranslation('Modules Completed', $_SESSION['language']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-success"><?php echo $userProgress['quiz_score']; ?>%</h4>
                            <p class="text-muted"><?php echo getTranslation('Average Quiz Score', $_SESSION['language']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-warning"><?php echo $userProgress['badges_earned']; ?></h4>
                            <p class="text-muted"><?php echo getTranslation('Badges Earned', $_SESSION['language']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-info">₹<?php echo number_format($userProgress['virtual_balance']); ?></h4>
                            <p class="text-muted"><?php echo getTranslation('Virtual Balance', $_SESSION['language']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

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
