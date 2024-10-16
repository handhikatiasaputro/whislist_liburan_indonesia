<?php
include 'functions.php';

$destinations = getAllDestinations();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Wishlist Liburan</title>
</head>
<body>
    <div class="container">
        <h1>Wishlist Liburan di Indonesia</h1>
        <a href="add_list.php" class="btn">Tambah Tempat Wisata</a>
        <table>
            <tr>
                <th>Gambar</th>
                <th>Tempat Wisata</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($destinations as $row) { ?>
                <tr>
                    <td>
                        <?php if ($row['gambar']) { ?>
                            <img src="uploads/<?php echo $row['gambar']; ?>" alt="<?php echo $row['tempat_wisata']; ?>" width="100">
                        <?php } else { ?>
                            <p>Tidak ada gambar</p>
                        <?php } ?>
                    </td>
                    <td><?php echo $row['tempat_wisata']; ?></td>
                    <td><?php echo $row['deskripsi']; ?></td>
                    <td class="button-container">
                        <a href="edit_list.php?id=<?php echo $row['id']; ?>" class="edit">Edit</a>
                        <a href="delete_list.php?id=<?php echo $row['id']; ?>"  onclick="return confirm('Kamu Yakin Mau Hapus Ini?')" class="hapus" >Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
