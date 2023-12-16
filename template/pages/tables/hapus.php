<?php
// Menghubungkan ke database (ganti dengan informasi koneksi database Anda)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'final';

$connection = mysqli_connect($host, $username, $password, $database);

// Memeriksa koneksi database
if (mysqli_connect_error()) {
    echo "Gagal terhubung ke MySQL: " . mysqli_connect_error();
    exit();
}

// Memeriksa apakah ada parameter ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Menghapus data berdasarkan ID dari database
    $query = "DELETE FROM data WHERE id = '$id'";
    if (mysqli_query($connection, $query)) {
        // Redirect ke halaman sebelumnya setelah penghapusan berhasil
        mysqli_close($connection); // Menutup koneksi database
        header("Location: basic-table.php");
        exit();
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($connection);
    }
} else {
    // Redirect ke halaman sebelumnya jika parameter ID tidak ada
    header("Location: basic-table.php");
    exit();
}

// Menutup koneksi database
mysqli_close($connection);
?>
