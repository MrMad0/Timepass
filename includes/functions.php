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

function getStock($symbol) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM stocks WHERE symbol = ?");
    $stmt->execute([$symbol]);
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
?>
