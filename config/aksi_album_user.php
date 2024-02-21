<?php

session_start();
include 'koneksi.php';

if (isset($_POST['tambah'])) {
    $NamaAlbum = $_POST['namaalbum'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = date('Y-m-d');
    $UserID = $_SESSION['UserID'];

    $sql = mysqli_query($koneksi, "INSERT INTO album (NamaAlbum, Deskripsi, TanggalDibuat, UserId) VALUES ('$NamaAlbum', '$deskripsi', '$tanggal', '$UserID')");

    if ($sql) {
        echo "<script>
        alert('Data berhasil disimpan');
        location.href='../user/album.php';
        </script>";
    } else {
        echo "<script>
        alert('Gagal menyimpan data');
        location.href='../user/album.php';
        </script>";
    }
}

if (isset($_POST['edit'])) {
    $AlbumID = $_POST['AlbumID'];
    $NamaAlbum = $_POST['namaalbum_edit']; // Mengambil data dari input nama album yang baru
    $deskripsi = $_POST['deskripsi_edit']; // Mengambil data dari input deskripsi yang baru
    $TanggalDibuat = date('Y-m-d');

    $sql = mysqli_query($koneksi, "UPDATE album SET NamaAlbum='$NamaAlbum', Deskripsi='$deskripsi', TanggalDibuat='$TanggalDibuat' WHERE AlbumID='$AlbumID'");

    if ($sql) {
        echo "<script>
        alert('Data berhasil diperbarui');
        location.href='../user/album.php';
        </script>";
    } else {
        echo "<script>
        alert('Gagal memperbarui data');
        location.href='../user/album.php';
        </script>";
    }
}

if (isset($_POST['hapus'])) {
    $AlbumID = $_POST['AlbumID'];

    $sql = mysqli_query($koneksi, "DELETE FROM album WHERE AlbumID='$AlbumID'");

    if ($sql) {
        echo "<script>
        alert('Data berhasil dihapus');
        location.href='../user/album.php';
        </script>";
    } else {
        echo "<script>
        alert('Gagal menghapus data');
        location.href='../user/album.php';
        </script>";
    }
}
