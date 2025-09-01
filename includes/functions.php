<?php
global $pdo;

// Translation function
function getTranslation($text, $language = 'en') {
    $translations = [
        'en' => [
            'Investor Education Platform' => 'Investor Education Platform',
            'InvestorEdu' => 'InvestorEdu',
            'Learn' => 'Learn',
            'Trading Simulator' => 'Trading Simulator',
            'Leaderboard' => 'Leaderboard',
            'Dashboard' => 'Dashboard',
            'Logout' => 'Logout',
            'Login' => 'Login',
            'Register' => 'Register',
            'Master the Stock Market' => 'Master the Stock Market',
            'Learn investing fundamentals, practice with virtual trading, and track your progress in multiple Indian languages.' => 'Learn investing fundamentals, practice with virtual trading, and track your progress in multiple Indian languages.',
            'Start Learning' => 'Start Learning',
            'Try Trading' => 'Try Trading',
            'Educational Modules' => 'Educational Modules',
            'Interactive tutorials covering stock market basics, risk assessment, and portfolio diversification.' => 'Interactive tutorials covering stock market basics, risk assessment, and portfolio diversification.',
            'Gamified Learning' => 'Gamified Learning',
            'Take quizzes, earn badges, and compete on leaderboards to stay motivated.' => 'Take quizzes, earn badges, and compete on leaderboards to stay motivated.',
            'Virtual Trading' => 'Virtual Trading',
            'Practice trading with virtual money using real market data without any risk.' => 'Practice trading with virtual money using real market data without any risk.',
            'Your Learning Progress' => 'Your Learning Progress',
            'Modules Completed' => 'Modules Completed',
            'Average Quiz Score' => 'Average Quiz Score',
            'Badges Earned' => 'Badges Earned',
            'Virtual Balance' => 'Virtual Balance',
            'Empowering retail investors through education and virtual trading practice.' => 'Empowering retail investors through education and virtual trading practice.',
            'Inspired by SEBI\'s investor education initiatives' => 'Inspired by SEBI\'s investor education initiatives'
        ],
        'hi' => [
            'Investor Education Platform' => 'निवेशक शिक्षा मंच',
            'InvestorEdu' => 'निवेशक शिक्षा',
            'Learn' => 'सीखें',
            'Trading Simulator' => 'ट्रेडिंग सिमुलेटर',
            'Leaderboard' => 'लीडरबोर्ड',
            'Dashboard' => 'डैशबोर्ड',
            'Logout' => 'लॉगआउट',
            'Login' => 'लॉगिन',
            'Register' => 'रजिस्टर',
            'Master the Stock Market' => 'शेयर बाजार में महारत हासिल करें',
            'Learn investing fundamentals, practice with virtual trading, and track your progress in multiple Indian languages.' => 'निवेश के मूल सिद्धांत सीखें, वर्चुअल ट्रेडिंग के साथ अभ्यास करें, और कई भारतीय भाषाओं में अपनी प्रगति को ट्रैक करें।',
            'Start Learning' => 'सीखना शुरू करें',
            'Try Trading' => 'ट्रेडिंग आज़माएं',
            'Educational Modules' => 'शैक्षिक मॉड्यूल',
            'Interactive tutorials covering stock market basics, risk assessment, and portfolio diversification.' => 'शेयर बाजार के मूल सिद्धांत, जोखिम मूल्यांकन और पोर्टफोलियो विविधीकरण को कवर करने वाले इंटरैक्टिव ट्यूटोरियल।',
            'Gamified Learning' => 'गेमिफाइड लर्निंग',
            'Take quizzes, earn badges, and compete on leaderboards to stay motivated.' => 'प्रेरित रहने के लिए क्विज़ लें, बैज कमाएं और लीडरबोर्ड पर प्रतिस्पर्धा करें।',
            'Virtual Trading' => 'वर्चुअल ट्रेडिंग',
            'Practice trading with virtual money using real market data without any risk.' => 'बिना किसी जोखिम के वास्तविक बाजार डेटा का उपयोग करके वर्चुअल पैसे के साथ ट्रेडिंग का अभ्यास करें।',
            'Your Learning Progress' => 'आपकी सीखने की प्रगति',
            'Modules Completed' => 'पूर्ण किए गए मॉड्यूल',
            'Average Quiz Score' => 'औसत क्विज़ स्कोर',
            'Badges Earned' => 'कमाए गए बैज',
            'Virtual Balance' => 'वर्चुअल बैलेंस',
            'Empowering retail investors through education and virtual trading practice.' => 'शिक्षा और वर्चुअल ट्रेडिंग अभ्यास के माध्यम से खुदरा निवेशकों को सशक्त बनाना।',
            'Inspired by SEBI\'s investor education initiatives' => 'सेबी के निवेशक शिक्षा पहल से प्रेरित'
        ],
        'ta' => [
            'Investor Education Platform' => 'முதலீட்டாளர் கல்வி தளம்',
            'InvestorEdu' => 'முதலீட்டாளர் கல்வி',
            'Learn' => 'கற்றுக்கொள்ளுங்கள்',
            'Trading Simulator' => 'வர்த்தக சிமுலேட்டர்',
            'Leaderboard' => 'முன்னணி பலகை',
            'Dashboard' => 'டாஷ்போர்டு',
            'Logout' => 'வெளியேறு',
            'Login' => 'உள்நுழைவு',
            'Register' => 'பதிவு',
            'Master the Stock Market' => 'பங்கு சந்தையில் மாஸ்டர் ஆகுங்கள்',
            'Learn investing fundamentals, practice with virtual trading, and track your progress in multiple Indian languages.' => 'முதலீட்டு அடிப்படைகளைக் கற்றுக்கொள்ளுங்கள், மெய்நிகர் வர்த்தகத்துடன் பயிற்சி செய்யுங்கள், மேலும் பல இந்திய மொழிகளில் உங்கள் முன்னேற்றத்தைக் கண்காணிக்கவும்.',
            'Start Learning' => 'கற்றல் தொடங்குங்கள்',
            'Try Trading' => 'வர்த்தகத்தை முயற்சிக்கவும்',
            'Educational Modules' => 'கல்வி தொகுதிகள்',
            'Interactive tutorials covering stock market basics, risk assessment, and portfolio diversification.' => 'பங்கு சந்தை அடிப்படைகள், ஆபத்து மதிப்பீடு மற்றும் போர்ட்ஃபோலியோ பன்முகத்தன்மையை உள்ளடக்கிய ஊடாடும் பயிற்சிகள்.',
            'Gamified Learning' => 'விளையாட்டு கற்றல்',
            'Take quizzes, earn badges, and compete on leaderboards to stay motivated.' => 'உந்துதலை பராமரிக்க கேள்வித்தாள்களை எடுத்து, பதக்கங்களைப் பெற்று, முன்னணி பலகைகளில் போட்டியிடுங்கள்.',
            'Virtual Trading' => 'மெய்நிகர் வர்த்தகம்',
            'Practice trading with virtual money using real market data without any risk.' => 'எந்த ஆபத்தும் இல்லாமல் உண்மையான சந்தை தரவைப் பயன்படுத்தி மெய்நிகர் பணத்துடன் வர்த்தகத்தைப் பயிற்சி செய்யுங்கள்.',
            'Your Learning Progress' => 'உங்கள் கற்றல் முன்னேற்றம்',
            'Modules Completed' => 'முடிக்கப்பட்ட தொகுதிகள்',
            'Average Quiz Score' => 'சராசரி கேள்வித்தாள் மதிப்பெண்',
            'Badges Earned' => 'பெறப்பட்ட பதக்கங்கள்',
            'Virtual Balance' => 'மெய்நிகர் இருப்பு',
            'Empowering retail investors through education and virtual trading practice.' => 'கல்வி மற்றும் மெய்நிகர் வர்த்தக பயிற்சி மூலம் சில்லறை முதலீட்டாளர்களை மேம்படுத்துதல்.',
            'Inspired by SEBI\'s investor education initiatives' => 'SEBI-ன் முதலீட்டாளர் கல்வி முயற்சிகளால் ஈர்க்கப்பட்டது'
        ]
    ];

    return isset($translations[$language][$text]) ? $translations[$language][$text] : $text;
}

