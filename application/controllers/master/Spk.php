<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Spk extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_name'] = "spk";
        $this->template->load('template/template', 'master/spk/all-spk', $data);
    }


    public function pdfprint($id)
    {
        $data['spk'] = $this->mymodel->selectDataone('spk', array('id' => $id));
        $data['file'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'spk'));
        $data['page_name'] = "spk";
        $this->load->view('master/spk/print-spk', $data);
    }

    public function printtopdf($id)
    {

        $this->load->library('pdf');
        $files = 'SPK';
        $html = file_get_contents(base_url('master/spk/pdfprint/' . $id));
        $this->pdf->toPdf2($files, $html);
    }


    public function create()
    {
        $data['page_name'] = "spk";
        $this->template->load('template/template', 'master/spk/add-spk', $data);
    }

    public function edit($id)
    {
        $data['spk'] = $this->mymodel->selectDataone('spk', array('id' => $id));
        $data['file'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'spk'));
        $data['page_name'] = "spk";
        $this->template->load('template/template', 'master/spk/edit-spk', $data);
    }



    public function validate()
    {
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->form_validation->set_rules('dt[nomor_spk]', '<strong>NOMOR SPK	</strong>', 'required');
        $this->form_validation->set_rules('dt[tanggal_spk]', '<strong>TANGGAL SPK	</strong>', 'required');
        $this->form_validation->set_rules('dt[nama_perusahaan]', '<strong>NAMA PERUSAHAAN	</strong>', 'required');
        $this->form_validation->set_rules('dt[alamat_perusahaan]', '<strong>ALAMAT PERUSAHAAN	</strong>', 'required');
        $this->form_validation->set_rules('dt[telp_facsimile]', '<strong>NO. TELP / FACSIMILE	 </strong>', 'required');
        $this->form_validation->set_rules('dt[surat_penawaran]', '<strong>SURAT PENAWARAN	</strong>', 'required');
        $this->form_validation->set_rules('dt[tanggal_surat_penawaran]', '<strong> TGL SURAT PENAWARAN	</strong>', 'required');
        $this->form_validation->set_rules('dt[jenis_pekerjaan]', '<strong>JENIS PEKERJAAN	</strong>', 'required');
        // $this->form_validation->set_rules('dt[ruang_lingkup_pekerjaan]', '<strong>JENIS PEKERJAAN	</strong>', 'required');
        $this->form_validation->set_rules('dt[harga]', '<strong>HARGA	</strong>', 'required');
        $this->form_validation->set_rules('dt[total_harga_terbilang]', '<strong>TOTAL HARGA TERBILANG	</strong>', 'required');
        $this->form_validation->set_rules('dt[catatan_imbalan_jasa]', '<strong>CATATAN IMBALAN JASA	</strong>', 'required');
        $this->form_validation->set_rules('dt[jangka_waktu]', '<strong>JANGKA WAKTU & DELIVERABLES		</strong>', 'required');
        $this->form_validation->set_rules('dt[cara_pembayaran]', '<strong>CARA PEMBAYARAN		</strong>', 'required');
        $this->form_validation->set_rules('dt[lain_lain]', '<strong>LAIN - LAIN	</strong>', 'required');
        $this->form_validation->set_rules('dt[pic_penerima_kerja]', '<strong>PIC PENERIMA KERJA	</strong>', 'required');
        $this->form_validation->set_rules('dt[jabatan_penerima_kerja]', '<strong>JABATAN PENERIMA KERJA		</strong>', 'required');
        $this->form_validation->set_rules('dt[pic_pemberi_kerja]', '<strong>PIC PEMBERI KERJA	</strong>', 'required');
        $this->form_validation->set_rules('dt[jabatan_pemberi_kerja]', '<strong>JABATAN PEMBERI KERJA	</strong>', 'required');
    }

    public function json()
    {
        $param = $this->input->post();

        header('Content-Type: application/json');

        $this->datatables->select('spk.id,spk.nomor_spk,spk.tanggal_spk,spk.nama_perusahaan,spk.surat_penawaran,spk.status,spk.jenis_pekerjaan');
        // $this->datatables->where('spk.status',$status);
        $this->datatables->from('spk');
        if ($param['tanggal']) {
            $this->datatables->where('tanggal_spk', $param['tanggal']);
        }
        // if($status=="ENABLE"){

        //  	}else{
        // $this->datatables->add_column('view', '<div class="btn-group">
        // 													<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
        // 													<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
        // 											</div>', 'id');
        //  	}

        if ($this->session->userdata('role_slug') == 'kepala_divisi') {
            $this->datatables->add_column('view', '', 'id');
        } else {
            $this->datatables->add_column('view', '<div class="btn-group">
                        <button style="font-size:14px" type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
                        <button style="font-size:14px" type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
                </div>', 'id');
        }

        echo $this->datatables->generate();
    }


    public function store()
    {
        $post = $this->input->post();
        $data = $post['dt'];
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->validate();
        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {
            // $this->db->select('COUNT(0) as jml');
            // $number = $this->mymodel->selectDataone('spk',['MONTH(created_at)'=>date('m'),'YEAR(created_at)'=>date('Y')])['jml'];
            // $numberspk = sprintf("%'03d", $number+1);
            // $data['nomor_spk'] = str_replace('XX',$numberspk,$data['nomor_spk']);

            // ================================================================
            $dir = 'webfile/spk/' . str_replace('/', '_', $data['nomor_spk']);
            if (!is_dir($dir)) {
                mkdir('./' . $dir, 0777, TRUE);
            }
            $config['upload_path']          = $dir;
            $config['allowed_types']        = '*';
            $config['encrypt_name']         = true;
            $this->load->library('upload', $config);
            $jumlah_files = count($_FILES['files']['name']);
            for ($i = 0; $i < $jumlah_files; $i++) {
                if (!empty($_FILES['files']['name'][$i])) {
                    $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $dataimg[] = $uploadData['file_name'];
                    }
                }
            }
            if ($dataimg) {
                $data['file_attachment'] = json_encode($dataimg);
            }
            if ($_FILES['file_spk']) {
                if ($this->upload->do_upload('file_spk')) {
                    $uploadDataspk = $this->upload->data();
                    $data['file_spk'] = $uploadDataspk['file_name'];
                }
            }
            // ================================================================

            $data['created_at'] = date('Y-m-d H:i:s');
            $data['harga'] = str_replace(',', '', $data['harga']);
            $data['created_by'] = $this->session->userdata('id');
            $data['status'] = "";
            $this->mymodel->insertData('spk', $data);
            echo "success";
        }
    }

    public function update()
    {
        $post = $this->input->post();
        $data = $post['dt'];
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->validate();
        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {
            $this->db->select('COUNT(0) as jml');
            // $number = $this->mymodel->selectDataone('spk',['MONTH(created_at)'=>date('m'),'YEAR(created_at)'=>date('Y')])['jml'];

            // $numberspk = sprintf("%'03d", $number+1);

            // $data['nomor_spk'] = str_replace('XX',$numberspk,$data['nomor_spk']);
            // ================================================================
            foreach ($post['nama_files_old'] as $k => $files_old) {
                $dataimg[] = $files_old;
            }
            $dir = 'webfile/spk/' . str_replace('/', '_', $data['nomor_spk']);
            if (!is_dir($dir)) {
                mkdir('./' . $dir, 0777, TRUE);
            }
            $config['upload_path']          = $dir;
            $config['allowed_types']        = '*';
            $config['encrypt_name']         = true;
            $this->load->library('upload', $config);
            $jumlah_files = count($_FILES['files']['name']);
            for ($i = 0; $i < $jumlah_files; $i++) {
                if (!empty($_FILES['files']['name'][$i])) {
                    $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $dataimg[] = $uploadData['file_name'];
                    }
                }
            }
            if ($dataimg) {
                $data['file_attachment'] = json_encode($dataimg);
            }
            if ($_FILES['file_spk']) {
                if ($this->upload->do_upload('file_spk')) {
                    $uploadDataspk = $this->upload->data();
                    $data['file_spk'] = $uploadDataspk['file_name'];
                }
            }
            // ================================================================
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['harga'] = str_replace(',', '', $data['harga']);
            $data['updated_by'] = $this->session->userdata('id');
            $data['status'] = "";
            $this->mymodel->updateData('spk', $data, ['id' => $post['id']]);
            echo "success";
        }
    }


    public function delete()
    {
        $id = $this->input->post('id', TRUE);
        $file = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'spk'));
        @unlink($file['dir']);
        $this->mymodel->deleteData('file',  array('table_id' => $id, 'table' => 'spk'));
        $str = $this->mymodel->deleteData('spk',  array('id' => $id));
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
            $this->db->where_in('id', $id);
            $this->db->delete('spk', []);
            if ($str == true) {
                echo "success";
            } else {
                echo "Something error in system";
            }
        } else {
            echo "success";
        }
    }

    public function exportexcel()
    {
        $data['spk'] = $this->mymodel->selectData('spk');
        $this->load->view('master/spk/export-spk', $data, FALSE);
    }
}
