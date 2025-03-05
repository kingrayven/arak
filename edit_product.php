<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "liquor_store";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $label = $_POST['label'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("UPDATE liquor_products SET name=?, label=?, price=? WHERE id=?");
    $stmt->bind_param("ssdi", $name, $label, $price, $id);
    $stmt->execute();

    header("Location: dashboard.php");
} else {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM liquor_products WHERE id=$id");
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>

    <h2>Edit Product</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label>Product Name</label>
        <input type="text" name="name" value="<?php echo $row['name']; ?>" required>

        <label>Label</label>
        <input type="text" name="label" value="<?php echo $row['label']; ?>" required>

        <label>Price</label>
        <input type="number" step="0.01" name="price" value="<?php echo $row['price']; ?>" required>

        <button type="submit">Update Product</button>
    </form>

</body>
</html>
