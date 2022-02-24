<?php

// definisikan koneksi ke database
$server = "localhost";
$username = "root";
$password = "!@#$%root#";
$database = "akuntansi";

// Koneksi dan memilih database di server
$koneksi = new \mysqli($server,$username, $password, $database) or die("Koneksi gagal");
//mysql_select_db($database) or die("Database tidak bisa dibuka");

?>
