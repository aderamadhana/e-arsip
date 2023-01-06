<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Authors extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['page_name'] = "authors";
			$this->template->load('template/template','master/authors/all-authors',$data);
		}
		
		public function create()
		{
			$this->load->view('master/authors/add-authors');
		}
		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[first_name]', '<strong>First Name</strong>', 'required');
			$this->form_validation->set_rules('dt[last_name]', '<strong>Last Name</strong>', 'required');
			$this->form_validation->set_rules('dt[email]', '<strong>Email</strong>', 'required');
			$this->form_validation->set_rules('dt[birthdate]', '<strong>Birthdate</strong>', 'required');
			$this->form_validation->set_rules('dt[address]', '<strong>Address</strong>', 'required');
			
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
				$str = $this->mymodel->insertData('authors', $dt);
					    
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
							'table'=> 'authors',
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
						'table'=> 'authors',
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
	        $this->datatables->select('authors.id,authors.first_name,authors.last_name,authors.email,authors.birthdate,authors.address,status');
	        $this->datatables->where('authors.status',$status);
	        $this->datatables->from('authors');
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
			$data['authors'] = $this->mymodel->selectDataone('authors',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'authors'));		
			$data['page_name'] = "authors";
			$this->load->view('master/authors/edit-authors',$data);
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
							'table'=> 'authors',
							'table_id'=> $id,
							'updated_at'=>date('Y-m-d H:i:s')
						);
						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'authors'));
						@unlink($file['dir']);
						if($file==""){
							$this->mymodel->insertData('file', $data);
						}else{
							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));
						}

						$dt = $this->input->post('dt');
						$dt['updated_at'] = date("Y-m-d H:i:s");
						$dt['updated_by'] = $this->session->userdata('id');
						$str =  $this->mymodel->updateData('authors', $dt , array('id'=>$id));
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
					$str = $this->mymodel->updateData('authors', $dt , array('id'=>$id));
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
			$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'authors'));
			@unlink($file['dir']);
			$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'authors'));
			$str = $this->mymodel->deleteData('authors',  array('id'=>$id));
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
				$this->db->delete('authors',[]);
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
			$this->mymodel->updateData('authors',array('status'=>$status),array('id'=>$id));
			redirect('master/Authors');
		}
	}
?>