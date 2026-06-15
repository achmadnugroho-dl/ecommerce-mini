<?php
$conn = new mysqli("localhost", "root", "", "ecommerce_mini");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
