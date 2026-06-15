<?php
include '../config/admin_guard.php';
include '../config/db.php';

if(!isset($_GET['id'])){
    header("Location: dashboard.php");
    exit;
}

$id = (int)$_GET['id'];

// Ambil nama file gambar sebelum dihapus
$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if(!$result){
    header("Location: dashboard.php?error=Produk tidak ditemukan");
    exit;
}

// Cek apakah produk masih ada di order_items
$cek = $conn->prepare("SELECT COUNT(*) as c FROM order_items WHERE product_id = ?");
$cek->bind_param("i", $id);
$cek->execute();
$jumlah = $cek->get_result()->fetch_assoc()['c'];

if($jumlah > 0){
    header("Location: dashboard.php?error=Produk tidak bisa dihapus karena masih terkait dengan pesanan");
    exit;
}

// Hapus record dari database
$del = $conn->prepare("DELETE FROM products WHERE id = ?");
$del->bind_param("i", $id);
$del->execute();

// Hapus file gambar jika bukan gambar default
$image = $result['image'];
$path = "../uploads/" . $image;
$default = ['basreng.jpg','kripik.jpg','makaroni.jpg'];
if(!in_array($image, $default) && file_exists($path)){
    unlink($path);
}

header("Location: dashboard.php?success=Produk berhasil dihapus");
exit;
