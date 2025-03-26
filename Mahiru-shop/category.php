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
    $sql .= " AND category = :category";
}

// Chuẩn bị và thực thi truy vấn
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
    <link rel="stylesheet" href="./css/styles.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
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
            <a href="category.html" class="logo-link"><h1>MAHIRU<span>.</span></h1></a>
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
           
          </div>
        </div>
      </div>
      <nav>
        <div class="container">
          <ul>
           <li><a href="index.php">Home</a></li>
           <li><a href="category.php?category=gundam">Gundam</a></li>
           <li><a href="category.php?category=kamen_rider">Kamen Rider</a></li>
           <li><a href="category.php?category=standee">Standee</a></li>
           <li><a href="category.php?category=keychain">Keychain</a></li>
           <li><a href="category.php?category=plush">Plush</a></li>
           <li><a href="category.php?category=figure">Figure</a></li>
          </ul>
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
          </div>
          <!-- Row 1 -->
          <div class="product-row">
            <div class="product-card">
                <a href="product_details.html" class="product-image">
                  <img src="img/Vidar.jpg" alt="Product 1" />
                </a>
                <h3>Gundam Vidar</h3>
                <p>Mobile suit Gundam: IBO</p>
                <span class="price">$99.99</span>
                <a href="product_details.html" class="btn">Add to Cart</a>
              </div>
            <div class="product-card">
              <a href="product_details.html" class="product-image">
                <img src="./img/SAM.webp" alt="Product 2" />
              </a>
              <h3>Stellaron Hunter SAM</h3>
              <p>Honkai Star Rail</p>
              <span class="price">$15.99</span>
              <a href="product_details.html" class="btn">Add to Cart</a>
            </div>
            <div class="product-card">
              <a href="product_details.html" class="product-image">
                <img src="./img/RiderKick.jpg" alt="Product 3" />
              </a>
              <h3>SHFGuart Kamen rider Kabuto</h3>
              <p>Kamen Rider Kabuto</p>
              <span class="price">$11.99</span>
              <a href="product_details.html" class="btn">Add to Cart</a>
            </div>
          </div>
          <!-- Row 2 -->
          <div class="product-row">
            <div class="product-card">
                <a href="product_details.html" class="product-image">
                  <img src="img/Barbatos_lupus_rex.webp" alt="Product 4" />
                </a>
                <h3>Barbatos lupus rex</h3>
                <p>Mobile suit Gundam: IBO</p>
                <span class="price">$99.99</span>
                <a href="product_details.html" class="btn">Add to Cart</a>
              </div>
            <div class="product-card">
              <a href="product_details.html" class="product-image">
                <img src="img/Bocchi.jpeg" alt="Product 5" />
              </a>
              <h3>Gotou Hitori</h3>
              <p>Bocchi The Rock</p>
              <span class="price">$99.99</span>
              <a href="product_details.html" class="btn">Add to Cart</a>
            </div>
            <div class="product-card">
              <a href="product_details.html" class="product-image">
                <img src="img/EVA-01.webp" alt="Product 6" />
              </a>
              <h3>EVA-01</h3>
              <p>Neon Genesis Evangelion</p>
              <span class="price">$99.99</span>
              <a href="product_details.html" class="btn">Add to Cart</a>
            </div>
          </div>
    
          </div>
        </section>
      </div>
      <div class="pagination">
        <a href="category.html">&laquo;</a>
        <a href="category.html" class="active">1</a>
        <a href="category.html">2</a>
        <a href="category.html">3</a>
        <a href="category.html">4</a>
        <a href="category.html">5</a>
        <a href="category.html">&raquo;</a>
      </div>
    </main>

    <footer>
      <div class="container">
        <p>&copy;  Mahiru Shop. We are pleased to serve you.</p>
      </div>
    </footer>
    <script src="./js/popup.js"></script>
  </body>
</html>
