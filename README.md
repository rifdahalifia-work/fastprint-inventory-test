# 🚀 FastPrint Inventory System - Technical Test

Halo Tim HRD & Technical FastPrint! Saya Rifdah Alifia👋 
Terima kasih atas kesempatannya. Proyek ini adalah hasil pengerjaan Technical Test untuk posisi Junior Programmer. Sistem ini dibuat untuk mengelola data produk dengan sinkronisasi langsung dari API FastPrint.

## 🔗 Repository & Demo
- **GitHub**: [PASTE_LINK_GITHUB_KAMU_DISINI]
- **Author**: Rifdah Alifia

## ✨ Fitur Utama
- **Auto-Sync API**: Mengambil data produk, kategori, dan status langsung dari API resmi dengan autentikasi MD5.
- **Smart Filtering**: Halaman utama secara default hanya menampilkan produk dengan status "bisa dijual" (Sesuai instruksi soal).
- **Full CRUD**: Tambah, Edit, dan Hapus data dengan validasi yang kuat.
- **Form Validation**: Proteksi input nama produk kosong dan validasi harga harus berupa angka.
- **Safety Delete**: Fitur konfirmasi sebelum menghapus data untuk mencegah kesalahan user.

## 🛠️ Teknologi yang Digunakan
- **Bahasa**: PHP 8.x
- **Database**: MySQL (MariaDB)
- **Interface**: HTML5 & CSS Minimalist
- **Auth**: MD5 Hash Authentication

## 📸 Dokumentasi Tampilan
*(Screenshot dapat dilihat pada folder `/screenshots`)*
1. **Halaman Utama**: Menampilkan produk siap jual.
2. **Manajemen Data**: Fitur Tambah, Edit, dan Hapus (dengan konfirmasi).
3. **Validasi**: Pesan peringatan jika input tidak sesuai kriteria.

## 📂 Cara Instalasi
1. Clone atau download file proyek ini ke folder `htdocs` (XAMPP).
2. Import file database `db_inventory.sql` yang tersedia di folder proyek melalui phpMyAdmin.
3. Sesuaikan konfigurasi database di file `koneksi.php` jika perlu.
4. Jalankan `localhost/inventory/ambil_api.php` pada browser untuk pertama kali guna melakukan sinkronisasi data awal dari API.
5. Akses sistem melalui `localhost/inventory/index.php`.

## 💡 Catatan Tambahan
Sistem ini menggunakan logika `ON DUPLICATE KEY UPDATE` saat pengambilan data dari API, sehingga data di database lokal akan selalu sinkron tanpa adanya duplikasi data kategori atau status.

---
*Terima kasih banyak atas kesempatan dan waktunya ✨*