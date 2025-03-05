<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "liquor_store";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$day = $_POST['day'];
$month = $_POST['month'];
$year = $_POST['year'];

$birth_date = "$year-$month-$day";
$age = date_diff(date_create($birth_date), date_create('today'))->y;

if ($age >= 21) {
    $stmt = $conn->prepare("INSERT INTO users (birth_date, confirmed) VALUES (?, 1)");
    $stmt->bind_param("s", $birth_date);
    $stmt->execute();
    echo "success";
} else {
    echo "fail";
}

$conn->close();
?>
