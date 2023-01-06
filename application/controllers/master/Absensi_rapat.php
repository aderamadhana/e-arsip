<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Library untuk PHP Presentation
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\Writer\PowerPoint2007;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Slide\Background\Image;
use PhpOffice\PhpPresentation\DocumentLayout;
use PhpOffice\PhpPresentation\Style\Border;
use PhpOffice\PhpPresentation\Shape\Drawing;

// Library untuk PHP Spreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Absensi_rapat extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['tipe_rapat'] = $this->input->get('tipe_rapat');
        if ($data['tipe_rapat'] == "rapat_direksi") {
            $data['page_name'] = "ABSENSI RAPAT DIREKSI";
        } else if ($data['tipe_rapat'] == "komite_direksi") {
            $data['page_name'] = "ABSENSI RAPAT KOMITE DIREKSI";
        } else if ($data['tipe_rapat'] == "komite_komisaris") {
            $data['page_name'] = "ABSENSI RAPAT KOMITE KOMISARIS";
        } else {
            $data['page_name'] = "ABSENSI RAPAT GABUNGAN";
        }

        $this->template->load('template/template', 'master/absensi_rapat/all-absensi_rapat', $data);
    }

    public function json_absensi()
    {
        $tipe_rapat = $this->input->post('tipe_rapat');
        header('Content-Type: application/json');
        $this->datatables->select('
				absensi_rapat.ar_id,
				absensi_rapat.ar_tanggal,
				(SELECT GROUP_CONCAT(absensi_rapat_agenda.ara_nama SEPARATOR ";") AS agenda_rapat FROM `absensi_rapat_agenda` WHERE absensi_rapat_agenda.ara_ar_id = absensi_rapat.ar_id) as agenda_rapat,
                ar_mk_nama,
                (SELECT GROUP_CONCAT(absensi_rapat_agenda.ara_singkatan_divisi_materi SEPARATOR ";") AS divisi_pemateri FROM `absensi_rapat_agenda` WHERE absensi_rapat_agenda.ara_ar_id = absensi_rapat.ar_id) as divisi_pemateri');
        $this->datatables->from('absensi_rapat');
        $this->datatables->where('ar_tipe_rapat', $tipe_rapat);
        /*if (($this->session->userdata('role_id') == '25') || ($this->session->userdata('role_id') == '26')) {
            $this->datatables->where('created_by', $this->session->userdata('id'));
        }*/
        if (@$this->session->userdata('komite_id') != '') {
            $this->datatables->where_in('ar_mk_id', $this->session->userdata('komite_id'));
        }

        if ($this->session->userdata('role_slug') == 'kepala_divisi') {
            $this->datatables->add_column('view', '<div class="btn-group">
                <button style="font-size:14px" type="button" class="btn btn-sm btn-info" onclick="detail($1)"><i class="fa fa-info"></i> Detail</button>
            </div>', 'ar_id');
        } else {
            $this->datatables->add_column('view', '<div class="btn-group">
                <button style="font-size:14px" type="button" class="btn btn-sm btn-info" onclick="detail($1)"><i class="fa fa-info"></i> Detail</button>		
                <button style="font-size:14px" type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button>
                <button style="font-size:14px" type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
            </div>', 'ar_id');
        }

        echo $this->datatables->generate();
    }

    public function create_agenda()
    {
        $data['tipe_rapat'] = $this->input->get('tipe_rapat');
        $data['page_name'] = "Tambah Agenda Rapat";
        $this->template->load('template/template', 'master/absensi_rapat/create-absensi_rapat', $data);
    }

    public function store_agenda()
    {
        $dt = $this->input->post('dt');

        $ar_input = array();
        $ar_input['ar_tipe_rapat'] = $dt['ar_tipe_rapat'];
        $ar_input['ar_tanggal'] = $dt['ar_tanggal'];
        $ar_input['ar_lokasi'] = $dt['ar_lokasi'];
        $ar_input['ar_mk_id'] = $dt['ar_mk_id'];

        if (@$dt['ar_mk_id'] != '') {
            $this->db->select('mk_nama');
            $m_komite = $this->mymodel->selectDataone('master_komite', ['mk_id' => $dt['ar_mk_id']]);
            $ar_input['ar_mk_nama'] = $m_komite['mk_nama'];
        }

        if ($dt['ar_tipe_rapat'] == "komite_direksi") {
            $sub_komite = $dt['sub_komite'];
            $array_sub = array();
            foreach ($sub_komite as $key => $val) {
                $array_sub[] = $val;
            }
            $ar_input['ar_sub_komite'] = json_encode($array_sub);
        }

        if ($dt['ar_lokasi'] == "Lainnya") {
            $ar_input['ar_lokasi_lainnya'] = $dt['ar_lokasi_lainnya'];
        }

        $ar_input['ar_jumlah'] = $dt['ar_jumlah'];
        $ar_input['created_at'] = date("Y-m-d H:i:s");
        $ar_input['created_by'] = $this->session->userdata('id');
        $this->mymodel->insertData('absensi_rapat', $ar_input);
        $last_id = $this->db->insert_id();

        foreach ($dt['agenda'] as $key => $value) {
            $agenda_rapat = $dt['agenda'][$key];
            $jam_mulai = $dt['mulai'][$key];
            $jam_selesai = $dt['selesai'][$key];

            // Handle Pemateri Data
            $pemateri_id = $dt['pemateri'][$key];
            if (strpos($pemateri_id, ",")) {
                // Multiple data
                $explode_pemateri = explode(",", $pemateri_id);
                $nama_pemateri = array();
                $singkatan_pemateri = array();
                foreach ($explode_pemateri as $mat => $val_mat) {
                    $detail_pemateri = $this->mymodel->selectDataone('m_divisi', ['md_id' => $val_mat]);
                    $nama_pemateri[] = $detail_pemateri['md_nama'];
                    $singkatan_pemateri[] = $detail_pemateri['md_singkatan'];
                }
                $value_id_pemateri = json_encode($explode_pemateri);
                $value_nama_pemateri = json_encode($nama_pemateri);
                $value_singkatan_pemateri = json_encode($singkatan_pemateri);
            } else {
                // Single Data
                $detail_pemateri = $this->mymodel->selectDataone('m_divisi', ['md_id' => $pemateri_id]);
                $value_id_pemateri = json_encode(array($pemateri_id));
                $value_nama_pemateri = json_encode(array($detail_pemateri['md_nama']));
                $value_singkatan_pemateri = json_encode(array($detail_pemateri['md_singkatan']));
            }

            // Handle Pendamping Data
            $pendamping_id = $dt['pendamping'][$key];
            if (strpos($pendamping_id, ",")) {
                // Multiple data
                $explode_pendamping = explode(",", $pendamping_id);
                $nama_pendamping = array();
                $singkatan_pendamping = array();
                foreach ($explode_pendamping as $pdm => $val_pdm) {
                    $detail_pendamping = $this->mymodel->selectDataone('m_divisi', ['md_id' => $val_pdm]);
                    $nama_pendamping[] = $detail_pendamping['md_nama'];
                    $singkatan_pendamping[] = $detail_pendamping['md_singkatan'];
                }
                $value_id_pendamping = json_encode($explode_pendamping);
                $value_nama_pendamping = json_encode($nama_pendamping);
                $value_singkatan_pendamping = json_encode($singkatan_pendamping);
            } else {
                // Single Data
                $detail_pendamping = $this->mymodel->selectDataone('m_divisi', ['md_id' => $pendamping_id]);
                $value_id_pendamping = json_encode(array($pendamping_id));
                $value_nama_pendamping = json_encode(array($detail_pendamping['md_nama']));
                $value_singkatan_pendamping = json_encode(array($detail_pendamping['md_singkatan']));
            }

            $ara_input = array(
                'ara_ar_id' => $last_id,
                'ara_nama' => $agenda_rapat,
                'ara_mulai' => $jam_mulai,
                'ara_selesai' => $jam_selesai,
                'ara_id_divisi_materi' => $value_id_pemateri,
                'ara_nama_divisi_materi' => $value_nama_pemateri,
                'ara_singkatan_divisi_materi' => $value_singkatan_pemateri,
                'ara_id_divisi_pendamping' => $value_id_pendamping,
                'ara_nama_divisi_pendamping' => $value_nama_pendamping,
                'ara_singkatan_divisi_pendamping' => $value_singkatan_pendamping,
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $this->session->userdata('id')
            );
            $this->mymodel->insertData('absensi_rapat_agenda', $ara_input);
        }

        // Create QR Absensi Rapat
        $link = base_url('form-absensi/kehadiran/' . $this->template->sonEncode($last_id));
        $logo = 'http://digitalcorsec.id/assets/logo_bri_new2.png';
        $content = file_get_contents('http://dev.alfahuma.tech/generate_qrcode.php?qr_content=' . $link . '&qr_logo=' . $logo);
        file_put_contents('webfile/qr_absensi_rapat/qrcode-' . $last_id . '.jpg', $content);

        echo "success";
    }

    public function detail_agenda($ar_id)
    {
        $data['tipe_rapat'] = $this->input->get('tipe_rapat');
        $data['page_name'] = "Detail Agenda Rapat";
        $data['absensi_rapat'] = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id]);
        $data['absensi_rapat_agenda'] = $this->mymodel->selectWhere('absensi_rapat_agenda', ['ara_ar_id' => $ar_id]);
        $this->template->load('template/template', 'master/absensi_rapat/detail-absensi_rapat', $data);
    }

    public function edit_agenda($ar_id)
    {
        $data['tipe_rapat'] = $this->input->get('tipe_rapat');
        $data['page_name'] = "Edit Agenda Rapat";
        $data['absensi_rapat'] = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id]);
        $data['absensi_rapat_agenda'] = $this->mymodel->selectWhere('absensi_rapat_agenda', ['ara_ar_id' => $ar_id]);
        $this->template->load('template/template', 'master/absensi_rapat/edit-absensi_rapat', $data);
    }

    public function update_agenda()
    {
        $dt = $this->input->post('dt');
        $ar_id = $dt['ar_id'];

        $ar_update = array();
        $ar_update['ar_tanggal'] = $dt['ar_tanggal'];
        $ar_update['ar_lokasi'] = $dt['ar_lokasi'];

        $ar_update['ar_mk_id'] = $dt['ar_mk_id'];

        if (@$dt['ar_mk_id'] != '') {
            $this->db->select('mk_nama');
            $m_komite = $this->mymodel->selectDataone('master_komite', ['mk_id' => $dt['ar_mk_id']]);
            $ar_update['ar_mk_nama'] = $m_komite['mk_nama'];
        }

        if ($this->input->post('tipe_rapat') == "komite_direksi") {
            $sub_komite = $dt['sub_komite'];
            $array_sub = array();
            foreach ($sub_komite as $key => $val) {
                $array_sub[] = $val;
            }
            $ar_update['ar_sub_komite'] = json_encode($array_sub);
        }

        if ($dt['ar_lokasi'] == "Lainnya") {
            $ar_update['ar_lokasi_lainnya'] = $dt['ar_lokasi_lainnya'];
        }

        $ar_update['ar_jumlah'] = $dt['ar_jumlah'];
        $ar_update['updated_at'] = date("Y-m-d H:i:s");
        $ar_update['updated_by'] = $this->session->userdata('id');
        $this->mymodel->updateData('absensi_rapat', $ar_update, ['ar_id' => $ar_id]);
        $last_id = $ar_id;

        $this->mymodel->deleteData('absensi_rapat_agenda', ['ara_ar_id' => $last_id]);
        foreach ($dt['agenda'] as $key => $value) {
            $agenda_rapat = $dt['agenda'][$key];
            $jam_mulai = $dt['mulai'][$key];
            $jam_selesai = $dt['selesai'][$key];

            // Handle Pemateri Data
            $pemateri_id = $dt['pemateri'][$key];
            if (strpos($pemateri_id, ",")) {
                // Multiple data
                $explode_pemateri = explode(",", $pemateri_id);
                $nama_pemateri = array();
                $singkatan_pemateri = array();
                foreach ($explode_pemateri as $mat => $val_mat) {
                    $detail_pemateri = $this->mymodel->selectDataone('m_divisi', ['md_id' => $val_mat]);
                    $nama_pemateri[] = $detail_pemateri['md_nama'];
                    $singkatan_pemateri[] = $detail_pemateri['md_singkatan'];
                }
                $value_id_pemateri = json_encode($explode_pemateri);
                $value_nama_pemateri = json_encode($nama_pemateri);
                $value_singkatan_pemateri = json_encode($singkatan_pemateri);
            } else {
                // Single Data
                $detail_pemateri = $this->mymodel->selectDataone('m_divisi', ['md_id' => $pemateri_id]);
                $value_id_pemateri = json_encode(array($pemateri_id));
                $value_nama_pemateri = json_encode(array($detail_pemateri['md_nama']));
                $value_singkatan_pemateri = json_encode(array($detail_pemateri['md_singkatan']));
            }

            // Handle Pendamping Data
            $pendamping_id = $dt['pendamping'][$key];
            if (strpos($pendamping_id, ",")) {
                // Multiple data
                $explode_pendamping = explode(",", $pendamping_id);
                $nama_pendamping = array();
                $singkatan_pendamping = array();
                foreach ($explode_pendamping as $pdm => $val_pdm) {
                    $detail_pendamping = $this->mymodel->selectDataone('m_divisi', ['md_id' => $val_pdm]);
                    $nama_pendamping[] = $detail_pendamping['md_nama'];
                    $singkatan_pendamping[] = $detail_pendamping['md_singkatan'];
                }
                $value_id_pendamping = json_encode($explode_pendamping);
                $value_nama_pendamping = json_encode($nama_pendamping);
                $value_singkatan_pendamping = json_encode($singkatan_pendamping);
            } else {
                // Single Data
                $detail_pendamping = $this->mymodel->selectDataone('m_divisi', ['md_id' => $pendamping_id]);
                $value_id_pendamping = json_encode(array($pendamping_id));
                $value_nama_pendamping = json_encode(array($detail_pendamping['md_nama']));
                $value_singkatan_pendamping = json_encode(array($detail_pendamping['md_singkatan']));
            }

            $ara_input = array(
                'ara_ar_id' => $last_id,
                'ara_nama' => $agenda_rapat,
                'ara_mulai' => $jam_mulai,
                'ara_selesai' => $jam_selesai,
                'ara_id_divisi_materi' => $value_id_pemateri,
                'ara_nama_divisi_materi' => $value_nama_pemateri,
                'ara_singkatan_divisi_materi' => $value_singkatan_pemateri,
                'ara_id_divisi_pendamping' => $value_id_pendamping,
                'ara_nama_divisi_pendamping' => $value_nama_pendamping,
                'ara_singkatan_divisi_pendamping' => $value_singkatan_pendamping,
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $this->session->userdata('id')
            );
            $this->mymodel->insertData('absensi_rapat_agenda', $ara_input);
        }

        echo "success";
    }

    public function delete_absensi()
    {
        $are_id = $this->input->post('are_id');

        $rapat_enroll = $this->mymodel->selectWhere('absensi_rapat_enroll', ['are_id' => $are_id]);
        // unlink data
        if (file_exists("./webfile/ttd_absensi_rapat/" . $rapat_enroll['are_ttd'])) {
            unlink("./webfile/ttd_absensi_rapat" . $rapat_enroll['are_ttd']);
        }
        // delete data
        $this->mymodel->deleteData('absensi_rapat_enroll', ['are_id' => $are_id]);

        echo "success";
    }

    // ------ End CRUD ABSENSI RAPAT ----- //

    public function create_absensi_direksi($tipe, $ar_id, $mpj_id)
    {
        if ($tipe == 1) {
            $posisi = "Direksi";
        } else {
            $posisi = "SEVP";
        }
        $data['direksi'] = $this->mymodel->selectDataone('m_posisi_jabatan', ['mpj_id' => $mpj_id, 'status' => "ENABLE"]);
        $data['posisi'] = $posisi;
        $data['ar_id']  = $ar_id;
        $data['ar_id_encode'] = $this->template->sonEncode($ar_id);
        $this->load->view('master/absensi_rapat/create-absensi_direksi', $data);
    }

    public function store_absensi_direksi()
    {
        $post_data = $this->input->post();
        $dt = $this->input->post('dt');
        $dt['are_status_kehadiran'] = "Hadir";
        $dt['created_at'] = date("Y-m-d H:i:s");
        $this->mymodel->insertData('absensi_rapat_enroll', $dt);
        $last_id = $this->db->insert_id();

        // Handle signature pad / tanda tangan
        $data_uri = $post_data['ttd'];
        $encoded_image = explode(",", $data_uri)[1];
        $decoded_image = base64_decode($encoded_image);
        $ttd_name = "ttd_" . $dt['are_ar_id'] . "_" . $last_id . ".png";
        file_put_contents("webfile/ttd_absensi_rapat/" . $ttd_name, $decoded_image);

        // Update field ttd ke data absensi.
        $this->mymodel->updateData('absensi_rapat_enroll', ['are_ttd' => $ttd_name], ['are_id' => $last_id]);
        echo "success";
    }

    public function create_absensi_divisi($tipe, $ar_id)
    {
        if ($tipe == 1) {
            $posisi = "Pemateri";
        } elseif ($tipe == 3) {
            $posisi = "Non Komisaris";
        } else {
            $posisi = "Pendamping";
        }
        $data['divisi'] = $this->mymodel->selectWhere('m_divisi', ['status' => "ENABLE"]);
        $data['posisi'] = $posisi;
        $data['ar_id']  = $ar_id;
        $data['tipe'] = $tipe;
        $data['ar_id_encode'] = $this->template->sonEncode($ar_id);
        $this->load->view('master/absensi_rapat/create-absensi_divisi', $data);
    }

    public function store_absensi_divisi()
    {
        $post_data = $this->input->post();
        $dt = $this->input->post('dt');

        $divisi_detail = @$this->mymodel->selectDataone('m_divisi', ['md_id' => $dt['are_md_id']]);
        $dt['are_md_nama'] = @$divisi_detail['md_nama'];
        $dt['are_status_kehadiran'] = "Hadir";
        $dt['created_at'] = date("Y-m-d H:i:s");
        $this->mymodel->insertData('absensi_rapat_enroll', $dt);
        $last_id = $this->db->insert_id();

        // Handle signature pad / tanda tangan
        $data_uri = $post_data['ttd'];
        $encoded_image = explode(",", $data_uri)[1];
        $decoded_image = base64_decode($encoded_image);
        $ttd_name = "ttd_" . $dt['are_ar_id'] . "_" . $last_id . ".png";
        file_put_contents("webfile/ttd_absensi_rapat/" . $ttd_name, $decoded_image);

        // Update field ttd ke data absensi.
        $this->mymodel->updateData('absensi_rapat_enroll', ['are_ttd' => $ttd_name], ['are_id' => $last_id]);
        echo "success";
    }

    public function delete_agenda()
    {
        $ar_id = $this->input->post('id');
        // Delete Data absensi rapat enroll
        $cek_data_enroll = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_ar_id' => $ar_id]);
        if ($cek_data_enroll['are_id'] != NULL) {
            $rapat_enroll = $this->mymodel->selectWhere('absensi_rapat_enroll', ['are_ar_id' => $ar_id]);
            if ($rapat_enroll) {
                foreach ($rapat_enroll as $re) {
                    // unlink data
                    if (file_exists("./webfile/ttd_absensi_rapat/" . $re['are_ttd'])) {
                        unlink("./webfile/ttd_absensi_rapat" . $re['are_ttd']);
                    }
                    // delete data
                    $this->mymodel->deleteData('absensi_rapat_enroll', ['are_id' => $re['are_id']]);
                }
            }
        }

        // Delete Data Absensi Rapat Agenda
        $cek_data_agenda = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_ar_id' => $ar_id]);
        if ($cek_data_agenda['ara_id'] != NULL) {
            $this->mymodel->deleteData('absensi_rapat_agenda', ['ara_ar_id' => $ar_id]);
        }

        // Delete QRCODE
        if (file_exists("./webfile/qr_absensi_rapat/qrcode-" . $ar_id . "jpg")) {
            unlink("./webfile/qr_absensi_rapat/qrcode-" . $ar_id . "jpg");
        }
        // Delete Data Agenda
        $this->mymodel->deleteData('absensi_rapat', ['ar_id' => $ar_id]);
        echo "success";
    }

    public function tanggal_data($ar_id)
    {
        $absensi_rapat = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id]);
        $timestamp = strtotime($absensi_rapat['ar_tanggal']);

        $day = date('D', $timestamp);
        $tanggal = date('d', $timestamp);
        $bulan = date('m', $timestamp);
        $tahun = date('Y', $timestamp);

        switch ($day) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;

            case 'Mon':
                $hari_ini = "Senin";
                break;

            case 'Tue':
                $hari_ini = "Selasa";
                break;

            case 'Wed':
                $hari_ini = "Rabu";
                break;

            case 'Thu':
                $hari_ini = "Kamis";
                break;

            case 'Fri':
                $hari_ini = "Jumat";
                break;

            case 'Sat':
                $hari_ini = "Sabtu";
                break;

            default:
                $hari_ini = "Tidak di ketahui";
                break;
        }

        switch ($bulan) {
            case '01':
                $bulan_ini = "Januari";
                break;

            case '02':
                $bulan_ini = "Februari";
                break;

            case '03':
                $bulan_ini = "Maret";
                break;

            case '04':
                $bulan_ini = "April";
                break;

            case '05':
                $bulan_ini = "Mei";
                break;

            case '06':
                $bulan_ini = "Juni";
                break;

            case '07':
                $bulan_ini = "Juli";
                break;

            case '08':
                $bulan_ini = "Agustus";
                break;

            case '09':
                $bulan_ini = "September";
                break;

            case '10':
                $bulan_ini = "Oktober";
                break;

            case '11':
                $bulan_ini = "November";
                break;

            case '12':
                $bulan_ini = "Desember";
                break;

            default:
                $bulan_ini = "Tidak di ketahui";
                break;
        }

        return $hari_ini . ", " . $tanggal . " " . $bulan_ini . " " . $tahun;
    }

    public function unduh_ppt($ar_id)
    {
        // Data untuk pptnya
        $absensi_rapat = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id]);
        $absensi_rapat_agenda = $this->mymodel->selectWhere('absensi_rapat_agenda', ['ara_ar_id' => $ar_id]);
        $data_tanggal = $this->tanggal_data($absensi_rapat['ar_id']);

        $judulrapat['rapat_direksi'] = 'Rapat Direksi';
        $judulrapat['komite_komisaris'] = 'Rapat Komisaris';
        $judulrapat['komite_direksi'] = 'Rapat Komite Direksi';
        $judulrapat['rapat_gabungan'] = 'Rapat Gabungan';

        $judul_rapat = $judulrapat[$absensi_rapat['ar_tipe_rapat']];

        $phpPresentation = new PhpPresentation();
        $phpPresentation->getLayout()->setDocumentLayout(DocumentLayout::LAYOUT_SCREEN_16X9);

        if ($absensi_rapat_agenda) :
            $display = 6;
            //echo $display;exit();
            // inisialisasi variabel page
            $page = 1;

            // mengatur data dalam array
            foreach ($absensi_rapat_agenda as $pesertaBagi) :
                $arrdata[] = $pesertaBagi;
            endforeach;

            $jumlah = count($absensi_rapat_agenda);
            if (($jumlah % $display) == 0) {
                $total = (int)($jumlah / $display);
            } else {
                $total = ((int)($jumlah / $display) + 1);
            }
        endif;

        if ($absensi_rapat_agenda) {
            for ($page = 1; $page <= $total; $page++) {
                $start  = ($page * $display) - $display;
                $view   = array_slice($arrdata, $start, $display);
                $end    = $display * $page;

                // Create Slide
                if ($page == 1) {
                    $currentSlide = $phpPresentation->getActiveSlide();
                } else {
                    $currentSlide = $phpPresentation->createSlide();
                }

                $oBkgImage = new Image();
                $oBkgImage->setPath('./webfile/background-bri.jpg');
                $currentSlide->setBackground($oBkgImage);

                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(70)
                    ->setWidth(525)
                    ->setOffsetX(250)
                    ->setOffsetY(7.5);
                $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $textRun = $shape->createTextRun('PT Bank Rakyat Indonesia (Persero) Tbk.');
                $textRun->getFont()->setBold(true)->setSize(16)->setName('Tahoma');
                $textRun = $shape->createBreak();
                $textRun = $shape->createTextRun($judul_rapat . ' - ' . $data_tanggal);
                $textRun->getFont()->setBold(true)->setSize(16)->setName('Tahoma');

                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(25)
                    ->setWidth(300)
                    ->setOffsetX(615)
                    ->setOffsetY(90);
                $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $textRun = $shape->createTextRun('Daftar Hadir ' . $judul_rapat);
                $textRun->getFont()->setBold(true)->setSize(12)->setName('Tahoma');

                if (file_exists('./webfile/qr_absensi_rapat/qrcode-' . $absensi_rapat['ar_id'] . '.jpg')) {
                    $shape = new Drawing\Base64();
                    $image_url = base_url('webfile/qr_absensi_rapat/qrcode-' . $absensi_rapat['ar_id'] . '.jpg');
                    $imageData = "data:image/jpeg;base64," . base64_encode(file_get_contents($image_url));
                    $shape->setName('QR Code')
                        ->setDescription('QR Code')
                        ->setData($imageData)
                        ->setResizeProportional(false)
                        ->setHeight(175)
                        ->setWidth(175)
                        ->setOffsetX(675)
                        ->setOffsetY(120);
                    $currentSlide->addShape($shape);
                }

                // Table Data
                $shape = $currentSlide->createTableShape(2);
                $shape->setHeight(50);
                $shape->setWidth(1150);
                $shape->setOffsetX(15);
                $shape->setOffsetY(95);

                $seq_number = 1;
                foreach ($view as $ara) {
                    // Creat Row
                    $row = $shape->createRow();

                    // Create Column
                    $row->setHeight(75);
                    $oCellNo = $row->nextCell();
                    $oCellNo->setWidth(50);
                    $oCellNo->createTextRun($seq_number . ".")->getFont()->setBold(true)->setSize(10)->setName('Tahoma');
                    $oCellNo->getActiveParagraph()->getAlignment()->setMarginLeft(2.5);
                    $oCellNo->getBorders()->getLeft()->setLineStyle(Border::LINE_NONE);
                    $oCellNo->getBorders()->getTop()->setLineStyle(Border::LINE_NONE);
                    $oCellNo->getBorders()->getRight()->setLineStyle(Border::LINE_NONE);
                    $oCellNo->getBorders()->getBottom()->setLineStyle(Border::LINE_NONE);

                    // Another Column
                    $oCellData = $row->nextCell();
                    $oCellData->createTextRun($ara['ara_nama'])->getFont()->setBold(true)->setSize(10)->setName('Tahoma');
                    $oCellData->createBreak();

                    $jam_mulai = strtotime($ara['ara_mulai']);
                    $jam_selesai = strtotime($ara['ara_selesai']);
                    $oCellData->createTextRun('Pukul: ' . date('H:i', $jam_mulai) . ' - ' . date('H:i', $jam_selesai) . ' WIB')->getFont()->setBold(false)->setSize(10)->setName('Tahoma');
                    $oCellData->createBreak();

                    $data_pemateri = json_decode($ara['ara_id_divisi_materi']);
                    $count_pemateri = count($data_pemateri);
                    $str_pemateri = "";
                    $number_pemateri = 1;
                    foreach ($data_pemateri as $dtm) {
                        $this->db->select('md_singkatan');
                        $div_mat = $this->mymodel->selectDataone('m_divisi', ['md_id' => $dtm]);
                        if ($number_pemateri == $count_pemateri) {
                            $str_pemateri .= $div_mat['md_singkatan'] . ".";
                        } else {
                            $str_pemateri .= $div_mat['md_singkatan'] . ", ";
                        }
                        $number_pemateri++;
                    }
                    $oCellData->createTextRun('Pemateri: Divisi ' . $str_pemateri)->getFont()->setBold(false)->setSize(10)->setName('Tahoma');
                    $oCellData->createBreak();

                    $data_pendamping = json_decode($ara['ara_id_divisi_pendamping']);
                    $count_pendamping = count($data_pendamping);
                    $str_pendamping = "";
                    $number_pendamping = 1;
                    foreach ($data_pendamping as $dtm) {
                        $this->db->select('md_singkatan');
                        $div_mat = $this->mymodel->selectDataone('m_divisi', ['md_id' => $dtm]);
                        if ($number_pendamping == $count_pendamping) {
                            $str_pendamping .= $div_mat['md_singkatan'] . ".";
                        } else {
                            $str_pendamping .= $div_mat['md_singkatan'] . ", ";
                        }
                        $number_pendamping++;
                    }
                    $oCellData->createTextRun('Pendamping: Divisi ' . $str_pendamping)->getFont()->setBold(false)->setSize(10)->setName('Tahoma');
                    $oCellData->getBorders()->getLeft()->setLineStyle(Border::LINE_NONE);
                    $oCellData->getBorders()->getTop()->setLineStyle(Border::LINE_NONE);
                    $oCellData->getBorders()->getRight()->setLineStyle(Border::LINE_NONE);
                    $oCellData->getBorders()->getBottom()->setLineStyle(Border::LINE_NONE);
                    $seq_number++;
                }
            }
        }


        $writer = new PowerPoint2007($phpPresentation);

        $filename = 'agenda_rapat_' . $ar_id;
        header('Content-Type: application/vnd.ms-powerpoint');
        header('Content-Disposition: attachment;filename="' . $filename . '.pptx"');
        header('Cache-Control: max-age=0');

        $writer->save("php://output");
        die();
    }

    public function detail_pdf($ar_id)
    {
        $absensi_rapat = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id]);
        $data['absensi_rapat'] = $absensi_rapat;
        $data['absensi_rapat_agenda'] = $this->mymodel->selectWhere('absensi_rapat_agenda', ['ara_ar_id' => $ar_id]);
        $data['data_tanggal'] = $this->tanggal_data($absensi_rapat['ar_id']);
        $data['page_name'] = "absensi detail";
        $this->load->view('master/absensi_rapat/pdf-absensi_rapat', $data);
    }

    public function unduh_pdf($ar_id)
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');

        // title dari pdf
        $absensi_rapat = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id]);
        $this->data['absensi_rapat'] = $absensi_rapat;
        $this->data['absensi_rapat_agenda'] = $this->mymodel->selectWhere('absensi_rapat_agenda', ['ara_ar_id' => $ar_id]);
        $this->data['data_tanggal'] = $this->tanggal_data($absensi_rapat['ar_id']);
        $this->data['page_name'] = "absensi detail";

        // filename dari pdf ketika didownload
        $file_pdf = 'absensi_rapat';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "landscape";

        $html = $this->load->view('master/absensi_rapat/pdf-absensi_rapat', $this->data, true);

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function unduh_absensi_direksi($ar_id)
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');

        // title dari pdf
        $absensi_rapat = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id]);
        $this->data['absensi_rapat'] = $absensi_rapat;
        $this->data['page_name'] = "absensi detail";

        // filename dari pdf ketika didownload
        $file_pdf = 'absensi_rapat_direksi';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "potrait";

        $html = $this->load->view('master/absensi_rapat/pdf-absensi_direksi', $this->data, true);

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function unduh_absensi_sevp($ar_id)
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');

        // title dari pdf
        $absensi_rapat = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id]);
        $this->data['absensi_rapat'] = $absensi_rapat;
        $this->data['page_name'] = "absensi detail";

        // filename dari pdf ketika didownload
        $file_pdf = 'absensi_rapat_sevp';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "potrait";

        $html = $this->load->view('master/absensi_rapat/pdf-absensi_sevp', $this->data, true);

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function unduh_absensi_pemateri($ar_id)
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');

        // title dari pdf
        $absensi_rapat = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id]);
        $this->data['absensi_rapat'] = $absensi_rapat;
        $this->data['page_name'] = "absensi detail";

        // filename dari pdf ketika didownload
        $file_pdf = 'absensi_rapat_pemateri';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "potrait";

        $html = $this->load->view('master/absensi_rapat/pdf-absensi_pemateri', $this->data, true);

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function unduh_absensi_pendamping($ar_id)
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');

        // title dari pdf
        $absensi_rapat = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id]);
        $this->data['absensi_rapat'] = $absensi_rapat;
        $this->data['page_name'] = "absensi detail";

        // filename dari pdf ketika didownload
        $file_pdf = 'absensi_rapat_pendamping';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "potrait";

        $html = $this->load->view('master/absensi_rapat/pdf-absensi_pendamping', $this->data, true);

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function ekspor_agenda()
    {
        $tipe_rapat = $this->input->get('tipe_rapat');
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator('Digital Corsec')
            ->setLastModifiedBy('Digital Corsec')
            ->setTitle("Agenda Rapat")
            ->setSubject("Agenda Rapat")
            ->setDescription("Agenda Rapat")
            ->setKeywords("Agenda Rapat");

        $style_col = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),
                'right' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),
                'bottom' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),
                'left' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
            ),
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'DDDDDD')
            ),
        );

        $style_col1 = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),
                'right' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),
                'bottom' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),
                'left' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
            ),
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'DDDDDD')
            ),
        );

        $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit("A1",  "No.", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->getColumnDimension("A")->setAutoSize(TRUE);
        $spreadsheet->getActiveSheet(0)->mergeCells("A1:A2");
        $spreadsheet->getActiveSheet(0)->getStyle("A1:A2")->applyFromArray($style_col);

        $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit("B1",  "Tanggal", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->getColumnDimension("B")->setAutoSize(TRUE);
        $spreadsheet->getActiveSheet(0)->mergeCells("B1:B2");
        $spreadsheet->getActiveSheet(0)->getStyle("B1:B2")->applyFromArray($style_col);

        $data_direksi = $this->mymodel->selectWhere('m_posisi_jabatan', ['mpj_mp_id' => '1', 'status' => "ENABLE"]);
        $char = "B";
        foreach ($data_direksi as $key => $value) {
            ++$char;
        }
        $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit("C1",  "Daftar Hadir Direksi", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->mergeCells("C1:" . $char . "1");
        $spreadsheet->getActiveSheet(0)->getStyle("C1:" . $char . "1")->applyFromArray($style_col);

        $char = "C";
        foreach ($data_direksi as $key) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit($char . "2",  $key['mpj_singkatan'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $spreadsheet->getActiveSheet(0)->getColumnDimension($char)->setWidth(15);
            $spreadsheet->getActiveSheet(0)->getStyle($char . "2")->applyFromArray($style_col);
            ++$char;
        }

        $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit($char . "1",  "Direktur yang hadir", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->getColumnDimension($char)->setAutoSize(TRUE);
        $spreadsheet->getActiveSheet(0)->mergeCells($char . "1:" . $char . "2");
        $spreadsheet->getActiveSheet(0)->getStyle($char . "1:" . $char . "2")->applyFromArray($style_col);
        ++$char;

        $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit($char . "1",  "Total Direksi", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->getColumnDimension($char)->setAutoSize(TRUE);
        $spreadsheet->getActiveSheet(0)->mergeCells($char . "1:" . $char . "2");
        $spreadsheet->getActiveSheet(0)->getStyle($char . "1:" . $char . "2")->applyFromArray($style_col);
        ++$char;

        $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit($char . "1",  "% Kuorum", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->getColumnDimension($char)->setAutoSize(TRUE);
        $spreadsheet->getActiveSheet(0)->mergeCells($char . "1:" . $char . "2");
        $spreadsheet->getActiveSheet(0)->getStyle($char . "1:" . $char . "2")->applyFromArray($style_col);
        ++$char;

        $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit($char . "1",  "Agenda", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->getColumnDimension($char)->setAutoSize(TRUE);
        $spreadsheet->getActiveSheet(0)->mergeCells($char . "1:" . $char . "2");
        $spreadsheet->getActiveSheet(0)->getStyle($char . "1:" . $char . "2")->applyFromArray($style_col);
        ++$char;

        $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit($char . "1",  "Divisi Pemateri", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->getColumnDimension($char)->setAutoSize(TRUE);
        $spreadsheet->getActiveSheet(0)->mergeCells($char . "1:" . $char . "2");
        $spreadsheet->getActiveSheet(0)->getStyle($char . "1:" . $char . "2")->applyFromArray($style_col);


        $spreadsheet->getActiveSheet(0)->getDefaultRowDimension()->setRowHeight(-1);
        $spreadsheet->getActiveSheet(0)->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet(0)->setTitle("Data Absen dan Download Direksi");

        $row = 3;

        if (($this->session->userdata('role_id') == '25') || ($this->session->userdata('role_id') == '26')) {
            $this->db->where('created_by', $this->session->userdata('id'));
        }
        $agenda_rapat = $this->mymodel->selectWhere('absensi_rapat', ['ar_tipe_rapat' => $tipe_rapat]);
        if ($agenda_rapat) {
            $number_data = 1;
            foreach ($agenda_rapat as $key_data) {
                $char = "A";

                $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit($char . $row,  $number_data . ".", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->getStyle($char . $row)->applyFromArray($style_col);
                ++$char;

                $tanggalnya = $this->tanggal_data($key_data['ar_id']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit($char . $row,  $tanggalnya, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->getStyle($char . $row)->applyFromArray($style_col);
                ++$char;

                $dir_hadir = 0;
                foreach ($data_direksi as $dri) {
                    $cek_absen = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_ar_id' => $key_data['ar_id'], 'are_tipe' => 'Direksi', 'are_mpj_id' => $dri['mpj_id']]);
                    if ($cek_absen['are_id'] == NULL) {
                        $hasil_cek = "-";
                        $dir_hadir += 0;
                    } else {
                        $hasil_cek = "1";
                        $dir_hadir += 1;
                    }
                    $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit($char . $row,  $hasil_cek, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $spreadsheet->getActiveSheet(0)->getStyle($char . $row)->applyFromArray($style_col);
                    ++$char;
                }

                $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit($char . $row,  $dir_hadir, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->getStyle($char . $row)->applyFromArray($style_col);
                ++$char;

                $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit($char . $row,  $key_data['ar_jumlah'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->getStyle($char . $row)->applyFromArray($style_col);
                ++$char;

                $hitung_kuorum = ($dir_hadir / $key_data['ar_jumlah']) * 100;
                $kuorum_fix = number_format($hitung_kuorum, 2, ",", ".") . "%";
                $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit($char . $row,  $kuorum_fix, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->getStyle($char . $row)->applyFromArray($style_col);
                ++$char;

                $id_Data = $key_data['ar_id'];
                $query = "SELECT GROUP_CONCAT(ara_nama SEPARATOR ', ') AS agenda_rapat FROM `absensi_rapat_agenda` WHERE ara_ar_id = $id_Data";
                $data_agenda = $this->db->query($query)->row_array();
                $explode_data_1 = explode(",", $data_agenda['agenda_rapat']);
                $number_data_1 = 1;
                $text_data_1 = "";
                foreach ($explode_data_1 as $key_1 => $val_1) {
                    $text_data_1 .= $number_data_1 . ". " . $val_1 . "\n";
                    $number_data_1++;
                }

                $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit($char . $row,  $text_data_1, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->getStyle($char . $row)->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet(0)->getStyle($char . $row)->applyFromArray($style_col);
                ++$char;

                $query = "SELECT GROUP_CONCAT(ara_singkatan_divisi_materi SEPARATOR ';') AS singkatan_divisi_materi FROM `absensi_rapat_agenda` WHERE ara_ar_id = $id_Data";
                $data_agenda = $this->db->query($query)->row_array();
                $explode_data_1 = explode(";", $data_agenda['singkatan_divisi_materi']);
                $number_data_1 = 1;
                $text_data_1 = "";
                foreach ($explode_data_1 as $key_1 => $val_1) {
                    $text_data_1 .= $number_data_1 . ". " . $val_1 . "\n";
                    $number_data_1++;
                }

                $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit($char . $row,  $text_data_1, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->getStyle($char . $row)->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet(0)->getStyle($char . $row)->applyFromArray($style_col);
                ++$char;

                $number_data++;
                $row++;
            }
        }

        $row++;
        // Legenda Direksi

        $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit("B" . $row,  "Legend", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->getStyle("B" . $row)->applyFromArray($style_col);

        $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit("C" . $row,  "Direksi (Singkatan)", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->getStyle("C" . $row)->applyFromArray($style_col);

        foreach ($data_direksi as $dat_dir) {
            $row++;

            $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit("B" . $row,  $dat_dir['mpj_nama'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $spreadsheet->getActiveSheet(0)->getStyle("B" . $row)->applyFromArray($style_col1);

            $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit("C" . $row,  $dat_dir['mpj_singkatan'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $spreadsheet->getActiveSheet(0)->getStyle("C" . $row)->applyFromArray($style_col);
        }

        // Sheet Name
        $spreadsheet->getSheet(0);
        $spreadsheet->getSheetByName('Data Absen dan Download Direksi');

        // Add Sheet SEVP
        $spreadsheet->createSheet(1);

        $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit("A1",  "No.", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(1)->getColumnDimension("A")->setAutoSize(TRUE);
        $spreadsheet->getActiveSheet(1)->mergeCells("A1:A2");
        $spreadsheet->getActiveSheet(1)->getStyle("A1:A2")->applyFromArray($style_col);

        $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit("B1",  "Tanggal", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(1)->getColumnDimension("B")->setAutoSize(TRUE);
        $spreadsheet->getActiveSheet(1)->mergeCells("B1:B2");
        $spreadsheet->getActiveSheet(1)->getStyle("B1:B2")->applyFromArray($style_col);

        $data_direksi = $this->mymodel->selectWhere('m_posisi_jabatan', ['mpj_mp_id' => '2', 'status' => "ENABLE"]);
        $char = "B";
        foreach ($data_direksi as $key => $value) {
            ++$char;
        }
        $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit("C1",  "Daftar Hadir SEVP", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(1)->mergeCells("C1:" . $char . "1");
        $spreadsheet->getActiveSheet(1)->getStyle("C1:" . $char . "1")->applyFromArray($style_col);

        $char = "C";
        foreach ($data_direksi as $key) {
            $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit($char . "2",  $key['mpj_singkatan'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $spreadsheet->getActiveSheet(1)->getColumnDimension($char)->setWidth(15);
            $spreadsheet->getActiveSheet(1)->getStyle($char . "2")->applyFromArray($style_col);
            ++$char;
        }

        $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit($char . "1",  "SEVP yang Hadir", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(1)->getColumnDimension($char)->setAutoSize(TRUE);
        $spreadsheet->getActiveSheet(1)->mergeCells($char . "1:" . $char . "2");
        $spreadsheet->getActiveSheet(1)->getStyle($char . "1:" . $char . "2")->applyFromArray($style_col);
        ++$char;

        $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit($char . "1",  "Agenda", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(1)->getColumnDimension($char)->setAutoSize(TRUE);
        $spreadsheet->getActiveSheet(1)->mergeCells($char . "1:" . $char . "2");
        $spreadsheet->getActiveSheet(1)->getStyle($char . "1:" . $char . "2")->applyFromArray($style_col);
        ++$char;

        $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit($char . "1",  "Divisi Pemateri", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(1)->getColumnDimension($char)->setAutoSize(TRUE);
        $spreadsheet->getActiveSheet(1)->mergeCells($char . "1:" . $char . "2");
        $spreadsheet->getActiveSheet(1)->getStyle($char . "1:" . $char . "2")->applyFromArray($style_col);

        $row = 3;

        if (($this->session->userdata('role_id') == '25') || ($this->session->userdata('role_id') == '26')) {
            $this->db->where('created_by', $this->session->userdata('id'));
        }
        $agenda_rapat = $this->mymodel->selectWhere('absensi_rapat', ['ar_tipe_rapat' => $tipe_rapat]);
        if ($agenda_rapat) {
            $number_data = 1;
            foreach ($agenda_rapat as $key_data) {
                $char = "A";

                $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit($char . $row,  $number_data . ".", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(1)->getStyle($char . $row)->applyFromArray($style_col);
                ++$char;

                $tanggalnya = $this->tanggal_data($key_data['ar_id']);
                $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit($char . $row,  $tanggalnya, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(1)->getStyle($char . $row)->applyFromArray($style_col);
                ++$char;

                $sevp_hadir = 0;
                foreach ($data_direksi as $dri) {
                    $cek_absen = $this->mymodel->selectDataone('absensi_rapat_enroll', ['are_ar_id' => $key_data['ar_id'], 'are_tipe' => 'SEVP', 'are_mpj_id' => $dri['mpj_id']]);
                    if ($cek_absen['are_id'] == NULL) {
                        $hasil_cek = "-";
                        $sevp_hadir += 0;
                    } else {
                        $hasil_cek = "1";
                        $sevp_hadir += 1;
                    }
                    $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit($char . $row,  $hasil_cek, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $spreadsheet->getActiveSheet(1)->getStyle($char . $row)->applyFromArray($style_col);
                    ++$char;
                }

                $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit($char . $row,  $sevp_hadir, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(1)->getStyle($char . $row)->applyFromArray($style_col);
                ++$char;

                $id_Data = $key_data['ar_id'];
                $query = "SELECT GROUP_CONCAT(ara_nama SEPARATOR ', ') AS agenda_rapat FROM `absensi_rapat_agenda` WHERE ara_ar_id = $id_Data";
                $data_agenda = $this->db->query($query)->row_array();
                $explode_data_2 = explode(",", $data_agenda['agenda_rapat']);
                $number_data_2 = 1;
                $text_data_2 = "";
                foreach ($explode_data_2 as $key_2 => $val_2) {
                    $text_data_2 .= $number_data_2 . ". " . $val_2 . "\n";
                    $number_data_2++;
                }

                $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit($char . $row,  $text_data_2, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(1)->getStyle($char . $row)->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet(1)->getStyle($char . $row)->applyFromArray($style_col);
                ++$char;

                $query = "SELECT GROUP_CONCAT(ara_singkatan_divisi_materi SEPARATOR ';') AS singatan_divisi_materi FROM `absensi_rapat_agenda` WHERE ara_ar_id = $id_Data";
                $data_agenda = $this->db->query($query)->row_array();
                $explode_data_2 = explode(";", $data_agenda['singatan_divisi_materi']);
                $number_data_2 = 1;
                $text_data_2 = "";
                foreach ($explode_data_2 as $key_2 => $val_2) {
                    $text_data_2 .= $number_data_2 . ". " . $val_2 . "\n";
                    $number_data_2++;
                }

                $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit($char . $row,  $text_data_2, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(1)->getStyle($char . $row)->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet(1)->getStyle($char . $row)->applyFromArray($style_col);
                ++$char;

                $number_data++;
                $row++;
            }
        }

        $row++;
        // Legenda Direksi

        $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit("B" . $row,  "Legend", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(1)->getStyle("B" . $row)->applyFromArray($style_col);

        $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit("C" . $row,  "SEVP (Singkatan)", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(1)->getStyle("C" . $row)->applyFromArray($style_col);

        foreach ($data_direksi as $dat_dir) {
            $row++;

            $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit("B" . $row,  $dat_dir['mpj_nama'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $spreadsheet->getActiveSheet(1)->getStyle("B" . $row)->applyFromArray($style_col1);

            $spreadsheet->setActiveSheetIndex(1)->setCellValueExplicit("C" . $row,  $dat_dir['mpj_singkatan'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $spreadsheet->getActiveSheet(1)->getStyle("C" . $row)->applyFromArray($style_col);
        }

        // Sheet Name
        $spreadsheet->getActiveSheet(1)->setTitle('Data Absen dan Download SEVP');

        // Set Active Sheet
        $spreadsheet->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Agenda Rapat.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        ob_end_clean();
        $writer->save('php://output');
        die();
    }

    public function unduh_absensi_komisaris($ar_id)
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');

        // title dari pdf
        $absensi_rapat = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id]);
        $this->data['absensi_rapat'] = $absensi_rapat;
        $this->data['page_name'] = "absensi detail";

        // filename dari pdf ketika didownload
        $file_pdf = 'absensi_rapat_direksi';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "potrait";

        $html = $this->load->view('master/absensi_rapat/pdf-absensi_komisaris', $this->data, true);

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function unduh_absensi_non_komisaris($ar_id)
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');

        // title dari pdf
        $absensi_rapat = $this->mymodel->selectDataone('absensi_rapat', ['ar_id' => $ar_id]);
        $this->data['absensi_rapat'] = $absensi_rapat;
        $this->data['page_name'] = "absensi detail";

        // filename dari pdf ketika didownload
        $file_pdf = 'absensi_rapat_pemateri';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "potrait";

        $html = $this->load->view('master/absensi_rapat/pdf-absensi_non_komisaris', $this->data, true);

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    function get_data_agenda($ara_id)
    {
        $result = array();
        $agenda = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_id' => $ara_id]);

        if ($agenda) {
            $dt['ara_stopwatch_mulai'] = date('Y-m-d H:i:s');
            $this->mymodel->updateData('absensi_rapat_agenda', $dt, array('ara_id' => $ara_id));

            $result = array(
                'status_code' => 200,
                'agenda' => $agenda['ara_nama'],
            );
        } else {
            $result = array(
                'status_code' => 400,
            );
        }

        echo json_encode($result);
    }

    function batal_stopwatch_agenda($ara_id)
    {
        $result = array();
        $dt['ara_stopwatch_mulai'] = null;
        $batal = $this->mymodel->updateData('absensi_rapat_agenda', $dt, array('ara_id' => $ara_id));

        if ($batal) {
            $result = array(
                'status_code' => 200,
            );
        } else {
            $result = array(
                'status_code' => 400,
            );
        }

        echo json_encode($result);
    }

    function selesai_stopwatch_agenda($ara_id)
    {
        $result = array();
        $dt['ara_stopwatch_selesai'] = date('Y-m-d H:i:s');
        $batal = $this->mymodel->updateData('absensi_rapat_agenda', $dt, array('ara_id' => $ara_id));

        if ($batal) {
            $result = array(
                'status_code' => 200,
            );
        } else {
            $result = array(
                'status_code' => 400,
            );
        }

        echo json_encode($result);
    }

    function lanjut_stopwatch_agenda($ara_id)
    {
        $result = array();
        $agenda = $this->mymodel->selectDataone('absensi_rapat_agenda', ['ara_id' => $ara_id]);

        if ($agenda) {
            $this->mymodel->updateData('absensi_rapat_agenda', $dt, array('ara_id' => $ara_id));

            $result = array(
                'status_code' => 200,
                'agenda' => $agenda['ara_nama'],
                'waktu_mulai' => $agenda['ara_stopwatch_mulai'],
            );
        } else {
            $result = array(
                'status_code' => 400,
            );
        }

        echo json_encode($result);
    }

    public function remakeQrCode($id)
    {
        $link = base_url('form-absensi/kehadiran/' . $this->template->sonEncode($id));

        $logo = 'http://digitalcorsec.id/assets/logo_bri_new2.png';
        $content = file_get_contents('https://app.aotol.com/qr/api?qr_content=' . $link . '&qr_logo=' . $logo);
        file_put_contents('webfile/qr_absensi_rapat/qrcode-' . $id . '.jpg', $content);

        echo $link;
    }
}
