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

$title = "Ubah Mahasiswa";

include 'config/app.php';

if (isset($_POST['ubah'])) {
    if (update_mahasiswa($_POST) > 0) {
        echo "<script>
                alert('Data berhasil diubah');
                document.location.href = 'mahasiswa.php';
              </script>";

    } else {
        echo "<script>
                alert('Data gagal diubah');
                document.location.href = 'mahasiswa.php';
              </script>";
    }
}

include 'layout/header.php';

// mengambil id mahasiswa dari url
$id_mahasiswa = (int)$_GET['id_mahasiswa'];

// query ambil data mahasiswa
$mahasiswa = select("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa")[0];

?>

<!-- PERBAIKAN LAYOUT: Menggunakan wrapper AdminLTE agar aman dari sidebar -->
<div class="content-wrapper">
    <!-- Content Header (Judul Halaman) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ubah Data Mahasiswa</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Dibungkus Card AdminLTE agar formulir terlihat rapi di dalam kotak putih -->
            <div class="card">
                <div class="card-body">
                    
                    <form action="" method="post" enctype="multipart/form-data">
                        <!-- Input Hidden ID & Foto Lama -->
                        <input type="hidden" name="id_mahasiswa" value="<?= $mahasiswa['id_mahasiswa'] ?>">
                        <input type="hidden" name="fotoLama" value="<?= $mahasiswa['foto'] ?>">

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Mahasiswa</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Mahasiswa..." required value="<?= $mahasiswa['nama'] ?>">   
                        </div>

                        <div class="row">
                            <!-- FIXED: Mengubah typo 'nb-3' menjadi 'mb-3' -->
                            <div class="mb-3 col-md-6">
                                <label for="prodi" class="form-label">Program Studi</label>
                                <select name="prodi" id="prodi" class="form-control" required>
                                    <?php $prodi = $mahasiswa['prodi']; ?>
                                    <option value="Teknik Informatika" <?= $prodi == 'Teknik Informatika' ? 'selected' : null ?>>Teknik Informatika</option>
                                    <option value="Sistem Informasi" <?= $prodi == 'Sistem Informasi' ? 'selected' : null ?>>Sistem Informasi</option>
                                    <option value="Teknik Komputer" <?= $prodi == 'Teknik Komputer' ? 'selected' : null ?>>Teknik Komputer</option>
                                </select>
                            </div>

                            <!-- FIXED: Mengubah typo 'nb-3' menjadi 'mb-3' dan menyesuaikan label ID Jenis Kelamin -->
                            <div class="mb-3 col-md-6">
                                <label for="jk" class="form-label">Jenis Kelamin</label>
                                <select name="jk" id="jk" class="form-control" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" <?= $mahasiswa['jk'] == 'Laki-laki' ? 'selected' : null ?>>Laki-laki</option>
                                    <option value="Perempuan" <?= $mahasiswa['jk'] == 'Perempuan' ? 'selected' : null ?>>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="number" class="form-control" id="telepon" name="telepon" placeholder="Nomor Telepon..." required value="<?= $mahasiswa['telepon'] ?>">
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <!-- OPTIMASI: Menambahkan class form-control dan rows agar textarea melebar rapi sesuai Bootstrap -->
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Alamat lengkap..." required><?= $mahasiswa['alamat']; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email..." required value="<?= $mahasiswa['email'] ?>">
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" onchange="previewImage()">
                            
                            <div class="mt-3">
                                <small class="text-muted d-block mb-1">Gambar saat ini:</small>
                                <!-- FIXED: Menghapus duplikasi atribut width -->
                                <img src="assets/img/<?= $mahasiswa['foto'] ?>" alt="foto" class="img-thumbnail img-preview" style="max-width: 150px;">
                            </div>
                        </div>

                        <hr>
                        
                        <!-- OPTIMASI UX: Tombol navigasi aksi -->
                        <div class="clearfix">
                            <a href="mahasiswa.php" class="btn btn-secondary float-left">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" name="ubah" class="btn btn-primary float-right">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'layout/footer.php'; ?>