<?php
session_start();

// Cek apakah sudah masuk
if (!isset($_SESSION['status_masuk']) || $_SESSION['status_masuk'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Beranda</title>  
</head>
<body>
    <h1>Selamat Datang, <?php echo $_SESSION['nama_pengguna']; ?>!</h1>
    <p>Anda berhasil masuk.</p>
    <a href="keluar.php">Keluar</a>
</body>
</html>