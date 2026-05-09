<?php
$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "user_system";

// Membuat koneksi ke database saya, saya menggunakan database default dari bawaan dengan username root
$koneksi = mysqli_connect($host, $username, $password, $database);

// Pengecekan koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>