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
                    <table class="table w-100 table-bordered table-hover" id="tblPengeluaran">
                        <thead>
                            <tr>
                            <tr>
                                <th style="text-align:center;width:40px;">No</th>
                                <th>Tanggal/waktu</th>
                                <th>Nama Pengeluaran</th>
                                <th>Jumlah Pengeluaran</th>
                                <th>Keterangan</th>
                            </tr>
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
    var dataMSG = '<?= $this->session->flashdata('msgPengeluaran'); ?>';
    if (dataMSG.length != 0) {
        if (dataMSG === "save") {
            Swal.fire("Sukses", "Sukses Tambah Pengeluaran", "success");
        }
        dataMSG = "";
    }

    window.onload = function() {
        document.getElementById('btnSidebar').click();
        document.getElementById('headTable').click();
    }

    let url,
        lapDbar = $("#tblPengeluaran").DataTable({
            responsive: !0,
            scrollX: !0,
            ajax: '<?php echo base_url('laporan/readpengeluarantable') ?>',
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
                    data: "tanggal"
                },
                {
                    data: "nama"
                },
                {
                    data: "jumlah"
                },
                {
                    data: "keterangan"
                },
            ],
        });

    function reloadTable() {
        lapDbar.ajax.reload();
    }

    lapDbar.on("order.dt search.dt", () => {
            lapDbar
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