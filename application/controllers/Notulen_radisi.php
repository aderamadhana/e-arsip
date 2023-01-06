<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Notulen_radisi extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "Notulasi Radisi";
		$this->template->load('template/template', 'notulen_radisi/index', $data);
	}

	public function json()
	{
		$tglNotulen = $_GET['tanggal'];

		header('Content-Type: application/json');
		$this->datatables->select(
			'nr_id, nr_pic, nr_tanggal_awal_sirkuler, nr_catatan,
			(SELECT GROUP_CONCAT(absensi_rapat_agenda.ara_nama SEPARATOR ";") AS agenda_rapat FROM `absensi_rapat_agenda` WHERE absensi_rapat_agenda.ara_ar_id = absensi_rapat.ar_id) as agenda_rapat'
		);
		$this->datatables->join('absensi_rapat', 'absensi_rapat.ar_id = notulensi_radisi.nr_absensi_rapat_id');

		if ($tglNotulen != "") {
			$this->datatables->where('DATE(notulensi_radisi.nr_tanggal_awal_sirkuler)', $tglNotulen);
		}

		$this->datatables->from('notulensi_radisi');
		$this->datatables->add_column('view', '<div class="btn-group">
				<button style="font-size:14px" type="button" class="btn btn-sm btn-primary" onclick="detailNotula($1);"><i class="fa fa-eye"></i></button>
		</div>', 'nr_id');
		echo $this->datatables->generate();
	}

	public function create()
	{
		$data['absensiRapat'] = $this->mymodel->selectWhere('absensi_rapat', array('ar_tipe_rapat' => 'rapat_direksi'));
		$this->load->view('notulen_radisi/add-notulen_radisi', $data);
	}

	public function validate()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('dt[nr_absensi_rapat_id]', '<strong>Tanggal Rapat Direksi</strong>', 'required');
	}

	public function store()
	{
		$this->validate();
		if ($this->form_validation->run() == FALSE) {
			echo validation_errors();
		} else {
			$dt = $this->input->post('dt');

			$time = date('Y-m-d H:i:s');

			$idAbsensi = $dt['nr_absensi_rapat_id'];

			$dataAbsensi = $this->mymodel->selectDataone('absensi_rapat', array('ar_id' => $idAbsensi));
			$dt['nr_absensi_rapat_tanggal'] = $dataAbsensi['ar_tanggal'];

			$dataAgenda = $this->mymodel->selectWhere('absensi_rapat_agenda', array('ara_ar_id' => $idAbsensi));

			$agenda = "";

			foreach ($dataAgenda as $key => $value) {
				$no = $key + 1;
				$agenda .= $no . ". " . $value['ara_nama'] . "\n";
			}

			$dt['nr_absensi_rapat_agenda'] = $agenda;

			$dt['nr_tanggal_awal_sirkuler'] = $time;
			$dt['created_at'] = $time;
			$dt['created_by'] = $this->session->userdata('id');
			$str = $this->mymodel->insertData('notulensi_radisi', $dt);

			if ($str) {
				$response = [
					'status' => 200,
					'message' => 'Berhasil disimpan',
				];
			} else {
				$response = [
					'status' => 400,
					'message' => 'Gagal disimpan',
				];
			}

			echo json_encode($response);
		}
	}

	public function getAgendaRapat($idAbsensiRapat)
	{
		$dataAgenda = $this->mymodel->selectWhere('absensi_rapat_agenda', array('ara_ar_id' => $idAbsensiRapat));

		if ($dataAgenda) {
			$agenda = "";

			foreach ($dataAgenda as $key => $value) {
				$no = $key + 1;
				$agenda .= $no . ". " . $value['ara_nama'] . "\n";
			}

			$response = [
				'status' => 200,
				'agenda' => $agenda,
			];
		} else {
			$response = [
				'status' => 400,
				'agenda' => 'Tidak ditemukan',
			];
		}

		echo json_encode($response);
	}

	public function detailContent($id, $title)
	{
		$data['data'] = $this->mymodel->selectDataone('notulensi_radisi', array('nr_id' => $id));

		if ($title == "Agenda") {
			$this->load->view('notulen_radisi/detailagenda-notulen_radisi', $data);
		} else if ($title == "Catatan") {
			$this->load->view('notulen_radisi/catatan-notulen_radisi', $data);
		} else {
			$this->load->view('notulen_radisi/detail-notulen_radisi', $data);
		}
	}

	public function detailNotula($id)
	{
		$data['page_name'] = "Notulasi Radisi";

		$data['data'] = $this->mymodel->selectDataone('notulensi_radisi', array('nr_id' => $id));

		// Create QR Absensi Rapat
		$link = base_url('Notulen_radisi/kehadiran_notula_radisi/' . $this->template->sonEncode($id));
		$logo = 'http://digitalcorsec.id/assets/logo_bri_new2.png';
		$content = file_get_contents('http://dev.alfahuma.tech/generate_qrcode.php?qr_content=' . $link . '&qr_logo=' . $logo);
		file_put_contents('webfile/qr_notula_radisi/qrcodenotulen-' . $id . '.jpg', $content);

		$this->db->order_by('mpj_sortingcustom', 'asc');
		$data['absenjabatan'] = $this->mymodel->selectWhere('m_posisi_jabatan', ['status' => 'ENABLE', 'mpj_mp_id' => 1]);

		$this->template->load('template/template', 'notulen_radisi/detail-notulen_radisi', $data);
	}

	public function jsonTimeline()
	{
		$idNotulaRadisi = $_GET['notulaRadisi'];

		header('Content-Type: application/json');
		$this->datatables->select(
			'tnr_waktu_masuk, tnr_waktu_keluar, tnr_posisi_jabatan, tnr_catatan, nr_tanggal_awal_sirkuler'
		);
		$this->datatables->join('notulensi_radisi', 'notulensi_radisi.nr_id = timeline_notula_radisi.tnr_nr_id');

		if ($idNotulaRadisi != "") {
			$this->datatables->where('timeline_notula_radisi.tnr_nr_id', $idNotulaRadisi);
		}

		$this->db->order_by('tnr_waktu_masuk', 'asc');
		$this->datatables->from('timeline_notula_radisi');
		echo $this->datatables->generate();
	}

	public function kehadiran_notula_radisi($id)
	{
		$data['page_name'] = "Check-In Notulen Radisi";
		$data['status'] = "Sirkuler Masuk";

		$data['nr_id'] = $this->template->sonDecode($id);

		$riwayatTimelineBelumKeluar = $this->mymodel->selectWhere('timeline_notula_radisi', ['tnr_nr_id' => $data['nr_id'], 'tnr_waktu_keluar' => null]);

		if (count($riwayatTimelineBelumKeluar) > 0) {
			//terdapat data dengan scan keluar belum terisi
			$data['page_name'] = "Check-Out Notulen Radisi";
			$data['status'] = "Sirkuler Keluar";

			$dataBelumScanKeluar = $this->mymodel->selectDataOne('timeline_notula_radisi', ['tnr_nr_id' => $data['nr_id'], 'tnr_waktu_keluar' => null]);

			$this->db->order_by('mpj_sortingcustom', 'asc');
			$data['jabatan'] = $this->mymodel->selectWhere('m_posisi_jabatan', ['status' => 'ENABLE', 'mpj_mp_id' => 1, 'mpj_id' => $dataBelumScanKeluar['tnr_posisi_jabatan_id']]);
		} else {
			//select jabatan yang belum pernah melakukan notulen
			$this->db->select('tnr_posisi_jabatan_id');
			$riwayatTimeline = $this->mymodel->selectWhere('timeline_notula_radisi', ['tnr_nr_id' => $data['nr_id']]);

			$jabatanArray = array();

			foreach ($riwayatTimeline as $jabatan) {
				$jabatanArray[] = $jabatan['tnr_posisi_jabatan_id'];
			}

			$dtJabatanSdhScan = implode(',', $jabatanArray);
			$dtJabatanScan = explode(',', $dtJabatanSdhScan);

			$this->db->where_not_in('mpj_id', $dtJabatanScan);
			$this->db->order_by('mpj_sortingcustom', 'asc');
			$data['jabatan'] = $this->mymodel->selectWhere('m_posisi_jabatan', ['status' => 'ENABLE', 'mpj_mp_id' => 1]);
		}

		$this->db->order_by('mpj_sortingcustom', 'asc');
		$data['absenjabatan'] = $this->mymodel->selectWhere('m_posisi_jabatan', ['status' => 'ENABLE', 'mpj_mp_id' => 1]);

		$this->db->order_by('tnr_id', 'asc');
		$data['timeline'] = $this->mymodel->selectWhere('timeline_notula_radisi', ['tnr_nr_id' => $data['nr_id']]);

		$this->template->load('template/template-absensi', 'notulen_radisi/scan-notulen_radisi', $data);
	}

	public function store_checkin_checkout()
	{
		$dt = $this->input->post('dt');
		$waktu = date('Y-m-d H:i:s');
		$dt['tnr_is_late'] = 0;
		$dt['tnr_readnotif'] = 0;
		$dt['tnr_countlate'] = 0;

		if ($dt['tnr_jenis'] == "Sirkuler Keluar") {
			$dataTimelineNotula = $this->mymodel->selectDataOne('timeline_notula_radisi', array('tnr_nr_id' => $dt['tnr_nr_id'], 'tnr_posisi_jabatan_id' => $dt['tnr_posisi_jabatan_id'], 'tnr_jenis' => 'Sirkuler Masuk'));

			if ($dataTimelineNotula) {
				$tglMasuk = new DateTime($dataTimelineNotula['created_at']);
				$tglKeluar = new DateTime($waktu);

				$hari = $tglKeluar->diff($tglMasuk);

				if ($hari->d > 2) {
					$dt['tnr_is_late'] = 1;
					$dt['tnr_readnotif'] = 1;
					$dt['tnr_countlate'] = $hari->d;
				}

				/* Update Keluar */
				$dt['tnr_waktu_keluar'] = $waktu;
				$str = $this->mymodel->updateData('timeline_notula_radisi', $dt, ['tnr_id' => $dataTimelineNotula['tnr_id']]);

				if ($str) {

					$response = [
						'status' => 200,
						'message' => 'Berhasil disimpan',
						'id_jabatan' => $dataTimelineNotula['tnr_posisi_jabatan_id'],
						'id_timeline' => $dataTimelineNotula['tnr_id'],
					];
				} else {
					$response = [
						'status' => 400,
						'message' => 'Gagal disimpan',
					];
				}
			} else {
				$response = [
					'status' => 400,
					'message' => 'Silahkan lakukan scan masuk terlebih dahulu',
				];
			}

			echo json_encode($response);
		} else {
			/* Insert Masuk */

			$dt['tnr_waktu_masuk'] = $waktu;

			$dataPosisiJabatan = $this->mymodel->selectDataone('m_posisi_jabatan', array('mpj_id' => $dt['tnr_posisi_jabatan_id']));
			$dt['tnr_posisi_jabatan'] = $dataPosisiJabatan['mpj_nama'];

			$dt['created_at'] = $waktu;

			$str = $this->mymodel->insertData('timeline_notula_radisi', $dt);

			if ($str) {

				$lastIdTimeline = $this->db->insert_id();

				$response = [
					'status' => 200,
					'message' => 'Berhasil disimpan',
					'id_jabatan' => $dt['tnr_posisi_jabatan_id'],
					'id_timeline' => $lastIdTimeline,
				];
			} else {
				$response = [
					'status' => 400,
					'message' => 'Gagal disimpan',
				];
			}

			echo json_encode($response);
		}
	}

	public function download_qrnotulen($id)
	{
		$data['id'] = $id;
		$this->load->view('notulen_radisi/downloadqr-notulen_radisi', $data);
	}

	public function notif_scan($idJabatan, $idTimeline)
	{
		$dataTimelineNotula = $this->mymodel->selectDataOne('timeline_notula_radisi', array('tnr_id' => $idTimeline, 'tnr_posisi_jabatan_id' => $idJabatan));

		if ($dataTimelineNotula['tnr_waktu_keluar'] == null) {
			$data['page_name'] = "Check-In";
			$data['tanggal'] = date('d-m-Y', strtotime($dataTimelineNotula['tnr_waktu_masuk']));
			$data['waktu'] = date('H:i', strtotime($dataTimelineNotula['tnr_waktu_masuk']));
		} else {
			$data['page_name'] = "Check-Out";
			$data['tanggal'] = date('d-m-Y', strtotime($dataTimelineNotula['tnr_waktu_keluar']));
			$data['waktu'] = date('H:i', strtotime($dataTimelineNotula['tnr_waktu_keluar']));
		}

		$dataNotula = $this->mymodel->selectDataOne('notulensi_radisi', array('nr_id' => $dataTimelineNotula['tnr_nr_id']));
		$data['waktu_notulen'] = date('d-m-Y', strtotime($dataNotula['nr_absensi_rapat_tanggal']));

		$dataPosisiJabatan = $this->mymodel->selectDataone('m_posisi_jabatan', array('mpj_id' => $idJabatan));
		$data['jabatan'] = $dataPosisiJabatan['mpj_nama'];

		$this->template->load('template/template-absensi', 'notulen_radisi/notif-scan-notulen_radisi', $data);
	}

	public function exportExcel()
	{
		$tglNotulen = $_GET['tanggal'];

		$this->db->select('
		nr_id, nr_pic, DATE(nr_tanggal_awal_sirkuler) as nr_tanggal_awal_sirkuler, nr_catatan,
		(SELECT GROUP_CONCAT(absensi_rapat_agenda.ara_nama SEPARATOR ";") AS agenda_rapat FROM `absensi_rapat_agenda` WHERE absensi_rapat_agenda.ara_ar_id = absensi_rapat.ar_id) as agenda_rapat
		');
		$this->db->join('absensi_rapat', 'absensi_rapat.ar_id = notulensi_radisi.nr_absensi_rapat_id');

		if ($tglNotulen != "") {
			$this->db->where('DATE(notulensi_radisi.nr_tanggal_awal_sirkuler)', $tglNotulen);
		}

		$data['data'] = $this->mymodel->selectWhere('notulensi_radisi', []);

		$this->load->view('notulen_radisi/export-notulen_radisi', $data, FALSE);
	}
}
