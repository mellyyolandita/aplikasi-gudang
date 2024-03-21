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
    $id_keadaan             = mysqli_real_escape_string($mysqli, $_POST['id_keadaan']);
    $barang                 = mysqli_real_escape_string($mysqli, $_POST['barang']);
    $tanggal_cek            = mysqli_real_escape_string($mysqli, trim($_POST['tanggal_cek']));
    $stok                   = mysqli_real_escape_string($mysqli, $_POST['stok']);
    $kondisi_barang         = mysqli_real_escape_string($mysqli, $_POST['kondisi_barang']);
    $keterangan             = mysqli_real_escape_string($mysqli, $_POST['keterangan']);

    // ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d) sebelum disimpan ke database
    $tanggal_cek = date('Y-m-d', strtotime($tanggal_cek));

    // sql statement untuk update data di tabel "tbl_keadaan_barang" berdasarkan "id_keadaan"
    $update = mysqli_query($mysqli, "UPDATE tbl_keadaan_barang
                                     SET barang='$barang', tanggal_cek='$tanggal_cek', stok='$stok', kondisi_barang='$kondisi_barang', keterangan='$keterangan'
                                     WHERE id_keadaan='$id_keadaan'")
                                     or die('Ada kesalahan pada query update : ' . mysqli_error($mysqli));

    // cek query
    // jika proses update berhasil
    if ($update) {
      // alihkan ke halaman keadaan barang dan tampilkan pesan berhasil simpan data
      header('location: ../../main.php?module=keadaan_barang&pesan=2');
    }
  }
}
