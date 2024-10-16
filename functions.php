<?php

function getDbConnection() {
    $db = new SQLite3("db_whislist.db");
    if (!$db) {
        die($db->lastErrorMsg());
    }
    return $db;
}

function getAllDestinations() {
    $db = getDbConnection();
    $result = $db->query("SELECT * FROM whislist");
    $destinations = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $destinations[] = $row;
    }
    return $destinations;
}

function addDestination($tempat_wisata, $deskripsi) {
    $db = getDbConnection();
    $gambar = '';

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['gambar']['tmp_name'];
        $fileName = $_FILES['gambar']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
    
        $allowedfileExtensions = array('jpg', 'png', 'jpeg');
    
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = './uploads/';
            
            // Menggunakan nama file asli
            $newFileName = $fileName;
            $dest_path = $uploadFileDir . $newFileName;
    
            // Menangani duplikat dengan menambahkan angka
            $count = 1;
            while (file_exists($dest_path)) {
                // Mengambil nama tanpa ekstensi
                $fileNameWithoutExt = basename($fileName, '.' . $fileExtension);
                // Mengatur nama file baru dengan menambahkan nomor
                $newFileName = $fileNameWithoutExt . "_" . $count . '.' . $fileExtension;
                $dest_path = $uploadFileDir . $newFileName;
                $count++;
            }
    
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $gambar = $newFileName; // Set nama file gambar yang akan disimpan ke database
            }
        }
    }
    


    $stmt = $db->prepare("INSERT INTO whislist (tempat_wisata, deskripsi, gambar) VALUES (:tempat_wisata, :deskripsi, :gambar)");
    $stmt->bindValue(':tempat_wisata', $tempat_wisata, SQLITE3_TEXT);
    $stmt->bindValue(':deskripsi', $deskripsi, SQLITE3_TEXT);
    $stmt->bindValue(':gambar', $gambar, SQLITE3_TEXT); // Simpan nama file gambar
    return $stmt->execute();
}

function getDestinationById($id) {
    $db = getDbConnection();
    return $db->querySingle("SELECT * FROM whislist WHERE id = $id", true);
}

function updateDestination($id, $tempat_wisata, $deskripsi) {
    $db = getDbConnection();
    $gambar = getDestinationById($id)['gambar']; // Ambil gambar yang sudah ada

    // Cek apakah file gambar baru diupload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['gambar']['tmp_name'];
        $fileName = $_FILES['gambar']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'png', 'jpeg');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = './uploads/';
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Hapus gambar lama
                if ($gambar && file_exists('./uploads/' . $gambar)) {
                    unlink('./uploads/' . $gambar);
                }
                $gambar = $newFileName; // Set gambar baru
            }
        }
    }

    $stmt = $db->prepare("UPDATE whislist SET tempat_wisata = :tempat_wisata, deskripsi = :deskripsi, gambar = :gambar WHERE id = :id");
    $stmt->bindValue(':tempat_wisata', $tempat_wisata, SQLITE3_TEXT);
    $stmt->bindValue(':deskripsi', $deskripsi, SQLITE3_TEXT);
    $stmt->bindValue(':gambar', $gambar, SQLITE3_TEXT); // Simpan nama file gambar
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    return $stmt->execute();
}

function deleteDestination($id) {
    $db = getDbConnection();
    $gambar = getDestinationById($id)['gambar'];

    // Hapus gambar dari folder jika ada
    if ($gambar && file_exists('./uploads/' . $gambar)) {
        unlink('./uploads/' . $gambar);
    }

    return $db->exec("DELETE FROM whislist WHERE id = $id");
}
?>
