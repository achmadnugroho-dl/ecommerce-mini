<?php 
session_start();
include 'config/db.php';

// Tambah produk ke keranjang
if(isset($_POST['add'])){
    $id = (int)$_POST['id'];
    if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    $_SESSION['cart'][] = $id;
    header("Location: index.php");
    exit;
}

// Hapus item dari keranjang
if(isset($_GET['hapus'])){
    $idx = (int)$_GET['hapus'];
    if(isset($_SESSION['cart'][$idx])){
        array_splice($_SESSION['cart'], $idx, 1);
    }
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Keranjang — ecommerce-mini</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="navbar-brand"><span class="fire">🔥</span> ecommerce-mini</a>
  <div class="navbar-links">
    <a href="index.php">← Lanjut Belanja</a>
  </div>
</nav>

<div class="cart-wrap">
  <div class="page-title">🛒 Keranjang Belanja</div>

  <?php
  $total = 0;
  if(!empty($_SESSION['cart'])):
    foreach($_SESSION['cart'] as $idx => $id):
        $id = (int)$id;
        $q = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $q->bind_param("i", $id);
        $q->execute();
        $p = $q->get_result()->fetch_assoc();
        if(!$p) continue;
        $total += $p['price'];
  ?>
  <div class="cart-item">
    <div>
      <div class="cart-item-name"><?= htmlspecialchars($p['name']) ?></div>
    </div>
    <div style="display:flex;align-items:center;gap:16px;">
      <div class="cart-item-price">Rp <?= number_format($p['price'], 0, ',', '.') ?></div>
      <a href="cart.php?hapus=<?= $idx ?>" style="color:var(--text-muted);font-size:1.1rem;text-decoration:none;" title="Hapus">✕</a>
    </div>
  </div>
  <?php endforeach;
  else: ?>
  <div class="empty-cart">
    <div class="icon">🛒</div>
    <div>Keranjang kamu masih kosong</div>
    <a href="index.php" class="btn btn-outline" style="margin-top:16px;">Lihat Produk</a>
  </div>
  <?php endif; ?>

  <?php if(!empty($_SESSION['cart'])): ?>
  <div class="cart-total">
    <div class="total-label">Total Pembayaran</div>
    <div class="total-amount">Rp <?= number_format($total, 0, ',', '.') ?></div>
  </div>
  <div class="cart-actions">
    <a href="index.php" class="btn btn-outline" style="flex:1;">← Lanjut Belanja</a>
    <a href="checkout.php" class="btn btn-primary" style="flex:2;">Checkout Sekarang →</a>
  </div>
  <?php endif; ?>
</div>

<script src="assets/js/script.js"></script>
</body>
</html>
