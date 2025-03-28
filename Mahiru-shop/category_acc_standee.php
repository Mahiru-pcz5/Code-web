<?php
session_start();

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

$currentUser = null;
if (isset($_SESSION['user_name']) && isset($_SESSION['user_role'])) {
    $currentUser = [
        'username' => $_SESSION['user_name'],
        'role'     => $_SESSION['user_role']
    ];
}

$searchName = isset($_GET['name']) ? $_GET['name'] : '';
$priceRange = isset($_GET['price']) ? $_GET['price'] : 150;

$limit = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$countSql = "SELECT COUNT(*) FROM products WHERE category = 'standee' AND price <= :price";
if (!empty($searchName)) {
    $countSql .= " AND name LIKE :name";
}
$countStmt = $conn->prepare($countSql);
$countStmt->bindValue(':price', $priceRange, PDO::PARAM_INT);
if (!empty($searchName)) {
    $countStmt->bindValue(':name', "%$searchName%", PDO::PARAM_STR);
}
$countStmt->execute();
$totalProducts = $countStmt->fetchColumn();
$totalPages = ceil($totalProducts / $limit);

$sql = "SELECT * FROM products WHERE category = 'standee' AND price <= :price";
if (!empty($searchName)) {
    $sql .= " AND name LIKE :name";
}
$sql .= " LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($sql);
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
    <title>Mahiru Shop - Standee</title>
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
                    <span><i class="fas fa-map-marker-alt"></i> 1104 Wall Street</span>
                </div>
                <div class="user-actions">
                    <?php if ($currentUser): ?>
                        <i class="fas fa-user"></i>
                        <?php if (strtolower($currentUser['role']) === 'admin'): ?>
                            <span class="name">ADMIN</span>
                        <?php else: ?>
                            <span class="name"><?php echo htmlspecialchars($currentUser['username']); ?></span>
                        <?php endif; ?>
                        <div class="login-dropdown">
                            <?php if (strtolower($currentUser['role']) === 'admin'): ?>
                                <a href="edit.php" class="login-option">Edit</a>
                            <?php else: ?>
                                <a href="order_history.php" class="login-option">Order history</a>
                            <?php endif; ?>
                            <a href="index.php" class="login-option">Log out</a>
                        </div>
                    <?php else: ?>
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
        <div class="main-header">
            <div class="container">
                <div class="logo">
                    <a href="index_account.php" class="logo-link"><h1>MAHIRU<span>.</span></h1></a>
                </div>
                <div class="search-bar">
                    <form action="search.php" method="GET">
                        <input type="text" name="name" placeholder="Search here" value="<?php echo htmlspecialchars($searchName); ?>" />
                        <input type="hidden" name="category" value="standee" />
                        <input type="hidden" name="price" value="<?php echo htmlspecialchars($priceRange); ?>" />
                        <button type="submit" class="search-button">Search</button>
                    </form>
                </div>
                <div class="user-menu">
                    <a href="cart.php" class="icon"><i class="fas fa-shopping-cart"></i></a>
                </div>
            </div>
        </div>
        <nav>
            <div class="container">
                <ul>
                    <li><a href="index_account.php">Home</a></li>
                    <li><a href="category_acc_gundam.php">Gundam</a></li>
                    <li><a href="category_acc_kamen_rider.php">Kamen Rider</a></li>
                    <li><a href="category_acc_standee.php">Standee</a></li>
                    <li><a href="category_acc_keychain.php">Keychain</a></li>
                    <li><a href="category_acc_plush.php">Plush</a></li>
                    <li><a href="category_acc_figure.php">Figure</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="filter-sidebar">
                <form action="category_acc_standee.php" method="GET">
                    <h3>Name:</h3>
                    <div class="filter-name">
                        <input type="text" name="name" placeholder="Enter product name" class="filter-input" value="<?php echo htmlspecialchars($searchName); ?>" />
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
                    <button type="submit" class="filter-button" style="margin-top: 10px;">Search</button>
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
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="category_acc_standee.php?page=<?php echo $page - 1; ?>&name=<?php echo urlencode($searchName); ?>&price=<?php echo $priceRange; ?>">« Previous</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="category_acc_standee.php?page=<?php echo $i; ?>&name=<?php echo urlencode($searchName); ?>&price=<?php echo $priceRange; ?>" class="<?php echo ($i === $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <a href="category_acc_standee.php?page=<?php echo $page + 1; ?>&name=<?php echo urlencode($searchName); ?>&price=<?php echo $priceRange; ?>">Next »</a>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>© Mahiru Shop. We are pleased to serve you.</p>
        </div>
    </footer>

    <script src="./js/popup.js"></script>
</body>
</html>