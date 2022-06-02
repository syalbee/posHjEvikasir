<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_member extends CI_Controller
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
		$this->load->model('m_penjualan');
		$this->load->model('m_pelanggan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		if ($this->session->userdata('akses') == '1' || $this->session->userdata('akses') == '2') {
			$memberId = $this->session->userdata('trMemberid');

            $data = [
				'title' => "Transaksi Member",
				'toko' => $this->db->get('tbl_toko')->result_array()[0]['nama'],
				'nama' => $this->session->userdata('nama'),
                'member' => $this->db->query("SELECT nama FROM tbl_member WHERE kode = '$memberId'")->result_array()[0]['nama']
			];

			$this->load->view('template/header', $data);
			$this->load->view('template/sidebar', $data);
			$this->load->view('transaksi/member', $data);
		} else {
			echo "Halaman tidak ditemukan";
		}
	}

	public function get_barang()
	{
		if ($this->session->userdata('akses') == '1' || $this->session->userdata('akses') == '2') {
			$kobar = $this->input->post('kode_brg');
			$barang = $this->m_barang->get_barangtransaksi($kobar);

			if ($barang->row()) {
				echo json_encode($barang->row());
			}
		} else {
			echo "Halaman tidak ditemukan";
		}
	}

	public function ambil_barang()
	{
		if ($this->session->userdata('akses') == '1' || $this->session->userdata('akses') == '2') {
			$kobar = $this->input->post('kode_brg');
			$x['brg'] = $this->m_barang->get_beli($kobar);
			$this->load->view('penjualan/v_detail_barang_jual', $x);
		} else {
			echo "Halaman tidak ditemukan";
		}
	}

	public function add_to_cart()
	{

		if ($this->session->userdata('akses') == '1' || $this->session->userdata('akses') == '2') {

			$kobar = $this->input->post('Barangid');
			$produk = $this->m_barang->get_beli($kobar);

			$i = $produk->row_array();
			if ($this->input->post('jenisTR') === "grosir") {
				$data = array(
					'id'       => $i['barang_id'] . $this->_getNameID(),
					'kodeBrg'  => $i['barang_id'],
					'name'     => $i['barang_nama'],
					'satuan'   => $i['barang_satuan'],
					'jenis'	   => "grosir",
					'harpok'   => $i['barang_harpok_grosir'],
					'price'    => intval($i['barang_harjul_grosir']),
					'disc'     => 0,
					'qty'      => $this->input->post('Barangqty'),
					'amount'	=> intval($i['barang_harjul_grosir'])
				);
			} else if ($this->input->post('jenisTR') === "eceran") {
				$data = array(
					'id'       => $i['barang_id']. $this->_getNameID(),
					'kodeBrg'  => $i['barang_id'],
					'name'     => $i['barang_nama'],
					'satuan'   => $i['satuan_turunan'],
					'jenis'	   => "eceran",
					'harpok'   => $i['barang_harpok_eceran'],
					'price'    => intval($i['barang_harjul_eceran']),
					'disc'     => 0,
					'qty'      => $this->input->post('Barangqty'),
					'amount'	=> intval($i['barang_harjul_eceran'])
				);
			}

			if ($this->cart->insert($data)) {
				echo json_encode('sukses');
			}
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
			$output .=
				'<tr>
                <input type="hidden" id="BRGiD" name="BRGiD" value="' . $items['rowid'] . '">
                <input type="hidden" id="BRGprice" name="BRGprice" value="' . $items['amount'] . '">
                <td>' . $items['name'] . ' </td>
                <td>' . $items['jenis'] . ' </td>
                <td style="text-align:center;">' . $items['satuan'] . ' </td>
                <td style="text-align:right;">' . number_format($items['amount']) . ' </td>
                <td><input type="text" id="etdisc" onkeydown="search(this)" name="ETdiskon" value="' . $items['disc'] . '" class="form-control input-sm" style="width:130px;margin-right:5px;" required></td>
                <td><input type="text" id="etqty" onkeydown="search(this)" name="ETqty" value=" ' . $items['qty'] . '" class="form-control input-sm" style="width:90px;margin-right:5px;" required></td>
                <td style="text-align:right;">' . number_format($items['subtotal']) . ' </td>
                <td style="text-align:center;">
                <button id="' . $items['rowid'] . '"  class="edit_cart btn btn-warning btn-xs">Edt</button>
                <button id="' . $items['rowid'] . '"  class="hapus_cart btn btn-danger btn-xs">Hps</button>
            </td>
            </tr>
            ';
			$i++;
		}
		echo $output;
	}

	public function remove()
	{
		$this->cart->update(array(
			'rowid' => $this->input->post('row_id'),
			'qty' => 0
		));
	}

	public function edit()
	{
		$qty = $this->input->post('qty');
		$diskon = $this->input->post('diskon');
		$price = $this->input->post('price');
		$this->cart->update(array(
			'rowid' => $this->input->post('row_id'),
			'qty' => $qty,
			'price' => $price - $diskon,
			'disc' => $diskon
		));
	}

	public function simpan_penjualan()
	{
		if ($this->session->userdata('akses') == '1' || $this->session->userdata('akses') == '2') {
			$total = $this->input->post('total');
			$jml_uang = str_replace(",", "", $this->input->post('jml_uang'));
			$kembalian = $jml_uang - $total;
            $pesan = $this->input->post('message');
			$stsBayar = $this->input->post('setTotal');
            $pelanggan =  $this->session->userdata('trMemberid');

            if (empty($stsBayar)) {
				$stsBayar = '0';
			} else {
				$stsBayar = '1';
			}

			if (!empty($total) && !empty($jml_uang)) {
				if ($jml_uang < $total) {
					echo $this->session->set_flashdata('msgTransaksi', 'gagal');
					redirect('transaksi_member');
				} else {
					$nofak = $this->m_penjualan->get_nofak();
					$this->session->set_userdata('nofak', $nofak);
					$order_proses = $this->m_penjualan->simpan_penjualan($nofak, $total, $jml_uang, $kembalian, $pelanggan, $pesan, $stsBayar);
					$this->setPoint($pelanggan, $total);
                    if ($order_proses) {
						$this->cart->destroy();
						$this->session->unset_userdata('tglfak');
                        $this->session->unset_userdata('trMemberid');
						$this->session->unset_userdata('nofak');
						$this->session->unset_userdata('suplier');
						$this->session->set_flashdata('msgTransaksi', $nofak);

						$data = [
							'title' => "Transaksi Member",
							'toko' => "Toko Hj Evi",
							'nama' => $this->session->userdata('nama'),
							'token' => $nofak,
							'jenis' => 'member'
						];

						$this->load->view('template/header', $data);
						$this->load->view('template/sidebar', $data);
						$this->load->view('transaksi/alert_sukses', $data);

					} else {
						redirect('transaksi_nonmember');
					}
				}
			} else {
				echo $this->session->set_flashdata('msg', '<label class="label label-danger">Transaksi Gagal di Simpan, Mohon Periksa Kembali Semua Inputan Anda!</label>');
				redirect('transaksi_nonmember');
			}
		} else {
			echo "Halaman tidak ditemukan";
		}
	}

	public function readtotal()
	{
		echo $this->cart->total();
	}

	private function setPoint($id, $totalBelanja)
	{
		$pelanggan = $this->m_pelanggan->getPoint($id);
		$toko =  $this->db->get('tbl_toko')->row();

		$point = $pelanggan->point;
		$minUang = $toko->jumUang;
		$pointKelipatan = round($totalBelanja / $minUang);

		if ($totalBelanja >= $minUang) {
			$hasilPoint = $toko->point * $pointKelipatan;
			$this->m_pelanggan->setPoint($id, $hasilPoint + $point);
		}
	}

	public function resetcart()
	{
		$this->cart->destroy();
		redirect('transaksi_member');
	}

	private function _getNameID() {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < 3; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}
		return $randomString;
	}
	  
}
