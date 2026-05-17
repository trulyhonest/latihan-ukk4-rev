<?php
include 'koneksi.php';

if (isset($_POST['register'])) {

    $nama = $_POST['nama'];
    $angkatan = $_POST['angkatan'];
    $jurusan = $_POST['jurusan'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // cek username
    $cek = mysqli_query($koneksi, "SELECT username FROM users WHERE username='$username'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah dipakai!');</script>";
    } else {

        $query = "INSERT INTO users (nama, angkatan, jurusan, username, password, role)
                  VALUES ('$na ma', '$angkatan', '$jurusan', '$username', '$password', 'user')";

        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Register berhasil!'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Register gagal!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style/register.css">
</head>

<body>

<div class="box">
    <img src="img/tel-damni.png" alt="Logo Sekolah" class="logo">
    <form method="POST">

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" placeholder="Masukkan Nama" required>
        </div>

        <div class="form-group">
            <label>Tahun Angkatan</label>
            <input type="number" name="angkatan" placeholder="Masukkan Angkatan" required>
        </div>

        <div class="form-group">
            <label for="jurusan">Jurusan</label>
            <select name="jurusan" id="jurusan" required>
                <option value="" disabled selected>Pilih Jurusan</option>
                <option value="RPL">Rekayasa Perangkat Lunak</option>
                <option value="TKJ">Teknik Komputer Dan Jaringan</option>
                <option value="TJAT">Teknik Jaringan Akses Telekomunikasi</option>
                <option value="ANIMASI">ANIMASI</option>
            </select>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan Username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan Password" required>
        </div>

        <button type="submit" name="register">Daftar</button>

        <p class="login">
            Sudah punya akun? <a href="login.php">Login</a>
        </p>

    </form>
</div>

</body>
</html>