<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Notification extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
		}
		public function index()
		{
			$data['page_name'] = "notification";
			$this->template->load('template/template','master/notification/all-notification',$data);
		}
		public function create()
		{
			$data['page_name'] = "notification";
			$this->template->load('template/template','master/notification/add-notification',$data);
		}
		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[slug]', '<strong>Slug</strong>', 'required');
			// $this->form_validation->set_rules('dt[user_id]', '<strong>User Id</strong>', 'required');
			$this->form_validation->set_rules('dt[role_id]', '<strong>Role Id</strong>', 'required');
		}
		public function store()
		{
			$this->validate();
	    	if ($this->form_validation->run() == FALSE){
				$this->alert->alertdanger(validation_errors());     
	        }else{
	        	$dt = $_POST['dt'];
	        	if (@$dt['user_id']) {
		        	$user = $this->mmodel->selectWhere('user',['id'=>$dt['user_id']])->row();
		        	$dt['user_name'] = $user->name;
	        	}

	        	if (@$dt['role_id']) {
	        		if ($dt['role_id']=="allrole") {
	        			unset($dt['user_id']);
	        			unset($dt['user_name']);
			        	$role = $this->mmodel->selectWhere('role',['status'=>'ENABLE'])->result();
	        			foreach ($role as $vrole) {
			        		$dt['role_name'] = $vrole->role;
							$str = $this->mymodel->insertData('notification', $dt);
	        			}
	        		} else {
			        	$role = $this->mmodel->selectWhere('role',['id'=>$dt['role_id']])->row();
			        	$dt['role_name'] = $role->role;
						$str = $this->mymodel->insertData('notification', $dt);
	        		}
	        	} else {
					$str = $this->mymodel->insertData('notification', $dt);
	        	}
				$last_id = $this->db->insert_id();
				$this->alert->alertsuccess('Success Send Data');   
			}
		}
		public function json()
		{
			header('Content-Type: application/json');
	        $this->datatables->select('id,slug,user_id,role_id,user_name,role_name');
	        $this->datatables->from('notification');
	        $this->datatables->add_column('view', '<div class="btn-group"><button type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button><button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button></div>', 'id');
	        echo $this->datatables->generate();
		}
		public function edit($id)
		{
			$data['notification'] = $this->mymodel->selectDataone('notification',array('id'=>$id));$data['page_name'] = "notification";
			$this->template->load('template/template','master/notification/edit-notification',$data);
		}
		public function update()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->validate();
	    	if ($this->form_validation->run() == FALSE){
				$this->alert->alertdanger(validation_errors());     
	        }else{
				$id = $this->input->post('id', TRUE);		
				$dt = $_POST['dt'];

	        	if (@$dt['user_id']) {
		        	$user = $this->mmodel->selectWhere('user',['id'=>$dt['user_id']])->row();
		        	$dt['user_name'] = $user->name;
	        	} else {
		        	$dt['user_name'] = null;
	        	}
	        	if (@$dt['role_id']) {
		        	$role = $this->mmodel->selectWhere('role',['id'=>$dt['role_id']])->row();
		        	$dt['role_name'] = $role->role;
	        	} else {
		        	$dt['role_name'] = null;
	        	}

				$str = $this->mymodel->updateData('notification', $dt , array('id'=>$id));
				$this->alert->alertsuccess('Success Send Data');   
					// return $str;  
			}
		}
		public function delete()
		{
				$id = $this->input->post('id', TRUE);
				$str = $this->mymodel->deleteData('notification',  array('id'=>$id));
				 return $str;
		}
		public function status($id,$status)
		{
			$this->mymodel->updateData('notification',array('status'=>$status),array('id'=>$id));
			redirect('master/Notification');
		}

		public function expUpdate($tipe="add")
		{
			#contoh penggunaan mnotif
			#parameter updateByRole =  slug, role_id(bisa tunggal, bisa array), angka notif (untuk menambah isi angka positif, untuk mengurangi isi angka negatif, dan kosongi parameter untuk menjumlah 1 angka notif)
			#parameter updateAllRole = slug, angka notif (untuk menambah isi angka positif, untuk mengurangi isi angka negatif, dan kosongi parameter untuk menjumlah 1 angka notif)

			if ($tipe=="add") {
				$this->mnotif->updateByRole('google-drive','17'); #contoh tambah 1 angka notif dengan 1 role
			} elseif ($tipe=="min") {
				$this->mnotif->updateByRole('google-drive',['17'],'-1'); #contoh mengurangi 1 angka notif dengan multi role
			} elseif ($tipe=="all") {
				$this->mnotif->updateAllRole('google-drive'); #contoh tambah 1 angka notif semua role
			}

			redirect('master/notification','refresh');
		}
	}
?>