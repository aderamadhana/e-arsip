<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class M_disposisi extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['page_name'] = "m_disposisi";
			$this->template->load('template/template','master/m_disposisi/all-m_disposisi',$data);
		}
		

		public function create()
		{
			$data['page_name'] = "m_disposisi";
			$this->template->load('template/template','master/m_disposisi/add-m_disposisi',$data);
		}
		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[md_nama]', '<strong>Md Nama</strong>', 'required');
			
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
				$str = $this->mymodel->insertData('m_disposisi', $dt);
				
			echo 'success';

		   

			}
		}

		public function json()
		{
			$status = $_GET['status'];
			if($status=='') $status = 'ENABLE';
			
			header('Content-Type: application/json');
	        $this->datatables->select('m_disposisi.md_id,m_disposisi.md_nama,status');
	        $this->datatables->where('m_disposisi.status',$status);
	        $this->datatables->from('m_disposisi');
	        if($status=="ENABLE"){
				$this->datatables->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
																	<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
															</div>', 'md_id');
	    	}else{
				$this->datatables->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
																	<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
															</div>', 'md_id');
	    	}
	        echo $this->datatables->generate();
		}

		public function edit($id)
		{
			$data['m_disposisi'] = $this->mymodel->selectDataone('m_disposisi',array('md_id'=>$id));		
			$data['page_name'] = "m_disposisi";
			$this->template->load('template/template','master/m_disposisi/edit-m_disposisi',$data);
		}

		public function update()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->validate();

			if ($this->form_validation->run() == FALSE){
				echo validation_errors();   
	        }else{
				$id = $this->input->post('md_id', TRUE);		
				$dt = $this->input->post('dt');
				$dt['updated_at'] = date("Y-m-d H:i:s");
				$str = $this->mymodel->updateData('m_disposisi', $dt , array('md_id'=>$id));
				if($str==true){
					echo "success";
				}else{
					echo "Something error in system";
				}  
			}
		}

		public function delete()
		{
			$id = $this->input->post('md_id', TRUE);
			$str = $this->mymodel->deleteData('m_disposisi', array('md_id'=>$id));
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
				$this->db->where_in('md_id',$id);
				$this->db->delete('m_disposisi',[]);
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
			$this->mymodel->updateData('m_disposisi',array('status'=>$status),array('md_id'=>$id));
			redirect('master/M_disposisi');
		}
	}
?>