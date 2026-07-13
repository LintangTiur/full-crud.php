<?php

session_start();

//membatasi halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Silakan login terlebih dahulu!');
            document.location.href = 'login.php';
          </script>";
    exit;
}

$title = "Ubah Barang";

include 'config/app.php';

//mengambil id_barang dari url
$id_barang = (int)$_GET['id_barang'];

$barang = select("SELECT * FROM barang WHERE id_barang = $id_barang")[0];

//cek apakah tombol ubah sudah ditekan
if (isset($_POST['ubah'])) {
    if (update_barang($_POST, $id_barang) > 0) {
        echo "<script>
                alert('Data barang berhasil diubah');
                document.location.href = 'index.php';
              </script>";

    } else {
        echo "<script>
                alert('Data barang gagal diubah');
                document.location.href = 'index.php';
              </script>";
    }
}

include 'layout/header.php';
?>

<div class="container mt-5">
    <h1>Ubah Barang</h1>
    <hr>

    <form action="" method="post">

        <input type="hidden" name="id_barang" value="<?= $barang['id_barang']; ?>">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $barang['nama']; ?>" placeholder="Nama Barang..." required>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= $barang['jumlah']; ?>" placeholder="Jumlah Barang..." required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga Barang</label>
            <input type="number" class="form-control" id="harga" name="harga" value="<?= $barang['harga']; ?>" placeholder="Harga Barang..." required>
        </div>
        <button type="submit" name="ubah" class="btn btn-primary" style="float: right;">Ubah</button>
    </form>
</div>

<?php include 'layout/footer.php'; ?>
