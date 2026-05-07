<?php
$host = "localhost";
$username = "root"; // username default XAMPP
$password = ""; // password default XAMPP (kosong)
$database = "user_system";

// Membuat koneksi
$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

echo "Koneksi berhasil"; 
?>