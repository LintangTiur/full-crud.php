<?php

session_start();

// membatasi halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Silakan login terlebih dahulu!');
            document.location.href = 'login.php';
          </script>";
    exit;
}

$title = "Data akun";

include 'config/database.php';
include 'config/controller.php';

$data_akun = select("SELECT * FROM akun");

//tampil data berdasarkan user login
$id_akun = $_SESSION['id_akun'];
$data_bylogin = select("SELECT * FROM akun WHERE id_akun = $id_akun");

// jika tombol tambah ditekan jalankan script berikut
if (isset($_POST['tambah'])) {
    if (create_akun($_POST) > 0) {
        echo "<script>
                alert('Data akun berhasil ditambahkan');
                document.location.href = 'crud-modal.php';
              </script>";
    } else {
        echo "<script>
                alert('Data akun gagal ditambahkan');
                document.location.href = 'crud-modal.php';
              </script>";
    }
}

// jika tombol hapus ditekan jalankan script berikut
if (isset($_POST['hapus'])) {
    $id_akun = $_POST['id_akun'];
    
    // Memanggil fungsi delete_akun dari controller.php
    if (delete_akun($id_akun) > 0) { 
        echo "<script>
                alert('Data akun berhasil dihapus');
                document.location.href = 'crud-modal.php';
              </script>";
    } else {
        echo "<script>
                alert('Data akun gagal dihapus');
                document.location.href = 'crud-modal.php';
              </script>";
    }
}

// jika tombol ubah ditekan jalankan script berikut
if (isset($_POST['ubah'])) {
    if (update_akun($_POST) > 0) { 
        echo "<script>
                alert('Data akun berhasil diubah');
                document.location.href = 'crud-modal.php';
              </script>";
    } else {
        echo "<script>
                alert('Data akun gagal diubah');
                document.location.href = 'crud-modal.php';
              </script>";
    }
}
?>

<?php include 'layout/header.php'; ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Akun</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Card dengan garis biru atas sesuai AdminLTE di modul -->
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-cog mr-1"></i> Tabel Data Akun
                    </h3>
                </div>
                <div class="card-body">
                    
                    <?php if ($_SESSION['level'] == 1) : ?>
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambah">
                        <i class="fas fa-plus mr-1"></i> Tambah
                    </button>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle" id="table">
                            <thead class="text-center">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $no = 1; ?>
                                <?php if ($_SESSION['level'] == 1) : ?>
                                    <!-- Menampilkan semua data jika login sebagai Admin -->
                                    <?php foreach ($data_akun as $akun) : ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= $akun['nama']; ?></td>
                                            <td><?= $akun['username']; ?></td>
                                            <td><?= $akun['email']; ?></td>
                                            <td>Password ter-enkripsi</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#modalUbah<?= $akun['id_akun']; ?>">
                                                    <i class="fas fa-edit"></i> Ubah
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapus<?= $akun['id_akun']; ?>">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <!-- Menampilkan data milik user itu sendiri jika login sebagai Operator -->
                                    <?php foreach ($data_bylogin as $akun) : ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= $akun['nama']; ?></td>
                                            <td><?= $akun['username']; ?></td>
                                            <td><?= $akun['email']; ?></td>
                                            <td>Password ter-enkripsi</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalUbah<?= $akun['id_akun']; ?>">
                                                    <i class="fas fa-edit"></i> Ubah
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<!-- ==================== MODAL ZONE ==================== -->

<!-- Modal Tambah -->
<?php if ($_SESSION['level'] == 1) : ?>
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user-plus mr-2"></i>Tambah Akun</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
            <div class="form-group mb-3">
                <label for="nama" class="font-weight-bold">Nama</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap..." required>
            </div>
            <div class="form-group mb-3">
                <label for="username" class="font-weight-bold">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username..." required>
            </div>
            <div class="form-group mb-3">
                <label for="email" class="font-weight-bold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email aktif..." required>
            </div>
            <div class="form-group mb-3">
                <label for="password" class="font-weight-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password..." required>
            </div>
            <div class="form-group mb-3">
                <label for="level" class="font-weight-bold">Level</label>
                <select name="level" class="form-control" required>
                    <option value="">-- Pilih Level --</option>
                    <option value="1">Admin</option>
                    <option value="2">Operator Barang</option>
                    <option value="3">Operator Mahasiswa</option>
                </select> 
            </div>
        </div>
        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Kembali</button>
            <button type="submit" name="tambah" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Modal Hapus -->
<?php foreach ($data_akun as $akun) : ?>
<div class="modal fade" id="modalHapus<?= $akun['id_akun']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle mr-2"></i>Konfirmasi Hapus</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form action="" method="post">
        <input type="hidden" name="id_akun" value="<?= $akun['id_akun']; ?>">
        
        <div class="modal-body py-4">
            <p class="text-center mb-0" style="font-size: 1.1rem;">
                Apakah Anda yakin ingin menghapus data akun <strong class="text-danger"><?= $akun['nama']; ?></strong>?
            </p>
        </div>
        
        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
            <button type="submit" name="hapus" class="btn btn-danger"><i class="fas fa-trash-alt mr-1"></i> Ya, Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>

<!-- Modal Ubah -->
<?php foreach ($data_akun as $akun) : ?>
<div class="modal fade" id="modalUbah<?= $akun['id_akun']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user-edit mr-2"></i>Ubah Akun</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form action="" method="post">
        <div class="modal-body">
            <input type="hidden" name="id_akun" value="<?= $akun['id_akun']; ?>">

            <div class="form-group mb-3">
                <label for="nama" class="font-weight-bold">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?= $akun['nama']; ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="username" class="font-weight-bold">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="<?= $akun['username']; ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="email" class="font-weight-bold">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= $akun['email']; ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="password" class="font-weight-bold">Password <small class="text-danger">(Masukkan password baru/lama)</small></label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password untuk konfirmasi perubahan..." required>
            </div>

            <?php if ($_SESSION['level'] == 1) : ?>
            <div class="form-group mb-3">
                <label for="level" class="font-weight-bold">Level</label>
                <select name="level" id="level" class="form-control" required>
                    <?php $level = $akun['level']; ?>
                    <option value="1" <?= $level == 1 ? 'selected' : ''; ?>>Admin</option>
                    <option value="2" <?= $level == 2 ? 'selected' : ''; ?>>Operator Barang</option>
                    <option value="3" <?= $level == 3 ? 'selected' : ''; ?>>Operator Mahasiswa</option>
                </select> 
            </div>
            <?php else : ?>
                <input type="hidden" name="level" value="<?= $akun['level']; ?>">
            <?php endif; ?>
        </div>

        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Kembali</button>
            <button type="submit" name="ubah" class="btn btn-success"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
        </div>
      </form> 
    </div>
  </div>
</div>
<?php endforeach; ?>

<?php include 'layout/footer.php'; ?>