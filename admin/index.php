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
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
        }
        .card img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            height: 250px; /* Menetapkan tinggi gambar */
            object-fit: cover; /* Memastikan gambar sesuai dengan container */
        }
        .card-body {
            padding: 15px;
        }
        .card-title {
            font-weight: bold;
        }
        .card-text {
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
                <a href="data_user.php" class="nav-link">Data User</a>
            </div>
            <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1">Keluar</a>
        </div>
    </div>
</nav>

<div class="container mt-2">
    <div class="row">
        <?php
        $query = mysqli_query($koneksi, 'SELECT * FROM foto INNER JOIN user ON foto.userid=user.userid INNER JOIN album ON foto.albumid=album.albumid');
while ($data = mysqli_fetch_array($query)) {
    ?>
        <div class="col-md-3">
            <div class="card mb-2">
                <img src="../assets/img/<?php echo $data['lokasifile']; ?>" class="card-img-top" style="height: 200px;" title="../assets/img/<?php echo $data['judulfoto']; ?>">
                <div class="card-footer text-center">
                <?php
                $fotoid = $data['fotoid'];
                $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                if (mysqli_num_rows($ceksuka) == 1) { ?>
    <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid']; ?>" 
    type="submit" name="batalsuka"><i class="fa fa-heart"></i></a>
    <?php } else { ?>
      <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid']; ?>" 
    type="submit" name="suka"><i class="fa-regular fa-heart" ></i></a>
    <?php }
    $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='".$data['fotoid']."'");

                echo mysqli_num_rows($like).' Suka';
                ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#Komentar<?php echo $data['fotoid']; ?>"><i class="fa-regular fa-comment"></i></a>
                    <?php
    $jlmkomen = mysqli_query($koneksi, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
    echo mysqli_num_rows($jlmkomen).' Komentar';
    ?>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="Komentar<?php echo $data['fotoid']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <img src="../assets/img/<?php echo $data['lokasifile']; ?>" class="card-img-top" title="../assets/img/<?php echo $data['judulfoto']; ?>">
                            </div>
                            <div class="col-md-4">
                                <div class="mt-2">
                                    <div class="overflow-auto">
                                        <div class="sticky-top">
                                            <strong><?php echo $data['judulfoto']; ?> </strong><br>
                                            <span class="badge bg-secondary"><?php echo $data['NamaLengkap']; ?></span>
                                            <span class="badge bg-secondary"><?php echo $data['tanggalunggah']; ?></span>
                                            <span class="badge bg-primary"><?php echo $data['NamaAlbum']; ?></span>
                                        </div>
                                        <hr>
                                        <p align="left">
                                            <?php echo $data['deskripsifoto']; ?>
                                        </p>
                                        <hr>
                                        <?php
                        $FotoID = $data['fotoid'];
    $komentar = mysqli_query($koneksi, "SELECT * FROM komentarfoto INNER JOIN user ON komentarfoto.userid=user.userid WHERE komentarfoto.fotoid='$FotoID'");
    while ($row = mysqli_fetch_array($komentar)) {
        ?>
                                            <p align="left">
                                                <strong><?php echo $row['NamaLengkap']; ?></strong> <?php echo $row['IsiKomentar']; ?>
                                            </p>
                                        <?php } ?>

                                        <hr>
                                        <div class="sticky-bottom">
                                            <form action="../config/proses_komentar.php" method="POST">
                                                <div class="input-group">
                                                    <input type="hidden" name="fotoid" value="<?php echo $data['fotoid']; ?>">
                                                    <input type="text" name="isikomentar" class="form-control" placeholder="Tambah Komentar">
                                                    <div class="input-group-prepend">
                                                        <button type="submit" name="kirimkomentar" class="btn btn-outline-primary">Kirim</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
    <p>&copy; Website Galeri Foto </p>
</footer>

<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
