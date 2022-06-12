<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') !== 'login') {
            redirect('login');
        }
        $this->load->model('m_penjualan');
        $this->load->model('m_pelanggan');
        $this->load->library('escpos');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function struk($id)
    {
        $connector = new Escpos\PrintConnectors\WindowsPrintConnector('printer_a');
        $printer = new Escpos\Printer($connector);

        $this->db->where('d_jual_nofak', $id);
        $produk = $this->db->get('tbl_detail_jual')->result();

        $this->db->where('jual_nofak', $id);
        $transaksi = $this->db->get('tbl_jual')->result();
        $date = new DateTime($transaksi[0]->jual_tanggal);

        $this->db->select('tbl_user.user_nama as kasir');
        $this->db->from('tbl_user');
        $this->db->join('tbl_jual', 'tbl_jual.jual_user_id = tbl_user.user_id');
        $this->db->where('tbl_jual.jual_nofak', $id);
        $kasir = $this->db->get()->result();

        $diskonSum = 0;

        $printer->initialize();
        $printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
        $printer->setFont(Escpos\Printer::FONT_A);
        $printer->text($this->db->get('tbl_toko')->result()[0]->nama . "\n");
        $printer->text("\n");
        $printer->text($this->db->get('tbl_toko')->result()[0]->alamat . "\n");
        $printer->text("\n");
        $printer->text($this->db->get('tbl_toko')->result()[0]->noTelp . "\n");
        $printer->text("-------------------------------");

        $printer->initialize();
        $printer->setJustification(Escpos\Printer::JUSTIFY_LEFT);
        $printer->text("No Nota : " . $transaksi[0]->jual_nofak . "\n");
        $printer->text("Tanggal : " . $date->format('d/m/y H:i') . "\n");
        $printer->text("Kasir   : " . $kasir[0]->kasir . "\n");

        if (!empty($transaksi[0]->jual_member_id)) {

            $this->db->select('nama, point');
            $this->db->where('id', $transaksi[0]->jual_member_id);
            $pelanggan = $this->db->get('tbl_member')->result();

            $printer->text("Nama    : " . $pelanggan[0]->nama . "\n");
        }

        $printer->text("-------------------------------");
        $printer->text("\n");

        foreach ($produk as $key) {

            $printer->initialize();
            $printer->setFont(Escpos\Printer::FONT_A);
            $printer->text($key->d_jual_barang_nama . " \n");

            if ($key->d_jual_diskon !== "0") {
                $diskonSum += ($key->d_jual_diskon * $key->d_jual_banyaknya) * $key->d_jual_qty;
                $printer->text($key->d_jual_qty . " " . $key->d_jual_barang_satuan . " * " . $key->d_jual_banyaknya, "", "-" . ($key->d_jual_diskon * $key->d_jual_banyaknya) * $key->d_jual_qty, $key->d_jual_total);
            } else {
                $printer->text($this->buatBaris4Kolom($key->d_jual_qty . " " . $key->d_jual_barang_satuan . " * " . $key->d_jual_banyaknya, "", "     ", $key->d_jual_total));
            }

            $printer->initialize();
            $printer->setFont(Escpos\Printer::FONT_A);
        }

        $printer->text("-------------------------------");
        $printer->text("\n");

        $printer->text("Total   : " . $transaksi[0]->jual_total . "\n");
        $printer->text("Tunai   : " . $transaksi[0]->jual_jml_uang . "\n");
        $printer->text("Kembali : " . $transaksi[0]->jual_kembalian . "\n");
        $printer->text("Diskon : " .  $diskonSum . "\n");
        $printer->text("\n");

        $printer->initialize();
        $printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
        $printer->text("TERIMA KASIH \n");

        $printer->feed(2); // mencetak 2 baris kosong, agar kertas terangkat ke atas
        $printer->close();
    }

    private function buatBaris4Kolom($kolom1, $kolom2, $kolom3, $kolom4)
    {
        // Mengatur lebar setiap kolom (dalam satuan karakter)
        $lebar_kolom_1 = 12;
        $lebar_kolom_2 = 3;
        $lebar_kolom_3 = 13;
        $lebar_kolom_4 = 9;

        // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
        $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
        $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
        $kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);
        $kolom4 = wordwrap($kolom4, $lebar_kolom_4, "\n", true);

        // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
        $kolom1Array = explode("\n", $kolom1);
        $kolom2Array = explode("\n", $kolom2);
        $kolom3Array = explode("\n", $kolom3);
        $kolom4Array = explode("\n", $kolom4);

        // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
        $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array), count($kolom4Array));

        // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
        $hasilBaris = array();

        // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
        for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

            // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
            $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
            $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ");

            // memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
            $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);
            $hasilKolom4 = str_pad((isset($kolom4Array[$i]) ? $kolom4Array[$i] : ""), $lebar_kolom_4, " ", STR_PAD_LEFT);

            // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
            $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3 . " " . $hasilKolom4;
        }

        // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
        return implode("\n", $hasilBaris) . "\n";
    }
}
// public function coba($id)
    // {

    //     $this->db->where('d_jual_nofak', $id);
    //     $produk = $this->db->get('tbl_detail_jual')->result();

    //     $this->db->where('jual_nofak', $id);
    //     $transaksi = $this->db->get('tbl_jual')->result();
    //     $date = new DateTime($transaksi[0]->jual_tanggal);

    //     $this->db->select('tbl_user.user_nama as kasir');
    //     $this->db->from('tbl_user');
    //     $this->db->join('tbl_jual', 'tbl_jual.jual_user_id = tbl_user.user_id');
    //     $this->db->where('tbl_jual.jual_nofak', $id);
    //     $kasir = $this->db->get()->result();

    //     $diskonSum = 0;

    //     echo $this->db->get('tbl_toko')->result()[0]->nama . "<br>";
    //     echo "<br>";
    //     echo $this->db->get('tbl_toko')->result()[0]->alamat . "<br>";
    //     echo "<br>";
    //     echo $this->db->get('tbl_toko')->result()[0]->noTelp . "<br>";
    //     echo "------------------------------- <br>";

    //     echo "No Nota : " . $transaksi[0]->jual_nofak . "<br>";
    //     echo "Tanggal : " . $date->format('d/m/y H:i') . "<br>";
    //     echo "Kasir   : " . $kasir[0]->kasir . "<br>";

    //     if (!empty($transaksi[0]->jual_member_id)) {
    //         $this->db->select('nama, point');
    //         $this->db->where('id', $transaksi[0]->jual_member_id);
    //         $pelanggan = $this->db->get('tbl_member')->result();
    //         echo "Pelanggan    : " . $pelanggan[0]->nama . "<br>";
    //     }

    //     echo "-------------------------------";
    //     echo "<br>";

    //     foreach ($produk as $key) {

    //         $diskonSum += ($key->d_jual_diskon * $key->d_jual_banyaknya) * $key->d_jual_qty;

    //         echo $key->d_jual_barang_nama . "  \n";
    //         echo "<br>";
    //         if ($key->d_jual_diskon !== "0") {
    //             echo $this->buatBaris4Kolom($key->d_jual_qty . " " . $key->d_jual_barang_satuan . " * " . $key->d_jual_banyaknya, "", "-" . ($key->d_jual_diskon * $key->d_jual_banyaknya) * $key->d_jual_qty, $key->d_jual_total);
    //         } else {
    //             echo $this->buatBaris4Kolom($key->d_jual_qty . " " . $key->d_jual_barang_satuan . " * " . $key->d_jual_banyaknya, "", "     ", $key->d_jual_total);
    //         }
    //         echo "<br>";
    //     }

    //     echo "-------------------------------";
    //     echo "<br>";

    //     echo "Total   : " . $transaksi[0]->jual_total . "<br>";
    //     echo "Tunai   : " . $transaksi[0]->jual_jml_uang . "<br>";
    //     echo "Kembali : " . $transaksi[0]->jual_kembalian . "<br>";
    //     echo "Diskon : " .  $diskonSum . "<br>";
    //     echo "<br>";


    //     echo "TERIMA KASIH \n";
    // }