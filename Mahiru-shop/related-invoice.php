<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Mahiru Shop</title>
    <script src="https://unpkg.com/lucide@latest"></script>
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
    <body>    
        <main>
            <div class="container">
                <table class="customer-info">
                    <tr>
                        <td>Invoice related to the product: Bocchi Hitori</td>
                    </tr>
            </table>
            <div class="admin-panel">
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th>InvoicesID</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>INV-001</td>
                            <td>2024-03-15</td>
                            <td>$150.00</td>
                            <td>
                                <div class="invoice-actions">
                                    <a href="detail-invoice.php" class="btn">View</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>INV-002</td>
                            <td>2024-03-20</td>
                            <td>$75.50</td>
                            <td>
                                <div class="invoice-actions">
                                    <a href="detail-invoice.php" class="btn">View</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>INV-003</td>
                            <td>2024-03-25</td>
                            <td>$200.00</td>
                            <td>
                                <div class="invoice-actions">
                                    <a href="detail-invoice.php" class="btn">View</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>INV-004</td>
                            <td>2024-04-01</td>
                            <td>$100.00</td>
                            <td>
                                <div class="invoice-actions">
                                    <a href="detail-invoice.php" class="btn">View</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>INV-005</td>
                            <td>2024-04-05</td>
                            <td>$50.00</td>
                            <td>
                                <div class="invoice-actions">
                                    <a href="detail-invoice.php" class="btn">View</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>INV-006</td>
                            <td>2024-03-15</td>
                            <td>$150.00</td>
                            <td>
                                <div class="invoice-actions">
                                    <a href="detail-invoice.php" class="btn">View</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>INV-007</td>
                            <td>2024-03-20</td>
                            <td>$75.50</td>
                            <td>
                                <div class="invoice-actions">
                                    <a href="detail-invoice.php" class="btn">View</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>INV-008</td>
                            <td>2024-03-25</td>
                            <td>$200.00</td>
                            <td>
                                <div class="invoice-actions">
                                    <a href="detail-invoice.php" class="btn">View</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>INV-009</td>
                            <td>2024-04-01</td>
                            <td>$100.00</td>
                            <td>
                                <div class="invoice-actions">
                                    <a href="detail-invoice.php" class="btn">View</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>INV-010</td>
                            <td>2024-04-05</td>
                            <td>$50.00</td>
                            <td>
                                <div class="invoice-actions">
                                    <a href="detail-invoice.php" class="btn">View</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            </div>
            <div class="pagination">
                <a href="#">&laquo;</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">&raquo;</a>
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
