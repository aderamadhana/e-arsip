<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_cloud extends MY_Controller {

	public function index()
	{
		
		$data['page_name'] = "home";
		$this->template->load('template/template','upload-cloud/index',$data);
	}

	public function prosesUploadCloud()
	{
		$upload = $this->uploadFiletoCloud($_FILES['file']);
		redirect('upload-cloud','refresh');
	}

	public function ajaxUploadCloud()
	{
		$upload = $this->uploadFiletoCloud($_FILES['file']);

		echo $upload;
	}

	public function prosesCreateFolder()
	{
		// print_r($this->input->post());
		$nama_folder = $this->input->post('name');
		$folderid = $this->input->post('folderid');
		$result = $this->createFolderCloud($nama_folder,$folderid);
		redirect('upload-cloud','refresh');
		// echo $result;
	}

	public function getList($id)
	{
		$data = $this->getListCloud($id);
		echo $data;
	}

	public function getFile($id)
	{
		if($this->session->userdata('session_sop')=="") {
            redirect('login/');
    	}else{
    		// $this->load->helper('download');
			$data = $this->getFileCloud($id);
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $data,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			  CURLOPT_HEADER=> 1
			));

			$response = curl_exec($curl);
			$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
			$header = substr($response, 0, $header_size);
			$body = substr($response, $header_size);
			$reDispo = '/^Content-Disposition: .*?filename=(?<f>[^\s]+|\x22[^\x22]+\x22)\x3B?.*$/m';
		      if (preg_match($reDispo, $header, $mDispo))
		      {
		        $filename = trim($mDispo['f'],' ";');
		        header('Cache-Control: public'); 
				header('Content-type: application/pdf');
				header('Content-Disposition: attachment; filename="'.$filename.'"');
				header('Content-Length: '.strlen($body));
				echo $body;
		      }
			// echo $header;
			// redirect($data);
			// redirect($data,'refresh');
			// force_download($data,NULL);
			// echo '<iframe src="'.$data.'"></iframe> <script>window.setTimeout(function(){window.close();}, 1000);</script>';
    	}
	}

}

/* End of file upload_cloud.php */
/* Location: ./application/controllers/upload_cloud.php */