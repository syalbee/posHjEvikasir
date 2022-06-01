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
                    <h5><b>Form Tambah Barang</b></h5>
                </div>
                <div class="card-body">
                    <form id="BRformadd" autocomplete="off" method="POST" action="<?= base_url('barang/add'); ?>">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input name="nabar" class="form-control" type="text" placeholder="Nama Barang" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Kategori</label>
                                <select class="form-control select2" style="width: 100%;" name="kategori">
                                    <?php foreach ($kat->result_array() as $kt) { ?>
                                        <option value="<?= $kt['kategori_id']; ?>"><?= $kt['kategori_nama']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col">
                                <label>Satuan</label>
                                <select class="form-control select2" style="width: 100%;" name="satuan">
                                    <?php foreach ($sat->result_array() as $s) { ?>
                                        <option value="<?= $s['satuan_id']; ?>"><?= $s['satuan_nama']; ?> => <?= $s['satuan_turunan']; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Supplier</label>
                            <select class="form-control select2" style="width: 100%;" name="suplier">
                                <?php foreach ($sup->result_array() as $s) { ?>
                                    <option value="<?= $s['suplier_id']; ?>"><?= $s['suplier_nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Stok Barang Grosir</label>
                                <input name="stok" class="form-control" type="number" placeholder="Stok Barang Grosir" required>
                            </div>

                            <div class="col">
                                <label>Banyaknya Jumlah Eceran ke Grosir</label>
                                <input name="min_stok" class="form-control" type="number" placeholder="Banyaknya Jumlah Eceran ke Grosir" required>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col">
                                <label>Harga Modal Grosir</label>
                                <input name="harpok_grosir" class="harpok form-control" type="number" required>
                            </div>
                            <div class="col">
                                <label>Harga Modal Eceran</label>
                                <input name="harpok_eceran" class="harjul form-control" type="number" required>
                            </div>

                        </div>
                        <br>
                        <hr color="grey" size="2">
                        <h5> <b> Non Member</b></h5>
                        <div class="row">
                            <div class="col">
                                <label>Harga Jual Grosir</label>
                                <input name="harjul_grosir" class="harjul form-control" type="number" required>
                            </div>

                            <div class="col">
                                <label>Harga Jual Eceran</label>
                                <input name="harjul_eceran" class="harjul form-control" type="number" required>
                            </div>
                        </div>
                        <hr color="grey" size="2">
                        <h5> <b> Member</b></h5>
                        <div class="row">

                            <div class="col">
                                <label>Harga Jual Grosir</label>
                                <input name="harjul_grosir_m" class="harjul form-control" type="number" required>
                            </div>

                            <div class="col">
                                <label>Harga Jual Eceran</label>
                                <input name="harjul_eceran_m" class="harjul form-control" type="number" required>
                            </div>
                        </div>

                        <br>
                        <button class="btn btn-success" type="submit">Simpan</button>
                    </form>

                </div>
            </div>
        </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

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
<script src="<?= base_url(); ?>assets/plugins/jquery/jquery.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>assets/dist/js/adminlte.min.js"></script>
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>

<script type="text/javascript">
    $('#tblSatuan').DataTable();
    var dataMSG = '<?= $this->session->flashdata('msgSatuan'); ?>';
    console.log("Data" + dataMSG.length);

    if (dataMSG.length != 0) {
        if (dataMSG === "add") {
            Swal.fire("Sukses", "Sukses Menambah Satuan", "success");
        } else if (dataMSG === "edit") {
            Swal.fire("Sukses", "Sukses Edit Satuan", "success");
        } else if (dataMSG === "remove") {
            Swal.fire("Sukses", "Sukses Hapus Satuan", "success");
        }
        dataMSG = "";
    }
</script>
</body>

</html>