<?php 
session_start();
include 'config/db.php';

if(empty($_SESSION['cart'])){
    header("Location: cart.php");
    exit;
}

$success = false;

if(isset($_POST['order'])){
    $nama   = trim($_POST['nama']);
    $hp     = trim($_POST['hp']);
    $alamat = trim($_POST['alamat']);
    $metode = $_POST['metode'];

    $total = 0;
    foreach($_SESSION['cart'] as $id){
        $id = (int)$id;
        $q = $conn->prepare("SELECT price FROM products WHERE id = ?");
        $q->bind_param("i", $id);
        $q->execute();
        $p = $q->get_result()->fetch_assoc();
        if($p) $total += $p['price'];
    }

    $stmt = $conn->prepare("INSERT INTO orders (nama, alamat, hp, total, metode, status) VALUES (?, ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("sssds", $nama, $alamat, $hp, $total, $metode);
    $stmt->execute();
    $order_id = $conn->insert_id;

    foreach($_SESSION['cart'] as $id){
        $id = (int)$id;
        $ins = $conn->prepare("INSERT INTO order_items (order_id, product_id, qty) VALUES (?, ?, 1)");
        $ins->bind_param("ii", $order_id, $id);
        $ins->execute();
    }

    unset($_SESSION['cart']);
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout — ecommerce-mini</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="navbar-brand"><span class="fire">🔥</span> ecommerce-mini</a>
  <div class="navbar-links">
    <a href="cart.php">← Kembali ke Keranjang</a>
  </div>
</nav>

<div class="checkout-wrap">

<?php if($success): ?>
  <div style="text-align:center;padding:60px 20px;">
    <div style="font-size:4rem;margin-bottom:16px;">🎉</div>
    <h2 style="font-family:'Syne',sans-serif;margin-bottom:8px;">Pesanan Berhasil!</h2>
    <p style="color:var(--text-muted);margin-bottom:28px;">Terima kasih sudah belanja! Pesanan kamu sedang diproses.</p>
    <a href="index.php" class="btn btn-primary">Belanja Lagi</a>
  </div>
<?php else: ?>
  <div class="page-title">📦 Checkout</div>
  <form method="POST">
    <div class="auth-card" style="max-width:100%;">
      <h3 style="font-family:'Syne',sans-serif;margin-bottom:20px;">Data Pengiriman</h3>
      <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>
      </div>
      <div class="form-group">
        <label>No. HP / WhatsApp</label>
        <input type="text" name="hp" placeholder="08xxxxxxxxxx" required>
      </div>
      <div class="form-group">
        <label>Alamat Lengkap</label>
        <textarea name="alamat" placeholder="Jalan, nomor rumah, kelurahan, kecamatan, kota..." required></textarea>
      </div>
      <div class="form-group">
        <label>Metode Pembayaran</label>
        <select name="metode">
          <option value="BCA">Transfer BCA</option>
          <option value="DANA">DANA</option>
          <option value="OVO">OVO</option>
          <option value="GoPay">GoPay</option>
          <option value="COD">COD (Bayar di Tempat)</option>
        </select>
      </div>
      <button type="submit" name="order" class="btn btn-primary btn-full" style="margin-top:8px;">✅ Konfirmasi Pesanan</button>
    </div>
  </form>
<?php endif; ?>

</div>
<script src="assets/js/script.js"></script>
</body>
</html>
