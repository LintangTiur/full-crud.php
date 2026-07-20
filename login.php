<?php

session_start();
//password sementara
//echo password_hash("admin", PASSWORD_DEFAULT); die(); 

include 'config/app.php';

//cek apakah tombol login ditekan
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    //cek username
    $result = mysqli_query($db, "SELECT * FROM akun WHERE username = '$username'");

    //jika ada user
    if (mysqli_num_rows($result) == 1) {
        //check passwordnya
        $hasil = mysqli_fetch_assoc($result);

        // SET SESSION (Tanda titik koma keliru setelah IF sudah dihapus agar password wajib benar)
        if (password_verify($password, $hasil['password'])) {
            $_SESSION['login']    = true;
            $_SESSION['id_akun']  = $hasil['id_akun'];
            $_SESSION['nama']     = $hasil['nama'];
            $_SESSION['username'] = $hasil['username'];
            $_SESSION['email']    = $hasil['email'];
            $_SESSION['level']    = $hasil['level'];

            //jika sudah benar arahkan ke index.php
            header("Location: index.php");
            exit;
        }
    }
    //jika tidak ada user/login salah
    $error = true;
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login · AdminLTE Style</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- Font Awesome CDN untuk Ikon Username & Password -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
      body {
        background-color: #ebedef;
        font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      }
      .login-box {
        width: 100%;
        max-width: 420px;
        margin: 7% auto;
      }
      .login-logo {
        font-size: 2.1rem;
        font-weight: 300;
        margin-bottom: .9rem;
        text-align: center;
      }
      .login-logo b {
        font-weight: 700;
      }
      .login-logo a {
        color: #495057;
        text-decoration: none;
      }
      .input-group-text {
        background-color: transparent;
        border-left: none;
        color: #777;
      }
      .form-control:focus + .input-group-text {
        border-color: #86b7fe;
      }
      .form-control {
        border-right: none;
      }
      .form-control:focus {
        box-shadow: none;
      }
    </style>
  </head>
  <body>
    
<div class="container d-flex align-items-center justify-content-center">
  <div class="login-box">
    
    <!-- Logo Aplikasi atas Card -->
    <div class="login-logo">
      <a href="#"><b>Admin</b>LTE</a>
    </div>

    <!-- Card Login Box -->
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4">
        <p class="text-center text-muted mb-4 small">Masukan username dan password</p>

        <!-- Notifikasi Error jika gagal login -->
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger py-2 mb-3 small text-center">
                <i class="fas fa-exclamation-triangle mr-1"></i> <b>Username atau Password salah</b>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
          
          <!-- Input Username dengan Ikon -->
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username..." required autocomplete="off">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
          </div>
          
          <!-- Input Password dengan Ikon -->
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password..." required>
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
          </div>

          <!-- Google reCAPTCHA -->
          <div class="mb-3 d-flex justify-content-center">
            <div class="g-recaptcha" data-sitekey="6LcOdVYtAAAAALFOsjXcOivy9a4SiWkZ-WERZ2dt"></div>
          </div>

          <!-- Baris Tombol Submit (Masuk ke Kanan) -->
          <div class="row justify-content-end align-items-center mt-4">
            <div class="col-4 text-end">
              <button class="btn btn-primary px-4 fw-normal" type="submit" name="login">Masuk</button>
            </div>
          </div>
          
          <!-- Footer Hak Cipta di dalam Card -->
          <div class="text-center mt-4 pt-3 border-top text-muted small">
             Developer &copy; <a href="#" class="text-decoration-none">Muba Teknologi</a> 2026
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

    <!-- Script Google reCAPTCHA (Typo tanda titik di kode sebelumnya sudah dibersihkan) -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>