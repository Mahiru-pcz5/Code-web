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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Mahiru Shop Admin</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="./css/user.css">
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
                        <h2>User Management</h2>
                        <ul>
                            <li><a href="./user-management.php">User List</a></li>
                            <li><a href="./add-user.php">Add New User</a></li>
                        </ul>
                    </div>
                    <div class="admin-content">
                        <div class="action-bar">
                            <div class="search-bar">
                                <input type="text" placeholder="Search for user name">
                            </div>        
                        </div>
                        <table class="user-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Email Address</th>
                                    <th>User Role</th>
                                    <th>Status</th>
                                    <th>Lock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT id, username, email, role, status FROM users";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['role'] . "</td>";
                                        echo "<td><span class='status " . ($row['status'] == 'Active' ? 'status-active' : 'status-inactive') . "'>" . $row['status'] . "</span></td>";
                                        echo "<td>
                                                <label class='switch'>
                                                    <input type='checkbox' " . ($row['status'] == 'Deactive' ? 'checked' : '') . ">
                                                    <span class='slider'></span>
                                                </label>
                                              </td>";
                                        echo "<td>
                                                <a href='edit-user.php?id=" . $row['id'] . "' class='action-btn' style='background-color: green;border-color: green; color: white'>Edit</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No users found</td></tr>";
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
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="container">
                <p>&copy;  Mahiru Shop. We are pleased to serve you.</p>
            </div>
        </footer>
    </div>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
<?php $conn->close(); ?>
