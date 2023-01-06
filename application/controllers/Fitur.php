<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Fitur extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}


	public function spread()
	{

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="testi.xlsx"');
	header('Cache-Control: max-age=0');

	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();
	$sheet->setCellValue('A1', 'Hello World !');

	$writer = new Xlsx($spreadsheet);
	ob_end_clean();
	$writer->save('php://output');
	}



	public function ekspor($table)
	{
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
		->setCreator('Smartsoft Studio')
		->setLastModifiedBy('Smartsoft Studio')
		->setTitle("Master ".$table)
		->setSubject("".$table)
		->setDescription("Master ".$table)
		->setKeywords("Master ".$table);
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
		$style_row = array(
			'alignment' => array(
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), 
				'right' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  
				'bottom' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), 
				'left' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) 
			)
		);
		$style_row2 = array(
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), 
				'right' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  
				'bottom' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), 
				'left' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) 
			)
		);

		$structure_query = "SELECT COLUMN_NAME,COLUMN_KEY,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".$this->db->database."' AND TABLE_NAME='".$table."'";
        $structure = $this->mymodel->selectWithQuery($structure_query);
        $urut = 0;
        foreach ($structure as $stt) {
        	$abjad = $this->template->getNameFromNumber($urut);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue($abjad.'1', $stt['COLUMN_NAME']); 
		$urut++;
		}
	 	$urut = 0;
        foreach ($structure as $stt) {
        	$abjad = $this->template->getNameFromNumber($urut);
			$spreadsheet->getActiveSheet()->getStyle($abjad.'1')->applyFromArray($style_col);
    	$urut++;
		}
			$rec = $this->mymodel->selectData($table);
			$no = 1; 
			$numrow = 2; 
			foreach($rec as $dt){
				$urut = 0;
		        foreach ($structure as $stt) {
		        	$abjad = $this->template->getNameFromNumber($urut);
					$spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit($abjad.$numrow,  $dt[$stt['COLUMN_NAME']],(is_numeric($dt[$stt['COLUMN_NAME']]) ? \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC : \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING ) );
		    	$urut++;
				}
				$urut = 0;
		        foreach ($structure as $stt) {
		        	$abjad = $this->template->getNameFromNumber($urut);
					$spreadsheet->getActiveSheet()->getStyle($abjad.$numrow)->applyFromArray($style_row);
		        	$urut++;
				}
				$no++; 
				$numrow++; 
			}
			$urut = 0;
	        foreach ($structure as $stt) {
        	$abjad = $this->template->getNameFromNumber($urut);
			$spreadsheet->getActiveSheet()->getColumnDimension($abjad)->setAutoSize(TRUE); 
        	$urut++;
        	}
			$spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
			$spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$spreadsheet->getActiveSheet(0)->setTitle("Master ".$table);
			$spreadsheet->setActiveSheetIndex(0);
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="'.$table.'.xlsx"');
			header('Cache-Control: max-age=0');
			$writer = new Xlsx($spreadsheet);
			ob_end_clean();
			$writer->save('php://output');
	}

	public function impor($table)
	{
		# code...
       	ini_set('max_execution_time', 30000);
		$config['upload_path']          = 'webfile/';
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['file_name']            = md5($table).'.xlsx';
		$config['overwrite']            =  TRUE;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('file'))
		{
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
		}
		else
		{
			$data = array('file' => $this->upload->data());
			$this->importdata($table);
		}
	}
	public function importdata($table)
	{
		# code...
	//    $this->load->library('excel');
		$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		
	   
		try 
		{
			$spreadsheet = $reader->load('webfile/'.md5($table).'.xlsx');
		}
		catch(Exception $e)
		{
			$this->resp->success = FALSE;
			$this->resp->msg = 'Error Uploading file';
			echo json_encode($this->resp);
			exit;
		}


		// $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null,true,true,true);

        $query = "SELECT COLUMN_NAME,COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".$this->db->database."' AND TABLE_NAME='".$table."' AND COLUMN_KEY = 'PRI'";
        $pri = $this->mymodel->selectWithQuery($query);
        $primary = $pri[0]['COLUMN_NAME'];
        $header = $allDataInSheet[1];
			$i=1;
			$record=0;
			foreach($allDataInSheet as $aa=>$import){
                if($i>1){
                	$j = 0; 
					foreach ($import as $key => $value) {
		        	$abjad = $this->template->getNameFromNumber($j);
		        		$kolom = $header[$abjad]; 
		        		if($kolom==$primary){
		        			$update[$record][$kolom] = $value;  
		        		}else{
		        			$update[$record]['data'][$kolom] = $value;  
		        		}
	       			$j++;
	       			}  
	       			$record++;         			
                }
           	$i++;
            }
            foreach ($update as $k => $to_table) {
            	$cekdata = $this->mymodel->selectDataone($table,array($primary=>$to_table[$primary]));
            	if(count($cekdata)==0){
            		$this->mymodel->insertData($table,$to_table['data']);
            	}else{
            		$this->mymodel->updateData($table,$to_table['data'],array($primary=>$to_table[$primary]));
            	}
            }
            redirect ('master/'.$table);
	}
	
	public function access()
	{
		# code...
		$this->db->truncate('access_control');
		// print_r($ci);
		$file = $this->get_uri();
		foreach ($file['file'] as $controller) {
			$con[] = $controller;
			$fol[] = '';
		}
		foreach ($file['folder'] as $folder) {
			$files = $this->get_uri('/'.$folder);
			foreach ($files['file'] as $controller) {
				$con[] = $controller;
				$fol[] = $folder.'/';
			}
		}
		$i=0;
		foreach ($con as $ctrl) {
			if($fol[$i]!="api/"){
	    		include_once APPPATH . 'controllers/' . $fol[$i] .$ctrl;
	    		$methods = get_class_methods( str_replace( '.php', '', $ctrl ) );
	    		foreach ($methods as $mt) {
	    			$data = array(
	    						'folder'=>str_replace("/","",$fol[$i]),
	    						'class'=>str_replace( '.php', '', $ctrl ),
	    						'method'=>$mt,
	    						'val'=>strtolower($fol[$i].str_replace( '.php', '', $ctrl )."/".$mt),
	    					);
	    			$cek = $this->mymodel->selectDataone('access_control',$data);
	    			if(count($cek)==0){
						$this->db->insert('access_control', $data);
	    			}else{
	    				$this->mymodel->updateData('access_control',$data,array('id'=>$cek['id']));
	    			}
	    		}
	    	}
		$i++;
		}
		$json = $this->mymodel->selectData('access_control');
		echo json_encode($json);
	}


	function exportreport()
	{
		$data = $this->session->flashdata('report');
		// print_r($data);
		$this->excel->to_file($data['judul'],$data['head'],$data['data']);
	}

	public function testEncrypt()
	{
		error_reporting(-1);
		ini_set('display_errors', 1);
		$filename = uniqid().'-'.substr($_FILES['file']['name'], 0, strrpos($_FILES['file']['name'], "."));
		$fileupload = $this->upload_file_dir('file','webfile/',$filename);
		// die(dump_variable($fileupload));
		$this->encryptPDF($fileupload['message']['dir'],'testing',$fileupload['message']['dir']);
	}

	public function pdf_form()
	{
		$this->load->view('test');
	}


	public function uploadPDF($filename)
	{
		$fileupload = $this->upload_file_dir('file','webfile/',$filename,true);
	}

}
/* End of file Fitur.php */
/* Location: ./application/controllers/Fitur.php */