// Get language name
function getLanguageName($code) {
    $languages = [
        'en' => 'English',
        'hi' => 'हिंदी',
        'ta' => 'தமிழ்',
        'te' => 'తెలుగు',
        'bn' => 'বাংলা'
    ];
    return isset($languages[$code]) ? $languages[$code] : 'English';
}

// User functions
function registerUser($username, $email, $password) {
    global $pdo;
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

function loginUser($email, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

function authenticateUser($username, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT id, username, email, password, is_admin, is_active FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password']) && $user['is_active']) {
        return $user;
    }
    return false;
}

function getUserProgress($userId) {
    global $pdo;
    
    // Get modules completed
    $stmt = $pdo->prepare("SELECT COUNT(*) as completed FROM user_progress WHERE user_id = ? AND completed = 1");
    $stmt->execute([$userId]);
    $modulesCompleted = $stmt->fetch()['completed'];
    
    // Get average quiz score
    $stmt = $pdo->prepare("SELECT AVG(quiz_score) as avg_score FROM user_progress WHERE user_id = ? AND quiz_score > 0");
    $stmt->execute([$userId]);
    $avgScore = $stmt->fetch()['avg_score'] ?: 0;
    
    // Get badges earned
    $stmt = $pdo->prepare("SELECT COUNT(*) as badges FROM user_badges WHERE user_id = ?");
    $stmt->execute([$userId]);
    $badgesEarned = $stmt->fetch()['badges'];
    
    // Get virtual balance
    $stmt = $pdo->prepare("SELECT virtual_balance FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $virtualBalance = $stmt->fetch()['virtual_balance'];
    
    return [
        'modules_completed' => $modulesCompleted,
        'quiz_score' => round($avgScore),
        'badges_earned' => $badgesEarned,
        'virtual_balance' => $virtualBalance
    ];
}

// Module functions
function getModules() {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM modules ORDER BY order_num");
    $stmt->execute();
    return $stmt->fetchAll();
}

function getModule($id) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM modules WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getQuizzes($moduleId) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM quizzes WHERE module_id = ?");
    $stmt->execute([$moduleId]);
    return $stmt->fetchAll();
}

function saveQuizResult($userId, $moduleId, $score) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("INSERT INTO user_progress (user_id, module_id, completed, quiz_score, completed_at) 
                               VALUES (?, ?, 1, ?, NOW()) 
                               ON DUPLICATE KEY UPDATE completed = 1, quiz_score = ?, completed_at = NOW()");
        $stmt->execute([$userId, $moduleId, $score, $score]);
        
        // Check for badges
        checkAndAwardBadges($userId);
        
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// Badge functions
function checkAndAwardBadges($userId) {
    global $pdo;
    
    // Get user stats
    $progress = getUserProgress($userId);
    
    // Check for First Steps badge
    if ($progress['modules_completed'] >= 1) {
        awardBadge($userId, 1);
    }
    
    // Check for Quiz Master badge
    $stmt = $pdo->prepare("SELECT COUNT(*) as perfect FROM user_progress WHERE user_id = ? AND quiz_score = 100");
    $stmt->execute([$userId]);
    if ($stmt->fetch()['perfect'] > 0) {
        awardBadge($userId, 2);
    }
    
    // Check for Market Expert badge
    if ($progress['modules_completed'] >= 8) {
        awardBadge($userId, 8);
    }
}

function awardBadge($userId, $badgeId) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("INSERT IGNORE INTO user_badges (user_id, badge_id) VALUES (?, ?)");
        $stmt->execute([$userId, $badgeId]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function getUserBadges($userId) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT b.* FROM badges b 
                           INNER JOIN user_badges ub ON b.id = ub.badge_id 
                           WHERE ub.user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

// Trading functions
function getStocks() {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM stocks ORDER BY symbol");
    $stmt->execute();
    return $stmt->fetchAll();
}

function getAllStocks() {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM stocks ORDER BY symbol");
    $stmt->execute();
    return $stmt->fetchAll();
}

function getStock($symbol) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM stocks WHERE symbol = ?");
    $stmt->execute([$symbol]);
    return $stmt->fetch();
}

function getStockById($id) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM stocks WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function executeTrade($userId, $symbol, $type, $quantity, $price) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        $totalAmount = $quantity * $price;
        
        // Get user's current balance
        $stmt = $pdo->prepare("SELECT virtual_balance FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $currentBalance = $stmt->fetch()['virtual_balance'];
        
        if ($type == 'buy') {
            if ($currentBalance < $totalAmount) {
                throw new Exception('Insufficient balance');
            }
            
            $newBalance = $currentBalance - $totalAmount;
        } else {
            // Check if user has enough shares to sell
            $stmt = $pdo->prepare("SELECT quantity FROM user_portfolio WHERE user_id = ? AND stock_symbol = ?");
            $stmt->execute([$userId, $symbol]);
            $currentShares = $stmt->fetch();
            
            if (!$currentShares || $currentShares['quantity'] < $quantity) {
                throw new Exception('Insufficient shares');
            }
            
            $newBalance = $currentBalance + $totalAmount;
        }
        
        // Update user balance
        $stmt = $pdo->prepare("UPDATE users SET virtual_balance = ? WHERE id = ?");
        $stmt->execute([$newBalance, $userId]);
        
        // Record the trade
        $stmt = $pdo->prepare("INSERT INTO user_trades (user_id, stock_symbol, trade_type, quantity, price, total_amount) 
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $symbol, $type, $quantity, $price, $totalAmount]);
        
        // Update portfolio
        if ($type == 'buy') {
            $stmt = $pdo->prepare("INSERT INTO user_portfolio (user_id, stock_symbol, quantity, avg_buy_price) 
                                   VALUES (?, ?, ?, ?) 
                                   ON DUPLICATE KEY UPDATE 
                                   quantity = quantity + ?, 
                                   avg_buy_price = ((avg_buy_price * quantity) + (? * ?)) / (quantity + ?)");
            $stmt->execute([$userId, $symbol, $quantity, $price, $quantity, $price, $quantity, $quantity]);
        } else {
            $stmt = $pdo->prepare("UPDATE user_portfolio SET quantity = quantity - ? WHERE user_id = ? AND stock_symbol = ?");
            $stmt->execute([$quantity, $userId, $symbol]);
            
            // Remove if quantity becomes 0
            $stmt = $pdo->prepare("DELETE FROM user_portfolio WHERE user_id = ? AND stock_symbol = ? AND quantity = 0");
            $stmt->execute([$userId, $symbol]);
        }
        
        $pdo->commit();
        
        // Check for trading badges
        checkTradingBadges($userId);
        
        return true;
    } catch (Exception $e) {
        $pdo->rollback();
        return false;
    }
}

function checkTradingBadges($userId) {
    global $pdo;
    
    // Check for Trader badge (first trade)
    $stmt = $pdo->prepare("SELECT COUNT(*) as trades FROM user_trades WHERE user_id = ?");
    $stmt->execute([$userId]);
    if ($stmt->fetch()['trades'] >= 1) {
        awardBadge($userId, 6);
    }
    
    // Check for Portfolio Builder badge (5 different stocks)
    $stmt = $pdo->prepare("SELECT COUNT(*) as stocks FROM user_portfolio WHERE user_id = ? AND quantity > 0");
    $stmt->execute([$userId]);
    if ($stmt->fetch()['stocks'] >= 5) {
        awardBadge($userId, 7);
    }
}

function getUserPortfolio($userId) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT up.*, s.name, s.current_price, s.change_percent 
                           FROM user_portfolio up 
                           INNER JOIN stocks s ON up.stock_symbol = s.symbol 
                           WHERE up.user_id = ? AND up.quantity > 0");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function getUserTrades($userId) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM user_trades WHERE user_id = ? ORDER BY trade_date DESC LIMIT 20");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

