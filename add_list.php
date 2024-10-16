<?php
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tempat_wisata = $_POST['tempat_wisata'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_POST['gambar'];

    addDestination($tempat_wisata, $deskripsi, $gambar);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Tambah Tempat Wisata</title>
</head>
<body>
    <div class="container">
        <h1>Tambah Tempat Wisata</h1>
        <form action="" method="post" enctype="multipart/form-data">
    <label for="tempat_wisata">Tempat Wisata:</label>
    <input type="text" name="tempat_wisata" required>

    <label for="deskripsi">Deskripsi:</label>
    <textarea name="deskripsi" required></textarea>

    <label for="gambar">Upload Gambar:</label>
    <input type="file" name="gambar">

    <button type="submit">Tambah Wishlist</button>
</form>
<a href="index.php" class="b">Kembali</a>

    </div>
</body>
</html>
