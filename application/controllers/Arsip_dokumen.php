<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Arsip_dokumen extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data['page_name'] = "List Surat";
		$data['view_menu'] = $this->view_menu();
		$this->template->load('template/template', 'arsip_dokumen/index', $data);
	}

	public function surat_masuk()
	{
		$data['page_name'] = "SURAT MASUK";
		$data['view_menu'] = $this->view_menu();
		$this->template->load('template/template', 'arsip_dokumen/index', $data);
	}

	public function surat_keluar()
	{
		$data['page_name'] = "SURAT KELUAR";
		$data['view_menu'] = $this->view_menu_keluar();
		$this->template->load('template/template', 'arsip_dokumen/surat_keluar', $data);
	}

	public function booking()
	{
		$data['page_name'] = "List Booking Slot";
		$data['view_menu'] = $this->view_menu_keluar();
		$this->template->load('template/template', 'arsip_dokumen/booking_slot', $data);
	}

	public function add($id = '')
	{
		$data['page_name'] = "Tambah Permohonan Surat Masuk";
		$data['view_menu'] = $this->view_menu();
		$data['arsip'] = $this->mymodel->selectDataone('arsip_dokumen', array('ad_id' => $id));
		$data['id_arsip'] = $id;
		$this->db->order_by('ad_id', 'desc');
		$data['lastid'] = $this->db->get('arsip_dokumen')->row_array();
		$this->template->load('template/template', 'arsip_dokumen/add', $data);
	}
	public function addSuratKeluar($id = '')
	{
		$data['page_name'] = "Tambah Permohonan Surat Keluar";
		$data['view_menu'] = $this->view_menu_keluar();
		$data['arsip'] = $this->mymodel->selectDataone('arsip_dokumen', array('ad_id' => $id));
		$data['tipe_surat_keluar'] = $this->mymodel->selectWhere('tipe_surat_keluar', ['status' => 'ENABLE']);
		$data['id_arsip'] = $id;
		$array_no = explode(".", $data['arsip']['ad_nomorsurat']);
		$data['current_no'] = substr($array_no[1], 0, 4);
		$this->template->load('template/template', 'arsip_dokumen/add-surat-keluar', $data);
	}
	public function view_menu()
	{
		$role_user = $this->session->userdata('role_slug');
		$jabatan_user = $this->session->userdata('jabatan');
		$departement_user = $this->session->userdata('departement');

		$this->db->select('COUNT(*) as total');
		if ($this->session->userdata('role_slug') != 'super_admin' && $this->session->userdata('role_slug') != 'sekretaris_divisi') {
			$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id AND adl_isaktif="1"', 'left');
			$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_penerima = "' . $this->session->userdata('id') . '"');
		}
		$this->db->where('status', 'draft');
		$this->db->where('ad_tipesurat', 'Surat Masuk');
		$data['draft'] = $this->mymodel->selectDataone('arsip_dokumen', []);

		$this->db->select('count(ad_nomorsurat) as total');
		if ($role_user == 'kepala_departemen' and $jabatan_user == 'Admin Department Head') {
			$this->db->where('arsip_dokumen.status', 'didisposisikan');
			$this->db->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut');
			$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
			$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id');

			$this->db->group_start();
			$this->db->where("adld_id_penerima in (select id from user where role_slug ='kepala_departemen' AND jabatan = 'Department Head' AND departemen = $departement_user ) ");
			$this->db->or_where('adld_id_penerima', $this->session->userdata('id'));
			$this->db->group_end();
		} elseif ($role_user == 'sekretaris_divisi') {
			$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
			$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id');
		} else {
			if ($role_user == 'kepala_divisi') {
				$this->db->group_start();
				$this->db->where('arsip_dokumen.status', 'didisposisikan');
				$this->db->or_where('arsip_dokumen.status', 'diajukan');
				$this->db->group_end();
			} else {
				$this->db->where('arsip_dokumen.status', 'didisposisikan');
			}
			$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
			$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_penerima = "' . $this->session->userdata('id') . '" AND adld_id_pengirim != "' . $this->session->userdata('id') . '" ');
			if ($role_user == 'officer') {
				$this->db->where('adld_is_tindaklanjut!=', '1');
			}
		}

		// if ($this->session->userdata('role_slug')=='super_admin' && $this->session->userdata('role_slug')!='sekretaris_divisi') {
		// 	$this->db->where('status', 'diajukan');
		// } else {
		$this->db->where('status', 'didisposisikan');
		// }
		$this->db->where('ad_tipesurat', 'Surat Masuk');
		if (($this->session->userdata('role_slug') != 'super_admin' and $this->session->userdata('role_slug') != 'sekretaris_divisi' and $this->session->userdata('role_slug') != 'kepala_divisi')) {
			$this->db->join('arsip_dokumen_departement', 'ad_id = add_id_arsip_dokumen');
			$this->db->where('add_id_departement', $this->session->userdata('departement'));
		}
		$this->db->where('arsip_dokumen.status!=', 'dihapus');
		// $this->db->group_by('ad_nomorsurat');
		$data['inbox'] = $this->mymodel->selectDataone('arsip_dokumen', []);

		$this->db->select('COUNT(*) as total');
		if ($this->session->userdata('role_slug') != 'super_admin' && $this->session->userdata('role_slug') != 'sekretaris_divisi') {
			$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id AND adl_isaktif="1"', 'left');
			$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_penerima = "' . $this->session->userdata('id') . '"');
		}
		$this->db->where('status', 'void');
		$data['void'] = $this->mymodel->selectDataone('arsip_dokumen', []);

		return $this->load->view('arsip_dokumen/menu', $data, TRUE);
	}

	public function view_menu_keluar()
	{
		$this->db->select('COUNT(*) as total');
		if ($this->session->userdata('role_slug') != 'super_admin' && $this->session->userdata('role_slug') != 'sekretaris_divisi') {
			$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id AND adl_isaktif="1"', 'left');
			$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_penerima = "' . $this->session->userdata('id') . '"');
		}
		$this->db->where('ad_tipesurat', 'Surat Keluar');
		$data['surat_keluar'] = $this->mymodel->selectDataone('arsip_dokumen', []);
		return $this->load->view('arsip_dokumen/menu_surat_keluar', $data, TRUE);
	}
	public function saveArsip()
	{
		// ini_set('max_execution_time',     70000000);
		ini_set('max_execution_time', 100000000000);
		ini_set('memory_limit', 100000000000);
		ini_set('post_max_size', 100000000000);
		ini_set('upload_max_filesize', 100000000000);

		$datapost = $this->input->post();
		$dt = $datapost['dt'];
		if (trim($dt['ad_nomorsurat']) == '') {
			echo 'Nomor Surat tidak boleh kosong!';
			return FALSE;
		}

		$this->db->where('status !=', 'dihapus');
		$this->db->where('ad_id !=', $_POST['id']);
		$cek_nomor = $this->db->get_where('arsip_dokumen', [
			'ad_nomorsurat' => $dt['ad_nomorsurat'],
		])->num_rows();
		if ($cek_nomor > 0) {
			echo 'Nomor Surat sudah pernah dibuat!';
			return FALSE;
		}

		$dt['created_at'] = date('Y-m-d H:i:s');
		$dt['created_by'] = $this->session->userdata('id');
		$dt['ad_is_booking'] = 0;
		$dt['status'] = "diajukan";
		if ($this->input->post('draft') == 'y') {
			$dt['status'] = 'draft';
		}
		if (!empty($_FILES['file_tindak_lanjut']['name'])) {
			$dt['ad_file_tindaklanjut'] = $this->upload_file_dir('file_tindak_lanjut', 'webfile/')['message']['dir'];
		}

		if ($datapost['id'] != '') {
			$this->db->update('arsip_dokumen', $dt, array('ad_id' => $datapost['id']));
			$id_arsip = $datapost['id'];

			if ($dt['ad_kategorisurat_id'] != '') {
				$this->db->select('arsip_dokumen.ad_id,arsip_dokumen.ad_kategorisurat_id,m_departemen.nama,arsip_dokumen.created_at,arsip_dokumen.created_by');
				$this->db->join('m_departemen', 'arsip_dokumen.ad_kategorisurat_id = m_departemen.id');
				$this->db->where('ad_tipesurat', 'Surat Masuk');
				$this->db->where('ad_id', $id_arsip);
				$data_arsip = $this->db->get('arsip_dokumen')->row_array();

				$data_update = [
					'add_id_departement' => $dt['ad_kategorisurat_id'],
					'add_nama_departement' => $data_arsip['nama'],
					'created_at' => $data_arsip['created_at'],
					'created_by' => $data_arsip['created_by'],
				];

				$this->db->where('add_id_arsip_dokumen', $id_arsip);
				$this->db->update('arsip_dokumen_departement', $data_update);
			}
		} else {
			unset($dt['id']);
			$this->db->insert('arsip_dokumen', $dt);
			$id_arsip = $this->db->insert_id();

			// insert ke table arsip departement

			if ($dt['ad_kategorisurat_id'] != '') {
				$this->db->select('arsip_dokumen.ad_id,arsip_dokumen.ad_kategorisurat_id,m_departemen.nama,arsip_dokumen.created_at,arsip_dokumen.created_by');
				$this->db->join('m_departemen', 'arsip_dokumen.ad_kategorisurat_id = m_departemen.id');
				$this->db->where('ad_tipesurat', 'Surat Masuk');
				$this->db->where('ad_id', $id_arsip);
				$data_arsip = $this->db->get('arsip_dokumen')->row_array();

				$data_insert = [
					'add_id_arsip_dokumen' => $id_arsip,
					'add_id_departement' => $dt['ad_kategorisurat_id'],
					'add_nama_departement' => $data_arsip['nama'],
					'created_at' => $data_arsip['created_at'],
					'created_by' => $data_arsip['created_by'],
					'add_tipe_surat' => 'Surat Masuk'
				];

				$this->db->insert('arsip_dokumen_departement', $data_insert);
			}
		}
		if ($this->input->post('draft') == 'n') {
			$this->updateStatusArsipDokumen($id_arsip, 'diajukan', 'Diajukan Oleh sekretaris_divisi');
		}

		$this->mymodel->updateData('arsip_dokumen_log', array('adl_isaktif' => 0), array('adl_id_arsip_dokumen' => $id_arsip));
		$arrayinsertlog = array(
			'adl_id_arsip_dokumen' => $id_arsip,
			'adl_isi_disposisi' => '-',
			'adl_status' => 'diajukan',
			'adl_waktu' => date('Y-m-d H:i:s'),
			'adl_isaktif' => 1,
		);
		$this->mymodel->insertData('arsip_dokumen_log', $arrayinsertlog);
		$idlog = $this->db->insert_id();

		$arrayinsertlogdetail = array(
			'adld_id_arsip_dokumen' => $id_arsip,
			'adld_id_arsip_dokumen_log' => $idlog,
			'adld_id_pengirim' => $this->session->userdata('id'),
			'adld_id_penerima' => $this->session->userdata('id'),
			'adld_isread' => 1,
		);
		$this->mymodel->insertData('arsip_dokumen_log_detail', $arrayinsertlogdetail);
		$logdetail[] = $arrayinsertlogdetail;

		$this->mymodel->updateData('arsip_dokumen_log', array('adl_json_detail' => json_encode($logdetail)), array('adl_id' => $idlog));

		//rename file surat
		$new_file_name = $dt['ad_nomorsurat'] . '.pdf';
		$path_file = $this->db->get_where('arsip_dokumen', ['ad_id' => $id_arsip])->row()->ad_lampiran;
		$array_path = explode('/', $path_file);
		if (count($array_path) == 6) {
			$id_file = $array_path[5];
			$data_rename = [
				'id' => $id_file,
				'name' => $new_file_name
			];
			$this->renameFileCloud($data_rename);
		}

		//insert data lampiran
		$list_lampiran = $this->input->post('path');
		$list_keterangan = $this->input->post('keterangan');
		$list_password = $this->input->post('password');
		foreach ($list_lampiran as $index => $lampiran) {

			// rename file lampiran
			$nama_file_lampiran = $dt['ad_nomorsurat'] . "- Lampiran " . $list_keterangan[$index] . '.pdf';
			$array_path_lampiran = explode('/', $lampiran);
			$id_file_lampiran = $array_path_lampiran[5];

			$data_rename_lampiran = [
				'id' => $id_file_lampiran,
				'name' => $nama_file_lampiran
			];

			$this->renameFileCloud($data_rename_lampiran);

			$data_insert = [
				'path' => $lampiran,
				'keterangan' => $list_keterangan[$index],
				'password' => $list_password[$index],
				'arsip_dokumen_id' => $id_arsip,
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('id')
			];
			$this->mymodel->insertData('lampiran_surat', $data_insert);
		}

		echo  json_encode(
			[
				'status' => 'success',
				'id' => $id_arsip
			]
		);
	}
	public function saveArsipSuratKeluar()
	{

		ini_set('max_execution_time', 100000000000);
		ini_set('memory_limit', 100000000000);
		ini_set('post_max_size', 100000000000);
		ini_set('upload_max_filesize', 100000000000);

		$datapost = $this->input->post();
		$dt = $datapost['dt'];

		$this->db->where('status !=', 'dihapus');
		$this->db->where('ad_id !=', $_POST['id']);
		$cek_nomor = $this->db->get_where('arsip_dokumen', [
			'ad_nomorsurat' => $dt['ad_nomorsurat'],
		])->num_rows();
		if ($cek_nomor > 0) {
			echo 'Nomor Surat sudah pernah dibuat!';
			return FALSE;
		}

		$dt['created_at'] = date('Y-m-d H:i:s');
		$dt['created_by'] = $this->session->userdata('id');
		$dt['status'] = "selesai";
		$dt['ad_is_booking'] = 0;
		$departemen = $this->mymodel->selectDataone('m_departemen', array('id' => $dt['ad_departemen']));
		// $dt['ad_kategorisurat_id'] = $dt['ad_departemen'];
		$dt['ad_kategorisurat_code'] = $departemen['code'];
		$dt['ad_kategorisurat'] = $departemen['nama'];
		// if(!empty($_FILES['file_tindak_lanjut']['name'])){
		// 	$dt['ad_file_tindaklanjut'] = $this->upload_file_dir('file_tindak_lanjut','webfile/')['message']['dir'];
		// }
		if ($datapost['id'] != '') {
			$this->db->update('arsip_dokumen', $dt, array('ad_id' => $datapost['id']));
			$id_arsip = $datapost['id'];

			if ($dt['ad_departemen'] != '') {
				$this->db->select('arsip_dokumen.ad_id,arsip_dokumen.ad_departemen,m_departemen.nama,arsip_dokumen.created_at,arsip_dokumen.created_by');
				$this->db->join('m_departemen', 'arsip_dokumen.ad_departemen = m_departemen.id');
				$this->db->where('ad_tipesurat', 'Surat Keluar');
				$this->db->where('ad_id', $id_arsip);
				$data_arsip = $this->db->get('arsip_dokumen')->row_array();

				$check_arsip_department = $this->db->get_where('arsip_dokumen_departement', ['add_id_arsip_dokumen' => $id_arsip])->num_rows();
				if ($check_arsip_department == 0) {
					$data_insert = [
						'add_id_arsip_dokumen' => $id_arsip,
						'add_id_departement' => $dt['ad_departemen'],
						'add_nama_departement' => $data_arsip['nama'],
						'created_at' => $data_arsip['created_at'],
						'created_by' => $data_arsip['created_by'],
						'add_tipe_surat' => 'Surat Keluar'
					];

					$this->db->insert('arsip_dokumen_departement', $data_insert);
				} else {
					$data_update = [
						'add_id_departement' => $dt['ad_departemen'],
						'add_nama_departement' => $data_arsip['nama'],
						'created_at' => $data_arsip['created_at'],
						'created_by' => $data_arsip['created_by'],
					];

					$this->db->where('add_id_arsip_dokumen', $id_arsip);
					$this->db->update('arsip_dokumen_departement', $data_update);
				}
			}
		} else {
			unset($dt['id']);
			$this->db->insert('arsip_dokumen', $dt);
			$id_arsip = $this->db->insert_id();

			if ($dt['ad_departemen'] != '') {
				$this->db->select('arsip_dokumen.ad_id,arsip_dokumen.ad_departemen,m_departemen.nama,arsip_dokumen.created_at,arsip_dokumen.created_by');
				$this->db->join('m_departemen', 'arsip_dokumen.ad_departemen = m_departemen.id');
				$this->db->where('ad_tipesurat', 'Surat Keluar');
				$this->db->where('ad_id', $id_arsip);
				$data_arsip = $this->db->get('arsip_dokumen')->row_array();

				$data_insert = [
					'add_id_arsip_dokumen' => $id_arsip,
					'add_id_departement' => $dt['ad_departemen'],
					'add_nama_departement' => $data_arsip['nama'],
					'created_at' => $data_arsip['created_at'],
					'created_by' => $data_arsip['created_by'],
					'add_tipe_surat' => 'Surat Keluar'
				];

				$this->db->insert('arsip_dokumen_departement', $data_insert);
			}
		}

		// $this->updateStatusArsipDokumen($datapost['id'],'diajukan','Diajukan Oleh sekretaris_divisi');

		// $this->mymodel->updateData('arsip_dokumen_log',array('adl_isaktif'=>0),array('adl_id_arsip_dokumen'=>$datapost['id']));
		// $arrayinsertlog = array(
		// 	'adl_id_arsip_dokumen' => $datapost['id'],
		// 	'adl_isi_disposisi' => '-',
		// 	'adl_status' => 'diajukan',
		// 	'adl_waktu' => date('Y-m-d H:i:s'),
		// 	'adl_isaktif' => 1,
		// );
		// $this->mymodel->insertData('arsip_dokumen_log',$arrayinsertlog);
		// $idlog = $this->db->insert_id();

		// $arrayinsertlogdetail = array(
		// 	'adld_id_arsip_dokumen' => $datapost['id'],
		// 	'adld_id_arsip_dokumen_log' => $idlog,
		// 	'adld_id_pengirim' => $this->session->userdata('id'),
		// 	'adld_id_penerima' => $this->session->userdata('id'),
		// 	'adld_isread' => 1,
		// );
		// $this->mymodel->insertData('arsip_dokumen_log_detail',$arrayinsertlogdetail);
		// $logdetail[] = $arrayinsertlogdetail;

		// $this->mymodel->updateData('arsip_dokumen_log',array('adl_json_detail'=>json_encode($logdetail)),array('adl_id'=>$idlog));

		//rename file surat
		$new_file_name = $dt['ad_nomorsurat'] . '.pdf';
		$path_file = $this->db->get_where('arsip_dokumen', ['ad_id' => $id_arsip])->row()->ad_lampiran;
		$array_path = explode('/', $path_file);
		if (count($array_path) == 6) {
			$id_file = $array_path[5];
			$data_rename = [
				'id' => $id_file,
				'name' => $new_file_name
			];
			$this->renameFileCloud($data_rename);
		}

		//insert data lampiran
		$list_lampiran = $this->input->post('path');
		$list_keterangan = $this->input->post('keterangan');
		$list_password = $this->input->post('password');
		foreach ($list_lampiran as $index => $lampiran) {

			// rename file lampiran
			$nama_file_lampiran = $dt['ad_nomorsurat'] . "- Lampiran " . $list_keterangan[$index] . '.pdf';
			$array_path_lampiran = explode('/', $lampiran);
			$id_file_lampiran = $array_path_lampiran[5];

			$data_rename_lampiran = [
				'id' => $id_file_lampiran,
				'name' => $nama_file_lampiran
			];

			$this->renameFileCloud($data_rename_lampiran);

			$data_insert = [
				'path' => $lampiran,
				'keterangan' => $list_keterangan[$index],
				'password' => $list_password[$index],
				'arsip_dokumen_id' => $id_arsip,
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('id')
			];
			$this->mymodel->insertData('lampiran_surat', $data_insert);
		}

		echo json_encode(
			[
				'status' => 'success',
				'id' => $id_arsip
			]
		);
	}
	public function aksiTindakLanjut()
	{
		$dt = $this->input->post();
		$data = array(
			'ad_tindaklanjut' => $dt['ad_tindaklanjut'],
			'status_message' => 'Telah Ditindak Lanjuti Oleh Officer',
			'status' => 'ditindaklanjuti'
		);
		if (!empty($_FILES['file_tindak_lanjut']['name'])) {
			$data['ad_file_tindaklanjut'] = $this->upload_file_dir('file_tindak_lanjut', 'webfile/tindak-lanjut/')['message']['dir'];
		}
		$this->mymodel->updateData('arsip_dokumen', $data, array('ad_id' => $dt['id']));

		$arrayinsertlog = array(
			'adl_id_arsip_dokumen' => $dt['id'],
			'adl_isi_disposisi' => '-',
			'adl_status' => 'Ditindak Lanjuti',
			'adl_waktu' => date('Y-m-d H:i:s'),
			'adl_isaktif' => 1,
		);
		$this->mymodel->insertData('arsip_dokumen_log', $arrayinsertlog);
		$idlog = $this->db->insert_id();

		$arrayinsertlogdetail = array(
			'adld_id_arsip_dokumen' => $dt['id'],
			'adld_id_arsip_dokumen_log' => $idlog,
			'adld_id_pengirim' => $this->session->userdata('id'),
			'adld_id_penerima' => $this->session->userdata('id'),
			'adld_isread' => 1,
		);
		$this->mymodel->insertData('arsip_dokumen_log_detail', $arrayinsertlogdetail);
		$logdetail[] = $arrayinsertlogdetail;
		$this->mymodel->updateData('arsip_dokumen_log', array('adl_json_detail' => json_encode($logdetail)), array('adl_id' => $idlog));

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function aksiTindakLanjut_new()
	{
		$dt = $this->input->post();
		$id = $dt['id'];

		$role_slug = $this->session->userdata('role_slug');
		if (in_array($role_slug, ['super_admin', 'kepala_departemen', 'sekretaris_divisi'])) {
			$data_log_detail = $this->mymodel->selectDataone('arsip_dokumen_log_detail', ['adld_id_arsip_dokumen' => $dt['id'], 'adld_id_arsip_dokumen_log' => $dt['adld_id_arsip_dokumen_log']]);
			$data_insert = [
				'adld_id_arsip_dokumen' => $dt['id'],
				'adld_id_arsip_dokumen_log' => $dt['adld_id_arsip_dokumen_log'],
				'adld_id_pengirim' => $data_log_detail['adld_id_pengirim'],
				'adld_id_penerima' => $this->session->userdata('id'),
			];
			$this->db->insert('arsip_dokumen_log_detail', $data_insert);
		}
		foreach ($_FILES['adld_file_tindaklanjut']['name'] as $key => $image) {
			$file_tindak_lanjut = NULL;
			if ($image != '') {
				$adld_id = $this->db->get_where('arsip_dokumen_log_detail', ['adld_id_arsip_dokumen' => $dt['id'], 'adld_id_arsip_dokumen_log' => $dt['adld_id_arsip_dokumen_log'], 'adld_id_penerima' => $this->session->userdata('id')])->row()->adld_id;
				$data_adld = $this->db->get_where('arsip_dokumen_log_detail', ['adld_id' => $adld_id])->row_array();
				$data_surat = $this->db->get_where('arsip_dokumen', ['ad_id' => $data_adld['adld_id_arsip_dokumen']])->row_array();

				$_FILES['images']['name'] = $_FILES['adld_file_tindaklanjut']['name'][$key];
				$_FILES['images']['type'] = $_FILES['adld_file_tindaklanjut']['type'][$key];
				$_FILES['images']['tmp_name'] = $_FILES['adld_file_tindaklanjut']['tmp_name'][$key];
				$_FILES['images']['error'] = $_FILES['adld_file_tindaklanjut']['error'][$key];
				$_FILES['images']['size'] = $_FILES['adld_file_tindaklanjut']['size'][$key];

				$dir = 'webfile/tindak-lanjut/';
				$namafile = $data_surat['ad_nomorsurat'] . '_lampiran_' . $dt['adld_catatan_tindaklanjut'][$key];
				$config['upload_path']          = $dir;
				$config['allowed_types']        = '*';
				$config['max_size'] 			= '64000';
				// $config['file_name']           	= $namafile;
				$this->load->library('upload', $config);
				$this->upload->do_upload('images');
				$data_file = $this->upload->data();
				$file_tindak_lanjut = $dir . $data_file['file_name'];

				// add password dan qr code
				if (in_array($data_surat['ad_sifatsurat'], ['rahasia', 'sangat_rahasia'])) {
					$this->checkAndConvertPDF($data_file['full_path']);
					$this->addQRCodeToPDF($file_tindak_lanjut);
					$password =  substr(md5(date('Y-m-d H:i:s')), 0, 6);
					$this->encryptPDF($file_tindak_lanjut, $password, $file_tindak_lanjut);
				}
			}
			$adld_id = $this->db->get_where('arsip_dokumen_log_detail', ['adld_id_arsip_dokumen' => $dt['id'], 'adld_id_arsip_dokumen_log' => $dt['adld_id_arsip_dokumen_log'], 'adld_id_penerima' => $this->session->userdata('id')])->row()->adld_id;
			$data_adld = $this->db->get_where('arsip_dokumen_log_detail', ['adld_id' => $adld_id])->row_array();


			$data_insert = [
				'adld_id' => $adld_id,
				'adld_id_arsip_dokumen_log' => $data_adld['adld_id_arsip_dokumen_log'],
				'adld_id_arsip_dokumen' => $data_adld['adld_id_arsip_dokumen'],
				'id_penerima' => $data_adld['adld_id_penerima'],
				'catatan_tindaklanjut' => $dt['adld_catatan_tindaklanjut'][$key],
				'file_tindaklanjut' => $file_tindak_lanjut,
			];
			if (in_array($data_surat['ad_sifatsurat'], ['rahasia', 'sangat_rahasia'])) {
				$data_insert['password_file'] = $password;
			}
			$this->db->insert('lampiran_tindaklanjut', $data_insert);
		}
		// foreach($dt['adld_catatan_tindaklanjut'] as $index => $value){
		// 	if(!empty($_FILES['adld_file_tindaklanjut']['name'][$index])){
		// 		$upload = $this->upload_file_dir('adld_file_tindaklanjut','webfile/tindak-lanjut/');
		// 		// $dt['adld_file_tindaklanjut'][] = $this->upload_file_dir('adld_file_tindaklanjut','webfile/tindak-lanjut/')['message']['dir'];
		// 		dump_variable($upload);
		// 	}	
		// }


		$adld_id = $this->db->get_where('arsip_dokumen_log_detail', ['adld_id_arsip_dokumen' => $dt['id'], 'adld_id_arsip_dokumen_log' => $dt['adld_id_arsip_dokumen_log'], 'adld_id_penerima' => $this->session->userdata('id')])->row()->adld_id;
		unset($dt['id']);
		unset($dt['adld_catatan_tindaklanjut']);
		$this->mymodel->updateData('arsip_dokumen_log_detail', $dt, array('adld_id' => $adld_id));
		// die(dump_variable($dt));
		$counter = 0;
		$this->db->select('arsip_dokumen_log_detail.* , user.name as nama_penerima , user_pengirim.name as nama_pengirim,user.role_slug as role_penerima');
		$this->db->join('user', 'user.id = arsip_dokumen_log_detail.adld_id_penerima', 'left');
		$this->db->join('user user_pengirim', 'user_pengirim.id = arsip_dokumen_log_detail.adld_id_pengirim', 'left');
		$list_penindaklanjut = $this->db->get_where('arsip_dokumen_log_detail', [
			'adld_id_arsip_dokumen' => $id,
			'adld_id_arsip_dokumen_log' => $dt['adld_id_arsip_dokumen_log'],
			'user.role_slug' => 'officer'
		])->result_array();
		// die(dump_variable($list_penindaklanjut));
		foreach ($list_penindaklanjut as $list) {
			if ($list['adld_is_tindaklanjut'] == 1) $counter++;
		}

		if ($counter >= count($list_penindaklanjut)) {

			$data = array(
				// 'ad_tindaklanjut'=>$dt['ad_tindaklanjut'],
				'status_message' => 'Telah Ditindak Lanjuti Oleh Officer',
				'status' => 'ditindaklanjuti'
			);
			$this->mymodel->updateData('arsip_dokumen', $data, array('ad_id' => $id));
		}


		$arrayinsertlog = array(
			'adl_id_arsip_dokumen' => $id,
			'adl_isi_disposisi' => '-',
			'adl_status' => 'Ditindak Lanjuti',
			'adl_waktu' => date('Y-m-d H:i:s'),
			'adl_isaktif' => 1,
		);
		$this->mymodel->insertData('arsip_dokumen_log', $arrayinsertlog);
		$idlog = $this->db->insert_id();

		$arrayinsertlogdetail = array(
			'adld_id_arsip_dokumen' => $id,
			'adld_id_arsip_dokumen_log' => $idlog,
			'adld_id_pengirim' => $this->session->userdata('id'),
			'adld_id_penerima' => $this->session->userdata('id'),
			'adld_isread' => 1,
		);
		$this->mymodel->insertData('arsip_dokumen_log_detail', $arrayinsertlogdetail);
		$logdetail[] = $arrayinsertlogdetail;
		$this->mymodel->updateData('arsip_dokumen_log', array('adl_json_detail' => json_encode($logdetail)), array('adl_id' => $idlog));

		redirect($_SERVER['HTTP_REFERER']);
	}
	public function getSonEncode($id)
	{
		echo $this->template->sonEncode($id);
	}
	public function saveDraft()
	{
		$datapost = $this->input->post();
		$dt = $datapost['dt'];

		$this->db->where('status !=', 'dihapus');
		$this->db->where('ad_id !=', $_POST['id']);
		$cek_nomor = $this->db->get_where('arsip_dokumen', [
			'ad_nomorsurat' => $dt['ad_nomorsurat'],
		])->num_rows();
		if ($cek_nomor > 0) {
			echo 'Nomor Surat sudah pernah dibuat!';
			return FALSE;
		}

		$cek = $this->mymodel->selectDataone('arsip_dokumen', array('ad_id' => $datapost['id']));
		$dt['ad_kategorisurat_id'] = (int)$dt['ad_kategorisurat_id'];
		if ($dt['ad_tipesurat'] == 'Surat Masuk') {
			$departemen = $this->mymodel->selectDataone('m_departemen', array('id' => $dt['ad_kategorisurat_id']));
		} else {
			$departemen = $this->mymodel->selectDataone('m_departemen', array('id' => $dt['ad_departemen']));
		}
		$dt['ad_kategorisurat_code'] = $departemen['code'];
		$dt['ad_kategorisurat'] = $departemen['nama'];
		$dt['ad_is_booking'] = 1;

		if ($cek['ad_id']) {
			$this->db->update('arsip_dokumen', $dt, array('ad_id' => $cek['ad_id']));
		} else {
			$dt['status'] = "draft";
			$dt['created_by'] = $this->session->userdata('id');
			$this->db->insert('arsip_dokumen', $dt);
		}

		echo json_encode(
			[
				'status' => 'success',
				'id' => $id_arsip
			]
		);
		// echo $this->db->last_query();
	}
	public function aksiVoid($id)
	{
		$this->updateStatusArsipDokumen($id, 'void', 'Divoid Oleh ' . $this->session->userdata('role_name'));
		$this->mymodel->updateData('arsip_dokumen_log', array('adl_isaktif' => 0), array('adl_id_arsip_dokumen' => $id));
		$arrayinsertlog = array(
			'adl_id_arsip_dokumen' => $id,
			'adl_isi_disposisi' => '-',
			'adl_status' => 'void',
			'adl_waktu' => date('Y-m-d H:i:s'),
			'adl_isaktif' => 1,
		);
		$this->mymodel->insertData('arsip_dokumen_log', $arrayinsertlog);
		$idlog = $this->db->insert_id();

		$arrayinsertlogdetail = array(
			'adld_id_arsip_dokumen' => $id,
			'adld_id_arsip_dokumen_log' => $idlog,
			'adld_id_pengirim' => $this->session->userdata('id'),
			'adld_id_penerima' => $this->session->userdata('id'),
			'adld_isread' => 1,
		);
		$this->mymodel->insertData('arsip_dokumen_log_detail', $arrayinsertlogdetail);
		$logdetail[] = $arrayinsertlogdetail;
		redirect('arsip_dokumen?status=void');
	}
	public function getDataArsip()
	{
		$role_user = $this->session->userdata('role_slug');
		$departement_user = $this->session->userdata('departement');
		$this->datatables->select('ad_id , ad_nomorsurat , ad_tanggalsurat , ad_instansipengirim , REPLACE(ad_bentukdokumen,"_"," ") as ad_bentukdokumen , ad_tipesurat , ad_duedate , arsip_dokumen.status , user.name as nama_pengirim,user.role_slug as role_pengirim,ad_tipesurat,arsip_dokumen.created_by,ad_sifatsurat,ad_perihal');
		$this->datatables->group_by('arsip_dokumen.ad_id');
		if (@$_GET['tipe'] == 'inbox') {
			$jabatan_user = $this->session->userdata('jabatan');
			if ($role_user == 'kepala_departemen' and $jabatan_user == 'Admin Department Head') {
				$this->datatables->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
				$this->datatables->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
				$this->datatables->where('arsip_dokumen.status', $_GET['status']);
				$this->datatables->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut');
				$this->datatables->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
				$this->datatables->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id');

				$this->db->group_start();
				$this->datatables->where("adld_id_penerima in (select id from user where role_slug ='kepala_departemen' AND jabatan = 'Department Head' AND departemen = $departement_user ) ");
				$this->datatables->or_where('adld_id_penerima', $this->session->userdata('id'));
				$this->db->group_end();
			} elseif ($role_user == 'sekretaris_divisi') {
				$this->datatables->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
				$this->datatables->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
				$this->datatables->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
				$this->datatables->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id');
			} elseif ($role_user == 'kepala_departemen' and $jabatan_user == 'Department Head' and $departement_user == 5) {
				$this->datatables->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
				$this->datatables->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
				$this->datatables->where('arsip_dokumen.status', $_GET['status']);
				$this->datatables->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut');
				$this->datatables->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
				$this->datatables->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id');

				$this->db->group_start();
				$this->datatables->where("arsip_dokumen.created_by = 111 ");
				$this->datatables->or_where('adld_id_penerima', $this->session->userdata('id'));
				$this->db->group_end();
			} else {
				if ($role_user == 'kepala_divisi') {
					$this->db->group_start();
					$this->datatables->where('arsip_dokumen.status', $_GET['status']);
					$this->datatables->or_where('arsip_dokumen.status', 'diajukan');
					$this->db->group_end();
				} else {
					$this->datatables->where('arsip_dokumen.status', $_GET['status']);
				}

				$this->datatables->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
				$this->datatables->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
				$this->datatables->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
				$this->datatables->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_penerima = "' . $this->session->userdata('id') . '" AND adld_id_pengirim != "' . $this->session->userdata('id') . '" ');
				if ($role_user == 'officer') {
					$this->datatables->where('adld_is_tindaklanjut!=', '1');
				}
			}
		} else if ($_GET['status'] == 'ditindaklanjuti') {
			if ($role_user == 'officer') {
				$this->datatables->where(" arsip_dokumen.status = '$_GET[status]' OR (arsip_dokumen.status = 'didisposisikan' AND adld_is_tindaklanjut = '1') ");
			} else {
				$this->datatables->where('arsip_dokumen.status', $_GET['status']);
			}
			if ($this->session->userdata('role_slug') == 'super_admin' || $this->session->userdata('role_slug') == 'kepala_departemen' || $this->session->userdata('role_slug') == 'sekretaris_divisi') {
				$this->datatables->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
				$this->datatables->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
				$this->datatables->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
				$this->datatables->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id');
			} else {
				$this->datatables->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
				$this->datatables->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
				$this->datatables->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
				$this->datatables->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_penerima = "' . $this->session->userdata('id') . '" AND adld_id_pengirim != "' . $this->session->userdata('id') . '" ');
			}
		} else {
			if (@$_GET['status']) {
				if (@$_GET['status'] == 'draft') {
					$this->datatables->where('arsip_dokumen.ad_tipesurat', 'Surat Masuk');
				}
				$this->datatables->where('arsip_dokumen.status', $_GET['status']);
				if ($this->session->userdata('role_slug') == 'super_admin' || $this->session->userdata('role_slug') == 'kepala_departemen' || $this->session->userdata('role_slug') == 'sekretaris_divisi') {
					$this->datatables->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
					$this->datatables->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
					$this->datatables->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
					$this->datatables->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id');
				} else {
					$this->datatables->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut');
					$this->datatables->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
					$this->datatables->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
					$this->datatables->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_isread = "1" AND adld_id_penerima = "' . $this->session->userdata('id') . '"');
				}
			} else {
				if ($this->session->userdata('role_slug') == 'super_admin' || $this->session->userdata('role_slug') == 'kepala_departemen' || $this->session->userdata('role_slug') == 'sekretaris_divisi') {
					$this->datatables->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
					$this->datatables->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
					$this->datatables->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
					$this->datatables->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id');
					// $this->datatables->where('arsip_dokumen.status', 'diajukan');
				} else {

					$this->datatables->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
					$this->datatables->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
					$this->datatables->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
					$this->datatables->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_penerima = "' . $this->session->userdata('id') . '" AND adld_id_pengirim != "' . $this->session->userdata('id') . '" ');
					$this->datatables->where('arsip_dokumen.status', 'didisposisikan');
				}
			}
		}

		if (@$_GET['sifat']) {
			$this->datatables->where('ad_sifatsurat', $_GET['sifat']);
		}

		if (@$_GET['bentuk']) {
			$this->datatables->where('ad_bentukdokumen', $_GET['bentuk']);
		}

		if (@$_GET['kategori']) {
			$this->datatables->join('arsip_dokumen_departement', 'ad_id = add_id_arsip_dokumen');
			$this->datatables->where('add_id_departement', $_GET['kategori']);
		}

		// if (@$_GET['duedate']) {
		// 	$this->datatables->where('ad_duedate', $_GET['duedate']);
		// }

		if (@$_GET['tanggal_surat'] and @$_GET['tanggal_surat'] != '') {
			$this->datatables->where('ad_tanggalsurat', $_GET['tanggal_surat']);
		}

		if (($this->session->userdata('role_slug') != 'super_admin' and $this->session->userdata('role_slug') != 'sekretaris_divisi' and $this->session->userdata('role_slug') != 'kepala_divisi') or ($this->session->userdata('role_slug') == 'kepala_departemen' and @$_GET['tipe'] == 'inbox')) {
			$this->datatables->join('arsip_dokumen_departement', 'ad_id = add_id_arsip_dokumen');
			$this->datatables->where('add_id_departement', $this->session->userdata('departement'));
		}
		$this->datatables->join('user', 'user.id = arsip_dokumen.dari', 'left');
		$this->datatables->where('ad_tipesurat', 'Surat Masuk');
		$this->datatables->where('arsip_dokumen.status!=', 'dihapus');
		$this->datatables->from('arsip_dokumen');
		echo $this->datatables->generate();
	}
	public function getDataArsipKeluar()
	{
		$this->datatables->select('ad_id , ad_nomorsurat , ad_tanggalsurat , ad_instansipengirim , REPLACE(ad_bentukdokumen,"_"," ") as ad_bentukdokumen , ad_tipesurat , ad_duedate , arsip_dokumen.status , user.name as nama_pengirim,ad_tipesurat,arsip_dokumen.created_by,ad_sifatsurat,ad_perihal');

		$this->datatables->join('user', 'user.id = arsip_dokumen.dari', 'left');
		$this->datatables->where('ad_tipesurat', 'Surat Keluar');
		$this->datatables->where('arsip_dokumen.status !=', 'dihapus');
		$this->datatables->where('ad_is_booking', '0');

		if ($this->session->userdata('role_slug') != 'super_admin' and $this->session->userdata('role_slug') != 'sekretaris_divisi' and $this->session->userdata('role_slug') != 'kepala_divisi') {
			$this->datatables->where('ad_departemen', $this->session->userdata('departement'));
		}

		if (@$_GET['sifat']) {
			$this->datatables->where('ad_sifatsurat', $_GET['sifat']);
		}

		if (@$_GET['bentuk']) {
			$this->datatables->where('ad_bentukdokumen', $_GET['bentuk']);
		}

		// if (@$_GET['kategori']) {
		// 	$this->datatables->where('ad_kategorisurat', $_GET['kategori']);
		// }

		if (@$_GET['duedate']) {
			$this->datatables->where('ad_duedate', $_GET['duedate']);
		}

		if (@$_GET['kategori'] and $_GET['kategori'] != '') {
			$this->datatables->join('arsip_dokumen_departement', 'ad_id = add_id_arsip_dokumen', 'left');
			$this->datatables->where('add_id_departement', @$_GET['kategori']);
		}

		$this->datatables->from('arsip_dokumen');

		echo $this->datatables->generate();
	}
	public function toDetailArsip($idArsip = '')
	{
		$idArsip = $this->template->sonEncode($idArsip);
		redirect(base_url('arsip_dokumen/detail/' . $idArsip), 'refresh');
	}
	public function detail($idArsip)
	{

		$idArsip = $this->template->sonDecode($idArsip);
		$data['list_lampiran'] = $this->db->get_where('lampiran_surat', ['arsip_dokumen_id' => $idArsip])->result_array();

		$data['list_tindak_lanjut'] = $this->db->get_where('arsip_dokumen_log', array('adl_id_arsip_dokumen' => $idArsip, 'adl_status' => 'didisposisikan', 'adl_isaktif' => 1))->row_array();

		$check_surat = $this->db->get_where('arsip_dokumen_log_detail', ['adld_id_arsip_dokumen' => $idArsip, 'adld_id_penerima' => $this->session->userdata('id')])->num_rows();
		if ($check_surat > 0) {
			$this->mymodel->updateData('arsip_dokumen_log_detail', array('adld_isread' => 1), array('adld_id_arsip_dokumen' => $idArsip, 'adld_id_penerima' => $this->session->userdata('id')));
		}


		$data['page_name'] = "Detail Permohonan Surat";
		$data['data'] = $this->mmodel->selectWhere('arsip_dokumen', ['ad_id' => $idArsip])->row();
		if ($data['data']->ad_tipesurat == 'Surat Keluar') {
			$data['view_menu'] = $this->view_menu_keluar();
		} else {
			$data['view_menu'] = $this->view_menu();
		}

		$this->template->load('template/template', 'arsip_dokumen/detail', $data);
	}

	public function uploadPDFWithQRCode($addqrcode = 'yes', $encryptPDF = 'no')
	{
		// error_reporting(-1);
		// ini_set('display_errors', 1);
		// die($addqrcode);
		ini_set('max_execution_time', 100000000000);
		ini_set('memory_limit', 100000000000);
		$filename = uniqid() . '-' . str_replace('.', '', substr($_FILES['file']['name'], 0, strrpos($_FILES['file']['name'], ".")));
		$filename = substr(preg_replace('/[^A-Za-z0-9\-]/', '', $filename), 0, 30);
		$fileupload = $this->upload_file_dir('file', 'webfile/', $filename);
		$this->checkAndConvertPDF($fileupload['message']['full_path']);

		$return = [];
		if ($fileupload['response']) {
			if ($addqrcode == 'yes') {
				$this->addQRCodeToPDF($fileupload['message']['dir']);
			}

			if ($encryptPDF == 'yes') {
				$password =  substr(md5(date('Y-m-d H:i:s')), 0, 6);
				$this->encryptPDF($fileupload['message']['dir'], $password, $fileupload['message']['dir']);
			}

			$return = $this->uploadFileFromServerToCloud($fileupload['message']['dir']);
		}

		@unlink($fileupload['message']['dir']);
		if ($encryptPDF == 'yes') {
			$array_return = json_decode($return, TRUE);
			$array_return['password'] = $password;
			$return = json_encode($array_return);
		}
		echo $return;
	}

	public function addQRCodeToPDF($file)
	{
		require_once(APPPATH . "third_party/fpdf/fpdf.php");
		require_once(APPPATH . "third_party/fpdi/src/autoload.php");

		$this->db->select('ad_id');
		$this->db->order_by('ad_id', 'desc');
		$lastid = $this->mymodel->selectDataone('arsip_dokumen', []);

		$link = base_url('arsip_dokumen/detail/' . $this->template->sonEncode($lastid['ad_id'] + 1) . '?source=qrcode');
		$logo = 'http://digitalcorsec.id/assets/logo_bri.png';
		$content = file_get_contents('http://dev.alfahuma.tech/generate_qrcode.php?qr_content=' . $link . '&qr_logo=' . $logo);
		file_put_contents('webfile/qrcode.jpg', $content);

		$pdf = new \setasign\Fpdi\Fpdi();
		$pdf->AddPage();

		//Set the source PDF file
		$pagecount = $pdf->setSourceFile(APPPATH . "../" . $file);
		//Import the first page of the file
		$tppl = $pdf->importPage(1);
		// //Use this page as template
		// // use the imported page and place it at point 20,30 with a width of 170 mm
		$pdf->useTemplate($tppl, -10, 20, 210);


		// #Print Hello World at the bottom of the page

		// //Select Arial italic 8
		$pdf->Image(base_url('webfile/qrcode.jpg'), 2, 275, 20, 20);
		for ($i = 2; $i <= $pagecount; $i++) {
			$pdf->AddPage();
			$tplId = $pdf->importPage($i);
			$pdf->useTemplate($tplId);
			$pdf->Image(base_url('webfile/qrcode.jpg'), 2, 275, 20, 20);
		}
		$pdf->Output($file, "F");
	}
	public function test()
	{
		$this->db->select('ad_id');
		$this->db->order_by('ad_id', 'desc');
		$lastid = $this->mymodel->selectDataone('arsip_dokumen', []);

		$link = base_url('arsip_dokumen/detail/' . $this->template->sonEncode(124124) . '?source=qrcode');
		$logo = 'http://digitalcorsec.id/assets/logo_bri.png';
		$content = file_get_contents('http://dev.alfahuma.tech/generate_qrcode.php?qr_content=' . $link . '&qr_logo=' . $logo);
		file_put_contents('webfile/qrcode.jpg', $content);

		// echo base_url('webfile/qrcode.png');
	}

	public function aksiDisposisi()
	{
		$post = $this->input->post();
		$this->mymodel->updateData('arsip_dokumen_log', array('adl_isaktif' => 0), array('adl_id_arsip_dokumen' => $post['id']));
		$arrayinsertlog = array(
			'adl_id_arsip_dokumen' => $post['id'],
			'adl_isi_disposisi' => $post['isi_disposisi'],
			// 'adl_arahan_kepala_bagian' => $post['arahan_kepala_bagian'],
			'adl_status' => 'didisposisikan',
			'adl_waktu' => date('Y-m-d H:i:s'),
			'adl_isaktif' => 1,
		);
		$this->mymodel->insertData('arsip_dokumen_log', $arrayinsertlog);
		$idlog = $this->db->insert_id();

		$logdetail = [];
		for ($i = 0; $i < count($post['to']); $i++) {
			$arrayinsertlogdetail = array(
				'adld_id_arsip_dokumen' => $post['id'],
				'adld_id_arsip_dokumen_log' => $idlog,
				'adld_id_pengirim' => $this->session->userdata('id'),
				'adld_id_penerima' => $post['to'][$i],
				'adld_isread' => 0,
			);
			$this->mymodel->insertData('arsip_dokumen_log_detail', $arrayinsertlogdetail);
			$logdetail[] = $arrayinsertlogdetail;
		}

		if ($this->session->userdata('role_slug') == 'super_admin') {
			$statusmessage = 'Didisposisikan Ke Kepala Divisi';
		} elseif ($this->session->userdata('role_slug') == 'sekretaris_divisi') {
			$statusmessage = 'Didisposisikan Ke Kepala Divisi';
		} elseif ($this->session->userdata('role_slug') == 'kepala_divisi') {
			$statusmessage = 'Didisposisikan Ke Kepala Departemen';
		} elseif ($this->session->userdata('role_slug') == 'kepala_departemen' || $this->session->userdata('role_slug') == 'officer') {
			$statusmessage = 'Didisposisikan Ke Team Leader';
		} elseif ($this->session->userdata('role_slug') == 'team_leader') {
			$statusmessage = 'Didisposisikan Ke Officer';
		}
		$this->updateStatusArsipDokumen($post['id'], 'didisposisikan', $statusmessage);
		redirect('arsip_dokumen/detail/' . $this->template->sonEncode($post['id']));
	}

	public function disposisiSekretarisDivisi($arsip_dokumen_id)
	{
		$this->mymodel->updateData('arsip_dokumen_log', array('adl_isaktif' => 0), array('adl_id_arsip_dokumen' => $arsip_dokumen_id));
		$arrayinsertlog = array(
			'adl_id_arsip_dokumen' => $arsip_dokumen_id,
			'adl_isi_disposisi' => '-',
			// 'adl_arahan_kepala_bagian' => $post['arahan_kepala_bagian'],
			'adl_status' => 'didisposisikan',
			'adl_waktu' => date('Y-m-d H:i:s'),
			'adl_isaktif' => 1,
		);
		$this->mymodel->insertData('arsip_dokumen_log', $arrayinsertlog);
		$idlog = $this->db->insert_id();

		$data_kepala_divisi = $this->mymodel->selectDataone('user', ['role_slug' => 'kepala_divisi']);

		$arrayinsertlogdetail = array(
			'adld_id_arsip_dokumen' => $arsip_dokumen_id,
			'adld_id_arsip_dokumen_log' => $idlog,
			'adld_id_pengirim' => $this->session->userdata('id'),
			'adld_id_penerima' => $data_kepala_divisi['id'],
			'adld_isread' => 0,
		);
		$this->mymodel->insertData('arsip_dokumen_log_detail', $arrayinsertlogdetail);

		if ($this->session->userdata('role_slug') == 'super_admin') {
			$statusmessage = 'Didisposisikan Ke Kepala Divisi';
		} elseif ($this->session->userdata('role_slug') == 'sekretaris_divisi') {
			$statusmessage = 'Didisposisikan Ke Kepala Divisi';
		} elseif ($this->session->userdata('role_slug') == 'kepala_divisi') {
			$statusmessage = 'Didisposisikan Ke Kepala Departemen';
		} elseif ($this->session->userdata('role_slug') == 'kepala_departemen' || $this->session->userdata('role_slug') == 'officer') {
			$statusmessage = 'Didisposisikan Ke Team Leader';
		} elseif ($this->session->userdata('role_slug') == 'team_leader') {
			$statusmessage = 'Didisposisikan Ke Officer';
		}
		$this->updateStatusArsipDokumen($arsip_dokumen_id, 'diajukan', $statusmessage);
		redirect('arsip_dokumen/detail/' . $this->template->sonEncode($arsip_dokumen_id));
	}

	public function aksiDisposisiKepalaDivisi()
	{
		$post = $this->input->post();
		if (count($post['to']) > 0) {
			$this->mymodel->updateData('arsip_dokumen_log', array('adl_isaktif' => 0), array('adl_id_arsip_dokumen' => $post['id']));
			$arrayinsertlog = array(
				'adl_id_arsip_dokumen' => $post['id'],
				'adl_isi_disposisi' => $post['isi_disposisi'],
				// 'adl_arahan_kepala_bagian' => $post['arahan_kepala_bagian'],
				'adl_status' => 'didisposisikan',
				'adl_waktu' => date('Y-m-d H:i:s'),
				'adl_isaktif' => 1,
			);
			$this->mymodel->insertData('arsip_dokumen_log', $arrayinsertlog);
			$idlog = $this->db->insert_id();

			$logdetail = [];
			for ($i = 0; $i < count($post['to']); $i++) {

				$id_departement = $post['to'][$i];
				// insert table arsip departement
				$data_departement = $this->db->get_where('m_departemen', ['id' => $id_departement])->row_array();

				$this->db->select('arsip_dokumen.ad_id,arsip_dokumen.created_at,arsip_dokumen.created_by');
				$this->db->where('ad_tipesurat', 'Surat Masuk');
				$this->db->where('ad_id', $post['id']);
				$data_arsip = $this->db->get('arsip_dokumen')->row_array();

				$data_insert = [
					'add_id_arsip_dokumen' => $post['id'],
					'add_id_departement' => $id_departement,
					'add_nama_departement' => $data_departement['nama'],
					'created_at' => $data_arsip['created_at'],
					'created_by' => $data_arsip['created_by'],
					'add_tipe_surat' => 'Surat Masuk'
				];

				$this->db->insert('arsip_dokumen_departement', $data_insert);


				$this->db->where('departemen', $id_departement);
				$this->db->where('jabatan', 'Department Head');
				$list_user = $this->db->get('user')->result_array();
				foreach ($list_user as $user) {
					$arrayinsertlogdetail = array(
						'adld_id_arsip_dokumen' => $post['id'],
						'adld_id_arsip_dokumen_log' => $idlog,
						'adld_id_pengirim' => $this->session->userdata('id'),
						'adld_id_penerima' => $user['id'],
						'adld_isread' => 0,
					);
					$this->mymodel->insertData('arsip_dokumen_log_detail', $arrayinsertlogdetail);
					$logdetail[] = $arrayinsertlogdetail;
				}
			}

			if ($this->session->userdata('role_slug') == 'super_admin') {
				$statusmessage = 'Didisposisikan Ke Kepala Divisi';
			} elseif ($this->session->userdata('role_slug') == 'sekretaris_divisi') {
				$statusmessage = 'Didisposisikan Ke Kepala Divisi';
			} elseif ($this->session->userdata('role_slug') == 'kepala_divisi') {
				$statusmessage = 'Didisposisikan Ke Kepala Departemen';
			} elseif ($this->session->userdata('role_slug') == 'kepala_departemen' || $this->session->userdata('role_slug') == 'officer') {
				$statusmessage = 'Didisposisikan Ke Team Leader';
			} elseif ($this->session->userdata('role_slug') == 'team_leader') {
				$statusmessage = 'Didisposisikan Ke Officer';
			}
			$this->updateStatusArsipDokumen($post['id'], 'didisposisikan', $statusmessage);
		}
		redirect('arsip_dokumen/detail/' . $this->template->sonEncode($post['id']));
	}

	public function updateStatusArsipDokumen($idarsip, $status, $message)
	{
		$array = array(
			'status' => $status,
			'status_message' => $message,
			'dari' => $this->session->userdata('id'),
			'kirim_date' => date('Y-m-d H:i:s'),
		);
		$query = $this->mymodel->updateData('arsip_dokumen', $array, array('ad_id' => $idarsip));
		return $query;
	}

	public function aksiHapus()
	{
		$ad_id = $this->input->post('ad_id');

		$data_update = [
			'status' => 'dihapus',
			'status_message' => 'Telah dihapus',
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $this->session->userdata('id')
		];

		$result = $this->mymodel->updateData('arsip_dokumen', $data_update, array('ad_id' => $ad_id));
		if ($result) {
			echo 'success';
		} else {
			echo 'failed';
		}
		// redirect($_SERVER['HTTP_REFERER']);
	}

	public function getKategoriSurat()
	{
		$tsk_id = $this->input->post('tsk_id');
		$list_kategori_surat = $this->mymodel->selectWhere('m_kategori_surat', ['status' => 'ENABLE', 'tsk_id' => $tsk_id]);
		echo json_encode($list_kategori_surat);
	}
	public function getTeamLeader()
	{
		$departement_id = $this->input->post('departement_id');
		$list_team_leader = $this->mymodel->selectWhere('user', ['departemen' => $departement_id, 'role_slug' => 'team_leader']);
		echo json_encode($list_team_leader);
	}
	public function aksiEditAksesSuratKeluar()
	{
		$post = $this->input->post();
		$this->db->query("TRUNCATE surat_keluar_akses");
		for ($i = 0; $i < count($post['akses']); $i++) {
			$data_user = $this->mymodel->selectDataone('user', ['id' => $post['akses'][$i]]);
			$arrayinsert = array(
				'role_id' => $data_user['role_id'],
				'user_id' => $post['akses'][$i],
			);
			$this->mymodel->insertData('surat_keluar_akses', $arrayinsert);
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function generateNoSuratByDepartment()
	{
		$departement_id = $this->input->get('departement_id');
		$id_team_leader = $this->input->get('id_team_leader');
		$sifat_surat = $this->input->get('sifat_surat');
		$tipe_surat_keluar = $this->input->get('tipe_surat_keluar');
		$kodesifatsurat = $this->input->get('kodesifatsurat');
		// $current_year = date('Y');
		$current_year = $this->input->get('tahun');
		$this->db->select("ad_nomorsurat");
		$this->db->like('ad_nomorsurat', $kodesifatsurat . '.');
		$this->db->like('ad_nomorsurat', '-' . $tipe_surat_keluar . '/');
		$this->db->where('ad_tipesurat', 'Surat Keluar');
		$this->db->where('status !=', 'dihapus');
		$this->db->where('ad_departemen', $departement_id);
		$this->db->where('ad_sifatsurat', $sifat_surat);

		$this->db->where('YEAR(ad_tanggalsurat)', $current_year);

		if ($id_team_leader != "") {
			$this->db->where('ad_id_teamleader', $id_team_leader);
		}		
		$this->db->order_by('ad_id', 'desc');
		$this->db->order_by('ad_nomorsurat', 'desc');
		// $id = $this->db->get('arsip_dokumen')->row()->id;
		$nomor_surat = $this->db->get('arsip_dokumen')->row()->ad_nomorsurat;

		if ($nomor_surat == NULL) {
			$nomor = sprintf('%04d', 1);
		} else {
			$array_1 = explode('.', $nomor_surat);
			if (count($array_1) > 1) {
				$array_2 = explode('-', $array_1[1]);
				$id =  (int) current($array_2);
				if ($id == 0) {
					for ($i = 0; $id == 0; $i++) {
						$this->db->select("ad_nomorsurat");
						$this->db->where('ad_tipesurat', 'Surat Keluar');
						$this->db->where('status !=', 'dihapus');
						$this->db->where('YEAR(ad_tanggalsurat)', $current_year);
						$this->db->where('ad_departemen', $departement_id);
						if ($id_team_leader != "") {
							$this->db->where('ad_id_teamleader', $id_team_leader);
						}
						$this->db->where('ad_sifatsurat', $sifat_surat);
						$this->db->order_by('ad_id', 'desc');
						$this->db->order_by('ad_nomorsurat', 'desc');
						$nomor_surat = $this->db->get('arsip_dokumen')->row($i)->ad_nomorsurat;
						$array_1 = explode('.', $nomor_surat);

						if (count($array_1) > 1) {
							$array_2 = explode('-', $array_1[1]);
							$id =  (int) current($array_2);
						} else {
							$id = 0;
						}
					}

					$id++;
				} else {
					$id++;
				}
			}
			$nomor = sprintf('%04d', $id);
		}
		echo json_encode([
			'nomor' => $nomor
		]);
	}

	public function contentModalEditTindakLanjut($adld_id)
	{
		$data['adld_id'] = $adld_id;
		$data['list_lampiran'] = $this->db->get_where('lampiran_tindaklanjut', ['adld_id' => $adld_id])->result_array();
		$this->load->view('arsip_dokumen/content_modal_edit_tindaklanjut', $data);
	}

	public function editTindakLanjut()
	{
		// error_reporting(-1);
		// ini_set('display_errors', 1);
		// dump_variable($_POST);
		// dump_variable($_FILES);
		// die();
		foreach ($_FILES['adld_file_tindaklanjut']['name'] as $key => $image) {
			$is_delete = $_POST['is_delete'][$key];
			if ($is_delete == 'y') {
				$id_delete = $_POST['id'][$key];

				$this->db->where('id', (int) $id_delete);
				$a = $this->db->delete('lampiran_tindaklanjut');
			} else {
				$id_lampiran_tindaklanjut = $_POST['id'][$key];
				$file_tindak_lanjut = NULL;
				if ($image != '') {
					$adld_id = $_POST['adld_id'][0];
					$data_adld = $this->db->get_where('arsip_dokumen_log_detail', ['adld_id' => $adld_id])->row_array();
					$data_surat = $this->db->get_where('arsip_dokumen', ['ad_id' => $data_adld['adld_id_arsip_dokumen']])->row_array();

					$_FILES['images']['name'] = $_FILES['adld_file_tindaklanjut']['name'][$key];
					$_FILES['images']['type'] = $_FILES['adld_file_tindaklanjut']['type'][$key];
					$_FILES['images']['tmp_name'] = $_FILES['adld_file_tindaklanjut']['tmp_name'][$key];
					$_FILES['images']['error'] = $_FILES['adld_file_tindaklanjut']['error'][$key];
					$_FILES['images']['size'] = $_FILES['adld_file_tindaklanjut']['size'][$key];

					$dir = 'webfile/tindak-lanjut/';
					$namafile = $data_surat['ad_nomorsurat'] . '_lampiran_' . $_POST['adld_catatan_tindaklanjut'][$key];
					$config['upload_path']          = $dir;
					$config['allowed_types']        = '*';
					$config['max_size'] 			= '64000';
					// $config['file_name']           	= $namafile;
					$this->load->library('upload', $config);
					$this->upload->do_upload('images');
					$data_file = $this->upload->data();
					$file_tindak_lanjut = $dir . $data_file['file_name'];

					// add password dan qrcode
					if (in_array($data_surat['ad_sifatsurat'], ['rahasia', 'sangat_rahasia'])) {
						$this->checkAndConvertPDF($data_file['full_path']);
						$this->addQRCodeToPDF($file_tindak_lanjut);
						$password =  substr(md5(date('Y-m-d H:i:s')), 0, 6);
						$this->encryptPDF($file_tindak_lanjut, $password, $file_tindak_lanjut);
					}
				}
				$adld_id = $_POST['adld_id'][0];
				$data_adld = $this->db->get_where('arsip_dokumen_log_detail', ['adld_id' => $adld_id])->row_array();
				if ($id_lampiran_tindaklanjut == "") {
					// update status tindak lanjut 
					$data_update = ['adld_is_tindaklanjut' => 1];
					$this->db->where('adld_id', $adld_id);
					$this->db->update('arsip_dokumen_log_detail', $data_update);

					$data_insert = [
						'adld_id' => $adld_id,
						'adld_id_arsip_dokumen_log' => $data_adld['adld_id_arsip_dokumen_log'],
						'adld_id_arsip_dokumen' => $data_adld['adld_id_arsip_dokumen'],
						'id_penerima' => $data_adld['adld_id_penerima'],
						'catatan_tindaklanjut' => $_POST['adld_catatan_tindaklanjut'][$key],
						'file_tindaklanjut' => $file_tindak_lanjut,
					];
					if (in_array($data_surat['ad_sifatsurat'], ['rahasia', 'sangat_rahasia'])) {
						$data_insert['password_file'] = $password;
					}
					$this->db->insert('lampiran_tindaklanjut', $data_insert);

					$data_adl = $this->mymodel->selectDataone('arsip_dokumen_log', ['adl_id' => $data_adld['adld_id_arsip_dokumen_log']]);
					$arrayinsertlog = array(
						'adl_id_arsip_dokumen' => $data_adld['adld_id_arsip_dokumen'],
						'adl_isi_disposisi' => $_POST['adld_catatan_tindaklanjut'][$key],
						'adl_status' => 'Ditindak Lanjuti',
						'adl_waktu' => date('Y-m-d H:i:s'),
						'adl_isaktif' => 1,
					);
					$this->mymodel->insertData('arsip_dokumen_log', $arrayinsertlog);

					$idlog = $this->db->insert_id();

					$arrayinsertlogdetail = array(
						'adld_id_arsip_dokumen' => $data_adld['adld_id_arsip_dokumen'],
						'adld_id_arsip_dokumen_log' => $idlog,
						'adld_id_pengirim' => $this->session->userdata('id'),
						'adld_id_penerima' => $this->session->userdata('id'),
						'adld_isread' => 1,
					);
					$this->mymodel->insertData('arsip_dokumen_log_detail', $arrayinsertlogdetail);
				} else {
					$data_update = [
						'catatan_tindaklanjut' => $_POST['adld_catatan_tindaklanjut'][$key],
						'file_tindaklanjut' => $file_tindak_lanjut,
					];
					if ($file_tindak_lanjut == NULL) unset($data_update['file_tindaklanjut']);
					if (in_array($data_surat['ad_sifatsurat'], ['rahasia', 'sangat_rahasia'])) {
						$data_update['password_file'] = $password;
					}
					$this->db->where('id', $id_lampiran_tindaklanjut);
					$this->db->update('lampiran_tindaklanjut', $data_update);
				}
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function excelSuratMasuk()
	{
		$role_user = $this->session->userdata('role_slug');
		$this->db->select('ad_id , ad_nomorsurat , ad_tanggalsurat , ad_instansipengirim , REPLACE(ad_bentukdokumen,"_"," ") as ad_bentukdokumen , ad_tipesurat , ad_duedate , arsip_dokumen.status , user.name as nama_pengirim,user.role_slug as role_pengirim,ad_tipesurat,arsip_dokumen.created_by,ad_sifatsurat,ad_perihal');
		$this->db->group_by('arsip_dokumen.ad_id');
		if (@$_GET['tipe'] == 'inbox') {
			$jabatan_user = $this->session->userdata('jabatan');
			$departement_user = $this->session->userdata('departement');
			if ($role_user == 'kepala_departemen' and $jabatan_user == 'Admin Department Head') {
				$this->db->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
				$this->db->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
				$this->db->where('arsip_dokumen.status', $_GET['status']);
				$this->db->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut');
				$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
				$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id');

				$this->db->group_start();
				$this->db->where("adld_id_penerima in (select id from user where role_slug ='kepala_departemen' AND jabatan = 'Department Head' AND departemen = $departement_user ) ");
				$this->db->or_where('adld_id_penerima', $this->session->userdata('id'));
				$this->db->group_end();
			} elseif ($role_user == 'sekretaris_divisi') {
				$this->db->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
				$this->db->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
				$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
				$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id');
			} else {
				if ($role_user == 'kepala_divisi') {
					$this->db->group_start();
					$this->db->where('arsip_dokumen.status', $_GET['status']);
					$this->db->or_where('arsip_dokumen.status', 'diajukan');
					$this->db->group_end();
				} else {
					$this->db->where('arsip_dokumen.status', $_GET['status']);
				}

				$this->db->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
				$this->db->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
				$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
				$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_penerima = "' . $this->session->userdata('id') . '" AND adld_id_pengirim != "' . $this->session->userdata('id') . '" ');
				if ($role_user == 'officer') {
					$this->db->where('adld_is_tindaklanjut!=', '1');
				}
			}
		} else if ($_GET['status'] == 'ditindaklanjuti') {
			if ($role_user == 'officer') {
				$this->db->where(" arsip_dokumen.status = '$_GET[status]' OR (arsip_dokumen.status = 'didisposisikan' AND adld_is_tindaklanjut = '1') ");
			} else {
				$this->db->where('arsip_dokumen.status', $_GET['status']);
			}
			if ($this->session->userdata('role_slug') == 'super_admin' || $this->session->userdata('role_slug') == 'kepala_departemen' || $this->session->userdata('role_slug') == 'sekretaris_divisi') {
				$this->db->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
				$this->db->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
				$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
				$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id');
			} else {
				$this->db->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
				$this->db->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
				$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
				$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_penerima = "' . $this->session->userdata('id') . '" AND adld_id_pengirim != "' . $this->session->userdata('id') . '" ');
			}
		} else {
			if (@$_GET['status']) {
				if (@$_GET['status'] == 'draft') {
					$this->db->where('arsip_dokumen.ad_tipesurat', 'Surat Masuk');
				}
				$this->db->where('arsip_dokumen.status', $_GET['status']);
				if ($this->session->userdata('role_slug') == 'super_admin' || $this->session->userdata('role_slug') == 'kepala_departemen' || $this->session->userdata('role_slug') == 'sekretaris_divisi') {
					$this->db->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
					$this->db->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
					$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
					$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id');
				} else {
					$this->db->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut');
					$this->db->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
					$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
					$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_isread = "1" AND adld_id_penerima = "' . $this->session->userdata('id') . '"');
				}
			} else {
				if ($this->session->userdata('role_slug') == 'super_admin' || $this->session->userdata('role_slug') == 'kepala_departemen' || $this->session->userdata('role_slug') == 'sekretaris_divisi') {
					$this->db->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
					$this->db->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
					$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
					$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id');
					// $this->db->where('arsip_dokumen.status', 'diajukan');
				} else {

					$this->db->select('arsip_dokumen_log_detail.adld_isread,arsip_dokumen_log_detail.adld_is_tindaklanjut,adld_id_pengirim');
					$this->db->select("(SELECT GROUP_CONCAT(adld_id_pengirim) FROM arsip_dokumen_log_detail where adld_id_arsip_dokumen = ad_id ) as list_pengirim");
					$this->db->join('arsip_dokumen_log', 'arsip_dokumen_log.adl_id_arsip_dokumen = arsip_dokumen.ad_id', 'left');
					$this->db->join('arsip_dokumen_log_detail', 'arsip_dokumen_log_detail.adld_id_arsip_dokumen_log = arsip_dokumen_log.adl_id AND adld_id_penerima = "' . $this->session->userdata('id') . '" AND adld_id_pengirim != "' . $this->session->userdata('id') . '" ');
					$this->db->where('arsip_dokumen.status', 'didisposisikan');
				}
			}
		}

		if (@$_GET['sifat']) {
			$this->db->where('ad_sifatsurat', $_GET['sifat']);
		}

		if (@$_GET['bentuk']) {
			$this->db->where('ad_bentukdokumen', $_GET['bentuk']);
		}

		if (@$_GET['kategori']) {
			$this->db->join('arsip_dokumen_departement', 'ad_id = add_id_arsip_dokumen');
			$this->db->where('add_id_departement', $_GET['kategori']);
		}

		// if (@$_GET['duedate']) {
		// 	$this->db->where('ad_duedate', $_GET['duedate']);
		// }

		if (@$_GET['tanggal_surat'] and @$_GET['tanggal_surat'] != '') {
			$this->db->where('ad_tanggalsurat', $_GET['tanggal_surat']);
		}

		if (($this->session->userdata('role_slug') != 'super_admin' and $this->session->userdata('role_slug') != 'sekretaris_divisi' and $this->session->userdata('role_slug') != 'kepala_divisi') or ($this->session->userdata('role_slug') == 'kepala_departemen' and @$_GET['tipe'] == 'inbox')) {
			$this->db->join('arsip_dokumen_departement', 'ad_id = add_id_arsip_dokumen');
			$this->db->where('add_id_departement', $this->session->userdata('departement'));
		}
		$this->db->join('user', 'user.id = arsip_dokumen.dari', 'left');
		$this->db->where('ad_tipesurat', 'Surat Masuk');
		$this->db->where('arsip_dokumen.status!=', 'dihapus');
		$this->db->from('arsip_dokumen');
		$data['data_surat'] = $this->db->get()->result_array();
		$this->load->view('arsip_dokumen/excel_surat_masuk', $data);
	}
	public function excelSuratKeluar()
	{
		$this->db->select('
			ad_id , 
			ad_nomorsurat , 
			ad_tanggalsurat , 
			ad_instansipengirim , 
			REPLACE(ad_bentukdokumen,"_"," ") as ad_bentukdokumen , 
			ad_tipesurat , 
			ad_duedate , 
			arsip_dokumen.status , 
			user.name as nama_pengirim,
			ad_tipesurat,
			arsip_dokumen.created_by,
			ad_sifatsurat,
			ad_perihal,
			ad_dikirim,
			ad_pic,
			ad_notelp
			');

		$this->db->join('user', 'user.id = arsip_dokumen.dari', 'left');
		$this->db->where('ad_tipesurat', 'Surat Keluar');
		$this->db->where('arsip_dokumen.status !=', 'dihapus');
		$this->db->where('ad_is_booking', '0');

		if ($this->session->userdata('role_slug') != 'super_admin' and $this->session->userdata('role_slug') != 'sekretaris_divisi' and $this->session->userdata('role_slug') != 'kepala_divisi') {
			$this->db->where('ad_departemen', $this->session->userdata('departement'));
		}

		if (@$_GET['sifat']) {
			$this->db->where('ad_sifatsurat', $_GET['sifat']);
		}

		if (@$_GET['bentuk']) {
			$this->db->where('ad_bentukdokumen', $_GET['bentuk']);
		}

		// if (@$_GET['kategori']) {
		// 	$this->db->where('ad_kategorisurat', $_GET['kategori']);
		// }

		if (@$_GET['duedate']) {
			$this->db->where('ad_duedate', $_GET['duedate']);
		}

		if (@$_GET['kategori'] and $_GET['kategori'] != '') {
			$this->db->join('arsip_dokumen_departement', 'ad_id = add_id_arsip_dokumen', 'left');
			$this->db->where('add_id_departement', @$_GET['kategori']);
		}

		$this->db->from('arsip_dokumen');



		$data['data_surat'] = $this->db->get()->result_array();
		$this->load->view('arsip_dokumen/excel_surat_keluar', $data);
	}

	public function checkPassword()
	{
		$check_password = $this->input->post('check_password');
		$user_id = $this->session->userdata('id');
		$data_user = $this->mymodel->selectDataone('user', ['id' => $user_id]);
		if (md5($check_password) == $data_user['password']) {
			echo $this->alert->alertsuccess('Success');
		} else {
			echo $this->alert->alertdanger('Password yang anda input salah!');
		}
	}

	public function getPasswordLampiran($type = 'surat')
	{
		if ($type == 'surat') {
			$id_surat = $this->template->sonDecode($this->input->post('id_surat'));
		} else {
			$id_surat = $this->input->post('id_surat');
		}

		$password = $this->input->post('password');
		$user_id = $this->session->userdata('id');
		$data_user = $this->mymodel->selectDataone('user', ['id' => $user_id]);
		if (md5($password) == $data_user['password']) {
			if ($type == 'surat') {
				$data_lampiran = $this->mymodel->selectDataone('arsip_dokumen', ['ad_id' => $id_surat]);
				echo $data_lampiran['ad_lampiran_password'];
			} else if ($type == 'lampiran') {
				$data_lampiran = $this->mymodel->selectDataone('lampiran_surat', ['id' => $id_surat]);
				echo $data_lampiran['password'];
			} else {
				$data_lampiran = $this->mymodel->selectDataone('lampiran_tindaklanjut', ['id' => $id_surat]);
				echo $data_lampiran['password_file'];
			}
		}
	}

	public function tambahLampiran()
	{
		// die(dump_variable($_FILES));
		$password = '';
		$data_arsip = $this->mymodel->selectDataone('arsip_dokumen', ['ad_id' => $this->input->post('id_arsip')]);
		$filename = uniqid() . '-' . str_replace('.', '', substr($_FILES['file']['name'], 0, strrpos($_FILES['file']['name'], ".")));
		$filename = substr(preg_replace('/[^A-Za-z0-9\-]/', '', $filename), 0, 30);
		$fileupload = $this->upload_file_dir('file', 'webfile/', $filename);
		$this->checkAndConvertPDF($fileupload['message']['full_path']);
		$this->addQRCodeToPDF($fileupload['message']['dir']);
		if ($data_arsip['ad_sifatsurat'] != 'biasa') {
			$password =  substr(md5(date('Y-m-d H:i:s')), 0, 6);
			$this->encryptPDF($fileupload['message']['dir'], $password, $fileupload['message']['dir']);
		}
		$return = $this->uploadFileFromServerToCloud($fileupload['message']['dir']);
		if ($data_arsip['ad_sifatsurat'] != 'biasa') {
			$array_return = json_decode($return, TRUE);
			$array_return['password'] = $password;
			$return = json_encode($array_return);
		}
		// dump_variable($fileupload);
		$array_return = $array_return = json_decode($return, TRUE);
		$nama_file_lampiran = $data_arsip['ad_nomorsurat'] . "- Lampiran " . $this->input->post('keterangan') . '.pdf';

		$data_rename_lampiran = [
			'id' => $array_return['id'],
			'name' => $nama_file_lampiran
		];
		$this->renameFileCloud($data_rename_lampiran);
		$lampiran = base_url('upload-cloud/getFile/' . $array_return['id']);
		$data_insert = [
			'path' => $lampiran,
			'keterangan' => $this->input->post('keterangan'),
			'password' => $password,
			'arsip_dokumen_id' => $this->input->post('id_arsip'),
			'created_at' => date('Y-m-d H:i:s'),
			'created_by' => $this->session->userdata('id')
		];
		$this->db->insert('lampiran_surat', $data_insert);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function ubahLampiran()
	{
		ini_set('max_execution_time', 100000000000);
		ini_set('memory_limit', 100000000000);
		ini_set('post_max_size', 100000000000);
		ini_set('upload_max_filesize', 100000000000);

		$keterangan = $this->input->post('keterangan');
		$id_lampiran = $this->input->post('id_lampiran');
		$data_lampiran = $this->mymodel->selectDataone('lampiran_surat', ['id' => $id_lampiran]);
		$data_arsip = $this->mymodel->selectDataone('arsip_dokumen', ['ad_id' => $data_lampiran['arsip_dokumen_id']]);
		if ($_FILES['file']['name'] != '') {
			$filename = uniqid() . '-' . str_replace('.', '', substr($_FILES['file']['name'], 0, strrpos($_FILES['file']['name'], ".")));
			$filename = substr(preg_replace('/[^A-Za-z0-9\-]/', '', $filename), 0, 30);
			$fileupload = $this->upload_file_dir('file', 'webfile/', $filename);
			$this->checkAndConvertPDF($fileupload['message']['full_path']);
			$this->addQRCodeToPDF($fileupload['message']['dir']);
			if ($data_arsip['ad_sifatsurat'] != 'biasa') {
				$password =  substr(md5(date('Y-m-d H:i:s')), 0, 6);
				$this->encryptPDF($fileupload['message']['dir'], $password, $fileupload['message']['dir']);
			}
			$return = $this->uploadFileFromServerToCloud($fileupload['message']['dir']);
			if ($data_arsip['ad_sifatsurat'] != 'biasa') {
				$array_return = json_decode($return, TRUE);
				$array_return['password'] = $password;
				$return = json_encode($array_return);
			}
			// dump_variable($fileupload);
			$array_return = $array_return = json_decode($return, TRUE);
			$nama_file_lampiran = $data_arsip['ad_nomorsurat'] . "- Lampiran " . $keterangan . '.pdf';

			$data_rename_lampiran = [
				'id' => $array_return['id'],
				'name' => $nama_file_lampiran
			];
			$this->renameFileCloud($data_rename_lampiran);
			$lampiran = base_url('upload-cloud/getFile/' . $array_return['id']);
			$data_update = [
				'path' => $lampiran,
				'keterangan' => $keterangan,
				'updated_at' => date('Y-m-d H:i:s'),
				'updated_by' => $this->session->userdata('id')
			];
		} else {
			$path_file = $this->db->get_where('arsip_dokumen', ['ad_id' => $id_arsip])->row()->ad_lampiran;
			$array_path = explode('/', $data_lampiran['path']);
			$id_file = $array_path[5];

			$nama_file_lampiran = $data_arsip['ad_nomorsurat'] . "- Lampiran " . $keterangan . '.pdf';
			$data_rename_lampiran = [
				'id' => $id_file,
				'name' => $nama_file_lampiran
			];
			$this->renameFileCloud($data_rename_lampiran);
			$data_update = [
				'keterangan' => $keterangan,
				'updated_at' => date('Y-m-d H:i:s'),
				'updated_by' => $this->session->userdata('id')
			];
		}
		$this->db->where('id', $id_lampiran);
		$this->db->update('lampiran_surat', $data_update);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function editKategoriSurat()
	{
		// dump_variable($_POST);
		$data_update = [
			'ad_kategorisurat_id' => $this->input->post('ad_kategorisurat_id'),
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $this->session->userdata('id')
		];

		$this->db->where('ad_id', $this->input->post('id'));
		$this->db->update('arsip_dokumen', $data_update);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function ubahTanggalSurat()
	{
		$tanggal_surat = $this->input->post('tanggal_surat');
		$id_lampiran = $this->input->post('id_lampiran');
		$data_update = [
			'ad_tanggalsurat' => $tanggal_surat,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $this->session->userdata('id')
		];

		$this->db->where('ad_id', $id_lampiran);
		$this->db->update('arsip_dokumen', $data_update);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */