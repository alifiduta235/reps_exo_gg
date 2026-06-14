<?php
// 2572056 - Alifi Duta Sangjaya
header("Content-Type: application/json");
include 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $query = "SELECT * FROM buku";
    
    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $kolom = mysqli_real_escape_string($conn, $_GET['kolom']);
        $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
        
        if ($kolom === 'semua') {
            $query .= " WHERE judul LIKE '%$keyword%' OR penulis LIKE '%$keyword%' 
                       OR penerbit LIKE '%$keyword%' OR tahun_terbit LIKE '%$keyword%' 
                       OR stok LIKE '%$keyword%'";
        } else {
            $allowed = ['judul', 'penulis', 'penerbit', 'tahun_terbit'];
            if (in_array($kolom, $allowed)) {
                $query .= " WHERE $kolom LIKE '%$keyword%'";
            }
        }
    }
    
    $result = mysqli_query($conn, $query);
    $buku = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $buku[] = $row;
    }
    echo json_encode($buku);
}

if ($method === 'POST') {
    $judul    = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis  = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun    = mysqli_real_escape_string($conn, $_POST['tahun']);
    $stok     = mysqli_real_escape_string($conn, $_POST['stok']);
    
    $query = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, stok) 
              VALUES ('$judul', '$penulis', '$penerbit', '$tahun', '$stok')";
              
    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Data berhasil ditambah"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}
?>