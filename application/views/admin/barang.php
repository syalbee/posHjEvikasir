<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">

                <div class="card-header">
                    <!-- <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#BRmodaladd"><span class="fa fa-plus"></span> Tambah Barang</a> -->
                    <a href="<?= base_url('barang/tambahview'); ?>" class="btn btn-sm btn-success"><span class="fa fa-plus"></span> Tambah Barang</a>
                </div>
                <div class="card-body">
                    <table class="table w-100 table-bordered table-hover" id="tblbarang">
                        <thead>
                            <tr>
                                <th style="text-align:center;width:40px;">ID</th>
                                <th>Nama</th>
                                <th>H Pk  Grosir</th>
                                <th>H Pk Eceran</th>
                                <th>H Jl Grosir </th>
                                <th>H Jl Eceran</th>
                                <th>H Jl Grosir Mbr</th>
                                <th>H Jl Eceran Mbr</th>
                                <th>Stok </th>
                                <th>Jumlah Min</th>
                                <th style="width:100px;text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- Modal Edit -->
<div class="modal fade" id="BRmodaledit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Barang</h5>
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="BRformedit">
                    <input name="kobar" type="hidden">

                    <!-- <div class="form-group">
                        <label>Barcode</label>
                        <input name="barcode" class="form-control" type="text" placeholder="Barcode">
                    </div> -->

                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input name="nabar" class="form-control" type="text" placeholder="Nama Barang" required>
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control select2" style="width: 100%;" name="kategori">
                            <?php foreach ($kat->result_array() as $kt) {
                                $id_kat = $kt['kategori_id'];
                                $nm_kat = $kt['kategori_nama'];
                                echo "<option value='$id_kat'>$nm_kat</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Suplier</label>
                        <select class="form-control select2" style="width: 100%;" name="suplier">
                            <?php foreach ($sup->result_array() as $s) {
                                $id_sup = $s['suplier_id'];
                                $nm_sup = $s['suplier_nama'];
                                echo "<option value='$id_sup'>$nm_sup</option>";
                            } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Satuan</label>
                        <select class="form-control select2" style="width: 100%;" id="selSatuan" name="satuan">
                            <?php foreach ($sat->result_array() as $s) {
                                $id_sat = $s['satuan_id'];
                                $nm_sat = $s['satuan_nama'] . " => " . $s['satuan_turunan'];
                                echo "<option value='$id_sat'>$nm_sat</option>";
                            } ?>

                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <label>Harga Pokok Untuk Satuan Utama</label>
                        <input name="harpok" class="form-control" type="text" placeholder="Harga Pokok">
                    </div>

                    <div class="form-group">
                        <label>Harga (Penjualan) Untuk Satuan Utama</label>
                        <input name="harjul" class="form-control" type="text" placeholder="Harga Jual Eceran">
                    </div>

                    <div class="form-group">
                        <label>Harga (Penjualan) Untuk Satuan Utama</label>
                        <input name="harjul_grosir" class="form-control" type="text" placeholder="Harga Jual Grosir">
                    </div>

                    <div class="form-group">
                        <label>Stok Untuk 1 Satuan Utama</label>
                        <input name="min_stok" class="form-control" type="number" placeholder="Minimal Stok">
                    </div> -->

                    <div class="form-group">
                        <label>Harga Pokok Untuk Satuan Utama</label>
                        <input name="harpok" class="harpok form-control" type="text" placeholder="Harga Pokok" required>
                    </div>

                    <div class="form-group">
                        <label>Harga (Penjualan Grosir)</label>
                        <input name="harjul_grosir" class="harjul form-control" type="text" placeholder="Harga (Penjualan Grosir) Untuk Satuan Utama" required>
                    </div>

                    <div class="form-group">
                        <label>Harga (Penjualan Eceran)</label>
                        <input name="harjul" class="harjul form-control" type="text" placeholder="Harga (Penjualan Eceran) Untuk Satuan Kedua">
                    </div>


                    <div class="form-group">
                        <label>Jumlah min / satuan utama</label>
                        <input name="min_stok" class="form-control" type="number" placeholder="Jumlah min / satuan utama" required>
                    </div>

                    <button class="btn btn-sm btn-success" name="BREdtbtn" type="button" onclick="editData()">Edit</button>
                    <button class="btn btn-sm btn-danger" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Edit -->


<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Versi</b> 1.0.0
    </div>
    <strong><a href="<?= base_url('dashboard'); ?>"><?= $this->db->get('tbl_toko')->result_array()[0]['nama']; ?></a></strong>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>assets/dist/js/adminlte.min.js"></script>
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?= base_url(); ?>assets/plugins/select2/js/select2.full.min.js"></script>
<script>
    var BRGreadUrl = '<?= base_url('barang/read') ?>';
    var BRGaddUrl = '<?= base_url('barang/add') ?>';
    var BRGremoveUrl = '<?= base_url('barang/delete') ?>';
    var BRGeditUrl = '<?= base_url('barang/edit') ?>';
    var BRGget_barangUrl = '<?= base_url('barang/updateview') ?>';
    var BRGlisturl = '<?= base_url('barang/listbarang') ?>';
</script>
<script src="<?= base_url('assets/js/barang.js') ?>"></script>

<script type="text/javascript">
    $('.select2').select2();
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });
</script>
</body>

</html>