<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use setasign\FpdiProtection\FpdiProtection;

require_once($_SERVER['DOCUMENT_ROOT'].str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']).'/application/third_party/fpdf/fpdf.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']).'/application/third_party/fpdi/src/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'].str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']).'/application/third_party/fpdi-protection/src/autoload.php');

abstract class MY_Controller extends CI_Controller{

	public function __construct() {
		parent::__construct();
        $this->core = & get_instance();
		date_default_timezone_set("Asia/Jakarta");
		$folder = $this->router->directory;
		$class = $this->router->class;
		$method = $this->router->method;
		$role = $this->session->userdata('role_id');
		if($folder==""){
			$link = $class."/".$method;
		}else{
			$link = $folder.$class."/".$method;
		}
		
		// $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));


		// if($this->session->userdata('session_sop')==true){
		// 	$get_link = $this->mymodel->selectDataone('access_control',array('val'=>$link));
		// 	$cek = $this->mymodel->selectWhere('access',array('access_control_id'=>$get_link['id'],'role_id'=>$role));
		// 	if($link!=""){
		// 		if(count($cek)==0){
		// 			// redirect('/');
		// 		}	
		// 	}

  //       	$check_restricting = $this->mmodel->selectWhere('access_block',['ab_role_id'=>$role,'ab_link'=>$link])->num_rows();
  //       	if ($check_restricting) {
  //       		redirect('restricted');
  //       	}
		// }


		$this->konfig();
		
		// JIKA INGIN MENGAKTIFKAN LOG AKTIVITAS
		// $this->log_activity();
		define('KEY', '!2261%^^&!*&@**@#&');
		define('IV', '**#$7843874^^&$*#&7');
	}

	function konfig()
	{
		$konfig = $this->mymodel->selectData('konfig');
		foreach ($konfig as $knf) {
			define($knf['slug'], $knf['value']);
		}
	}

	public function get_uri($folder="")
	{
		# code...
		if($folder!="api/"){
			$dir    =  dirname(__FILE__) .'/../controllers'.$folder;
			$files1 = scandir($dir);
			foreach ($files1 as $file) {
				$a = $file;
				if (strpos($a, '.php') !== false) {
				    $data['file'][] = $a;
				}else{
					if($a!="." AND $a!=".." AND strpos($a, '.') === false)
				    $data['folder'][] = $a;
				}
			}
			return $data;
		}
	}

