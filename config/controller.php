<?php

//untuk menampilkan (read)
function select($query)
{
    global $db;

    $result = mysqli_query($db, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

//untuk menambahkan (create)
function create_barang($data)
{
    global $db;

    $nama = $data['nama'];
    $jumlah = $data['jumlah'];
    $harga = $data['harga'];
    $barcode = rand(10000, 999999);

    //query untuk tambah data
    $query = "INSERT INTO barang VALUES ('', '$nama', '$jumlah', '$harga', '$barcode', CURRENT_TIMESTAMP())";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

//untuk mengubah (update)
function update_barang($data, $id_barang)
{
    global $db;

    $nama = $data['nama'];
    $jumlah = $data['jumlah'];
    $harga = $data['harga'];

    $query = "UPDATE barang SET nama = '$nama', jumlah = '$jumlah', harga = '$harga' WHERE id_barang = $id_barang";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

//untuk menghapus (delete)
function delete_barang($id_barang)
{
    global $db;

    //query untuk hapus data
    $query = "DELETE FROM barang WHERE id_barang = $id_barang";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

//menambah data mahasiswa
function create_mahasiswa($data)
{
    global $db;

    // Membersihkan input agar aman dari tag HTML berbahaya
    $nama    = strip_tags($data['nama']);
    $prodi   = strip_tags($data['prodi']);
    $jk      = strip_tags($data['jk']);
    $telepon = strip_tags($data['telepon']);
    $alamat  = strip_tags($data['alamat']); // FIXED: Mengubah $post menjadi $data
    $email   = strip_tags($data['email']);
    
    // Menjalankan fungsi upload file gambar
    $foto    = upload_file();

    // check upload foto
    if (!$foto) {
        return false;
    }

    // FIXED: Membungkus $alamat dengan kutip tunggal ('$alamat') agar sintaks SQL valid
    $query = "INSERT INTO mahasiswa (id_mahasiswa, nama, prodi, jk, telepon, email, foto, alamat) 
              VALUES (null, '$nama', '$prodi', '$jk', '$telepon', '$email', '$foto', '$alamat')";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
} 

// fungsi untuk upload file 
function upload_file()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // cek file yang sudah diupload
    $extensiFileValid = ['jpg', 'jpeg', 'png'];
    $extensiFile = explode('.', $namaFile);
    $extensiFile = strtolower(end($extensiFile));

    // cek extensi file
    if (!in_array($extensiFile, $extensiFileValid)) {
        echo "<script>
                alert('Yang anda upload bukan file gambar!');
                document.location.href = 'tambah-mahasiswa.php';
              </script>";
        die();
    }

    // check ukuran file (Maksimal 2MB)
    if ($ukuranFile > 2048000) {
        echo "<script>
                alert('Ukuran file terlalu besar!');
                document.location.href = 'tambah-mahasiswa.php';
              </script>";
        die();
    }

    // generate nama file baru agar unik dan tidak tabrakan di server
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensiFile;

    // pindahkan file dari tempat penyimpanan sementara ke folder project
    move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);
    
    return $namaFileBaru;
}

//untuk menghapus data mahsiswa
function delete_mahasiswa($id_mahasiswa)
{
    global $db;

    //ambil foto sesuai data yang dipilih
    $foto = select ("SELECT foto FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa")[0]['foto']; unlink('assets/img/' . $foto);

    //query untuk hapus data
    $query = "DELETE FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

//mengubah data mahasiswa
function update_mahasiswa($data)
{
    global $db;

    $id_mahasiswa = strip_tags($data['id_mahasiswa']);
    $nama    = strip_tags($data['nama']);
    $prodi   = strip_tags($data['prodi']);
    $jk      = strip_tags($data['jk']);
    $telepon = strip_tags($data['telepon']);
    $alamat  = strip_tags($data['alamat']); 
    $email   = strip_tags($data['email']);
    $fotoLama   = strip_tags($data['fotoLama']);

    //check upload foto baru atau tidak
    if ($_FILES['foto']['error'] == 4) {
        $foto = $fotoLama;
    } else {
        $foto = upload_file();
    }

    //check upload foto gagal atau tidak
    if (!$foto) {
        return false;
    }

    // PERBAIKAN 2: Menambahkan tanda petik tunggal '$alamat' pada query SQL
    $query = "UPDATE mahasiswa SET 
                nama = '$nama', 
                prodi = '$prodi', 
                jk = '$jk', 
                telepon = '$telepon', 
                alamat = '$alamat', 
                email = '$email', 
                foto = '$foto' 
              WHERE id_mahasiswa = $id_mahasiswa";

    // Mengeksekusi query UPDATE
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

//fungsi tambah akun
function create_akun($data)
{
    global $db;

    $nama     = strip_tags($data['nama']);
    $username = strip_tags($data['username']);
    $email    = strip_tags($data['email']);
    $password = strip_tags($data['password']);
    $level    = strip_tags($data['level']);

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //query untuk tambah data
    $query = "INSERT INTO akun VALUES(null, '$nama', '$username', '$email', '$password', '$level')";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// fungsi menghapus data akun
function delete_akun($id_akun)
{
    global $db;

    // query untuk hapus data akun berdasarkan id
    $query = "DELETE FROM akun WHERE id_akun = $id_akun";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// fungsi mengubah data akun
function update_akun($data)
{
    global $db;

    $id_akun  = strip_tags($data['id_akun']);
    $nama     = strip_tags($data['nama']);
    $username = strip_tags($data['username']);
    $email    = strip_tags($data['email']);
    $password = strip_tags($data['password']);
    $level    = strip_tags($data['level']);

    // enkripsi password baru/lama yang dimasukkan
    $password = password_hash($password, PASSWORD_DEFAULT);

    // query untuk mengubah data akun berdasarkan id_akun
    $query = "UPDATE akun SET 
                nama = '$nama', 
                username = '$username', 
                email = '$email', 
                password = '$password', 
                level = '$level' 
              WHERE id_akun = $id_akun";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}