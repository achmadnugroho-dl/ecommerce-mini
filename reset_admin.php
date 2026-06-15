<?php
include 'config/db.php';

$password_baru = 'admin123';
$hash = password_hash($password_baru, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = 'admin'");
$stmt->bind_param("s", $hash);

if($stmt->execute()){
    echo "✅ Password admin berhasil direset ke: <b>admin123</b>";
} else {
    echo "❌ Gagal: " . $conn->error;
}
?>