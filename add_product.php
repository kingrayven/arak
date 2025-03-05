<?php
include "config.php";

$name = $_POST['name'];
$label = $_POST['label'];
$volume_ml = $_POST['volume_ml']; // Get volume from form
$price = $_POST['price'];

// Handle Image Upload
$target_dir = "uploads/";
$image_name = basename($_FILES["image"]["name"]);
$target_file = $target_dir . $image_name;
move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

// Insert product with volume and image
$stmt = $conn->prepare("INSERT INTO liquor_products (name, label, volume_ml, price, image) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssids", $name, $label, $volume_ml, $price, $image_name);
$stmt->execute();

header("Location: dashboard.php");
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add</title>
</head>
<body>
<form action="add_product.php" method="post" enctype="multipart/form-data">
    <label for="name">Product Name:</label>
    <input type="text" name="name" required>

    <label for="label">Label:</label>
    <input type="text" name="label" required>

    <label for="volume_ml">Volume (ml):</label>
    <input type="number" name="volume_ml" required>

    <label for="price">Price (₱):</label>
    <input type="number" step="0.01" name="price" required>

    <label for="image">Product Image:</label>
    <input type="file" name="image" accept="image/*" required>

    <button type="submit">Add Product</button>
</form>


</body>
</html>