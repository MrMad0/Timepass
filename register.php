<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';
$success = '';

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = getTranslation('Please fill in all fields.', $_SESSION['language']);
    } elseif (strlen($username) < 3) {
        $error = getTranslation('Username must be at least 3 characters long.', $_SESSION['language']);
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = getTranslation('Please enter a valid email address.', $_SESSION['language']);
    } elseif (strlen($password) < 6) {
        $error = getTranslation('Password must be at least 6 characters long.', $_SESSION['language']);
    } elseif ($password !== $confirm_password) {
        $error = getTranslation('Passwords do not match.', $_SESSION['language']);
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = getTranslation('Email address already registered.', $_SESSION['language']);
        } else {
            // Check if username already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                $error = getTranslation('Username already taken.', $_SESSION['language']);
            } else {
                // Create user account
                $userId = registerUser($username, $email, $password);
                if ($userId) {
                    $success = getTranslation('Account created successfully! You can now log in.', $_SESSION['language']);
                } else {
                    $error = getTranslation('Error creating account. Please try again.', $_SESSION['language']);
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getTranslation('Register', $_SESSION['language']); ?> - InvestorEdu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-chart-line me-2"></i>
                <?php echo getTranslation('InvestorEdu', $_SESSION['language']); ?>
            </a>
            <ul class="navbar-nav ms-auto">
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
            </ul>
        </div>
    </nav>

    <!-- Registration Form -->
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-user-plus text-primary" style="font-size: 3rem;"></i>
                            <h3 class="mt-3"><?php echo getTranslation('Join InvestorEdu', $_SESSION['language']); ?></h3>
                            <p class="text-muted"><?php echo getTranslation('Start your investment learning journey today', $_SESSION['language']); ?></p>
                        </div>

                        <?php if ($error): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($success): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo $success; ?>
                                <div class="mt-3">
                                    <a href="login.php" class="btn btn-success">
                                        <i class="fas fa-sign-in-alt me-2"></i>
                                        <?php echo getTranslation('Go to Login', $_SESSION['language']); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!$success): ?>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="username" class="form-label">
                                        <i class="fas fa-user me-2"></i>
                                        <?php echo getTranslation('Username', $_SESSION['language']); ?>
                                    </label>
                                    <input type="text" class="form-control" id="username" name="username" 
                                           value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                                           required minlength="3">
                                    <div class="form-text"><?php echo getTranslation('At least 3 characters', $_SESSION['language']); ?></div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2"></i>
                                        <?php echo getTranslation('Email Address', $_SESSION['language']); ?>
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                                           required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>
                                        <?php echo getTranslation('Password', $_SESSION['language']); ?>
                                    </label>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           required minlength="6">
                                    <div class="form-text"><?php echo getTranslation('At least 6 characters', $_SESSION['language']); ?></div>
                                </div>

                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>
                                        <?php echo getTranslation('Confirm Password', $_SESSION['language']); ?>
                                    </label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-user-plus me-2"></i>
                                        <?php echo getTranslation('Create Account', $_SESSION['language']); ?>
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-4">
                                <p class="text-muted">
                                    <?php echo getTranslation('Already have an account?', $_SESSION['language']); ?>
                                    <a href="login.php" class="text-decoration-none">
                                        <?php echo getTranslation('Sign in here', $_SESSION['language']); ?>
                                    </a>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Benefits -->
                <div class="row mt-4">
                    <div class="col-4 text-center">
                        <div class="feature-icon mx-auto mb-2">
                            <i class="fas fa-graduation-cap text-primary"></i>
                        </div>
                        <small class="text-muted"><?php echo getTranslation('8 Modules', $_SESSION['language']); ?></small>
                    </div>
                    <div class="col-4 text-center">
                        <div class="feature-icon mx-auto mb-2">
                            <i class="fas fa-chart-bar text-success"></i>
                        </div>
                        <small class="text-muted"><?php echo getTranslation('Virtual Trading', $_SESSION['language']); ?></small>
                    </div>
                    <div class="col-4 text-center">
                        <div class="feature-icon mx-auto mb-2">
                            <i class="fas fa-trophy text-warning"></i>
                        </div>
                        <small class="text-muted"><?php echo getTranslation('Earn Badges', $_SESSION['language']); ?></small>
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
</body>
</html>
