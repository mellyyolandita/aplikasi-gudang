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
    $id_penyesuaian          = mysqli_real_escape_string($mysqli, $_POST['id_penyesuaian']);
    $tanggal                 = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
    $barang                  = mysqli_real_escape_string($mysqli, $_POST['barang']);
    $jumlah                  = mysqli_real_escape_string($mysqli, $_POST['jumlah']);
    $keterangan              = mysqli_real_escape_string($mysqli, $_POST['keterangan']);

    // ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d) sebelum disimpan ke database
    $tanggal = date('Y-m-d', strtotime($tanggal));

    // sql statement untuk insert data ke tabel "tbl_penyesuaian"
    $insert = mysqli_query($mysqli, "INSERT INTO tbl_penyesuaian(id_penyesuaian, tanggal, barang, jumlah, keterangan) 
                                     VALUES('$id_penyesuaian', '$tanggal', '$barang', '$jumlah', '$keterangan')")
                                     or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));
    // cek query
    // jika proses insert berhasil
    if ($insert) {
      // alihkan ke halaman penyesuaian dan tampilkan pesan berhasil simpan data
      header('location: ../../main.php?module=penyesuaian&pesan=1');
    }
  }
}