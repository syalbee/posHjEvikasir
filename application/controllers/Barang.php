<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') != TRUE) {
            $url = base_url();
            redirect($url);
        };
        $this->load->model('m_satuan');
        $this->load->model('m_kategori');
        $this->load->model('m_barang');
        $this->load->model('m_suplier');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {

        if ($this->session->userdata('akses') == '1' || $this->session->userdata('akses') == '2') {
            $data = [
                'title' => "Barang",
                'toko' => "Toko Hj Evi",
                'nama' => $this->session->userdata('nama'),
                'kat' => $this->m_kategori->tampil_kategori(),
                'sat' => $this->m_satuan->tampil_satuan(),
                'sup' => $this->m_suplier->tampil_suplier()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('admin/barang', $data);
        } else {
            echo "Halaman tidak ditemukan";
        }
    }

    public function read()
    {
        header('Content-type: application/json');
        if ($this->m_barang->read()->num_rows() > 0) {
            foreach ($this->m_barang->read()->result() as $barang) {
                $data[] = array(
                    // 'barang_barcode' => $barang->barang_id,
                    'barang_nama' => $barang->barang_nama,
                    'barang_harpok_grosir' => $barang->barang_harpok_grosir,
                    'barang_harpok_eceran' => $barang->barang_harpok_eceran,
                    'barang_harjul_grosir' => $barang->barang_harjul_grosir,
                    'barang_harjul_eceran' => $barang->barang_harjul_eceran,
                    'barang_harjul_grosir_m' => $barang->barang_harjul_grosir_m,
                    'barang_harjul_eceran_m' => $barang->barang_harjul_eceran_m,
                    'barang_stok' =>  round($barang->barang_stok) . " " . $barang->satuan_nama . " / " . round($barang->barang_stok * $barang->barang_min_stok) . " " . $barang->satuan_turunan,
                    'barang_min_stok' => round($barang->barang_stok * $barang->barang_min_stok) <= $barang->barang_min_stok ? "<h6 class='alert alert-danger'> < " . $barang->barang_min_stok . "</h6>"  : "<h6 class='alert alert-success'> > "  . $barang->barang_min_stok . "</h6>",
                    'action' => '<button class="btn btn-sm btn-warning" onclick="edit(' . $barang->id . ')"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger" onclick="remove(' . $barang->id . ')"><i class="fas fa-trash"></i></button>',
                );
            }
        } else {
            $data = array();
        }
        $pelanggan = array(
            'data' => $data
        );
        echo json_encode($pelanggan);
    }

    public function readDetail()
    {
        header('Content-type: application/json');
        if ($this->m_barang->read()->num_rows() > 0) {
            $i = 1;
            foreach ($this->m_barang->read()->result() as $barang) {
                $i++;
                $data[] = array(
                    'no' => $i,
                    'barang_barcode' => $barang->barang_id,
                    'barang_nama' => $barang->barang_nama,
                    'barang_harpok_grosir' => $barang->barang_harpok_grosir,
                    'barang_harpok_eceran' => $barang->barang_harpok_eceran,
                    'barang_harjul_grosir' => $barang->barang_harjul_grosir,
                    'barang_harjul_eceran' => $barang->barang_harjul_eceran,
                    'barang_harjul_grosir_m' => $barang->barang_harjul_grosir_m,
                    'barang_harjul_eceran_m' => $barang->barang_harjul_eceran_m,
                    'barang_kategori' => $barang->kategori_nama,
                    'barang_suplier' => $barang->suplier_nama,
                    'barang_stok' =>  round($barang->barang_stok) . " " . $barang->satuan_nama . " / " . round($barang->barang_stok * $barang->barang_min_stok) . " " . $barang->satuan_turunan,
                    'barang_min_stok' => $barang->barang_min_stok,
                    'barang_last' => $barang->barang_tgl_last_update,
                );
            }
        } else {
            $data = array();
        }
        $pelanggan = array(
            'data' => $data
        );
        echo json_encode($pelanggan);
    }

    public function add()
    {
        $kodebarang = $this->m_barang->get_kobar();
        $data = array(
            'barang_id' => $kodebarang,
            'barcode' => $kodebarang,
            'barang_nama' => $this->input->post('nabar'),
            'barang_harpok_grosir' => $this->input->post('harpok_grosir'),
            'barang_harjul_grosir' => $this->input->post('harjul_grosir'),
            'barang_harpok_eceran' => $this->input->post('harpok_eceran'),
            'barang_harjul_eceran' => $this->input->post('harjul_eceran'),
            // 'barang_harpok_grosir_m' => $this->input->post('harpok_grosir_m'),
            'barang_harjul_grosir_m' => $this->input->post('harjul_grosir_m'),
            // 'barang_harpok_eceran_m' => $this->input->post('harpok_eceran_m'),
            'barang_harjul_eceran_m' => $this->input->post('harjul_eceran_m'),
            'barang_stok' => $this->input->post('stok'),
            'barang_min_stok' => $this->input->post('min_stok'),
            'barang_satuan_id' => $this->input->post('satuan'),
            'barang_kategori_id' => $this->input->post('kategori'),
            'barang_suplier_id' => $this->input->post('suplier'),
            'barang_user_id' => $this->session->userdata('idadmin'),
            'active' => '1'
        );

        if ($this->m_barang->create($data)) {
            // echo json_encode('sukses');
            redirect('barang');
        }
    }


    public function delete()
    {
        $id = $this->input->post('id');
        $data = array(
            'active' => '0'
        );

        if ($this->m_barang->updatedelete($id, $data)) {
            echo json_encode('sukses');
        }
    }


    public function edit($id)
    {
        $data = array(
            'barang_nama' => $this->input->post('nabar'),
            'barang_harpok_grosir' => $this->input->post('harpok_grosir'),
            'barang_harjul_grosir' => $this->input->post('harjul_grosir'),
            'barang_harpok_eceran' => $this->input->post('harpok_eceran'),
            'barang_harjul_eceran' => $this->input->post('harjul_eceran'),
            'barang_harjul_grosir_m' => $this->input->post('harjul_grosir_m'),
            'barang_harjul_eceran_m' => $this->input->post('harjul_eceran_m'),
            'barang_min_stok' => $this->input->post('min_stok'),
            'barang_satuan_id' => $this->input->post('satuan'),
            'barang_kategori_id' => $this->input->post('kategori'),
            'barang_suplier_id' => $this->input->post('suplier'),
            'barang_user_id' => $this->session->userdata('idadmin'),
            'barang_tgl_last_update' => date('Y-m-d H:i:s'),
        );

        if ($this->m_barang->update($id, $data)) {
            redirect('barang');
            // echo json_encode('sukses');
        }
    }


    public function get_barcode()
    {
        header('Content-type: application/json');
        $barcode = $this->input->post('barcode');
        $search = $this->m_barang->ambilBarcode($barcode);
        $data = [];
        foreach ($search as $barcode) {
            $data[] = [
                'id' => $barcode['barang_id'],
                'text' => $barcode['barang_nama']
            ];
        }
        echo json_encode($data);
    }

    public function tambahView()
    {
        if ($this->session->userdata('akses') == '1' || $this->session->userdata('akses') == '2') {

            $data = [
                'title' => "Tambah Data Barang",
                'toko' => "Toko Hj Evi",
                'nama' => $this->session->userdata('nama'),
                'kat' => $this->m_kategori->tampil_kategori(),
                'sat' => $this->m_satuan->tampil_satuan(),
                'sup' => $this->m_suplier->tampil_suplier()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('admin/tambahbarang', $data);
        } else {
            echo "Halaman tidak ditemukan";
        }
    }


    public function updateView($id)
    {
        if ($this->session->userdata('akses') == '1' || $this->session->userdata('akses') == '2') {

            $data = [
                'title' => "Edit Barang",
                'toko' => "Toko Hj Evi",
                'nama' => $this->session->userdata('nama'),
                'kat' => $this->m_kategori->tampil_kategori(),
                'sat' => $this->m_satuan->tampil_satuan(),
                'sup' => $this->m_suplier->tampil_suplier(),
                'barang' => $this->m_barang->getBarang($id)->result_array()
            ];


            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('admin/updatebarang', $data);
        } else {
            echo "Halaman tidak ditemukan";
        }
    }
}
