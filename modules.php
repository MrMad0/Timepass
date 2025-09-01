<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$modules = getModules();
$userProgress = getUserProgress($_SESSION['user_id']);
$userBadges = getUserBadges($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getTranslation('Educational Modules', $_SESSION['language']); ?> - InvestorEdu</title>
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
                        <a class="nav-link active" href="modules.php">
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Progress Overview -->
    <div class="bg-light py-4">
        <div class="container">
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
                        <div class="label"><?php echo getTranslation('Average Quiz Score', $_SESSION['language']); ?></div>
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
            <div class="mt-3">
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

    <!-- Modules Section -->
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="mb-4">
                    <i class="fas fa-graduation-cap text-primary me-2"></i>
                    <?php echo getTranslation('Educational Modules', $_SESSION['language']); ?>
                </h2>
                
                <div class="row">
                    <?php foreach ($modules as $module): ?>
                        <?php
                        // Check if user has completed this module
                        $completed = false;
                        $quizScore = 0;
                        $stmt = $pdo->prepare("SELECT completed, quiz_score FROM user_progress WHERE user_id = ? AND module_id = ?");
                        $stmt->execute([$_SESSION['user_id'], $module['id']]);
                        $progress = $stmt->fetch();
                        if ($progress) {
                            $completed = $progress['completed'];
                            $quizScore = $progress['quiz_score'];
                        }
                        ?>
                        <div class="col-md-6 mb-4">
                            <div class="card module-card h-100" data-module-id="<?php echo $module['id']; ?>">
                                <div class="card-header position-relative">
                                    <h5 class="mb-0"><?php echo $module['title']; ?></h5>
                                    <span class="badge bg-<?php echo getDifficultyColor($module['difficulty']); ?>">
                                        <?php echo ucfirst($module['difficulty']); ?>
                                    </span>
                                    <?php if ($completed): ?>
                                        <div class="module-progress">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    <?php else: ?>
                                        <div class="module-progress">
                                            <?php echo $module['order_num']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted"><?php echo $module['description']; ?></p>
                                    
                                    <?php if ($completed): ?>
                                        <div class="alert alert-success mb-3">
                                            <i class="fas fa-check-circle me-2"></i>
                                            <?php echo getTranslation('Completed', $_SESSION['language']); ?> 
                                            (<?php echo $quizScore; ?>% <?php echo getTranslation('Quiz Score', $_SESSION['language']); ?>)
                                        </div>
                                        <a href="module_content.php?id=<?php echo $module['id']; ?>" class="btn btn-outline-primary">
                                            <i class="fas fa-eye me-2"></i>
                                            <?php echo getTranslation('Review', $_SESSION['language']); ?>
                                        </a>
                                    <?php else: ?>
                                        <a href="module_content.php?id=<?php echo $module['id']; ?>" class="btn btn-primary">
                                            <i class="fas fa-play me-2"></i>
                                            <?php echo getTranslation('Start Learning', $_SESSION['language']); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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
                                <div class="d-flex align-items-center mb-2">
                                    <i class="<?php echo $badge['icon']; ?> text-warning me-2"></i>
                                    <div>
                                        <strong><?php echo $badge['name']; ?></strong>
                                        <br><small class="text-muted"><?php echo $badge['description']; ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Learning Tips -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-lightbulb text-info me-2"></i>
                            <?php echo getTranslation('Learning Tips', $_SESSION['language']); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                <?php echo getTranslation('Complete modules in order for best learning experience', $_SESSION['language']); ?>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                <?php echo getTranslation('Take quizzes seriously to test your understanding', $_SESSION['language']); ?>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                <?php echo getTranslation('Practice with virtual trading to apply your knowledge', $_SESSION['language']); ?>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                <?php echo getTranslation('Earn badges to track your achievements', $_SESSION['language']); ?>
                            </li>
                        </ul>
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
