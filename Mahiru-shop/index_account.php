<?php
session_start();

// ========== KẾT NỐI CSDL ==========
$host = 'localhost';
$dbname = 'mahiru_shop';
$dbUsername = 'root';
$dbPassword = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// ========== LẤY THÔNG TIN USER TỪ SESSION ==========
$currentUser = null;
if (isset($_SESSION['user_name']) && isset($_SESSION['user_role'])) {
    // Dùng trực tiếp các biến session đã lưu từ login/sign_up
    $currentUser = [
        'username' => $_SESSION['user_name'],
        'role'     => $_SESSION['user_role']
    ];
}

// ========== LẤY DANH MỤC TỪ BẢNG products ==========
$categoryQuery = $conn->query("SELECT DISTINCT category FROM products");
$categories = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);

// ========== XỬ LÝ TÌM KIẾM & LỌC SẢN PHẨM ==========
$searchName = isset($_GET['name']) ? $_GET['name'] : '';
$category   = isset($_GET['category']) ? $_GET['category'] : 'all';
$priceRange = isset($_GET['price']) ? $_GET['price'] : 150;

$sql = "SELECT * FROM products WHERE price <= :price";
if (!empty($searchName)) {
    $sql .= " AND name LIKE :name";
}
if ($category != 'all') {
    $sql .= " AND category = :category";
}

$stmt = $conn->prepare($sql);
$stmt->bindValue(':price', $priceRange, PDO::PARAM_INT);
if (!empty($searchName)) {
    $stmt->bindValue(':name', "%$searchName%", PDO::PARAM_STR);
}
if ($category != 'all') {
    $stmt->bindValue(':category', $category, PDO::PARAM_STR);
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
  <!-- File CSS -->
  <link rel="stylesheet" href="./css/styles.css" />
  <!-- FontAwesome (icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body>
  <!-- ========== HEADER ========== -->
  <header>
    <!-- Top bar -->
    <div class="top-bar">
      <div class="container">
        <div class="contact-info">
          <span><i class="fas fa-phone"></i> 012345678</span>
          <span><i class="fas fa-envelope"></i> mahiru@gmail.com</span>
          <span><i class="fas fa-map-marker-alt"></i> 1104 Wall Street</span>
        </div>

        <!-- Góc phải: hiển thị tên user/admin hoặc Login/Sign up -->
        <div class="user-actions">
          <?php if ($currentUser): ?>
            <!-- Nếu đã đăng nhập -->
            <i class="fas fa-user"></i>
            <?php if (strtolower($currentUser['role']) === 'admin'): ?>
              <span class="name">ADMIN</span>
            <?php else: ?>
              <span class="name"><?php echo htmlspecialchars($currentUser['username']); ?></span>
            <?php endif; ?>

            <!-- Dropdown: Admin sẽ có "Edit", còn User thường có "Order history" -->
            <div class="login-dropdown">
              <?php if (strtolower($currentUser['role']) === 'admin'): ?>
                <a href="edit.php" class="login-option">Edit</a>
              <?php else: ?>
                <a href="order_history.php" class="login-option">Order history</a>
              <?php endif; ?>
              <a href="logout.php" class="login-option">Log out</a>
            </div>
          <?php else: ?>
            <!-- Nếu chưa đăng nhập -->
            <a class="login-link">
              <i class="fas fa-user"></i>
              <span class="name">Login/Sign up</span>
            </a>
            <div class="login-dropdown">
              <a href="login.php" class="login-option">Login</a>
              <a href="sign_up.php" class="login-option">Sign up</a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Main header: Logo + Search Bar -->
    <div class="main-header">
      <div class="container">
        <div class="logo">
          <a href="index_account.php" class="logo-link">
            <h1>MAHIRU<span>.</span></h1>
          </a>
        </div>
        <div class="search-bar">
          <form action="search.php" method="GET">
            <input type="text" name="name" placeholder="Search here" value="<?php echo htmlspecialchars($searchName); ?>" />
            <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>" />
            <input type="hidden" name="price" value="<?php echo htmlspecialchars($priceRange); ?>" />
            <button type="submit" class="search-button">Search</button>
          </form>
        </div>
        <div class="user-menu">
          <a href="cart.php" class="icon"><i class="fas fa-shopping-cart"></i></a>
        </div>
      </div>
    </div>

    <!-- Navigation Menu -->
    <nav>
      <div class="container">
        <ul>
          <li><a href="index_account.php">Home</a></li>
          <li><a href="category_account.php">Gundam</a></li>
          <li><a href="category_account.php">Kamen Rider</a></li>
          <li><a href="category_account.php">Standee</a></li>
          <li><a href="category_account.php">Keychain</a></li>
          <li><a href="category_account.php">Plush</a></li>
          <li><a href="category_account.php">Figure</a></li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- ========== MAIN CONTENT ========== -->
  <main>
    <div class="container">
      <!-- Sidebar Filter -->
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
              <?php foreach ($categories as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat['category']); ?>" <?php echo ($category == $cat['category']) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $cat['category']))); ?>
                </option>
              <?php endforeach; ?>
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

          <button type="submit" class="filter-button" style="margin-top: 10px">Search</button>
        </form>
      </div>

      <!-- Product Grid -->
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

    <!-- Pagination (demo) -->
    <div class="pagination">
      <a href="#">&laquo;</a>
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <a href="#">4</a>
      <a href="#">5</a>
      <a href="#">&raquo;</a>
    </div>
  </main>

  <!-- ========== FOOTER ========== -->
  <footer>
    <div class="container">
      <p>&copy; Mahiru Shop. We are pleased to serve you.</p>
    </div>
  </footer>

  <!-- Script -->
  <script src="./js/popup.js"></script>
</body>
</html>
