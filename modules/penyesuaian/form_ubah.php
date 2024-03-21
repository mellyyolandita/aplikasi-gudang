<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {
  // mengecek data GET "id_penyesuaian"
  if (isset($_GET['id'])) {
    // ambil data GET dari tombol ubah
    $id_penyesuaian = $_GET['id'];

    // sql statement untuk menampilkan data dari tabel "tbl_penyesuaian" berdasarkan "id_penyesuaian"
    $query = mysqli_query($mysqli, "SELECT a.id_penyesuaian, a.tanggal, a.barang, a.jumlah, a.keterangan, b.nama_barang
                                    FROM tbl_penyesuaian as a INNER JOIN tbl_barang as b
                                    ON a.barang=b.id_barang
                                    WHERE a.id_penyesuaian='$id_penyesuaian'")
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
        <h4 class="page-title text-white"><i class="fas fa-list mr-2"></i> Penyesuaian</h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a href="?module=penyesuaian" class="text-white">Penyesuaian</a></li>
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
        <div class="card-title">Ubah Data Penyesuaian</div>
      </div>
      <!-- form ubah data -->
      <form action="modules/penyesuaian/proses_ubah.php" method="post" class="needs-validation" novalidate>
        <div class="card-body">
          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <label>ID Penyesuaian <span class="text-danger">*</span></label>
                <input type="text" name="id_penyesuaian" class="form-control" value="<?php echo $data['id_penyesuaian']; ?>" readonly>
              </div>

              <div class="form-group">
                <label>Tanggal <span class="text-danger">*</span></label>
                <input type="text" name="tanggal" class="form-control date-picker" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" required>
                <div class="invalid-feedback">Tanggal tidak boleh kosong.</div>
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
                <label>Jumlah<span class="text-danger">*</span></label>
                <input type="text" id="jumlah" name="jumlah" class="form-control" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" value="<?php echo $data['jumlah']; ?>"required>
                <div class="invalid-feedback">Jumlah tidak boleh kosong.</div>
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
          <a href="?module=penyesuaian" class="btn btn-default btn-round pl-4 pr-4">Batal</a>
        </div>
      </form>
    </div>
  </div>
<?php } ?>