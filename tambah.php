<?php
include "koneksi.php";

// ambil data dropdown
$kategori_opt = mysqli_query($koneksi, "SELECT * FROM kategori");
$status_opt = mysqli_query($koneksi, "SELECT * FROM status");

if (isset($_POST['submit'])) {
    $id_produk = mysqli_real_escape_string($koneksi, $_POST['id_produk']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori_id'];
    $status = $_POST['status_id'];

    // validasi nama dan harga
    if (empty($id_produk)) {
        echo "<script>alert('ID produk tidak boleh kosong');</script>";
    } elseif (empty($nama)) {
        echo "<script>alert('Nama produk tidak boleh kosong');</script>";
    } elseif (!is_numeric($harga)) {
        echo "<script>alert('Harga harus berupa angka');</script>";
    } else {
        // insert data
        $query = "INSERT INTO produk 
        (id_produk, nama_produk, harga, kategori_id, status_id) 
        VALUES 
        ('$id_produk', '$nama', '$harga', '$kategori', '$status')";

        // if (mysqli_query($koneksi, $query)) {
        //     header("Location: index.php");
        //     exit();
        // } else {
        //     echo "<script>alert('Gagal! ID produk " . $id_produk . " sudah ada.');</script>";
        // }
        
        try {
            if (mysqli_query($koneksi, $query)) {
                header("Location: index.php");
                exit();
            }
        } catch (mysqli_sql_exception $e) {
            // Tangani error karena duplikat entry (kode 1062)
            if ($e->getCode() == 1062) {
            echo "<script>alert('Gagal! ID produk " . $id_produk . " sudah ada. Gunakan ID lain.'); window.history.back();</script>";
            } else {
                // Tangani error lainnya
                echo "<script>alert('Terjadi kesalahan database.'); window.history.back();</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru</title>
</head>
<body>
    <h2>Tambah Produk Baru</h2>
    <form method="POST">
        ID Produk (Angka): <br>
        <input type="number" name="id_produk" placeholder="Contoh: 1234"><br><br>

        Nama Produk: <br>
        <input type="text" name="nama_produk"><br><br>

        Harga: <br>
        <input type="text" name="harga"><br><br>

        Kategori: <br>
        <select name="kategori_id">
            <?php while ($k = mysqli_fetch_assoc($kategori_opt)): ?>
                <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        Status: <br>
        <select name="status_id">
            <?php while ($s = mysqli_fetch_assoc($status_opt)): ?>
                <option value="<?= $s['id_status'] ?>"><?= $s['nama_status'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit" name="submit">Simpan Produk</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>