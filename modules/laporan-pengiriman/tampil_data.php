<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else { ?>
  <div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-file mr-2"></i> Laporan Pengiriman</h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a>Laporan</a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a>Pengiriman</a></li>
        </ul>
      </div>
    </div>
  </div>

  <?php
  // mengecek data hasil submit dari form filter
  // jika tidak ada data yang dikirim (tombol tampilkan belum diklik) 
  if (!isset($_POST['tampil'])) { ?>
    <div class="page-inner mt--5">
      <div class="card">
        <div class="card-header">
          <!-- judul form -->
          <div class="card-title">Filter Data Pengiriman</div>
        </div>
        <!-- form filter data -->
        <div class="card-body">
          <form action="?module=laporan_pengiriman" method="post" class="needs-validation" novalidate>
            <div class="row">
              <div class="col-lg-3">
                <div class="form-group">
                  <label>Tanggal Awal <span class="text-danger">*</span></label>
                  <input type="text" name="tanggal_awal" class="form-control date-picker" autocomplete="off" required>
                  <div class="invalid-feedback">Tanggal awal tidak boleh kosong.</div>
                </div>
              </div>

              <div class="col-lg-3">
                <div class="form-group">
                  <label>Tanggal Akhir <span class="text-danger">*</span></label>
                  <input type="text" name="tanggal_akhir" class="form-control date-picker" autocomplete="off" required>
                  <div class="invalid-feedback">Tanggal akhir tidak boleh kosong.</div>
                </div>
              </div>

              <div class="col-lg-2 pr-0">
                <div class="form-group pt-3">
                  <!-- tombol tampil data -->
                  <input type="submit" name="tampil" value="Tampilkan" class="btn btn-secondary btn-round btn-block mt-4">
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php
  }
  // jika ada data yang dikirim (tombol tampilkan diklik)
  else {
    // ambil data hasil submit dari form filter
    $tanggal_awal  = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];
  ?>
    <div class="page-inner mt--5">
      <div class="card">
        <div class="card-header">
          <!-- judul form -->
          <div class="card-title">Filter Data Pengiriman</div>
        </div>
        <!-- form filter data -->
        <div class="card-body">
          <form action="?module=laporan_pengiriman" method="post" class="needs-validation" novalidate>
            <div class="row">
              <div class="col-lg-3">
                <div class="form-group">
                  <label>Tanggal Awal <span class="text-danger">*</span></label>
                  <input type="text" name="tanggal_awal" class="form-control date-picker" autocomplete="off" value="<?php echo $tanggal_awal; ?>" required>
                  <div class="invalid-feedback">Tanggal awal tidak boleh kosong.</div>
                </div>
              </div>

              <div class="col-lg-3">
                <div class="form-group">
                  <label>Tanggal Akhir <span class="text-danger">*</span></label>
                  <input type="text" name="tanggal_akhir" class="form-control date-picker" autocomplete="off" value="<?php echo $tanggal_akhir; ?>" required>
                  <div class="invalid-feedback">Tanggal akhir tidak boleh kosong.</div>
                </div>
              </div>

              <div class="col-lg-2 pr-0">
                <div class="form-group pt-3">
                  <!-- tombol tampil data -->
                  <input type="submit" name="tampil" value="Tampilkan" class="btn btn-secondary btn-round btn-block mt-4">
                </div>
              </div>

              <div class="col-lg-2 pr-0">
                <div class="form-group pt-3">
                  <!-- tombol cetak laporan -->
                  <a href="modules/laporan-pengiriman/cetak.php?tanggal_awal=<?php echo $tanggal_awal; ?>&tanggal_akhir=<?php echo $tanggal_akhir; ?>" target="_blank" class="btn btn-warning btn-round btn-block mt-4">
                    <span class="btn-label"><i class="fa fa-print mr-2"></i></span> Cetak
                  </a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <!-- judul tabel -->
          <div class="card-title">
            <i class="fas fa-file-alt mr-2"></i> Laporan Data Pengiriman <strong><?php echo $tanggal_awal; ?></strong> s.d. <strong><?php echo $tanggal_akhir; ?></strong>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <!-- tabel untuk menampilkan data dari database -->
            <table id="basic-datatables" class="display table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th class="text-center">No.</th>
                  <th class="text-center">ID Pengiriman</th>
                  <th class="text-center">Tanggal</th>
                  <th class="text-center">Tipe Proses</th>
                  <th class="text-center">Gudang Pengirim</th>
                  <th class="text-center">Gudang Tujuan</th>
                  <th class="text-center">Keterangan</th>
                  <th class="text-center">Status Pengiriman</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d)
                $tanggal_awal  = date('Y-m-d', strtotime($tanggal_awal));
                $tanggal_akhir = date('Y-m-d', strtotime($tanggal_akhir));

                // variabel untuk nomor urut tabel
                $no = 1;

                // sql statement untuk menampilkan data dari tabel "tbl_pengiriman" berdasarkan "tanggal"
                $query = mysqli_query($mysqli, "SELECT a.id_pengiriman, a.tanggal, a.tipe_proses, a.gudang_pengirim, a.gudang, a.keterangan, a.status
                                                FROM tbl_pengiriman as a
                                                WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY a.id_pengiriman ASC")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                // ambil data hasil query
                while ($data = mysqli_fetch_assoc($query)) { ?>
                  <!-- tampilkan data -->
                  <tr>
                    <td width="50" class="text-center"><?php echo $no++; ?></td>
                    <td width="90" class="text-center"><?php echo $data['id_pengiriman']; ?></td>
                    <td width="70" class="text-center"><?php echo date('d-m-Y', strtotime($data['tanggal'])); ?></td>
                    <td width="70" class="text-left"><?php echo $data['tipe_proses']; ?></td>
                    <td width="70" class="text-left"><?php echo $data['gudang_pengirim']; ?></td>
                    <td width="70" class="text-left"><?php echo $data['gudang']; ?></td>
                    <td width="200" class="text-center"><?php echo $data['keterangan']; ?></td>
                    <td width="60"><?php echo $data['status']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
  <?php
  }
}
?>