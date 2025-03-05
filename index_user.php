<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "liquor_store";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM liquor_products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liquor Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Welcome to Our Liquor Store</h2>

    <div class="product-list">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="product">
                <h3><?php echo $row['name']; ?></h3>
                <p>Label: <?php echo $row['label']; ?></p>
                <p>Price: $<?php echo $row['price']; ?></p>
                <form action="cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input type="number" name="quantity" value="1" min="1">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php } ?>
    </div>

    <a href="cart.php">View Cart</a>

</body>
</html>
