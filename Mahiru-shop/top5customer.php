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
    <main>
        <div class="container admin-panel" style="
        border-left-width: 0px;
        padding-left: 0px;
        padding-right: 0px;
    ">
            <div class="admin-sidebar">
                <h2>Order Management</h2>
                <ul>
                    <li><a href="./business_performance.php" class="active">Product Statistics</a></li>
                    <li><a href="./top5customer.php"></a>Top 5 Customer</li>
                </ul>
            </div>
            <section class="admin-content">
                <h3>Top 5 Customers</h3>
        <table class="table-wrapper">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Revenue</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Jane Doe</td>
                    <td>$2000</td>
                    <td><a href="./customer-invoices.php" class="btn">View Invoices</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Tsukishiro Yanagi</td>
                    <td>$1800</td>
                    <td><a href="./customer-invoices.php" class="btn">View Invoices</a></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Burnice White</td>
                    <td>$1500</td>
                    <td><a href="./customer-invoices.php" class="btn">View Invoices</a></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Ceaser King</td>
                    <td>$1200</td>
                    <td><a href="./customer-invoices.php" class="btn">View Invoices</a></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Nicole Demara</td>
                    <td>$999</td>
                    <td><a href="./customer-invoices.php" class="btn">View Invoices</a></td>
                </tr>
            </tbody>
        </table>
        
            </section>
        </div>
    </main>
</div>
<script>
    lucide.createIcons();
</script>
</body>
</html>
<footer>
    <div class="container">
        <p>&copy;Mahiru Shop. We are pleased to serve you.</p>
    </div>
</footer>   