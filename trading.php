<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$stocks = getStocks();
$userPortfolio = getUserPortfolio($_SESSION['user_id']);
$userTrades = getUserTrades($_SESSION['user_id']);
$userProgress = getUserProgress($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getTranslation('Trading Simulator', $_SESSION['language']); ?> - InvestorEdu</title>
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
                        <a class="nav-link active" href="trading.php">
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

    <!-- Alert Container -->
    <div id="alert-container"></div>

    <!-- Trading Dashboard -->
    <div class="container my-4">
        <div class="row">
            <!-- Account Summary -->
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-wallet text-primary me-2"></i>
                            <?php echo getTranslation('Account Summary', $_SESSION['language']); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span><?php echo getTranslation('Virtual Balance', $_SESSION['language']); ?>:</span>
                            <strong id="virtual-balance"><?php echo formatCurrency($userProgress['virtual_balance']); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span><?php echo getTranslation('Portfolio Value', $_SESSION['language']); ?>:</span>
                            <strong id="portfolio-value">
                                <?php
                                $portfolioValue = 0;
                                foreach ($userPortfolio as $holding) {
                                    $portfolioValue += $holding['quantity'] * $holding['current_price'];
                                }
                                echo formatCurrency($portfolioValue);
                                ?>
                            </strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><?php echo getTranslation('Total Value', $_SESSION['language']); ?>:</span>
                            <strong class="text-primary">
                                <?php echo formatCurrency($userProgress['virtual_balance'] + $portfolioValue); ?>
                            </strong>
                        </div>
                    </div>
                </div>

                <!-- Quick Trade -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-exchange-alt text-success me-2"></i>
                            <?php echo getTranslation('Quick Trade', $_SESSION['language']); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="trade-form">
                            <div class="mb-3">
                                <label for="stock-symbol" class="form-label"><?php echo getTranslation('Stock', $_SESSION['language']); ?></label>
                                <select class="form-select" id="stock-symbol" required>
                                    <option value=""><?php echo getTranslation('Select Stock', $_SESSION['language']); ?></option>
                                    <?php foreach ($stocks as $stock): ?>
                                        <option value="<?php echo $stock['symbol']; ?>">
                                            <?php echo $stock['symbol']; ?> - <?php echo $stock['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label"><?php echo getTranslation('Quantity', $_SESSION['language']); ?></label>
                                <input type="number" class="form-control" id="quantity" min="1" required>
                            </div>
                            <div id="trade-preview"></div>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-success" id="buy-stock">
                                    <i class="fas fa-plus me-2"></i>
                                    <?php echo getTranslation('Buy', $_SESSION['language']); ?>
                                </button>
                                <button type="button" class="btn btn-danger" id="sell-stock">
                                    <i class="fas fa-minus me-2"></i>
                                    <?php echo getTranslation('Sell', $_SESSION['language']); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Market Overview -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line text-info me-2"></i>
                            <?php echo getTranslation('Market Overview', $_SESSION['language']); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($stocks as $stock): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="trading-card">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1"><?php echo $stock['symbol']; ?></h6>
                                                <small class="text-muted"><?php echo $stock['name']; ?></small>
                                            </div>
                                            <div class="text-end">
                                                <div class="stock-price">₹<?php echo number_format($stock['current_price'], 2); ?></div>
                                                <div class="stock-change <?php echo $stock['change_percent'] >= 0 ? 'positive' : 'negative'; ?>">
                                                    <?php echo ($stock['change_percent'] >= 0 ? '+' : '') . number_format($stock['change_percent'], 2); ?>%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Portfolio and Trade History -->
        <div class="row mt-4">
            <!-- Portfolio -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-briefcase text-warning me-2"></i>
                            <?php echo getTranslation('Your Portfolio', $_SESSION['language']); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($userPortfolio)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-briefcase text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3">
                                    <?php echo getTranslation('Your portfolio is empty. Start trading to build your portfolio!', $_SESSION['language']); ?>
                                </p>
                                <a href="#trade-form" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    <?php echo getTranslation('Make Your First Trade', $_SESSION['language']); ?>
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table portfolio-table" id="portfolio-table">
                                    <thead>
                                        <tr>
                                            <th><?php echo getTranslation('Stock', $_SESSION['language']); ?></th>
                                            <th><?php echo getTranslation('Quantity', $_SESSION['language']); ?></th>
                                            <th><?php echo getTranslation('Avg Buy Price', $_SESSION['language']); ?></th>
                                            <th><?php echo getTranslation('Current Price', $_SESSION['language']); ?></th>
                                            <th><?php echo getTranslation('P&L', $_SESSION['language']); ?></th>
                                            <th><?php echo getTranslation('Current Value', $_SESSION['language']); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($userPortfolio as $holding): ?>
                                            <?php
                                            $currentValue = $holding['quantity'] * $holding['current_price'];
                                            $profitLoss = $currentValue - ($holding['quantity'] * $holding['avg_buy_price']);
                                            $profitLossPercent = ($profitLoss / ($holding['quantity'] * $holding['avg_buy_price'])) * 100;
                                            ?>
                                            <tr>
                                                <td>
                                                    <strong><?php echo $holding['stock_symbol']; ?></strong><br>
                                                    <small><?php echo $holding['name']; ?></small>
                                                </td>
                                                <td><?php echo $holding['quantity']; ?></td>
                                                <td>₹<?php echo number_format($holding['avg_buy_price'], 2); ?></td>
                                                <td>₹<?php echo number_format($holding['current_price'], 2); ?></td>
                                                <td class="<?php echo $profitLoss >= 0 ? 'text-success' : 'text-danger'; ?>">
                                                    ₹<?php echo number_format($profitLoss, 2); ?>
                                                    (<?php echo number_format($profitLossPercent, 2); ?>%)
                                                </td>
                                                <td>₹<?php echo number_format($currentValue, 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Recent Trades -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-history text-secondary me-2"></i>
                            <?php echo getTranslation('Recent Trades', $_SESSION['language']); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($userTrades)): ?>
                            <p class="text-muted text-center">
                                <?php echo getTranslation('No trades yet. Start trading to see your history!', $_SESSION['language']); ?>
                            </p>
                        <?php else: ?>
                            <?php foreach (array_slice($userTrades, 0, 10) as $trade): ?>
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
