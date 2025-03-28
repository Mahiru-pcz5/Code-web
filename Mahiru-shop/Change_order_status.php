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
                <span class="admin-name">Admin</span>
                <a href="./loginad.php" class="logout">Log out</a>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="admin-content2">
                <h1>Change Order Status</h1>
                <form id="orderStatusForm">
                    <div class="form-group">
                        <label for="order-id" >Order ID:</label>
                        <input type="text" id="order-id" name="order-id" value="#2532" readonly>
                    </div>
                    <div class="form-group">
                        <label for="current-status">Current Status:</label>
                        <input type="text" id="current-status" name="current-status" value="Pending" readonly>
                    </div>
                    <div class="form-group">
                        <label for="new-status">New Status:</label>
                        <select id="new-status" name="new-status">
                            <option value="">Select new status</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <button type="submit"  onclick="myfucn()" >Update Status</button>
                    <script>
                        function myfucn() {
                            // Hiển thị popup thông báo
                            alert("Status updated successfully!");
                        }
                    </script>
                </form>
                </div>
            </div>
        </div>
    </main>
    </main>
    <footer>
        <div class="container">
            <p>&copy;Mahiru Shop. We are pleased to serve you.</p>
        </div>
    </footer>
</body>
</html> 