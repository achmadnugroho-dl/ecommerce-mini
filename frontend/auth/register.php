<?php 
session_start();
include '../config/db.php';

if(isset($_SESSION['user'])) { header("Location: ../index.php"); exit; }

$error = '';
$success = '';

if(isset($_POST['register'])){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if(strlen($username) < 3){
        $error = "Username minimal 3 karakter!";
    } elseif(strlen($password) < 5){
        $error = "Password minimal 5 karakter!";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $error = "Username sudah digunakan, coba yang lain!";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
            $ins->bind_param("ss", $username, $hash);
            $ins->execute();
            $success = "Registrasi berhasil! Silakan login.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register — ecommerce-mini 🔥</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="auth-wrap">
  <div class="auth-card">
    <div class="logo">🔥 Cemilan Pedas</div>
    <h2>Buat akun baru</h2>
    <p class="subtitle">Gratis dan cepat!</p>

    <?php if($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?> <a href="login.php">Login →</a></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="Minimal 3 karakter" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Minimal 5 karakter" required>
      </div>
      <button type="submit" name="register" class="btn btn-primary btn-full">Daftar Sekarang</button>
    </form>

    <div class="auth-footer">
      Sudah punya akun? <a href="login.php">Masuk</a>
    </div>
  </div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
