# InvestorEdu - Investor Education Platform

A comprehensive web application for investor education, featuring interactive tutorials, virtual trading simulation, and gamified learning in multiple Indian languages.

## 🎯 Problem Statement

Many retail investors lack the knowledge to navigate the securities market, leading to poor investment decisions or reliance on unverified advice. Most online sources of investor education are in English, leaving a gap in vernacular languages.

## 🚀 Features

### 📚 Educational Modules
- **8 Interactive Tutorials** covering stock market basics, risk assessment, portfolio diversification, technical analysis, fundamental analysis, algo trading, HFT, and SEBI regulations
- **Multilingual Support** for English, Hindi, Tamil, Telugu, and Bengali
- **Progressive Learning Path** with difficulty levels (Beginner, Intermediate, Advanced)

### 🎮 Gamified Learning
- **Interactive Quizzes** after each module with scoring and explanations
- **Badge System** with 8 different achievements
- **Progress Tracking** with visual progress bars and statistics
- **Leaderboard** to compete with other learners

### 💹 Virtual Trading Simulator
- **Real-time Stock Data** (simulated) for major Indian stocks
- **Portfolio Management** with buy/sell functionality
- **Risk-free Practice** with virtual ₹100,000 starting balance
- **Trade History** and performance tracking
- **P&L Analysis** with percentage gains/losses

### 👤 User Engagement
- **Personalized Dashboard** with learning progress
- **Achievement System** with badges and milestones
- **Responsive Design** optimized for mobile and desktop
- **Modern UI/UX** with Bootstrap 5 and custom styling

## 🛠️ Technology Stack

- **Backend**: PHP 7.4+ (Plain PHP with PDO)
- **Database**: MySQL 5.7+ / MariaDB
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **UI Framework**: Bootstrap 5.3.0
- **Icons**: Font Awesome 6.0.0
- **Server**: Apache/Nginx (XAMPP/LAMP compatible)

## 📋 Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher / MariaDB
- Apache/Nginx web server
- Composer (optional, for dependency management)

## 🚀 Installation & Setup

### Option 1: XAMPP/WAMP (Recommended for Development)

1. **Download and Install XAMPP**
   ```bash
   # Download from https://www.apachefriends.org/
   # Install and start Apache and MySQL services
   ```

2. **Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/investor-edu.git
   cd investor-edu
   # Copy files to htdocs folder (XAMPP) or www folder (WAMP)
   ```

3. **Database Setup**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - The application will automatically create the database and tables on first run
   - Default database name: `investor_edu`

4. **Configuration**
   - Edit `config/database.php` if you need to change database credentials
   - Default settings:
     - Host: `localhost`
     - Database: `investor_edu`
     - Username: `root`
     - Password: `` (empty)

5. **Access the Application**
   ```
   http://localhost/investor-edu/
   ```

### Option 2: Manual Setup

1. **Database Configuration**
   ```sql
   CREATE DATABASE investor_edu CHARACTER SET utf8 COLLATE utf8_unicode_ci;
   ```

2. **File Permissions**
   ```bash
   chmod 755 -R /path/to/investor-edu
   chmod 777 -R /path/to/investor-edu/uploads  # if you add file uploads later
   ```

3. **Web Server Configuration**
   - Ensure PHP PDO extension is enabled
   - Configure virtual host if needed

## 📁 Project Structure

```
investor-edu/
├── assets/
│   ├── css/
│   │   └── style.css          # Custom styles
│   └── js/
│       └── app.js             # JavaScript functionality
├── config/
│   └── database.php           # Database configuration
├── includes/
│   └── functions.php          # Core functions and utilities
├── index.php                  # Homepage
├── login.php                  # User login
├── register.php               # User registration
├── modules.php                # Educational modules
├── trading.php                # Trading simulator
├── leaderboard.php            # User rankings
├── dashboard.php              # User dashboard
├── logout.php                 # Logout functionality
├── execute_trade.php          # Trading API
├── get_portfolio.php          # Portfolio API
├── get_balance.php            # Balance API
└── README.md                  # This file
```

## 🎯 Core Features Implementation

### 1. Multilingual Support
- Translation system with language files
- Support for 5 Indian languages
- Dynamic language switching

### 2. Educational Content
- 8 comprehensive modules
- Interactive quizzes with explanations
- Progress tracking and completion certificates

### 3. Virtual Trading
- Real-time stock price simulation
- Portfolio management with P&L tracking
- Trade history and performance analytics

### 4. Gamification
- Badge system with 8 achievements
- Leaderboard with rankings
- Progress visualization

## 🔧 Configuration

### Database Settings
Edit `config/database.php`:
```php
$host = 'localhost';
$dbname = 'investor_edu';
$username = 'root';
$password = '';
```

### Language Settings
Supported languages are defined in `includes/functions.php`:
- English (en)
- Hindi (hi)
- Tamil (ta)
- Telugu (te)
- Bengali (bn)

## 🚀 Deployment

### Local Development
1. Use XAMPP/WAMP for local development
2. Access via `http://localhost/investor-edu/`

### Production Deployment
1. **Upload files** to web server
2. **Configure database** with production credentials
3. **Set file permissions** appropriately
4. **Enable HTTPS** for security
5. **Configure caching** for better performance

### Hosting Platforms
- **Shared Hosting**: Upload files via FTP/cPanel
- **VPS/Dedicated**: Use Git deployment
- **Cloud Platforms**: Deploy to AWS, Google Cloud, or Azure

## 📊 Database Schema

### Core Tables
- `users` - User accounts and authentication
- `modules` - Educational content
- `quizzes` - Quiz questions and answers
- `user_progress` - Learning progress tracking
- `badges` - Achievement system
- `user_badges` - User achievements
- `stocks` - Stock market data
- `user_trades` - Trading history
- `user_portfolio` - Portfolio holdings

## 🔒 Security Features

- **Password Hashing** using PHP's `password_hash()`
- **SQL Injection Prevention** with prepared statements
- **Session Management** for user authentication
- **Input Validation** and sanitization
- **CSRF Protection** (can be enhanced)

## 🎨 Customization

### Styling
- Edit `assets/css/style.css` for custom styling
- Modify Bootstrap variables in CSS
- Add custom animations and effects

### Content
- Add new modules in `config/database.php`
- Create new badges and achievements
- Customize quiz questions and answers

### Languages
- Add new translations in `includes/functions.php`
- Support additional Indian languages
- Implement RTL support if needed

## 🧪 Testing

### Manual Testing Checklist
- [ ] User registration and login
- [ ] Module completion and quiz taking
- [ ] Virtual trading functionality
- [ ] Badge earning system
- [ ] Leaderboard rankings
- [ ] Multilingual support
- [ ] Mobile responsiveness

### Browser Compatibility
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 🙏 Acknowledgments

- **SEBI** for investor education initiatives
- **Bootstrap** for the UI framework
- **Font Awesome** for icons
- **PHP Community** for excellent documentation

## 📞 Support

For support and questions:
- Create an issue on GitHub
- Email: support@investoredu.com
- Documentation: [Wiki](https://github.com/yourusername/investor-edu/wiki)

## 🔄 Updates & Maintenance

### Regular Maintenance
- Update dependencies regularly
- Monitor database performance
- Backup data regularly
- Update stock data sources

### Future Enhancements
- Real-time stock data integration
- Advanced charting capabilities
- Social features and forums
- Mobile app development
- AI-powered learning recommendations

---

**Built with ❤️ for the Indian investor community**
