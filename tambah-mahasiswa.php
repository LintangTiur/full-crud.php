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

$title = "Tambah Mahasiswa";

include 'config/app.php';

if (isset($_POST['tambah'])) {
    if (create_mahasiswa($_POST) > 0) {
        echo "<script>
                alert('Data berhasil ditambahkan');
                document.location.href = 'mahasiswa.php';
              </script>";

    } else {
        echo "<script>
                alert('Data gagal ditambahkan');
                document.location.href = 'mahasiswa.php';
              </script>";
    }
}

include 'layout/header.php';
?>

<div class="container mt-5">
    <h1>Tambah Mahasiswa</h1>
    <hr>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Mahasiswa..." required>
        </div>

        <div class="row">
            <div class="nb-3 col-6">
                <label for="prodi" class="form-label">Program Studi</label>
                <select name="prodi" id="prodi" class="form-control" required>
                    <option value="">-- Pilih Program Studi --</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Sistem Informasi">Teknik Mesin</option>
                    <option value="Teknik Komputer">Teknik Elektro</option>
                </select>
            </div>

            <div class="nb-3 col-6">
                <label for="prodi" class="form-label">Jenis Kelamin</label>
                <select name="jk" id="prodi" class="form-control" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="number" class="form-control" id="telepon" name="telepon" placeholder="Nomor Telepon..." required>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat"></textarea>
        </div>


        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email..." required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control" id="foto" name="foto" placeholder="Foto Mahasiswa...">
            <img src="" alt="" class="img-thumbnail img-preview" width="100px">
        </div>


        <input type="submit" name="tambah" class="btn btn-primary" style="float: right;">
    </form>
</div>

<!-- preview image -->
 <script>
     function previewImage() {
        const foto = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview');

        const fileFoto = new FileReader();
        fileFoto.readAsDataURL(foto.files[0]);

        fileFoto.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
 </script>


<?php include 'layout/footer.php'; ?>