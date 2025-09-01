<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit();
}

// Get analytics data
$analytics = getAnalyticsData();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/admin.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-header">
                <h1>Analytics Dashboard</h1>
                <div class="header-actions">
                    <button class="btn btn-outline-primary" onclick="exportAnalytics()">
                        <i class="fas fa-download"></i> Export Report
                    </button>
                    <button class="btn btn-outline-success" onclick="refreshData()">
                        <i class="fas fa-sync"></i> Refresh Data
                    </button>
                </div>
            </div>

            <!-- Key Metrics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="metric-card bg-primary text-white">
                        <div class="metric-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="metric-content">
                            <h3><?php echo $analytics['total_users']; ?></h3>
                            <p>Total Users</p>
                            <small>+<?php echo $analytics['new_users_this_month']; ?> this month</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="metric-card bg-success text-white">
                        <div class="metric-icon">
                            <i class="fas fa-video"></i>
                        </div>
                        <div class="metric-content">
                            <h3><?php echo $analytics['total_courses']; ?></h3>
                            <p>Total Courses</p>
                            <small><?php echo $analytics['avg_completion_rate']; ?>% completion rate</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="metric-card bg-warning text-white">
                        <div class="metric-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="metric-content">
                            <h3><?php echo $analytics['total_trades']; ?></h3>
                            <p>Total Trades</p>
                            <small>₹<?php echo number_format($analytics['total_trading_volume']); ?> volume</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="metric-card bg-info text-white">
                        <div class="metric-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="metric-content">
                            <h3><?php echo $analytics['total_badges_awarded']; ?></h3>
                            <p>Badges Awarded</p>
                            <small><?php echo $analytics['avg_badges_per_user']; ?> per user</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 1 -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-line"></i> User Registration Trend</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="userRegistrationChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-pie"></i> Course Completion by Difficulty</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="courseCompletionChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 2 -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-bar"></i> Trading Activity by Stock</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="tradingActivityChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-area"></i> Quiz Performance Distribution</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="quizPerformanceChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Analytics -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-table"></i> Top Performing Users</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th>User</th>
                                            <th>Courses Completed</th>
                                            <th>Avg Quiz Score</th>
                                            <th>Badges</th>
                                            <th>Trading P&L</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($analytics['top_users'] as $index => $user): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-<?php echo $index < 3 ? 'warning' : 'secondary'; ?>">
                                                    #<?php echo $index + 1; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                                                <br><small class="text-muted">Joined <?php echo date('M Y', strtotime($user['created_at'])); ?></small>
                                            </td>
                                            <td><?php echo $user['courses_completed']; ?>/<?php echo $user['total_courses']; ?></td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" style="width: <?php echo $user['avg_quiz_score']; ?>%">
                                                        <?php echo $user['avg_quiz_score']; ?>%
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?php echo $user['badges_earned']; ?></span>
                                            </td>
                                            <td>
                                                <span class="text-<?php echo $user['trading_pnl'] >= 0 ? 'success' : 'danger'; ?>">
                                                    ₹<?php echo number_format($user['trading_pnl'], 2); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-list"></i> Recent Activity</h5>
                        </div>
                        <div class="card-body">
                            <div class="activity-list">
                                <?php foreach ($analytics['recent_activity'] as $activity): ?>
                                <div class="activity-item">
                                    <div class="activity-icon bg-<?php echo $activity['type_color']; ?>">
                                        <i class="fas fa-<?php echo $activity['icon']; ?>"></i>
                                    </div>
                                    <div class="activity-content">
                                        <p><?php echo htmlspecialchars($activity['description']); ?></p>
                                        <small class="text-muted"><?php echo $activity['time_ago']; ?></small>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Analytics -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-line"></i> Stock Performance</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Stock</th>
                                            <th>Price</th>
                                            <th>Change</th>
                                            <th>Volume</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($analytics['stock_performance'] as $stock): ?>
                                        <tr>
                                            <td><strong><?php echo $stock['symbol']; ?></strong></td>
                                            <td>₹<?php echo number_format($stock['current_price'], 2); ?></td>
                                            <td>
                                                <span class="text-<?php echo $stock['change_percent'] >= 0 ? 'success' : 'danger'; ?>">
                                                    <?php echo $stock['change_percent'] >= 0 ? '+' : ''; ?><?php echo number_format($stock['change_percent'], 2); ?>%
                                                </span>
                                            </td>
                                            <td><?php echo number_format($stock['volume']); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-medal"></i> Badge Distribution</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Badge</th>
                                            <th>Earned</th>
                                            <th>Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($analytics['badge_distribution'] as $badge): ?>
                                        <tr>
                                            <td>
                                                <i class="<?php echo $badge['icon']; ?>"></i>
                                                <?php echo htmlspecialchars($badge['name']); ?>
                                            </td>
                                            <td><?php echo $badge['count']; ?></td>
                                            <td>
                                                <div class="progress" style="height: 15px;">
                                                    <div class="progress-bar" style="width: <?php echo $badge['percentage']; ?>%">
                                                        <?php echo $badge['percentage']; ?>%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
    <script>
        // User Registration Chart
        const userRegCtx = document.getElementById('userRegistrationChart').getContext('2d');
        new Chart(userRegCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($analytics['user_registration_labels']); ?>,
                datasets: [{
                    label: 'New Users',
                    data: <?php echo json_encode($analytics['user_registration_data']); ?>,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Course Completion Chart
        const courseCompCtx = document.getElementById('courseCompletionChart').getContext('2d');
        new Chart(courseCompCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($analytics['course_completion_labels']); ?>,
                datasets: [{
                    data: <?php echo json_encode($analytics['course_completion_data']); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 205, 86, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Trading Activity Chart
        const tradingCtx = document.getElementById('tradingActivityChart').getContext('2d');
        new Chart(tradingCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($analytics['trading_activity_labels']); ?>,
                datasets: [{
                    label: 'Trade Volume',
                    data: <?php echo json_encode($analytics['trading_activity_data']); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.8)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Quiz Performance Chart
        const quizCtx = document.getElementById('quizPerformanceChart').getContext('2d');
        new Chart(quizCtx, {
            type: 'bar',
            data: {
                labels: ['0-20%', '21-40%', '41-60%', '61-80%', '81-100%'],
                datasets: [{
                    label: 'Number of Users',
                    data: <?php echo json_encode($analytics['quiz_performance_data']); ?>,
                    backgroundColor: 'rgba(255, 159, 64, 0.8)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function exportAnalytics() {
            window.location.href = 'export_analytics.php';
        }

        function refreshData() {
            location.reload();
        }
    </script>
</body>
</html>
