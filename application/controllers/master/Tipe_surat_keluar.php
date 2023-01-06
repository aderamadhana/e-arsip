<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Tipe_surat_keluar extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['page_name'] = "tipe_surat_keluar";
			$this->template->load('template/template','master/tipe_surat_keluar/all-tipe_surat_keluar',$data);
		}
		

		public function create()
		{
			$data['page_name'] = "tipe_surat_keluar";
			$this->template->load('template/template','master/tipe_surat_keluar/add-tipe_surat_keluar',$data);
		}
		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[nama]', '<strong>Nama</strong>', 'required');
			$this->form_validation->set_rules('dt[kode]', '<strong>Kode</strong>', 'required');
			
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
				$str = $this->mymodel->insertData('tipe_surat_keluar', $dt);
				
			echo 'success';

		   

			}
		}

		public function json()
		{
			$status = $_GET['status'];
			if($status=='') $status = 'ENABLE';
			
			header('Content-Type: application/json');
	        $this->datatables->select('tipe_surat_keluar.id,tipe_surat_keluar.nama,tipe_surat_keluar.kode,status');
	        $this->datatables->where('tipe_surat_keluar.status',$status);
	        $this->datatables->from('tipe_surat_keluar');
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
			$data['tipe_surat_keluar'] = $this->mymodel->selectDataone('tipe_surat_keluar',array('id'=>$id));		
			$data['page_name'] = "tipe_surat_keluar";
			$this->template->load('template/template','master/tipe_surat_keluar/edit-tipe_surat_keluar',$data);
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
				$str = $this->mymodel->updateData('tipe_surat_keluar', $dt , array('id'=>$id));
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
			$str = $this->mymodel->deleteData('tipe_surat_keluar', array('id'=>$id));
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
				$this->db->delete('tipe_surat_keluar',[]);
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
			$this->mymodel->updateData('tipe_surat_keluar',array('status'=>$status),array('id'=>$id));
			redirect('master/Tipe_surat_keluar');
		}
	}
?>