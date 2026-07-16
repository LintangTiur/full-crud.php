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

    if (isset($_POST['filter'])) {
        $tgl_awal = strip_tags($_POST['tgl_awal'] . " 00:00:00");
        $tgl_akhir = strip_tags($_POST['tgl_akhir'] . " 23:59:59");

        // query filter data
        $data_barang = select("SELECT * FROM barang WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id_barang DESC");
    } else {
        // query tampil seluruh data
        $jumlahDataPerhalaman = 1;
        $jumlahData           = count(select("SELECT * FROM barang"));
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
                <!-- small box -->
                <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>

                    <p>New Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>

                    <p>Bounce Rate</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                <div class="inner">
                    <h3>44</h3>

                    <p>User Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>

                    <p>Unique Visitors</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            </div>
            <!-- /.row -->
            
            <!-- Area Tabel Data Barang -->
            <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Barang</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <a href="tambah-barang.php" class="btn btn-primary mb-1"><i class="fas fa-plus"></i> Tambah Barang</a>

                    <button type="button" class="btn btn-success btn-sm mb-2" data-toggle="modal" data-target="#modalFilter">
                        <i class="fas fa-search"></i> Filter Data
                    </button>  

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
                            <?php $no = 1; ?>
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
                                    <a href="ubah-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-primary">Ubah</a>
                                    <a href="hapus-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-danger"
                                    onclick="return confirm('Yakin ingin menghapus barang?');">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

                <!-- KODE PAGINATION DI SINI -->
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

                    <!-- Footer Modal di dalam Form agar tombol submit berfungsi -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success btn-sm" name="filter">Submit</button>
                    </div>
                </form>
            </div> <!-- Penutup modal-body -->
            
        </div> <!-- Penutup modal-content -->
    </div> <!-- Penutup modal-dialog -->
</div> <!-- Penutup modal utama -->

<?php include 'layout/footer.php'; ?>