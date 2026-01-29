<?php
include "koneksi.php";

//hapus 
if (isset($_GET['hapus'])) {
    $id_hapus = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk='$id_hapus'");
    header("Location: index.php?filter=dijual");
    exit();
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'dijual';
$where = "";

if ($filter === 'dijual') {
    $where = "WHERE s.nama_status = 'bisa dijual'";
} 

$query = mysqli_query($koneksi, 
"SELECT p.id_produk, p.nama_produk, p.harga, 
k.nama_kategori, s.nama_status
FROM produk p
JOIN kategori k ON p.kategori_id = k.id_kategori
JOIN status s ON p.status_id = s.id_status
$where
ORDER BY p.id_produk ASC
");
?>

<h2>Daftar Produk</h2>

<a href="index.php?filter=semua">Semua Produk</a> |
<a href="index.php?filter=dijual">Hanya Bisa Dijual</a>
<a href="tambah.php" style="color:green; font-weight: bold;">+ Tambah Produk</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>ID Produk</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Kategori</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($query)) { ?>
    <tr>
        <td><?= $row['id_produk'] ?></td>
        <td><?= $row['nama_produk'] ?></td>
        <td><?= number_format($row['harga'], 0, ',', '.') ?></td> 
        <td><?= $row['nama_kategori'] ?></td>
        <td><?= $row['nama_status'] ?></td>
        <td>
            <a href="edit.php?id=<?= $row['id_produk'] ?>">Edit</a> |
            <a href="index.php?hapus=<?= $row['id_produk'] ?>" 
            style="color:red;"
            onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>