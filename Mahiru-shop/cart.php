<?php
session_start();
    
// Kiểm tra giỏ hàng
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Xử lý thêm sản phẩm vào giỏ hàng
if (isset($_GET['add_to_cart'])) {
    $product_id = intval($_GET['add_to_cart']);
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = 1; // Số lượng mặc định là 1
    } else {
        $_SESSION['cart'][$product_id] += 1; // Tăng số lượng nếu sản phẩm đã có trong giỏ hàng
    }
    header("Location: cart.php");
    exit();
}

// Xử lý yêu cầu xóa sản phẩm
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
        header("Location: cart.php");
        exit();
    }
}

// Xử lý yêu cầu cập nhật số lượng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $qty) {
        $id = intval($id);
        $qty = intval($qty);
        if ($qty > 0 && $qty <= 10) {
            $_SESSION['cart'][$id] = $qty;
        } else {
            // Xóa sản phẩm nếu số lượng không hợp lệ
            unset($_SESSION['cart'][$id]);
        }
    }
    header("Location: cart.php");
    exit();
}

// Khởi tạo biến $total và $shipping
$total = 0;
$shipping = 5.00;

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root"; // Thay bằng username của bạn
$password = ""; // Thay bằng password của bạn
$dbname = "mahiru_shop"; // Thay bằng tên database của bạn

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy dữ liệu sản phẩm từ cơ sở dữ liệu
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[$row['id']] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Cart - Mahiru Shop</title>
    <link rel="stylesheet" href="./css/styles.css" />
    <link rel="stylesheet" href="./css/cart.css" />
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
                    <a href="index.html" class="logo-link"><h1>MAHIRU<span>.</span></h1></a>
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
            <div class="cart-container">
                <h1 class="page-title">Your Shopping Cart</h1>
                <form action="cart.php" method="post" class="cart-form">
                    <div class="cart-items">
                        <?php if (empty($_SESSION['cart'])): ?>
                            <p class="empty-cart">Your cart is empty.</p>
                        <?php else: ?>
                            <?php foreach ($_SESSION['cart'] as $id => $qty): ?>
                                <?php if (isset($products[$id])): 
                                    $product = $products[$id];
                                    $subtotal = $product['price'] * $qty;
                                    $total += $subtotal;
                                ?>
                                    <div class="product-card">
                                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
                                        <div class="product-info">
                                            <h3><?php echo $product['name']; ?></h3>
                                            <p><?php echo $product['description']; ?></p>
                                            <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
                                            <div class="quantity-control">
                                                <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $qty; ?>" min="1" max="10">
                                                <a href="cart.php?remove=<?php echo $id; ?>" class="remove-btn">Remove</a>
                                            </div>
                                            <span class="subtotal">Subtotal: $<?php echo number_format($subtotal, 2); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($_SESSION['cart'])): ?>
                        <div class="cart-actions">
                            <button type="submit" name="update_cart" class="update-cart-btn">Update Cart</button>
                        </div>
                    <?php endif; ?>
                </form>
                <div class="cart-summary">
                    <h2>Order Summary</h2>
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>$<?php echo number_format($total, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span>$<?php echo number_format($shipping, 2); ?></span>
                    </div>
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span>$<?php echo number_format($total + $shipping, 2); ?></span>
                    </div>
                    <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
                </div>
            </div>
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
