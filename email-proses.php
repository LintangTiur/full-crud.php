<?php
use PHPMailer\PHPMailer\PHPMailer;      
use PHPMailer\PHPMailer\Exception;

// Cek apakah benar-benar diakses lewat tombol Kirim
if (isset($_POST['kirim'])) {
    
    // load composer autoloader
    require 'vendor/autoload.php';

    // create object phpmailer
    $email = new PHPMailer(true);
    
    try {
        // Server Settings
        $email->SMTPDebug = 0;
        $email->isSMTP();
        $email->Host = 'smtp.gmail.com';
        $email->SMTPAuth = true;
        
        // KREDENSIAL EMAIL PENGIRIM
        $email->Username = 'rahmantiur94@gmail.com';
        
        // PENTING: Isi dengan 16 digit Sandi
        $email->Password = 'dcyrzxwdehvldssmue'; 
        
        $email->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $email->Port = 465;

        // Recipients
        $email->setFrom('rahmantiur94@gmail.com', 'Lintang Murid Telkom');
        $email->addAddress($_POST['email_penerima']);
        $email->addReplyTo('rahmantiur94@gmail.com', 'Lintang Murid Telkom');   

        // Content
        $email->isHTML(true);
        $email->Subject = $_POST['subject'];
        $email->Body    = nl2br($_POST['pesan']); // Menjaga spasi/enter dari textarea tetap rapi

        $email->send();
        echo "<script>
        alert('Email berhasil dikirimkan!');
        document.location.href = 'email.php';
        </script>";
        
    } catch (Exception $e) {
        // Jika gagal, akan memunculkan pesan eror spesifik dari PHPMailer agar mudah dilacak
        echo "<script>
        alert('Email gagal dikirimkan! Error: {$email->ErrorInfo}');
        document.location.href = 'email.php';
        </script>";
    }
} else {
    // Jika ada yang iseng akses file ini langsung tanpa isi form, kembalikan ke email.php
    header("Location: email.php");
    exit();
}
?>