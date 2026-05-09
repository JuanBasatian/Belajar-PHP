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
        
        // Verifikasi kata sandi
        if (password_verify($kata_sandi, $data_pengguna['password'])) {
            $_SESSION['nama_pengguna'] = $nama_pengguna;
            $_SESSION['status_masuk'] = true;
            header("Location: beranda.php");
            exit();
        } else {
            $pesan = "Password salah!";
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
    <title>Halaman Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        .pesan {
            text-align: center;
        }
        
        
        .profile {
            position: fixed;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 8px 15px;
            border-radius: 50px;
            z-index: 100;
        }
        
        .profile-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #4CAF50;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .profile-name {
            color: white;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    
    <div class="profile">
        <div class="profile-img">
            <img src="Gambar.jpeg" alt="Profile">
        </div>
        <span class="profile-name">Juan Bastian Mambraku / 245314030</span>
    </div>
    
    <h1>Halaman Login</h1>
    
    <?php if (isset($pesan)): ?>
        <p class="pesan" style="color: <?php echo ($warna_pesan == 'merah') ? 'red' : 'green'; ?>;"><?php echo $pesan; ?></p>
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
                <td colspan="2" style="text-align: center;">
                    <input type="submit" value="Masuk">
                </td>
            </tr>
        </table>
    </form>
    
    <div class="link-login">
        Belum punya akun? <a href="registrasi.php">Daftar disini</a>
    </div>
</body>
</html>