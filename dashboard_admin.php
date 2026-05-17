<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="style/dashboard.css">
</head>
<body>

<header>
    <div class="nav-container">
        <h2>Manajemen Data Alumni</h2>

        <div class="profile-wrapper">
            <div class="profile-info">
                <span class="hi-text">Hi, <?= $_SESSION['nama'] ?? 'Truly' ?></span>
                <span class="role-label"><?= ucfirst($_SESSION['role']) ?></span>
            </div>

            <div class="avatar-container" onclick="toggleDropdown()">
                <img src="img/profil.png" alt="Profile" class="avatar-img">

                <div class="profile-dropdown" id="myDropdown">
                    <div class="dropdown-header">
                        <img src="img/profil.png" alt="Large Profile">
                        <a href="edit_foto.php" class="edit-photo-btn">Edit Foto Profil</a>
                    </div>

                    <div class="dropdown-body">
                        <div class="label-status"><b><?= ucfirst($_SESSION['role']) ?></b></div>
                        <div class="user-details">
                            <p class="full-name"><?= $_SESSION['nama_lengkap'] ?? 'User' ?></p>
                            <p class="username">@<?= $_SESSION['username'] ?? 'user' ?></p>
                        </div>
                    </div>

                    <div class="dropdown-footer">
                        <a href="logout.php" class="logout-btn">Logout</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>

<script>
function toggleDropdown() {
    document.getElementById("myDropdown").classList.toggle("show");
}

window.onclick = function(event) {
  if (!event.target.closest('.avatar-container')) {
    document.getElementById("myDropdown").classList.remove("show");
  }
}
</script>

<div class="container">
    <div class="card">

        <div class="card-header">
            <h3>Data Alumni</h3>

            <div class="action-bar">
                <form method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Cari nama / jurusan..." 
                           value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                    <button type="submit">Cari</button>
                </form>

                <a class="tambah" href="tambah.php">+ Tambah Data</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Angkatan</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php
            $no = 1;
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            if($search != ''){
                $data = mysqli_query($koneksi, "
                    SELECT * FROM users 
                    WHERE role='user'
                    AND (nama LIKE '%$search%' OR jurusan LIKE '%$search%' OR angkatan LIKE '%$search%')
                    ORDER BY created_at DESC
                ");
            } else {
                $data = mysqli_query($koneksi, "
                    SELECT * FROM users 
                    WHERE role='user'
                    ORDER BY created_at DESC
                ");
            }

            $now = time();

            while($d = mysqli_fetch_array($data)){

                $baru = ($now - strtotime($d['created_at']) <= 86400);
            ?>
                <tr>
                    <td><?= $no++ ?></td>

                    <td>
                        <?= $d['nama'] ?>
                        <?php if($baru): ?>
                            <span class="badge-baru">(Baru)</span>
                        <?php endif; ?>
                    </td>

                    <td><?= $d['angkatan'] ?></td>
                    <td><?= $d['jurusan'] ?></td>

                    <td>
                        <a class="edit" href="edit.php?id=<?= $d['user_id'] ?>">Edit</a>
                        <a class="hapus" href="delete.php?id=<?= $d['user_id'] ?>" onclick="return confirm('Hapus data?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>

    </div>
</div>

<footer>
    &copy; <?= date('Y') ?> Truly Honesty Falah Sahda - All Rights Reserved
</footer>

</body>
</html>