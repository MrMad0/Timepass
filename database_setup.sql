-- Investor Education Platform Database Setup
-- Complete SQL file for setting up the database, tables, and sample data

-- Create database
CREATE DATABASE IF NOT EXISTS investor_edu CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE investor_edu;

-- Drop existing tables if they exist (for clean setup)
DROP TABLE IF EXISTS user_portfolio;
DROP TABLE IF EXISTS user_trades;
DROP TABLE IF EXISTS user_badges;
DROP TABLE IF EXISTS user_progress;
DROP TABLE IF EXISTS quizzes;
DROP TABLE IF EXISTS badges;
DROP TABLE IF EXISTS stocks;
DROP TABLE IF EXISTS modules;
DROP TABLE IF EXISTS users;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    virtual_balance DECIMAL(15,2) DEFAULT 100000.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Modules table
CREATE TABLE modules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    content TEXT,
    difficulty ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'beginner',
    order_num INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Quizzes table
CREATE TABLE quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    module_id INT,
    question TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_answer CHAR(1) NOT NULL,
    explanation TEXT,
    FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE
);

-- User progress table
CREATE TABLE user_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    module_id INT,
    completed BOOLEAN DEFAULT FALSE,
    quiz_score INT DEFAULT 0,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE
);

-- Badges table
CREATE TABLE badges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    icon VARCHAR(50),
    criteria VARCHAR(255)
);

-- User badges table
CREATE TABLE user_badges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    badge_id INT,
    earned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE CASCADE
);

-- Stocks table (for trading simulator)
CREATE TABLE stocks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    symbol VARCHAR(10) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    sector VARCHAR(100),
    current_price DECIMAL(10,2) DEFAULT 0.00,
    change_percent DECIMAL(5,2) DEFAULT 0.00,
    volume BIGINT DEFAULT 0,
    market_cap DECIMAL(15,2) DEFAULT 0.00
);

-- User trades table
CREATE TABLE user_trades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    stock_symbol VARCHAR(10),
    trade_type ENUM('buy', 'sell') NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total_amount DECIMAL(15,2) NOT NULL,
    trade_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- User portfolio table
CREATE TABLE user_portfolio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    stock_symbol VARCHAR(10),
    quantity INT DEFAULT 0,
    avg_buy_price DECIMAL(10,2) DEFAULT 0.00,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_stock (user_id, stock_symbol)
);

-- Insert sample modules
INSERT INTO modules (title, description, content, difficulty, order_num) VALUES 
('Stock Market Basics', 'Learn the fundamentals of stock market investing', 'This module covers the basic concepts of stock market investing including what stocks are, how the market works, and basic terminology. You will learn about market participants, types of orders, and how to read stock quotes.', 'beginner', 1),
('Risk Assessment', 'Understanding and managing investment risks', 'Learn about different types of investment risks including market risk, company-specific risk, and systematic risk. Understand how to assess your risk tolerance and create a risk management strategy.', 'beginner', 2),
('Portfolio Diversification', 'How to build a balanced investment portfolio', 'Discover the importance of diversification and how to build a well-balanced portfolio. Learn about asset allocation, sector diversification, and how to reduce portfolio risk through proper diversification.', 'intermediate', 3),
('Technical Analysis', 'Reading charts and technical indicators', 'Master the art of technical analysis including chart patterns, trend analysis, support and resistance levels, and popular technical indicators like moving averages, RSI, and MACD.', 'intermediate', 4),
('Fundamental Analysis', 'Evaluating company fundamentals', 'Learn how to analyze company financial statements, evaluate business models, and assess company valuation. Understand key financial ratios and how to use them in investment decisions.', 'intermediate', 5),
('Algo Trading Basics', 'Introduction to algorithmic trading', 'Get introduced to algorithmic trading concepts, automated trading strategies, and the technology behind modern trading systems. Learn about backtesting and strategy development.', 'advanced', 6),
('High-Frequency Trading', 'Understanding HFT and its implications', 'Explore the world of high-frequency trading, its impact on markets, and the technology that drives it. Understand the regulatory environment and market microstructure.', 'advanced', 7),
('SEBI Regulations', 'Important regulations for Indian investors', 'Learn about SEBI regulations, investor protection mechanisms, trading rules, and compliance requirements for Indian stock market participants.', 'beginner', 8);

-- Insert sample stocks
INSERT INTO stocks (symbol, name, sector, current_price, change_percent, volume, market_cap) VALUES 
('RELIANCE', 'Reliance Industries Ltd', 'Oil & Gas', 2450.00, 2.5, 1500000, 1650000000000),
('TCS', 'Tata Consultancy Services Ltd', 'IT', 3850.00, -1.2, 800000, 1400000000000),
('HDFCBANK', 'HDFC Bank Ltd', 'Banking', 1650.00, 0.8, 2000000, 950000000000),
('INFY', 'Infosys Ltd', 'IT', 1450.00, 1.5, 1200000, 600000000000),
('ICICIBANK', 'ICICI Bank Ltd', 'Banking', 950.00, -0.5, 1800000, 650000000000),
('HINDUNILVR', 'Hindustan Unilever Ltd', 'FMCG', 2800.00, 0.3, 500000, 650000000000),
('ITC', 'ITC Ltd', 'FMCG', 450.00, 1.8, 3000000, 550000000000),
('SBIN', 'State Bank of India', 'Banking', 650.00, 2.1, 2500000, 580000000000),
('BHARTIARTL', 'Bharti Airtel Ltd', 'Telecom', 850.00, 1.2, 1200000, 480000000000),
('AXISBANK', 'Axis Bank Ltd', 'Banking', 750.00, -0.8, 1500000, 230000000000);

