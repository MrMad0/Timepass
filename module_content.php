<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$moduleId = $_GET['id'] ?? 0;
$module = getModule($moduleId);

if (!$module) {
    header('Location: modules.php');
    exit();
}

$quizzes = getQuizzes($moduleId);

// Handle quiz submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_quiz'])) {
    $score = 0;
    $totalQuestions = count($quizzes);
    
    foreach ($quizzes as $quiz) {
        $userAnswer = $_POST['question_' . $quiz['id']] ?? '';
        if ($userAnswer === $quiz['correct_answer']) {
            $score++;
        }
    }
    
    $percentage = $totalQuestions > 0 ? round(($score / $totalQuestions) * 100) : 0;
    saveQuizResult($_SESSION['user_id'], $moduleId, $percentage);
    
    // Redirect to prevent form resubmission
    header('Location: module_content.php?id=' . $moduleId . '&quiz_completed=1');
    exit();
}

// Get user progress for this module
$stmt = $pdo->prepare("SELECT completed, quiz_score FROM user_progress WHERE user_id = ? AND module_id = ?");
$stmt->execute([$_SESSION['user_id'], $moduleId]);
$userProgress = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($module['title']); ?> - InvestorEdu</title>
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

    <div class="container my-4">
        <div class="row">
            <div class="col-lg-8">
                <!-- Module Content -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><?php echo htmlspecialchars($module['title']); ?></h4>
                            <span class="badge bg-<?php echo getDifficultyColor($module['difficulty']); ?>">
                                <?php echo ucfirst($module['difficulty']); ?>
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Video Section -->
                        <?php if ((isset($module['youtube_url']) && $module['youtube_url']) || (isset($module['video_url']) && $module['video_url'])): ?>
                            <div class="mb-4">
                                <h5><i class="fas fa-video me-2"></i>Video Tutorial</h5>
                                <div class="ratio ratio-16x9">
                                    <?php if (isset($module['youtube_url']) && $module['youtube_url']): ?>
                                        <iframe src="<?php echo getYouTubeEmbedUrl($module['youtube_url']); ?>" 
                                                frameborder="0" allowfullscreen>
                                        </iframe>
                                    <?php elseif (isset($module['video_url']) && $module['video_url']): ?>
                                        <video controls>
                                            <source src="uploads/videos/<?php echo $module['video_url']; ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Content Section -->
                        <div class="mb-4">
                            <h5><i class="fas fa-book me-2"></i>Content</h5>
                            <div class="module-content">
                                <?php echo nl2br(htmlspecialchars($module['content'])); ?>
                            </div>
                        </div>

                        <!-- Quiz Section -->
                        <?php if (!empty($quizzes)): ?>
                            <div class="mb-4">
                                <h5><i class="fas fa-question-circle me-2"></i>Quiz</h5>
                                
                                <?php if (isset($_GET['quiz_completed'])): ?>
                                    <div class="alert alert-success">
                                        <h6><i class="fas fa-check-circle me-2"></i>Quiz Completed!</h6>
                                        <p class="mb-0">Your score: <strong><?php echo $userProgress['quiz_score']; ?>%</strong></p>
                                    </div>
                                <?php elseif ($userProgress && $userProgress['completed']): ?>
                                    <div class="alert alert-info">
                                        <h6><i class="fas fa-info-circle me-2"></i>Quiz Already Completed</h6>
                                        <p class="mb-0">Your previous score: <strong><?php echo $userProgress['quiz_score']; ?>%</strong></p>
                                    </div>
                                <?php else: ?>
                                    <form method="POST">
                                        <?php foreach ($quizzes as $index => $quiz): ?>
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h6 class="card-title">Question <?php echo $index + 1; ?></h6>
                                                    <p class="card-text"><?php echo htmlspecialchars($quiz['question']); ?></p>
                                                    
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="question_<?php echo $quiz['id']; ?>" value="A" required>
                                                        <label class="form-check-label"><?php echo htmlspecialchars($quiz['option_a']); ?></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="question_<?php echo $quiz['id']; ?>" value="B" required>
                                                        <label class="form-check-label"><?php echo htmlspecialchars($quiz['option_b']); ?></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="question_<?php echo $quiz['id']; ?>" value="C" required>
                                                        <label class="form-check-label"><?php echo htmlspecialchars($quiz['option_c']); ?></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="question_<?php echo $quiz['id']; ?>" value="D" required>
                                                        <label class="form-check-label"><?php echo htmlspecialchars($quiz['option_d']); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        
                                        <button type="submit" name="submit_quiz" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i>Submit Quiz
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Module Navigation -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>Course Modules
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php 
                        $allModules = getModules();
                        foreach ($allModules as $mod): 
                            $isCurrent = $mod['id'] == $moduleId;
                            $stmt = $pdo->prepare("SELECT completed FROM user_progress WHERE user_id = ? AND module_id = ?");
                            $stmt->execute([$_SESSION['user_id'], $mod['id']]);
                            $modProgress = $stmt->fetch();
                        ?>
                            <div class="d-flex align-items-center mb-2 <?php echo $isCurrent ? 'fw-bold' : ''; ?>">
                                <div class="me-2">
                                    <?php if ($modProgress && $modProgress['completed']): ?>
                                        <i class="fas fa-check-circle text-success"></i>
                                    <?php elseif ($isCurrent): ?>
                                        <i class="fas fa-play-circle text-primary"></i>
                                    <?php else: ?>
                                        <i class="fas fa-circle text-muted"></i>
                                    <?php endif; ?>
                                </div>
                                <a href="module_content.php?id=<?php echo $mod['id']; ?>" 
                                   class="text-decoration-none <?php echo $isCurrent ? 'text-primary' : 'text-dark'; ?>">
                                    <?php echo htmlspecialchars($mod['title']); ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Progress Summary -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i>Your Progress
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php 
                        $progress = getUserProgress($_SESSION['user_id']);
                        $totalModules = count($allModules);
                        $completionPercentage = $totalModules > 0 ? round(($progress['modules_completed'] / $totalModules) * 100) : 0;
                        ?>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Overall Progress</span>
                                <span><?php echo $completionPercentage; ?>%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: <?php echo $completionPercentage; ?>%">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <div class="h4 mb-0"><?php echo $progress['modules_completed']; ?></div>
                                    <small class="text-muted">Completed</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="h4 mb-0"><?php echo $progress['quiz_score']; ?>%</div>
                                <small class="text-muted">Avg Score</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation Buttons -->
        <div class="d-flex justify-content-between mt-4">
            <?php
            $currentIndex = array_search($module, $allModules);
            $prevModule = $currentIndex > 0 ? $allModules[$currentIndex - 1] : null;
            $nextModule = $currentIndex < count($allModules) - 1 ? $allModules[$currentIndex + 1] : null;
            ?>
            
            <?php if ($prevModule): ?>
                <a href="module_content.php?id=<?php echo $prevModule['id']; ?>" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Previous Module
                </a>
            <?php else: ?>
                <div></div>
            <?php endif; ?>
            
            <a href="modules.php" class="btn btn-secondary">
                <i class="fas fa-list me-2"></i>All Modules
            </a>
            
            <?php if ($nextModule): ?>
                <a href="module_content.php?id=<?php echo $nextModule['id']; ?>" class="btn btn-primary">
                    Next Module<i class="fas fa-arrow-right ms-2"></i>
                </a>
            <?php else: ?>
                <div></div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
