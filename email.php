<?php
session_start();

// Proteksi halaman: Hapus/komentari jika belum membuat sistem login
if (!isset($_SESSION['login'])){
    echo "<script>
    alert('Login dulu dong');
    document.location.href = 'login.php';
    </script>";
    exit();
}

$title = "Kirim Email";
include 'layout/header.php';
?>

<!-- Content Wrapper. Area utama konten AdminLTE -->
<div class="content-wrapper">
    
    <!-- Header Halaman (Bagian Judul & Navigasi Kanan) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-envelope mr-2"></i>Kirim Email</h1>
                </div>
                <div class="col-sm-6">
                    <span class="float-sm-right text-muted" style="font-size: 14px;">Kirim Email</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Konten Utama Form -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Kotak Putih Polos Lebar Penuh -->
            <div class="card">
                <div class="card-body">
                    
                    <!-- PERBAIKAN: action diarahkan ke proses-email.php -->
                    <form action="email-proses.php" method="post">
                        
                        <!-- 1. Email Penerima -->
                        <div class="form-group mb-3">
                            <label for="email_penerima">Email Penerima</label>
                            <input type="email" class="form-control" name="email_penerima" id="email_penerima" placeholder="Email penerima..." required>
                        </div>

                        <!-- 2. Subject -->
                        <div class="form-group mb-3">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject..." required>
                        </div>

                        <!-- 3. Pesan (Menggunakan Textarea tinggi kosong) -->
                        <div class="form-group mb-3">
                            <label for="pesan">Pesan</label>
                            <textarea class="form-control" name="pesan" id="pesan" rows="8" placeholder="Tulis pesan anda di sini..." required></textarea>
                        </div>

                        <!-- Tombol Kirim Biru di Kanan Bawah -->
                        <div class="clearfix">
                            <!-- PERBAIKAN: name diganti menjadi 'kirim' agar singkron dengan proses-email.php -->
                            <button type="submit" name="kirim" class="btn btn-primary float-right" style="padding: 6px 20px;">Kirim</button>
                        </div>
                        
                    </form>

                </div>
            </div> <!-- /.card -->

        </div>
    </section>
</div>

<?php include 'layout/footer.php'; ?>