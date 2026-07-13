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

//membatasi halaman seusai user login
if ($_SESSION["level"] != 1 and $_SESSION['level'] != 2) {
    echo "<script>
            alert('Anda tidak memiliki akses ke sini');
            document.location.href = 'crud-modal.php';
          </script>";
    exit;
}

$title = "Data Barang";

include 'config/database.php';

$data_barang = select("SELECT * FROM barang ORDER BY id_barang ASC");

function select($query)
{
    global $db;

    $result = mysqli_query($db, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

$data_barang = select("SELECT * FROM barang");
?>

<?php include 'layout/header.php'; ?>

<div class="container mt-5">
    <h1>Data Barang</h1>
    <hr>
    <a href="tambah-barang.php" class="btn btn-primary mb-1"><i class="fas fa-plus-circle"></i> Tambah</a>
    <table class="table table-bordered table-striped" id="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Barcode</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data_barang as $barang) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $barang['nama']; ?></td>
                <td><?= $barang['jumlah']; ?></td>
                <td>Rp. <?= number_format($barang['harga'], 0, ',', '.'); ?></td>
                <td class="text-center">
                    <img alt="barcode" src="barcode.php?codetype=Code128&size=15&text=<?= $barang['barcode']; ?>&print=true" />
                </td>
                <td><?= date('d/m/Y H:i:s', strtotime($barang['tanggal'])); ?></td>
                <td class="text-center" width="15%">
                    <a href="ubah-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Ubah</a>
                    <a href="hapus-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin data barang akan dihapus?');"><i class="fas fa-trash-alt"></i> Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'layout/footer.php'; ?>