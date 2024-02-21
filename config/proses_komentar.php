<?php

session_start();
include 'koneksi.php';

if (isset($_POST['kirimkomentar'])) {
    $fotoid = $_POST['fotoid'];
    $isikomentar = $_POST['isikomentar'];
    $UserID = $_SESSION['UserID'];
    $TanggalKomentar = date('Y-m-d');

    $sql = mysqli_query($koneksi, "INSERT INTO komentarfoto (fotoid, userid, isikomentar, tanggalkomentar) VALUES ('$fotoid', '$UserID', '$isikomentar', '$TanggalKomentar')");

    if ($sql) {
        echo "<script>
        alert('Komentar berhasil ditambahkan');
        location.href='../admin/index.php';
        </script>";
    } else {
        echo "<script>
        alert('Terjadi kesalahan, komentar gagal ditambahkan');
        location.href='../admin/index.php';
        </script>";
    }
}
