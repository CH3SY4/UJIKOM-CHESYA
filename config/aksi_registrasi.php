<?php

include 'koneksi.php';

$username = $_POST['username'];
$password = md5($_POST['password']);
$email = $_POST['email'];
$namalengkap = $_POST['namalengkap'];
$alamat = $_POST['alamat'];

// Query untuk memeriksa apakah username atau email sudah ada dalam database
$check_query = "SELECT * FROM user WHERE username = '$username' OR email = '$email'";
$check_result = mysqli_query($koneksi, $check_query);

// Jika hasil query mengembalikan baris lebih dari 0, artinya username atau email sudah ada
if (mysqli_num_rows($check_result) > 0) {
    echo "<script>
    alert('Username atau email sudah digunakan. Silahkan buat username dan email yang berbeda!');
    location.href='../registrasi.php'; // Redirect kembali ke halaman registrasi
    </script>";
    exit; // Berhenti eksekusi skrip
}

// Jika username dan email belum digunakan, lanjutkan proses pendaftaran
$sql = "INSERT INTO user (Username, Password, Email, NamaLengkap, Alamat) VALUES ('$username', '$password', '$email', '$namalengkap', '$alamat')";

if (mysqli_query($koneksi, $sql)) {
    echo "<script>
    alert('Pendaftaran akun berhasil');
    location.href='../login.php';
    </script>";
} else {
    echo "<script>
    alert('Terjadi kesalahan saat memasukkan data. Silahkan coba lagi.');
    location.href='../registrasi.php';
    </script>";
}

?>
