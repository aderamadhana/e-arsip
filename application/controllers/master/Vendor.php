<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Vendor extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
			define('vendor', 'vendor');
			
		}

		public function index()
		{
			$data['page_name'] = "vendor";
			$this->template->load('template/template','master/vendor/all-vendor',$data);
		}
		

		public function create()
		{
			$data['page_name'] = "vendor";
			$this->template->load('template/template','master/vendor/add-vendor',$data);
		}
		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[nama]', '<strong>Nama Vendor/Konsultan</strong>', 'required');
			$this->form_validation->set_rules('dt[tanggal]', '<strong>Tanggal Pelaksanaan</strong>', 'required');
			$this->form_validation->set_rules('dt[penjelasan_singkat]', '<strong>Penjelasan Singkat</strong>', 'required');
			$this->form_validation->set_rules('dt[nilai_jasa]', '<strong>Nilai Jasa Vendor/Konsultan</strong>', 'required');
			$this->form_validation->set_rules('dt[department_id]', '<strong>Department </strong>', 'required');

			$this->form_validation->set_rules('dt[kategori]', '<strong>Kategori</strong>', 'required');
			$this->form_validation->set_rules('dt[tipe_id]', '<strong>Tipe</strong>', 'required');
			$this->form_validation->set_rules('dt[pic_vendor]', '<strong>PIC Vendor/Konsultan	</strong>', 'required');
			$this->form_validation->set_rules('dt[pic_nomor_vendor]', '<strong>No HP PIC Vendor/Konsultan	</strong>', 'required');
			$this->form_validation->set_rules('dt[penjelasan_keuntungan]', '<strong>Penjelasan Keuntungan	</strong>', 'required');
			$this->form_validation->set_rules('dt[nominal_akhir]', '<strong>Nominal Akhir</strong>', 'required');
			$this->form_validation->set_rules('dt[is_pajak]', '<strong>Fee termaksud pajak ?</strong>', 'required');
			$this->form_validation->set_rules('dt[termin_pembayaran]', '<strong>Termin Pembayaran	</strong>', 'required');
			$this->form_validation->set_rules('dt[is_kegiatan_terlaksana]', '<strong>Project/Kegiatan terlaksana?	</strong>', 'required');
			$this->form_validation->set_rules('dt[catatan_kegiatan]', '<strong>Catatan Project</strong>', 'required');
			$this->form_validation->set_rules('dt[dasar_pertimbangan]', '<strong>Dasar Pertimbangan memilih vendor/konsultan	</strong>', 'required');
			$this->form_validation->set_rules('dt[penilaian_hasil]', '<strong>Penilaian Hasil Akhir Vendor/Konsultan		</strong>', 'required');
			
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
				if(count($post['pic'])>3){
					echo "<li>PIC pelaksana tidak boleh lebih dari 3</li>";
					return false;
				}

				$dt['tanggal_transfer'] = json_encode($post['tanggal_transfer']);
				$dt['pic'] = json_encode($post['pic']);
				$dt['nilai_jasa'] = str_replace(',','',$dt['nilai_jasa']);
				$dt['nominal_akhir'] = str_replace(',','',$dt['nominal_akhir']);
				// ================================================================
				$config['upload_path']          = './webfile/vendor/';
				$config['allowed_types']        = '*';
				// $config['max_size']             = 500;
				// $config['max_width']            = 2048;
				// $config['max_height']           = 1000;
				$config['encrypt_name'] 		= true;
				$this->load->library('upload',$config);
				$jumlah_files = count($_FILES['files']['name']);
				for($i = 0; $i < $jumlah_files;$i++)
				{
					if(!empty($_FILES['files']['name'][$i])){
						$_FILES['file']['name'] = $_FILES['files']['name'][$i];
						$_FILES['file']['type'] = $_FILES['files']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
						$_FILES['file']['error'] = $_FILES['files']['error'][$i];
						$_FILES['file']['size'] = $_FILES['files']['size'][$i];
			
						if($this->upload->do_upload('file')){
							
							$uploadData = $this->upload->data();
							$dataimg[] = [
								'name' => $post['nama_files'][$i],
								'dir' => 'webfile/vendor/'.$uploadData['file_name']
							];
						}
					}
				}
				if($dataimg){
					$dt['files'] = json_encode($dataimg);
				}


				$directory = 'webfile/vendor/';
				$filename = $_FILES['spk']['name'];
				$allowed_types = 'gif|jpg|png';
				$max_size = '2000';
				// $result = $this->uploadfile->upload('spk',$filename,$directory,$allowed_types, $max_size);
				$result = $this->upload_file_dir('spk',$directory);
				if($result['response'] == true){
					$dt['spk'] = $result['message']['dir'];
				}

				$filename = $_FILES['penilaian']['name'];
				$result = $this->upload_file_dir('penilaian',$directory);

				if($result['response'] == true){
					$dt['penilaian'] = $result['message']['dir'];
				}

				$bukti_transfer = array();
				$dir = 'webfile/vendor/';
				$config['upload_path']          = './webfile/sponsorship/';
				$config['allowed_types']        = '*';
				// $config['max_size']             = 500;
				// $config['max_width']            = 2048;
				// $config['max_height']           = 1000;
				$config['encrypt_name'] 		= true;
				$this->load->library('upload',$config);
			

				for ($i=1; $i <=10 ; $i++) {
					if(!empty($_FILES['bukti_transfer'.$i]['name'])){
						if($this->upload->do_upload('bukti_transfer'.$i)){
							$uploadData = $this->upload->data();
							$bukti_transfer[] = $dir.$uploadData['file_name'];
						}
					}
				}


				if (count($bukti_transfer)>=1) {
					$dt['bukti_transfer'] = json_encode($bukti_transfer);
				}


				
				// ================================================================
				
				
				$str = $this->mymodel->insertData('vendor', $dt);
				$id = $this->db->insert_id();
				$hash_url = str_replace("#", "", $post['tab_index']);
				if($hash_url<=4){
					redirect('master/vendor/edit/'.$id.'#'.($hash_url+1));
				}else{
					redirect('master/sponsorship');
				}
				// echo 'success';
				// print_r($dt);

			// }
			
		
			
		}

		public function json()
		{
			$param = $this->input->post();
			if (@$param['pic']) {
				foreach ($param['pic'] as $key => &$value) {
					if (count($param['pic'])==$key+1) {
						$textpic = '"'.$value.'"';
					}else{
						$textpic = '"'.$value.'",';
					}
				}
			}
			header('Content-Type: application/json');
	        $this->datatables->select('vendor.id,vendor.nama,vendor.tanggal,vendor.tanggal_selesai,vendor.status,vendor.penjelasan_singkat,vendor.pic,vendor.is_kegiatan_terlaksana,vendor.penilaian_hasil');
	        // $this->datatables->where('vendor.status',$status);
	        $this->datatables->from('vendor');
	        if ($param['tipe']) {
	        	$this->datatables->where('kategori', $param['tipe']);
	        }
	        if (@$param['pic']) {
	        	$this->datatables->like('pic', $textpic, 'BOTH');
	        }
	        if ($param['status']) {
	        	if ($param['status']==2) {
	        		$this->datatables->where('is_kegiatan_terlaksana', 0);
	        	}else{
	        		$this->datatables->where('is_kegiatan_terlaksana', $param['status']);
	        	}
	        }
	        if ($param['tanggal']) {
	        	$this->datatables->where('tanggal', $param['tanggal']);
	        }
	        // if($status=="ENABLE"){
			$this->datatables->add_column('view', '<div class="btn-group">
														<button style="font-size:14px" type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
														<button style="font-size:14px" type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
												</div>', 'id');
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
					<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
					<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
				</div>', 'id');
			}

	        echo $this->datatables->generate();
		}

		public function edit($id)
		{
			$data['vendor'] = $this->mymodel->selectDataone('vendor',array('id'=>$id));	
			$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'vendor'));		
			$data['page_name'] = "vendor";
			$this->template->load('template/template','master/vendor/edit-vendor',$data);
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
				if(count($post['pic'])>3){
					echo "<li>PIC pelaksana tidak boleh lebih dari 3</li>";
					return false;
				}

				$dt['pic'] = json_encode($post['pic']);
				$dt['tanggal_transfer'] = json_encode($post['tanggal_transfer']);
				$dt['nilai_jasa'] = str_replace(',','',$dt['nilai_jasa']);
				$dt['nominal_akhir'] = str_replace(',','',$dt['nominal_akhir']);
				// ================================================================
				foreach($post['nama_files_old'] as $k => $files_old){

					$dataimg[] = [
						'name' => $files_old,
						'dir' => $post['files_old'][$k]
					];
				}
				$config['upload_path']          = './webfile/vendor/';
				$config['allowed_types']        = '*';
				// $config['max_size']             = 500;
				// $config['max_width']            = 2048;
				// $config['max_height']           = 1000;
				$config['encrypt_name'] 		= true;
				$this->load->library('upload',$config);
				$jumlah_files = count($_FILES['files']['name']);
				for($i = 0; $i < $jumlah_files;$i++)
				{
					if(!empty($_FILES['files']['name'][$i])){
						$_FILES['file']['name'] = $_FILES['files']['name'][$i];
						$_FILES['file']['type'] = $_FILES['files']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
						$_FILES['file']['error'] = $_FILES['files']['error'][$i];
						$_FILES['file']['size'] = $_FILES['files']['size'][$i];
			
						if($this->upload->do_upload('file')){
							
							$uploadData = $this->upload->data();
							$dataimg[] = [
								'name' => $post['nama_files'][$i],
								'dir' => 'webfile/vendor/'.$uploadData['file_name']
							];
						}
					}
				}
				if($dataimg){
					$dt['files'] = json_encode($dataimg);
				}


				$directory = 'webfile/vendor/';
				$filename = $_FILES['spk']['name'];
				$allowed_types = 'gif|jpg|png';
				$max_size = '2000';
				// $result = $this->uploadfile->upload('spk',$filename,$directory,$allowed_types, $max_size);
				$result = $this->upload_file_dir('spk',$directory);
				if($result['response'] == true){
					$dt['spk'] = $result['message']['dir'];
				}

				$filename = $_FILES['penilaian']['name'];
				$result = $this->upload_file_dir('penilaian',$directory);

				if($result['response'] == true){
					$dt['penilaian'] = $result['message']['dir'];
				}

				$bukti_transfer = array();
				$dir = 'webfile/vendor/';
				$config['upload_path']          = './webfile/sponsorship/';
				$config['allowed_types']        = '*';
				// $config['max_size']             = 500;
				// $config['max_width']            = 2048;
				// $config['max_height']           = 1000;
				$config['encrypt_name'] 		= true;
				$this->load->library('upload',$config);
				

				for ($i=1; $i <=10 ; $i++) {
					if(!empty($_FILES['bukti_transfer'.$i]['name'])){
						if($this->upload->do_upload('bukti_transfer'.$i)){
							$uploadData = $this->upload->data();
							$bukti_transfer[] = $dir.$uploadData['file_name'];
						}
					}
				}


				if (count($bukti_transfer)>=1) {
					$dt['bukti_transfer'] = json_encode($bukti_transfer);
				}


				
				// ================================================================
				
				
				$str = $this->mymodel->updateData('vendor', $dt,['id'=>$post['id']]);
				// echo 'success';
				// print_r($dt);
				$hash_url = str_replace("#", "", $post['tab_index']);
				if($hash_url<=4){
					redirect('master/vendor/edit/'.$post['id'].'#'.($hash_url+1));
				}else{
					redirect('master/vendor');
				}

			// }

			/*

			$post = $this->input->post();
			$dt = $post['dt'];
			$this->form_validation->set_error_delimiters('<li>', '</li>');

			$this->validate();
			if ($this->form_validation->run() == FALSE){
				echo validation_errors();    
	        }else{
				$dt['pic'] = json_encode($post['pic']);
				$dt['keuntungan_id'] = json_encode($post['keuntungan_id']);
				$dt['nilai_sponsor'] = str_replace(',','',$dt['nilai_sponsor']);
				// ================================================================
				foreach($post['nama_files_old'] as $k => $files_old){

					$dataimg[] = [
						'name' => $files_old,
						'dir' => $post['files_old'][$k]
					];
				}
				$config['upload_path']          = './webfile/vendor/';
				$config['allowed_types']        = '*';
				$config['encrypt_name'] 		= true;
				$this->load->library('upload',$config);
				$jumlah_files = count($_FILES['files']['name']);
				for($i = 0; $i < $jumlah_files;$i++)
				{
					if(!empty($_FILES['files']['name'][$i])){
						$_FILES['file']['name'] = $_FILES['files']['name'][$i];
						$_FILES['file']['type'] = $_FILES['files']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
						$_FILES['file']['error'] = $_FILES['files']['error'][$i];
						$_FILES['file']['size'] = $_FILES['files']['size'][$i];
			
						if($this->upload->do_upload('file')){
							
							$uploadData = $this->upload->data();
							$dataimg[] = [
								'name' => $post['nama_files'][$i],
								'dir' => $uploadData['file_name']
							];
						}
					}
				}
				if($dataimg){
					$dt['files'] = json_encode($dataimg);
				}
				// ================================================================
				
				if($post['kantor']){
					foreach($post['kantor'] as $key => $kantor){
						$datasharing[] = [
							'kantor' =>$kantor,
							'presentase'=>$post['presentase'][$key]
						];
					}
					$dt['sharing'] = json_encode($datasharing);

				}

				$str = $this->mymodel->updateData('vendor', $dt,['id'=>$post['id']]);
				echo 'success';

			}
			*/

		}

		public function delete()
		{
			$id = $this->input->post('id', TRUE);
			$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'vendor'));
			@unlink($file['dir']);
			$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'vendor'));
			$str = $this->mymodel->deleteData('vendor',  array('id'=>$id));
			if($str==true){
				echo "success";
			}else{
				echo "Something error in system";
			}  
					
		}

		public function deleteData()
		{
			$data = $this->input->post('data');
			if($data!=""){
				$id = explode(',',$data);
				$this->db->where_in('id',$id);
				$this->db->delete('vendor',[]);
				if($str==true){
					echo "success";
				}else{
					echo "Something error in system";
				} 
			}else{
				echo "success";
			}
		}

		public function status($id,$status)
		{
			$this->mymodel->updateData('vendor',array('status'=>$status),array('id'=>$id));
			redirect('master/vendor');
		}

		public function getdatapic($idsponsorship)
		{
			$sponsor = $this->mymodel->selectDataone('vendor',['id'=>$idsponsorship]);
			$datapic = json_decode($sponsor['pic']);
			$text = "";
			foreach ($datapic as $key => &$valpic) {
				$user = $this->mymodel->selectDataone('user',['id'=>$valpic]);
				if (count($datapic)==$key+1) {
					$text .= $user['name'];
				}else{
					$text .= $user['name'].',<br>';
				}
			}

			echo $text;
		}


		public function exportexcel()
		{
			$data['vendor'] = $this->mymodel->selectData('vendor');
			$this->load->view('master/vendor/export-vendor', $data, FALSE);
		}
	}
