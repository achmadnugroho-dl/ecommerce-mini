<?php 
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ecommerce-mini 🔥</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="navbar-brand">
    <span class="fire">🔥</span> ecommerce-mini
  </a>
  <div class="navbar-links">
    <?php if(isset($_SESSION['user'])): ?>
      <span style="color:var(--text-muted);font-size:0.85rem;">Hi, <?= htmlspecialchars($_SESSION['user']) ?>!</span>
      <?php if($_SESSION['role']=='admin'): ?>
        <a href="admin/dashboard.php">Admin</a>
      <?php endif; ?>
      <a href="auth/logout.php">Keluar</a>
    <?php else: ?>
      <a href="auth/login.php">Masuk</a>
      <a href="auth/register.php">Daftar</a>
    <?php endif; ?>
    <a href="cart.php" class="btn-cart">🛒 Keranjang
      <?php 
        $jumlah = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
        if($jumlah > 0) echo "<span style='background:white;color:var(--primary);border-radius:50%;padding:0 6px;font-size:0.75rem;font-weight:700;margin-left:4px;'>$jumlah</span>";
      ?>
    </a>
  </div>
</nav>

<div class="hero">
  <h1>Cemilan Pedas<br><span>Favoritmu!</span> 🌶️</h1>
  <p>Snack pedas premium, renyah, dan bikin nagih. Pesan sekarang, dikirim ke seluruh Indonesia!</p>
</div>

<div class="container">
  <div class="section-title">Produk Kami</div>
  <div class="produk">
  <?php
  $result = $conn->query("SELECT * FROM products");
  while($row = $result->fetch_assoc()):
    $desc = !empty($row['description']) ? $row['description'] : 'Cemilan pedas pilihan terbaik, renyah dan lezat.';
  ?>
  <div class="card">
    <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" loading="lazy">
    <div class="card-body">
      <h3><?= htmlspecialchars($row['name']) ?></h3>
      <div class="price">Rp <?= number_format($row['price'], 0, ',', '.') ?></div>
      <p class="desc"><?= htmlspecialchars($desc) ?></p>
      <form method="POST" action="cart.php">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <button type="submit" name="add" class="btn btn-primary">+ Keranjang</button>
      </form>
    </div>
  </div>
  <?php endwhile; ?>
  </div>
</div>

<script src="assets/js/script.js"></script>
</body>
</html>
