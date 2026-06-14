<?php
// 2572056 - Alifi Duta Sangjaya
$host = "localhost";
$user = "root";
$pass = "";
$db   = "perpustakaan";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die(json_encode(["status" => "error", "message" => "Koneksi gagal"]));
}
?>