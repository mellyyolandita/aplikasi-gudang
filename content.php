<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "config/database.php";

  // pemanggilan file halaman konten sesuai "module" yang dipilih
  // jika module yang dipilih "dashboard"
  if ($_GET['module'] == 'dashboard') {
    // panggil file tampil data dashboard
    include "modules/dashboard/tampil_data.php";
  }
  // jika module yang dipilih "barang" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'barang' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file tampil data barang
    include "modules/barang/tampil_data.php";
  }
  // jika module yang dipilih "form_entri_barang" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'form_entri_barang' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file form entri barang
    include "modules/barang/form_entri.php";
  }
  // jika module yang dipilih "form_ubah_barang" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'form_ubah_barang' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file form ubah barang
    include "modules/barang/form_ubah.php";
  }
  // jika module yang dipilih "tampil_detail_barang" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'tampil_detail_barang' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file tampil detail barang
    include "modules/barang/tampil_detail.php";
  }
  // jika module yang dipilih "satuan" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'satuan' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file tampil data satuan
    include "modules/satuan/tampil_data.php";
  }
  // jika module yang dipilih "form_entri_satuan" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'form_entri_satuan' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file form entri satuan
    include "modules/satuan/form_entri.php";
  }
  // jika module yang dipilih "form_ubah_satuan" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'form_ubah_satuan' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file form ubah satuan
    include "modules/satuan/form_ubah.php";
  }
  // jika module yang dipilih "penyesuaian" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'penyesuaian' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file tampil data penyesuaian
    include "modules/penyesuaian/tampil_data.php";
  }
  // jika module yang dipilih "form_entri_penyesuaian" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'form_entri_penyesuaian' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file form entri penyesuaian
    include "modules/penyesuaian/form_entri.php";
  }
  // jika module yang dipilih "form_ubah_penyesuaian" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'form_ubah_penyesuaian' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file form ubah penyesuaian
    include "modules/penyesuaian/form_ubah.php";
  }
  // jika module yang dipilih "keadaan_barang" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'keadaan_barang' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file tampil data keadaan barang
    include "modules/keadaan-barang/tampil_data.php";
  }
  // jika module yang dipilih "form_entri_keadaan_barang" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'form_entri_keadaan_barang' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file form entri keadaan barang
    include "modules/keadaan-barang/form_entri.php";
  }
  // jika module yang dipilih "form_ubah_keadaan_barang" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'form_ubah_keadaan_barang' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file form ubah keadaan barang
    include "modules/keadaan-barang/form_ubah.php";
  }
  // jika module yang dipilih "pengiriman" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'pengiriman' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file tampil data pengiriman
    include "modules/pengiriman/tampil_data.php";
  }
  // jika module yang dipilih "form_entri_pengiriman" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'form_entri_pengiriman' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file form entri pengiriman
    include "modules/pengiriman/form_entri.php";
  }
  // jika module yang dipilih "form_ubah_pengiriman" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'form_ubah_pengiriman' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file form ubah pengiriman
    include "modules/pengiriman/form_ubah.php";
  }
  // jika module yang dipilih "tampil_detail_pengiriman" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'tampil_detail_pengiriman' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file tampil detail pengiriman
    include "modules/pengiriman/tampil_detail.php";
  }
  // jika module yang dipilih "barang_masuk" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'barang_masuk' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file tampil data barang masuk
    include "modules/barang-masuk/tampil_data.php";
  }
  // jika module yang dipilih "form_entri_barang_masuk" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'form_entri_barang_masuk' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file form entri barang masuk
    include "modules/barang-masuk/form_entri.php";
  }
    // jika module yang dipilih "form_ubah_barang_masuk" dan hak akses bukan "Kepala Gudang"
    elseif ($_GET['module'] == 'form_ubah_barang_masuk' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
      // panggil file form ubah barang masuk
      include "modules/barang-masuk/form_ubah.php";
    }
  // jika module yang dipilih "barang_keluar" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'barang_keluar' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file tampil data barang keluar
    include "modules/barang-keluar/tampil_data.php";
  }
  // jika module yang dipilih "form_entri_barang_keluar" dan hak akses bukan "Kepala Gudang"
  elseif ($_GET['module'] == 'form_entri_barang_keluar' && $_SESSION['hak_akses'] != 'Kepala Gudang') {
    // panggil file form entri barang keluar
    include "modules/barang-keluar/form_entri.php";
  }
  // jika module yang dipilih "laporan_stok"
  elseif ($_GET['module'] == 'laporan_stok') {
    // panggil file tampil data laporan stok
    include "modules/laporan-stok/tampil_data.php";
  }
  // jika module yang dipilih "laporan_barang_masuk"
  elseif ($_GET['module'] == 'laporan_barang_masuk') {
    // panggil file tampil data laporan barang masuk
    include "modules/laporan-barang-masuk/tampil_data.php";
  }
  // jika module yang dipilih "laporan_barang_keluar"
  elseif ($_GET['module'] == 'laporan_barang_keluar') {
    // panggil file tampil data laporan barang keluar
    include "modules/laporan-barang-keluar/tampil_data.php";
  }
  // jika module yang dipilih "laporan_pengiriman"
  elseif ($_GET['module'] == 'laporan_pengiriman') {
    // panggil file tampil data laporan pengiriman
    include "modules/laporan-pengiriman/tampil_data.php";
  }
  // jika module yang dipilih "laporan_penyesuaian"
  elseif ($_GET['module'] == 'laporan_penyesuaian') {
    // panggil file tampil data laporan penyesuaian
    include "modules/laporan-penyesuaian/tampil_data.php";
  }
  // jika module yang dipilih "laporan_keadaan_barang"
  elseif ($_GET['module'] == 'laporan_keadaan_barang') {
    // panggil file tampil data laporan keadaan barang
    include "modules/laporan-keadaan-barang/tampil_data.php";
  }
  // jika module yang dipilih "user" dan hak akses "Administrator"
  elseif ($_GET['module'] == 'user' && $_SESSION['hak_akses'] == 'Administrator') {
    // panggil file tampil data user
    include "modules/user/tampil_data.php";
  }
  // jika module yang dipilih "form_entri_user" dan hak akses "Administrator"
  elseif ($_GET['module'] == 'form_entri_user' && $_SESSION['hak_akses'] == 'Administrator') {
    // panggil file form entri user
    include "modules/user/form_entri.php";
  }
  // jika module yang dipilih "form_ubah_user" dan hak akses "Administrator"
  elseif ($_GET['module'] == 'form_ubah_user' && $_SESSION['hak_akses'] == 'Administrator') {
    // panggil file form ubah user
    include "modules/user/form_ubah.php";
  }
  // jika module yang dipilih "form_ubah_password"
  elseif ($_GET['module'] == 'form_ubah_password') {
    // panggil file form ubah password
    include "modules/password/form_ubah.php";
  }
}
