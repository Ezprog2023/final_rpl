<?php
// Membuat koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "final";

$conn = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengecek apakah ada data yang dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data yang dikirim dari form
    $username = $_POST["username"];
    $password = $_POST["password"];
    $loginAs = $_POST["loginAs"];

    // Memeriksa apakah username, password, dan loginAs kosong
    if (empty($username) || empty($password) || empty($loginAs)) {
        echo "<script>alert('Username, password, atau pilihan login tidak boleh kosong.'); window.location.href = 'login.php';</script>";
        exit();
    }

    // Menentukan tabel yang akan diquery berdasarkan loginAs
    $table = ($loginAs == 'admin') ? 'login_admin' : 'login_nasabah';

    // Melakukan query untuk memeriksa login
    $query = "SELECT * FROM $table WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    // Memeriksa hasil query
    if ($result->num_rows == 1) {
        // Jika login berhasil
        // Inisialisasi session
        session_start();

        // Simpan informasi login pengguna dalam session
        $_SESSION["username"] = $username;
        $_SESSION["loginAs"] = $loginAs;

        // Ambil nama pengguna

        $_SESSION["namaPengguna"] = $username;

        // Lanjutkan dengan tindakan sesuai kebutuhan Anda
        if ($loginAs == 'admin') {
            // Redirect ke halaman dashboard admin
            header("Location: ../../index.html");
        } elseif ($loginAs == 'nasabah') {
            // Redirect ke halaman dashboard nasabah
            header("Location: ../../index1.php");
        }
        exit();
    } else {
        // Jika login gagal
        echo "<script>alert('Username atau password salah.'); window.location.href = 'login.php';</script>";
    }
}

// Menutup koneksi ke database
$conn->close();
?>
