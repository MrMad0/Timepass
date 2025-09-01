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

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error = getTranslation('Please fill in all fields.', $_SESSION['language']);
    } else {
        $user = loginUser($email, $password);
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit();
        } else {
            $error = getTranslation('Invalid email or password.', $_SESSION['language']);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getTranslation('Login', $_SESSION['language']); ?> - InvestorEdu</title>
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

    <!-- Login Form -->
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-chart-line text-primary" style="font-size: 3rem;"></i>
                            <h3 class="mt-3"><?php echo getTranslation('Welcome Back', $_SESSION['language']); ?></h3>
                            <p class="text-muted"><?php echo getTranslation('Sign in to continue your learning journey', $_SESSION['language']); ?></p>
                        </div>

                        <?php if ($error): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
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
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    <?php echo getTranslation('Sign In', $_SESSION['language']); ?>
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="text-muted">
                                <?php echo getTranslation('Don\'t have an account?', $_SESSION['language']); ?>
                                <a href="register.php" class="text-decoration-none">
                                    <?php echo getTranslation('Sign up here', $_SESSION['language']); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Features Preview -->
                <div class="row mt-4">
                    <div class="col-4 text-center">
                        <div class="feature-icon mx-auto mb-2">
                            <i class="fas fa-graduation-cap text-primary"></i>
                        </div>
                        <small class="text-muted"><?php echo getTranslation('Learn', $_SESSION['language']); ?></small>
                    </div>
                    <div class="col-4 text-center">
                        <div class="feature-icon mx-auto mb-2">
                            <i class="fas fa-chart-bar text-success"></i>
                        </div>
                        <small class="text-muted"><?php echo getTranslation('Trade', $_SESSION['language']); ?></small>
                    </div>
                    <div class="col-4 text-center">
                        <div class="feature-icon mx-auto mb-2">
                            <i class="fas fa-trophy text-warning"></i>
                        </div>
                        <small class="text-muted"><?php echo getTranslation('Compete', $_SESSION['language']); ?></small>
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
