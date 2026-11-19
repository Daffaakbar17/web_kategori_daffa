
<?php
$conn = mysqli_connect("localhost", "root", "");

if (!$conn) {
    die("MySQL belum aktif!");
}

mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS db_produk");
mysqli_select_db($conn, "db_produk");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100)
)");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS produk (
    id_produk INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100),
    id_kategori INT,
    harga DECIMAL(12,2),
    stok INT
)");

$cek = mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk");
$total = mysqli_fetch_assoc($cek);

if ($total['total'] == 0) {
    mysqli_query($conn, "INSERT INTO kategori VALUES
    (1,'Alat Tulis'),
    (2,'Aksesoris Komputer'),
    (3,'Kebutuhan Lab')");

    mysqli_query($conn, "INSERT INTO produk VALUES
    (1,'Buku Catatan',1,12000,20),
    (2,'Pulpen Gel',1,7000,30),
    (3,'Mouse USB',2,85000,8),
    (4,'Flashdisk 32 GB',2,78000,12),
    (6,'Kabel Jumper',3,25000,20)");
}

$data = mysqli_query($conn, "
SELECT produk.*, kategori.nama_kategori
FROM produk
LEFT JOIN kategori
ON produk.id_kategori = kategori.id_kategori
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Produk</title>

<style>
body {
    font-family: Arial;
    background: #f3f5f9;
    margin: 0;
}

table {
    border-collapse: collapse;
    background: white;
    width: 70%;
    margin: 75px auto;
    box-shadow: 0 5px 15px #ddd;
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    padding: 17px;
    text-align: center;
    border-right: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    font-size: 20px;
}

th {
    font-weight: normal;
}

tr:last-child td {
    border-bottom: none;
}

th:last-child, td:last-child {
    border-right: none;
}
</style>

</head>
<body>

<table>
<tr>
    <th>Id Produk</th>
    <th>Nama Produk</th>
    <th>Nama Kategori</th>
    <th>Harga</th>
    <th>Stok</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($data)) { ?>
<tr>
    <td><?= $row['id_produk']; ?></td>
    <td><?= $row['nama_produk']; ?></td>
    <td><?= $row['nama_kategori']; ?></td>
    <td><?= number_format($row['harga'], 2, '.', ''); ?></td>
    <td><?= $row['stok']; ?></td>
</tr>
<?php } ?>

</table>

</body>
</html>

