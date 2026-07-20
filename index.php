<?php 
    session_start();

    // membatasi halaman sebelum login
    if (!isset($_SESSION['login'])){
        echo "<script>
        alert('Login dulu dong');
        document.location.href = 'login.php';
        </script>";
        exit;
    }

    // membatasi halaman sesuai user
    if ($_SESSION['level'] != 1 and $_SESSION['level'] != 2){
        echo "<script>
        alert('Perhatian anda tidak punya hak akses!');
        document.location.href = 'crud-modal.php';
        </script>";
        exit;
    }

    $title = "Daftar Barang";
    include 'layout/header.php';

    // === 1. QUERY UNTUK INFO BOX DITULIS DI SINI ===
    $jml_barang  = count(select("SELECT * FROM barang"));
    $jml_mhs     = count(select("SELECT * FROM mahasiswa"));
    $jml_akun    = count(select("SELECT * FROM akun"));

    // Menghitung total stok barang (SUM jumlah)
    $stok_barang = 0;
    $sum_stok    = select("SELECT SUM(jumlah) AS total FROM barang");
    if (!empty($sum_stok) && isset($sum_stok[0]['total'])) {
        $stok_barang = $sum_stok[0]['total'];
    }

    // === 2. QUERY UNTUK DATA GRAFIK (AMBIL SEMUA BARANG) ===
    // Kita buat query terpisah tanpa LIMIT agar grafik menampilkan seluruh item barang
    $barang_grafik = select("SELECT nama, jumlah FROM barang ORDER BY id_barang DESC");
    $array_nama   = [];
    $array_jumlah = [];
    foreach ($barang_grafik as $bg) {
        $array_nama[]   = $bg['nama'];
        $array_jumlah[] = (int)$bg['jumlah'];
    }

    // Logic penanganan filter & pagination bawaan kode kamau
    if (isset($_POST['filter'])) {
        $tgl_awal = strip_tags($_POST['tgl_awal'] . " 00:00:00");
        $tgl_akhir = strip_tags($_POST['tgl_akhir'] . " 23:59:59");

        // query filter data
        $data_barang = select("SELECT * FROM barang WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id_barang DESC");
    } else {
        // query tampil seluruh data dengan pagination
        $jumlahDataPerhalaman = 5; // Ubah ke 5 atau lebih agar data tidak muncul cuma 1 per halaman
        $jumlahData           = $jml_barang;
        $jumlahHalaman        = ceil($jumlahData / $jumlahDataPerhalaman);
        $halamanAktif         = (isset($_GET['halaman']) ?  $_GET['halaman'] : 1);
        $awalData             = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

        $data_barang = select("SELECT * FROM barang ORDER BY id_barang DESC LIMIT $awalData, $jumlahDataPerhalaman");
    }
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box 1: Jumlah Barang -->
                <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $jml_barang; ?></h3>
                    <p>Jumlah Barang</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="index.php" class="small-box-footer">Informasi selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box 2: Stok Barang -->
                <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $stok_barang; ?></h3>
                    <p>Stok Barang</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="index.php" class="small-box-footer">Informasi selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box 3: Jumlah Mahasiswa -->
                <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?= $jml_mhs; ?></h3>
                    <p>Jumlah Mahasiswa</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="mahasiswa.php" class="small-box-footer">Informasi selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box 4: Total Akun -->
                <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?= $jml_akun; ?></h3>
                    <p>Total Akun</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="crud-modal.php" class="small-box-footer">Informasi selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            </div>
            <!-- /.row -->
            
            <!-- === 3. AREA LAYOUT GRAFIK BARU DI SINI === -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card card-white">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-1"></i> Grafik Jumlah Barang
                            </h3>
                        </div>
                        <div class="card-body">
                            <div style="position: relative; height: 320px; width: 100%;">
                                <canvas id="chartBarang"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Area Tabel Data Barang -->
            <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Barang</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <!-- FIXED: Tombol dibungkus div mb-3 agar ada spasi ke tabel -->
                    <div class="mb-3">
                        <a href="tambah-barang.php" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i> Tambah Barang</a>
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalFilter">
                            <i class="fas fa-search mr-1"></i> Filter Data
                        </button>  
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Barcode</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = $awalData + 1; ?>
                            <?php foreach ($data_barang as $barang) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $barang["nama"] ?></td>
                                <td><?= $barang["jumlah"] ?></td>
                                <!-- format rupiah -->
                                <td>Rp<?= number_format($barang["harga"],0,',','.')  ?></td>
                                <!-- barcode -->
                                <td class="text-center">
                                    <img src="barcode.php?codetype=Code128&size=30&text=<?= $barang['barcode']; ?>&print=true" alt="barcode">
                                </td>
                                <!-- format tanggal indonesia -->
                                <td><?= date("d/m/Y | H:i:s", strtotime($barang["tanggal"])); ?></td>
                                <td width="15%" class="text-center">
                                    <a href="ubah-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-primary btn-sm">Ubah</a>
                                    <a href="hapus-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus barang?');">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

                <!-- KODE PAGINATION -->
                <div class="card-footer clearfix">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php if ($halamanAktif > 1) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?halaman=<?= $halamanAktif - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                                <?php if ($i == $halamanAktif) : ?>
                                <li class="page-item active"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
                                <?php else : ?>
                                <li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if ($halamanAktif < $jumlahHalaman) : ?>
                                <li class="page-item">
                                <a class="page-link" href="?halaman=<?= $halamanAktif + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <!-- /.card-footer -->

                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
        </section>
    </div>
    <!-- /.content-wrapper -->
        
<!-- Modal Filter -->
<div class="modal fade" id="modalFilter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Header Modal -->
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-search"></i> Filter Data
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Body Modal + Form -->
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="tgl_awal">Tanggal Awal</label>
                        <input type="date" name="tgl_awal" id="tgl_awal" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="tgl_akhir">Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success btn-sm" name="filter">Submit</button>
                    </div>
                </form>
            </div> 
        </div> 
    </div> 
</div> 

<!-- === 4. INJECT SCRIPT CHART.JS TERBARU DI SINI === -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ambil context element canvas
    const ctx = document.getElementById('chartBarang').getContext('2d');
    
    // Inisialisasi Chart.js Modern
    new Chart(ctx, {
        type: 'bar',
        data: {
            // Encode data dari array PHP ke JSON format JavaScript
            labels: <?php echo json_encode($array_nama); ?>,
            datasets: [{
                label: 'Jumlah Barang',
                data: <?php echo json_encode($array_jumlah); ?>,
                backgroundColor: [
                    '#17a2b8', // cyan
                    '#28a745', // green
                    '#ffc107', // yellow
                    '#dc3545', // red
                    '#6f42c1', // purple
                    '#fd7e14', // orange
                    '#007bff'  // blue
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Skala grafik naik per 1 angka bulat
                    }
                }
            }
        }
    });
</script>

<?php include 'layout/footer.php'; ?>