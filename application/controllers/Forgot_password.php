<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends MY_Controller {

	public function index()
	{
		  $this->load->view('login/forgot-password');
	}

	public function proceed()
	{
		$email = $this->input->post('email');

		$query = $this->mmodel->selectWhere('user',['email'=>$email])->row();
		if ($query) {
			$token = $this->template->sonEncode($query->id.date("Ymdhis")); 
			$data['data'] = $query;
			$data['token'] = $token;

			
			
			$user = $this->mymodel->selectDataone('user',['id'=>$query->id]);
			$active = date("Y-m-d H:i:s", strtotime('+5 minutes',strtotime($user['last_email'])));
			if(date('Y-m-d H:i:s')>$active){
				$this->mymodel->updateData('user',['token'=>''],['id'=>$user['id']]);
			}

			$user = $this->mymodel->selectDataone('user',['id'=>$query->id]);

			if($user['token']==""){
				$this->mmodel->updateData("user",['token'=>$token,'last_email'=>date('Y-m-d H:i:s')],['id'=>$query->id]);
				$message = $this->load->view('login/forgot-password-email-template', $data,true);
				$email = $this->template->sendEmail($email,"Reset Password",$message);
				if ($email) {
					$this->alert->alertsuccess('Success, check your inbox to reset your password');
				} else {
					$this->alert->alertdanger('Failed, please try again');
				}
			}else{
				
				
				$this->alert->alertdanger('Email has been sent , wait five more minutes for resend');


			}
			
		} else {
			$this->alert->alertdanger('Email not found, please check your email correctly');
		}

	}
	public function jancuk()
	{
		$email = "bayubriyanelroy@gmail.com";
		$message = $this->load->view('login/forgot-password-email-template', $data,true);

		 $this->template->sendEmail($email,"Reset Password",$message);

		# code...
	}
}

/* End of file forgot_passoword.php */
/* Location: ./application/controllers/forgot_passoword.php */