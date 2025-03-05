<?php
include "config.php";

$result = $conn->query("SELECT * FROM liquor_products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liquor Store</title>
    <link rel="stylesheet" href="css/index_user.css">
</head>
<body>

    <h2>Welcome to Our Liquor Store</h2>


    <a href="cart.php" class="view-cart">View Cart</a> <br>

    <?php while ($row = $result->fetch_assoc()) { ?>
    <div class="product">
        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="product-image">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p>Label: <?php echo htmlspecialchars($row['label']); ?></p>
        <p>Volume: <?php echo htmlspecialchars($row['volume_ml']); ?> ml</p>
        <p>Price: ₱<?php echo number_format($row['price'], 2); ?></p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
            <input type="number" name="quantity" value="1" min="1">
            <button type="submit">Add to Cart</button>
        </form>
    </div>
<?php } ?>





    <script src="js/script.js"></script>
</body>
</html>
