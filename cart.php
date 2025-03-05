<?php
include "config.php";

// Add to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $result = $conn->query("SELECT * FROM liquor_products WHERE id = $product_id");
    $product = $result->fetch_assoc();

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id) {
            $item['quantity'] += $quantity; // Update quantity if product already in cart
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            "id" => $product['id'],
            "name" => $product['name'],
            "label" => $product['label'],
            "price" => $product['price'],
            "quantity" => $quantity
        ];
    }
}

// Update quantity
if (isset($_POST['update_quantity'])) {
    $update_id = $_POST['product_id'];
    $new_quantity = max(1, $_POST['quantity']); // Ensure minimum quantity is 1

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $update_id) {
            $item['quantity'] = $new_quantity;
            break;
        }
    }
}

// Remove from cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($remove_id) {
        return $item['id'] != $remove_id;
    });
}

// Clear cart
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Drizzle Shopping Cart</title>
    <link rel="icon" href="css/img/logo.png" type="image/png" sizes="16x16">
    
    <link rel="stylesheet" href="css/cart.css">
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
                <th>Action</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $item) {
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
                echo "<tr>
                        <td>{$item['name']}</td>
                        <td>{$item['label']}</td>
                        <td>₱" . number_format($item['price'], 2) . "</td>
                        <td>
                            <form method='post' action='cart.php'>
                                <input type='hidden' name='product_id' value='{$item['id']}'>
                                <button type='submit' name='update_quantity' value='-' onclick='this.parentNode.quantity.value=Math.max(1, parseInt(this.parentNode.quantity.value)-1)'>-</button>
                                <input type='number' name='quantity' value='{$item['quantity']}' min='1' style='width: 50px;'>
                                <button type='submit' name='update_quantity' value='+' onclick='this.parentNode.quantity.value=parseInt(this.parentNode.quantity.value)+1'>+</button>
                            </form>
                        </td>
                        <td>₱" . number_format($subtotal, 2) . "</td>
                        <td><a href='cart.php?remove={$item['id']}'>Remove</a></td>
                      </tr>";
            }
            ?>
        </table>
        <h3>Grand Total: ₱<?php echo number_format($total, 2); ?></h3>
        <a href="checkout.php">Proceed to Checkout</a> |
        <a href="cart.php?clear=true">Clear Cart</a>
    <?php } else { ?>
        <p>Your cart is empty.</p>
    <?php } ?>

</body>
</html>
