<?php
session_start();
if (empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Checkout</h2>
    <form action="place_order.php" method="POST">
        <label>Name</label>
        <input type="text" name="customer_name" required>

        <label>Address</label>
        <input type="text" name="address" required>

        <label>Phone Number</label>
        <input type="text" name="phone" required>

        <button type="submit">Place Order</button>
    </form>

</body>
</html>
