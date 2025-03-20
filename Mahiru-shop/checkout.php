<?php
session_start();

// Kiểm tra giỏ hàng
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Khởi tạo biến tổng tiền và phí vận chuyển
$total = 0;
$shipping = 5.00;

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mahiru_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu sản phẩm từ giỏ hàng
$products = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($ids)");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $products[$row['id']] = $row;
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Mahiru Shop</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/checkout.css">
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
            <form action="process_checkout.php" method="post" class="checkout-form">
                <h1 class="page-title">Checkout</h1>
                <div class="checkout-container">
                    <div class="shipping-info">
                        <h2>Shipping Information</h2>
                        <input type="text" name="full_name" placeholder="Full Name" required>
                        <input type="text" name="street_address" placeholder="Street Address" required>
                        <input type="text" name="city" placeholder="City" required>
                        <input type="text" name="state" placeholder="State/Province">
                        <input type="text" name="zip_code" placeholder="ZIP/Postal Code">
                        <input type="text" name="country" placeholder="Country" required>
                        <input type="tel" name="phone" placeholder="Phone Number" required>
                    </div>
                    <div class="payment-info">
                        <h2>Payment Method</h2>
                        <div class="payment-options">
                            <label><input type="radio" name="payment" value="cash" checked> Cash on Delivery</label>
                            <label><input type="radio" name="payment" value="bank_transfer"> Bank Transfer</label>
                            <label><input type="radio" name="payment" value="credit_card"> Credit/Debit Card</label>
                        </div>
                    </div>
                </div>
                <div class="order-summary">
                    <h2>Order Summary</h2>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($_SESSION['cart'] as $id => $qty): ?>
                            <?php if (isset($products[$id])): 
                                $product = $products[$id];
                                $subtotal = $product['price'] * $qty;
                                $total += $subtotal;
                            ?>
                            <div class="summary-row">
                                <span><?php echo htmlspecialchars($product['name']); ?> (x<?php echo $qty; ?>)</span>
                                <span>$<?php echo number_format($subtotal, 2); ?></span>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Your cart is empty or contains invalid products.</p>
                    <?php endif; ?>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span>$<?php echo number_format($shipping, 2); ?></span>
                    </div>
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span>$<?php echo number_format($total + $shipping, 2); ?></span>
                    </div>
                    <input type="hidden" name="total" value="<?php echo $total + $shipping; ?>">
                    <button type="submit" class="place-order-btn">Place Order</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
