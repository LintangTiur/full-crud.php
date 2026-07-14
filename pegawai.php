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

$title = "Daftar pegawai";
include 'layout/header.php';
?>

<!-- PERBAIKAN STRUKTUR: Menggunakan standar layout AdminLTE 3 -->
<div class="content-wrapper">
    <!-- Content Header (Judul Halaman) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-list-ul"></i> Data Pegawai
                    </h1>
                </div>
            </div>
        </div>
    </div>

<!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Cukup gunakan SATU Card AdminLTE agar rapi -->
            <div class="card">
                <div class="card-header">
                   <h3 class="card-title">Tabel Data Pegawai</h3>
                </div>
                
                <div class="card-body">
                    <!-- Dibungkus table-responsive agar tabel aman di layar HP/Kecil -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover m-0">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <!-- Jangan lupa ID ini untuk target AJAX kamu nanti -->
                            <tbody id="live_data">
                                <!-- Data akan di-load di sini via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- /.card (Satu penutup card yang bersih) -->

        </div>
    </section>
</div> <!-- Penutup content-wrapper -->

<script>
    $(document).ready(function() {
        setInterval(function() {
            getPegawai()
        }, 3000) //request 3 detik
    });

    function getPegawai()
    {
        $.ajax({
            url: "realtime-pegawai.php",
            type: "GET",
            success: function(response) {
                $('#live_data').html(response)
            }
        });
    }
</script>

<?php include 'layout/footer.php' ?>