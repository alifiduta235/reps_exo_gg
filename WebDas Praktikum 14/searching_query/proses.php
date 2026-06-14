<?php
include_once "koneksi.php";

$firstname = FILTER_INPUT(INPUT_POST, 'fname');
$email = FILTER_INPUT(INPUT_POST, 'email');
$btnSubmit = FILTER_INPUT(INPUT_POST, 'btnSubmit');

if($btnSubmit) {
    //echo "<p>Nama: ".$firstname."</p>";
    //echo "<p>Email: ".$email."</p>";

    try {
        $sql = "INSERT INTO pengguna (first_name, email) VALUES (:fname, :email)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'fname' => $firstname,
            'email' => $email
        ]);
        $msg = "New record created successfully";
    } catch(PDOException $e) {
        $msg = $sql . "<br>" . $e->getMessage();
    }
    $conn = null;
    header("location:index.php?msg=".$msg);
    exit;
}
?>