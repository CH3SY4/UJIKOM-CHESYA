<?php

session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");

$cek = mysqli_num_rows($sql);

if ($cek > 0) {
    $data = mysqli_fetch_array($sql);

    $_SESSION['Username'] = $data['Username'];
    $_SESSION['UserID'] = $data['UserID'];
    $_SESSION['role'] = $data['role'];
    $_SESSION['status'] = 'login';

    if ($data['role'] == 'admin') {
        echo "<script>
        alert('Login berhasil sebagai admin');
        location.href='../admin/index.php';
        </script>";
    } elseif ($data['role'] == 'user') {
        echo "<script>
        alert('Login berhasil sebagai user');
        location.href='../user/index.php';
        </script>";
    }
} else {
    echo "<script>
    alert('username atau password salah');
    location.href='../login.php';
    </script>";
}
