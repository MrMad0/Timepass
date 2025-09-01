<?php
// Database configuration
$host = 'localhost';
$dbname = 'investor_edu';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Update existing tables to ensure all required columns exist
    updateExistingTables($pdo);
} catch(PDOException $e) {
    // If database doesn't exist, create it
    if ($e->getCode() == 1049) {
        $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("CREATE DATABASE $dbname CHARACTER SET utf8 COLLATE utf8_unicode_ci");
        $pdo->exec("USE $dbname");
        createTables($pdo);
    } else {
        die("Connection failed: " . $e->getMessage());
    }
}

function createTables($pdo) {
    // Users table
    $pdo->exec("CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        virtual_balance DECIMAL(15,2) DEFAULT 100000.00,
        is_admin BOOLEAN DEFAULT FALSE,
        is_active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Modules table
    $pdo->exec("CREATE TABLE modules (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        content TEXT,
        difficulty ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'beginner',
        order_num INT DEFAULT 0,
        video_url VARCHAR(255),
        thumbnail VARCHAR(255),
        youtube_url VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Quizzes table
    $pdo->exec("CREATE TABLE quizzes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        module_id INT,
        question TEXT NOT NULL,
        option_a VARCHAR(255) NOT NULL,
        option_b VARCHAR(255) NOT NULL,
        option_c VARCHAR(255) NOT NULL,
        option_d VARCHAR(255) NOT NULL,
        correct_answer CHAR(1) NOT NULL,
        explanation TEXT,
        FOREIGN KEY (module_id) REFERENCES modules(id)
    )");

    // User progress table
    $pdo->exec("CREATE TABLE user_progress (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        module_id INT,
        completed BOOLEAN DEFAULT FALSE,
        quiz_score INT DEFAULT 0,
        completed_at TIMESTAMP NULL,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (module_id) REFERENCES modules(id)
    )");

    // Badges table
    $pdo->exec("CREATE TABLE badges (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        icon VARCHAR(50),
        criteria VARCHAR(255)
    )");

    // User badges table
    $pdo->exec("CREATE TABLE user_badges (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        badge_id INT,
        earned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (badge_id) REFERENCES badges(id)
    )");

    // Stocks table (for trading simulator)
    $pdo->exec("CREATE TABLE stocks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        symbol VARCHAR(10) UNIQUE NOT NULL,
        name VARCHAR(100) NOT NULL,
        sector VARCHAR(100),
        current_price DECIMAL(10,2) DEFAULT 0.00,
        change_percent DECIMAL(5,2) DEFAULT 0.00,
        volume BIGINT DEFAULT 0,
        market_cap DECIMAL(15,2) DEFAULT 0.00
    )");

    // User trades table
    $pdo->exec("CREATE TABLE user_trades (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        stock_symbol VARCHAR(10),
        trade_type ENUM('buy', 'sell') NOT NULL,
        quantity INT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        total_amount DECIMAL(15,2) NOT NULL,
        trade_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )");

    // User portfolio table
    $pdo->exec("CREATE TABLE user_portfolio (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        stock_symbol VARCHAR(10),
        quantity INT DEFAULT 0,
        avg_buy_price DECIMAL(10,2) DEFAULT 0.00,
        last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        UNIQUE KEY unique_user_stock (user_id, stock_symbol)
    )");

    // Insert sample data
    insertSampleData($pdo);
    
    // Update existing tables if needed
    updateExistingTables($pdo);
}

function insertSampleData($pdo) {
    // Insert modules
    $modules = [
        ['Stock Market Basics', 'Learn the fundamentals of stock market investing', 'content_here', 'beginner', 1],
        ['Risk Assessment', 'Understanding and managing investment risks', 'content_here', 'beginner', 2],
        ['Portfolio Diversification', 'How to build a balanced investment portfolio', 'content_here', 'intermediate', 3],
        ['Technical Analysis', 'Reading charts and technical indicators', 'content_here', 'intermediate', 4],
        ['Fundamental Analysis', 'Evaluating company fundamentals', 'content_here', 'intermediate', 5],
        ['Algo Trading Basics', 'Introduction to algorithmic trading', 'content_here', 'advanced', 6],
        ['High-Frequency Trading', 'Understanding HFT and its implications', 'content_here', 'advanced', 7],
        ['SEBI Regulations', 'Important regulations for Indian investors', 'content_here', 'beginner', 8]
    ];

    $stmt = $pdo->prepare("INSERT INTO modules (title, description, content, difficulty, order_num) VALUES (?, ?, ?, ?, ?)");
    foreach ($modules as $module) {
        $stmt->execute($module);
    }

    // Insert sample stocks
    $stocks = [
        ['RELIANCE', 'Reliance Industries Ltd', 'Oil & Gas', 2450.00, 2.5, 1500000, 1650000000000],
        ['TCS', 'Tata Consultancy Services Ltd', 'IT', 3850.00, -1.2, 800000, 1400000000000],
        ['HDFCBANK', 'HDFC Bank Ltd', 'Banking', 1650.00, 0.8, 2000000, 950000000000],
        ['INFY', 'Infosys Ltd', 'IT', 1450.00, 1.5, 1200000, 600000000000],
        ['ICICIBANK', 'ICICI Bank Ltd', 'Banking', 950.00, -0.5, 1800000, 650000000000],
        ['HINDUNILVR', 'Hindustan Unilever Ltd', 'FMCG', 2800.00, 0.3, 500000, 650000000000],
        ['ITC', 'ITC Ltd', 'FMCG', 450.00, 1.8, 3000000, 550000000000],
        ['SBIN', 'State Bank of India', 'Banking', 650.00, 2.1, 2500000, 580000000000]
    ];

    $stmt = $pdo->prepare("INSERT INTO stocks (symbol, name, sector, current_price, change_percent, volume, market_cap) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($stocks as $stock) {
        $stmt->execute($stock);
    }

    // Insert badges
    $badges = [
        ['First Steps', 'Complete your first module', 'fas fa-star', 'Complete 1 module'],
        ['Quiz Master', 'Score 100% on any quiz', 'fas fa-trophy', 'Score 100% on quiz'],
        ['Diversifier', 'Complete portfolio diversification module', 'fas fa-chart-pie', 'Complete module 3'],
        ['Risk Manager', 'Complete risk assessment module', 'fas fa-shield-alt', 'Complete module 2'],
        ['Advanced Learner', 'Complete an advanced module', 'fas fa-graduation-cap', 'Complete advanced module'],
        ['Trader', 'Make your first virtual trade', 'fas fa-chart-line', 'Make first trade'],
        ['Portfolio Builder', 'Hold 5 different stocks', 'fas fa-building', 'Hold 5 stocks'],
        ['Market Expert', 'Complete all modules', 'fas fa-crown', 'Complete all modules']
    ];

    $stmt = $pdo->prepare("INSERT INTO badges (name, description, icon, criteria) VALUES (?, ?, ?, ?)");
    foreach ($badges as $badge) {
        $stmt->execute($badge);
    }
}

function updateExistingTables($pdo) {
    // Check and add missing columns to users table
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS is_admin BOOLEAN DEFAULT FALSE");
        $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS is_active BOOLEAN DEFAULT TRUE");
    } catch (Exception $e) {
        // Column might already exist, ignore error
    }
    
    // Check and add missing columns to modules table
    try {
        $pdo->exec("ALTER TABLE modules ADD COLUMN IF NOT EXISTS video_url VARCHAR(255)");
        $pdo->exec("ALTER TABLE modules ADD COLUMN IF NOT EXISTS thumbnail VARCHAR(255)");
        $pdo->exec("ALTER TABLE modules ADD COLUMN IF NOT EXISTS youtube_url VARCHAR(255)");
    } catch (Exception $e) {
        // Column might already exist, ignore error
    }
}
?>
