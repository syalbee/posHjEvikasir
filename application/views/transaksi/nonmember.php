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
                    <a href="<?= base_url('transaksi_nonmember/resetcart'); ?>" class="btn btn-sm btn-danger">Reset Form</a>
                    <br>
                    <hr>
                    <form id="addTocartjual">
                        <table>
                            <tr>
                                <th>Nama Barang</th>
                            </tr>
                            <tr>
                                <th>
                                    <select style="width:200px;margin-right:5px;" name="kode_brg" id="kode_brg" class="form-control select2 col-sm-12">
                                    </select>
                                </th>
                            </tr>
                            <div id="detail_barang" style="position:absolute;">

                            </div>
                        </table>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table w-100 table-bordered table-hover" id="tblbarang">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th style="text-align:center;">Satuan</th>
                                <th style="text-align:center;">Harga(Rp)</th>
                                <th style="text-align:center;">Diskon(Rp)</th>
                                <th style="text-align:center;">Qty</th>
                                <th style="text-align:center;">Sub Total</th>
                                <th style="width:100px;text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="detail_cart">

                        </tbody>
                    </table>

                </div>
            </div>

            <form action="<?= base_url('transaksi_nonmember/simpan_penjualan'); ?>" method="POST">
                <table>
                    <tr>
                        <td style="width:760px;" rowspan="2"><button type="submit" class="btn btn-info btn-lg">Simpan</button></td>
                        <th style="width:140px;">Total Belanja(Rp)</th>
                        <th style="text-align:right;width:140px;"><input type="text" id="total2" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly></th>
                        <input type="hidden" id="total" name="total" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly>
                    </tr>
                    <tr>
                        <th>Tunai(Rp)</th>
                        <th style="text-align:right;"><input type="text" id="jml_uang" name="jml_uang" class="jml_uang form-control input-sm" style="text-align:right;margin-bottom:5px;" required></th>
                        <input type="hidden" id="jml_uang2" name="jml_uang2" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" required>
                    </tr>
                    <tr>
                        <td></td>
                        <th>Kembalian(Rp)</th>
                        <th style="text-align:right;"><input type="text" id="kembalian" name="kembalian" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly></th>
                    </tr>
                </table>
            </form>
            <hr />
        </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->

</div>

<!-- Modal show transaksi -->
<div class="modal fade" id="showBRGKg">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="title_modal" class="modal-title"></h5>
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <h5 id="titleKg"></h5> -->
                <!-- <form id="BRGkginsert"> -->
                <input type="hidden" id="idBarangs" name="idBarangs">
                <div class="form-group">
                    <!-- <label>QTY :</label> -->
                    <input id="qtyBarang" name="qtyBarang" type="text" onkeydown="addKeranjang()" class="form-control">
                </div>
                <!-- <button class="btn btn-success" onclick="addKeranjangkilo()" type="button">Tambah</button> -->
                <!-- </form> -->
            </div>
        </div>
    </div>
</div>
<!-- End Modal show Kg -->


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
<!-- Select2 -->
<script src="<?= base_url(); ?>assets/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="<?= base_url(); ?>assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="<?= base_url(); ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="<?= base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?= base_url(); ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="<?= base_url(); ?>assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="<?= base_url(); ?>assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="<?= base_url(); ?>assets/plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>assets/dist/js/adminlte.min.js"></script>
<script src="<?= base_url('assets/js/jquery.price_format.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>

<script type="text/javascript">
    function resultHasil() {
        // $(function() {
        $("#kode_brg")[0].focus();
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('transaksi_nonmember/readtotal'); ?>",
            success: function(msg) {
                console.log(msg);
                $('#total').val(msg);
                $('#total2').val(formatRupiah(msg));
            },
            error: (a) => {
                console.log(a);
            },
        });

        $('#jml_uang').on("input", function() {
            var total = $('#total').val();
            var jumuang = $('#jml_uang').val();
            var hsl = jumuang.replace(/[^\d]/g, "");
            $('#jml_uang2').val(hsl);
            $('#kembalian').val(hsl - total);
        })

        $('.jml_uang').priceFormat({
            prefix: '',
            //centsSeparator: '',
            centsLimit: 0,
            thousandsSeparator: ','
        });
        $('#jml_uang2').priceFormat({
            prefix: '',
            //centsSeparator: '',
            centsLimit: 0,
            thousandsSeparator: ''
        });
        $('#kembalian').priceFormat({
            prefix: '',
            //centsSeparator: '',
            centsLimit: 0,
            thousandsSeparator: ','
        });
        $('.harjul').priceFormat({
            prefix: '',
            //centsSeparator: '',
            centsLimit: 0,
            thousandsSeparator: ','
        });
        // });
    }

    function formatRupiah(bilangan) {
        var reverse = bilangan.toString().split("").reverse().join(""),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join(".").split("").reverse().join("");

        if (bilangan < 0) {
            return "Rp. " + bilangan;
        } else {
            return "Rp. " + ribuan;
        }
    }


    // reload dat from chart
    $('#detail_cart').load("<?= site_url('transaksi_nonmember/read'); ?>");
    resultHasil();
    window.onload = onLoadPage();


    // Get barang on load
    function onLoadPage() {
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        $("#kode_brg").select2({
            placeholder: "Nama Barang",
            ajax: {
                url: '<?php echo site_url('barang/get_barcode') ?>',
                type: "post",
                dataType: "json",
                data: (params) => ({
                    barcode: params.term,
                }),
                success: function(msg) {
                    $('#detail_barang').html(msg);
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
    }

    // Tentuin jenis transaksi
    var cekGrosir = false;
    document
        .addEventListener("keydown", e => {
            if (e.key === "F4" || e.key === "F9") {
                cekGrosir = true;
                e.preventDefault()
            }
        });

    // Buat nampilin modal setelah search barang
    $("#kode_brg")[0].focus();
    $(document).ready(function() {

        $("#kode_brg").focus();
        $("#kode_brg").on("input", function() {
            var kobar = {
                kode_brg: $(this).val()
            };
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('transaksi_nonmember/get_barang'); ?>",
                data: kobar,
                success: function(msg) {
                    const obj = JSON.parse(msg);
                    $("#title_modal").html(obj['barang_nama']);
                    $("#idBarangs").val(obj['barang_id']);
                    $("#showBRGKg").modal("show");
                    $('#showBRGKg').on('shown.bs.modal', function() {
                        $('#qtyBarang').focus();
                        $("#qtyBarang").val("");
                    });
                },
                error(a) {
                    console.log(a);
                }
            });
        });

    });

    // Untuk masukin ke keranjang
    function addKeranjang() {
        if (event.key === 'Enter') {
            var jenisTransaksi = "";
            if (cekGrosir == true) {
                jenisTransaksi = "grosir";
            } else {
                jenisTransaksi = "eceran";
            }
            $.ajax({
                url: "<?= base_url('transaksi_nonmember/add_to_cart'); ?>",
                type: "POST",
                data: {
                    jenisTR: jenisTransaksi,
                    Barangid: $("#idBarangs").val(),
                    Barangqty: $("#qtyBarang").val(),
                },
                success: (a) => {
                    cekGrosir = false;
                    $('#detail_cart').load("<?= site_url('transaksi_nonmember/read'); ?>");
                    resultHasil();
                    $("#showBRGKg").modal("hide");
                    $('#kode_brg').empty();
                },
                error: (a) => {
                    console.log('e' + a);
                },
            });
        }
    }

    // Edit item cart
    $(document).ready(function() {
        $("#tblbarang").on('click', '.edit_cart', function() {
            var currentRow = $(this).closest("tr");
            var brgid = currentRow.find('#BRGiD').val();
            var brgprice = currentRow.find('#BRGprice').val();
            var brgdisc = currentRow.find('#etdisc').val();
            var brgqty = currentRow.find('#etqty').val();

            $.ajax({
                url: "<?php echo base_url(); ?>transaksi_nonmember/edit",
                method: "POST",
                data: {
                    diskon: brgdisc,
                    qty: brgqty,
                    price: brgprice,
                    row_id: brgid
                },
                success: function(data) {
                    $('#detail_cart').load("<?= site_url('transaksi_nonmember/read'); ?>");
                    resultHasil();
                }
            });
        });
    });

    //Hapus Item Cart
    $(document).on('click', '.hapus_cart', function() {
        var row_id = $(this).attr("id"); //mengambil row_id dari artibut id
        $.ajax({
            url: "<?php echo base_url(); ?>transaksi_nonmember/remove",
            method: "POST",
            data: {
                row_id: row_id
            },
            success: function(data) {
                $('#detail_cart').load("<?= site_url('transaksi_nonmember/read'); ?>");
                resultHasil();
            }
        });
    });

    // Buat edit dll
    function search(ele) {
        if (event.key === 'Enter') {
            $('.edit_cart').click();
            $("#kode_brg")[0].focus();
        }
    }
</script>

</body>

</html>