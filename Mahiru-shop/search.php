<?php
// Kết nối database
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "mahiru_shop"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý tìm kiếm sản phẩm
$search_query = isset($_GET['name']) ? $_GET['name'] : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : 'all';
$sort_option = isset($_GET['sort']) ? $_GET['sort'] : '';

$sql = "SELECT * FROM products WHERE name LIKE '%$search_query%'";

// Nếu có chọn category, thêm điều kiện lọc
if ($category_filter !== 'all') {
    $sql .= " AND category = '$category_filter'";
}

// Thêm điều kiện sắp xếp theo giá
if ($sort_option === 'low_to_high') {
    $sql .= " ORDER BY price ASC";
} elseif ($sort_option === 'high_to_low') {
    $sql .= " ORDER BY price DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahiru Shop - Search</title>
    <link rel="stylesheet" href="./css/search.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

<header>
    <div class="top-bar">
        <div class="container">
            <div class="contact-info">
                <span><i class="fas fa-phone"></i> 012345678</span>
                <span><i class="fas fa-envelope"></i> mahiru@gmail.com</span>
                <span><i class="fas fa-map-marker-alt"></i>1104 Wall Street</span>
            </div>
            <div class="user-actions">
                <a class="login-link">
                    <i class="fas fa-user"></i>
                    <span class="name">Login/Sign up</span>
                </a>
            </div>
        </div>
    </div>
    <div class="main-header">
        <div class="container">
            <div class="logo">
                <a href="search.php"><h1>MAHIRU<span>.</span></h1></a>
            </div>
            <div class="search-bar">
                <form action="search.php" method="GET">
                    <input type="text" name="name" placeholder="Search here" value="<?= htmlspecialchars($search_query) ?>">
                    <button type="submit" class="search-button">Search</button>
                </form>
            </div>
        </div>
    </div>
</header>

<main>
    <div class="container">
        <div class="filter-sidebar">
            <form action="search.php" method="GET">
                <h3>Name:</h3>
                <input type="text" name="name" placeholder="Enter product name" class="filter-input" value="<?= htmlspecialchars($search_query) ?>">

                <h3>Category:</h3>
                <select name="category" class="filter-select">
                    <option value="all">All Categories</option>
                    <option value="gundam" <?= $category_filter == 'gundam' ? 'selected' : '' ?>>Gundam</option>
                    <option value="kamen_rider" <?= $category_filter == 'kamen_rider' ? 'selected' : '' ?>>Kamen Rider</option>
                    <option value="standee" <?= $category_filter == 'standee' ? 'selected' : '' ?>>Standee</option>
                    <option value="keychain" <?= $category_filter == 'keychain' ? 'selected' : '' ?>>Keychain</option>
                    <option value="plush" <?= $category_filter == 'plush' ? 'selected' : '' ?>>Plush</option>
                    <option value="figure" <?= $category_filter == 'figure' ? 'selected' : '' ?>>Figure</option>
                </select>

                <h3>Sort by:</h3>
                <select name="sort" class="filter-select">
                    <option value="">Default</option>
                    <option value="low_to_high" <?= $sort_option == 'low_to_high' ? 'selected' : '' ?>>Price: Low to High</option>
                    <option value="high_to_low" <?= $sort_option == 'high_to_low' ? 'selected' : '' ?>>Price: High to Low</option>
                </select>

                <button type="submit" class="filter-button">Search</button>
            </form>
        </div>

        <section class="product-grid">
            <h1>Search Results:</h1>
            <div class="product-row">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='product-card'>";
                        echo "<a href='product_details.php?id=" . $row['id'] . "' class='product-image'>";
                        echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "'>";
                        echo "</a>";
                        echo "<h3>" . $row['name'] . "</h3>";
                        echo "<p>" . $row['description'] . "</p>";
                        echo "<span class='price'>$" . $row['price'] . "</span>";
                        echo "<a href='#' class='btn'>Add to Cart</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No products found.</p>";
                }
                ?>
            </div>
        </section>
    </div>
</main>

<footer>
    <div class="container">
        <p>&copy; Mahiru Shop. We are pleased to serve you.</p>
    </div>
</footer>

</body>
</html>

<?php
$conn->close();
?>
