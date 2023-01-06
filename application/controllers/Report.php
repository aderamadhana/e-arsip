<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Report extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data['page_name'] = "Report Slot Nomor";
		// $data['view_menu'] = $this->view_menu();
		$this->template->load('template/template', 'report/index', $data);
	}
	public function json()
	{
		// $this->datatables->join('user', 'user.id = arsip_dokumen.dari', 'left');
		if (!empty($_GET['kategori'])) {
			$this->datatables->where('arsip_dokumen.ad_kategorisurat_id', $_GET['kategori']);
		}
		if ($this->session->userdata('role_slug') != 'super_admin') {
			$this->datatables->where('ad_departemen', $this->session->userdata('departement'));
		}
		$this->datatables->where('arsip_dokumen.ad_tipesurat', 'Surat Keluar');
		$this->datatables->select('arsip_dokumen.ad_id,arsip_dokumen.ad_tandatangan,arsip_dokumen.ad_nomorsurat,arsip_dokumen.ad_perihal,arsip_dokumen.ad_signer,arsip_dokumen.ad_pic,arsip_dokumen.ad_notelp,arsip_dokumen.ad_dikirim,arsip_dokumen.ad_tandatangan,arsip_dokumen.ad_tanggalsurat,DATE_FORMAT(arsip_dokumen.ad_tanggalsurat, "%d %M %Y") AS tanggal_surat,ad_is_booking');
		$this->datatables->from('arsip_dokumen');
		$this->datatables->where('status !=', 'dihapus');
		$this->datatables->where('ad_is_booking', '1');
		$this->datatables->add_column('view', '<div class="btn-toolbar"> <button onclick="deleteSurat($1)" class="btn btn-xs btn-danger" style="font-size:14px"><i class="fa fa-trash"></i> Delete</button> </div>', 'ad_id');
		echo $this->datatables->generate();
	}
}
