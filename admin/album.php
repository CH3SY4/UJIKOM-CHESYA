<?php
session_start();
include '../config/koneksi.php';
if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('anda belum login');
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
            <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1" onclick="return confirm('Apakah Anda yakin ingin keluar?')">Keluar</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card mt-2">
                <div class="card-header">Tambah Album</div>
                <div class="card-body">
                    <form action="../config/aksi_album.php" method="POST">
                        <label class="form-label">Nama Album</label>
                        <input type="text" name="namaalbum" class="form-control" required>
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" required></textarea>
                        <button type="submit" class="btn btn-primary mt-2" name="tambah">Tambah Data</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mt-2">
                <div class="card-header">Data Album</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Album</th>
                                <th>Deskripsi</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tbody>
    <?php
    $no = 1;
$userid = $_SESSION['UserID'];
$sql = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid'");
while ($data = mysqli_fetch_array($sql)) {
    ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['NamaAlbum']; ?></td>
            <td><?php echo $data['Deskripsi']; ?></td>
            <td><?php echo $data['TanggalDibuat']; ?></td>
            <td>
            <form action="../config/aksi_album.php" method="POST" style="display: inline;">
    <input type="hidden" name="AlbumID" value="<?php echo $data['AlbumID']; ?>">
    <!-- Tambahkan input untuk memperbarui nama album -->
    <input type="text" name="namaalbum_edit" value="<?php echo $data['NamaAlbum']; ?>" class="form-control" required>
    <!-- Tambahkan input untuk memperbarui deskripsi -->
    <textarea name="deskripsi_edit" class="form-control" required><?php echo $data['Deskripsi']; ?></textarea>
    <!-- Tombol untuk submit form edit -->
    <button type="submit" class="btn btn-primary" name="edit">Edit</button>
</form>


                <form action="../config/aksi_album.php" method="POST" style="display: inline;">
                    <input type="hidden" name="AlbumID" value="<?php echo $data['AlbumID']; ?>">
                    <button type="submit" class="btn btn-danger" name="hapus" onclick="return confirm('Apakah Anda yakin akan menghapus album ini?')">Hapus</button>
                </form>
            </td>
        </tr>
    <?php } ?>
</tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
    <p>&copy; Website Galeri Foto </p>
</footer>

<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
