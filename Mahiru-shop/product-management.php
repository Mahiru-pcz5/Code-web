<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mahiru_shop";

// Kết nối đến MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn lấy danh sách sản phẩm
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management - Mahiru Shop</title>
    <link rel="stylesheet" href="./css/admin-styles.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <div class="page-container">
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
                <div class="admin-panel">
                    <div class="admin-sidebar">
                        <h2>Product Management</h2>
                        <ul>
                            <li><a href="./product-management.php">Product List</a></li>
                            <li><a href="./add-product.php" class="active">Add New Product</a></li>

                        </ul>
                    </div>
                    <div class="admin-content">

                            <h2>Product List</h2>
                            <div class="product-search">
                                <input type="text" id="product-search" placeholder="Search for a product...">
                                <button class="action-btn">Search</button>
                            </div>
                            <table class="product-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Product image</th>
                                        <th>Category</th>
                                        <th>Price</th>                                       
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td><img src='" . $row["image"] . "' alt='" . $row["name"] . "' class='product-image'></td>";
                    echo "<td>" . $row["category"] . "</td>";
                    echo "<td>$" . number_format($row["price"], 2) . "</td>";
                    echo "<td><a href='edit-product.php?id=" . $row["id"] . "' class='action-btn'>Edit</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No products found</td></tr>";
            }
            ?>
                                </tbody>
                            </table>

                            <div class="pagination">
                                <a href="#">&laquo;</a>
                                <a href="#" class="active">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <a href="#">4</a>
                                <a href="#">5</a>
                                <a href="#">&raquo;</a>
                        </section>
                    </div>
                </div>
            </div>
        </main>

        <footer>
            <div class="container">
                <p>&copy; Mahiru Shop. We are pleased to serve you.</p>
            </div>
        </footer>
    </div>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>