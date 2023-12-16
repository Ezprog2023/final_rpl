<?php
// Menghubungkan ke database (ganti dengan informasi koneksi database Anda)
$host = 'localhost';
$usernameDB = 'root';
$passwordDB = '';
$database = 'final';

$connection = mysqli_connect($host, $usernameDB, $passwordDB, $database);

// Memeriksa koneksi database
if (mysqli_connect_errno()) {
    echo "Gagal terhubung ke MySQL: " . mysqli_connect_error();
    exit();
}

// Memeriksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari form
    $namaNasabah = $_POST['nama_nasabah'];
    $noInduk = $_POST['no_induk'];
    $jenisSampah = $_POST['jenis_sampah'];
    $beratSampah = $_POST['berat_sampah'];
    $hargaSampah = $_POST['harga_sampah'];
    $total = $_POST['total'];
    $tgl = $_POST['tgl'];

    // Menyimpan atau mengupdate data di tabel biodata
    $queryBiodata = "INSERT INTO data (nama_nasabah, no_induk, jenis_sampah, berat_sampah, harga_sampah, total, tgl) 
                    VALUES ('$namaNasabah', '$noInduk', '$jenisSampah', '$beratSampah', '$hargaSampah', '$total', '$tgl')";

    if (mysqli_query($connection, $queryBiodata)) {
        // Gunakan nomor induk sebagai password
        $username = $namaNasabah;
        $password = $noInduk;

        // Menyimpan atau mengupdate data di tabel login_nasabah
        $queryLogin = "INSERT IGNORE INTO login_nasabah (username, password) 
                        VALUES ('$username', '$password')";

        if (mysqli_query($connection, $queryLogin)) {
            // Redirect ke halaman baru setelah data berhasil disimpan
            header("Location: basic_elements.php");
            exit();
        } else {
            echo "Terjadi kesalahan saat menyimpan data login: " . mysqli_error($connection);
        }
    } else {
        echo "Terjadi kesalahan saat menyimpan data biodata: " . mysqli_error($connection);
    }
}

// Menutup koneksi database
mysqli_close($connection);
?>
