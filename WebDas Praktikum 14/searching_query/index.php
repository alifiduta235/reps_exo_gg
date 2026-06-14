<?php
include_once "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ini PHP</title>
    <style>
        table, tr, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            margin: 3px;
            padding: 3px;
        }
    </style>
</head>
<body>
<h1>Ini halaman PHP Pertamaku</h1>
<?php
echo "Ini dari PHP.";
$nama = "Maresha";
echo "<p>Hello, ".$nama.".</p>";
?>
<h2>Haiiii, <?php echo $nama; ?>.</h2>

<fieldset>
    <legend>Isian Data</legend>
    <form action="proses.php" method="POST">
        <input type="text" name="fname" placeholder="First name">
        <input type="email" name="email" placeholder="Email">
        <input type="submit" name="btnSubmit" value="Simpan">
    </form>
</fieldset>
<br/>
<?php
$keyword = ISSET($_GET['keyword']) ? trim($_GET['keyword']) : "";
?>
<form action="index.php" method="get">
    <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>">
    <button type="submit">Cari</button>
</form>
<?php
$msg = ISSET($_GET['msg']) ? trim($_GET['msg']) : "";
echo "<span style='color:red'>".$msg."</span>";

try { 
    if ($keyword != '') {
        $sql = "SELECT user_id, first_name, email FROM pengguna WHERE first_name LIKE :keyword";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
        $stmt->execute();
    } else {
        $sql = "SELECT user_id, first_name, email FROM pengguna";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    if ($stmt->rowCount() > 0) {
        echo "<table><tr><th>ID</th><th>Firstname</th><th>Email</th></tr>";
        echo "<tr><td colspan='3'>".$stmt->rowCount()."</td></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['first_name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        unset($result);
    } else {
        echo "No records found.";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
</body>
</html>