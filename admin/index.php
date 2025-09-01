<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit();
}

// Get admin statistics
$stats = getAdminStats();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Investor Education Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/admin.css" rel="stylesheet">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <nav class="admin-sidebar">
            <div class="sidebar-header">
                <h4><i class="fas fa-chart-line"></i> Admin Panel</h4>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="courses.php">
                        <i class="fas fa-video"></i> Manage Courses
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users.php">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="stocks.php">
                        <i class="fas fa-chart-bar"></i> Manage Stocks
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="analytics.php">
                        <i class="fas fa-analytics"></i> Analytics
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-header">
                <h1>Admin Dashboard</h1>
                <div class="admin-user">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $stats['total_users']; ?></h3>
                            <p>Total Users</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon bg-success">
                            <i class="fas fa-video"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $stats['total_courses']; ?></h3>
                            <p>Total Courses</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $stats['total_stocks']; ?></h3>
                            <p>Total Stocks</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon bg-info">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $stats['total_badges']; ?></h3>
                            <p>Total Badges</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-clock"></i> Recent User Registrations</h5>
                        </div>
                        <div class="card-body">
                            <div class="recent-list">
                                <?php foreach ($stats['recent_users'] as $user): ?>
                                <div class="recent-item">
                                    <div class="recent-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="recent-content">
                                        <h6><?php echo htmlspecialchars($user['username']); ?></h6>
                                        <small><?php echo date('M d, Y', strtotime($user['created_at'])); ?></small>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-line"></i> Recent Trading Activity</h5>
                        </div>
                        <div class="card-body">
                            <div class="recent-list">
                                <?php foreach ($stats['recent_trades'] as $trade): ?>
                                <div class="recent-item">
                                    <div class="recent-avatar bg-<?php echo $trade['trade_type'] == 'buy' ? 'success' : 'danger'; ?>">
                                        <i class="fas fa-<?php echo $trade['trade_type'] == 'buy' ? 'arrow-up' : 'arrow-down'; ?>"></i>
                                    </div>
                                    <div class="recent-content">
                                        <h6><?php echo htmlspecialchars($trade['stock_symbol']); ?> - <?php echo ucfirst($trade['trade_type']); ?></h6>
                                        <small><?php echo $trade['quantity']; ?> shares at ₹<?php echo number_format($trade['price'], 2); ?></small>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-bolt"></i> Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="courses.php?action=add" class="btn btn-primary btn-block">
                                        <i class="fas fa-plus"></i> Add New Course
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="stocks.php?action=add" class="btn btn-success btn-block">
                                        <i class="fas fa-plus"></i> Add New Stock
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="users.php" class="btn btn-info btn-block">
                                        <i class="fas fa-users"></i> View All Users
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="analytics.php" class="btn btn-warning btn-block">
                                        <i class="fas fa-chart-bar"></i> View Analytics
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
</body>
</html>
