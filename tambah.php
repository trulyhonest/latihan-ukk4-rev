<?php
session_start();
include 'koneksi.php';

if(isset($_POST['simpan'])){
    $nama=$_POST['nama'];
    $angkatan=$_POST['angkatan'];
    $jurusan=$_POST['jurusan'];
mysqli_query($koneksi, "
    INSERT INTO users (nama, angkatan, jurusan, role) 
    VALUES ('$nama', '$angkatan', '$jurusan', 'user')");
    header("Location: dashboard_" . $_SESSION['role'] . ".php");
    exit; /*header("Location: dashboard_admin.php");*/
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Alumni</title>
    <link rel="stylesheet" href="style/tambah.css">
</head>
<body>

<div class="box">
    <h2>Tambah Data Alumni</h2>

    <form method="POST">
        <input type="text" name="nama" placeholder="Masukan Nama" required>
        
        <input type="number" name="angkatan" placeholder="Masukan Tahun Angkatan" required>

        <select name="jurusan" required>
            <option value="" disabled selected>Pilih Jurusan</option>
            <option>Rekayasa Perangkat Lunak</option>
            <option>Teknik Komputer Dan Jaringan</option>
            <option>Teknik Jaringan Akses Telekomunikasi</option>
            <option>ANIMASI</option>
        </select>

        <div class="button-group">
            <button type="submit" name="simpan" class="btn-save">Simpan</button>
            <a href="dashboard_admin.php" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>

</body>
</html>