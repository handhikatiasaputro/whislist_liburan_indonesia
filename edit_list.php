<?php
require "functions.php";

$id = $_GET['id'];
$result = getDestinationById($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tempat_wisata = $_POST['tempat_wisata'];
    $deskripsi = $_POST['deskripsi'];

    // Update data dengan gambar baru jika ada
    updateDestination($id, $tempat_wisata, $deskripsi);
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
    <title>Edit Tempat Wisata</title>
</head>
<body>
    <div class="container">
        <h1>Edit Tempat Wisata</h1>
        <form method="POST" enctype="multipart/form-data"> <!-- Tambahkan enctype untuk file upload -->
            <label for="tempat_wisata">Tempat Wisata:</label>
            <input type="text" name="tempat_wisata" value="<?php echo $result['tempat_wisata']; ?>" required>
            
            <label for="deskripsi">Deskripsi:</label>
            <textarea name="deskripsi" required><?php echo $result['deskripsi']; ?></textarea>
            
            <label for="gambar">Gambar (pilih jika ingin mengganti):</label>
            <input type="file" name="gambar"> <!-- Ganti input menjadi file upload -->

            <p>Gambar saat ini: <img src="uploads/<?php echo $result['gambar']; ?>" alt="<?php echo $result['tempat_wisata']; ?>" width="150"></p>

            <button type="submit">Update</button>
            <a href="index.php" class="b">Kembali</a>
        </form>
    </div>
</body>
</html>
