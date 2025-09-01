<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userProgress = getUserProgress($_SESSION['user_id']);
$userBadges = getUserBadges($_SESSION['user_id']);
$userPortfolio = getUserPortfolio($_SESSION['user_id']);
$recentTrades = getUserTrades($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getTranslation('Dashboard', $_SESSION['language']); ?> - InvestorEdu</title>
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
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Welcome Section -->
    <div class="bg-light py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2">
                        <i class="fas fa-user-circle text-primary me-2"></i>
                        <?php echo getTranslation('Welcome back', $_SESSION['language']); ?>, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                    </h2>
                    <p class="text-muted mb-0">
                        <?php echo getTranslation('Continue your investment learning journey', $_SESSION['language']); ?>
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="modules.php" class="btn btn-primary">
                        <i class="fas fa-graduation-cap me-2"></i>
                        <?php echo getTranslation('Continue Learning', $_SESSION['language']); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="container my-5">
        <div class="row">
            <!-- Progress Overview -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line text-primary me-2"></i>
                            <?php echo getTranslation('Learning Progress', $_SESSION['language']); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="stats-card">
                                    <div class="number"><?php echo $userProgress['modules_completed']; ?>/8</div>
                                    <div class="label"><?php echo getTranslation('Modules Completed', $_SESSION['language']); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="stats-card">
                                    <div class="number"><?php echo $userProgress['quiz_score']; ?>%</div>
                                    <div class="label"><?php echo getTranslation('Average Score', $_SESSION['language']); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="stats-card">
                                    <div class="number"><?php echo $userProgress['badges_earned']; ?></div>
                                    <div class="label"><?php echo getTranslation('Badges Earned', $_SESSION['language']); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="stats-card">
                                    <div class="number"><?php echo formatCurrency($userProgress['virtual_balance']); ?></div>
                                    <div class="label"><?php echo getTranslation('Virtual Balance', $_SESSION['language']); ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Overall Progress Bar -->
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold"><?php echo getTranslation('Overall Progress', $_SESSION['language']); ?></span>
                                <span><?php echo round(($userProgress['modules_completed'] / 8) * 100); ?>%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" 
                                     style="width: <?php echo ($userProgress['modules_completed'] / 8) * 100; ?>%" 
                                     data-progress="<?php echo ($userProgress['modules_completed'] / 8) * 100; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-graduation-cap text-primary mb-3" style="font-size: 3rem;"></i>
                                <h5><?php echo getTranslation('Continue Learning', $_SESSION['language']); ?></h5>
                                <p class="text-muted"><?php echo getTranslation('Complete more modules to earn badges and improve your knowledge', $_SESSION['language']); ?></p>
                                <a href="modules.php" class="btn btn-primary">
                                    <i class="fas fa-play me-2"></i>
                                    <?php echo getTranslation('Start Learning', $_SESSION['language']); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-chart-bar text-success mb-3" style="font-size: 3rem;"></i>
                                <h5><?php echo getTranslation('Practice Trading', $_SESSION['language']); ?></h5>
                                <p class="text-muted"><?php echo getTranslation('Apply your knowledge with virtual trading simulation', $_SESSION['language']); ?></p>
                                <a href="trading.php" class="btn btn-success">
                                    <i class="fas fa-chart-line me-2"></i>
                                    <?php echo getTranslation('Start Trading', $_SESSION['language']); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Recent Badges -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-trophy text-warning me-2"></i>
                            <?php echo getTranslation('Recent Badges', $_SESSION['language']); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($userBadges)): ?>
                            <p class="text-muted text-center">
                                <?php echo getTranslation('No badges earned yet. Complete modules to earn badges!', $_SESSION['language']); ?>
                            </p>
                        <?php else: ?>
                            <?php foreach (array_slice($userBadges, 0, 5) as $badge): ?>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="<?php echo $badge['icon']; ?> text-warning me-3" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <strong><?php echo $badge['name']; ?></strong>
                                        <br><small class="text-muted"><?php echo $badge['description']; ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php if (count($userBadges) > 5): ?>
                                <div class="text-center">
                                    <small class="text-muted">
                                        <?php echo getTranslation('And', $_SESSION['language']); ?> <?php echo count($userBadges) - 5; ?> <?php echo getTranslation('more badges', $_SESSION['language']); ?>
                                    </small>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Portfolio Summary -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-briefcase text-info me-2"></i>
                            <?php echo getTranslation('Portfolio Summary', $_SESSION['language']); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($userPortfolio)): ?>
                            <p class="text-muted text-center">
                                <?php echo getTranslation('No stocks in portfolio. Start trading to build your portfolio!', $_SESSION['language']); ?>
                            </p>
                            <div class="text-center">
                                <a href="trading.php" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    <?php echo getTranslation('Start Trading', $_SESSION['language']); ?>
                                </a>
                            </div>
                        <?php else: ?>
                            <?php 
                            $totalValue = 0;
                            $totalPnl = 0;
                            foreach ($userPortfolio as $holding) {
                                $currentValue = $holding['quantity'] * $holding['current_price'];
                                $totalValue += $currentValue;
                                $totalPnl += $currentValue - ($holding['quantity'] * $holding['avg_buy_price']);
                            }
                            ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span><?php echo getTranslation('Total Value', $_SESSION['language']); ?>:</span>
                                <strong><?php echo formatCurrency($totalValue); ?></strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span><?php echo getTranslation('Total P&L', $_SESSION['language']); ?>:</span>
                                <strong class="<?php echo $totalPnl >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo formatCurrency($totalPnl); ?>
                                </strong>
                            </div>
                            <div class="text-center">
                                <a href="trading.php" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-2"></i>
                                    <?php echo getTranslation('View Portfolio', $_SESSION['language']); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-history text-secondary me-2"></i>
                            <?php echo getTranslation('Recent Activity', $_SESSION['language']); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($recentTrades)): ?>
                            <p class="text-muted text-center">
                                <?php echo getTranslation('No recent activity. Start learning or trading!', $_SESSION['language']); ?>
                            </p>
                        <?php else: ?>
                            <?php foreach (array_slice($recentTrades, 0, 3) as $trade): ?>
                                <div class="d-flex justify-content-between align-items-center mb-2 p-2 border-bottom">
                                    <div>
                                        <strong><?php echo $trade['stock_symbol']; ?></strong>
                                        <br>
                                        <small class="text-muted">
                                            <?php echo date('M d, H:i', strtotime($trade['trade_date'])); ?>
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-<?php echo $trade['trade_type'] == 'buy' ? 'success' : 'danger'; ?>">
                                            <?php echo strtoupper($trade['trade_type']); ?>
                                        </span>
                                        <br>
                                        <small><?php echo $trade['quantity']; ?> shares</small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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
