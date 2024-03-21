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
    $id_pengiriman      = mysqli_real_escape_string($mysqli, $_POST['id_pengiriman']);
    $tanggal            = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
    $tipe_proses        = mysqli_real_escape_string($mysqli, $_POST['tipe_proses']);
    $gudang_pengirim    = mysqli_real_escape_string($mysqli, $_POST['gudang_pengirim']);
    $gudang             = mysqli_real_escape_string($mysqli, $_POST['gudang']);
    $keterangan         = mysqli_real_escape_string($mysqli, $_POST['keterangan']);
    $status             = mysqli_real_escape_string($mysqli, $_POST['status']);

    // ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d) sebelum disimpan ke database
    $tanggal = date('Y-m-d', strtotime($tanggal));

    // sql statement untuk insert data ke tabel "tbl_pengiriman"
    $insert = mysqli_query($mysqli, "INSERT INTO tbl_pengiriman(id_pengiriman, tanggal, tipe_proses, gudang_pengirim, gudang, keterangan, status) 
                                     VALUES('$id_pengiriman', '$tanggal', '$tipe_proses', '$gudang_pengirim', '$gudang', '$keterangan', '$status')")
                                     or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));
    // cek query
    // jika proses insert berhasil
    if ($insert) {
      // alihkan ke halaman pengiriman dan tampilkan pesan berhasil simpan data
      header('location: ../../main.php?module=pengiriman&pesan=1');
    }
  }
}
