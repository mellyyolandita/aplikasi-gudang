<?php
session_start();      // mengaktifkan session

// pengecekan session login user 
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk delete
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";

  // mengecek data GET "id_keadaan"
  if (isset($_GET['id'])) {
    // ambil data GET dari tombol hapus
    $id_keadaan = mysqli_real_escape_string($mysqli, $_GET['id']);

    // sql statement untuk delete data dari tabel "tbl_keadaan_barang" berdasarkan "id_keadaan"
    $delete = mysqli_query($mysqli, "DELETE FROM tbl_keadaan_barang WHERE id_keadaan='$id_keadaan'")
                                     or die('Ada kesalahan pada query delete : ' . mysqli_error($mysqli));
    // cek query
    // jika proses delete berhasil
    if ($delete) {
      // alihkan ke halaman keadaan barang dan tampilkan pesan berhasil hapus data
      header('location: ../../main.php?module=keadaan_barang&pesan=3');
    }
  }
}
