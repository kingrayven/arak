<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "liquor_store";

// Enable error reporting (useful for debugging)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    $conn->set_charset("utf8mb4"); // Ensure proper encoding
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}

?>
