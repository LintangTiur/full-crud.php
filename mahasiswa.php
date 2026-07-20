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

// KODE TAMBAHAN: AMBIL DATA UNTUK GRAFIK LINE
$query_grafik = mysqli_query($db, "SELECT prodi, 
    SUM(CASE WHEN jk = 'Laki-laki' THEN 1 ELSE 0 END) AS total_lakilaki,
    SUM(CASE WHEN jk = 'Perempuan' THEN 1 ELSE 0 END) AS total_perempuan 
    FROM mahasiswa GROUP BY prodi");

$prodi_labels = [];
$data_laki = [];
$data_perempuan = [];

while ($row = mysqli_fetch_assoc($query_grafik)) {
    $prodi_labels[] = $row['prodi'];
    $data_laki[]   = (int)$row['total_lakilaki'];
    $data_perempuan[] = (int)$row['total_perempuan'];
}
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
            

            <!-- KODE TAMBAHAN: CARD UNTUK TAMPILAN GRAFIK LINE -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line"></i> Grafik Mahasiswa
                    </h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="grafikMahasiswa" style="min-height: 280px; height: 280px; max-height: 280px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>

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
                        <table id="serverside" class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Prodi</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Telepon</th>
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
                                        <!-- tombol -->
                                        <td width="20%" class="text-center">
                                        <a href="detail-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i> Detail</a>
                                        <a href="ubah-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Ubah</a>
                                        <a href="hapus-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Data Mahasiswa Akan Dihapus.?');"><i class="fas fa-trash-alt"></i> Hapus</a>
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


<!-- KODE TAMBAHAN: INISIALISASI PLUG-IN CHART.JS LINE -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('grafikMahasiswa').getContext('2d');
    
    new Chart(ctx, {
        type: 'line', 
        data: {
            labels: <?= json_encode($prodi_labels); ?>,
            datasets: [
                {
                    label: 'Laki-laki',
                    data: <?= json_encode($data_laki); ?>,
                    borderColor: '#007bff',
                    backgroundColor: '#007bff',
                    fill: false,
                    tension: 0.2
                },
                {
                    label: 'Perempuan',
                    data: <?= json_encode($data_perempuan); ?>,
                    borderColor: '#fd7e14',
                    backgroundColor: '#fd7e14',
                    fill: false,
                    tension: 0.2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                // FIXED: Struktur skala khusus Chart.js bawaan AdminLTE 3
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1, // Memaksa lompatan angka bulat
                        precision: 0 // Menghilangkan desimal belakangan
                    }
                }]
            }
        }
    });
});
</script>

<?php include 'layout/footer.php' ?>