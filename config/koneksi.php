<?php
$host  = "localhost";
$user  = "root";
$pass  = "";
$db    = "logbook_web";

$koneksi  = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi)
    { die ("koneksi ke database gagal: " . mysqli_connect_error()); }

?>