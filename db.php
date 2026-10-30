<?php

$host = "127.0.0.1";
$user = "sqli_app";
$password = "SqliApp@2026!";
$database = "sqli_lab";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed");
}

$conn->set_charset("utf8mb4");

echo "Database connection successful!";
?>
