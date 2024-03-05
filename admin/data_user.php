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

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    // Query untuk menghapus user berdasarkan UserID
    $query_delete = "DELETE FROM user WHERE UserID = $id";
    $result_delete = mysqli_query($koneksi, $query_delete);

    if ($result_delete) {
        echo "<script>
        alert('User berhasil dihapus');
        location.href='data_user.php';
        </script>";
    } else {
        echo "<script>
        alert('Gagal menghapus user');
        location.href='data_user.php';
        </script>";
    }
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

<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h3>Data User</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Nama Lengkap</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($koneksi, 'SELECT * FROM user');
$no = 1;
while ($data = mysqli_fetch_array($query)) {
    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['Username']; ?></td>
                            <td><?php echo $data['Email']; ?></td>
                            <td><?php echo $data['Password']; ?></td>
                            <td><?php echo $data['NamaLengkap']; ?></td>
                            <td><?php echo $data['Alamat']; ?></td>
                            <td>
                                <!-- Tambahkan link hapus dengan mengirimkan UserID sebagai parameter -->
                                <a href="?hapus=<?php echo $data['UserID']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php
}
?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
    <p>&copy; Website Galeri Foto </p>
</footer>

<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
