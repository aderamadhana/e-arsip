<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{

	//============================================================================================================

	public function index()
	{
		$data_jabatan = [];
		$this->data['page_name'] = 'master';
		$this->db->select('jabatan.id,jabatan.role_id,role.role,jabatan.jabatan');
		$this->db->join('role', 'jabatan.role_id = role.id', 'left');
		$this->db->where('jabatan.status', 'ENABLE');
		$list_master_jabatan = $this->db->get('jabatan')->result_array();
		foreach ($list_master_jabatan as $master_jabatan) {
			$data_jabatan[$master_jabatan['role']][] = [
				'id' => $master_jabatan['id'],
				'jabatan' => $master_jabatan['jabatan']
			];
		}
		$this->data['encoded_json_jabatan'] = json_encode($data_jabatan);
		$this->template->load('template/template', 'master/user/user', $this->data);
	}

	public function json()
	{
		$data_user = $this->mymodel->selectdataone('user', ['id' => $this->session->userdata('id')]);
		header('Content-Type: application/json');
		$this->datatables->select('user.id,user.username,user.name,role.role,user.desc,user.is_login,user.jabatan,m_departemen.nama as nama_departement');
		$this->datatables->join('role', 'user.role_id=role.id', 'left');
		$this->datatables->join('m_departemen', 'user.departemen = m_departemen.id', 'left');
		// $this->datatables->join('file',"file.table_id=user.id AND `file`.`table` = 'user'",'left');

		$this->datatables->where(array('user.status' => 0));
		if ($this->session->userdata('role_slug') == 'kepala_departemen') {
			$this->datatables->where('departemen', $data_user['departemen']);
		}

		$this->datatables->from('user');
		if ($this->session->userdata('role_slug') == 'kepala_departemen') {
			$this->datatables->add_column('view', '<div class="btn-group"> <button onclick="activateUser($1)" type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Approve</button> <button onclick="resetPassword($1)"  class="btn btn-primary btn-flat btn-sm"><span class="txt-white fa fa-refresh"></span> Reset Password</button> </div>', 'id');
		} else if ($this->session->userdata('role_slug') == 'super_admin') {
			$this->datatables->add_column('view', '<div class="btn-group"> <a onclick="edit($1)" class="btn btn-info btn-flat btn-sm"Edit><span class="txt-white fa fa-edit"></span> Edit</a> <a onclick="hapus($1)"  class="btn btn-danger btn-flat btn-sm"><span class="txt-white fa fa-trash-o"></span> Delete</a> <a onclick="jumperLogin($1)"  class="btn btn-warning btn-flat btn-sm"><span class="txt-white fa fa-sign-in"></span> Login</a> <button onclick="resetPassword($1)"  class="btn btn-primary btn-flat btn-sm"><span class="txt-white fa fa-refresh"></span> Reset Password</button>  </div>', 'id');
		} else {
			$this->datatables->add_column('view', '', 'id');
		}

		echo $this->datatables->generate();
	}


	function json_activity($id)
	{
		$this->datatables->select('ip,link,get,post,user_id,created_at');
		$this->datatables->where(array('user_id' => $id));
		$this->datatables->from('activity');
		echo $this->datatables->generate();
	}

	public function store()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');

		$this->form_validation->set_rules(
			'dt[username]',
			'<strong>Username</strong>',
			'required|is_unique[user.username]',
			array(
				'required'      => 'You have not provided %s.',
				'is_unique'     => 'This %s already exists.'
			)
		);
		$this->form_validation->set_rules(
			'dt[email]',
			'<strong>Email</strong>',
			'required|is_unique[user.email]',
			array(
				'required'      => 'You have not provided %s.',
				'is_unique'     => 'This %s already exists.'
			)
		);
		$this->form_validation->set_rules('dt[password]', '<strong>Pasword</strong>', 'required|min_length[6]|callback_password_check');
		$this->form_validation->set_rules('password_confirmation_field', 'Password Confirmation Field', 'required|matches[dt[password]]');

		$this->form_validation->set_rules('dt[name]', '<strong>Name</strong>', 'required');

		$this->form_validation->set_rules('dt[role_id]', '<strong>Role</strong>', 'required');
		// $this->form_validation->set_rules('dt[desc]', '<strong>Description</strong>', 'required');


		if ($this->form_validation->run() == FALSE) {
			$error =  validation_errors();
			$this->alert->alertdanger($error);
		} else {
			$dt = $_POST['dt'];

			// update data komite untuk role rapat komite dan cek data untuk komite
			if (($dt['role_id'] == "25") || ($dt['role_id'] == "26")) {

				if (@sizeof($_POST['komite_id']) > 0) {
					
					$komite_str = implode(",", $_POST['komite_id']);
					$dt['komite_id'] = $komite_str;

				}else{
					$this->alert->alertdanger("Komite Wajib Dipilih.");
					exit();
				}
			}else{
				$dt['komite_id'] = NULL;
			}

			$role = $this->mmodel->selectWhere('role', ['id' => $dt['role_id']])->row();
			$dt['role_slug'] = $role->slug;
			$dt['role_name'] = $role->role;
			$dt['password'] = md5($dt['password']);
			$dt['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('user', $dt);
			$last_id = $this->db->insert_id();
			if (!empty($_FILES['file']['name'])) {
				$dir  = "webfile/";
				$config['upload_path']          = $dir;
				$config['allowed_types']        = '*';
				$config['file_name']           = md5('smartsoftstudio') . rand(1000, 100000);

				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('file')) {
					$error = $this->upload->display_errors();
					$this->alert->alertdanger($error);
				} else {
					$file = $this->upload->data();
					$data = array(
						'id' => '',
						'name' => $file['file_name'],
						'mime' => $file['file_type'],
						'dir' => $dir . $file['file_name'],
						'table' => 'user',
						'table_id' => $last_id,
						'status' => 'ENABLE',
						'created_at' => date('Y-m-d H:i:s')
					);
					$str = $this->db->insert('file', $data);
					$this->alert->alertsuccess('Success Send Data');
				}
			} else {
				$data = array(
					'id' => '',
					'name' => '',
					'mime' => '',
					'dir' => '',
					'table' => 'user',
					'table_id' => $last_id,
					'status' => 'ENABLE',
					'created_at' => date('Y-m-d H:i:s')
				);

				$str = $this->db->insert('file', $data);
				$this->alert->alertsuccess('Success Send Data');
			}
		}
	}

	public function edit($id)
	{
		$data['user'] = $this->mymodel->selectDataone('user', array('id' => $id));
		$data['file'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'user'));

		$this->load->view('master/user/user-edit', $data);
	}

	public function editUser($id)
	{
		$id = $this->template->sonDecode($id);
		$data['user_data'] = $this->mymodel->selectDataone('user', array('id' => $id));
		$data['file'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'user'));
		$data['page_name'] = 'master';
		$data['id'] = $id;

		$this->template->load('template/template', 'master/user/edit-user', $data);
	}

	public function updateUser()
	{
		$param = $this->input->post();
		$id = $param['ids'];

		$dataup = array(
			'name' => $param['name'],
			'email' => $param['email'],
			'desc' => $param['desc'],
			'departemen' => $param['departemen'],
			'jabatan' => $param['jabatan']
		);

		if ($_FILES['file']['name'] != '') {
			$dir  = "webfile/";
			$config['upload_path']          = $dir;
			$config['allowed_types']        = '*';
			$config['file_name']           = md5('smartsoftstudio') . rand(1000, 100000);

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('file')) {
				$error = $this->upload->display_errors();
				// $this->alert->alertdanger($error);		
			} else {
				$file = $this->upload->data();
				$data = array(
					'name' => $file['file_name'],
					'mime' => $file['file_type'],
					// 'size'=> $file['file_size'],
					'dir' => $dir . $file['file_name'],
					'table' => 'user',
					'table_id' => $id,
					'updated_at' => date('Y-m-d H:i:s')
				);
				$file = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'user'));
				@unlink($file['dir']);
				if ($file == "") {
					$this->mymodel->insertData('file', $data);
				} else {
					$this->mymodel->updateData('file', $data, array('id' => $file['id']));
				}


				$dataup['updated_at'] = date("Y-m-d H:i:s");
				$this->mymodel->updateData('user', $dataup, array('id' => $id));

				$this->alert->alertsuccess('Success Update Data');
				// redirect('master/user/editUser/'.$id,'refresh');
			}
		} else {

			$dataup['updated_at'] = date("Y-m-d H:i:s");
			$this->mymodel->updateData('user', $dataup, array('id' => $id));
			$this->alert->alertsuccess('Success Update Data');

			// redirect('master/user/editUser/'.$id,'refresh');
		}
	}

	public function update()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$username = $_POST['dt']['username'];
		$email = $_POST['dt']['email'];
		$password = $this->input->post('password');

		$username1 = $this->input->post('username');
		if ($username != $username1) {
			$this->form_validation->set_rules(
				'dt[username]',
				'<strong>username</strong>',
				'required|is_unique[user.username]',
				array(
					'required'      => 'You have not provided %s.',
					'is_unique'     => 'This %s already exists.'
				)
			);
		}

		$email1 = $this->input->post('email');
		if ($email != $email1) {
			$this->form_validation->set_rules(
				'dt[email]',
				'<strong>email</strong>',
				'required|is_unique[user.email]',
				array(
					'required'      => 'You have not provided %s.',
					'is_unique'     => 'This %s already exists.'
				)
			);
		}


		if ($password != "") {
			// $dt['password'] = md5($password);
			// $this->form_validation->set_rules('dt[password]', '<strong>Pasword</strong>', 'required');
			$this->form_validation->set_rules('password', '<strong>Pasword</strong>', 'required|min_length[6]|callback_password_check');
			$this->form_validation->set_rules('password_confirmation_field', 'Password Confirmation Field', 'required|matches[password]');
		}


		$this->form_validation->set_rules('dt[name]', '<strong>Name</strong>', 'required');
		$this->form_validation->set_rules('dt[role_id]', '<strong>Role</strong>', 'required');
		// $this->form_validation->set_rules('dt[desc]', '<strong>Description</strong>', 'required');


		if ($this->form_validation->run() == FALSE) {
			$error =  validation_errors();
			$this->alert->alertdanger($error);
		} else {
			$dt = $this->input->post('dt');
			$id = $this->input->post('ids');

			if ($password != "") {
				$dt['password'] = md5($password);
			}

			// Cek komite
			if (($dt['role_id'] == "25") || ($dt['role_id'] == "26")) {
				if (@sizeof($_POST['komite_id']) > 0) {
					
					$komite_str = implode(",", $_POST['komite_id']);
					$dt['komite_id'] = $komite_str;

				}else{
					$this->alert->alertdanger("Komite Wajib Dipilih.");
					exit();
				}
			}else{
				$dt['komite_id'] = NULL;
			}

			// $dt['updated_at'] = date('Y-m-d H:i:s');
			// $this->mymodel->updateData('user',$dt,array('id'=>$ids));
			// $this->alert->alertsuccess('Success Send Data');
			if (!empty($_FILES['file']['name'])) {
				$dir  = "webfile/";
				$config['upload_path']          = $dir;
				$config['allowed_types']        = '*';
				$config['file_name']           = md5('smartsoftstudio') . rand(1000, 100000);
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('file')) {
					$error = $this->upload->display_errors();
					$this->alert->alertdanger($error);
				} else {
					$file = $this->upload->data();
					$data = array(
						'name' => $file['file_name'],
						'mime' => $file['file_type'],
						// 'size'=> $file['file_size'],
						'dir' => $dir . $file['file_name'],
						'table' => 'user',
						'table_id' => $id,
						'updated_at' => date('Y-m-d H:i:s')
					);
					$file = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'user'));
					@unlink($file['dir']);
					if ($file == "") {
						$this->mymodel->insertData('file', $data);
					} else {
						$this->mymodel->updateData('file', $data, array('id' => $file['id']));
					}


					$dt['updated_at'] = date("Y-m-d H:i:s");
					$role = $this->mmodel->selectWhere('role', ['id' => $dt['role_id']])->row();
					$dt['role_slug'] = $role->slug;
					$dt['role_name'] = $role->role;
					$this->mymodel->updateData('user', $dt, array('id' => $id));

					$this->alert->alertsuccess('Success Update Data');
				}
			} else {
				$dt = $_POST['dt'];
				if ($password != "") {
					$dt['password'] = md5($password);
				}
				$role = $this->mmodel->selectWhere('role', ['id' => $dt['role_id']])->row();
				$dt['role_slug'] = $role->slug;
				$dt['role_name'] = $role->role;
				$dt['updated_at'] = date("Y-m-d H:i:s");
				// print_r($dt);
				$this->mymodel->updateData('user', $dt, array('id' => $id));
				$this->alert->alertsuccess('Success Update Data');
			}
		}
	}

	public function delete($id)
	{
		// $this->mymodel->updateData('user',array('status'=>1),array('id'=>$id));

		// cek role rapat komite
		$user_data = $this->mymodel->selectDataone('user', ['id' => $id]);
		if (($user_data['role_id'] == "25") || ($user_data['role_id'] == "26")) {
			$this->mymodel->updateData('master_komite', ['is_user' => 0], ['mk_id' => $user_data['komite_id']]);
		}

		$file = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'user'));
		@unlink($file['dir']);

		$this->mymodel->deleteData('user', array('id' => $id));
		$this->mymodel->deleteData('file', array('table_id' => $id, 'table' => 'user'));

		$this->session->set_flashdata('message', 'Success Delete Data');
		$this->session->set_flashdata('class', 'success');

		redirect('master/user');
	}

	public function password_check($str)
	{
		$this->form_validation->set_message('password_check', "password must combine alphabet and numeric");
		$message = FALSE;
		if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
			$message = TRUE;
		}
		return $message;
	}


	public function editUser_redirect($id)
	{
		$id = $this->template->sonEncode($id);
		redirect('master/user/editUser/' . $id);
	}

	public function activateUser()
	{
		$user_id = $this->input->post('id');
		$data_update = [
			'is_login' => 1,
			'updated_at' => date('Y-m-d H:i:s')
		];

		$this->db->where('id', $user_id);
		$update = $this->db->update('user', $data_update);
		if ($update) {
			echo 'success';
		} else {
			echo 'failed';
		}
	}

	public function resetPassword()
	{
		$id = $this->input->post('id');
		$new_password = $this->input->post('new_password');
		$confirm_password = $this->input->post('confirm_password');
		if ($new_password == $confirm_password) {
			$data_update = [
				'password' => md5($new_password)
			];
			$this->db->where('id', $id);
			$update = $this->db->update('user', $data_update);
			if ($update) {
				$json_result = [
					'status' => 'success',
					'message' => 'Success to reset password'
				];
			} else {
				$json_result = [
					'status' => 'error',
					'message' => 'Failed to reset password.'
				];
			}
		} else {
			$json_result = [
				'status' => 'error',
				'message' => 'Password mismatch.'
			];
		}

		echo json_encode($json_result);
	}

	public function selectKomite()
	{
		$role = $this->input->post('role');
		$get_komite = $this->mymodel->selectWhere('master_komite', ['mk_role_id' => $role]);
		$response = array();
		foreach ($get_komite as $key) {
			$response[] = array(
				'komite' => $key['mk_nama'],
				'id' => $key['mk_id']
			);
		}
		echo json_encode($response);
	}
}
