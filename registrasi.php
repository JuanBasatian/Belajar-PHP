<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pengguna = $_POST['username'];
    $kata_sandi = $_POST['password'];
    
    $kata_sandi_acak = password_hash($kata_sandi, PASSWORD_DEFAULT);
    
    $cek_data = "SELECT * FROM users WHERE username = '$nama_pengguna'";
    $hasil_cek = mysqli_query($koneksi, $cek_data);
    
    if (mysqli_num_rows($hasil_cek) > 0) {
        $pesan = "Akun sudah terdaftar!";
        $warna_pesan = "merah";
    } else {
        $simpan_data = "INSERT INTO users (username, password) VALUES ('$nama_pengguna', '$kata_sandi_acak')";
        
        if (mysqli_query($koneksi, $simpan_data)) {
            $pesan = "Registrasi berhasil! Silahkan masuk.";
            $warna_pesan = "hijau";
        } else {
            $pesan = "Registrasi gagal: " . mysqli_error($koneksi);
            $warna_pesan = "merah";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Registrasi</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
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
        
        .pesan {
            text-align: center;
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
    
    <h1>Halaman Registrasi</h1>
    
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
                    <input type="submit" value="Daftar">
                </td>
            </tr>
        </table>
    </form>
    
    <div class="link-login">
        Sudah punya akun? <a href="login.php">Masuk disini</a>
    </div>
</body>
</html>