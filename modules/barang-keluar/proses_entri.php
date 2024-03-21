<?php
session_start();      // mengaktifkan session

// pengecekan session login user 
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk insert
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";

  // mengecek data hasil submit dari form
  if (isset($_POST['simpan'])) {
    // ambil data hasil submit dari form
    $id_transaksi  = mysqli_real_escape_string($mysqli, $_POST['id_transaksi']);
    $tanggal       = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
    $barang        = mysqli_real_escape_string($mysqli, $_POST['barang']);
    $penerima      = mysqli_real_escape_string($mysqli, $_POST['penerima']);
    $harga         = mysqli_real_escape_string($mysqli, $_POST['harga']);
    $jumlah        = mysqli_real_escape_string($mysqli, $_POST['jumlah']);
    $total_harga   = mysqli_real_escape_string($mysqli, $_POST['total_harga']);

    // ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d) sebelum disimpan ke database
    $tanggal_keluar = date('Y-m-d', strtotime($tanggal));

    // sql statement untuk insert data ke tabel "tbl_barang_keluar"
    $insert = mysqli_query($mysqli, "INSERT INTO tbl_barang_keluar(id_transaksi, tanggal, barang, penerima, harga, jumlah, total_harga) 
                                     VALUES('$id_transaksi', '$tanggal_keluar', '$barang', '$penerima', '$harga', '$jumlah', '$total_harga')")
                                     or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));
    // cek query
    // jika proses insert berhasil
    if ($insert) {
      // alihkan ke halaman barang keluar dan tampilkan pesan berhasil simpan data
      header('location: ../../main.php?module=barang_keluar&pesan=1');
    }
  }
}
