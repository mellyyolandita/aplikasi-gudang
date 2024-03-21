<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {
  // mengecek data GET "id_pengiriman"
  if (isset($_GET['id'])) {
    // ambil data GET dari tombol detail
    $id_pengiriman = $_GET['id'];

    // sql statement untuk menampilkan data dari tabel "tbl_pengiriman", tabel "tbl_gudang" berdasarkan "id_pengiriman"
    $query = mysqli_query($mysqli, "SELECT a.id_pengiriman, a.tanggal, a.tipe_proses, a.gudang_pengirim, a.gudang, a.keterangan, a.status
                                    FROM tbl_pengiriman as a 
                                    WHERE a.id_pengiriman='$id_pengiriman'")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    // ambil data hasil query
    $data = mysqli_fetch_assoc($query);
  }
?>
  <div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-45">
      <div class="d-flex align-items-left align-items-md-top flex-column flex-md-row">
        <div class="page-header text-white">
          <!-- judul halaman -->
          <h4 class="page-title text-white"><i class="fas fa-warehouse mr-2"></i> Pemindahan</h4>
          <!-- breadcrumbs -->
          <ul class="breadcrumbs">
            <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="?module=pengiriman" class="text-white">Pemindahan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Detail</a></li>
          </ul>
        </div>
        <div class="ml-md-auto py-2 py-md-0">
          <!-- tombol kembali ke halaman data pengiriman -->
          <a href="?module=pengiriman" class="btn btn-secondary btn-round">
            <span class="btn-label"><i class="far fa-arrow-alt-circle-left mr-2"></i></span> Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <!-- judul form -->
            <div class="card-title">Detail Data Pemindahan</div>
          </div>
          <!-- detail data -->
          <div class="card-body">
            <table class="table table-striped">
              <tr>
                <td width="120">ID Pemindahan</td>
                <td width="10">:</td>
                <td><?php echo $data['id_pengiriman']; ?></td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><?php echo $data['tanggal']; ?></td>
              </tr>
              <tr>
                <td>Tipe Proses</td>
                <td>:</td>
                <td><?php echo $data['tipe_proses']; ?></td>
              </tr>
              <tr>
                <td>Gudang Pengirim</td>
                <td>:</td>
                <td><?php echo $data['gudang_pengirim']; ?></td>
              </tr>
              <tr>
                <td>Gudang Tujuan</td>
                <td>:</td>
                <td><?php echo $data['gudang']; ?></td>
              </tr>
              <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td><?php echo $data['keterangan']; ?></td>
              </tr>
              <tr>
                <td>Status Pengiriman</td>
                <td>:</td>
                <td><?php echo $data['status']; ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>