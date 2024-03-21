<?php
session_start();      // mengaktifkan session

// include autoloader untuk load dompdf, libraries, dan helper functions
require_once("../../assets/js/plugin/dompdf/autoload.inc.php");
// mereferensikan Dompdf namespace
use Dompdf\Dompdf;

// pengecekan session login user 
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk cetak
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";
  // panggil file "fungsi_tanggal_indo.php" untuk membuat format tanggal indonesia
  require_once "../../helper/fungsi_tanggal_indo.php";

  // ambil data GET dari tombol cetak
  $tanggal_awal  = $_GET['tanggal_awal'];
  $tanggal_akhir = $_GET['tanggal_akhir'];

  // gunakan dompdf class
  $dompdf = new Dompdf();
  // setting options
  $options = $dompdf->getOptions();
  $options->setIsRemoteEnabled(true); // aktifkan akses file untuk bisa mengakses file gambar dan CSS
  $options->setChroot('C:\xampp\htdocs\gudang'); // tentukan path direktori aplikasi
  $dompdf->setOptions($options);

  // halaman HTML yang akan diubah ke PDF
  $html = '<!DOCTYPE html>
          <html>
          <head>
              <title>Laporan Data Penyesuaian</title>
            <link href="../../assets/css/laporan.css" rel="stylesheet">
          </head>
          <body class="text-dark">
            <div class="text-center">
              <h2>LAPORAN DATA PENYESUAIAN</h2>
              <span>Tanggal ' . $tanggal_awal . ' s.d. ' . $tanggal_akhir . '</span>
            </div>
            <hr>
            <div class="mt-4">
              <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="bg-secondary text-white text-center">
		              <tr>
                    <th>No.</th>
                    <th>ID Penyesuaian</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
		              </tr>
		            </thead>
						    <tbody class="text-dark">';
  // ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d)
  $tanggal_awal  = date('Y-m-d', strtotime($tanggal_awal));
  $tanggal_akhir = date('Y-m-d', strtotime($tanggal_akhir));
  // variabel untuk nomor urut tabel 
  $no = 1;
  // sql statement untuk menampilkan data dari tabel "tbl_pengiriman" berdasarkan "tanggal"
  $query = mysqli_query($mysqli, "SELECT a.id_penyesuaian, a.tanggal, a.barang, a.jumlah, a.keterangan, b.nama_barang
                                  FROM tbl_penyesuaian as a INNER JOIN tbl_barang as b
                                  ON a.barang=b.id_barang
                                  WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY a.id_penyesuaian ASC")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
  // ambil data hasil query
  while ($data = mysqli_fetch_assoc($query)) {
    // tampilkan data
    $html .= '		<tr>
                    <td width="50" class="text-center">' . $no++ . '</td>
                    <td width="80" class="text-center">' . $data['id_penyesuaian'] . '</td>
                    <td width="70" class="text-center">' . date('d-m-Y', strtotime($data['tanggal'])) . '</td>
                    <td width="100" class="text-center">' . $data['barang'] . ' - ' . $data['nama_barang'] . '</td>
                    <td width="70" class="text-center">' . number_format($data['jumlah'], 0, '', '.') . '</td>
                    <td width="220" class="text-left">' . $data['keterangan'] . '</td>
                  </tr>';
  }
  $html .= '		</tbody>
              </table>
            </div>
            <div class="text-right mt-5">............, ' . tanggal_indo(date('Y-m-d')) . '</div>
            </body>
          </html>';

  // load html
  $dompdf->loadHtml($html);
  // mengatur ukuran dan orientasi kertas
  $dompdf->setPaper('A4', 'landscape');
  // mengubah dari HTML menjadi PDF
  $dompdf->render();
  // menampilkan file PDF yang dihasilkan ke browser dan berikan nama file "Laporan Data Pengiriman.pdf"
  $dompdf->stream('Laporan Data Pengiriman.pdf', array('Attachment' => 0));
}
