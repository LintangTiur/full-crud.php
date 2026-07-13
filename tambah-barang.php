<?php
session_start();

if (!isset($_SESSION['login'])){
    echo "<script>
    alert('Login dulu dong');
    document.location.href = 'login.php';
    </script>";
}

$title = "Tambah Barang";
include 'layout/header.php';

if (isset($_POST['tambah'])) {
    if (create_barang($_POST) > 0) {
        echo "<script>
        alert('Data berhasil ditambahkan!');
        document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
        alert('Data gagal ditambahkan!');
        document.location.href = 'index.php';
        </script>";
    }
}
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="container mt-5">
    <h1>Tambah Data Barang</h1>
    <hr>

    <form action="tambah-barang.php" method="post">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Barang" required>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Jumlah</label>
            <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah Barang" required>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Harga Barang</label>
            <input type="number" class="form-control" name="harga" id="harga" placeholder="Harga Barang" required>
        </div>

        <button type="submit" name="tambah" class="btn btn-primary" style="float: right;">
            <i class="fa fa-plus" style="font-size:14px"></i> Tambah
        </button>
    </form>
</div>
  </div>

  <?php include 'layout/footer.php'; ?>