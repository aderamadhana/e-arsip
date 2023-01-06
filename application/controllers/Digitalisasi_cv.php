<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Digitalisasi_cv extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data['page_name'] = "DIGITALISASI CV DIREKSI & DEKOM";
		$this->template->load('template/template', 'digitalisasi_cv/index', $data);
	}
	public function add()
	{
		$data['page_name'] = "Add CV";
		$this->template->load('template/template', 'digitalisasi_cv/add', $data);
	}
	public function tambahBaru()
	{
		$post = $this->input->post();
		$this->mymodel->insertData('cv', $post['dt']);
		$id = $this->db->insert_id();

		$arrayinsert = array(
			'cva_id_cv' => $id,
			'cva_id_user' => $this->session->userdata('id'),
		);
		$this->mymodel->insertData('cv_akses', $arrayinsert);

		redirect('digitalisasi_cv/detail/' . $this->template->sonEncode($id));
	}
	public function aksiAdd()
	{
		$post = $this->input->post();
		if ($_FILES['file']['name']) {
			$fileupload = $this->upload_file_dir('file', 'webfile/');
			$post['dt']['cv_gambar'] = $fileupload['message']['dir'];
		}

		if ($_FILES['riwayat_jabatan_file']) {
			$fileriwayat_jabatan = $this->upload_multiple_file_dir($_FILES['riwayat_jabatan_file'], 'webfile/cv/', 'riwayatjabatan-');
		}
		foreach ($post['riwayat_jabatan_nama'] as $key => $value) {
			$arrayriwayat_jabatan = array(
				'jabatan' => $post['riwayat_jabatan_nama'][$key],
				'uraian' => $post['riwayat_jabatan_uraian'][$key],
				'rentang_waktu' => $post['riwayat_jabatan_rentang'][$key],
				'achievement' => $post['riwayat_jabatan_achievement'][$key],
				'file' => $post['riwayat_jabatan_file_old'][$key],
			);
			if (@$fileriwayat_jabatan['dir'][$key]) {
				$arrayriwayat_jabatan['file'] = @$fileriwayat_jabatan['dir'][$key];
			}
			$group_arrayriwayat_jabatan[] = $arrayriwayat_jabatan;
		}

		if ($_FILES['penugasan_file']) {
			$filepenugasan = $this->upload_multiple_file_dir($_FILES['penugasan_file'], 'webfile/cv/', 'penugasan-');
		}
		foreach ($post['penugasan_penugasan'] as $key => $value) {
			$arraypenugasan = array(
				'penugasan' => $post['penugasan_penugasan'][$key],
				'tupoksi' => $post['penugasan_uraian'][$key],
				'rentang_waktu' => $post['penugasan_rentang'][$key],
				'instansi' => $post['penugasan_instansi'][$key],
				'file' => $post['penugasan_file_old'][$key],
			);
			if (@$filepenugasan['dir'][$key]) {
				$arraypenugasan['file'] = @$filepenugasan['dir'][$key];
			}
			$group_arraypenugasan[] = $arraypenugasan;
		}

		if ($_FILES['organisasi_pekerjaan_file']) {
			$fileorganisasi_pekerjaan = $this->upload_multiple_file_dir($_FILES['organisasi_pekerjaan_file'], 'webfile/cv/', 'organisasipekerjaan-');
		}
		foreach ($post['organisasi_pekerjaan_nama'] as $key => $value) {
			$arrayorganisasi_pekerjaan = array(
				'nama' => $post['organisasi_pekerjaan_nama'][$key],
				'jabatan' => $post['organisasi_pekerjaan_jabatan'][$key],
				'rentang_waktu' => $post['organisasi_pekerjaan_rentang'][$key],
				'uraian' => $post['organisasi_pekerjaan_uraian'][$key],
				'file' => $post['organisasi_pekerjaan_file_old'][$key],
			);
			if (@$fileorganisasi_pekerjaan['dir'][$key]) {
				$arrayorganisasi_pekerjaan['file'] = @$fileorganisasi_pekerjaan['dir'][$key];
			}
			$group_arrayorganisasi_pekerjaan[] = $arrayorganisasi_pekerjaan;
		}

		if ($_FILES['organisasi_nonformal_file']) {
			$fileorganisasi_nonformal = $this->upload_multiple_file_dir($_FILES['organisasi_nonformal_file'], 'webfile/cv/', 'organisasinonformal-');
		}
		foreach ($post['organisasi_nonformal_nama'] as $key => $value) {
			$arrayorganisasi_nonformal = array(
				'nama' => $post['organisasi_nonformal_nama'][$key],
				'jabatan' => $post['organisasi_nonformal_jabatan'][$key],
				'rentang_waktu' => $post['organisasi_nonformal_rentang'][$key],
				'uraian' => $post['organisasi_nonformal_uraian'][$key],
				'file' => $post['organisasi_nonformal_file_old'][$key],
			);
			if (@$fileorganisasi_nonformal['dir'][$key]) {
				$arrayorganisasi_nonformal['file'] = @$fileorganisasi_nonformal['dir'][$key];
			}
			$group_arrayorganisasi_nonformal[] = $arrayorganisasi_nonformal;
		}

		if ($_FILES['penghargaan_file']) {
			$filepenghargaan = $this->upload_multiple_file_dir($_FILES['penghargaan_file'], 'webfile/cv/', 'penghargaan-');
		}
		foreach ($post['penghargaan_jenis'] as $key => $value) {
			$arraypenghargaan = array(
				'jenis' => $post['penghargaan_jenis'][$key],
				'tingkat' => $post['penghargaan_tingkat'][$key],
				'diberikan_oleh' => $post['penghargaan_diberikan_oleh'][$key],
				'tahun' => $post['penghargaan_tahun'][$key],
				'file' => $post['penghargaan_file_old'][$key],
			);
			if (@$filepenghargaan['dir'][$key]) {
				$arraypenghargaan['file'] = @$filepenghargaan['dir'][$key];
			}
			$group_arraypenghargaan[] = $arraypenghargaan;
		}

		if ($_FILES['pendidikan_formal_file']) {
			$filependidikan_formal = $this->upload_multiple_file_dir($_FILES['pendidikan_formal_file'], 'webfile/cv/', 'pendidikanformal-');
		}
		foreach ($post['pendidikan_formal_jenjang'] as $key => $value) {
			$arraypendidikan_formal = array(
				'jenjang' => $post['pendidikan_formal_jenjang'][$key],
				'perguruan_tinggi' => $post['pendidikan_formal_perguruan_tinggi'][$key],
				'tahun_lulus' => $post['pendidikan_formal_tahun_lulus'][$key],
				'kota' => $post['pendidikan_formal_kota'][$key],
				'penghargaan' => $post['pendidikan_formal_penghargaan'][$key],
				'file' => $post['pendidikan_formal_file_old'][$key],
			);
			if (@$filependidikan_formal['dir'][$key]) {
				$arraypendidikan_formal['file'] = @$filependidikan_formal['dir'][$key];
			}
			$group_arraypendidikan_formal[] = $arraypendidikan_formal;
		}

		if ($_FILES['diklat_jabatan_file']) {
			$filediklat_jabatan = $this->upload_multiple_file_dir($_FILES['diklat_jabatan_file'], 'webfile/cv/', 'diklatjabatan-');
		}
		foreach ($post['diklat_jabatan_nama'] as $key => $value) {
			$arraydiklat_jabatan = array(
				'nama' => $post['diklat_jabatan_nama'][$key],
				'penyelenggara' => $post['diklat_jabatan_penyelenggara'][$key],
				'durasi' => $post['diklat_jabatan_durasi'][$key],
				'nomor_sertifikat' => $post['diklat_jabatan_nomor'][$key],
				'file' => $post['diklat_jabatan_file_old'][$key],
			);
			if (@$filediklat_jabatan['dir'][$key]) {
				$arraydiklat_jabatan['file'] = @$filediklat_jabatan['dir'][$key];
			}
			$group_arraydiklat_jabatan[] = $arraydiklat_jabatan;
		}

		if ($_FILES['diklat_fungsional_file']) {
			$filediklat_fungsional = $this->upload_multiple_file_dir($_FILES['diklat_fungsional_file'], 'webfile/cv/', 'diklatfungsional-');
		}
		foreach ($post['diklat_fungsional_nama'] as $key => $value) {
			$arraydiklat_fungsional = array(
				'nama' => $post['diklat_fungsional_nama'][$key],
				'penyelenggara' => $post['diklat_fungsional_penyelenggara'][$key],
				'durasi' => $post['diklat_fungsional_durasi'][$key],
				'nomor_sertifikat' => $post['diklat_fungsional_nomor'][$key],
				'file' => $post['diklat_fungsional_file_old'][$key],
			);
			if (@$filediklat_fungsional['dir'][$key]) {
				$arraydiklat_fungsional['file'] = @$filediklat_fungsional['dir'][$key];
			}
			$group_arraydiklat_fungsional[] = $arraydiklat_fungsional;
		}

		if ($_FILES['karya_tulis_file']) {
			$filekarya_tulis = $this->upload_multiple_file_dir($_FILES['karya_tulis_file'], 'webfile/cv/', 'karyatulis-');
		}
		foreach ($post['karya_tulis_judul'] as $key => $value) {
			$arraykarya_tulis = array(
				'judul' => $post['karya_tulis_judul'][$key],
				'tahun' => $post['karya_tulis_tahun'][$key],
				'file' => $post['karya_tulis_file_old'][$key],
			);
			if (@$filekarya_tulis['dir'][$key]) {
				$arraykarya_tulis['file'] = @$filekarya_tulis['dir'][$key];
			}
			$group_arraykarya_tulis[] = $arraykarya_tulis;
		}

		if ($_FILES['pengalaman_pembicara_file']) {
			$filepengalaman_pembicara = $this->upload_multiple_file_dir($_FILES['pengalaman_pembicara_file'], 'webfile/cv/', 'pengalamanpembicara-');
		}
		foreach ($post['pengalaman_pembicara_acara'] as $key => $value) {
			$arraypengalaman_pembicara = array(
				'acara' => $post['pengalaman_pembicara_acara'][$key],
				'penyelenggara' => $post['pengalaman_pembicara_penyelenggara'][$key],
				'periode' => $post['pengalaman_pembicara_periode'][$key],
				'lokasi' => $post['pengalaman_pembicara_lokasi'][$key],
				'file' => $post['pengalaman_pembicara_file_old'][$key],
			);
			if (@$filepengalaman_pembicara['dir'][$key]) {
				$arraypengalaman_pembicara['file'] = @$filepengalaman_pembicara['dir'][$key];
			}
			$group_arraypengalaman_pembicara[] = $arraypengalaman_pembicara;
		}

		if ($_FILES['referensi_file']) {
			$filereferensi = $this->upload_multiple_file_dir($_FILES['referensi_file'], 'webfile/cv/', 'referensi-');
		}
		foreach ($post['referensi_nama'] as $key => $value) {
			$arrayreferensi = array(
				'nama' => $post['referensi_nama'][$key],
				'perusahaan' => $post['referensi_perusahaan'][$key],
				'jabatan' => $post['referensi_jabatan'][$key],
				'no_telp' => $post['referensi_no_telp'][$key],
				'file' => $post['referensi_file_old'][$key],
			);
			if (@$filereferensi['dir'][$key]) {
				$arrayreferensi['file'] = @$filereferensi['dir'][$key];
			}
			$group_arrayreferensi[] = $arrayreferensi;
		}

		// if ($_FILES['pasangan_file']) {
		// 	$filepasangan = $this->upload_multiple_file_dir($_FILES['pasangan_file'],'webfile/cv/','pasangan-');
		// }
		foreach ($post['pasangan_nama'] as $key => $value) {
			$arraypasangan = array(
				'nama' => $post['pasangan_nama'][$key],
				'tempat_lahir' => $post['pasangan_tempat_lahir'][$key],
				'tanggal_lahir' => $post['pasangan_tanggal_lahir'][$key],
				'tanggal_menikah' => $post['pasangan_tanggal_menikah'][$key],
				'pekerjaan' => $post['pasangan_tanggal_pekerjaan'][$key],
				'keterangan' => $post['pasangan_tanggal_keterangan'][$key],
				'file' => array()
			);
			// $filepasangan = $this->upload_multiple_file_dir($_FILES['pasangan_file_'.$key],'webfile/cv/','pasangan-');
			foreach ($post['pasangan_nama_file_' . $key] as $f => $nama_file) {
				$dokumen = $post['pasangan_old_' . $key][$f];
				if (!empty($_FILES['pasangan_file_' . $key . '_' . $f])) {
					$dokumen = $this->upload_file_dir('pasangan_file_' . $key . '_' . $f, 'webfile/cv/', 'pasangan-' . (md5('smartsoftstudio') . rand(1000, 100000)))['message']['dir'];
				}
				if (!empty($nama_file) && !empty($dokumen)) {
					$arraypasangan['file'][] = array(
						'nama_file' => $nama_file,
						'file' => $dokumen
					);
				}
			}
			$group_arraypasangan[] = $arraypasangan;
		}

		// if ($_FILES['anak_file']) {
		// 	$fileanak = $this->upload_multiple_file_dir($_FILES['anak_file'],'webfile/cv/','anak-');
		// }
		foreach ($post['anak_nama'] as $key => $value) {
			$arrayanak = array(
				'nama' => $post['anak_nama'][$key],
				'tempat_lahir' => $post['anak_tempat_lahir'][$key],
				'tanggal_lahir' => $post['anak_tanggal_lahir'][$key],
				'jenis_kelamin' => $post['anak_jenis_kelamin'][$key],
				'pekerjaan' => $post['anak_tanggal_pekerjaan'][$key],
				'keterangan' => $post['anak_tanggal_keterangan'][$key],
				'file' => array()
			);
			foreach ($post['anak_nama_file_' . $key] as $f => $nama_file) {
				$dokumen = $post['anak_old_' . $key][$f];
				if (!empty($_FILES['anak_file_' . $key . '_' . $f])) {
					$dokumen = $this->upload_file_dir('anak_file_' . $key . '_' . $f, 'webfile/cv/', 'anak-' . (md5('smartsoftstudio') . rand(1000, 100000)))['message']['dir'];
				}
				if (!empty($nama_file) && !empty($dokumen)) {
					$arrayanak['file'][] = array(
						'nama_file' => $nama_file,
						'file' => $dokumen
					);
				}
			}
			$group_arrayanak[] = $arrayanak;
		}

		$post['dt']['cv_gelar_akademik'] = json_encode($post['akademik']);
		$post['dt']['cv_permintaan_posisi_direktur'] = json_encode($post['posisi_direktur']);
		$post['dt']['cv_riwayat_jabatan'] = json_encode($group_arrayriwayat_jabatan);
		$post['dt']['cv_penugasan'] = json_encode($group_arraypenugasan);
		$post['dt']['cv_organisasi_pekerjaan'] = json_encode($group_arrayorganisasi_pekerjaan);
		$post['dt']['cv_organisasi_nonformal'] = json_encode($group_arrayorganisasi_nonformal);
		$post['dt']['cv_penghargaan'] = json_encode($group_arraypenghargaan);
		$post['dt']['cv_pendidikan_formal'] = json_encode($group_arraypendidikan_formal);
		$post['dt']['cv_diklat_jabatan'] = json_encode($group_arraydiklat_jabatan);
		$post['dt']['cv_diklat_fungsional'] = json_encode($group_arraydiklat_fungsional);
		$post['dt']['cv_karya_tulis'] = json_encode($group_arraykarya_tulis);
		$post['dt']['cv_pengalaman_pembicara'] = json_encode($group_arraypengalaman_pembicara);
		$post['dt']['cv_referensi'] = json_encode($group_arrayreferensi);
		$post['dt']['cv_pasangan'] = json_encode($group_arraypasangan);
		$post['dt']['cv_anak'] = json_encode($group_arrayanak);

		// print_r($post['dt']);
		$this->mymodel->updateData('cv', $post['dt'], array('cv_id' => $post['id']));
		// $this->mymodel->insertData('cv',$post['dt']);

		$hash_url = str_replace("#", "", $post['tab_index']);
		if ($hash_url <= 7) {
			redirect('digitalisasi_cv/detail/' . $this->template->sonEncode($post['id']) . '#' . ($hash_url + 1));
		} else {
			redirect('digitalisasi_cv');
		}
	}
	public function detail($idcv)
	{
		$idcv = $this->template->sonDecode($idcv);
		$data['page_name'] = "Detail Digitalisasi CV";
		$data['data'] = $this->mymodel->selectDataone('cv', ['cv_id' => $idcv]);
		$this->template->load('template/template', 'digitalisasi_cv/detail', $data);
	}
	public function detail_print($idcv)
	{
		$data['lokasi'] = $this->input->get('lokasi');
		if ($data['lokasi'] == '') $data['lokasi'] = 'Jakarta';
		$idcv = $this->template->sonDecode($idcv);
		$data['page_name'] = "Detail Digitalisasi CV";
		$data['data'] = $this->mymodel->selectDataone('cv', ['cv_id' => $idcv]);
		$this->load->view('digitalisasi_cv/detail-print', $data);
	}
	public function detail_excel($idcv)
	{
		$idcv = $this->template->sonDecode($idcv);
		$data['page_name'] = "Detail Digitalisasi CV";
		$data['data'] = $this->mymodel->selectDataone('cv', ['cv_id' => $idcv]);
		$this->load->view('digitalisasi_cv/detail-excel', $data);
	}
	public function aksiEditAkses()
	{
		$post = $this->input->post();
		$this->mymodel->deleteData('cv_akses', array('cva_id_cv' => $post['id']));
		for ($i = 0; $i < count($post['akses']); $i++) {
			$arrayinsert = array(
				'cva_id_cv' => $post['id'],
				'cva_id_user' => $post['akses'][$i],
			);
			$this->mymodel->insertData('cv_akses', $arrayinsert);
		}
		redirect('digitalisasi_cv/detail/' . $this->template->sonEncode($post['id']));
	}
}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */