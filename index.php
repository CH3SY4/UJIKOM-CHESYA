<?php
include 'config/koneksi.php'; // Sesuaikan dengan lokasi file koneksi.php Anda

// Sisanya tetap sama
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
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
            <div class="navbar-nav ms-auto">
                <a href="registrasi.php" class="btn btn-outline-primary m-1">Daftar</a>
                <a href="login.php" class="btn btn-outline-success m-1">Masuk</a>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <?php
        $query = mysqli_query($koneksi, 'SELECT * FROM foto INNER JOIN user ON foto.userid=user.userid INNER JOIN album ON foto.albumid=album.albumid');
while ($data = mysqli_fetch_array($query)) {
    ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="assets/img/<?php echo $data['lokasifile']; ?>" class="card-img-top" alt="<?php echo $data['judulfoto']; ?>" style="transition: transform 0.3s ease;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $data['judulfoto']; ?></h5>
                    <p class="card-text"><?php echo $data['deskripsifoto']; ?></p>
                    <p class="card-text"><?php echo $data['tanggalunggah']; ?></p>
                </div>
            </div>
        </div>
        <?php
}
?>
    </div>
</div>

<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
    <p>&copy; Website Galeri Foto</p>
</footer>

<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>
