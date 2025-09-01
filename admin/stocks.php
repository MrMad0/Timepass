<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit();
}

$action = $_GET['action'] ?? 'list';
$message = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $message = addStock($_POST);
                break;
            case 'update':
                $message = updateStock($_POST);
                break;
            case 'delete':
                $message = deleteStock($_POST['stock_id']);
                break;
            case 'bulk_update':
                $message = bulkUpdateStockPrices($_POST);
                break;
        }
    }
}

// Get stocks for listing
$stocks = getAllStocks();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Stocks - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/admin.css" rel="stylesheet">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-header">
                <h1>Manage Stocks</h1>
                <div class="header-actions">
                    <button class="btn btn-outline-success" onclick="bulkUpdatePrices()">
                        <i class="fas fa-sync"></i> Bulk Update Prices
                    </button>
                    <a href="?action=add" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Stock
                    </a>
                </div>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?php if ($action == 'add' || $action == 'edit'): ?>
                <!-- Add/Edit Stock Form -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-<?php echo $action == 'add' ? 'plus' : 'edit'; ?>"></i> 
                            <?php echo $action == 'add' ? 'Add New Stock' : 'Edit Stock'; ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="<?php echo $action; ?>">
                            <?php if ($action == 'edit'): ?>
                                <input type="hidden" name="stock_id" value="<?php echo $_GET['id']; ?>">
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="symbol" class="form-label">Stock Symbol *</label>
                                        <input type="text" class="form-control" id="symbol" name="symbol" 
                                               value="<?php echo isset($_GET['id']) ? getStockById($_GET['id'])['symbol'] : ''; ?>" 
                                               maxlength="10" required>
                                        <small class="form-text text-muted">Maximum 10 characters</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Company Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo isset($_GET['id']) ? getStockById($_GET['id'])['name'] : ''; ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="sector" class="form-label">Sector</label>
                                        <select class="form-select" id="sector" name="sector">
                                            <option value="">Select Sector</option>
                                            <option value="IT" <?php echo (isset($_GET['id']) && getStockById($_GET['id'])['sector'] == 'IT') ? 'selected' : ''; ?>>IT</option>
                                            <option value="Banking" <?php echo (isset($_GET['id']) && getStockById($_GET['id'])['sector'] == 'Banking') ? 'selected' : ''; ?>>Banking</option>
                                            <option value="Oil & Gas" <?php echo (isset($_GET['id']) && getStockById($_GET['id'])['sector'] == 'Oil & Gas') ? 'selected' : ''; ?>>Oil & Gas</option>
                                            <option value="FMCG" <?php echo (isset($_GET['id']) && getStockById($_GET['id'])['sector'] == 'FMCG') ? 'selected' : ''; ?>>FMCG</option>
                                            <option value="Telecom" <?php echo (isset($_GET['id']) && getStockById($_GET['id'])['sector'] == 'Telecom') ? 'selected' : ''; ?>>Telecom</option>
                                            <option value="Pharma" <?php echo (isset($_GET['id']) && getStockById($_GET['id'])['sector'] == 'Pharma') ? 'selected' : ''; ?>>Pharma</option>
                                            <option value="Auto" <?php echo (isset($_GET['id']) && getStockById($_GET['id'])['sector'] == 'Auto') ? 'selected' : ''; ?>>Auto</option>
                                            <option value="Real Estate" <?php echo (isset($_GET['id']) && getStockById($_GET['id'])['sector'] == 'Real Estate') ? 'selected' : ''; ?>>Real Estate</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="current_price" class="form-label">Current Price *</label>
                                        <input type="number" class="form-control" id="current_price" name="current_price" 
                                               value="<?php echo isset($_GET['id']) ? getStockById($_GET['id'])['current_price'] : ''; ?>" 
                                               step="0.01" min="0" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="change_percent" class="form-label">Change %</label>
                                        <input type="number" class="form-control" id="change_percent" name="change_percent" 
                                               value="<?php echo isset($_GET['id']) ? getStockById($_GET['id'])['change_percent'] : '0'; ?>" 
                                               step="0.01">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="volume" class="form-label">Volume</label>
                                        <input type="number" class="form-control" id="volume" name="volume" 
                                               value="<?php echo isset($_GET['id']) ? getStockById($_GET['id'])['volume'] : '0'; ?>" 
                                               min="0">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="market_cap" class="form-label">Market Cap (₹)</label>
                                        <input type="number" class="form-control" id="market_cap" name="market_cap" 
                                               value="<?php echo isset($_GET['id']) ? getStockById($_GET['id'])['market_cap'] : '0'; ?>" 
                                               min="0">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="stocks.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> 
                                    <?php echo $action == 'add' ? 'Add Stock' : 'Update Stock'; ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <!-- Stock List -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-bar"></i> All Stocks (<?php echo count($stocks); ?>)</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Symbol</th>
                                        <th>Company Name</th>
                                        <th>Sector</th>
                                        <th>Price</th>
                                        <th>Change %</th>
                                        <th>Volume</th>
                                        <th>Market Cap</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stocks as $stock): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($stock['symbol']); ?></strong>
                                        </td>
                                        <td><?php echo htmlspecialchars($stock['name']); ?></td>
                                        <td>
                                            <span class="badge bg-secondary"><?php echo htmlspecialchars($stock['sector']); ?></span>
                                        </td>
                                        <td>₹<?php echo number_format($stock['current_price'], 2); ?></td>
                                        <td>
                                            <span class="text-<?php echo $stock['change_percent'] >= 0 ? 'success' : 'danger'; ?>">
                                                <i class="fas fa-arrow-<?php echo $stock['change_percent'] >= 0 ? 'up' : 'down'; ?>"></i>
                                                <?php echo number_format($stock['change_percent'], 2); ?>%
                                            </span>
                                        </td>
                                        <td><?php echo number_format($stock['volume']); ?></td>
                                        <td>₹<?php echo number_format($stock['market_cap']); ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="?action=edit&id=<?php echo $stock['id']; ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="deleteStock(<?php echo $stock['id']; ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Stock Statistics -->
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5>Total Stocks</h5>
                                <h3><?php echo count($stocks); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5>Gainers</h5>
                                <h3><?php echo count(array_filter($stocks, function($s) { return $s['change_percent'] > 0; })); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h5>Losers</h5>
                                <h3><?php echo count(array_filter($stocks, function($s) { return $s['change_percent'] < 0; })); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5>Total Market Cap</h5>
                                <h3>₹<?php echo number_format(array_sum(array_column($stocks, 'market_cap')) / 1000000000, 1); ?>B</h3>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this stock? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="stock_id" id="deleteStockId">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Update Modal -->
    <div class="modal fade" id="bulkUpdateModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Update Stock Prices</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="bulkUpdateForm">
                        <input type="hidden" name="action" value="bulk_update">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Symbol</th>
                                        <th>Current Price</th>
                                        <th>New Price</th>
                                        <th>Change %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stocks as $stock): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($stock['symbol']); ?></td>
                                        <td>₹<?php echo number_format($stock['current_price'], 2); ?></td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" 
                                                   name="prices[<?php echo $stock['id']; ?>]" 
                                                   value="<?php echo $stock['current_price']; ?>" 
                                                   step="0.01" min="0">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" 
                                                   name="changes[<?php echo $stock['id']; ?>]" 
                                                   value="<?php echo $stock['change_percent']; ?>" 
                                                   step="0.01">
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="bulkUpdateForm" class="btn btn-success">
                        <i class="fas fa-sync"></i> Update All Prices
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
    <script>
        function deleteStock(stockId) {
            document.getElementById('deleteStockId').value = stockId;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
        
        function bulkUpdatePrices() {
            new bootstrap.Modal(document.getElementById('bulkUpdateModal')).show();
        }
    </script>
</body>
</html>
