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

$title = "Detail Mahasiswa";

include 'layout/header.php';
include 'config/app.php';

// mengambil id mahasiswa dari url
$id_mahasiswa = (int)$_GET['id_mahasiswa'];

$mahasiswa = select("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa")[0];

?>

<!-- PERBAIKAN LAYOUT: Menggunakan wrapper AdminLTE agar bergeser dari sidebar -->
<div class="content-wrapper">
    <!-- Content Header (Judul Halaman) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Data: <?= $mahasiswa['nama']; ?></h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Dibungkus Card AdminLTE agar tampilan detail terlihat elegan -->
            <div class="card">
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td style="width: 25%;"><strong>Nama</strong></td>
                                <td>: <?= $mahasiswa['nama']; ?></td>
                            </tr>

                            <tr>
                                <td><strong>Program Studi</strong></td>
                                <td>: <?= $mahasiswa['prodi']; ?></td>
                            </tr>

                            <tr>
                                <td><strong>Jenis Kelamin</strong></td>
                                <td>: <?= $mahasiswa['jk']; ?></td>
                            </tr>

                            <tr>
                                <td><strong>Telepon</strong></td>
                                <td>: <?= $mahasiswa['telepon']; ?></td>
                            </tr>

                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td>: <?= $mahasiswa['alamat']; ?></td>
                            </tr>

                            <tr>
                                <td><strong>Email</strong></td>
                                <td>: <?= $mahasiswa['email']; ?></td>
                            </tr>

                            <tr>
                                <td><strong>Nama File Foto</strong></td>
                                <td>: <?= $mahasiswa['foto']; ?></td>
                            </tr>

                            <tr>
                                <td><strong>Tampilan Foto</strong></td>
                                <td>:
                                    <a href="assets/img/<?= $mahasiswa['foto']; ?>" target="_blank" title="Klik untuk memperbesar">
                                        <!-- Menambahkan class img-thumbnail agar foto memiliki bingkai rapi -->
                                        <img src="assets/img/<?= $mahasiswa['foto']; ?>" alt="foto mahasiswa" class="img-thumbnail mt-2" style="max-width: 200px;">
                                    </a> 
                                </td>
                            </tr>
                        </table>
                    </div>

                    <hr>
                    
                    <!-- Menggunakan utility Bootstrap float-right agar tombol rapi di kanan bawah -->
                    <div class="clearfix">
                        <a href="mahasiswa.php" class="btn btn-secondary float-right">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'layout/footer.php'; ?>