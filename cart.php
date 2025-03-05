<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "liquor_store";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $result = $conn->query("SELECT * FROM liquor_products WHERE id = $product_id");
    $product = $result->fetch_assoc();

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][] = [
        "id" => $product['id'],
        "name" => $product['name'],
        "label" => $product['label'],
        "price" => $product['price'],
        "quantity" => $quantity
    ];
}

// Display cart
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Your Cart</h2>

    <?php if (!empty($_SESSION['cart'])) { ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Label</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $item) {
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
                echo "<tr>
                        <td>{$item['name']}</td>
                        <td>{$item['label']}</td>
                        <td>\${$item['price']}</td>
                        <td>{$item['quantity']}</td>
                        <td>\${$subtotal}</td>
                      </tr>";
            }
            ?>
        </table>
        <h3>Grand Total: $<?php echo number_format($total, 2); ?></h3>

        <a href="checkout.php">Proceed to Checkout</a>
    <?php } else { ?>
        <p>Your cart is empty.</p>
    <?php } ?>

</body>
</html>
