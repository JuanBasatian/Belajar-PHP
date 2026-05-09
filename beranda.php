<?php
session_start();
include 'koneksi.php';

// Mengecek apakah sudah login
if (!isset($_SESSION['status_masuk']) || $_SESSION['status_masuk'] !== true) {
    header("Location: login.php");
    exit();
}

// Mengambil id user dari session
$nama_pengguna = $_SESSION['nama_pengguna'];
$ambil_user = "SELECT id FROM users WHERE username = '$nama_pengguna'";
$hasil_user = mysqli_query($koneksi, $ambil_user);
$data_user = mysqli_fetch_assoc($hasil_user);
$user_id = $data_user['id'];

// Proses unutk tambah Tugas
if (isset($_POST['tambah'])) {
    $nama_tugas = $_POST['nama_tugas'];
    if (!empty($nama_tugas)) {
        $query_tambah = "INSERT INTO tugas (user_id, nama_tugas) VALUES ('$user_id', '$nama_tugas')";
        mysqli_query($koneksi, $query_tambah);
    }
    header("Location: beranda.php");
    exit();
}

// Proses Selesai (dengan kondisi mengubah status menjadi selesai seperti dicoret)
if (isset($_GET['selesai'])) {
    $id_tugas = $_GET['selesai'];
    $query_selesai = "UPDATE tugas SET status = 'selesai' WHERE id = '$id_tugas' AND user_id = '$user_id'";
    mysqli_query($koneksi, $query_selesai);
    header("Location: beranda.php");
    exit();
}

// Proses menghapus Tugas
if (isset($_GET['hapus'])) {
    $id_tugas = $_GET['hapus'];
    $query_hapus = "DELETE FROM tugas WHERE id = '$id_tugas' AND user_id = '$user_id'";
    mysqli_query($koneksi, $query_hapus);
    header("Location: beranda.php");
    exit();
}

// Mengambil semua tugas user
$query_tampil = "SELECT * FROM tugas WHERE user_id = '$user_id' ORDER BY tanggal_dibuat DESC";
$hasil_tampil = mysqli_query($koneksi, $query_tampil);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Beranda</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }
        .container {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-tambah {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }
        .form-tambah input {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-tambah button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-tambah button:hover {
            background-color: #0056b3;
        }
        .daftar-tugas {
            list-style: none;
            padding: 0;
        }
        .item-tugas {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        .item-tugas.selesai {
            background-color: #e8f5e9;
            border-left-color: #4caf50;
        }
        .item-tugas.selesai .nama-tugas {
            text-decoration: line-through;
            color: #888;
        }
        .nama-tugas {
            flex: 1;
            font-size: 16px;
        }
        .tombol {
            display: flex;
            gap: 10px;
        }
        .tombol a {
            text-decoration: none;
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 14px;
        }
        .tombol-selesai {
            background-color: #4caf50;
            color: white;
        }
        .tombol-selesai:hover {
            background-color: #45a049;
        }
        .tombol-hapus {
            background-color: #f44336;
            color: white;
        }
        .tombol-hapus:hover {
            background-color: #da190b;
        }
        .logout {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #999;
        }
        .kosong {
            text-align: center;
            color: #999;
            padding: 30px;
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

    <div class="container">
        <h1>Halaman Beranda</h1>
        <p style="text-align: center;">Halo, <strong><?php echo $nama_pengguna; ?></strong></p>
        
        <!-- Halaman untuk Tambah Tugas -->
        <form method="POST" class="form-tambah">
            <input type="text" name="nama_tugas" placeholder="<Teks to do>" required>
            <button type="submit" name="tambah">Tambah</button>
        </form>
        
        <!-- Daftar Tugas -->
        <?php if (mysqli_num_rows($hasil_tampil) > 0): ?>
            <ul class="daftar-tugas">
                <?php while ($tugas = mysqli_fetch_assoc($hasil_tampil)): ?>
                    <li class="item-tugas <?php echo ($tugas['status'] == 'selesai') ? 'selesai' : ''; ?>">
                        <span class="nama-tugas"><?php echo htmlspecialchars($tugas['nama_tugas']); ?></span>
                        <div class="tombol">
                            <?php if ($tugas['status'] == 'pending'): ?>
                                <a href="?selesai=<?php echo $tugas['id']; ?>" class="tombol-selesai" onclick="return confirm('Selesaikan tugas ini?')">Selesai</a>
                            <?php endif; ?>
                            <a href="?hapus=<?php echo $tugas['id']; ?>" class="tombol-hapus" onclick="return confirm('Hapus tugas ini?')">Hapus</a>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <div class="kosong">
                <p>Belum ada tugas. Silakan tambah tugas baru!</p>
            </div>
        <?php endif; ?>
        
        <a href="keluar.php" class="logout">Keluar</a>
    </div>
</body>
</html>