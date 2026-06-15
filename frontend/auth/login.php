<?php 
session_start();
include '../config/db.php';

// Redirect jika sudah login
if(isset($_SESSION['user'])){
    if($_SESSION['role'] == 'admin') header("Location: ../admin/dashboard.php");
    else header("Location: ../index.php");
    exit;
}

$error = '';

if(isset($_POST['login'])){
    $u = trim($_POST['username']);
    $p = $_POST['password'];

    // Pakai prepared statement - aman dari SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $u);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if($row && password_verify($p, $row['password'])){
        $_SESSION['user'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['user_id'] = $row['id'];

        if($row['role'] == 'admin'){
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../index.php");
        }
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — ecommerce-mini 🔥</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="auth-wrap">
  <div class="auth-card">
    <div class="logo">🔥 Cemilan Pedas</div>
    <h2>Selamat datang!</h2>
    <p class="subtitle">Masuk ke akun kamu</p>

    <?php if($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" onsubmit="return validateLogin()">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="Masukkan username" autocomplete="username" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
      </div>
      <button type="submit" name="login" class="btn btn-primary btn-full">Masuk</button>
    </form>

    <div class="auth-footer">
      Belum punya akun? <a href="register.php">Daftar sekarang</a>
    </div>
  </div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
