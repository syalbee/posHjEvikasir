<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') != TRUE) {
            $url = base_url();
            redirect($url);
        };
        $this->load->model('m_kategori');
        $this->load->model('m_barang');
        $this->load->model('m_suplier');
        $this->load->model('m_pembelian');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        if ($this->session->userdata('akses') == '1' || $this->session->userdata('akses') == '2') {
            $data = [
                'title' => "Pembelian Barang",
                'toko' => "Toko Hj Evi",
                'nama' => $this->session->userdata('nama'),
                'sup' => $this->m_suplier->tampil_suplier(),
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('admin/pembelian', $data);
        } else {
            echo "Halaman tidak ditemukan";
        }
    }
    public function read()
    {
        $output = '';
        $i = 1;
        foreach ($this->cart->contents() as $items) {
            echo form_hidden($i . '[rowid]', $items['rowid']);

            $output .= '<tr>
                <td>' . $items['id'] . ' </td>
                <td>' . $items['name'] . ' </td>
                <td style="text-align:center;">' . $items['satuan'] . ' </td>
                <td style="text-align:right;">' . number_format($items['price']) . ' </td>
                <td style="text-align:right;"> ' . number_format($items['harga']) . ' </td>
                <td style="text-align:center;"> ' . number_format($items['qty']) . ' </td>
                <td style="text-align:right;">' . number_format($items['subtotal']) . ' </td>
                <td style="text-align:center;"><a href="' . base_url("pembelian/remove/") . $items['rowid'] . '" class="btn btn-warning btn-xs"><span class="fa fa-close"></span> Batal</a></td>
            </tr>
            ';
            $i++;
        }
        echo $output;
    }

    public function get_barang()
    {
        if ($this->session->userdata('akses') == '1' || $this->session->userdata('akses') == '2') {
            $kobar = $this->input->post('kode_brg');
            $x['brg'] = $this->m_barang->get_beli($kobar);
            $this->load->view('admin/v_detail_barang_beli', $x);
        } else {
            echo "Halaman tidak ditemukan";
        }
    }

    public function add_to_cart()
    {
        if ($this->session->userdata('akses') == '1' || $this->session->userdata('akses') == '2') {
            $nofak = $this->input->post('nofak');
            $tgl = $this->input->post('tgl');
            $suplier = $this->input->post('suplierbeli');

            $this->session->set_userdata('nofak', $nofak);
            $this->session->set_userdata('tglfak', $tgl);
            $this->session->set_userdata('suplier', $suplier);
            $kobar = $this->input->post('kode_brg');

            $produk = $this->m_barang->get_beli($kobar);
            $i = $produk->row_array();
            $data = array(
                'id'       => $i['barang_id'],
                'name'     => $i['barang_nama'],
                'satuan'   => $i['barang_satuan'],
                'price'    => $this->_getHarga($kobar)['harpok'],
                'harga'    => $this->_getHarga($kobar)['harjul'],
                'qty'      => $this->input->post('jumlah')
            );

            if ($this->cart->insert($data)) {
                echo json_encode('sukses');
            }
            // redirect('pembelian');
        } else {
            echo "Halaman tidak ditemukan";
        }
    }

    public function remove()
    {
        if ($this->session->userdata('akses') == '1' || $this->session->userdata('akses') == '2') {
            $row_id = $this->uri->segment(3);
            $this->cart->update(array(
                'rowid'      => $row_id,
                'qty'     => 0
            ));
            redirect('pembelian');
        } else {
            echo "Halaman tidak ditemukan";
        }
    }

    public function simpan_pembelian()
    {
        if ($this->session->userdata('akses') == '1'  || $this->session->userdata('akses') == '2') {
            $nofak = $this->session->userdata('nofak');
            $tglfak = $this->session->userdata('tglfak');
            $suplier = $this->session->userdata('suplier');

            $tglfak = date("Y-m-d", strtotime($tglfak));

            if (empty($tglfak) || $tglfak === "" || $tglfak === NULL) {
                $tglfak = date('Y-m-d');
            }

            if (!empty($nofak) && !empty($tglfak) && !empty($suplier)) {
                $beli_kode = $this->m_pembelian->get_kobel();
                $order_proses = $this->m_pembelian->simpan_pembelian($nofak, $tglfak, $suplier, $beli_kode);
                if ($order_proses) {
                    $this->cart->destroy();
                    $this->session->unset_userdata('nofak');
                    $this->session->unset_userdata('tglfak');
                    $this->session->unset_userdata('suplier');
                    echo $this->session->set_flashdata('msgPembelian', 'saveSuccess');
                    redirect('pembelian');
                } else {
                    redirect('pembelian');
                }
            } else {
                echo $this->session->set_flashdata('msgPembelian', 'saveFailed');
                redirect('pembelian');
            }
        } else {
            echo "Halaman tidak ditemukan";
        }
    }

    private function _getHarga($id)
    {
        $this->db->where('barang_id', $id);
        $data =  $this->db->get('tbl_barang')->result_array();

        $barang = array(
            'harjul' => $data[0]['barang_harjul_grosir'],
            'harpok' => $data[0]['barang_harpok_grosir']
        );
        return $barang;
    }

    public function coba()
    {
      echo $this->m_pembelian->get_kobel();
    }
}
