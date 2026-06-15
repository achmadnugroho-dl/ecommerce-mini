<div class="admin-sidebar">
  <div class="brand">🔥 ecommerce-mini</div>
  <a href="dashboard.php" <?= basename($_SERVER['PHP_SELF'])=='dashboard.php'?'class="active"':'' ?>>📊 Dashboard</a>
  <a href="add_product.php" <?= basename($_SERVER['PHP_SELF'])=='add_product.php'?'class="active"':'' ?>>➕ Tambah Produk</a>
  <a href="orders.php" <?= basename($_SERVER['PHP_SELF'])=='orders.php'?'class="active"':'' ?>>📦 Pesanan</a>
  <a href="../index.php" style="margin-top:auto;">🏠 Ke Toko</a>
  <a href="../auth/logout.php" style="color:#f87171;margin-top:8px;">🚪 Logout</a>
</div>
