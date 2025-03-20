<?php
session_start();

// Kiểm tra giỏ hàng
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Mahiru Shop</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="cart-container">
                <h1 class="page-title">Your Shopping Cart</h1>
                <form action="cart.php" method="post" class="cart-form">
                    <div class="cart-items">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($_SESSION['cart'])): ?>
                                    <tr>
                                        <td colspan="5" class="empty-cart">Your cart is empty.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($_SESSION['cart'] as $id => $qty): ?>
                                        <?php if (isset($products[$id])): 
                                            $product = $products[$id];
                                            $subtotal = $product['price'] * $qty;
                                            $total += $subtotal;
                                        ?>
                                            <tr>
                                                <td>
                                                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="cart-item-image">
                                                    <div class="product-info">
                                                        <h3><?php echo $product['name']; ?></h3>
                                                        <p><?php echo $product['description']; ?></p>
                                                    </div>
                                                </td>
                                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                                <td>
                                                    <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $qty; ?>" min="1" max="10">
                                                </td>
                                                <td>$<?php echo number_format($subtotal, 2); ?></td>
                                                <td>
                                                    <a href="cart.php?remove=<?php echo $id; ?>" class="remove-btn">Remove</a>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
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
</body>
</html>
<?php
$conn->close();
?>
