<?php
include "config.php";


$customer_name = $_POST['customer_name'];
$address = $_POST['address'];
$phone = $_POST['phone'];

$stmt = $conn->prepare("INSERT INTO orders (customer_name, address, phone) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $customer_name, $address, $phone);
$stmt->execute();

$order_id = $stmt->insert_id;

foreach ($_SESSION['cart'] as $item) {
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
    $stmt->execute();
}

unset($_SESSION['cart']);

header("Location: order_success.php");
?>
