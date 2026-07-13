
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

<!-- PERBAIKAN LAYOUT: Menggunakan wrapper AdminLTE agar form tidak tertutup sidebar -->
<div class="content-wrapper">
    <!-- Content Header (Judul Halaman) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Data Mahasiswa</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Dibungkus Card AdminLTE agar formulir berada di kotak putih yang rapi -->
            <div class="card">
                <div class="card-body">
                    
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Mahasiswa</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Mahasiswa..." required>
                        </div>

                        <div class="row">
                            <!-- FIXED: Mengubah typo 'nb-3' menjadi 'mb-3' -->
                            <div class="mb-3 col-md-6">
                                <label for="prodi" class="form-label">Program Studi</label>
                                <select name="prodi" id="prodi" class="form-control" required>
                                    <option value="">-- Pilih Program Studi --</option>
                                    <!-- FIXED: Menyelaraskan value dengan teks prodi yang benar -->
                                    <option value="Teknik Informatika">Teknik Informatika</option>
                                    <option value="Sistem Informasi">Sistem Informasi</option>
                                    <option value="Teknik Komputer">Teknik Komputer</option>
                                </select>
                            </div>

                            <!-- FIXED: Mengubah id="prodi" menjadi id="jk" agar tidak duplikat -->
                            <div class="mb-3 col-md-6">
                                <label for="jk" class="form-label">Jenis Kelamin</label>
                                <select name="jk" id="jk" class="form-control" required>
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
                            <!-- FIXED: Mengubah for="telepon" menjadi for="alamat" -->
                            <label for="alamat" class="form-label">Alamat</label>
                            <!-- OPTIMASI: Menambahkan class form-control agar kotak text alamat melebar rapi -->
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Alamat lengkap..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email..." required>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <!-- FIXED: Menambahkan atribut onchange agar fungsi Javascript pemanggil preview bekerja -->
                            <input type="file" class="form-control" id="foto" name="foto" onchange="previewImage()" required>
                            
                            <div class="mt-3">
                                <small class="text-muted d-block mb-1">Pratinjau Foto:</small>
                                <!-- OPTIMASI: Ditambahkan max-width dan display none awal agar kotak pecah tidak muncul sebelum upload -->
                                <img src="" alt="" class="img-thumbnail img-preview" style="max-width: 150px; display: none;">
                            </div>
                        </div>

                        <hr>
                        
                        <!-- Navigasi Aksi Bawah -->
                        <div class="clearfix">
                            <a href="mahasiswa.php" class="btn btn-secondary float-left">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" name="tambah" class="btn btn-primary float-right">
                                <i class="fas fa-save"></i> Simpan Data
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>

<!-- Preview Image Script (Ditingkatkan sedikit agar kotak gambar muncul saat file dipilih saja) -->
<script>
    function previewImage() {
        const foto = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview');

        // Memastikan ada file yang dipilih
        if (foto.files && foto.files[0]) {
            imgPreview.style.display = 'block'; // Tampilkan elemen gambar
            const fileFoto = new FileReader();
            fileFoto.readAsDataURL(foto.files[0]);

            fileFoto.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }
    }
</script>

<?php include 'layout/footer.php'; ?>