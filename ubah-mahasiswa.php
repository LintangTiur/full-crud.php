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

$title = "ubah Mahasiswa";

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

<div class="container mt-5">
    <h1>Ubah Mahasiswa</h1>
    <hr>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_mahasiswa" value="<?= $mahasiswa['id_mahasiswa'] ?>">
        <input type="hidden" name="fotoLama" value="<?= $mahasiswa['foto'] ?>">

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Mahasiswa..." required value="<?= $mahasiswa['nama'] ?>">   
        </div>

        <div class="row">
            <div class="nb-3 col-6">
                <label for="prodi" class="form-label">Program Studi</label>
                <select name="prodi" id="prodi" class="form-control" required>
                    <?php $prodi = $mahasiswa['prodi']; ?>
                    <option value="Teknik Informatika" <?= $prodi == 'Teknik Informatika' ? 'selected' : null ?>>Teknik Informatika</option>
                    <option value="Sistem Informasi" <?= $prodi == 'Sistem Informasi' ? 'selected' : null ?>>Sistem Informasi</option>
                    <option value="Teknik Komputer" <?= $prodi == 'Teknik Komputer' ? 'selected' : null ?>>Teknik Komputer</option>
                </select>
            </div>

            <div class="nb-3 col-6">
                <label for="prodi" class="form-label">Jenis Kelamin</label>
                <select name="jk" id="prodi" class="form-control" required>
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
            <label for="telepon" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat"><?= $mahasiswa['alamat']; ?></textarea>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email..." required value="<?= $mahasiswa['email'] ?>">
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control" id="foto" name="foto" placeholder="Foto Mahasiswa..." onchange="previewImage()">
            <p>
                <small>Gambar sebelumnya</small>
            </p>
            <img src="assets/img/<?= $mahasiswa['foto'] ?>" alt="foto" width="100px" class="img-thumbnail img-preview mt-2" width="100px">
        </div>

        <input type="submit" name="ubah" class="btn btn-primary" style="float: right;">
    </form>
</div>

<?php include 'layout/footer.php'; ?>