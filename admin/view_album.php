<?php
session_start();
include '../config/koneksi.php';

$userid = $_SESSION['UserID'];

if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum login');
    location.href='../index.php';
    </script>";
}

// Mendapatkan ID album dari URL
if (isset($_GET['albumid'])) {
    $albumid = $_GET['albumid'];

    // Ambil detail album dari database
    $query_album = mysqli_query($koneksi, "SELECT * FROM album WHERE AlbumID = '$albumid'");
    $album_data = mysqli_fetch_assoc($query_album);

    // Ambil daftar foto dari album
    $query_foto = mysqli_query($koneksi, "SELECT * FROM foto WHERE AlbumID = '$albumid'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Album</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 90%; /* Menyesuaikan lebar konten */
        }
        .foto {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }
        .foto:hover {
            transform: translateY(-10px);
        }
        .foto img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            height: 200px; /* Menetapkan tinggi gambar */
            object-fit: cover; /* Memastikan gambar sesuai dengan container */
        }
        .foto-body {
            padding: 15px;
        }
        .foto-title {
            font-weight: bold;
        }
        .foto-text {
            color: #666;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Website Galeri Foto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
            <div class="navbar-nav me-auto">
                <a href="home.php" class="nav-link">Home</a>
                <a href="album.php" class="nav-link">Album</a>
                <a href="foto.php" class="nav-link">Foto</a>
                <a href="data_user.php" class="nav-link">Data User</a>
            </div>
            <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1">Keluar</a>
        </div>
    </div>
</nav>

<div class="container mt-2">
    <h2><?php echo $album_data['NamaAlbum']; ?></h2>
    <p><?php echo $album_data['Deskripsi']; ?></p>
    <p>Tanggal Dibuat: <?php echo $album_data['TanggalDibuat']; ?></p>
    <div class="row">
        <?php
        // Menampilkan daftar foto dalam album
        while ($foto = mysqli_fetch_array($query_foto)) {
            ?>
            <div class="col-md-4">
                <div class="foto">
                    <img src="../assets/img/<?php echo $foto['lokasifile']; ?>" class="card-img-top" alt="Foto">
                    <div class="foto-body">
                        <h5 class="foto-title"><?php echo $foto['judulfoto']; ?></h5>
                        <p class="foto-text"><?php echo $foto['deskripsifoto']; ?></p>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
    <p>&copy; Website Galeri Foto </p>
</footer>

<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
