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
    $id_keadaan             = mysqli_real_escape_string($mysqli, $_POST['id_keadaan']);
    $barang                 = mysqli_real_escape_string($mysqli, $_POST['barang']);
    $tanggal_cek            = mysqli_real_escape_string($mysqli, trim($_POST['tanggal_cek']));
    $stok                   = mysqli_real_escape_string($mysqli, $_POST['stok']);
    $kondisi_barang         = mysqli_real_escape_string($mysqli, $_POST['kondisi_barang']);
    $keterangan             = mysqli_real_escape_string($mysqli, $_POST['keterangan']);

    // ubah format tanggal_cek menjadi Tahun-Bulan-Hari (Y-m-d) sebelum disimpan ke database
    $tanggal_cek = date('Y-m-d', strtotime($tanggal_cek));

    // sql statement untuk insert data ke tabel "tbl_keadaan_barang"
    $insert = mysqli_query($mysqli, "INSERT INTO tbl_keadaan_barang(id_keadaan, barang, tanggal_cek, stok, kondisi_barang, keterangan) 
                                     VALUES('$id_keadaan', '$barang', '$tanggal_cek', '$stok', '$kondisi_barang', '$keterangan')")
                                     or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));
    // cek query
    // jika proses insert berhasil
    if ($insert) {
      // alihkan ke halaman keadaan barang dan tampilkan pesan berhasil simpan data
      header('location: ../../main.php?module=keadaan_barang&pesan=1');
    }
  }
}