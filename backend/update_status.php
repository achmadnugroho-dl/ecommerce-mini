<?php 
include '../config/admin_guard.php';
include '../config/db.php';

if(isset($_GET['id'])){
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("UPDATE orders SET status='Dikirim' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: orders.php");
exit;