-- Insert badges
INSERT INTO badges (name, description, icon, criteria) VALUES 
('First Steps', 'Complete your first module', 'fas fa-star', 'Complete 1 module'),
('Quiz Master', 'Score 100% on any quiz', 'fas fa-trophy', 'Score 100% on quiz'),
('Diversifier', 'Complete portfolio diversification module', 'fas fa-chart-pie', 'Complete module 3'),
('Risk Manager', 'Complete risk assessment module', 'fas fa-shield-alt', 'Complete module 2'),
('Advanced Learner', 'Complete an advanced module', 'fas fa-graduation-cap', 'Complete advanced module'),
('Trader', 'Make your first virtual trade', 'fas fa-chart-line', 'Make first trade'),
('Portfolio Builder', 'Hold 5 different stocks', 'fas fa-building', 'Hold 5 stocks'),
('Market Expert', 'Complete all modules', 'fas fa-crown', 'Complete all modules'),
('Consistent Learner', 'Complete 5 modules', 'fas fa-book', 'Complete 5 modules'),
('Stock Picker', 'Make 10 successful trades', 'fas fa-bullseye', 'Make 10 trades');

-- Insert sample quizzes for modules
INSERT INTO quizzes (module_id, question, option_a, option_b, option_c, option_d, correct_answer, explanation) VALUES 
(1, 'What is a stock?', 'A type of bond', 'A share of ownership in a company', 'A government security', 'A mutual fund', 'B', 'A stock represents ownership in a company. When you buy a stock, you become a shareholder and own a portion of that company.'),
(1, 'What does IPO stand for?', 'Initial Public Offering', 'International Portfolio Option', 'Investment Portfolio Order', 'Individual Purchase Order', 'A', 'IPO stands for Initial Public Offering, which is when a private company first sells shares to the public.'),
(1, 'What is the primary purpose of a stock exchange?', 'To provide entertainment', 'To facilitate buying and selling of securities', 'To collect taxes', 'To provide loans', 'B', 'Stock exchanges provide a platform where buyers and sellers can trade securities like stocks and bonds.'),
(2, 'What is market risk?', 'Risk of company bankruptcy', 'Risk of losing money due to market fluctuations', 'Risk of fraud', 'Risk of inflation', 'B', 'Market risk is the risk of losing money due to overall market movements that affect all stocks.'),
(2, 'What is diversification?', 'Investing all money in one stock', 'Spreading investments across different assets', 'Timing the market', 'Following market trends', 'B', 'Diversification means spreading your investments across different assets to reduce risk.'),
(3, 'What is asset allocation?', 'Choosing individual stocks', 'Deciding how much to invest in different asset classes', 'Timing the market', 'Following market news', 'B', 'Asset allocation is the process of deciding how much of your portfolio to invest in different asset classes like stocks, bonds, and cash.'),
(4, 'What is a moving average?', 'A type of bond', 'A technical indicator that shows average price over time', 'A company\'s average revenue', 'A market index', 'B', 'A moving average is a technical indicator that calculates the average price of a security over a specific period.'),
(5, 'What is P/E ratio?', 'Price to Earnings ratio', 'Profit to Expense ratio', 'Portfolio to Equity ratio', 'Purchase to Exit ratio', 'A', 'P/E ratio (Price to Earnings ratio) compares a company\'s stock price to its earnings per share.'),
(6, 'What is backtesting?', 'Testing a trading strategy on historical data', 'Testing software bugs', 'Testing market conditions', 'Testing investor psychology', 'A', 'Backtesting involves testing a trading strategy on historical data to see how it would have performed.'),
(7, 'What is latency in HFT?', 'The time it takes to execute a trade', 'The time it takes to process data', 'The time it takes to send orders', 'All of the above', 'D', 'Latency in HFT refers to the time delay in processing and executing trades, which is critical for high-frequency trading.'),
(8, 'What does SEBI stand for?', 'Securities and Exchange Board of India', 'Stock Exchange Board of India', 'Securities Exchange Bureau of India', 'Stock and Exchange Bureau of India', 'A', 'SEBI stands for Securities and Exchange Board of India, the regulatory body for securities and commodity market in India.');

-- Create indexes for better performance
CREATE INDEX idx_user_progress_user_id ON user_progress(user_id);
CREATE INDEX idx_user_progress_module_id ON user_progress(module_id);
CREATE INDEX idx_user_trades_user_id ON user_trades(user_id);
CREATE INDEX idx_user_trades_stock_symbol ON user_trades(stock_symbol);
CREATE INDEX idx_user_portfolio_user_id ON user_portfolio(user_id);
CREATE INDEX idx_quizzes_module_id ON quizzes(module_id);

-- Show completion message
SELECT 'Database setup completed successfully!' AS status;
