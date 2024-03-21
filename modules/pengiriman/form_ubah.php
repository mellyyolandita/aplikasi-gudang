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
    // ambil data GET dari tombol ubah
    $id_pengiriman = $_GET['id'];

    // sql statement untuk menampilkan data dari tabel "tbl_pengiriman" dan tabel "tbl_gudang" berdasarkan "id_pengiriman"
    $query = mysqli_query($mysqli, "SELECT a.id_pengiriman, a.tanggal, a.tipe_proses, a.gudang_pengirim, a.gudang, a.keterangan, a.status
                                    FROM tbl_pengiriman as a
                                    WHERE a.id_pengiriman='$id_pengiriman'")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    // ambil data hasil query
    $data = mysqli_fetch_assoc($query);
  }
?>
  <!-- menampilkan pesan kesalahan unggah file -->
  <div id="pesan"></div>

  <div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-warehouse mr-2"></i> Pengiriman</h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a href="?module=pengiriman" class="text-white">Pengiriman</a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a>Ubah</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul form -->
        <div class="card-title">Ubah Data Pengiriman</div>
      </div>
      <!-- form ubah data -->
      <form action="modules/pengiriman/proses_ubah.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="card-body">
          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <label>ID Pengiriman <span class="text-danger">*</span></label>
                <input type="text" name="id_pengiriman" class="form-control" value="<?php echo $data['id_pengiriman']; ?>" readonly>
              </div>

              <div class="form-group">
                <label>Tanggal <span class="text-danger">*</span></label>
                <input type="text" name="tanggal" class="form-control date-picker" autocomplete="off" value="<?php echo date('d-m-Y', strtotime($data['tanggal'])); ?>" required>
                <div class="invalid-feedback">Tanggal tidak boleh kosong.</div>
              </div>       

              <div class="form-group">
                <label>Gudang Pengirim<span class="text-danger">*</span></label>
                <select name="gudang_pengirim" class="form-control chosen-select" autocomplete="off" required>
                  <option value="<?php echo $data['gudang_pengirim']; ?>"><?php echo $data['gudang_pengirim']; ?></option>
                  <option disabled value="">-- Pilih --</option>
                  <option value="Gudang 59 Basirih">Gudang 59 Basirih</option>
                  <option value="Gudang 59 Belakang">Gudang 59 Belakang</option>
                  <option value="Gudang Tiram">Gudang Tiram</option>
                  <option value="Gudang Hadiah">Gudang Hadiah</option>
                </select>
                <div class="invalid-feedback">Gudang tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Gudang Tujuan<span class="text-danger">*</span></label>
                <select name="gudang" class="form-control chosen-select" autocomplete="off" required>
                  <option value="<?php echo $data['gudang']; ?>"><?php echo $data['gudang']; ?></option>
                  <option disabled value="">-- Pilih --</option>
                  <option value="Gudang 59 Basirih">Gudang 59 Basirih</option>
                  <option value="Gudang 59 Belakang">Gudang 59 Belakang</option>
                  <option value="Gudang Tiram">Gudang Tiram</option>
                  <option value="Gudang Hadiah">Gudang Hadiah</option>
                </select>
                <div class="invalid-feedback">Gudang tidak boleh kosong.</div>
              </div>
            </div>

            <div class="col-md-5 ml-auto">
              <div class="form-group">
                <label>Keterangan <span class="text-danger">*</span></label>
                <input type="text" name="keterangan" class="form-control" autocomplete="off" value="<?php echo $data['keterangan']; ?>" required>
                <div class="invalid-feedback">Keterangan tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Status Pengiriman <span class="text-danger">*</span></label>
                <select name="status" class="form-control chosen-select" autocomplete="off" required>
                  <option value="<?php echo $data['status']; ?>"><?php echo $data['status']; ?></option>
                  <option disabled value="">-- Pilih --</option>
                  <option value="Belum Diterima">Belum Diterima</option>
                  <option value="Diterima Seluruhnya">Diterima Seluruhnya</option>
                </select>
                <div class="invalid-feedback">Status pengiriman tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Tipe Proses<span class="text-danger">*</span></label>
                <select name="tipe_proses" class="form-control chosen-select" autocomplete="off" required>
                  <option value="<?php echo $data['tipe_proses']; ?>"><?php echo $data['tipe_proses']; ?></option>
                  <option disabled value="">-- Pilih --</option>
                  <option value="Terima Barang">Terima Barang</option>
                  <option value="Kirim Barang">Kirim Barang</option>
                </select>
                <div class="invalid-feedback">Tipe proses tidak boleh kosong.</div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-action">
          <!-- tombol simpan data -->
          <input type="submit" name="simpan" value="Simpan" class="btn btn-secondary btn-round pl-4 pr-4 mr-2">
          <!-- tombol kembali ke halaman data pengiriman -->
          <a href="?module=pengiriman" class="btn btn-default btn-round pl-4 pr-4">Batal</a>
        </div>
      </form>
    </div>
  </div>
<?php } ?>