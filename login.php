Be<?php
session_start();
include 'koneksi.php';

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($data);

    if($user){

        // 🔥 KHUSUS ADMIN (tanpa hash)
        if($user['username'] == 'admin' && $password == 'admin'){
            
            $_SESSION['login'] = true;
            $_SESSION['role'] = 'admin';
            header("Location: dashboard_admin.php");
            exit;

        }

        // 🔥 USER (pakai hash)
        if(password_verify($password, $user['password'])){

            $_SESSION['login'] = true;
            $_SESSION['role'] = $user['role'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['angkatan'] = $user['angkatan'];
            $_SESSION['jurusan'] = $user['jurusan'];
            $_SESSION['username'] = $user['username'];

            header("Location: dashboard_user.php");
            exit;

        } else {
            echo  "<script>alert('Password salah!');</script>";
        }

    } else {
        echo "<script>alert('Username tidak ditemukan!');</script>";
    }

}
?>


<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="style/index.css">
</head>

<body>

<div class="box">
    <img src="img/tel-damni.png" alt="Logo Sekolah" class="logo">
    <form method="POST">
    
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Masukkan Username" required>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Masukkan Password" required>
    </div>

    
        <button type="submit" name="login">Masuk</button>

    </form>

    <p class="daftar">
        Belum memiliki akun? <a href="register.php">Daftar Sekarang</a>
    </p>

</div>
</body>
</html>