<?php

session_start();
include 'koneksi.php';
$FotoID = $_GET['fotoid'];
$UserID = $_SESSION['UserID'];

$ceksuka = mysqli_query($koneksi, "SELECT likeid FROM likefoto WHERE fotoid='$FotoID' AND userid='$UserID'");

if (mysqli_num_rows($ceksuka) == 1) {
    while ($row = mysqli_fetch_array($ceksuka)) {
        $likeid = $row['likeid'];
        $query = mysqli_query($koneksi, "DELETE FROM likefoto WHERE likeid='$likeid'");
        echo "<script>
        location.href='../admin/index.php';
        </script>";
    }
} else {
    $TanggalLike = date('Y-m-d');
    $query = mysqli_query($koneksi, "INSERT INTO likefoto VALUES('', '$FotoID', '$UserID', '$TanggalLike')");
    echo "<script>
    location.href='../admin/index.php';
    </script>";
}
