<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_posisi_jabatan extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "m_posisi_jabatan";
		$this->template->load('template/template', 'master/m_posisi_jabatan/all-m_posisi_jabatan', $data);
	}

	public function create()
	{
		$this->load->view('master/m_posisi_jabatan/add-m_posisi_jabatan');
	}
	public function validate()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('dt[mpj_mp_id]', '<strong>Posisi</strong>', 'required');
		$this->form_validation->set_rules('dt[mpj_nama]', '<strong>Nama Jabatan</strong>', 'required');
		$this->form_validation->set_rules('dt[mpj_singkatan]', '<strong>Nama Singkatan</strong>', 'required');
	}

	public function store()
	{
		$this->validate();
		if ($this->form_validation->run() == FALSE) {
			echo validation_errors();
		} else {
			$dt = $this->input->post('dt');

			//upload tanda tangan
            if (!empty($_FILES['file_ttd']['name'])){
                $dir  = "./webfile/ttd_sevp_direksi/";
                $config['upload_path'] = $dir;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['file_name'] = md5('smartsoftstudio').rand(1000, 100000);

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file_ttd')) {
                    $file = $this->upload->data();
                }

				$file_ext = pathinfo($_FILES['file_ttd']['name'], PATHINFO_EXTENSION);

				$file_name = $config['file_name'] . '.' . $file_ext;
            } else {
				$file_name = null;
			}

			$dt['mpj_ttd'] = $file_name;
			$dt['created_at'] = date('Y-m-d H:i:s');
			$dt['created_by'] = $this->session->userdata('id');
			$dt['status'] = "ENABLE";
			$str = $this->mymodel->insertData('m_posisi_jabatan', $dt);

			echo 'success';
		}
	}

	public function json()
	{
		$status = $_GET['status'];
		if ($status == '') $status = 'ENABLE';

		$mpj_mp_id = $this->input->post('filter_mpj_mp_id');
		header('Content-Type: application/json');
		$this->datatables->select('m_posisi_jabatan.mpj_id,m_posisi_jabatan.mpj_mp_id,m_posisi_jabatan.mpj_nama,m_posisi_jabatan.status,m_posisi.mp_nama,m_posisi_jabatan.mpj_singkatan');
		if ($mpj_mp_id) {
			$this->datatables->where('m_posisi_jabatan.mpj_mp_id', $mpj_mp_id);
		}
		$this->datatables->join('m_posisi', 'm_posisi.mp_id=m_posisi_jabatan.mpj_mp_id');
		$this->datatables->where('m_posisi_jabatan.status', $status);
		$this->datatables->from('m_posisi_jabatan');
		if ($status == "ENABLE") {
			$this->datatables->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
																	<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
															</div>', 'mpj_id');
		} else {
			$this->datatables->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
																	<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
															</div>', 'mpj_id');
		}
		echo $this->datatables->generate();
	}

	public function edit($id)
	{
		$data['m_posisi_jabatan'] = $this->mymodel->selectDataone('m_posisi_jabatan', array('mpj_id' => $id));
		$data['page_name'] = "m_posisi_jabatan";
		$this->load->view('master/m_posisi_jabatan/edit-m_posisi_jabatan', $data);
	}

	public function update()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->validate();

		if ($this->form_validation->run() == FALSE) {
			echo validation_errors();
		} else {
			$id = $this->input->post('mpj_id', TRUE);
			$dt = $this->input->post('dt');

			//upload tanda tangan
            if (!empty($_FILES['file_ttd']['name'])){
                $dir  = "./webfile/ttd_sevp_direksi/";

				//hapus file sebelumnya
				$data_m_posisi_jabatan = $this->mymodel->selectDataone('m_posisi_jabatan', array('mpj_id' => $id));
				unlink($dir.$data_m_posisi_jabatan['mpj_ttd']);

				//upload file
                $config['upload_path'] = $dir;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['file_name'] = md5('smartsoftstudio').rand(1000, 100000);

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file_ttd')) {
                    $file = $this->upload->data();
                }
				
				$file_ext = pathinfo($_FILES['file_ttd']['name'], PATHINFO_EXTENSION);

				$file_name = $config['file_name'] . '.' . $file_ext;
            } else {
				$file_name = null;
			}

			$dt['mpj_ttd'] = $file_name;
			$dt['updated_at'] = date("Y-m-d H:i:s");
			$str = $this->mymodel->updateData('m_posisi_jabatan', $dt, array('mpj_id' => $id));
			if ($str == true) {
				echo "success";
			} else {
				echo "Something error in system";
			}
		}
	}

	public function delete()
	{
		$id = $this->input->post('mpj_id', TRUE);
		$str = $this->mymodel->deleteData('m_posisi_jabatan', array('mpj_id' => $id));
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
			$this->db->where_in('mpj_id', $id);
			$str = $this->db->delete('m_posisi_jabatan', []);
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
		$this->mymodel->updateData('m_posisi_jabatan', array('status' => $status), array('mpj_id' => $id));
		redirect('master/M_posisi_jabatan');
	}

	public function download_ttd($nama_file) {
		$this->load->helper('download');
		force_download('./webfile/ttd_sevp_direksi/'.$nama_file, NULL);
	}
}
