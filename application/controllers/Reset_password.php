<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_password extends MY_Controller {

	public function index()
	{
		$token = $this->input->get('token');
		if ($token) {			
			$query = $this->mmodel->selectWhere('user',['token'=>$token])->row();
			if ($query) {
				$data['data'] = $query;
				$this->load->view('login/reset-password', $data);
			} else {
				echo 'Token not found';
			}
		} else {
			echo 'Token not found';
		}
	}



	public function proceed()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
    	$password = $this->input->post('password');
    	if($password!=""){
			$this->form_validation->set_rules('password', '<strong>Password</strong>', 'required|min_length[6]');
			$this->form_validation->set_rules('password_confirmation_field', 'Password Confirmation Field', 'required|matches[password]');
    	}

    	if ($this->form_validation->run() == FALSE){
			$error =  validation_errors();
			$this->alert->alertdanger($error);
             
        }else{
        	$id = $this->template->sonDecode($this->input->post('ids'));
        	if($password!=""){
	        	$dt['password'] = md5($password);
        	}
			$dt['updated_at'] = date("Y-m-d H:i:s");
			$dt['token'] = "";
			// print_r($dt);
			$this->mmodel->updateData('user', $dt , array('id'=>$id));
			$this->alert->alertsuccess('Success Update Data');  
        }
	}
}

/* End of file reset_password.php */
/* Location: ./application/controllers/reset_password.php */