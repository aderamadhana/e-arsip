
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Role extends MY_Controller {

		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['page_name'] = "role";
			$this->template->load('template/template','master/role/all-role',$data);
		}

		public function create()
		{
			$data['page_name'] = "role";
			$this->template->load('template/template','master/role/add-role',$data);
		}


		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
	$this->form_validation->set_rules('dt[role]', '<strong>Role</strong>', 'required');
	$this->form_validation->set_rules('dt[slug]', '<strong>Slug</strong>', 'required');
	}

		public function store()
		{
			$this->validate();
	    	if ($this->form_validation->run() == FALSE){
				$this->alert->alertdanger(validation_errors());     
	        }else{
	        	$dt = $_POST['dt'];
				$dt['created_at'] = date('Y-m-d H:i:s');
				$dt['status'] = "ENABLE";
				$str = $this->db->insert('role', $dt);
				$last_id = $this->db->insert_id();$this->alert->alertsuccess('Success Send Data');   
					
			}
		}

		public function json()
		{
			$status = $_GET['status'];
			header('Content-Type: application/json');
	        $this->datatables->select('id,role,status');
	        $this->datatables->where('status',$status);
	        $this->datatables->from('role');
	        if($status=="ENABLE"){
	        $this->datatables->add_column('view', '<div class="btn-group"><button type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button></div>', 'id');

	    	}else{
	        $this->datatables->add_column('view', '<div class="btn-group"><button type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button><button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button></div>', 'id');

	    	}
	        echo $this->datatables->generate();
		}
		public function edit($id)
		{
			$data['role'] = $this->mymodel->selectDataone('role',array('id'=>$id));$data['page_name'] = "role";
			$this->template->load('template/template','master/role/edit-role',$data);
		}

		public function update()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			
			$this->validate();
			

	    	if ($this->form_validation->run() == FALSE){
				$this->alert->alertdanger(validation_errors());     
	        }else{
				$id = $this->input->post('id', TRUE);	
				$mn = json_encode($_POST['menu']);


				$dt = $_POST['dt'];
				$dt['menu'] = $mn;
				$dt['updated_at'] = date("Y-m-d H:i:s");
				$this->mymodel->updateData('role', $dt , array('id'=>$id));

				$all_menu = $this->mmodel->selectWhere('menu_master',['status'=>'ENABLE'])->result();
				foreach ($all_menu as $vmenu) {
					if (in_array($vmenu->id, $_POST['menu'])) {
						$this->db->delete('access_block', ['ab_role_id'=>$id,'ab_link'=>$vmenu->function]);
					} else {
						if ($vmenu->function) { //check if function is set
							$check_available = $this->mmodel->selectWhere('access_block',['ab_role_id'=>$id,'ab_link'=>$vmenu->function])->num_rows();
							if ($check_available==0) { // check if the link not blocked yet
								$this->db->insert('access_block', ['ab_role_id'=>$id,'ab_link'=>$vmenu->function]);
							}
						}
					}
				}

				$this->alert->alertsuccess('Success Update Data');  
			}
		}

		public function delete()
		{
				$id = $this->input->post('id', TRUE);$this->alert->alertdanger('Success Delete Data');     
		}

		public function status($id,$status)
		{
			$this->mymodel->updateData('role',array('status'=>$status),array('id'=>$id));
			redirect('master/role');
		}


	}
?>