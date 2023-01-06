<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_posisi extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "m_posisi";
		$this->template->load('template/template', 'master/m_posisi/all-m_posisi', $data);
	}

	public function create()
	{
		$this->load->view('master/m_posisi/add-m_posisi');
	}
	public function validate()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('dt[mp_nama]', '<strong>Mp Nama</strong>', 'required');
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
			$str = $this->mymodel->insertData('m_posisi', $dt);

			echo 'success';
		}
	}

	public function json()
	{
		$status = $_GET['status'];
		if ($status == '') $status = 'ENABLE';

		header('Content-Type: application/json');
		$this->datatables->select('
				m_posisi.mp_id,
				m_posisi.mp_nama,
				m_posisi.status,
				(SELECT COUNT(mpj_id) as jumlah_jabatan FROM m_posisi_jabatan WHERE m_posisi_jabatan.mpj_mp_id = m_posisi.mp_id) as jumlah_jabatan');
		$this->datatables->where('m_posisi.status', $status);
		$this->datatables->from('m_posisi');
		if ($status == "ENABLE") {
			$this->datatables->add_column('view', '<div class="btn-group">
				<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
				<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
			</div>', 'mp_id');
		} else {
			$this->datatables->add_column('view', '<div class="btn-group">
				<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
				<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
			</div>', 'mp_id');
		}
		echo $this->datatables->generate();
	}

	public function edit($id)
	{
		$data['m_posisi'] = $this->mymodel->selectDataone('m_posisi', array('mp_id' => $id));
		$data['page_name'] = "m_posisi";
		$this->load->view('master/m_posisi/edit-m_posisi', $data);
	}

	public function update()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->validate();

		if ($this->form_validation->run() == FALSE) {
			echo validation_errors();
		} else {
			$id = $this->input->post('mp_id', TRUE);
			$dt = $this->input->post('dt');
			$dt['updated_at'] = date("Y-m-d H:i:s");
			$str = $this->mymodel->updateData('m_posisi', $dt, array('mp_id' => $id));
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
		$str = $this->mymodel->deleteData('m_posisi', array('mp_id' => $id));
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
			$this->db->where_in('mp_id', $id);
			$this->db->delete('m_posisi', []);
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
		$this->mymodel->updateData('m_posisi', array('status' => $status), array('mp_id' => $id));
		redirect('master/M_posisi');
	}
}
