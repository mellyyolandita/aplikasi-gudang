<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {
  // mengecek data GET "id_keadaan"
  if (isset($_GET['id'])) {
    // ambil data GET dari tombol ubah
    $id_keadaan = $_GET['id'];

    // sql statement untuk menampilkan data dari tabel "tbl_keadaan_barang" berdasarkan "id_keadaan"
    $query = mysqli_query($mysqli, "SELECT a.id_keadaan, a.barang, a.tanggal_cek, a.stok, a.kondisi_barang, a.keterangan, b.nama_barang
                                    FROM tbl_keadaan_barang as a INNER JOIN tbl_barang as b
                                    ON a.barang=b.id_barang
                                    WHERE a.id_keadaan='$id_keadaan'")
    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    // ambil data hasil query
    $data = mysqli_fetch_assoc($query);
  }
?>
  <!-- menampilkan pesan kesalahan -->
  <div id="pesan"></div>

  <div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-clipboard mr-2"></i> Keadaan Barang</h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a href="?module=keadaan_barang" class="text-white">Keadaan Barang</a></li>
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
        <div class="card-title">Ubah Data Keadaan Barang</div>
      </div>
      <!-- form ubah data -->
      <form action="modules/keadaan-barang/proses_ubah.php" method="post" class="needs-validation" novalidate>
        <div class="card-body">
          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <label>ID Keadaan <span class="text-danger">*</span></label>
                <input type="text" name="id_keadaan" class="form-control" value="<?php echo $data['id_keadaan']; ?>" readonly>
              </div>

              <div class="form-group">
                <label>Barang <span class="text-danger">*</span></label>
                <select id="data_barang" name="barang" class="form-control chosen-select" autocomplete="off" required>
                  <option value="<?php echo $data['barang']; ?>"><?php echo $data['nama_barang']; ?></option>
                  <option disabled value="">-- Pilih --</option>
                  <?php
                  // sql statement untuk menampilkan data dari tabel "tbl_barang"
                  $query_barang = mysqli_query($mysqli, "SELECT id_barang, nama_barang FROM tbl_barang ORDER BY id_barang ASC")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                  // ambil data hasil query
                  while ($data_barang = mysqli_fetch_assoc($query_barang)) {
                    // tampilkan data
                    echo "<option value='$data_barang[id_barang]'>$data_barang[nama_barang]</option>";
                  }
                  ?>
                </select>
                <div class="invalid-feedback">Barang tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Tanggal <span class="text-danger">*</span></label>
                <input type="text" name="tanggal_cek" class="form-control date-picker" autocomplete="off" value="<?php echo date('d-m-Y', strtotime($data['tanggal_cek'])); ?>" required>
                <div class="invalid-feedback">Tanggal tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Stok<span class="text-danger">*</span></label>
                <input type="text" id="stok" name="stok" class="form-control" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" value="<?php echo $data['stok']; ?>"required>
                <div class="invalid-feedback">Stok tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Kondisi Barang <span class="text-danger">*</span></label>
                <input type="text" name="kondisi_barang" class="form-control" autocomplete="off" value="<?php echo $data['kondisi_barang']; ?>" required>
                <div class="invalid-feedback">Kondisi barang tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Keterangan <span class="text-danger">*</span></label>
                <input type="text" name="keterangan" class="form-control" autocomplete="off" value="<?php echo $data['keterangan']; ?>" required>
                <div class="invalid-feedback">Keterangan tidak boleh kosong.</div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-action">
          <!-- tombol simpan data -->
          <input type="submit" name="simpan" value="Simpan" class="btn btn-secondary btn-round pl-4 pr-4 mr-2">
          <!-- tombol kembali ke halaman data barang masuk -->
          <a href="?module=keadaan_barang" class="btn btn-default btn-round pl-4 pr-4">Batal</a>
        </div>
      </form>
    </div>
  </div>
<?php } ?>