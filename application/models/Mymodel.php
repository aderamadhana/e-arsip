<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mymodel extends CI_Model {

		public function __construct()
		{
			$this->load->database(); 
		}

		public function selectData($table)
		{
			
			$query = $this->db->get($table);
			return $query->result_array();
		}

		public function selectWithQuery($str)
    	{
			
    		$query = $this->db->query($str);
    		return $query->result_array();
    	}


		public function selectWhere($table,$where)
		{
				
				$query = $this->db->get_where($table,$where);
				return $query->result_array();
		 }

		public function selectDataone($table,$where)
		{

				$query = $this->db->get_where($table,$where);
				return $query->row_array();
		}

		public function deleteData($table,$id)
		{

			
			$this->db->where($id);
			$cekdata = $this->db->get($table)->result_array();
			// echo $this->db->last_query();
			$datajson ='';
			foreach ($cekdata as $key => $value) {
				$datajson = $datajson.json_encode($value);
			}

			if(count($cekdata) > 0){
			$datalog = array(
				'log_created_at' => date('Y-m-d H:i:s'),
				'log_created_by' => $this->session->userdata('id'),
				'log_action' => 'deleteData',
				'log_tablename' => $table,
				'log_jsondata' => $datajson,
			);

			$resultlog = $this->db->insert('log_aktivitas',$datalog);

			$this->db->where($id);
			$result = $this->db->delete($table);
			return true;

			}else{

			return  false;
			
			}
			
		}

		public function insertData($table,$data)
		{

			$datalog = array(
				'log_created_at' => date('Y-m-d H:i:s'),
				'log_created_by' => $this->session->userdata('id'),
				'log_action' => 'insertData',
				'log_tablename' => $table,
				'log_jsondata' => json_encode($data),
			);

			$resultlog = $this->db->insert('log_aktivitas',$datalog);

			$result = $this->db->insert($table,$data);

			return $result;
		}


		public function updateData($table,$data,$where)
		{
			$this->db->where($where);
			$cekdata = $this->db->get($table)->result_array();

			$datajson ='';
			foreach ($cekdata as $key => $value) {
				$datajson = $datajson.json_encode($value);
			}

			if(count($cekdata) > 0){
			$datalog = array(
				'log_created_at' => date('Y-m-d H:i:s'),
				'log_created_by' => $this->session->userdata('id'),
				'log_action' => 'updateData',
				'log_tablename' => $table,
				'log_jsondata' => $datajson,
			);

			$resultlog = $this->db->insert('log_aktivitas',$datalog);

			$result = $this->db->update($table,$data,$where);

			// return $this->alert->alertsuccess('Success Update Data');
				return true;

			}else{

				// return  $this->alert->alertdanger("ID data tidak ditemukan");
				return false;
			}


		}

}