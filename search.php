<?php
// 1. FIXED: Wajib jalankan session di baris paling pertama agar nama admin di sidebar muncul kembali
session_start(); 

$title = "Hasil Pencarian Global - CRUD PHP";
include 'layout/header.php';

// Ambil kata kunci dari URL secara aman
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($db, $_GET['keyword']) : '';

// Query pencarian ke tabel akun berdasarkan nama, username, atau email
$query_akun = mysqli_query($db, "SELECT * FROM akun WHERE 
                                nama LIKE '%$keyword%' OR 
                                username LIKE '%$keyword%' OR 
                                email LIKE '%$keyword%'");
$jumlah_akun = mysqli_num_rows($query_akun);

// Total kecocokan global
$total_kecocokan = $jumlah_akun;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Hasil Pencarian Global</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Pencarian</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Alert Hasil Pencarian -->
      <div class="alert alert-info d-flex justify-content-between align-items-center">
        <span><i class="fas fa-search mr-2"></i> Menampilkan hasil pencarian untuk kata kunci: <strong><?= htmlspecialchars($keyword); ?></strong></span>
        <span class="badge badge-light" style="color: #17a2b8 !important; font-size: 90%;"><?= $total_kecocokan; ?> total kecocokan</span>
      </div>

      <!-- Card Data Akun -->
      <div class="card card-default">
        <div class="card-header border-transparent">
          <h3 class="card-title"><i class="fas fa-users mr-1"></i> Data Akun (<?= $jumlah_akun; ?>)</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table m-0 table-striped table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Level</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($jumlah_akun > 0): ?>
                  <?php $no = 1; while ($akun = mysqli_fetch_assoc($query_akun)): ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= htmlspecialchars($akun['nama']); ?></td>
                      <td><?= htmlspecialchars($akun['username']); ?></td>
                      <td><?= htmlspecialchars($akun['email']); ?></td>
                      <td><span class="badge badge-success"><?= htmlspecialchars($akun['level']); ?></span></td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center text-muted py-4">Data tidak ditemukan dengan kata kunci tersebut.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- 2. FIXED: Trik elemen tersembunyi agar dashboard.js bawaan AdminLTE tidak crash/error di halaman ini -->
<div style="display: none;">
    <div id="sparkline-1"></div>
    <div id="sparkline-2"></div>
    <div id="sparkline-3"></div>
    <div id="world-map"></div>
    <div id="revenue-chart-canvas"></div>
</div>

<?php 
include 'layout/footer.php'; 
?>