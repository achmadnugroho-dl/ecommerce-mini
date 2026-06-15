<?php 
include '../config/admin_guard.php';
include '../config/db.php';

$total_produk    = $conn->query("SELECT COUNT(*) as c FROM products")->fetch_assoc()['c'] ?? 0;
$total_pesanan   = $conn->query("SELECT COUNT(*) as c FROM orders")->fetch_assoc()['c'] ?? 0;
$total_pendapatan= $conn->query("SELECT SUM(total) as s FROM orders WHERE status='Dikirim'")->fetch_assoc()['s'] ?? 0;
$pesanan_pending = $conn->query("SELECT COUNT(*) as c FROM orders WHERE status='Pending'")->fetch_assoc()['c'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard — ecommerce-mini</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
  .btn-danger {
    background: #ef4444;
    color: #fff;
    border: none;
    border-radius: var(--radius);
    padding: 6px 14px;
    font-size: 0.8rem;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background 0.2s;
  }
  .btn-danger:hover { background: #dc2626; }
  .desc-cell {
    font-size: 0.82rem;
    color: var(--text-muted);
    max-width: 220px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
</style>
</head>
<body>
<div class="admin-layout">
  <?php include 'sidebar.php'; ?>
  <div class="admin-content">
    <div class="admin-header">📊 Dashboard</div>

    <?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success" style="max-width:100%;"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>
    <?php if(isset($_GET['error'])): ?>
    <div class="alert alert-danger" style="max-width:100%;"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <div class="stat-grid">
      <div class="stat-card">
        <div class="stat-label">Total Produk</div>
        <div class="stat-value"><?= $total_produk ?></div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Total Pesanan</div>
        <div class="stat-value"><?= $total_pesanan ?></div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Pending</div>
        <div class="stat-value" style="color:var(--accent)"><?= $pesanan_pending ?></div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Pendapatan (Terkirim)</div>
        <div class="stat-value" style="font-size:1.2rem;">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></div>
      </div>
    </div>

    <div class="admin-header" style="font-size:1.1rem;margin-bottom:16px;">📦 Daftar Produk</div>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Gambar</th>
            <th>Nama Produk</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $q = $conn->query("SELECT * FROM products ORDER BY id DESC");
        while($p = $q->fetch_assoc()):
        ?>
        <tr>
          <td><img src="../uploads/<?= htmlspecialchars($p['image']) ?>" style="width:48px;height:40px;object-fit:cover;border-radius:6px;"></td>
          <td><?= htmlspecialchars($p['name']) ?></td>
          <td><div class="desc-cell" title="<?= htmlspecialchars($p['description'] ?? '') ?>"><?= htmlspecialchars($p['description'] ?? '—') ?></div></td>
          <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
          <td>
            <a href="delete_product.php?id=<?= $p['id'] ?>"
               class="btn-danger"
               onclick="return confirm('Yakin ingin menghapus produk \"<?= htmlspecialchars($p['name'], ENT_QUOTES) ?>\"?')">
              🗑️ Hapus
            </a>
          </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
