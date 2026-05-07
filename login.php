<?php
include 'koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pengguna = $_POST['username'];
    $kata_sandi = $_POST['password'];
    
    // Cari pengguna di database
    $cari_pengguna = "SELECT * FROM users WHERE username = '$nama_pengguna'";
    $hasil_cari = mysqli_query($koneksi, $cari_pengguna);
    
    if (mysqli_num_rows($hasil_cari) == 1) {
        $data_pengguna = mysqli_fetch_assoc($hasil_cari);
        
        // Verifikasi kata sandi (cocokkan dengan yang sudah diacak)
        if (password_verify($kata_sandi, $data_pengguna['password'])) {
            $_SESSION['nama_pengguna'] = $nama_pengguna;
            $_SESSION['status_masuk'] = true;
            header("Location: beranda.php");
            exit();
        } else {
            $pesan = "Kata sandi salah!";
            $warna_pesan = "merah";
        }
    } else {
        $pesan = "Nama pengguna tidak ditemukan!";
        $warna_pesan = "merah";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Masuk</title>
</head>
<body>
    <h1>Halaman Login</h1> 
    
    <?php if (isset($pesan)): ?>
        <p style="color: <?php echo $warna_pesan; ?>;"><?php echo $pesan; ?></p>
    <?php endif; ?>
    
    <form method="POST" action="">
        <table>
            <tr>
                <td>Nama Pengguna:</td>
                <td><input type="text" name="username" required></td>
            </tr>
            <tr>
                <td>Kata Sandi:</td>
                <td><input type="password" name="password" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Masuk"></td>
            </tr>
        </table>
    </form>
    
    <p>Belum punya akun? <a href="registrasi.php">Daftar disini</a></p>
</body>
</html>