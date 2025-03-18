<?php
// Phần kết nối cơ sở dữ liệu
$host = 'localhost'; // Tên máy chủ MySQL
$dbname = 'mahiru_shop'; // Tên cơ sở dữ liệu
$username = 'root'; // Tên người dùng MySQL
$password = ''; // Mật khẩu MySQL

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Xử lý tìm kiếm và lọc
$searchName = isset($_GET['name']) ? $_GET['name'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$priceRange = isset($_GET['price']) ? $_GET['price'] : 150;

// Xây dựng câu truy vấn SQL
$sql = "SELECT * FROM products WHERE price <= :price";
if (!empty($searchName)) {
    $sql .= " AND name LIKE :name";
}
if ($category != 'all') {
    $sql .= " AND description LIKE :category";
}

// Chuẩn bị và thực thi truy vấn
$stmt = $conn->prepare($sql);
$stmt->bindValue(':price', $priceRange, PDO::PARAM_INT);
if (!empty($searchName)) {
    $stmt->bindValue(':name', "%$searchName%", PDO::PARAM_STR);
}
if ($category != 'all') {
    $stmt->bindValue(':category', "%$category%", PDO::PARAM_STR);
}
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mahiru Shop</title>
    <link rel="stylesheet" href="./css/search.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
                    <div class="login-dropdown">
                        <a href="login.html" class="login-option">Login</a>
                        <a href="sign_up.html" class="login-option">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-header">
            <div class="container">
                <div class="logo">
                    <a href="search.php" class="logo-link"><h1>MAHIRU<span>.</span></h1></a>
                </div>
                <div class="search-bar">
                    <input type="text" placeholder="Search here" />
                    <a href="search.php" class="search-button">Search</a>
                </div>
                <div class="user-menu"></div>
            </div>
        </div>
        <nav>
            <div class="container">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="category.html">Gundam</a></li>
                    <li><a href="category.html">Kamen Rider</a></li>
                    <li><a href="category.html">Standee</a></li>
                    <li><a href="category.html">Keychain</a></li>
                    <li><a href="category.html">Plush</a></li>
                    <li><a href="category.html">Figure</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <!-- Filter Bar -->
            <div class="filter-sidebar">
                <form action="search.php" method="GET">
                    <h3>Name:</h3>
                    <div class="filter-name">
                        <input type="text" name="name" placeholder="Enter product name" class="filter-input" value="<?php echo htmlspecialchars($searchName); ?>" />
                    </div>

                    <h3>Category:</h3>
                    <div class="filter-category">
                        <select name="category" class="filter-select">
                            <option value="all" <?php echo ($category == 'all') ? 'selected' : ''; ?>>All Categories</option>
                            <option value="gundam" <?php echo ($category == 'gundam') ? 'selected' : ''; ?>>Gundam</option>
                            <option value="kamen_rider" <?php echo ($category == 'kamen_rider') ? 'selected' : ''; ?>>Kamen Rider</option>
                            <option value="standee" <?php echo ($category == 'standee') ? 'selected' : ''; ?>>Standee</option>
                            <option value="keychain" <?php echo ($category == 'keychain') ? 'selected' : ''; ?>>Keychain</option>
                            <option value="plush" <?php echo ($category == 'plush') ? 'selected' : ''; ?>>Plush</option>
                            <option value="figure" <?php echo ($category == 'figure') ? 'selected' : ''; ?>>Figure</option>
                        </select>
                    </div>

                    <h3>Price:</h3>
                    <div class="filter-price">
                        <label for="priceRange">Range:</label>
                        <div class="range-container custom-range">
                            <div class="range-label">0</div>
                            <input type="range" id="priceRange" name="price" min="0" max="150" value="<?php echo $priceRange; ?>" class="filter-input" />
                            <div class="range-label">150</div>
                        </div>
                    </div>

                    <button type="submit" class="filter-button">Search</button>
                </form>
            </div>

            <!-- Product Grid -->
            <section class="product-grid">
                <div class="filter-box">
                    <span class="sort-label">Sort by:</span>
                    <a class="sort-label" href="search.php"><button class="filter-btn">Relevance</button></a>
                    <a class="sort-label" href="search.php"><button class="filter-btn">Newest</button></a>
                    <a class="sort-label" href="search.php"><button class="filter-btn">Best Selling</button></a>
                    <div class="filter-option">
                        <label class="price-btn" for="price-toggle">Price</label>
                        <input type="checkbox" id="price-toggle" class="price-toggle" />
                        <div class="price-dropdown">
                            <a href="search.php?sort=low_to_high" class="price-option">Low to High</a>
                            <a href="search.php?sort=high_to_low" class="price-option">High to Low</a>
                        </div>
                    </div>
                </div>
                <div class="search-results">
                    <h1>Search Results:</h1>
                </div>
                <?php if (count($products) > 0) : ?>
                    <?php foreach (array_chunk($products, 3) as $productRow) : ?>
                        <div class="product-row">
                            <?php foreach ($productRow as $product) : ?>
                                <div class="product-card">
                                    <a href="product_details.php?id=<?php echo $product['id']; ?>" class="product-image">
                                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                                    </a>
                                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                                    <span class="price">$<?php echo htmlspecialchars($product['price']); ?></span>
                                    <a href="product_details.php?id=<?php echo $product['id']; ?>" class="btn">Add to Cart</a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No products found.</p>
                <?php endif; ?>
            </section>
        </div>
        <div class="pagination">
            <a href="search.php">&laquo;</a>
            <a href="search.php" class="active">1</a>
            <a href="search.php">2</a>
            <a href="search.php">3</a>
            <a href="search.php">4</a>
            <a href="search.php">5</a>
            <a href="search.php">&raquo;</a>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; Mahiru Shop. We are pleased to serve you.</p>
        </div>
    </footer>
    <script src="./js/popup.js"></script>
</body>
</html>