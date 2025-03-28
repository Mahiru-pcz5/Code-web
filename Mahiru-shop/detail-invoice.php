<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Order Details</title>
    <link rel="stylesheet" href="./css/order.css">
</head>
<body>
    <header>
            <div class="container">
                <h1 class="logo">MAHIRU<span>.</span> ADMIN</h1>
                <nav>
                    <ul>
                        <li><a href="./admin.php">Dashboard</a></li>
                        <li><a href="./user-management.php">User</a></li>
                        <li><a href="./order-management.php">Orders</a></li>
                        <li><a href="./product-management.php">Product</a></li>
                        <li><a href="./business_performance.php">Statistic</a></li>
                    </ul>
                </nav>
                <div class="user-info">
                    <div class="user-icon">
                        <i data-lucide="user-circle"></i>
                    </div>
                    <span class="admin-name">Admin: Hatsu</span>
                    <a href="./loginad.php" class="logout">Log out</a>
                </div>
            </div>
    </header>
    <main>
        <div class="container">
            <div class="order-details">
                <div class="order-header">
                    
                    <h1 class="order-id">INVOICE ID: INV-001</h1>
                    <div class="order-actions">
                </div>
                </div>
                <div class="order-dates">
                    <p>Order date: January 15, 2024</p>
                    <p>Estimated delivery: January 20, 2024</p>
                </div>

                <div class="order-items">
                    <div class="product-item">
                        <img src="./img/Bocchi.jpeg" alt="Gotou Hitori" class="product-image2">
                        <div class="product-details">
                            <h3 class="product-title">Gotou Hitori</h3>
                            <p class="product-description">Figure</p>
                            <p class="product-price">$9.99 Qty: 1</p>
                        </div>
                    </div>
                    <div class="product-item">
                        <img src="./img/Cirno.jpg" alt="Fumo Cirno" class="product-image2">
                        <div class="product-details">
                            <h3 class="product-title">Fumo Cirno</h3>
                            <p class="product-description">plusie</p>
                            <p class="product-price">$31.98 Qty: 2</p>
                        </div>
                    </div>
                    <div class="product-item">
                        <img src="./img/Vidar.jpg" alt="Gundam Vidar" class="product-image2">
                        <div class="product-details">
                            <h3 class="product-title">Gundam Vidar</h3>
                            <p class="product-description">Gundam</p>
                            <p class="product-price">$11.99 Qty: 1</p>
                        </div>
                    </div>
                </div>

                <div class="order-summary">
                    <h2 class="section-title">Sumary</h2>
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>$53.96</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span>$5.00</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span>$58.96</span>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-section">
                        <h2 class="section-title">Shipping Information</h2>
                        <div class="info-row">
                            <div class="info-label">Client: Jane Doe</div>
                            <div class="info-label">Address:</div>
                            <div class="info-value">
                                123 Main Street<br>
                                Apt 4B<br>
                                New York, NY 10001<br>
                                United States
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Phone:</div>
                            <div class="info-value">(555) 123-4567</div>
                        </div>
                    </div>

                    <div class="info-section">
                        <h2 class="section-title">Payment Information</h2>
                        <div class="info-row">
                            <div class="info-label">Payment Method:</div>
                            <div class="info-value">Credit Card</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Card Number:</div>
                            <div class="info-value">**** **** **** 1234</div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <script>
                    lucide.createIcons();
                </script>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy;Mahiru Shop. We are pleased to serve you.</p>
        </div>
    </footer>
</body>
</html>
