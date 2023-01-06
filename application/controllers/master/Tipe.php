<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Tipe extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['page_name'] = "tipe";
			$this->template->load('template/template','master/tipe/all-tipe',$data);
		}
		
		public function create()
		{
			$this->load->view('master/tipe/add-tipe');
		}
		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[kategori]', '<strong>Kategori</strong>', 'required');
			$this->form_validation->set_rules('dt[tipe]', '<strong>Tipe</strong>', 'required');
			
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
				$str = $this->mymodel->insertData('tipe', $dt);
				
			echo 'success';

		   

			}
		}

		public function json()
		{
			$status = $_GET['status'];
			if($status=='') $status = 'ENABLE';
			
			header('Content-Type: application/json');
	        $this->datatables->select('tipe.id,tipe.kategori,tipe.tipe,status');
	        $this->datatables->where('tipe.status',$status);
	        $this->datatables->from('tipe');
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
			$data['tipe'] = $this->mymodel->selectDataone('tipe',array('id'=>$id));		
			$data['page_name'] = "tipe";
			$this->load->view('master/tipe/edit-tipe',$data);
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
				$str = $this->mymodel->updateData('tipe', $dt , array('id'=>$id));
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
			$str = $this->mymodel->deleteData('tipe', array('id'=>$id));
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
				$this->db->delete('tipe',[]);
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
			$this->mymodel->updateData('tipe',array('status'=>$status),array('id'=>$id));
			redirect('master/Tipe');
		}
	}
?>