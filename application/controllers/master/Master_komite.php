<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Master_komite extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "master_komite";
		$this->template->load('template/template', 'master/master_komite/all-master_komite', $data);
	}

	public function create()
	{
		$this->load->view('master/master_komite/add-master_komite');
	}
	public function validate()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('dt[mk_nama]', '<strong>Mk Nama</strong>', 'required');
		$this->form_validation->set_rules('dt[mk_role_id]', '<strong>Mk Role Id</strong>', 'required');
	}

	public function store()
	{
		$this->validate();
		if ($this->form_validation->run() == FALSE) {
			echo validation_errors();
		} else {
			$dt = $this->input->post('dt');
			$role = $this->mymodel->selectDataone('role', ['id' => $dt['mk_role_id']]);
			$dt['mk_role_nama'] = $role['role'];
			$dt['created_at'] = date('Y-m-d H:i:s');
			$dt['created_by'] = $this->session->userdata('id');
			$dt['status'] = "ENABLE";
			$str = $this->mymodel->insertData('master_komite', $dt);

			echo 'success';
		}
	}

	public function json()
	{
		$status = $_GET['status'];
		if ($status == '') $status = 'ENABLE';

		$mk_role_id = $this->input->post('filter_mk_role_id');
		header('Content-Type: application/json');
		$this->datatables->select('master_komite.mk_id,master_komite.mk_nama,master_komite.mk_role_id,master_komite.mk_role_nama,status');
		if ($mk_role_id) {
			$this->datatables->where('master_komite.mk_role_id', $mk_role_id);
		}

		$this->datatables->where('master_komite.status', $status);
		$this->datatables->from('master_komite');
		if ($status == "ENABLE") {
			$this->datatables->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
																	<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
															</div>', 'mk_id');
		} else {
			$this->datatables->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
																	<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
															</div>', 'mk_id');
		}
		echo $this->datatables->generate();
	}

	public function edit($id)
	{
		$data['master_komite'] = $this->mymodel->selectDataone('master_komite', array('mk_id' => $id));
		$data['page_name'] = "master_komite";
		$this->load->view('master/master_komite/edit-master_komite', $data);
	}

	public function update()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->validate();

		if ($this->form_validation->run() == FALSE) {
			echo validation_errors();
		} else {
			$id = $this->input->post('mk_id', TRUE);
			$dt = $this->input->post('dt');
			$role = $this->mymodel->selectDataone('role', ['id' => $dt['mk_role_id']]);
			$dt['mk_role_nama'] = $role['role'];
			$dt['updated_at'] = date("Y-m-d H:i:s");
			$str = $this->mymodel->updateData('master_komite', $dt, array('mk_id' => $id));
			if ($str == true) {
				echo "success";
			} else {
				echo "Something error in system";
			}
		}
	}

	public function delete()
	{
		$id = $this->input->post('id', TRUE);
		$str = $this->mymodel->deleteData('master_komite', array('mk_id' => $id));
		if ($str == true) {
			echo "success";
		} else {
			echo "Something error in system";
		}
	}

	public function deleteData()
	{
		$data = $this->input->post('data');
		if ($data != "") {
			$id = explode(',', $data);
			$this->db->where_in('mk_id', $id);
			$str = $this->db->delete('master_komite', []);
			if ($str == true) {
				echo "success";
			} else {
				echo "Something error in system";
			}
		} else {
			echo "success";
		}
	}

	public function status($id, $status)
	{
		$this->mymodel->updateData('master_komite', array('status' => $status), array('mk_id' => $id));
		redirect('master/Master_komite');
	}
}
