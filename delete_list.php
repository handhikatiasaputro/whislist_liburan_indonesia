<?php
include 'functions.php';

$id = $_GET['id'];
deleteDestination($id);

header("Location: index.php");
exit();
?>
