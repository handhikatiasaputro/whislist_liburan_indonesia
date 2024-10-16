<?php

$db = new SQLite3("db_whislist.db");

    if(!$db) {
        echo $db->lastErrorMsg();
      } else {
        // echo "Open database success...\n";
      } 


$db->query("CREATE TABLE IF NOT EXISTS whislist(
id INTEGER PRIMARY KEY AUTOINCREMENT,
tempat_wisata TEXT NOT NULL,
deskripsi TEXT NOT NULL,
gambar TEXT
)");