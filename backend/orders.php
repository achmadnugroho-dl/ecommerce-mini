<?php 
include '../config/admin_guard.php';
include '../config/db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Pesanan — ecommerce-mini</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="admin-layout">
  <?php include 'sidebar.php'; ?>
  <div class="admin-content">
    <div class="admin-header">📦 Data Pesanan</div>
    <div class="table-wrap">
      <table>
        <thead>
          <tr><th>#</th><th>Nama</th><th>HP</th><th>Total</th><th>Metode</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        <?php
        $q = $conn->query("SELECT * FROM orders ORDER BY id DESC");
        while($o = $q->fetch_assoc()):
        $badge = $o['status']=='Dikirim' ? 'badge-sent' : 'badge-pending';
        ?>
        <tr>
          <td><?= $o['id'] ?></td>
          <td><?= htmlspecialchars($o['nama']) ?></td>
          <td><?= htmlspecialchars($o['hp']) ?></td>
          <td>Rp <?= number_format($o['total'], 0, ',', '.') ?></td>
          <td><?= htmlspecialchars($o['metode']) ?></td>
          <td><span class="badge <?= $badge ?>"><?= htmlspecialchars($o['status']) ?></span></td>
          <td>
            <?php if($o['status'] != 'Dikirim'): ?>
            <a href="update_status.php?id=<?= $o['id'] ?>" class="btn btn-success" style="padding:6px 14px;font-size:0.8rem;">✓ Kirim</a>
            <?php else: ?>
            <span style="color:var(--text-muted);font-size:0.85rem;">—</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
