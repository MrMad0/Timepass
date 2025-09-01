// Investor Education Platform JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Quiz functionality
    initializeQuiz();
    
    // Trading simulator functionality
    initializeTrading();
    
    // Progress tracking
    updateProgressBars();
    
    // Real-time stock price updates (simulated)
    if (document.querySelector('.stock-price')) {
        simulateStockUpdates();
    }
});

// Quiz functionality
function initializeQuiz() {
    const quizOptions = document.querySelectorAll('.quiz-option');
    const submitBtn = document.querySelector('#submit-quiz');
    
    if (quizOptions.length > 0) {
        quizOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove previous selections
                quizOptions.forEach(opt => opt.classList.remove('selected'));
                // Select current option
                this.classList.add('selected');
                
                if (submitBtn) {
                    submitBtn.disabled = false;
                }
            });
        });
    }
    
    if (submitBtn) {
        submitBtn.addEventListener('click', function() {
            const selectedOption = document.querySelector('.quiz-option.selected');
            if (selectedOption) {
                submitQuiz(selectedOption.dataset.option);
            }
        });
    }
}

function submitQuiz(selectedAnswer) {
    const quizForm = document.querySelector('#quiz-form');
    const submitBtn = document.querySelector('#submit-quiz');
    
    if (submitBtn) {
        submitBtn.innerHTML = '<span class="loading"></span> Submitting...';
        submitBtn.disabled = true;
    }
    
    // Create form data
    const formData = new FormData();
    formData.append('selected_answer', selectedAnswer);
    formData.append('module_id', quizForm.dataset.moduleId);
    
    // Submit quiz
    fetch('submit_quiz.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showQuizResults(data);
        } else {
            showAlert('Error submitting quiz. Please try again.', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error submitting quiz. Please try again.', 'danger');
    });
}

function showQuizResults(data) {
    const quizContainer = document.querySelector('.quiz-container');
    const options = document.querySelectorAll('.quiz-option');
    
    // Show correct/incorrect answers
    options.forEach(option => {
        const optionLetter = option.dataset.option;
        if (optionLetter === data.correct_answer) {
            option.classList.add('correct');
        } else if (optionLetter === data.selected_answer && data.selected_answer !== data.correct_answer) {
            option.classList.add('incorrect');
        }
    });
    
    // Show results
    const resultsHtml = `
        <div class="alert ${data.correct ? 'alert-success' : 'alert-warning'} mt-3">
            <h5>${data.correct ? 'Correct!' : 'Incorrect'}</h5>
            <p><strong>Your Score:</strong> ${data.score}%</p>
            <p><strong>Explanation:</strong> ${data.explanation}</p>
            <div class="mt-3">
                <a href="modules.php" class="btn btn-primary">Continue Learning</a>
                <a href="dashboard.php" class="btn btn-outline-primary">View Dashboard</a>
            </div>
        </div>
    `;
    
    quizContainer.insertAdjacentHTML('beforeend', resultsHtml);
    
    // Disable submit button
    const submitBtn = document.querySelector('#submit-quiz');
    if (submitBtn) {
        submitBtn.style.display = 'none';
    }
    
    // Update progress if correct
    if (data.correct) {
        updateProgressBars();
    }
}

// Trading simulator functionality
function initializeTrading() {
    const buyBtn = document.querySelector('#buy-stock');
    const sellBtn = document.querySelector('#sell-stock');
    const quantityInput = document.querySelector('#quantity');
    const stockSelect = document.querySelector('#stock-symbol');
    
    if (buyBtn) {
        buyBtn.addEventListener('click', function() {
            executeTrade('buy');
        });
    }
    
    if (sellBtn) {
        sellBtn.addEventListener('click', function() {
            executeTrade('sell');
        });
    }
    
    if (quantityInput && stockSelect) {
        quantityInput.addEventListener('input', updateTradePreview);
        stockSelect.addEventListener('change', updateTradePreview);
    }
}

function updateTradePreview() {
    const quantity = document.querySelector('#quantity').value;
    const stockSymbol = document.querySelector('#stock-symbol').value;
    const previewDiv = document.querySelector('#trade-preview');
    
    if (quantity && stockSymbol) {
        // Get current stock price (in real app, this would be from API)
        const stockPrice = getStockPrice(stockSymbol);
        const totalAmount = quantity * stockPrice;
        
        if (previewDiv) {
            previewDiv.innerHTML = `
                <div class="alert alert-info">
                    <strong>Trade Preview:</strong><br>
                    Quantity: ${quantity}<br>
                    Price per share: ₹${stockPrice.toFixed(2)}<br>
                    Total Amount: ₹${totalAmount.toFixed(2)}
                </div>
            `;
        }
    }
}

function executeTrade(type) {
    const quantity = document.querySelector('#quantity').value;
    const stockSymbol = document.querySelector('#stock-symbol').value;
    
    if (!quantity || !stockSymbol) {
        showAlert('Please fill in all fields.', 'warning');
        return;
    }
    
    const formData = new FormData();
    formData.append('action', type);
    formData.append('symbol', stockSymbol);
    formData.append('quantity', quantity);
    
    fetch('execute_trade.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(`Trade executed successfully! ${type.toUpperCase()} ${quantity} shares of ${stockSymbol}`, 'success');
            updatePortfolio();
            updateBalance();
        } else {
            showAlert(data.message || 'Trade failed. Please try again.', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error executing trade. Please try again.', 'danger');
    });
}

