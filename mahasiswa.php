<?php
session_start();

if (!isset($_SESSION['login'])) {
    echo "<script>
    alert('Login dulu dong');
    document.location.href = 'login.php';
    </script>";
}

// membatasi halaman sesuai user
if ($_SESSION['level'] != 1 and $_SESSION['level'] != 3){
    echo "<script>
    alert('Perhatian anda tidak punya hak akses!');
    document.location.href = 'crud-modal.php';
    </script>";
}

$title = "Daftar Mahasiswa";
include 'layout/header.php';

$data_mahasiswa = select("SELECT * FROM mahasiswa ORDER BY id_mahasiswa DESC");
?>

<div class="content-wrapper">
<div class="container mt-5">
    <h1> <i class="fa fa-list-ul" style="font-size: 36px;"></i> Data Mahasiswa</h1>
    <hr>
    <a href="tambah-mahasiswa.php" class="btn btn-primary mb-1"> <i class="fa fa-plus"></i> Tambah</a>
    <a href="download-excel-mahasiswa.php" class="btn btn-success mb-1"><i class="fa-solid fa-file-excel"></i> Download Excel</a>
    <a href="download-pdf-mahasiswa.php" class="btn btn-danger mb-1"><i class="fa-solid fa-file-pdf"></i> Download PDF</a>

    <table id="example" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Prodi</th>
                <th>Jenis Kelamin</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data_mahasiswa as $mahasiswa) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $mahasiswa["nama"] ?></td>
                    <td><?= $mahasiswa["prodi"] ?></td>
                    <td><?= $mahasiswa["jk"] ?></td>
                    <td><?= $mahasiswa["telepon"] ?></td>
                    <td><?= $mahasiswa["email"] ?></td>

                    <td width="15%" class="text-center">
                        <a href="detail-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-secondary btn-sm">Detail</a>
                        <a href="ubah-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-success btn-sm">Ubah</a>
                        <a href="hapus-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus barang?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'layout/footer.php' ?>