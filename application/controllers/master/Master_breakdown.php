<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Master_breakdown extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['page_name'] = "master_breakdown";
			$this->template->load('template/template','master/master_breakdown/all-master_breakdown',$data);
		}
		
		public function create()
		{
			$this->load->view('master/master_breakdown/add-master_breakdown');
		}
		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[mb_keterangan]', '<strong>Mb Keterangan</strong>', 'required');
			$this->form_validation->set_rules('dt[mb_biaya]', '<strong>Mb Biaya</strong>', 'required');
			$this->form_validation->set_rules('dt[mb_periode_awal]', '<strong>Mb Periode Awal</strong>', 'required');
			$this->form_validation->set_rules('dt[mb_periode_akhir]', '<strong>Mb Periode Akhir</strong>', 'required');
			
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
				$str = $this->mymodel->insertData('master_breakdown', $dt);
				
			echo 'success';

		   

			}
		}

		public function json()
		{
			$status = $_GET['status'];
			if($status=='') $status = 'ENABLE';
			
			header('Content-Type: application/json');
	        $this->datatables_search->select('master_breakdown.id_breakdown,master_breakdown.mb_keterangan,master_breakdown.mb_biaya,master_breakdown.mb_periode_awal,master_breakdown.mb_periode_akhir,master_breakdown.mb_sisa_anggaran,status');
	        $this->datatables_search->where('master_breakdown.status',$status);
	        $this->datatables_search->from('master_breakdown');
	        if($status=="ENABLE"){
				$this->datatables_search->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
																	<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
															</div>', 'id_breakdown');
	    	}else{
				$this->datatables_search->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
																	<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
															</div>', 'id_breakdown');
	    	}
	        echo $this->datatables_search->generate();
		}
		
		public function edit($id)
		{
			$data['master_breakdown'] = $this->mymodel->selectDataone('master_breakdown',array('id_breakdown'=>$id));		
			$data['page_name'] = "master_breakdown";
			$this->load->view('master/master_breakdown/edit-master_breakdown',$data);
		}

		public function update()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->validate();

			if ($this->form_validation->run() == FALSE){
				echo validation_errors();   
	        }else{
				$id = $this->input->post('id_breakdown', TRUE);		
				$dt = $this->input->post('dt');
				$dt['updated_at'] = date("Y-m-d H:i:s");
				$str = $this->mymodel->updateData('master_breakdown', $dt , array('id_breakdown'=>$id));
				if($str==true){
					echo "success";
				}else{
					echo "Something error in system";
				}  
			}
		}

		public function delete()
		{
			$id = $this->input->post('id_breakdown', TRUE);
			$str = $this->mymodel->deleteData('master_breakdown', array('id_breakdown'=>$id));
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
				$this->db->where_in('id_breakdown',$id);
				$this->db->delete('master_breakdown',[]);
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
			$this->mymodel->updateData('master_breakdown',array('status'=>$status),array('id_breakdown'=>$id));
			redirect('master/Master_breakdown');
		}

		public function getbreakdown()
		{
			$tgl = $this->input->post('tanggal');
			$this->db->where('mb_periode_awal <=', $tgl);
			$this->db->where('mb_periode_akhir >=', $tgl);
			$getbreakdown = $this->mymodel->selectDataone('master_breakdown',['status'=>"ENABLE"]);
			$total_realisasi = str_replace(',', '', $getbreakdown['mb_biaya'])-str_replace(',', '', $getbreakdown['mb_sisa_anggaran']);

			$arraybreakdown = array('total_realisasi'=> number_format($total_realisasi , 0, ',', ','),
									'sisa_anggaran'=> number_format($getbreakdown['mb_sisa_anggaran'] , 0, ',', ','),
								   );

			echo json_encode($arraybreakdown);
			
		}
	}
?>