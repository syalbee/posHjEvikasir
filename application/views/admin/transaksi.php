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
                    <h5><b>Silahkan Pilih Jenis Transaksi</b></h5>
                </div>
                <div class="card-body">


                </div>
            </div>
        </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- Show modal buat nampilin jenis transaksi -->
<div class="modal" id="transaksiNotif">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Silahkan Pilih Jenis Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="IDpeltransaksi">Nama Pelanggan</label>
                        <select style="width:470px;margin-right:5px;" name="IDpeltransaksi" id="IDpeltransaksi" class="form-control select2 col-sm-12">

                        </select>
                    </div>
                    <button type="button" onclick="cekPelanggan()" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
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
<!-- Select2 -->
<script src="<?= base_url(); ?>assets/plugins/select2/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?= base_url(); ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/inputmask/jquery.inputmask.min.js"></script>

<script>
    window.onload = $('#transaksiNotif').modal('show');
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    $("#IDpeltransaksi").select2({
        placeholder: "Nama Pelanggan",
        ajax: {
            url: '<?php echo site_url('pelanggan/get_pelangganid') ?>',
            type: "post",
            dataType: "json",
            data: (params) => ({
                namaID: params.term,
            }),
            success: function(msg) {
                // $('#detail_barang').html(msg);
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return {
                            id: obj.id,
                            text: obj.text
                        };
                    })
                };
            },
            cache: true,
        },
    });

    function cekPelanggan() {
        $.ajax({
            url: '<?php echo site_url('transaksi/cektransaksi') ?>',
            type: "post",
            dataType: "text",
            data: {
                id: $("#IDpeltransaksi").val()
            },
            success: (res) => {
                console.log(res);
                if (res == "member") {
                    window.location.href = '<?= base_url('transaksi_member'); ?>';
                } else {
                    window.location.href = '<?= base_url('transaksi_nonmember'); ?>';
                }
            },
            error(a) {
                console.log(a);
            }
        });
    }
</script>

</html>