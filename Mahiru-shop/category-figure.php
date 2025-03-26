<?php
// Kết nối cơ sở dữ liệu
$host = 'localhost';
$dbname = 'mahiru_shop';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Lấy danh sách danh mục từ database
$categoryQuery = $conn->query("SELECT DISTINCT category FROM products");
$categories = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);

// Lọc sản phẩm theo danh mục 
$category = 'Figure'; // tùy thuộc vào cách lưu trữ trong database
$searchName = isset($_GET['name']) ? $_GET['name'] : '';
$priceRange = isset($_GET['price']) ? $_GET['price'] : 150;

// Phân trang
$limit = 9; // Số sản phẩm trên mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Trang hiện tại
$offset = ($page - 1) * $limit; // Tính toán offset

// Lấy tổng số sản phẩm 
$totalQuery = $conn->prepare("SELECT COUNT(*) FROM products WHERE category = :category");
$totalQuery->bindValue(':category', $category);
$totalQuery->execute();
$totalProducts = $totalQuery->fetchColumn();
$totalPages = ceil($totalProducts / $limit); // Tính tổng số trang

// Xây dựng câu truy vấn SQL
$sql = "SELECT * FROM products WHERE category = :category AND price <= :price";
if (!empty($searchName)) {
    $sql .= " AND name LIKE :name";
}
$sql .= " LIMIT :limit OFFSET :offset"; // Thêm LIMIT và OFFSET

// Chuẩn bị và thực thi truy vấn
$stmt = $conn->prepare($sql);
$stmt->bindValue(':category', $category);
$stmt->bindValue(':price', $priceRange, PDO::PARAM_INT);
if (!empty($searchName)) {
    $stmt->bindValue(':name', "%$searchName%", PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Figure Products - Mahiru Shop</title>
    <link rel="stylesheet" href="./css/styles.css" />
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
                        <a href="login.php" class="login-option">Login</a>
                        <a href="sign_up.php" class="login-option">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-header">
            <div class="container">
                <div class="logo">
                    <a href="index.php" class="logo-link"><h1>MAHIRU<span>.</span></h1></a>
                </div>
                <div class="search-bar">
    <form action="search.php" method="GET">
        <input type="text" name="name" placeholder="Search here" value="<?php echo htmlspecialchars($searchName); ?>" />
        <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>" />
        <input type="hidden" name="price" value="<?php echo htmlspecialchars($priceRange); ?>" />
        <button type="submit" class="search-button">Search</button>
    </form>
</div>
            </div>
        </div>
        <nav>
            <div class="container">
                <ul>
                <li><a href="index.php">Home</a></li>
            <li><a href="category-gundam.php">Gundam</a></li> <!-- Thêm liên kết đến Gundam -->
            <li><a href="category-kamen-rider.php">Kamen Rider</a></li>
            <li><a href="category-standee.php">Standee</a></li>
            <li><a href="category-keychain.php">Keychain</a></li>
            <li><a href="category-plush.php">Plush</a></li>
            <li><a href="category-figure.php">Figure</a></li>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
        <div class="filter-sidebar">
          <form action="search.php" method="GET">
            <h3>Name:</h3>
            <div class="filter-name">
              <input
                type="text"
                name="name"
                placeholder="Enter product name"
                class="filter-input"
                value="<?php echo htmlspecialchars($searchName); ?>"
              />
            </div>

            <h3>Category:</h3>
            <div class="filter-category">
              <select name="category" class="filter-select">
                <option value="all">All Categories</option>
                <option value="gundam">Gundam</option>
                <option value="kamen_rider">Kamen Rider</option>
                <option value="standee">Standee</option>
                <option value="keychain">Keychain</option>
                <option value="plush">Plush</option>
                <option value="figure">Figure</option>
              </select>
            </div>

            <h3>Price:</h3>
            <div class="filter-price">
              <label for="priceRange">Range:</label>
              <div class="range-container custom-range">
                <div class="range-label">0</div>
                <input
                  type="range"
                  id="priceRange"
                  name="price"
                  min="0"
                  max="150"
                  value="50"
                  class="filter-input"
                />
                <div class="range-label">150</div>
              </div>
            </div>

            <button type="submit" class="filter-button">Search</button>
          </form>
        </div>

            <section class="product-grid">
                <div class="product-categories">
                    <?php if (count($products) > 0): ?>
                        <?php foreach (array_chunk($products, 3) as $productRow): ?>
                            <div class="product-row">
                                <?php foreach ($productRow as $product): ?>
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
                    <?php else: ?>
                        <p>No products found.</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>

        <!-- Phân trang -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="category-figure.php?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="category-figure.php?page=<?php echo $i; ?>" class="<?php echo ($i === $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <a href="category-figure.php?page=<?php echo $page + 1; ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; Mahiru Shop. We are pleased to serve you.</p>
        </div>
    </footer>
</body>
</html>