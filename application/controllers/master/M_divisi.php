<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_divisi extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "m_divisi";
		$this->template->load('template/template', 'master/m_divisi/all-m_divisi', $data);
	}

	public function create()
	{
		$this->load->view('master/m_divisi/add-m_divisi');
	}
	public function validate()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('dt[md_nama]', '<strong>Nama Divisi</strong>', 'required');
		$this->form_validation->set_rules('dt[md_nama]', '<strong>Nama Singkatan</strong>', 'required');
	}

	public function store()
	{
		$this->validate();
		if ($this->form_validation->run() == FALSE) {
			echo validation_errors();
		} else {
			$dt = $this->input->post('dt');
			$dt['created_at'] = date('Y-m-d H:i:s');
			$dt['created_by'] = $this->session->userdata('id');
			$dt['status'] = "ENABLE";
			$str = $this->mymodel->insertData('m_divisi', $dt);

			echo 'success';
		}
	}

	public function json()
	{
		$status = $_GET['status'];
		if ($status == '') $status = 'ENABLE';

		header('Content-Type: application/json');
		$this->datatables->select('m_divisi.md_id,m_divisi.md_nama,m_divisi.md_singkatan,status');
		$this->datatables->where('m_divisi.status', $status);
		$this->datatables->from('m_divisi');
		if ($status == "ENABLE") {
			$this->datatables->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
																	<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
															</div>', 'md_id');
		} else {
			$this->datatables->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
																	<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
															</div>', 'md_id');
		}
		echo $this->datatables->generate();
	}

	public function edit($id)
	{
		$data['m_divisi'] = $this->mymodel->selectDataone('m_divisi', array('md_id' => $id));
		$data['page_name'] = "m_divisi";
		$this->load->view('master/m_divisi/edit-m_divisi', $data);
	}

	public function update()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->validate();

		if ($this->form_validation->run() == FALSE) {
			echo validation_errors();
		} else {
			$id = $this->input->post('md_id', TRUE);
			$dt = $this->input->post('dt');
			$dt['updated_at'] = date("Y-m-d H:i:s");
			$str = $this->mymodel->updateData('m_divisi', $dt, array('md_id' => $id));
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
		$str = $this->mymodel->deleteData('m_divisi', array('md_id' => $id));
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
			$this->db->where_in('md_id', $id);
			$str = $this->db->delete('m_divisi', []);
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
		$this->mymodel->updateData('m_divisi', array('status' => $status), array('md_id' => $id));
		redirect('master/M_divisi');
	}
}