// Leaderboard functions
function getLeaderboard() {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT u.username, 
                           COUNT(up.id) as modules_completed,
                           AVG(up.quiz_score) as avg_score,
                           COUNT(ub.id) as badges_earned
                           FROM users u 
                           LEFT JOIN user_progress up ON u.id = up.user_id AND up.completed = 1
                           LEFT JOIN user_badges ub ON u.id = ub.user_id
                           GROUP BY u.id, u.username
                           ORDER BY modules_completed DESC, avg_score DESC
                           LIMIT 20");
    $stmt->execute();
    return $stmt->fetchAll();
}

// Utility functions
function formatCurrency($amount) {
    return '₹' . number_format($amount, 2);
}

function formatPercentage($value) {
    return number_format($value, 1) . '%';
}

function getDifficultyColor($difficulty) {
    switch ($difficulty) {
        case 'beginner': return 'success';
        case 'intermediate': return 'warning';
        case 'advanced': return 'danger';
        default: return 'secondary';
    }
}

// Admin functions
function createAdminUser() {
    global $pdo;
    
    // Check if admin user exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = 'admin'");
    $stmt->execute();
    
    if (!$stmt->fetch()) {
        $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, is_admin, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(['admin', 'admin@investor.edu', $hashedPassword, 1, 1]);
    }
}

function getAdminStats() {
    global $pdo;
    
    $stats = [];
    
    // Total users
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $stats['total_users'] = $stmt->fetchColumn();
    
    // Total courses
    $stmt = $pdo->query("SELECT COUNT(*) FROM modules");
    $stats['total_courses'] = $stmt->fetchColumn();
    
    // Total stocks
    $stmt = $pdo->query("SELECT COUNT(*) FROM stocks");
    $stats['total_stocks'] = $stmt->fetchColumn();
    
    // Total badges
    $stmt = $pdo->query("SELECT COUNT(*) FROM badges");
    $stats['total_badges'] = $stmt->fetchColumn();
    
    // Recent users
    $stmt = $pdo->query("SELECT username, created_at FROM users ORDER BY created_at DESC LIMIT 5");
    $stats['recent_users'] = $stmt->fetchAll();
    
    // Recent trades
    $stmt = $pdo->query("SELECT stock_symbol, trade_type, quantity, price FROM user_trades ORDER BY trade_date DESC LIMIT 5");
    $stats['recent_trades'] = $stmt->fetchAll();
    
    return $stats;
}

function getAnalyticsData() {
    global $pdo;
    
    $analytics = [];
    
    // Basic stats
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $analytics['total_users'] = $stmt->fetchColumn();
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM modules");
    $analytics['total_courses'] = $stmt->fetchColumn();
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM user_trades");
    $analytics['total_trades'] = $stmt->fetchColumn();
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM user_badges");
    $analytics['total_badges_awarded'] = $stmt->fetchColumn();
    
    // New users this month
    $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)");
    $analytics['new_users_this_month'] = $stmt->fetchColumn();
    
    // Average completion rate
    $stmt = $pdo->query("SELECT AVG(completion_rate) FROM (SELECT (COUNT(CASE WHEN completed = 1 THEN 1 END) * 100.0 / COUNT(*)) as completion_rate FROM user_progress GROUP BY user_id) as rates");
    $analytics['avg_completion_rate'] = round($stmt->fetchColumn() ?: 0, 1);
    
    // Total trading volume
    $stmt = $pdo->query("SELECT SUM(total_amount) FROM user_trades");
    $analytics['total_trading_volume'] = $stmt->fetchColumn() ?: 0;
    
    // Average badges per user
    $stmt = $pdo->query("SELECT AVG(badge_count) FROM (SELECT COUNT(*) as badge_count FROM user_badges GROUP BY user_id) as counts");
    $analytics['avg_badges_per_user'] = round($stmt->fetchColumn() ?: 0, 1);
    
    // User registration trend (last 7 days)
    $labels = [];
    $data = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $labels[] = date('M d', strtotime($date));
        
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE DATE(created_at) = ?");
        $stmt->execute([$date]);
        $data[] = $stmt->fetchColumn();
    }
    $analytics['user_registration_labels'] = $labels;
    $analytics['user_registration_data'] = $data;
    
    // Course completion by difficulty
    $stmt = $pdo->query("SELECT difficulty, COUNT(*) as count FROM user_progress up JOIN modules m ON up.module_id = m.id WHERE up.completed = 1 GROUP BY difficulty");
    $difficultyData = $stmt->fetchAll();
    
    $analytics['course_completion_labels'] = array_column($difficultyData, 'difficulty');
    $analytics['course_completion_data'] = array_column($difficultyData, 'count');
    
    // Trading activity by stock
    $stmt = $pdo->query("SELECT stock_symbol, COUNT(*) as count FROM user_trades GROUP BY stock_symbol ORDER BY count DESC LIMIT 10");
    $tradingData = $stmt->fetchAll();
    
    $analytics['trading_activity_labels'] = array_column($tradingData, 'stock_symbol');
    $analytics['trading_activity_data'] = array_column($tradingData, 'count');
    
    // Quiz performance distribution - Fixed SQL syntax issue
    $stmt = $pdo->query("SELECT 
        CASE 
            WHEN quiz_score <= 20 THEN '0-20%'
            WHEN quiz_score <= 40 THEN '21-40%'
            WHEN quiz_score <= 60 THEN '41-60%'
            WHEN quiz_score <= 80 THEN '61-80%'
            ELSE '81-100%'
        END as score_range,
        COUNT(*) as count
        FROM user_progress 
        WHERE quiz_score > 0 
        GROUP BY score_range 
        ORDER BY score_range");
    $quizData = $stmt->fetchAll();
    
    $analytics['quiz_performance_data'] = array_column($quizData, 'count');
    
    // Top performing users
    $stmt = $pdo->query("SELECT 
        u.username, u.created_at,
        COUNT(CASE WHEN up.completed = 1 THEN 1 END) as courses_completed,
        COUNT(up.id) as total_courses,
        AVG(up.quiz_score) as avg_quiz_score,
        COUNT(ub.id) as badges_earned,
        COALESCE(SUM(portfolio_value - 100000), 0) as trading_pnl
        FROM users u
        LEFT JOIN user_progress up ON u.id = up.user_id
        LEFT JOIN user_badges ub ON u.id = ub.user_id
        LEFT JOIN (
            SELECT user_id, SUM(quantity * current_price) as portfolio_value
            FROM user_portfolio up
            JOIN stocks s ON up.stock_symbol = s.symbol
            GROUP BY user_id
        ) p ON u.id = p.user_id
        GROUP BY u.id
        ORDER BY courses_completed DESC, avg_quiz_score DESC
        LIMIT 10");
    $analytics['top_users'] = $stmt->fetchAll();
    
    // Recent activity
    $analytics['recent_activity'] = [];
    
    // Recent user registrations
    $stmt = $pdo->query("SELECT username, created_at FROM users ORDER BY created_at DESC LIMIT 3");
    $recentUsers = $stmt->fetchAll();
    foreach ($recentUsers as $user) {
        $analytics['recent_activity'][] = [
            'type' => 'user',
            'type_color' => 'primary',
            'icon' => 'user-plus',
            'description' => "New user registered: {$user['username']}",
            'time_ago' => timeAgo($user['created_at'])
        ];
    }
    
    // Recent trades
    $stmt = $pdo->query("SELECT stock_symbol, trade_type, quantity, trade_date FROM user_trades ORDER BY trade_date DESC LIMIT 3");
    $recentTrades = $stmt->fetchAll();
    foreach ($recentTrades as $trade) {
        $analytics['recent_activity'][] = [
            'type' => 'trade',
            'type_color' => $trade['trade_type'] == 'buy' ? 'success' : 'danger',
            'icon' => $trade['trade_type'] == 'buy' ? 'arrow-up' : 'arrow-down',
            'description' => "{$trade['trade_type']} {$trade['quantity']} shares of {$trade['stock_symbol']}",
            'time_ago' => timeAgo($trade['trade_date'])
        ];
    }
    
    // Stock performance
    $stmt = $pdo->query("SELECT symbol, current_price, change_percent, volume FROM stocks ORDER BY ABS(change_percent) DESC LIMIT 10");
    $analytics['stock_performance'] = $stmt->fetchAll();
    
    // Badge distribution
    $stmt = $pdo->query("SELECT b.name, b.icon, COUNT(ub.id) as count, 
        (COUNT(ub.id) * 100.0 / (SELECT COUNT(*) FROM users)) as percentage
        FROM badges b
        LEFT JOIN user_badges ub ON b.id = ub.badge_id
        GROUP BY b.id
        ORDER BY count DESC");
    $analytics['badge_distribution'] = $stmt->fetchAll();
    
    return $analytics;
}

function getAllUsers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

function getUserById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function updateUserByAdmin($data) {
    global $pdo;
    
    try {
        $updates = [];
        $params = [];
        
        if (!empty($data['username'])) {
            $updates[] = "username = ?";
            $params[] = $data['username'];
        }
        
        if (!empty($data['email'])) {
            $updates[] = "email = ?";
            $params[] = $data['email'];
        }
        
        if (!empty($data['new_password'])) {
            $updates[] = "password = ?";
            $params[] = password_hash($data['new_password'], PASSWORD_DEFAULT);
        }
        
        if (isset($data['virtual_balance'])) {
            $updates[] = "virtual_balance = ?";
            $params[] = $data['virtual_balance'];
        }
        
        if (isset($data['is_admin'])) {
            $updates[] = "is_admin = ?";
            $params[] = $data['is_admin'] ? 1 : 0;
        }
        
        $params[] = $data['user_id'];
        
        $sql = "UPDATE users SET " . implode(', ', $updates) . " WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        
        return "User updated successfully!";
    } catch (PDOException $e) {
        return "Error updating user: " . $e->getMessage();
    }
}

function deleteUserByAdmin($userId) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // Delete user's data from all related tables
        $pdo->prepare("DELETE FROM user_progress WHERE user_id = ?")->execute([$userId]);
        $pdo->prepare("DELETE FROM user_badges WHERE user_id = ?")->execute([$userId]);
        $pdo->prepare("DELETE FROM user_trades WHERE user_id = ?")->execute([$userId]);
        $pdo->prepare("DELETE FROM user_portfolio WHERE user_id = ?")->execute([$userId]);
        $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$userId]);
        
        $pdo->commit();
        return "User deleted successfully!";
    } catch (PDOException $e) {
        $pdo->rollBack();
        return "Error deleting user: " . $e->getMessage();
    }
}

