<?php
include "koneksi.php";

// id harus ada
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// ambil data lama produk
$query_produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id'");
$data_lama = mysqli_fetch_assoc($query_produk);

// ambil data dropdown
$kategori_opt = mysqli_query($koneksi, "SELECT * FROM kategori");
$status_opt = mysqli_query($koneksi, "SELECT * FROM status");

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori_id'];
    $status = $_POST['status_id'];

    // validasi nama dan harga
    if (empty($nama)) {
        echo "<script>alert('Nama produk tidak boleh kosong');</script>";
    } elseif (!is_numeric($harga)) {
        echo "<script>alert('Harga harus berupa angka');</script>";
    } else {
        // update data
        $update = "UPDATE produk SET
        nama_produk='$nama',
        harga='$harga',
        kategori_id='$kategori',
        status_id='$status'
        WHERE id_produk='$id'";

        if (mysqli_query($koneksi, $update)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
</head>
<body>
    <h2>Edit Produk</h2>
    <form method="POST">
        <p>ID Produk: <b><?=  $data_lama['id_produk'] ?></b> (ID tidak bisa diubah)</p>

        Nama produk: <br>
        <input type="text" name="nama_produk" 
        value="<?= $data_lama['nama_produk'] ?>"><br><br>

        Harga: <br>
        <input type="text" name="harga" 
        value="<?= (int)$data_lama['harga'] ?>"><br><br>

        Kategori: <br>
        <select name="kategori_id">
            <?php while ($k = mysqli_fetch_assoc($kategori_opt)): ?>
                <option value="<?= $k['id_kategori'] ?>"
                <?= ($k['id_kategori'] == $data_lama['kategori_id']) ? "selected" : "" ?>>
                <?= $k['nama_kategori'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        Status: <br>
        <select name="status_id">
            <?php while($s = mysqli_fetch_assoc($status_opt)): ?>
                <option value="<?= $s['id_status'] ?>"
                <?= ($s['id_status'] == $data_lama['status_id']) ? "selected" : "" ?>>
                <?= $s['nama_status'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit" name="update">Update Produk</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>