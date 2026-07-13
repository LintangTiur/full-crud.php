<?php
session_start();

if (!isset($_SESSION['login'])) {
    echo "<script>
    alert('Login dulu dong');
    document.location.href = 'login.php';
    </script>";
    exit; // Tambahkan exit setelah redirect
}

// membatasi halaman sesuai user
if ($_SESSION['level'] != 1 and $_SESSION['level'] != 3){
    echo "<script>
    alert('Perhatian anda tidak punya hak akses!');
    document.location.href = 'crud-modal.php';
    </script>";
    exit; // Tambahkan exit setelah redirect
}

$title = "Daftar Mahasiswa";
include 'layout/header.php';

$data_mahasiswa = select("SELECT * FROM mahasiswa ORDER BY id_mahasiswa DESC");
?>

<!-- PERBAIKAN STRUKTUR: Menggunakan standar layout AdminLTE 3 -->
<div class="content-wrapper">
    <!-- Content Header (Judul Halaman) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-list-ul"></i> Data Mahasiswa
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Menggunakan Card AdminLTE agar instan rapi dan clean -->
            <div class="card">
                <div class="card-header pb-0 border-0">
                    <!-- FIXED: Mengubah prefix ikon ke 'fas' agar logo Excel & PDF muncul -->
                    <a href="tambah-mahasiswa.php" class="btn btn-primary mb-2">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                    <a href="download-excel-mahasiswa.php" class="btn btn-success mb-2">
                        <i class="fas fa-file-excel"></i> Download Excel
                    </a>
                    <a href="download-pdf-mahasiswa.php" class="btn btn-danger mb-2">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                </div>
                
                <div class="card-body">
                    <!-- OPTIMASI: Dibungkus table-responsive agar tabel aman di layar kecil -->
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Prodi</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Telepon</th>
                                    <th>Email</th>
                                    <th class="text-center">Aksi</th>
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

                                        <td width="20%" class="text-center">
                                            <!-- Tombol aksi dikasih margin kecil (mx-1) agar tidak menempel rapat -->
                                            <a href="detail-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-secondary btn-sm mx-1">Detail</a>
                                            <a href="ubah-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-success btn-sm mx-1">Ubah</a>
                                            <a href="hapus-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-danger btn-sm mx-1"
                                                onclick="return confirm('Yakin ingin menghapus data?');">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div> <!-- FIXED: Tag penutup untuk content-wrapper yang krusial -->

<?php include 'layout/footer.php' ?>