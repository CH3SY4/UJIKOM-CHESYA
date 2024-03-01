<?php

session_start();
include 'koneksi.php';

// Validasi input
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Gunakan fungsi hash yang lebih aman, misalnya password_hash()
    $password_hashed = md5($password); // Untuk saat ini, gunakan md5(), tetapi disarankan untuk menggunakan fungsi hash yang lebih aman

    // Query untuk mendapatkan data pengguna
    $sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password_hashed'");

    // Periksa apakah ada baris hasil dari query
    if (mysqli_num_rows($sql) > 0) {
        $data = mysqli_fetch_array($sql);

        $_SESSION['Username'] = $data['Username'];
        $_SESSION['UserID'] = $data['UserID'];
        $_SESSION['role'] = $data['role'];
        $_SESSION['status'] = 'login';

        // Langsung arahkan ke halaman sesuai peran
        if ($data['role'] == 'admin') {
            header('Location: ../admin/index.php');
            exit;
        } elseif ($data['role'] == 'user') {
            header('Location: ../user/index.php');
            exit;
        }
    } else {
        // Jika tidak ada baris hasil dari query, berarti username atau password salah
        echo "<script>
        alert('Username atau password salah');
        location.href='../login.php';
        </script>";
        exit;
    }
} else {
    // Jika tidak semua input terpenuhi
    echo "<script>
    alert('Isi semua kolom');
    location.href='../login.php';
    </script>";
    exit;
}
