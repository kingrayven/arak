<?php
include "config.php";

// Default query to fetch all products
$query = "SELECT * FROM liquor_products";
$search_query = '';

// Check if the search term is set
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $query = "SELECT * FROM liquor_products WHERE name LIKE ? OR label LIKE ?";
}

$stmt = $conn->prepare($query);

if ($search_query) {
    // Securely bind the search parameter
    $search_param = "%" . $search_query . "%";
    $stmt->bind_param('ss', $search_param, $search_param);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drizzle</title>
    <link rel="icon" href="css/img/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="css/index_user.css">
</head>
<body>

    <h2>Welcome to Drizzle</h2>

    <!-- Header with Search bar and View Cart button -->
    <div class="header">

        <div class="header-right">
            <form action="" method="GET">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" class="search-input" placeholder="Search for products...">
                <button type="submit" class="search-btn">Search</button>
            </form>
            <a href="cart.php" class="view-cart">View Cart</a>
        </div>
    </div>

    <br>

    <!-- Display Products -->
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