function toggleUserAdminStatus($userId) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("UPDATE users SET is_admin = NOT is_admin WHERE id = ?");
        $stmt->execute([$userId]);
        
        return "User admin status updated successfully!";
    } catch (PDOException $e) {
        return "Error updating admin status: " . $e->getMessage();
    }
}

function getAllCourses() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM modules ORDER BY order_num, id");
    return $stmt->fetchAll();
}

function getCourseById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM modules WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function addCourse($data, $files) {
    global $pdo;
    
    try {
        $videoUrl = '';
        $thumbnail = '';
        $youtubeUrl = '';
        
        // Handle video type
        $videoType = $data['video_type'] ?? 'file';
        
        if ($videoType == 'youtube') {
            // Handle YouTube URL
            if (!empty($data['youtube_url'])) {
                $youtubeUrl = trim($data['youtube_url']);
            }
        } else {
            // Handle video file upload
            if (isset($files['video_file']) && $files['video_file']['error'] == 0) {
                $videoFile = $files['video_file'];
                $videoExt = pathinfo($videoFile['name'], PATHINFO_EXTENSION);
                $videoUrl = uniqid() . '.' . $videoExt;
                $videoPath = '../uploads/videos/' . $videoUrl;
                
                if (!move_uploaded_file($videoFile['tmp_name'], $videoPath)) {
                    return "Error uploading video file.";
                }
            }
        }
        
        // Handle thumbnail upload
        if (isset($files['thumbnail']) && $files['thumbnail']['error'] == 0) {
            $thumbFile = $files['thumbnail'];
            $thumbExt = pathinfo($thumbFile['name'], PATHINFO_EXTENSION);
            $thumbnail = uniqid() . '.' . $thumbExt;
            $thumbPath = '../uploads/thumbnails/' . $thumbnail;
            
            if (!move_uploaded_file($thumbFile['tmp_name'], $thumbPath)) {
                return "Error uploading thumbnail.";
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO modules (title, description, content, difficulty, order_num, video_url, thumbnail, youtube_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['title'],
            $data['description'],
            $data['content'],
            $data['difficulty'],
            $data['order_num'],
            $videoUrl,
            $thumbnail,
            $youtubeUrl
        ]);
        
        return "Course added successfully!";
    } catch (PDOException $e) {
        return "Error adding course: " . $e->getMessage();
    }
}

function updateCourse($data, $files) {
    global $pdo;
    
    try {
        // First, ensure all required columns exist
        updateExistingTables($pdo);
        
        $updates = [];
        $params = [];
        
        $updates[] = "title = ?";
        $params[] = $data['title'];
        
        $updates[] = "description = ?";
        $params[] = $data['description'];
        
        $updates[] = "content = ?";
        $params[] = $data['content'];
        
        $updates[] = "difficulty = ?";
        $params[] = $data['difficulty'];
        
        $updates[] = "order_num = ?";
        $params[] = $data['order_num'];
        
        // Handle video type
        $videoType = $data['video_type'] ?? 'file';
        
        if ($videoType == 'youtube') {
            // Handle YouTube URL
            if (!empty($data['youtube_url'])) {
                $updates[] = "youtube_url = ?";
                $params[] = trim($data['youtube_url']);
                
                // Clear video_url if switching to YouTube
                $updates[] = "video_url = ?";
                $params[] = '';
            }
        } else {
            // Handle video file upload
            if (isset($files['video_file']) && $files['video_file']['error'] == 0) {
                $videoFile = $files['video_file'];
                $videoExt = pathinfo($videoFile['name'], PATHINFO_EXTENSION);
                $videoUrl = uniqid() . '.' . $videoExt;
                $videoPath = '../uploads/videos/' . $videoUrl;
                
                if (move_uploaded_file($videoFile['tmp_name'], $videoPath)) {
                    $updates[] = "video_url = ?";
                    $params[] = $videoUrl;
                    
                    // Clear youtube_url if switching to uploaded video
                    $updates[] = "youtube_url = ?";
                    $params[] = '';
                }
            } else {
                // No new video file uploaded, but switching from YouTube to file type
                // Clear youtube_url and keep existing video_url (if any)
                $updates[] = "youtube_url = ?";
                $params[] = '';
            }
        }
        
        // Handle thumbnail upload
        if (isset($files['thumbnail']) && $files['thumbnail']['error'] == 0) {
            $thumbFile = $files['thumbnail'];
            $thumbExt = pathinfo($thumbFile['name'], PATHINFO_EXTENSION);
            $thumbnail = uniqid() . '.' . $thumbExt;
            $thumbPath = '../uploads/thumbnails/' . $thumbnail;
            
            if (move_uploaded_file($thumbFile['tmp_name'], $thumbPath)) {
                $updates[] = "thumbnail = ?";
                $params[] = $thumbnail;
            }
        }
        
        $params[] = $data['course_id'];
        
        $sql = "UPDATE modules SET " . implode(', ', $updates) . " WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        
        return "Course updated successfully!";
    } catch (PDOException $e) {
        return "Error updating course: " . $e->getMessage();
    }
}

function deleteCourse($courseId) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // Delete related quizzes
        $pdo->prepare("DELETE FROM quizzes WHERE module_id = ?")->execute([$courseId]);
        
        // Delete user progress
        $pdo->prepare("DELETE FROM user_progress WHERE module_id = ?")->execute([$courseId]);
        
        // Delete the course
        $pdo->prepare("DELETE FROM modules WHERE id = ?")->execute([$courseId]);
        
        $pdo->commit();
        return "Course deleted successfully!";
    } catch (PDOException $e) {
        $pdo->rollBack();
        return "Error deleting course: " . $e->getMessage();
    }
}

