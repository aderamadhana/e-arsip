<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class M_kategori_surat extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['page_name'] = "m_kategori_surat";
			$this->template->load('template/template','master/m_kategori_surat/all-m_kategori_surat',$data);
		}
		

		public function create()
		{
			$data['page_name'] = "m_kategori_surat";
			$this->template->load('template/template','master/m_kategori_surat/add-m_kategori_surat',$data);
		}
		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[mkt_kategori]', '<strong>Mkt Kategori</strong>', 'required');
			$this->form_validation->set_rules('dt[mkt_tipe]', '<strong>Mkt Tipe</strong>', 'required');
			$this->form_validation->set_rules('dt[tsk_id]', '<strong>Tsk Id</strong>', 'required');
			
		}

		public function store()
		{
			$this->validate();
			if ($this->form_validation->run() == FALSE){
				echo validation_errors();    
	        }else{
				$dt = $this->input->post('dt');
				$dt['created_at'] = date('Y-m-d H:i:s');
				$dt['created_by'] = $this->session->userdata('id');
				$dt['status'] = "ENABLE";
				$str = $this->mymodel->insertData('m_kategori_surat', $dt);
					    
				$last_id = $this->db->insert_id();
				if (!empty($_FILES['file']['name'])){
					$directory = 'webfile/';
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
							'table'=> 'm_kategori_surat',
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
						'table'=> 'm_kategori_surat',
						'table_id'=> $last_id,
						'status'=>'ENABLE',
						'created_at'=>date('Y-m-d H:i:s')
					);
					$str = $this->mymodel->insertData('file', $data);
					echo 'success';
				}
					    

			}
		}

		public function json()
		{
			$status = $_GET['status'];
			if($status=='') $status = 'ENABLE';
			
			header('Content-Type: application/json');
	        $this->datatables->select('m_kategori_surat.id,m_kategori_surat.mkt_kategori,m_kategori_surat.mkt_tipe,tipe_surat_keluar.nama,m_kategori_surat.status');
	        $this->datatables->join('tipe_surat_keluar','tsk_id = tipe_surat_keluar.id','left');
	        $this->datatables->where('m_kategori_surat.status',$status);
	        $this->datatables->from('m_kategori_surat');
	        if($status=="ENABLE"){
				$this->datatables->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
																	<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
															</div>', 'id');
	    	}else{
				$this->datatables->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
																	<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
															</div>', 'id');
	    	}
	        echo $this->datatables->generate();
		}

		public function edit($id)
		{
			$data['m_kategori_surat'] = $this->mymodel->selectDataone('m_kategori_surat',array('id'=>$id));	
			$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'m_kategori_surat'));		
			$data['page_name'] = "m_kategori_surat";
			$this->template->load('template/template','master/m_kategori_surat/edit-m_kategori_surat',$data);
		}

		public function update()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->validate();

			if ($this->form_validation->run() == FALSE){
				echo validation_errors();   
	        }else{
				$id = $this->input->post('id', TRUE);
				if (!empty($_FILES['file']['name'])){
					$directory = 'webfile/';
					$filename = $_FILES['file']['name'];
					$allowed_types = 'gif|jpg|png';
					$max_size = '2000';
					$result = $this->uploadfile->upload('file',$filename,$directory,$allowed_types, $max_size);
					if($result['alert'] == 'success'){
						$data = array(
							'name'=> $result['message']['name'],
							'mime'=> $result['message']['mime'],
							'dir'=> $result['message']['dir'],
							'table'=> 'm_kategori_surat',
							'table_id'=> $id,
							'updated_at'=>date('Y-m-d H:i:s')
						);
						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'m_kategori_surat'));
						@unlink($file['dir']);
						if($file==""){
							$this->mymodel->insertData('file', $data);
						}else{
							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));
						}

						$dt = $this->input->post('dt');
						$dt['updated_at'] = date("Y-m-d H:i:s");
						$dt['updated_by'] = $this->session->userdata('id');
						$str =  $this->mymodel->updateData('m_kategori_surat', $dt , array('id'=>$id));
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
					$dt['updated_at'] = date("Y-m-d H:i:s");
					$str = $this->mymodel->updateData('m_kategori_surat', $dt , array('id'=>$id));
					if($str==true){
						echo 'success';
					}else{
						echo 'Something error in system';
					}
				}
			}
		}

		public function delete()
		{
			$id = $this->input->post('id', TRUE);
			$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'m_kategori_surat'));
			@unlink($file['dir']);
			$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'m_kategori_surat'));
			$str = $this->mymodel->deleteData('m_kategori_surat',  array('id'=>$id));
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
				$this->db->delete('m_kategori_surat',[]);
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
			$this->mymodel->updateData('m_kategori_surat',array('status'=>$status),array('id'=>$id));
			redirect('master/M_kategori_surat');
		}
	}
?>