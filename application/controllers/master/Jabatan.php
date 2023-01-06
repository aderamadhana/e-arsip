<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Jabatan extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['page_name'] = "jabatan";
			$this->template->load('template/template','master/jabatan/all-jabatan',$data);
		}
		

		public function create()
		{
			$data['page_name'] = "jabatan";
			$this->template->load('template/template','master/jabatan/add-jabatan',$data);
		}
		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[role_id]', '<strong>Role Id</strong>', 'required');
			$this->form_validation->set_rules('dt[jabatan]', '<strong>Jabatan</strong>', 'required');
			
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
				$str = $this->mymodel->insertData('jabatan', $dt);
				
			echo 'success';

		   

			}
		}

		public function json()
		{
			$status = $_GET['status'];
			if($status=='') $status = 'ENABLE';
			
			header('Content-Type: application/json');
	        $this->datatables->select('jabatan.id,role.role as role_id,jabatan.jabatan,jabatan.status');
	        $this->datatables->join('role', 'jabatan.role_id = role.id', 'left');
	        $this->datatables->where('jabatan.status',$status);
	        $this->datatables->from('jabatan');
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
			$data['jabatan'] = $this->mymodel->selectDataone('jabatan',array('id'=>$id));		
			$data['page_name'] = "jabatan";
			$this->template->load('template/template','master/jabatan/edit-jabatan',$data);
		}

		public function update()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->validate();

			if ($this->form_validation->run() == FALSE){
				echo validation_errors();   
	        }else{
				$id = $this->input->post('id', TRUE);		
				$dt = $this->input->post('dt');
				$dt['updated_at'] = date("Y-m-d H:i:s");
				$str = $this->mymodel->updateData('jabatan', $dt , array('id'=>$id));
				if($str==true){
					echo "success";
				}else{
					echo "Something error in system";
				}  
			}
		}

		public function delete()
		{
			$id = $this->input->post('id', TRUE);
			$str = $this->mymodel->deleteData('jabatan', array('id'=>$id));
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
				$this->db->delete('jabatan',[]);
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
			$this->mymodel->updateData('jabatan',array('status'=>$status),array('id'=>$id));
			redirect('master/Jabatan');
		}
	}
?>