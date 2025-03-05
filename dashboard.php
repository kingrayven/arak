<?php
include "config.php";
if (!isset($_SESSION['store_manager'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h2>Store Manager Dashboard</h2>
    <a href="logout.php">Logout</a>

    <h3>Add New Product</h3>
    <form action="add_product.php" method="POST">
        <label>Product Name</label>
        <input type="text" name="name" required>

        <label>Label</label>
        <input type="text" name="label" required>

        <label>Price</label>
        <input type="number" step="0.01" name="price" required>

        <button type="submit">Add Product</button>
    </form>

    <h3>Product List</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Label</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php
        $conn = new mysqli("localhost", "root", "", "liquor_store");
        $result = $conn->query("SELECT * FROM liquor_products");

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['label']}</td>
                    <td>\${$row['price']}</td>
                    <td>
                        <a href='edit_product.php?id={$row['id']}'>Edit</a> | 
                        <a href='delete_product.php?id={$row['id']}'>Delete</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>

</body>
</html>
