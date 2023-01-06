<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Home extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		if ($this->session->userdata('session_sop') == "") {
			$urllogin = '';
			if (@$_GET['source'] == 'qrcode') {
				$urllogin = '?url=' . base_url(uri_string());
			}
			redirect('login' . $urllogin);
		}

		if ($this->session->userdata('role_slug') == 'officer') {
			redirect(base_url('arsip_dokumen/surat_masuk'));
		}

		if (($this->session->userdata('role_id') == '25') || ($this->session->userdata('role_id') == '26') || ($this->session->userdata('role_id') == '27')) {
			$data['page_name'] = "home";
			$this->template->load('template/template', 'template/index-komite', $data);
		} else {
			$data['page_name'] = "home";
			$this->template->load('template/template', 'template/index', $data);
		}
	}

	public function arsip()
	{
		$data['page_name'] = "home";
		$this->load->view('template/index-arsip');
		// $this->template->load('template/template', 'template/index-arsip', $data);
		# code...
	}

	public function sponsorship()
	{
		$data['page_name'] = "home";
		$this->load->view('template/index-sponsorship');
		// $this->template->load('template/template', 'template/index-sponsorship', $data);
		# code...
	}


	public function sponsorship_json()
	{
		$get = $this->input->get('status');
		$kategoriDanJumlahSponsor = [];
		$kategoriDanJumlahSponsorCancel = [];
		$kategoriDanNominalSponsor = [];
		$picSponsor = [];
		$kategorilingkupDanNominalSponsor = [];
		$kantorDanNominalSponsor = [];
		$picDanJumlahSponsor = [];
		$picSponsorTotalPic = [];
		$picDanJumlahSponsorall = [];
		$klasifikasi = $this->mymodel->selectWhere('klasifikasi', ['status' => 'ENABLE']);
		$lingkup = $this->mymodel->selectWhere('lingkup', ['status' => 'ENABLE']);
		foreach ($klasifikasi as $key => &$klas) {
			$this->db->select('COUNT(0) as jml, (SUM(nilai_sponsor)) as nominal');
			$totalkla = $this->mymodel->selectDataone('sponsorship', ['is_kegiatan_terlaksana' => 1, 'klasifikasi_id' => $klas['id']]);
			if ($totalkla['jml'] != 0) $picDanJumlahSponsorall['All user'][$klas['klasifikasi']] = $totalkla['jml'];

			$this->db->select('COUNT(0) as jml, (SUM(nilai_sponsor)) as nominal');
			$totallain = $this->mymodel->selectDataone('sponsorship', ['is_kegiatan_terlaksana' => 1, 'klasifikasi_id' => 0]);
			if ($totallain['jml'] != 0) {
				$picDanJumlahSponsorall['All user']['Lainnya'] = $totallain['jml'];
			}
		}

		if ($get == "bagian-1") {
			/**
			 * Kategori dan Jumlah Sponsor = $kategoriDanJumlahSponsor
			 * where status : belum
			 * 
			 * Kategori dan Nominal Sponsor = $kategoriDanNominalSponsor
			 * 
			 * Jenis Kegiatan dan jumlah Sponsor = $kategorilingkupDanNominalSponsor
			 * 
			 * PIC Sponsor : $picSponsor
			 */


			foreach ($klasifikasi as $klas) {
				$this->db->select('COUNT(0) as jml, (SUM(nilai_sponsor)) as nominal');
				$total = $this->mymodel->selectDataone('sponsorship', ['is_kegiatan_terlaksana' => 1, 'klasifikasi_id' => $klas['id']]);
				$kategoriDanJumlahSponsor[$klas['klasifikasi']] = $total['jml'];
				($total['nominal'] != null) ? $nominal = round($total['nominal']) : $nominal = 0;
				$kategoriDanNominalSponsor[$klas['klasifikasi']] = $nominal;


				$this->db->select('COUNT(0) as jml, (SUM(nilai_sponsor)) as nominal');
				$total = $this->mymodel->selectDataone('sponsorship', ['is_kegiatan_terlaksana' => 0, 'klasifikasi_id' => $klas['id']]);
				$kategoriDanJumlahSponsorCancel[$klas['klasifikasi']] = $total['jml'];



				// =======================================================================================================================
				// klasifikasi kegiatan dan lingkup kegiatan
				foreach ($lingkup as $ling) {
					$this->db->select('COUNT(0) as jml');
					$totallingkup = $this->mymodel->selectDataone('sponsorship', ['is_kegiatan_terlaksana' => 1, 'klasifikasi_id' => $klas['id'], 'lingkup_id' => $ling['id']]);
					// ($totallingkup['nominal']!=null)? $nominallingkup = round($totallingkup['nominal']) : $nominallingkup = 0;
					$kategorilingkupDanNominalSponsor[$klas['klasifikasi']][$ling['lingkup']] = $totallingkup['jml'];
				}

				$this->db->select('COUNT(0) as jml');
				$totallingkup = $this->mymodel->selectDataone('sponsorship', ['is_kegiatan_terlaksana' => 1, 'klasifikasi_id' => $klas['id'], 'lingkup_id' => 0]);
				// ($totallingkup['nominal']!=null)? $nominallingkup = round($totallingkup['nominal']) : $nominallingkup = 0;
				$kategorilingkupDanNominalSponsor[$klas['klasifikasi']]['Lainnya'] = $totallingkup['jml'];
				// =======================================================================================================================
				//PIC Sponsor

			}
			$this->db->select('COUNT(0) as jml, (SUM(nilai_sponsor)) as nominal');
			$total = $this->mymodel->selectDataone('sponsorship', ['is_kegiatan_terlaksana' => 1, 'klasifikasi_id' => 0]);
			$kategoriDanJumlahSponsor['Lainnya'] = $total['jml'];
			($total['nominal'] != null) ? $nominal = round($total['nominal']) : $nominal = 0;
			$kategoriDanNominalSponsor['Lainnya'] = $nominal;

			$this->db->select('COUNT(0) as jml, (SUM(nilai_sponsor)) as nominal');
			$total = $this->mymodel->selectDataone('sponsorship', ['is_kegiatan_terlaksana' => 0, 'klasifikasi_id' => 0]);
			$kategoriDanJumlahSponsorCancel['Lainnya'] = $total['jml'];

			// =======================================================================================================================
			// klasifikasi kegiatan dan lingkup kegiatan
			foreach ($lingkup as $ling) {
				$this->db->select('COUNT(0) as jml');
				$totallingkup = $this->mymodel->selectDataone('sponsorship', ['is_kegiatan_terlaksana' => 1, 'klasifikasi_id' => 0, 'lingkup_id' => $ling['id']]);
				// ($totallingkup['nominal']!=null)? $nominallingkup = round($totallingkup['nominal']) : $nominallingkup = 0;
				$kategorilingkupDanNominalSponsor['Lainnya'][$ling['lingkup']] = $totallingkup['jml'];
			}

			$this->db->select('COUNT(0) as jml');
			$totallingkup = $this->mymodel->selectDataone('sponsorship', ['is_kegiatan_terlaksana' => 1, 'klasifikasi_id' => 0, 'lingkup_id' => 0]);
			// ($totallingkup['nominal']!=null)? $nominallingkup = round($totallingkup['nominal']) : $nominallingkup = 0;
			$kategorilingkupDanNominalSponsor['Lainnya']['Lainnya'] = $totallingkup['jml'];

			// =======================================================================================================================
			/**
			 *  
			 * 
			 * 
			 * 
			 */
		} else if ($get == "bagian-2") {



			/**
			 * Kantor Wilayah + KCK
			 * Kategori dan nominal sponsor
			 */
			$kantor = $this->mymodel->selectWhere('kantor', ['status' => 'ENABLE']);
			foreach ($kantor as $klas) {
				$this->db->select('((SUM(nilai_sponsor))) as jml');
				$jml = $this->mymodel->selectDataone('sponsorship', ['is_kegiatan_terlaksana' => 1, 'kantor_id' => $klas['id']])['jml'];
				($jml != null) ? $nominal = round($jml) : $nominal = 0;
				$kantorDanNominalSponsor[$klas['kantor']] = $nominal;
			}
			/**
			 *  
			 * 
			 * 
			 * 
			 */
		} else if ($get == "bagian_logo") {
			$keuntungan = $this->mymodel->selectWhere('keuntungan', null);
			foreach ($keuntungan as $valkeuntungan) {
				$text = '"' . $valkeuntungan['id'] . '"';
				$this->db->select('count(id) as jml');
				$this->db->like('keuntungan_id', $text, 'BOTH');
				$jml = $this->mymodel->selectDataone('sponsorship', ['is_kegiatan_terlaksana' => 1, 'keuntungan_logo !=' => null])['jml'];
				($jml != null) ? $nominal = round($jml) : $nominal = 0;
				$logoDannominalsponsor[$valkeuntungan['keuntungan']] = $nominal;
			}
		} else {
			/**
			 * PIC Sponsorship
			 */
			// $this->db->select('DISTINCT()')
			$kategori = [];
			$dataUsers = [];
			$user = $this->mymodel->selectWhere('user', []);
			foreach ($user as $u) {
				foreach ($klasifikasi as $klas) {
					$this->db->select('COUNT(0) as jml, (SUM(nilai_sponsor)) as nominal');
					$this->db->like('pic', '"' . $u['id'] . '"', 'both');
					$total = $this->mymodel->selectDataone('sponsorship', ['is_kegiatan_terlaksana' => 1, 'klasifikasi_id' => $klas['id']]);
					if ($total['jml'] != 0) {
						$picSponsor[$klas['klasifikasi']][$u['name']] = $total['jml'];
						$dataUsers[] = $u['name'];
					}
					if ($total['jml'] != 0) $picDanJumlahSponsor[$u['name']][$klas['klasifikasi']] = $total['jml'];
					if ($total['jml'] != 0) $picDanJumlahSponsorall[$u['name']][$klas['klasifikasi']] = $total['jml'];
					if ($total['jml'] != 0) $picSponsorTotalPic[$u['name']][$klas['klasifikasi']] = round($total['nominal']);
					$kategori[] = $klas['klasifikasi'];
				}

				$this->db->select('COUNT(0) as jml, (SUM(nilai_sponsor)) as nominal');
				$this->db->like('pic', '"' . $u['id'] . '"', 'both');
				$total = $this->mymodel->selectDataone('sponsorship', ['is_kegiatan_terlaksana' => 1, 'klasifikasi_id' => 0]);
				if ($total['jml'] != 0) {
					$picDanJumlahSponsor[$u['name']]['Lainnya'] = $total['jml'];
					$dataUsers[] = $u['name'];
					$picDanJumlahSponsorall[$u['name']]['Lainnya'] = $total['jml'];
				}
				if ($total['jml'] != 0) $picSponsor['Lainnya'][$u['name']] = $total['jml'];
				if ($total['jml'] != 0) $picSponsorTotalPic[$u['name']]['Lainnya'] = round($total['nominal']);
				$kategori[] = "Lainnya";
			}

			$unique_kategori = array_unique($kategori);
			$unique_user = array_unique($dataUsers);
			foreach ($unique_kategori as $uk) {
				$data = [];
				foreach ($unique_user as $us) {
					$data[] = round($picSponsor[$uk][$us]);
				}
				$JsonPicSponsor[] = [
					"name" => $uk,
					"data" => $data
				];
			}

			foreach ($unique_user as $us) {
				$data = [];
				foreach ($unique_kategori as $uk) {
					$data[] = round($picSponsorTotalPic[$us][$uk]);
				}

				$JsonPicSponsorTotal[] = [
					"name" => $us,
					"data" => $data
				];
			}
		}


		$json = [
			'kategoriDanJumlahSponsor' => $kategoriDanJumlahSponsor,
			'kategoriDanJumlahSponsorCancel' => $kategoriDanJumlahSponsorCancel,
			'kategoriDanNominalSponsor' => $kategoriDanNominalSponsor,
			'kategorilingkupDanNominalSponsor' => $kategorilingkupDanNominalSponsor,
			'kantorDanNominalSponsor' => $kantorDanNominalSponsor,
			'logoDannominalsponsor' => $logoDannominalsponsor,
			// 'picSponsor' => $picSponsor,
			'picDanJumlahSponsor' => $picDanJumlahSponsor,
			'picDanJumlahSponsorall' => $picDanJumlahSponsorall,
			'picSponsorTotalPic' => $picSponsorTotalPic,
			'kategori' => $unique_kategori,
			'user' => $unique_user,
			'jsonPicSponsor' => $JsonPicSponsor,
			'jsonPicSponsorTotal' => $JsonPicSponsorTotal
		];

		echo json_encode($json);
	}

	public function vendor()
	{
		# code...
		$data['page_name'] = "home";
		$this->load->view('template/index-vendor');
		// $this->template->load('template/template', 'template/index-vendor', $data);
		# code...
	}


	public function vendor_json()
	{
		/**
		 * Kategori dan Jumlah Konsultan/Vendor = $kategoriDanJumlahKonsultanVendor
		 * Kategori dan Nominal Konsultan/Vendor = $kategoriDanNominalKonsultanVendor
		 * Kategori dan Nominal Konsultan/Vendor dengan status = $kategoriDanJumlahKonsultanVendorStatus
		 * Pic vendor dan konsultan = $picKonsultandanVendor
		 * Pic vendor dan konsultan User = $picKonsultandanVendorbyUser
		 * 
		 * dengan filter tahun
		 * 
		 * Where status belum ada
		 */
		$get = $this->input->get('status');
		$year = $this->input->get('year');
		($year == "") ? $year = date('Y') : $year = $year;
		$status = [
			"Very Good",
			"Good",
			"Netral",
			"Bad"
		];

		$dataKategori = [];
		$dataUsers = [];
		$this->db->select('DISTINCT(kategori) as kategori');
		$kategori = $this->mymodel->selectWhere('tipe', ['status' => 'ENABLE']);
		foreach ($kategori as $kat) {
			$tipe = $this->mymodel->selectWhere('tipe', ['kategori' => $kat['kategori']]);
			if ($get == "bagian-1") {
				foreach ($tipe as $tip) {
					$this->db->select('COUNT(0) as jml,(SUM(nilai_jasa)) as nominal');
					$vendor = $this->mymodel->selectDataone('vendor', ['is_kegiatan_terlaksana' => 1, 'tipe_id' => $tip['id'], 'kategori' => $kat['kategori'], 'YEAR(tanggal)' => $year]);
					$kategoriDanJumlahKonsultanVendor[$kat['kategori']][$tip['tipe']] = $vendor['jml'];
					$vendor['nominal'] = round($vendor['nominal']);
					$kategoriDanNominalKonsultanVendor[$kat['kategori']][$tip['tipe']] = $vendor['nominal'];


					$this->db->select('COUNT(0) as jml,(SUM(nilai_jasa)) as nominal');
					$vendor = $this->mymodel->selectDataone('vendor', ['is_kegiatan_terlaksana' => 0, 'tipe_id' => $tip['id'], 'kategori' => $kat['kategori'], 'YEAR(tanggal)' => $year]);
					$kategoriDanJumlahKonsultanVendorCancel[$kat['kategori']][$tip['tipe']] = $vendor['jml'];

					foreach ($status as $stt) {
						$this->db->select('COUNT(0) as jml');
						$vendorstatus = $this->mymodel->selectDataone('vendor', ['is_kegiatan_terlaksana' => 1, 'kategori' => $kat['kategori'], 'tipe_id' => $tip['id'], 'YEAR(tanggal)' => $year, 'penilaian_hasil' => $stt]);
						if ($vendorstatus != 0) $kategoriDanJumlahKonsultanVendorStatus[$kat['kategori']][$stt][$tip['tipe']] = $vendorstatus['jml'];
					}

					// PIC user vendor
					$user = $this->mymodel->selectWhere('user', []);
					foreach ($user as $u) {

						$this->db->select('COUNT(0) as jml, (SUM(nilai_jasa)) as nominal');
						$this->db->like('pic', '"' . $u['id'] . '"', 'both');
						$vendoruser = $this->mymodel->selectDataone('vendor', ['is_kegiatan_terlaksana' => 1, 'tipe_id' => $tip['id'], 'YEAR(tanggal)' => $year]);
						$jumlahVendorPic = $vendoruser['jml'];
						if ($jumlahVendorPic != 0) $picKonsultandanVendor[$tip['tipe']][$u['name']] = $jumlahVendorPic;
						if ($jumlahVendorPic != 0) $picKonsultandanVendorbyUser[$u['name']][$tip['tipe']] = $jumlahVendorPic;
						if ($jumlahVendorPic != 0) $picKonsultandanVendorbyUserTotal[$u['name']][$tip['tipe']] = round($vendoruser['nominal']);
						if ($jumlahVendorPic != 0) {
							$dataUsers[] = $u['name'];
							$dataKategori[] = $tip['tipe'];
						}
					}
				}

				foreach ($status as $stt) {
					$this->db->select('COUNT(0) as jml');
					$vendorstatus = $this->mymodel->selectDataone('vendor', ['is_kegiatan_terlaksana' => 1, 'kategori' => $kat['kategori'], 'tipe_id' => 0, 'YEAR(tanggal)' => $year, 'penilaian_hasil' => $stt]);
					if ($vendorstatus != 0) $kategoriDanJumlahKonsultanVendorStatus[$kat['kategori']][$stt]['Lainnya'] = $vendorstatus['jml'];
				}


				$this->db->select('COUNT(0) as jml,(SUM(nilai_jasa)) as nominal');
				$vendor = $this->mymodel->selectDataone('vendor', ['is_kegiatan_terlaksana' => 1, 'tipe_id' => 0, 'kategori' => $kat['kategori'], 'YEAR(tanggal)' => $year]);
				$kategoriDanJumlahKonsultanVendor[$kat['kategori']]['Lainnya'] = $vendor['jml'];
				$vendor['nominal'] = round($vendor['nominal']);
				$kategoriDanNominalKonsultanVendor[$kat['kategori']]['Lainnya'] = $vendor['nominal'];

				$this->db->select('COUNT(0) as jml,(SUM(nilai_jasa)) as nominal');
				$vendor = $this->mymodel->selectDataone('vendor', ['is_kegiatan_terlaksana' => 0, 'tipe_id' => 0, 'kategori' => $kat['kategori'], 'YEAR(tanggal)' => $year]);
				$kategoriDanJumlahKonsultanVendorCancel[$kat['kategori']]['Lainnya'] = $vendor['jml'];




				// PIC user vendor
				$user = $this->mymodel->selectWhere('user', []);
				foreach ($user as $u) {

					$this->db->select('COUNT(0) as jml, (SUM(nilai_jasa)) as nominal');
					$this->db->like('pic', '"' . $u['id'] . '"', 'both');
					$vendoruser = $this->mymodel->selectDataone('vendor', ['is_kegiatan_terlaksana' => 1, 'tipe_id' => 0, 'YEAR(tanggal)' => $year]);
					$jumlahVendorPic = $vendoruser['jml'];
					if ($jumlahVendorPic != 0) {
						$picKonsultandanVendor['Lainnya'][$u['name']] = $jumlahVendorPic;
						$dataUsers[] = $u['name'];
						$dataKategori[] = "Lainnya";
					}
					if ($jumlahVendorPic != 0) $picKonsultandanVendorbyUser[$u['name']]['Lainnya'] = $jumlahVendorPic;
					if ($jumlahVendorPic != 0) $picKonsultandanVendorbyUserTotal[$u['name']]['Lainnya'] = round($vendoruser['nominal']);
				}
			} else if ($get == "bagian-2") {
			}
		}

		$unique_kategori = array_unique($dataKategori);
		$unique_user = array_unique($dataUsers);


		foreach ($unique_kategori as $uk) {
			$data = [];
			foreach ($unique_user as $us) {
				$data[] = round($picKonsultandanVendor[$uk][$us]);
			}
			$JsonpicKonsultandanVendor[] = [
				"name" => $uk,
				"data" => $data
			];
		}

		foreach ($unique_user as $us) {
			$data = [];
			foreach ($unique_kategori as $uk) {
				$data[] = round($picKonsultandanVendorbyUserTotal[$us][$uk]);
			}

			$JsonpicKonsultandanVendorbyUserTotal[] = [
				"name" => $us,
				"data" => $data
			];
		}




		$data = [
			'kategoriDanJumlahKonsultanVendor' => $kategoriDanJumlahKonsultanVendor,
			'kategoriDanJumlahKonsultanVendorCancel' => $kategoriDanJumlahKonsultanVendorCancel,

			'kategoriDanNominalKonsultanVendor' => $kategoriDanNominalKonsultanVendor,
			'kategoriDanJumlahKonsultanVendorStatus' => $kategoriDanJumlahKonsultanVendorStatus,
			'picKonsultandanVendor' => $picKonsultandanVendor,
			'picKonsultandanVendorbyUser' => $picKonsultandanVendorbyUser,
			'picKonsultandanVendorbyUserTotal' => $picKonsultandanVendorbyUserTotal,
			'user' => $unique_user,
			'kategori' => $unique_kategori,
			'JsonpicKonsultandanVendor' => $JsonpicKonsultandanVendor,
			'JsonpicKonsultandanVendorbyUserTotal' => $JsonpicKonsultandanVendorbyUserTotal,

		];
		echo json_encode($data);
	}


	public function test()
	{
		// echo json_encode($this->controllerlist->getControllers());

		$file = $this->get_uri();
		foreach ($file['file'] as $controller) {
			$con[] = $controller;
			$fol[] = '';
		}
		foreach ($file['folder'] as $folder) {
			$files = $this->get_uri('/' . $folder);
			foreach ($files['file'] as $controller) {
				$con[] = $controller;
				$fol[] = $folder . '/';
			}
		}
		$i = 0;
		foreach ($con as $ctrl) {
			if ($fol[$i] != "api/") {
				include_once APPPATH . 'controllers/' . $fol[$i] . $ctrl;
				$methods = get_class_methods(str_replace('.php', '', $ctrl));
				foreach ($methods as $mt) {
					$data[] = array(
						'folder' => str_replace("/", "", $fol[$i]),
						'class' => str_replace('.php', '', $ctrl),
						'method' => $mt,
						'val' => strtolower($fol[$i] . str_replace('.php', '', $ctrl) . "/" . $mt),
					);
				}
			}
			$i++;
		}

		echo json_encode($data);
	}

	public function test2()
	{
		echo $this->router->fetch_directory();
		echo $this->router->fetch_class();
		echo $this->router->fetch_method();
	}

	public function cache()
	{
	}


	public function encodeId()
	{
		echo $this->template->sonEncode($_GET['id']);
	}
}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */