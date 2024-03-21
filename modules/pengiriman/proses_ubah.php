<?php
session_start();      // mengaktifkan session

// pengecekan session login user 
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk update
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";

  // mengecek data hasil submit dari form
  if (isset($_POST['simpan'])) {
    // ambil data hasil submit dari form
    $id_pengiriman      = mysqli_real_escape_string($mysqli, $_POST['id_pengiriman']);
    $tanggal            = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
    $tipe_proses        = mysqli_real_escape_string($mysqli, $_POST['tipe_proses']);
    $barang             = mysqli_real_escape_string($mysqli, $_POST['barang']);
    $gudang_pengirim    = mysqli_real_escape_string($mysqli, $_POST['gudang_pengirim']);
    $gudang             = mysqli_real_escape_string($mysqli, $_POST['gudang']);
    $keterangan         = mysqli_real_escape_string($mysqli, $_POST['keterangan']);
    $status             = mysqli_real_escape_string($mysqli, $_POST['status']);

    // ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d) sebelum disimpan ke database
    $tanggal = date('Y-m-d', strtotime($tanggal));

    // sql statement untuk update data di tabel "tbl_pengiriman" berdasarkan "id_pengiriman"
    $update = mysqli_query($mysqli, "UPDATE tbl_pengiriman
                                     SET tanggal='$tanggal', barang='$barang', tipe_proses='$tipe_proses', gudang_pengirim='$gudang_pengirim', gudang='$gudang', keterangan='$keterangan', status='$status'
                                     WHERE id_pengiriman='$id_pengiriman'")
                                     or die('Ada kesalahan pada query update : ' . mysqli_error($mysqli));

    // cek query
    // jika proses update berhasil
    if ($update) {
      // alihkan ke halaman pengiriman dan tampilkan pesan berhasil simpan data
      header('location: ../../main.php?module=pengiriman&pesan=1');
    }
  }
}
