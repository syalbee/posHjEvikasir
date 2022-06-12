<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') != TRUE) {
            $url = base_url();
            redirect($url);
        };
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('m_kategori');
        $this->load->model('m_barang');
        $this->load->model('m_suplier');
        $this->load->model('m_pembelian');
        $this->load->model('m_penjualan');
        $this->load->model('m_laporan');
        $this->load->model('m_satuan');
    }


    public function index()
    {

        if ($this->session->userdata('akses') == '1' || $this->session->userdata('akses') == '2') {
            $data = [
                'title' => "Laporan",
                'toko' => "Toko Hj Evi",
                'nama' => $this->session->userdata('nama'),
                'data' => $this->m_barang->tampil_barang(),
                'kat' => $this->m_kategori->tampil_kategori(),
                'jual_bln' => $this->m_laporan->get_bulan_jual(),
                'jual_thn' => $this->m_laporan->get_tahun_jual(),
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('admin/laporan', $data);
        } else {
            echo "Halaman tidak ditemukan";
        }
    }

    public function readLapmember()
    {
        header('Content-type: application/json');
        $iterasi = 1;
        if ($this->m_laporan->readMember()->num_rows() > 0) {
            foreach ($this->m_laporan->readMember()->result() as $lapMember) {
                if (!empty($lapMember->jual_member_id)) {
                    $idTran = (string)$lapMember->jual_nofak;
                    $data[] = array(
                        'no' => $iterasi++,
                        'member' => $this->_getMeber($lapMember->jual_member_id),
                        'jual_nofak' => $idTran,
                        'jual_tanggal' => $lapMember->jual_tanggal,
                        'jual_total' => $lapMember->jual_total,
                        'jual_jml_uang' => $lapMember->jual_jml_uang,
                        'jual_kembalian' => $lapMember->jual_kembalian,
                        'petugas' => $this->getPetugas($lapMember->jual_user_id),
                        'note' => $lapMember->jual_deskripsi,
                        'sts' => $lapMember->jual_status === '1' ? "<h6 class='alert alert-danger'>Hutang</h6>" : "<h6 class='alert alert-success'>Lunas</h6>",
                        'jual_utang' => $lapMember->jual_utang,
                        'action' => '<button class="btn btn-sm btn-warning" onclick="detail(\'' . $lapMember->jual_nofak . '\')"><i class="fas fa-edit"></i></button> &nbsp; <button class="btn btn-sm btn-primary" onclick="lunas(\'' . $lapMember->jual_nofak . '\')"><i class="fas fa-check"></i></button>',
                    );
                }
            }
        } else {
            $data = array();
        }
        $lapdataMember = array(
            'data' => $data
        );
        echo json_encode($lapdataMember);
    }

    public function readLapnonmember()
    {
        header('Content-type: application/json');
        $iterasi = 1;
        if ($this->m_laporan->readnonMember()->num_rows() > 0) {
            foreach ($this->m_laporan->readnonMember()->result() as $all) {
                if (empty($all->jual_member_id)) {
                    $idTran = (string)$all->jual_nofak;
                    $data[] = array(
                        'no' => $iterasi++,
                        'jual_nofak' => $idTran,
                        'jual_tanggal' => $all->jual_tanggal,
                        'jual_total' => $all->jual_total,
                        'jual_jml_uang' => $all->jual_jml_uang,
                        'jual_kembalian' => $all->jual_kembalian,
                        'petugas' => $this->getPetugas($all->jual_user_id),
                        'action' => '<button class="btn btn-sm btn-warning" onclick="detail(\'' . $all->jual_nofak . '\')"><i class="fas fa-edit"></i></button>',
                    );
                }
            }
        } else {
            $data = array();
        }
        $lapdatanonMember = array(
            'data' => $data
        );
        echo json_encode($lapdatanonMember);
    }

    public function readDetail($readDetail)
    {
        $output = '';
        $i = 1;
        foreach ($this->m_laporan->readDetail($readDetail)->result_array() as $items) {
            $output .=
                '<tr>
                <td>' . $i . ' </td>
                <td>' . $items['d_jual_barang_nama'] . ' </td>
                <td>' . $items['d_jual_barang_harjul'] . ' </td>
                <td>' . $items['d_jual_qty'] . ' </td>
                <td>' . $items['d_jual_barang_satuan'] . ' </td>
                <td>' . $items['d_jual_diskon'] . ' </td>
                <td>' . $items['d_jual_banyaknya'] . ' </td>
                <td>' . $items['d_jual_total'] . ' </td>
                <td>' . $this->_keuntunganbrg($items['d_jual_nofak'],$items['d_jual_id']) . ' </td>
            </tr>';
            $i++;
        }
        echo $output;
    }

    public function updateHutang()
    {
        $id = $this->input->post('jlStatus');

        $data = array(
            'jual_status' => '0',
            'jual_utang' => $this->session->userdata('nama') . " | " . date("y-m-d H:i"),
        );

        $this->db->where('jual_nofak', $id);
        if ($this->db->update('tbl_jual', $data)) {
            echo json_encode("Sukses");
        }
    }

    public function lapMember()
    {
        if ($this->session->userdata('akses') == '1') {

            $data = [
                'title' => "Laporan Penjualan Member",
                'toko' => $this->db->get('tbl_toko')->result_array()[0]['nama'],
                'nama' => $this->session->userdata('nama'),
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('laporan/member', $data);
        } else {
            echo "Halaman tidak ditemukan";
        }
    }

    public function lapnonMember()
    {
        if ($this->session->userdata('akses') == '1') {

            $data = [
                'title' => "Laporan Penjualan Non Member",
                'toko' => $this->db->get('tbl_toko')->result_array()[0]['nama'],
                'nama' => $this->session->userdata('nama'),
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('laporan/nonmember', $data);
        } else {
            echo "Halaman tidak ditemukan";
        }
    }


    public function lapdBarang()
    {
        if ($this->session->userdata('akses') == '1') {

            $data = [
                'title' => "Laporan Data Barang",
                'toko' => $this->db->get('tbl_toko')->result_array()[0]['nama'],
                'nama' => $this->session->userdata('nama'),
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('laporan/databarang', $data);
        } else {
            echo "Halaman tidak ditemukan";
        }
    }

    public function lapHarian()
    {
        if ($this->session->userdata('akses') == '1') {

            $data = [
                'title' => "Laporan Penjualan Harian - " . date("D-M-Y"),
                'toko' => $this->db->get('tbl_toko')->result_array()[0]['nama'],
                'nama' => $this->session->userdata('nama'),
                'totalJual' => $this->_pendapatanJual(date("Y-m-d"))['total'],
                'keuntungan' =>  $this->_getKeuntungan(date("Y-m-d"))
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('laporan/lapharian', $data);
        } else {
            echo "Halaman tidak ditemukan";
        }
    }

    public function getAlltrans()
    {
        if ($this->session->userdata('akses') == '1') {

            $data = [
                'title' => "Laporan Penjualan",
                'toko' => $this->db->get('tbl_toko')->result_array()[0]['nama'],
                'nama' => $this->session->userdata('nama'),
                'totalJual' => $this->_pendapatanJualall()['total'],
                'keuntungan' => $this->_getKeuntunganall()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('laporan/alltransaksi', $data);
        } else {
            echo "Halaman tidak ditemukan";
        }
    }

    public function getTranstgl()
    {

        if ($this->session->userdata('akses') == '1') {

            $tanggal = $this->input->post('tgl');
            $tanggal = date("Y-m-d", strtotime($tanggal));

            $data = [
                'title' => "Laporan Penjualan Pertanggal "  . $tanggal,
                'toko' => $this->db->get('tbl_toko')->result_array()[0]['nama'],
                'nama' => $this->session->userdata('nama'),
                'totalJual' => $this->_pendapatanJual($tanggal)['total'],
                'keuntungan' =>  $this->_getKeuntungan($tanggal),
                'tgl' => $tanggal
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('laporan/laporanpertgl', $data);
        } else {
            echo "Halaman tidak ditemukan";
        }
    }

    public function readAlltrans()
    {
        header('Content-type: application/json');
        $iterasi = 1;
        if ($this->m_laporan->allTransaksi()->num_rows() > 0) {
            foreach ($this->m_laporan->allTransaksi()->result() as $Alltrans) {
                $idTran = (string)$Alltrans->jual_nofak;
                $data[] = array(
                    'no' => $iterasi++,
                    'jual_nofak' => $idTran,
                    'jual_member' => $this->_getMeber($Alltrans->jual_member_id),
                    'jual_total' => $Alltrans->jual_total,
                    'jual_jml_uang' => $Alltrans->jual_jml_uang,
                    'jual_kembalian' => $Alltrans->jual_kembalian,
                    'petugas' => $this->getPetugas($Alltrans->jual_user_id),
                    'pesan' => $Alltrans->jual_deskripsi,
                    'keuntungan' => $this->_keuntungan($idTran),
                    'action' => '<button class="btn btn-sm btn-warning" onclick="detail(\'' . $Alltrans->jual_nofak . '\')"><i class="fas fa-edit"></i></button>',
                );
            }
        } else {
            $data = array();
        }
        $lapdatanonMember = array(
            'data' => $data
        );
        echo json_encode($lapdatanonMember);
    }

    public function readTgltrans($tanggal)
    {
        header('Content-type: application/json');
        $iterasi = 1;
        if ($this->m_laporan->getHariini($tanggal)->num_rows() > 0) {
            foreach ($this->m_laporan->getHariini($tanggal)->result() as $Alltrans) {
                $idTran = (string)$Alltrans->jual_nofak;
                $data[] = array(
                    'no' => $iterasi++,
                    'jual_nofak' => $idTran,
                    'jual_member' => $this->_getMeber($Alltrans->jual_member_id),
                    'jual_total' => $Alltrans->jual_total,
                    'jual_jml_uang' => $Alltrans->jual_jml_uang,
                    'jual_kembalian' => $Alltrans->jual_kembalian,
                    'petugas' => $this->getPetugas($Alltrans->jual_user_id),
                    'pesan' => $Alltrans->jual_deskripsi,
                    'keuntungan' => $this->_keuntungan($idTran),
                    'action' => '<button class="btn btn-sm btn-warning" onclick="detail(\'' . $Alltrans->jual_nofak . '\')"><i class="fas fa-edit"></i></button>',
                );
            }
        } else {
            $data = array();
        }
        $lapdatanonMember = array(
            'data' => $data
        );
        echo json_encode($lapdatanonMember);
    }

    public function readharini()
    {
        header('Content-type: application/json');
        $iterasi = 1;
        if ($this->m_laporan->getHariini(date('Y-m-d'))->num_rows() > 0) {
            foreach ($this->m_laporan->getHariini(date('Y-m-d'))->result() as $creadharinini) {
                $idTran = (string)$creadharinini->jual_nofak;
                $data[] = array(
                    'no' => $iterasi++,
                    'jual_nofak' => $idTran,
                    'jual_member' => $this->_getMeber($creadharinini->jual_member_id),
                    'jual_total' => $creadharinini->jual_total,
                    'jual_jml_uang' => $creadharinini->jual_jml_uang,
                    'jual_kembalian' => $creadharinini->jual_kembalian,
                    'petugas' => $this->getPetugas($creadharinini->jual_user_id),
                    'pesan' => $creadharinini->jual_deskripsi,
                    'keuntungan' => $this->_keuntungan($idTran),
                    'action' => '<button class="btn btn-sm btn-warning" onclick="detail(\'' . $creadharinini->jual_nofak . '\')"><i class="fas fa-edit"></i></button>',
                );
            }
        } else {
            $data = array();
        }
        $readHari = array(
            'data' => $data
        );

        echo json_encode($readHari);
    }

    public function readallTran()
    {
        header('Content-type: application/json');
        $iterasi = 1;
        if ($this->m_laporan->allTransaksi()->num_rows() > 0) {
            foreach ($this->m_laporan->allTransaksi()->result() as $creadharinini) {
                $idTran = (string)$creadharinini->jual_nofak;
                $data[] = array(
                    'no' => $iterasi++,
                    'jual_nofak' => $idTran,
                    'jual_member' => $this->_getMeber($creadharinini->jual_member_id),
                    'jual_total' => $creadharinini->jual_total,
                    'jual_jml_uang' => $creadharinini->jual_jml_uang,
                    'jual_kembalian' => $creadharinini->jual_kembalian,
                    'petugas' => $this->getPetugas($creadharinini->jual_user_id),
                    'pesan' => $creadharinini->jual_deskripsi,
                    'keuntungan' => $this->_keuntungan($idTran),
                    'action' => '<button class="btn btn-sm btn-warning" onclick="detail(\'' . $creadharinini->jual_nofak . '\')"><i class="fas fa-edit"></i></button>',
                );
            }
        } else {
            $data = array();
        }
        $readHari = array(
            'data' => $data
        );

        echo json_encode($readHari);
    }

    public function getbulan()
    {
        if ($this->session->userdata('akses') == '1') {
            $bulan = $this->input->post('bln');
            $data = [
                'title' => "Laporan Penjualan Perbulan " . $bulan,
                'toko' => $this->db->get('tbl_toko')->result_array()[0]['nama'],
                'nama' => $this->session->userdata('nama'),
                'totalJual' => $this->_keuntunganbln($bulan)[0]['total'],
                'keuntungan' => $this-> _getKeuntunganbln($bulan),
                'bln' =>  str_replace(" ", "_", $bulan),
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('laporan/laporanperbln', $data);
        } else {
            echo "Halaman tidak ditemukan";
        }
    }

    public function readTranbln($bulan)
    {
        header('Content-type: application/json');
        $bulan = str_replace("_", " ", $bulan);
        $iterasi = 1;
        if ($this->m_laporan->get_jual_perbulan($bulan)->num_rows() > 0) {
            foreach ($this->m_laporan->get_jual_perbulan($bulan)->result() as $readBln) {
                $idTran = (string)$readBln->jual_nofak;
                $data[] = array(
                    'no' => $iterasi++,
                    'jual_nofak' => $idTran,
                    'jual_member' => $this->_getMeber($readBln->jual_member_id),
                    'jual_total' => $readBln->jual_total,
                    'jual_jml_uang' => $readBln->jual_jml_uang,
                    'jual_kembalian' => $readBln->jual_kembalian,
                    'petugas' => $this->getPetugas($readBln->jual_user_id),
                    'pesan' => $readBln->jual_deskripsi,
                    'keuntungan' => $this->_keuntungan($idTran),
                    'action' => '<button class="btn btn-sm btn-warning" onclick="detail(\'' . $readBln->jual_nofak . '\')"><i class="fas fa-edit"></i></button>',
                );
            }
        } else {
            $data = array();
        }
        $readHari = array(
            'data' => $data
        );

        echo json_encode($readHari);
    }

    public function gettahun()
    {
        if ($this->session->userdata('akses') == '1') {
            $tahun = $this->input->post('thn');
            $data = [
                'title' => "Laporan Penjualan Pertahun " . $tahun,
                'toko' => $this->db->get('tbl_toko')->result_array()[0]['nama'],
                'nama' => $this->session->userdata('nama'),
                'totalJual' => $this->m_laporan->get_total_jual_pertahun($tahun)->result_array()[0]['total'],
                'keuntungan' => $this-> _getKeuntunganthn($tahun),
                'thn' =>  str_replace(" ", "_", $tahun),
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('laporan/laporanperthn', $data);
        } else {
            echo "Halaman tidak ditemukan";
        }
    }

    public function readTranthn($tahun)
    {
        header('Content-type: application/json');
        $tahun = str_replace("_", " ", $tahun);
        $iterasi = 1;
        if ($this->m_laporan->get_jual_pertahun($tahun)->num_rows() > 0) {
            foreach ($this->m_laporan->get_jual_pertahun($tahun)->result() as $readBln) {
                $idTran = (string)$readBln->jual_nofak;
                $data[] = array(
                    'no' => $iterasi++,
                    'jual_nofak' => $idTran,
                    'jual_member' => $this->_getMeber($readBln->jual_member_id),
                    'jual_total' => $readBln->jual_total,
                    'jual_jml_uang' => $readBln->jual_jml_uang,
                    'jual_kembalian' => $readBln->jual_kembalian,
                    'petugas' => $this->getPetugas($readBln->jual_user_id),
                    'pesan' => $readBln->jual_deskripsi,
                    'keuntungan' => $this->_keuntungan($idTran),
                    'action' => '<button class="btn btn-sm btn-warning" onclick="detail(\'' . $readBln->jual_nofak . '\')"><i class="fas fa-edit"></i></button>',
                );
            }
        } else {
            $data = array();
        }
        $readHari = array(
            'data' => $data
        );

        echo json_encode($readHari);
    }


    private function _keuntunganbrg($idTR, $idbarang)
    {
        $dataKen = $this->db->query("SELECT * FROM tbl_detail_jual WHERE d_jual_nofak= '$idTR' AND d_jual_id = '$idbarang'")->result_array()[0];
        return $dataKen['d_jual_total'] - ($dataKen['d_jual_barang_harpok'] * $dataKen['d_jual_banyaknya']);
    }

    public function lapbelibar()
    {
        if ($this->session->userdata('akses') == '1') {
            $data = [
                'title' => "Laporan Pembelian Barang",
                'toko' => $this->db->get('tbl_toko')->result_array()[0]['nama'],
                'nama' => $this->session->userdata('nama'),
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('laporan/laporanbelibar', $data);
        } else {
            echo "Halaman tidak ditemukan";
        }
    }

    public function readBelibar()
    {
        header('Content-type: application/json');
        $iterasi = 1;
        if ($this->m_laporan->getBelibar()->num_rows() > 0) {
            foreach ($this->m_laporan->getBelibar()->result() as $readBar) {
                $data[] = array(
                    'no' => $iterasi++,
                    'beli_nofak' => $readBar->beli_nofak,
                    'kode_tran' => $readBar->beli_kode,
                    'tanggal' => $readBar->beli_tanggal,
                    'supplier' => $readBar->suplier_nama,
                    'petugas' => $readBar->user_nama,
                    'action' => '<button class="btn btn-sm btn-warning" onclick="detail(\'' . $readBar->beli_kode . '\')"><i class="fas fa-edit"></i></button>',
                );
            }
        } else {
            $data = array();
        }
        $readHari = array(
            'data' => $data
        );

        echo json_encode($readHari);
    }
    public function readdetilbeli($readDetail)
    {
        $output = '';
        $i = 1;
        foreach ($this->m_laporan->getBelibardetail($readDetail)->result_array() as $items) {
            $output .=
                '<tr>
                <td>' . $i . ' </td>
                <td>' . $items['barang_nama'] . ' </td>
                <td>' . $items['d_beli_harga'] . ' </td>
                <td>' . $items['d_beli_jumlah'] . ' </td>
                <td>' . $items['d_beli_total'] . ' </td>
                </tr>';
            $i++;
        }
        echo $output;
    }

    private function _keuntungan($nofak)
    {
        $this->db->where('d_jual_nofak', $nofak);
        $dataKen = $this->db->get('tbl_detail_jual')->result();
        $sumModal = 0;

        foreach ($dataKen as $dt) {
            $sumModal += $dt->d_jual_barang_harpok * $dt->d_jual_banyaknya;
        }

        return $dataKen[0]->d_jual_total - $sumModal;
    }

    public function _keuntunganbln($bln)
    {
        return $this->m_laporan->get_total_jual_perbulan($bln)->result_array();
    }

    private function _pendapatanJual($tanggal)
    {
        return $this->db->query("SELECT SUM(jual_total) AS total FROM tbl_jual WHERE DATE(jual_tanggal) = '$tanggal'")->result_array()[0];
    }

    private function _pendapatanJualall()
    {
        return $this->db->query("SELECT SUM(jual_total) AS total FROM tbl_jual")->result_array()[0];
    }

    private function _getMeber($id)
    {

        if (empty($id) || $id === null) {
            return "Non Member";
        } else {
            $this->db->where('id', $id);
            return $this->db->get('tbl_member')->result_array()[0]['nama'];
        }
    }

    private function getPetugas($id)
    {
        $this->db->where('user_id', $id);
        return $this->db->get('tbl_user')->result_array()[0]['user_nama'];
    }

    private function _getKeuntungan($tanggal)
    {
        $dataKen = $this->db->query("SELECT SUM(jual_total) AS total FROM tbl_jual WHERE DATE(jual_tanggal) = '$tanggal'")->result_array();
        $dataBarang =  $this->db->query("SELECT d_jual_barang_harpok, d_jual_qty FROM tbl_jual JOIN tbl_detail_jual
                        ON tbl_jual.`jual_nofak` = tbl_detail_jual.`d_jual_nofak` WHERE DATE(jual_tanggal) = '$tanggal'")->result();
        $sumModal = 0;
        foreach ($dataBarang as $db) {
            $sumModal += $db->d_jual_barang_harpok * $db->d_jual_qty;
        }

        return $dataKen[0]['total'] - $sumModal;
    }

    private function _getKeuntunganall()
    {
        $dataKen = $this->db->query("SELECT SUM(jual_total) AS total FROM tbl_jual ")->result_array();
        $dataBarang =  $this->db->query("SELECT d_jual_barang_harpok, d_jual_qty FROM tbl_jual JOIN tbl_detail_jual
                        ON tbl_jual.`jual_nofak` = tbl_detail_jual.`d_jual_nofak` ")->result();
        $sumModal = 0;
        foreach ($dataBarang as $db) {
            $sumModal += $db->d_jual_barang_harpok * $db->d_jual_qty;
        }

        return $dataKen[0]['total'] - $sumModal;
    }

    private function _getKeuntunganbln($bulan)
    {
        $dataKen = $this->db->query("SELECT SUM(jual_total) AS total FROM tbl_jual WHERE DATE_FORMAT(jual_tanggal,'%M %Y') = '$bulan'")->result_array();
        $dataBarang =  $this->db->query("SELECT d_jual_barang_harpok, d_jual_qty FROM tbl_jual JOIN tbl_detail_jual
                        ON tbl_jual.`jual_nofak` = tbl_detail_jual.`d_jual_nofak` WHERE DATE_FORMAT(jual_tanggal,'%M %Y') = '$bulan'")->result();
        $sumModal = 0;
        foreach ($dataBarang as $db) {
            $sumModal += $db->d_jual_barang_harpok * $db->d_jual_qty;
        }

        return $dataKen[0]['total'] - $sumModal;
    }

    private function _getKeuntunganthn($tahun)
    {
        $dataKen = $this->db->query("SELECT SUM(jual_total) AS total FROM tbl_jual  WHERE YEAR(jual_tanggal)='$tahun' ")->result_array();
        $dataBarang =  $this->db->query("SELECT d_jual_barang_harpok, d_jual_qty FROM tbl_jual JOIN tbl_detail_jual
                        ON tbl_jual.`jual_nofak` = tbl_detail_jual.`d_jual_nofak`  WHERE YEAR(jual_tanggal)='$tahun' ")->result();
        $sumModal = 0;
        foreach ($dataBarang as $db) {
            $sumModal += $db->d_jual_barang_harpok * $db->d_jual_qty;
        }

        return $dataKen[0]['total'] - $sumModal;
    }


    public function _kenperTransaksi()
    {
       
    }

    public function coba($nofak)
    {
        $this->db->where('d_jual_nofak', $nofak);
        $dataKen = $this->db->get('tbl_detail_jual')->result();

        var_dump($dataKen[0]->d_jual_total);
    }
   
}