function addStock($data) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("INSERT INTO stocks (symbol, name, sector, current_price, change_percent, volume, market_cap) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['symbol'],
            $data['name'],
            $data['sector'],
            $data['current_price'],
            $data['change_percent'],
            $data['volume'],
            $data['market_cap']
        ]);
        
        return "Stock added successfully!";
    } catch (PDOException $e) {
        return "Error adding stock: " . $e->getMessage();
    }
}

function updateStock($data) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("UPDATE stocks SET symbol = ?, name = ?, sector = ?, current_price = ?, change_percent = ?, volume = ?, market_cap = ? WHERE id = ?");
        $stmt->execute([
            $data['symbol'],
            $data['name'],
            $data['sector'],
            $data['current_price'],
            $data['change_percent'],
            $data['volume'],
            $data['market_cap'],
            $data['stock_id']
        ]);
        
        return "Stock updated successfully!";
    } catch (PDOException $e) {
        return "Error updating stock: " . $e->getMessage();
    }
}

function deleteStock($stockId) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // Delete related trades and portfolio entries
        $pdo->prepare("DELETE FROM user_trades WHERE stock_symbol = (SELECT symbol FROM stocks WHERE id = ?)")->execute([$stockId]);
        $pdo->prepare("DELETE FROM user_portfolio WHERE stock_symbol = (SELECT symbol FROM stocks WHERE id = ?)")->execute([$stockId]);
        
        // Delete the stock
        $pdo->prepare("DELETE FROM stocks WHERE id = ?")->execute([$stockId]);
        
        $pdo->commit();
        return "Stock deleted successfully!";
    } catch (PDOException $e) {
        $pdo->rollBack();
        return "Error deleting stock: " . $e->getMessage();
    }
}

