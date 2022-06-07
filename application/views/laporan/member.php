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
                <div class="card-body">
                    <table class="table w-100 table-bordered table-hover" id="tbllapeceran">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Member</th>
                                <th>No Faktur</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Uang</th>
                                <th>Kembalian</th>
                                <th>Petugas</th>
                                <th>Pesan</th>
                                <th>Bayar</th>
                                <th>Detail</th>
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

<!-- Modal Add -->
<div class="modal fade" id="LAPmodalDetail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Barang</h5>
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table w-100 table-bordered table-hover" id="tblbarang">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Harga Jual</th>
                            <th>Qty</th>
                            <th>Diskon</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="detailBarang">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Add -->

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

<script>
    var LAPreadUrl = '<?php echo base_url('laporan/readlapeceran') ?>';
    var LAPdetailurl = '<?php echo base_url('laporan/readdetail/') ?>';
    var TRGeditUrl = '<?php echo base_url('laporan/updatehutang') ?>';

    let url,
        lapEceran = $("#tbllapeceran").DataTable({
            responsive: !0,
            scrollX: !0,
            ajax: '<?php echo base_url('laporan/readlapmember') ?>',
            columnDefs: [{
                searcable: !1,
                orderable: !1,
                targets: 0
            }],
            order: [
                [1, "asc"]
            ],
            columns: [{
                    data: null
                },
                {
                    data: "member"
                },
                {
                    data: "jual_nofak"
                },
                {
                    data: "jual_tanggal"
                },
                {
                    data: "jual_total"
                },
                {
                    data: "jual_jml_uang"
                },
                {
                    data: "jual_kembalian"
                },
                {
                    data: "petugas"
                },
                {
                    data: "note"
                },
                {
                    data: "sts"
                },
                {
                    data: "action"
                },
            ],
            columnDefs: [{
                targets: [0],
                render: function(data, type, row) {
                    if (row.index > 2) {
                        return "<div style='background-color:red'>" + data + "<div>";
                    }
                    return data;
                },
            }, ],
        });

    function reloadTable() {
        lapEceran.ajax.reload();
    }

    function detail(a) {
        console.log(a);
        $("#LAPmodalDetail").modal("show");
        $("#detailBarang").load(LAPdetailurl + a);
    }

    function lunas(a) {
        console.log(a);
        $.ajax({
            url: TRGeditUrl,
            type: "post",
            dataType: "json",
            data: {
                jlStatus: a,
            },
            success: (a) => {
                console.log(a);
                lapEceran.ajax.reload();
            },
            error: (a) => {
                console.log(a);
            },
        });
    }

    lapEceran.on("order.dt search.dt", () => {
            lapEceran
                .column(0, {
                    search: "applied",
                    order: "applied"
                })
                .nodes()
                .each((a, e) => {
                    a.innerHTML = e + 1;
                });
        }),
        $("#form").validate({
            errorElement: "span",
            errorPlacement: (e, t) => {
                e.addClass("invalid-feedback"), t.closest(".form-group").append(a);
            },
            submitHandler: () => {
                "edit" == url ? editData() : addData();
            },
        }),
        $(".modal").on("hidden.bs.modal", () => {
            $("#form")[0].reset(), $("#form").validate().resetForm();
        });
</script>

</body>

</html>