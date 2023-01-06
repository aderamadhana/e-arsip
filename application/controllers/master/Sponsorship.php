<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Sponsorship extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "sponsorship";
		$this->template->load('template/template', 'master/sponsorship/all-sponsorship', $data);
	}


	public function create()
	{
		$data['page_name'] = "sponsorship";
		$this->template->load('template/template', 'master/sponsorship/add-sponsorship', $data);
	}

	public function validate()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('dt[nama_kegiatan]', '<strong>Nama acara / kegiatan</strong>', 'required');
		$this->form_validation->set_rules('dt[tanggal]', '<strong>Tanggal</strong>', 'required');
		$this->form_validation->set_rules('dt[klasifikasi_id]', '<strong>Klasifikasi Kegiatan</strong>', 'required');
		$this->form_validation->set_rules('dt[lingkup_id]', '<strong>Lingkup Kegiatan</strong>', 'required');
		$this->form_validation->set_rules('dt[kantor_id]', '<strong>Pemberi Sponsor </strong>', 'required');
		$this->form_validation->set_rules('dt[pic]', '<strong>Pemberi Sponsor </strong>', 'required');

		$this->form_validation->set_rules('dt[nilai_sponsor]', '<strong>Nilai Sponsor</strong>', 'required');
		$this->form_validation->set_rules('dt[termin_pembayaran]', '<strong>Termin Pembayara</strong>', 'required');
		$this->form_validation->set_rules('dt[catatan_kegiatan]', '<strong>Catatan Kegiatan	</strong>', 'required');
		$this->form_validation->set_rules('dt[pic_terlaksana]', '<strong>PIC Pelaksana	</strong>', 'required');
		$this->form_validation->set_rules('dt[nomor_kontak_pelaksana]', '<strong>No Kontak Pelaksana	</strong>', 'required');
		$this->form_validation->set_rules('dt[alamat_pelaksana]', '<strong>Alamat Pelaksana	</strong>', 'required');
		$this->form_validation->set_rules('dt[pertimbangan_sponsor]', '<strong>Pertimbangan Sponsor/Bantuan Dana	</strong>', 'required');

		$this->form_validation->set_rules('dt[is_sponsor]', '<strong>Nilai Sponsor Termaksud Pajak ?</strong>', 'required');
		$this->form_validation->set_rules('dt[is_sharing_dana]', '<strong>Sharing Dana	</strong>', 'required');
		$this->form_validation->set_rules('dt[is_kegiatan_terlaksana]', '<strong>Kegiatan Terlaksana?	</strong>', 'required');
	}

	public function store()
	{
		$post = $this->input->post();
		$dt = $post['dt'];
		// $this->form_validation->set_error_delimiters('<li>', '</li>');

		// $this->validate();
		// if ($this->form_validation->run() == FALSE){
		// 	echo validation_errors();    
		//       }else{
		$dt['peserta_detail'] = json_encode($post['peserta_detail']);
		$dt['keuntungan_logo'] = json_encode($post['keuntungan_logo']);
		$dt['konsep_acara'] = json_encode($post['konsep_acara']);
		$dt['media'] = json_encode($post['media']);
		$dt['unit_kerja'] = json_encode($post['unit_kerja']);
		$kantorsharing = array(
			'individu' => $post['individu_kantor_id'],
			'sharing' => json_encode($post['sharing_kantor_id'])
		);
		$dt['data_unit'] = json_encode($kantorsharing);
		$dt['tanggal_transfer'] = json_encode($post['tanggal_transfer']);
		$dt['nominal_transfer'] = json_encode($post['nominal_transfer']);
		$dt['pic'] = json_encode($post['pic']);
		$dt['keuntungan_id'] = json_encode($post['keuntungan_id']);
		$dt['nilai_sponsor'] = str_replace(',', '', $dt['nilai_sponsor']);
		$dt['permohonan_nilai_sponsor'] = str_replace(',', '', $dt['permohonan_nilai_sponsor']);
		if ($dt['klasifikasi_id'] != 0) {
			$klasifikasi = $this->mymodel->selectdataone('klasifikasi', ['id' => $dt['klasifikasi_id']]);
			$dt['klasifikasi_nama'] = $klasifikasi['klasifikasi'];
		}
		if ($dt['lingkup_id'] != 0) {
			$lingkup = $this->mymodel->selectdataone('lingkup', ['id' => $dt['lingkup_id']]);
			$dt['lingkup_nama'] = $lingkup['lingkup'];
		}
		// ================================================================
		$config['upload_path']          = './webfile/sponsorship/';
		$config['allowed_types']        = '*';
		// $config['max_size']             = 500;
		// $config['max_width']            = 2048;
		// $config['max_height']           = 1000;
		$config['encrypt_name'] 		= true;
		$this->load->library('upload', $config);
		$jumlah_files = count($_FILES['files']['name']);
		for ($i = 0; $i < $jumlah_files; $i++) {
			if (!empty($_FILES['files']['name'][$i])) {
				$_FILES['file']['name'] = $_FILES['files']['name'][$i];
				$_FILES['file']['type'] = $_FILES['files']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['files']['error'][$i];
				$_FILES['file']['size'] = $_FILES['files']['size'][$i];

				if ($this->upload->do_upload('file')) {

					$uploadData = $this->upload->data();
					$dataimg[] = [
						'name' => $post['nama_files'][$i],
						'dir' => $uploadData['file_name']
					];
				}
			}
		}
		if ($dataimg) {
			$dt['files'] = json_encode($dataimg);
		}
		// ================================================================

		if ($post['kantor']) {
			foreach ($post['kantor'] as $key => $kantor) {
				$datasharing[] = [
					'kantor' => $kantor,
					'presentase' => $post['presentase'][$key],
					'nominal' => $post['nominal'][$key]
				];
			}
			$dt['sharing'] = json_encode($datasharing);
		}
		$bukti_transfer = array();
		$dir = 'webfile/sponsorship/';
		$config['upload_path']          = './webfile/sponsorship/';
		$config['allowed_types']        = '*';
		// $config['max_size']             = 500;
		// $config['max_width']            = 2048;
		// $config['max_height']           = 1000;
		$config['encrypt_name'] 		= true;
		$this->load->library('upload', $config);

		for ($i = 1; $i <= 10; $i++) {
			if (!empty($_FILES['bukti_transfer' . $i]['name'])) {
				if ($this->upload->do_upload('bukti_transfer' . $i)) {
					$uploadData = $this->upload->data();
					$bukti_transfer[] = $dir . $uploadData['file_name'];
				}
			}
		}



		$dt['bukti_transfer'] = json_encode($bukti_transfer);
		$str = $this->mymodel->insertData('sponsorship', $dt);
		$id = $this->db->insert_id();
		// echo 'success';

		// }

		$hash_url = str_replace("#", "", $post['tab_index']);
		if ($hash_url <= 5) {
			redirect('master/sponsorship/edit/' . $id . '#' . ($hash_url + 1));
		} else {
			redirect('master/sponsorship');
		}



		/*
			$this->validate();
			if ($this->form_validation->run() == FALSE){
				echo validation_errors();    
	        }else{
				$dt = $this->input->post('dt');
				$dt['created_at'] = date('Y-m-d H:i:s');
				$dt['created_by'] = $this->session->userdata('id');
				$dt['status'] = "ENABLE";

				$dt['nominal_sponsor'] = str_replace(',','',$dt['nominal_pajak_sponsor']);
				$dt['nominal_pajak_sponsor'] = str_replace(',','',$dt['nominal_pajak_sponsor']);
				

				$str = $this->mymodel->insertData('sponsorship', $dt);
					    
				$last_id = $this->db->insert_id();
				if (!empty($_FILES['file']['name'])){
					$directory = 'webfile/sponsorship/';
					$filename = $_FILES['file']['name'];
					$allowed_types = 'gif|jpg|png';
					$max_size = '2000';
					$result = $this->uploadfile->upload('file',$filename,$directory,$allowed_types, $max_size);
					if($result['alert'] == 'success'){
						$data = array(
							'id' => '',
							'name'=> $result['message']['name'],
							'mime'=> $result['message']['mime'],
							'dir'=> $result['message']['dir'],
							'table'=> 'sponsorship',
							'table_id'=> $last_id,
							'status'=>'ENABLE',
							'created_at'=>date('Y-m-d H:i:s')
						);
						$str = $this->mymodel->insertData('file', $data);
						echo 'success';
					}else{
						echo $result['message'];
					}
				}else{
					$data = array(
						'name'=> '',
						'mime'=> '',
						'dir'=> '',
						'table'=> 'sponsorship',
						'table_id'=> $last_id,
						'status'=>'ENABLE',
						'created_at'=>date('Y-m-d H:i:s')
					);
					$str = $this->mymodel->insertData('file', $data);
					echo 'success';
				}
					    

			} */
	}

	public function json()
	{
		$param = $this->input->post();
		if (@$param['pic']) {
			foreach ($param['pic'] as $key => &$value) {
				if (count($param['pic']) == $key + 1) {
					$textpic = '"' . $value . '"';
				} else {
					$textpic = '"' . $value . '",';
				}
			}
		}
		header('Content-Type: application/json');
		$this->datatables->select('sponsorship.id,sponsorship.nama_kegiatan,sponsorship.tanggal,sponsorship.status,sponsorship.klasifikasi_nama,sponsorship.lingkup_nama,sponsorship.pic,sponsorship.informasi_pembayaran,sponsorship.lembaga_pengaju,sponsorship.nilai_sponsor');
		// $this->datatables->where('sponsorship.status',$status);
		$this->datatables->from('sponsorship');
		if ($param['klasifikasi']) {
			$this->datatables->where('klasifikasi_id', $param['klasifikasi']);
			if ($param['klasifikasi'] == 0) {
				$this->datatables->where('klasifikasi_nama', $param['lain_klasifikasi']);
			}
		}
		if ($param['lingkup']) {
			$this->datatables->where('lingkup_id', $param['lingkup']);
			if ($param['lingkup'] == 0) {
				$this->datatables->where('lingkup_nama', $param['lain_lingkup']);
			}
		}
		if ($param['tanggal']) {
			$this->datatables->where('tanggal', $param['tanggal']);
		}
		if ($param['nama_kegiatan']) {
			$this->datatables->like('nama_kegiatan', $param['nama_kegiatan'], 'BOTH');
		}
		if (@$param['pic']) {
			$this->datatables->like('pic', $textpic, 'BOTH');
		}
		// if($status=="ENABLE"){

		//  	}else{
		// $this->datatables->add_column('view', '<div class="btn-group">
		// 													<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
		// 													<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
		// 											</div>', 'id');
		//  	}
		if ($this->session->userdata('role_slug') == 'kepala_divisi') {
			$this->datatables->add_column('view', '', 'id');
		} else {
			$this->datatables->add_column('view', '<div class="btn-group">
					<button style="font-size:14px" type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
					<button style="font-size:14px" type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
				</div>', 'id');
		}

		$this->db->order_by('tanggal', 'DESC');
		$this->db->order_by('id', 'DESC');
		echo $this->datatables->generate();
	}

	public function edit($id)
	{
		$data['sponsorship'] = $this->mymodel->selectDataone('sponsorship', array('id' => $id));
		$data['file'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'sponsorship'));
		$data['page_name'] = "sponsorship";
		$this->template->load('template/template', 'master/sponsorship/edit-sponsorship', $data);
	}

	public function update()
	{

		$post = $this->input->post();
		$dt = $post['dt'];
		// $this->form_validation->set_error_delimiters('<li>', '</li>');

		// $this->validate();
		// if ($this->form_validation->run() == FALSE){
		// 	echo validation_errors();    
		//       }else{
		$dt['peserta_detail'] = json_encode($post['peserta_detail']);
		$dt['keuntungan_logo'] = json_encode($post['keuntungan_logo']);
		$dt['konsep_acara'] = json_encode($post['konsep_acara']);
		$dt['media'] = json_encode($post['media']);
		$dt['unit_kerja'] = json_encode($post['unit_kerja']);
		$kantorsharing = array(
			'individu' => $post['individu_kantor_id'],
			'sharing' => $post['sharing_kantor_id']
		);
		$dt['data_unit'] = json_encode($kantorsharing);
		$dt['tanggal_transfer'] = json_encode($post['tanggal_transfer']);
		$dt['nominal_transfer'] = json_encode($post['nominal_transfer']);
		$dt['pic'] = json_encode($post['pic']);
		$dt['nilai_sponsor'] = str_replace(',', '', $dt['nilai_sponsor']);
		$dt['permohonan_nilai_sponsor'] = str_replace(',', '', $dt['permohonan_nilai_sponsor']);
		if ($dt['klasifikasi_id'] != 0) {
			$klasifikasi = $this->mymodel->selectdataone('klasifikasi', ['id' => $dt['klasifikasi_id']]);
			$dt['klasifikasi_nama'] = $klasifikasi['klasifikasi'];
		}
		if ($dt['lingkup_id'] != 0) {
			$lingkup = $this->mymodel->selectdataone('lingkup', ['id' => $dt['lingkup_id']]);
			$dt['lingkup_nama'] = $lingkup['lingkup'];
		}
		// ================================================================
		foreach ($post['nama_files_old'] as $k => $files_old) {

			$dataimg[] = [
				'name' => $files_old,
				'dir' => $post['files_old'][$k]
			];
		}
		$config['upload_path']          = './webfile/sponsorship/';
		$config['allowed_types']        = '*';
		$config['encrypt_name'] 		= true;
		$this->load->library('upload', $config);
		$jumlah_files = count($_FILES['files']['name']);
		for ($i = 0; $i < $jumlah_files; $i++) {
			if (!empty($_FILES['files']['name'][$i])) {
				$_FILES['file']['name'] = $_FILES['files']['name'][$i];
				$_FILES['file']['type'] = $_FILES['files']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['files']['error'][$i];
				$_FILES['file']['size'] = $_FILES['files']['size'][$i];

				if ($this->upload->do_upload('file')) {

					$uploadData = $this->upload->data();
					$dataimg[] = [
						'name' => $post['nama_files'][$i],
						'dir' => 'webfile/sponsorship/' . $uploadData['file_name']
					];
				}
			}
		}
		if ($dataimg) {
			$dt['files'] = json_encode($dataimg);
		}
		// ================================================================

		if ($post['kantor']) {
			foreach ($post['kantor'] as $key => $kantor) {
				$datasharing[] = [
					'kantor' => $kantor,
					'presentase' => $post['presentase'][$key],
					'nominal' => $post['nominal'][$key]
				];
			}
			$dt['sharing'] = json_encode($datasharing);
		}
		$bukti_transfer = array();
		$dir = 'webfile/sponsorship/';
		$config['upload_path']          = './webfile/sponsorship/';
		$config['allowed_types']        = '*';
		// $config['max_size']             = 500;
		// $config['max_width']            = 2048;
		// $config['max_height']           = 1000;
		$config['encrypt_name'] 		= true;
		$this->load->library('upload', $config);

		for ($i = 1; $i <= 10; $i++) {
			if (!empty($_FILES['bukti_transfer' . $i]['name'])) {
				if ($this->upload->do_upload('bukti_transfer' . $i)) {
					$uploadData = $this->upload->data();
					$bukti_transfer[] = $dir . $uploadData['file_name'];
				}
			}
		}



		if (count($bukti_transfer) >= 1) {
			$dt['bukti_transfer'] = json_encode($bukti_transfer);
		}

		$str = $this->mymodel->updateData('sponsorship', $dt, ['id' => $post['id']]);
		// echo 'success';

		// }
		$hash_url = str_replace("#", "", $post['tab_index']);
		if ($hash_url <= 5) {
			redirect('master/sponsorship/edit/' . $post['id'] . '#' . ($hash_url + 1));
		} else {
			redirect('master/sponsorship');
		}

		/*
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->validate();

			if ($this->form_validation->run() == FALSE){
				echo validation_errors();   
	        }else{
				$id = $this->input->post('id', TRUE);
				if (!empty($_FILES['file']['name'])){
					$directory = 'webfile/sponsorship/';
					$filename = $_FILES['file']['name'];
					$allowed_types = 'gif|jpg|png';
					$max_size = '2000';
					$result = $this->uploadfile->upload('file',$filename,$directory,$allowed_types, $max_size);
					if($result['alert'] == 'success'){
						$data = array(
							'name'=> $result['message']['name'],
							'mime'=> $result['message']['mime'],
							'dir'=> $result['message']['dir'],
							'table'=> 'sponsorship',
							'table_id'=> $id,
							'updated_at'=>date('Y-m-d H:i:s')
						);
						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'sponsorship'));
						@unlink($file['dir']);
						if($file==""){
							$this->mymodel->insertData('file', $data);
						}else{
							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));
						}

						$dt = $this->input->post('dt');
						$dt['nominal_sponsor'] = str_replace(',','',$dt['nominal_pajak_sponsor']);
						$dt['nominal_pajak_sponsor'] = str_replace(',','',$dt['nominal_pajak_sponsor']);
						$dt['updated_at'] = date("Y-m-d H:i:s");
						$dt['updated_by'] = $this->session->userdata('id');
						$str =  $this->mymodel->updateData('sponsorship', $dt , array('id'=>$id));
						if($str==true){
							echo 'success';
						}else{
							echo 'Something error in system';
						}
					}else{
						echo $result['message'];
					}

				}else{
					$dt = $this->input->post('dt');
					$dt['nominal_sponsor'] = str_replace(',','',$dt['nominal_pajak_sponsor']);
					$dt['nominal_pajak_sponsor'] = str_replace(',','',$dt['nominal_pajak_sponsor']);
					$dt['updated_at'] = date("Y-m-d H:i:s");
					$str = $this->mymodel->updateData('sponsorship', $dt , array('id'=>$id));
					if($str==true){
						echo 'success';
					}else{
						echo 'Something error in system';
					}
				}
			}

			*/
	}

	public function delete()
	{
		$id = $this->input->post('id', TRUE);
		$file = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'sponsorship'));
		@unlink($file['dir']);
		$this->mymodel->deleteData('file',  array('table_id' => $id, 'table' => 'sponsorship'));
		$str = $this->mymodel->deleteData('sponsorship',  array('id' => $id));
		if ($str == true) {
			echo "success";
		} else {
			echo "Something error in system";
		}
	}

	public function deleteData()
	{
		$data = $this->input->post('data');
		if ($data != "") {
			$id = explode(',', $data);
			$this->db->where_in('id', $id);
			$this->db->delete('sponsorship', []);
			if ($str == true) {
				echo "success";
			} else {
				echo "Something error in system";
			}
		} else {
			echo "success";
		}
	}

	public function status($id, $status)
	{
		$this->mymodel->updateData('sponsorship', array('status' => $status), array('id' => $id));
		redirect('master/Sponsorship');
	}

	public function getdatapic($idsponsorship)
	{
		$sponsor = $this->mymodel->selectDataone('sponsorship', ['id' => $idsponsorship]);
		$datapic = json_decode($sponsor['pic']);
		$text = "";
		foreach ($datapic as $key => &$valpic) {
			$user = $this->mymodel->selectDataone('user', ['id' => $valpic]);
			if (count($datapic) == $key + 1) {
				$text .= $user['name'];
			} else {
				$text .= $user['name'] . ',<br>';
			}
		}

		echo $text;
	}

	public function exportexcel()
	{
		$data['sponsorship'] = $this->mymodel->selectData('sponsorship');

		$this->load->view('master/sponsorship/export-sponsorship', $data, FALSE);
	}
}
