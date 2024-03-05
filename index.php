<?php
include 'config/koneksi.php'; // Sesuaikan dengan lokasi file koneksi.php Anda

// Tentukan jumlah foto per halaman
$jumlah_per_halaman = 6;

// Tentukan halaman saat ini
$halaman = isset($_GET['halaman']) ? $_GET['halaman'] : 1;

// Hitung offset berdasarkan halaman saat ini
$offset = ($halaman - 1) * $jumlah_per_halaman;

// Query untuk mengambil data foto dengan batasan jumlah per halaman dan offset
$query = "SELECT * FROM foto INNER JOIN user ON foto.userid=user.userid INNER JOIN album ON foto.albumid=album.albumid LIMIT $offset, $jumlah_per_halaman";
$result = mysqli_query($koneksi, $query);

// Hitung jumlah total foto
$total_foto = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM foto"));

// Hitung jumlah halaman yang dibutuhkan
$jumlah_halaman = ceil($total_foto / $jumlah_per_halaman);

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
            <div class="card mb-2">
            <img src="./assets/img/<?php echo $data['lokasifile']; ?>" class="card-img-top" style="height: 200px;" title="../assets/img/<?php echo $data['judulfoto']; ?>">
            <div class="card-body">
                    <h5 class="card-title"><?php echo $data['judulfoto']; ?></h5>
                    <p class="card-text"><?php echo $data['deskripsifoto']; ?></p>
                    <p class="card-text"><small class="text-muted">Tanggal Upload: <?php echo $data['tanggalunggah']; ?></small></p>
                </div>
        <div class="card-footer text-center">
            <?php
        $fotoid = $data['fotoid'];

    // Definisikan UserID jika pengguna telah login
    $UserID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';

    // Tampilkan tombol suka dan jumlah like hanya jika pengguna sudah login
    if (!empty($_SESSION['UserID'])) {
        $UserID = $_SESSION['UserID'];
        $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$UserID'");
        if (mysqli_num_rows($ceksuka) == 1) { ?>
            <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid']; ?>" type="submit" name="batalsuka"><i class="fa fa-heart"></i></a>
        <?php } else { ?>
            <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid']; ?>" type="submit" name="suka"><i class="fa-regular fa-heart"></i></a>
        <?php }
        $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='".$data['fotoid']."'");
        echo mysqli_num_rows($like).' Suka';
    } else {
        // Jika pengguna adalah guest, tampilkan hanya jumlah like
        $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='".$data['fotoid']."'");
        echo mysqli_num_rows($like).' Suka';
    }
    ?>

            <!-- Tampilkan tombol komentar dan jumlah komentar -->
            <a href="#" data-bs-toggle="modal" data-bs-target="#Komentar<?php echo $data['fotoid']; ?>"><i class="fa-regular fa-comment"></i></a>
            <?php
    $jlmkomen = mysqli_query($koneksi, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
    echo mysqli_num_rows($jlmkomen).' Komentar';
    ?>
        </div>
    </div>
</div>

<!-- Modal Komentar -->
<div class="modal fade" id="Komentar<?php echo $data['fotoid']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Tambahkan class untuk mengatur lebar gambar -->
                        <img src="./assets/img/<?php echo $data['lokasifile']; ?>" class="card-img-top img-fluid" style="max-height: 200px;" title="../assets/img/<?php echo $data['judulfoto']; ?>">
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

                                <!-- Tampilkan komentar -->
                                <?php
                        $komentar = mysqli_query($koneksi, "SELECT * FROM komentarfoto INNER JOIN user ON komentarfoto.userid=user.userid WHERE komentarfoto.fotoid='$fotoid'");
    while ($row = mysqli_fetch_array($komentar)) {
        // Tampilkan komentar hanya jika pengguna adalah guest atau komentar bukan miliknya
        if (empty($UserID) || $row['userid'] !== $UserID) { ?>
                                        <p align="left">
                                            <strong><?php echo $row['NamaLengkap']; ?></strong> <?php echo $row['IsiKomentar']; ?>
                                        </p>
                                    <?php }
        } ?>

                                <hr>

                                <!-- Tampilkan form komentar hanya jika pengguna adalah user yang login -->
                                <?php if (!empty($UserID)) { ?>
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
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
    <p>&copy; Website Galeri Foto</p>
</footer>

<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>