function bulkUpdateStockPrices($data) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        if (isset($data['prices']) && isset($data['changes'])) {
            foreach ($data['prices'] as $stockId => $price) {
                $change = $data['changes'][$stockId] ?? 0;
                
                $stmt = $pdo->prepare("UPDATE stocks SET current_price = ?, change_percent = ? WHERE id = ?");
                $stmt->execute([$price, $change, $stockId]);
            }
        }
        
        $pdo->commit();
        return "Stock prices updated successfully!";
    } catch (PDOException $e) {
        $pdo->rollBack();
        return "Error updating stock prices: " . $e->getMessage();
    }
}

function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    
    if ($time < 60) {
        return "Just now";
    } elseif ($time < 3600) {
        $minutes = floor($time / 60);
        return $minutes . " minute" . ($minutes > 1 ? "s" : "") . " ago";
    } elseif ($time < 86400) {
        $hours = floor($time / 3600);
        return $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
    } else {
        $days = floor($time / 86400);
        return $days . " day" . ($days > 1 ? "s" : "") . " ago";
    }
}

function getYouTubeEmbedUrl($url) {
    // Extract video ID from various YouTube URL formats
    $videoId = '';
    
    // Handle different YouTube URL formats
    if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
        $videoId = $matches[1];
    } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
        $videoId = $matches[1];
    } elseif (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
        $videoId = $matches[1];
    }
    
    if ($videoId) {
        return "https://www.youtube.com/embed/{$videoId}";
    }
    
    return $url; // Return original URL if no video ID found
}
?>