function updatePortfolio() {
    fetch('get_portfolio.php')
    .then(response => response.json())
    .then(data => {
        const portfolioTable = document.querySelector('#portfolio-table');
        if (portfolioTable && data.portfolio) {
            let html = '';
            data.portfolio.forEach(item => {
                const currentValue = item.quantity * item.current_price;
                const profitLoss = currentValue - (item.quantity * item.avg_buy_price);
                const profitLossPercent = ((profitLoss / (item.quantity * item.avg_buy_price)) * 100);
                
                html += `
                    <tr>
                        <td><strong>${item.stock_symbol}</strong><br><small>${item.name}</small></td>
                        <td>${item.quantity}</td>
                        <td>₹${item.avg_buy_price.toFixed(2)}</td>
                        <td>₹${item.current_price.toFixed(2)}</td>
                        <td class="${profitLoss >= 0 ? 'text-success' : 'text-danger'}">
                            ₹${profitLoss.toFixed(2)} (${profitLossPercent.toFixed(2)}%)
                        </td>
                        <td>₹${currentValue.toFixed(2)}</td>
                    </tr>
                `;
            });
            
            const tbody = portfolioTable.querySelector('tbody');
            if (tbody) {
                tbody.innerHTML = html;
            }
        }
    });
}

function updateBalance() {
    fetch('get_balance.php')
    .then(response => response.json())
    .then(data => {
        const balanceElement = document.querySelector('#virtual-balance');
        if (balanceElement) {
            balanceElement.textContent = `₹${parseFloat(data.balance).toLocaleString()}`;
        }
    });
}

// Progress tracking
function updateProgressBars() {
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const targetWidth = bar.dataset.progress || 0;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = targetWidth + '%';
        }, 100);
    });
}

// Stock price simulation
function simulateStockUpdates() {
    setInterval(() => {
        const stockPrices = document.querySelectorAll('.stock-price');
        stockPrices.forEach(priceElement => {
            const currentPrice = parseFloat(priceElement.textContent.replace('₹', ''));
            const change = (Math.random() - 0.5) * 0.02; // ±1% change
            const newPrice = currentPrice * (1 + change);
            
            priceElement.textContent = `₹${newPrice.toFixed(2)}`;
            
            // Update change percentage
            const changeElement = priceElement.parentElement.querySelector('.stock-change');
            if (changeElement) {
                const changePercent = change * 100;
                changeElement.textContent = `${changePercent >= 0 ? '+' : ''}${changePercent.toFixed(2)}%`;
                changeElement.className = `stock-change ${changePercent >= 0 ? 'positive' : 'negative'}`;
            }
        });
    }, 5000); // Update every 5 seconds
}

// Utility functions
function showAlert(message, type) {
    const alertContainer = document.querySelector('#alert-container') || document.body;
    const alertId = 'alert-' + Date.now();
    
    const alertHtml = `
        <div id="${alertId}" class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    if (alertContainer.id === 'alert-container') {
        alertContainer.innerHTML = alertHtml;
    } else {
        alertContainer.insertAdjacentHTML('afterbegin', alertHtml);
    }
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        const alert = document.querySelector(`#${alertId}`);
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}

function getStockPrice(symbol) {
    // Simulated stock prices (in real app, this would be from API)
    const prices = {
        'RELIANCE': 2450.00,
        'TCS': 3850.00,
        'HDFCBANK': 1650.00,
        'INFY': 1450.00,
        'ICICIBANK': 950.00,
        'HINDUNILVR': 2800.00,
        'ITC': 450.00,
        'SBIN': 650.00
    };
    
    return prices[symbol] || 1000.00;
}

// Module completion tracking
function markModuleComplete(moduleId) {
    fetch('mark_module_complete.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ module_id: moduleId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI to show completion
            const moduleCard = document.querySelector(`[data-module-id="${moduleId}"]`);
            if (moduleCard) {
                moduleCard.classList.add('completed');
                const progressBadge = moduleCard.querySelector('.module-progress');
                if (progressBadge) {
                    progressBadge.innerHTML = '<i class="fas fa-check"></i>';
                    progressBadge.style.background = 'var(--success-color)';
                }
            }
            
            // Show success message
            showAlert('Module completed successfully!', 'success');
            
            // Update progress bars
            updateProgressBars();
        }
    });
}

// Badge animation
function showBadgeAnimation(badgeName) {
    const badgeHtml = `
        <div class="badge-notification">
            <div class="badge-content">
                <i class="fas fa-trophy text-warning"></i>
                <h5>New Badge Earned!</h5>
                <p>${badgeName}</p>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', badgeHtml);
    
    // Remove after animation
    setTimeout(() => {
        const badgeNotification = document.querySelector('.badge-notification');
        if (badgeNotification) {
            badgeNotification.remove();
        }
    }, 3000);
}

// Add CSS for badge notification
const badgeStyles = `
    .badge-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        animation: slideInRight 0.5s ease-out;
    }
    
    .badge-content {
        text-align: center;
    }
    
    .badge-content i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;

// Inject styles
const styleSheet = document.createElement('style');
styleSheet.textContent = badgeStyles;
document.head.appendChild(styleSheet);
