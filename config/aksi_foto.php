<?php
session_start();
include '../config/koneksi.php';

if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum login');
    window.location.href='../index.php';
    </script>";
}

if(isset($_POST['tambah'])) {
    $judulfoto = $_POST['judulfoto'];
    $deskripsifoto = $_POST['deskripsifoto'];
    $AlbumID = $_POST['AlbumID'];

    $lokasi_file = $_FILES['lokasifile']['tmp_name'];
    $nama_file = $_FILES['lokasifile']['name'];
    $direktori = "../assets/img/$nama_file";

    if(move_uploaded_file($lokasi_file, $direktori)) {
        $query = "INSERT INTO foto (judulfoto, deskripsifoto, AlbumID, lokasifile, tanggalunggah, userid) VALUES ('$judulfoto', '$deskripsifoto', '$AlbumID', '$nama_file', NOW(), '{$_SESSION['UserID']}')"; // Perbaikan: gunakan UserID
        
        if(mysqli_query($koneksi, $query)) {
            echo "<script>
            alert('Data foto berhasil ditambahkan');
            window.location.href='../admin/foto.php';
            </script>";
        } else {
            echo "<script>
            alert('Gagal menambahkan data foto');
            window.location.href='../admin/foto.php';
            </script>";
        }
    } else {
        echo "<script>
        alert('Gagal mengunggah file foto');
        window.location.href='../admin/foto.php';
        </script>";
    }  
}

if (isset($_POST['edit'])) {
    // Mengambil data dari form
    $FotoID = $_POST['fotoid'];
    $judulfoto = $_POST['judulfoto'];
    $deskripsifoto = $_POST['deskripsifoto'];
    $tanggalunggah = date('Y-m-d');
    $AlbumID = $_POST['AlbumID'];
    $userid = $_SESSION['UserID'];
    $foto = $_FILES['lokasifile']['name'];
    $tmp = $_FILES['lokasifile']['tmp_name'];
    $lokasi = '../assets/img/';
    $namafoto = rand().'-'.$foto;

    // Memeriksa apakah ada pengiriman file baru
    if ($foto == null) {
        // Jika tidak ada file yang dikirimkan, update data tanpa mengubah gambar
        $sql = mysqli_query($koneksi, "UPDATE foto SET judulfoto='$judulfoto', deskripsifoto='$deskripsifoto', tanggalunggah='$tanggalunggah', albumid='$AlbumID' WHERE fotoid='$FotoID'");
    } else {
        // Jika ada file yang dikirimkan, update data termasuk penggantian gambar
        $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE fotoid='$FotoID'");
        $data = mysqli_fetch_array($query);
        if (is_file('../assets/img/'.$data['lokasifile'])) {
            unlink('../assets/img/'.$data['lokasifile']);
        }
        move_uploaded_file($tmp, $lokasi.$namafoto);
        // Perbaikan query: menghapus tanda kutip yang tidak perlu pada deskripsifoto
        $sql = mysqli_query($koneksi, "UPDATE foto SET judulfoto='$judulfoto', deskripsifoto='$deskripsifoto', tanggalunggah='$tanggalunggah', lokasifile='$namafoto', albumid='$AlbumID' WHERE fotoid='$FotoID'");
    }
    if ($sql) {
        echo "<script>
        alert('Data berhasil diperbaharui');
        window.location.href='../admin/foto.php';
        </script>";
    } else {
        echo "<script>
        alert('Gagal memperbarui data');
        window.location.href='../admin/foto.php';
        </script>";
    }
}

if (isset($_POST['hapus'])) {
    $FotoID = $_POST['fotoid'];
    $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE fotoid='$FotoID'");
    $data = mysqli_fetch_array($query);
    if (is_file('../assets/img/'.$data['lokasifile'])) {
        unlink('../assets/img/'.$data['lokasifile']);
    }
    $sql = mysqli_query($koneksi, "DELETE FROM foto WHERE fotoid='$FotoID'");
    echo "<script>
    alert('Data berhasil dihapus');
    window.location.href='../admin/foto.php';
    </script>";
}
?>
