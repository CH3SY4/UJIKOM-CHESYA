<?php

session_start();
include 'koneksi.php';

if (isset($_POST['kirim'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Disarankan untuk menggunakan metode hash yang lebih aman, seperti bcrypt atau Argon2
    $email = $_POST['email'];
    $namalengkap = $_POST['namalengkap'];
    $alamat = $_POST['alamat'];
    $role = $_POST['role']; // Tangkap nilai peran (role) yang dipilih oleh pengguna

    $query = "INSERT INTO user (username, password, email, namalengkap, alamat, role) VALUES ('$username', '$password', '$email', '$namalengkap', '$alamat', '$role')";

    if (mysqli_query($koneksi, $query)) {
        // Jika pendaftaran berhasil, arahkan pengguna ke halaman login
        echo "<script>
        alert('Pendaftaran berhasil');
        location.href='../login.php';
        </script>";
    } else {
        // Jika terjadi kesalahan saat pendaftaran, tampilkan pesan kesalahan
        echo "<script>
        alert('Terjadi kesalahan saat melakukan pendaftaran');
        location.href='../registrasi.php';
        </script>";
    }
}
