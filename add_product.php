<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "liquor_store";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$label = $_POST['label'];
$price = $_POST['price'];

$stmt = $conn->prepare("INSERT INTO liquor_products (name, label, price) VALUES (?, ?, ?)");
$stmt->bind_param("ssd", $name, $label, $price);
$stmt->execute();

header("Location: dashboard.php");
$conn->close();
?>
