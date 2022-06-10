let url,
  barang = $("#tblbarang").DataTable({
    responsive: !0,
    scrollX: !0,
    ajax: BRGreadUrl,
    columnDefs: [{ searcable: !1, orderable: !1, targets: 0 }],
    order: [[1, "asc"]],
    columns: [
      { data: null },
      { data: "barang_nama" },
      { data: "barang_harpok_grosir" },
      { data: "barang_harpok_eceran" },
      { data: "barang_harjul_grosir" },
      { data: "barang_harjul_eceran" },
      { data: "barang_harjul_grosir_m" },
      { data: "barang_harjul_eceran_m" },
      { data: "barang_stok" },
      { data: "barang_min_stok" },
      { data: "action" },
    ],columnDefs: [{
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
  barang.ajax.reload();
}

function addData() {
  $.ajax({
    url: BRGaddUrl,
    type: "post",
    dataType: "json",
    data: $("#BRformadd").serialize(),
    success: () => {
      $(".modal").modal("hide"),
        Swal.fire("Sukses", "Sukses Menambahkan Barang", "success"),
        reloadTable();
      $("#BRformadd")[0].reset();
    },
    error: (a) => {
      console.log(a);
    },
  });
}

function remove(a) {
  console.log(a);
  Swal.fire({
    title: "Konfirmasi Hapus ?",
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: "Save",
    denyButtonText: `Close`,
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: BRGremoveUrl,
        type: "post",
        dataType: "json",
        data: { id: a },
        success: () => {
          Swal.fire("Sukses", "Sukses Menghapus Barang", "success"),
            reloadTable();
        },
        error: (a) => {
          console.log(a);
        },
      });
    } else if (result.isDenied) {
      Swal.fire("Changes are not saved", "", "info");
    }
  });
}

function editData() {
  $.ajax({
    url: BRGeditUrl,
    type: "post",
    dataType: "json",
    data: $("#BRformedit").serialize(),
    success: () => {
      $(".modal").modal("hide"),
        Swal.fire("Sukses", "Sukses Mengedit Barang", "success"),
        reloadTable();
    },
    error: (a) => {
      console.log(a);
    },
  });
}

function edit(a) {
  window.location.href = BRGget_barangUrl + "/" + a;
  // $.ajax({
  //   url: BRGget_barangUrl,
  //   type: "post",
  //   dataType: "json",
  //   data: { id: a },
  //   success: (a) => {
  //     console.log(a);
  //     $('[name="kobar"]').val(a.barang_id),
  //       // $('[name="barcode"]').val(a.barcode),
  //       $('[name="nabar"]').val(a.barang_nama),
  //       $('[name="harpok"]').val(a.barang_harpok),
  //       $('[name="harjul_grosir"]').val(a.barang_harjul_grosir),
  //       $('[name="harjul"]').val(a.barang_harjul),
  //       $('[name="min_stok"]').val(a.barang_min_stok),
  //       $("#BRmodaledit").modal("show"),
  //       (url = "edit");
  //   },
  //   error: (a) => {
  //     console.log(a);
  //   },
  // });
}

barang.on("order.dt search.dt", () => {
  barang
    .column(0, { search: "applied", order: "applied" })
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
