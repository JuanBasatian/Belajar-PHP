<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pengguna = $_POST['username'];
    $kata_sandi = $_POST['password'];
    
    // Kata sandi diacak/dikodekan (hashed)
    $kata_sandi_acak = password_hash($kata_sandi, PASSWORD_DEFAULT);
    
    // Mengecek apakah nama pengguna sudah terdaftar
    $cek_data = "SELECT * FROM users WHERE username = '$nama_pengguna'";
    $hasil_cek = mysqli_query($koneksi, $cek_data);
    
    if (mysqli_num_rows($hasil_cek) > 0) {
        $pesan = "Akun sudah terdaftar!";
        $warna_pesan = "merah";
    } else {
        // Simpan ke database
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
</head>
<body>
    <h1>Halaman Registrasi</h1>
    
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
                <td><input type="submit" value="Daftar"></td>
            </tr>
        </table>
    </form>
    
    <p>Sudah punya akun? <a href="login.php">Masuk disini</a></p>
</body>
</html>