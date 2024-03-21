<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else { ?>
  <!-- menampilkan pesan kesalahan unggah file -->
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
          <li class="nav-item"><a>Entri</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul form -->
        <div class="card-title">Entri Data Keadaan Barang</div>
      </div>
      <!-- form entri data -->
      <form action="modules/keadaan-barang/proses_entri.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="card-body">
          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <?php
                // membuat "id_keadaan"
                // sql statement untuk menampilkan 4 digit terakhir dari "id_keadaan" pada tabel "tbl_keadaan_barang"
                $query = mysqli_query($mysqli, "SELECT RIGHT(id_keadaan,4) as nomor FROM tbl_keadaan_barang ORDER BY id_keadaan DESC LIMIT 1")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                // ambil jumlah baris data hasil query
                $rows = mysqli_num_rows($query);

                // cek hasil query
                // jika "id_keadaan" sudah ada
                if ($rows <> 0) {
                  // ambil data hasil query
                  $data = mysqli_fetch_assoc($query);
                  // nomor urut "id_keadaan" yang terakhir + 1 (contoh nomor urut yang terakhir adalah 2, maka 2 + 1 = 3, dst..)
                  $nomor_urut = $data['nomor'] + 1;
                }
                // jika "id_keadaan" belum ada
                else {
                  // nomor urut "id_keadaan" = 1
                  $nomor_urut = 1;
                }

                // menambahkan karakter "B" diawal dan karakter "0" disebelah kiri nomor urut
                $id_keadaan = "KB" . str_pad($nomor_urut, 4, "0", STR_PAD_LEFT);
                ?>
                <label>ID Keadaan Barang<span class="text-danger">*</span></label>
                <!-- tampilkan "id_keadaan" -->
                <input type="text" name="id_keadaan" class="form-control" value="<?php echo $id_keadaan; ?>" readonly>
              </div>

              <div class="form-group">
                <label>Barang <span class="text-danger">*</span></label>
                <select id="data_barang" name="barang" class="form-control chosen-select" autocomplete="off" required>
                  <option selected disabled value="">-- Pilih --</option>
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
                <label>Tanggal Cek<span class="text-danger">*</span></label>
                <input type="text" name="tanggal_cek" class="form-control date-picker" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" required>
                <div class="invalid-feedback">Tanggal cek tidak boleh kosong.</div>
              </div>
              
              <div class="form-group">
                <label>Stok<span class="text-danger">*</span></label>
                <input type="text" id="stok" name="stok" class="form-control" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" required>
                <div class="invalid-feedback">Stok tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Kondisi Barang <span class="text-danger">*</span></label>
                <input type="text" name="kondisi_barang" class="form-control" autocomplete="off" required>
                <div class="invalid-feedback">Kondisi barang tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Keterangan <span class="text-danger">*</span></label>
                <input type="text" name="keterangan" class="form-control" autocomplete="off" required>
                <div class="invalid-feedback">Keterangan tidak boleh kosong.</div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-action">
          <!-- tombol simpan data -->
          <input type="submit" name="simpan" value="Simpan" class="btn btn-secondary btn-round pl-4 pr-4 mr-2">
          <!-- tombol kembali ke halaman keadaan barang-->
          <a href="?module=keadaan_barang" class="btn btn-default btn-round pl-4 pr-4">Batal</a>
        </div>
      </form>
    </div>
  </div>
<?php } ?>