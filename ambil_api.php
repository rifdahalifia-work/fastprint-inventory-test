<?php
include "koneksi.php";

$url = "https://recruitment.fastprint.co.id/tes/api_tes_programmer";

date_default_timezone_set("Asia/Jakarta");

$tanggal = date("d");
$bulan = date("m");
$tahun = date("y");
$jam = date("H");

//username 
$username = "tesprogrammer" . date("dmy") . "C" . $jam;
//password sesuai tanggal hari ini
$password_raw = "bisacoding-$tanggal-$bulan-$tahun"; 
$password = md5($password_raw);

$postData = [
    "username" => $username,
    "password" => $password
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
// curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36");

// curl_setopt($ch, CURLOPT_HEADER, true);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);


$response = curl_exec($ch);

if ($response === false) {
    die("Curl error: " . curl_error($ch));
}

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpcode != 200) {
    die("API error. HTTP Code: " . $httpcode);
}

// $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
// $body = substr($response, $header_size);

curl_close($ch);

$data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("Error decoding JSON: " . json_last_error_msg());
}

if (!isset($data['data'])) {
    die("Gagal mengambil data dari API.");
}

$produkList = $data['data'];

foreach ($produkList as $p) {

    $kategori_nama = mysqli_real_escape_string($koneksi, $p['kategori']);
    $status_nama = trim(mysqli_real_escape_string($koneksi, $p['status']));

    // Kategori
    mysqli_query($koneksi, "INSERT IGNORE INTO kategori (nama_kategori) VALUES ('$kategori_nama')");
    $resKategori = mysqli_query($koneksi, "SELECT id_kategori FROM kategori WHERE nama_kategori='$kategori_nama'");
    $kategori_id = mysqli_fetch_assoc($resKategori)['id_kategori'];

    // Status
    mysqli_query($koneksi, "INSERT IGNORE INTO status (nama_status) VALUES ('$status_nama')");
    $resStatus = mysqli_query($koneksi, "SELECT id_status FROM status WHERE nama_status='$status_nama'");
    $status_id = mysqli_fetch_assoc($resStatus)['id_status'];

    // Produk
    $id_produk = $p['id_produk'];
    $nama_produk = mysqli_real_escape_string($koneksi, $p['nama_produk']);
    $harga = $p['harga'];

    // mysqli_query($koneksi, "INSERT IGNORE INTO produk 
    // (id_produk, nama_produk, harga, kategori_id, status_id) 
    // VALUES ('$id_produk', '$nama_produk', '$harga', '$kategori_id', '$status_id')");

    $sql_produk = "INSERT INTO produk 
    (id_produk, nama_produk, harga, kategori_id, status_id)
    VALUES ('$id_produk', '$nama_produk', '$harga', '$kategori_id', '$status_id')
    ON DUPLICATE KEY UPDATE
    nama_produk='$nama_produk', harga='$harga',
    kategori_id='$kategori_id', status_id='$status_id'
    ";

    mysqli_query($koneksi, $sql_produk);
}

echo "Data berhasil disimpan ke database!";

echo "<pre>";
echo "Username: " . $username . "\n";
echo "Password: " . $password . "\n";
echo "HTTP Code: " . $httpcode . "\n\n";
echo "</pre>";
?>