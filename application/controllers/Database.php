<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Database extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function playground()
	{

		$data['table_list']	=	$this->db->query("
			SELECT TABLE_NAME AS _tables 
			FROM INFORMATION_SCHEMA.TABLES 
			WHERE TABLE_SCHEMA = 'sop_clean'")->result_array();  
		$data['page_name'] 	=	"access";
		$this->template->load('template/template','database/playground',$data);
	}

	public function ajaxLoadTable()
	{
		$nama_table = $this->input->get('table');


		$this->db->select("*");
		$this->db->from($nama_table);
		$data['data_table'] = $this->db->get()->result_array();
		$table_header = $this->db->query("
			SELECT `COLUMN_NAME` as kolom
			FROM `INFORMATION_SCHEMA`.`COLUMNS` 
			WHERE `TABLE_SCHEMA`='sop_clean' 
    		AND `TABLE_NAME`='$nama_table'
    	")->result_array();
    	foreach($table_header as $header){
    		$data['table_header'][] = $header['kolom'];
    	}
    	$data['nama_table'] = $nama_table;

    	if($_POST){
    		$this->load->view('database/ajax_load_table_filtered',$data);
    	}else{
    		$this->load->view('database/ajax_load_table',$data);	
    	}
		
	}

	public function ajaxLoadFilter()
	{
		$nama_table = $this->input->get('table');		
		$table_header = $this->db->query("
			SELECT `COLUMN_NAME` as kolom
			FROM `INFORMATION_SCHEMA`.`COLUMNS` 
			WHERE `TABLE_SCHEMA`='sop_clean' 
    		AND `TABLE_NAME`='$nama_table'
    	")->result_array();
    	foreach($table_header as $header){
    		$data['table_header'][] = $header['kolom'];
    	}

    	$data['nama_table'] = $nama_table;

    	$this->load->view('database/ajax_load_filter',$data);
	}

}