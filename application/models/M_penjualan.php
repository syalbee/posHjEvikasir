<?php
defined('BASEPATH') or exit('No direct script access allowed');


class M_penjualan extends CI_Model
{

    function hapus_retur($kode)
    {
        $hsl = $this->db->query("DELETE FROM tbl_retur WHERE retur_id='$kode'");
        return $hsl;
    }

    function tampil_retur()
    {
        $hsl = $this->db->query("SELECT retur_id,DATE_FORMAT(retur_tanggal,'%d/%m/%Y') AS retur_tanggal,retur_barang_id,retur_barang_nama,retur_barang_satuan,retur_harjul,retur_qty,(retur_harjul*retur_qty) AS retur_subtotal,retur_keterangan FROM tbl_retur ORDER BY retur_id DESC");
        return $hsl;
    }

    function simpan_retur($kobar, $nabar, $satuan, $harjul, $qty, $keterangan)
    {
        $hsl = $this->db->query("INSERT INTO tbl_retur(retur_barang_id,retur_barang_nama,retur_barang_satuan,retur_harjul,retur_qty,retur_keterangan) 
                                 VALUES ('$kobar','$nabar','$satuan','$harjul','$qty','$keterangan')");
        return $hsl;
    }

    function simpan_penjualannon($nofak, $total, $jml_uang, $kembalian)
    {
        $idadmin = $this->session->userdata('idadmin');

        $dataJual = array(
            "jual_nofak"      => $nofak,
            "jual_total"      => $total,
            "jual_jml_uang"   => $jml_uang,
            "jual_kembalian"  => $kembalian,
            "jual_user_id"    => $idadmin,
            "jual_keterangan" => "nonmember",
            "jual_member_id"  => NULL,
            "jual_deskripsi"  => NULL,
            "jual_status"     => "0"
        );
        $this->db->insert('tbl_jual', $dataJual);

        foreach ($this->cart->contents() as $item) {
            $data = array(
                'd_jual_nofak'          =>    $nofak,
                'd_jual_barang_id'      =>    $item['kodeBrg'],
                'd_jual_barang_nama'    =>    $item['name'],
                'd_jual_barang_satuan'  =>    $item['satuan'],
                'd_jual_barang_harpok'  =>    $item['harpok'],
                'd_jual_barang_harjul'  =>    $item['amount'],
                'd_jual_qty'            =>    $item['qty'],
                'd_jual_diskon'         =>    $item['disc'],
                'd_jual_total'          =>    $item['subtotal']
            );
            $this->db->insert('tbl_detail_jual', $data);
            $this->_hitungQty($item['kodeBrg'], $item['qty'],  $item['jenis']);
        }

        return true;
    }

    function simpan_penjualan($nofak, $total, $jml_uang, $kembalian, $pelanggan, $pesan, $stsBayar)
    {
        $idadmin = $this->session->userdata('idadmin');

        $dataJual = array(
            "jual_nofak"      => $nofak,
            "jual_total"      => $total,
            "jual_jml_uang"   => $jml_uang,
            "jual_kembalian"  => $kembalian,
            "jual_user_id"    => $idadmin,
            "jual_keterangan" => "member",
            "jual_member_id"  => $this->_getIdmember($pelanggan),
            "jual_deskripsi"  => $pesan,
            "jual_status"     => $stsBayar
        );
        $this->db->insert('tbl_jual', $dataJual);

        foreach ($this->cart->contents() as $item) {
            $data = array(
                'd_jual_nofak'          =>    $nofak,
                'd_jual_barang_id'      =>    $item['kodeBrg'],
                'd_jual_barang_nama'    =>    $item['name'],
                'd_jual_barang_satuan'  =>    $item['satuan'],
                'd_jual_barang_harpok'  =>    $item['harpok'],
                'd_jual_barang_harjul'  =>    $item['amount'],
                'd_jual_qty'            =>    $item['qty'],
                'd_jual_diskon'         =>    $item['disc'],
                'd_jual_total'          =>    $item['subtotal']
            );
            $this->db->insert('tbl_detail_jual', $data);
            $this->_hitungQty($item['kodeBrg'], $item['qty'],  $item['jenis']);
        }

        return true;
    }

    function get_nofak()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(jual_nofak,6)) AS kd_max FROM tbl_jual WHERE DATE(jual_tanggal)=CURDATE()");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%06s", $tmp);
            }
        } else {
            $kd = "000001";
        }

        return date('dmy') . $kd;
    }

    function cetak_faktur()
    {
        $nofak = $this->session->userdata('nofak');
        $hsl = $this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,jual_total,jual_jml_uang,jual_kembalian,jual_keterangan,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE jual_nofak='$nofak'");
        return $hsl;
    }

    private function _hitungQty($id, $qty, $jenis)
    {
        $this->db->where('barang_id', $id);
        $qtyBarang = $this->db->get('tbl_barang')->result_array()[0]['barang_min_stok'];

        if ($jenis === "grosir") {
            $jumlah =  $qty;
        } else {
            $jumlah =  $qty / $qtyBarang;
        }
        $this->db->query("UPDATE tbl_barang SET barang_stok = barang_stok -$jumlah WHERE barang_id='$id'");
    }

    private function _getIdmember($kode)
    {
       return $this->db->query("SELECT id FROM tbl_member WHERE kode = '$kode'")->result_array()[0]['id'];
    }
}