	public function button_restrict($role,$type="allow") // $type diisi allow atau restrict
	{
		$me = $this->session->userdata('role_slug');

		if ($type=="allow") {
			if (in_array($me, $role)) {
				$return = "allow";
			} else {
				$return = "restricted";
			}
		} elseif ($type=="restrict") {
			if (in_array($me, $role)) {
				$return = "restricted";
			} else {
				$return = "allow";
			}
		}

		return $return;
	}
	public function upload_file_dir($files,$dir='uploads/',$namafile='',$overwrite=false) {
		// cara memanggil
		// $hasil = $this->upload_file('file','webfile/dokumen');
		// print_r($hasil);
		if ($namafile=='') {
			$namafile = md5('smartsoftstudio').rand(1000,100000);
		}
		$config['upload_path']          = $dir;
		$config['allowed_types']        = '*';
		$config['max_size'] 			= '64000';
		$config['file_name']           	= $namafile;
		$config['overwrite']            = $overwrite;
		if (!is_dir($dir)) {
		    mkdir('./'.$dir, 0777, TRUE);

		}
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload($files)){
			$msg['response'] = false;
			$msg['message'] = $this->upload->display_errors();
		}else{
			$file = $this->upload->data();
			$data = array(
		   				'name'=> $file['file_name'],
		   				'mime'=> $file['file_type'],
		   				'dir'=> $dir.$file['file_name'],
		   				'full_path'=>$file['full_path']
		   	 		);
			$msg['response'] = true;
			$msg['message'] = $data;
		}
		return $msg;
	}
	public function upload_multiple_file_dir($files,$dir='uploads/',$prefixname='') {
		if ($namafile=='') {
			$namafile = md5('smartsoftstudio').rand(1000,100000);
		}
		$config['upload_path']          = $dir;
		$config['allowed_types']        = '*';
		$config['max_size'] 			= '2000';
		if (!is_dir($dir)) {
		    mkdir('./'.$dir, 0777, TRUE);

		}
		$this->load->library('upload', $config);
		foreach ($files['name'] as $key => $image) {
            $_FILES['file']['name']     = $files['name'][$key]; 
            $_FILES['file']['type']     = $files['type'][$key]; 
            $_FILES['file']['tmp_name'] = $files['tmp_name'][$key]; 
            $_FILES['file']['error']     = $files['error'][$key]; 
            $_FILES['file']['size']     = $files['size'][$key]; 
                
            $config['file_name'] = $prefixname.''.$files['name'][$key];
            $this->upload->initialize($config);
            
            if($this->upload->do_upload('file')) {
                $data = $this->upload->data();
                $msg['dir'][] = $dir.$data['file_name'];
            }else{
                $error =  $this->upload->display_errors();
            }   
        }
        return $msg;
	}
	public function uploadFiletoCloud($files,$folder="")
	{
		// return print_r($files);ajaxUploadCloud
		// echo $files['tmp_name'];
		// echo "<br>";
		// echo $files['name'];

		if ($folder=="") {
			$folder="1";
		}
		$url = "http://repo.alfahuma.tech/files/v1/file/upload/".$folder."?apikey=".API_KEY_CLOUD; // angka 1 setelah upload/ adalah id folder
		if (function_exists('curl_file_create')) { // php 5.5+
		  $cFile = curl_file_create($files['tmp_name']);
		} else { // 
		  $cFile = '@' . realpath($files['tmp_name']);
		}
		// echo "<br>";
		// echo $cFile;
		$post = array('name' => $files['name'],'data' => $cFile);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST,true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Type: multipart/form-data")
		);
 
		$result=curl_exec ($ch);
		curl_close ($ch);

		return $result;
	}

	public function uploadFileFromServerToCloud($file,$folder="")
	{
		$exfile = explode('/', $file);
		$filename = $exfile[count($exfile)-1];
		// $tmp_name = tempnam($file, 'php');
		$fullpath = APPPATH."../".$file;

		// echo $tmp_name;
		// echo "<br>";
		// echo $filename;
		if ($folder=="") {
			$folder="1";
		}
		$url = "http://repo.alfahuma.tech/files/v1/file/upload/".$folder."?apikey=".API_KEY_CLOUD; // angka 1 setelah upload/ adalah id folder
		if (function_exists('curl_file_create')) { // php 5.5+
		  $cFile = curl_file_create($fullpath);
		} else { // 
		  $cFile = '@' . realpath($fullpath);
		}
		// print_r($cFile);
		// echo "<br>";
		// echo $cFile;
		$post = array('name' => $filename,'data' => $cFile);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST,true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Type: multipart/form-data")
		);
 
		$result=curl_exec ($ch);
		curl_close ($ch);

		return $result;
	}
	public function getFileCloud($idfiles)
	{
		// return print_r($files);
		$url = "http://repo.alfahuma.tech/files/v1/file/download/".$idfiles."?apikey=".API_KEY_CLOUD;
		return $url;
	}

	public function renameFileCloud($data)
	{
		$url = "http://repo.alfahuma.tech/files/v1/object/rename/".$data['id']."?apikey=".API_KEY_CLOUD;
		$post = [
			'name' =>$data['name']
		];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST,true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Type: multipart/form-data")
		);
 
		$result=curl_exec ($ch);
		curl_close ($ch);

		// return $result;
	}

	public function encryptPDF($original_file,$password,$destination_file)
	{
		$pdf = new FpdiProtection();
		$pagecount = $pdf->setSourceFile($original_file);

		for ($loop = 1; $loop <= $pagecount; $loop++) {
		$tplidx = $pdf->importPage($loop);
		$pdf->addPage();
		$pdf->useTemplate($tplidx);
		}

		// protect the new pdf file, and allow no printing, copy etc and leave only reading allowed
		$pdf->SetProtection(array(), $password, '');
		$pdf->Output($destination_file, 'F');
		return $destination_file;
	}

	public function checkAndConvertPDF($file_path)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'dev.alfahuma.tech/pdf_convert/fitur/uploadPDF_dev',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($file_path)),
		));

		$response = curl_exec($curl);
		return $response;
	}
	

}