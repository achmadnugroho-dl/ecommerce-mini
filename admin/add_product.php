<?php 
include '../config/admin_guard.php';
include '../config/db.php';

$success = '';
$error = '';

if(isset($_POST['save'])){
    $name        = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price       = (int)$_POST['price'];

    if(empty($name) || $price <= 0){
        $error = "Nama produk dan harga wajib diisi!";
    } elseif(empty($_FILES['image']['name'])){
        $error = "Gambar produk wajib diunggah!";
    } else {
        $allowed = ['jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if(!in_array($ext, $allowed)){
            $error = "Format gambar tidak didukung! Gunakan JPG, PNG, atau WebP.";
        } else {
            $filename = uniqid('prod_').'.'.$ext;
            $dest = "../uploads/".$filename;

            if(move_uploaded_file($_FILES['image']['tmp_name'], $dest)){
                $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssis", $name, $description, $price, $filename);
                $stmt->execute();
                $success = "Produk \"$name\" berhasil ditambahkan!";
            } else {
                $error = "Gagal mengunggah gambar. Pastikan folder uploads ada dan bisa ditulis.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Produk — Admin | ecommerce-mini</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="admin-layout">
  <?php include 'sidebar.php'; ?>
  <div class="admin-content">
    <div class="admin-header">➕ Tambah Produk</div>

    <?php if($error): ?>
    <div class="alert alert-danger" style="max-width:540px;"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if($success): ?>
    <div class="alert alert-success" style="max-width:540px;"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div style="background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:28px;max-width:540px;">
      <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label>Nama Produk</label>
          <input type="text" name="name" placeholder="Contoh: Makaroni Pedas Level 5" required>
        </div>
        <div class="form-group">
          <label>Deskripsi Produk</label>
          <textarea name="description" rows="3" placeholder="Contoh: Makaroni kriuk dengan bumbu pedas spesial yang bikin ketagihan!" style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:var(--radius);background:var(--bg);color:var(--text);font-size:0.95rem;resize:vertical;font-family:inherit;"></textarea>
        </div>
        <div class="form-group">
          <label>Harga (Rp)</label>
          <input type="number" name="price" placeholder="Contoh: 15000" min="0" required>
        </div>
        <div class="form-group">
          <label>Foto Produk (JPG/PNG/WebP)</label>
          <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" required style="padding:8px 0;">
        </div>
        <button type="submit" name="save" class="btn btn-primary" style="width:100%;margin-top:8px;">💾 Simpan Produk</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
