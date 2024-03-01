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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        /* CSS untuk album Facebook-like */
        .navbar-brand {
            font-size: 1.5rem;
        }
        .navbar-toggler {
            border: none;
        }
        .navbar-nav .btn {
            font-size: 0.9rem;
        }
        .container {
            max-width: 90%; /* Menyesuaikan lebar konten */
        }
        .album {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }
        .album:hover {
            transform: translateY(-10px);
        }
        .album img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            height: 200px; /* Menetapkan tinggi gambar */
            object-fit: cover; /* Memastikan gambar sesuai dengan container */
        }
        .album-body {
            padding: 15px;
        }
        .album-title {
            font-weight: bold;
        }
        .album-text {
            color: #666;
        }
        footer {
            font-size: 0.8rem;
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
            </div>
            <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1">Keluar</a>
        </div>
    </div>
</nav>

<div class="container mt-2">
    <div class="row">
        <?php
        // Menampilkan album yang ada di database
        $query = mysqli_query($koneksi, 'SELECT * FROM album WHERE userid = "'.$userid.'"');
while ($data = mysqli_fetch_array($query)) {
    ?>
            <div class="col-md-4">
                <div class="album">
                    <img src="../assets/img/album-placeholder.jpg" class="card-img-top" alt="Album Image">
                    <div class="album-body">
                        <h5 class="album-title"><?php echo $data['NamaAlbum']; ?></h5>
                        <p class="album-text"><?php echo $data['Deskripsi']; ?></p>
                        <p class="album-text">Tanggal Dibuat: <?php echo $data['TanggalDibuat']; ?></p>
                        <!-- Tambahkan tautan "Lihat Album" untuk melihat album -->
                        <a href="view_album.php?albumid=<?php echo $data['AlbumID']; ?>" class="btn btn-primary">Lihat Album</a>
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
