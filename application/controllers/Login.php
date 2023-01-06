<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        $data = [];
        if(CAPTCHA==0){
        $files = glob('./captcha/*'); // get all file names
        foreach($files as $file)
        { 
        // iterate files
        if(is_file($file))
            @unlink($file); // delete file
        }

        $options = array(
            'img_path'=>'./captcha/', #folder captcha yg sudah dibuat tadi
            'img_url'=>base_url('captcha'), #ini arahnya juga ke folder captcha
            'img_width'=>'130', #lebar image captcha
            'img_height'=>'35', #tinggi image captcha
            'expiration'=>7200, #waktu expired
            'word_length'   => 5, #panjang capthca
            // 'font_path' => FCPATH . 'assets/font/coolvetica.ttf', #load font jika mau ganti fontnya
            'pool' => '123456789ABCDEFGHJKLMNPQRSTUVWXYZ', #tipe captcha (angka/huruf, atau kombinasi dari keduanya)
     
            # atur warna captcha-nya di sini ya.. gunakan kode RGB
            'colors' => array(
                    'background' => array(242, 242, 242),
                    'border' => array(255, 255, 255),
                    'text' => array(0, 0, 0),
                    'grid' => array(200,200,200)),
                    'font_size' => 10
               );
        $cap = create_captcha($options);
        $data['image'] = $cap['image'];
        $this->session->set_userdata('mycaptcha', $cap['word']);
        $data['word'] = $this->session->userdata('mycaptcha');
        }


        if(LOGIN==0){
		  $this->load->view('login/login',$data);
        }else{
          $this->load->view('login/login-1',$data);
        }
    }
    

    public function register()
    {
        $data = [];
        if(CAPTCHA==0){
        $files = glob('./captcha/*'); // get all file names
        foreach($files as $file)
        { 
        // iterate files
        if(is_file($file))
            @unlink($file); // delete file
        }

        $options = array(
            'img_path'=>'./captcha/', #folder captcha yg sudah dibuat tadi
            'img_url'=>base_url('captcha'), #ini arahnya juga ke folder captcha
            'img_width'=>'130', #lebar image captcha
            'img_height'=>'35', #tinggi image captcha
            'expiration'=>7200, #waktu expired
            'word_length'   => 5, #panjang capthca
            // 'font_path' => FCPATH . 'assets/font/coolvetica.ttf', #load font jika mau ganti fontnya
            'pool' => '123456789ABCDEFGHJKLMNPQRSTUVWXYZ', #tipe captcha (angka/huruf, atau kombinasi dari keduanya)
     
            # atur warna captcha-nya di sini ya.. gunakan kode RGB
            'colors' => array(
                    'background' => array(242, 242, 242),
                    'border' => array(255, 255, 255),
                    'text' => array(0, 0, 0),
                    'grid' => array(200,200,200)),
                    'font_size' => 10
               );
        $cap = create_captcha($options);
        $data['image'] = $cap['image'];
        $this->session->set_userdata('mycaptcha', $cap['word']);
        $data['word'] = $this->session->userdata('mycaptcha');
        }
        
        $data_jabatan = [];
        $this->db->select('jabatan.id,jabatan.role_id,role.role,jabatan.jabatan');
		$this->db->join('role', 'jabatan.role_id = role.id', 'left');
		$this->db->where('jabatan.status', 'ENABLE');
		$list_master_jabatan = $this->db->get('jabatan')->result_array();
		foreach($list_master_jabatan as $master_jabatan){
			$data_jabatan[$master_jabatan['role']][] = [
				'id'=>$master_jabatan['id'],
				'jabatan'=>$master_jabatan['jabatan']
			];
		}
		
		$data['encoded_json_jabatan'] = json_encode($data_jabatan);
		  $this->load->view('login/register',$data);

    }

	public function logout()
	{
        if(ONE_TIME_LOGIN==0){
            $otl = $this->session->userdata('session_otl');
            $ip = $this->session->userdata('ip_address');
            $id = $this->session->userdata('id');
            
            $user = $this->mymodel->selectDataone('user',['id'=>$id]);
            $log = $this->mymodel->selectDataone('session_login',['date'=>$this->template->sonDecode($user['session_id']),'user_id'=>$id]);
                if($log['ip_address']==$ip){
                    // redirect('login/logout','refresh');
                    $this->mymodel->deleteData('session_login',['user_id'=>$id]);
                    $this->mymodel->updateData('user',['session_id'=>''],['id'=>$id]);
                }    
        }
        $this->session->sess_destroy();
        if(ONE_TIME_LOGIN==0){
            if($log['ip_address']==$ip){
        		redirect('login','refresh');
            }else{
                redirect('login/redirect_otl?ip='.$log['ip_address'],'refresh');
            }
        }else{
    		redirect('login','refresh');
        }
    }
    
    public function redirect_otl()
    {
        $ip = $this->input->get('ip');
        $this->session->set_flashdata('message','Last login account ip : '.$ip);  
		redirect('login','refresh');

    }

    public function jumperLogin($id)
    {
        $id = $this->template->sonDecode($id);
        $user = $this->mymodel->selectDataone('user',array('id'=>$id));
        $username = $user['username'];
        $pass = $user['password'];

        $cek = $this->mlogin->login($username,$pass);
        $session = $this->mlogin->data($username);

        if ($cek > 0) {
            // $this->session->sess_destroy();

            $this->session->set_userdata('session_sop', true);
            $this->session->set_userdata('id', $session->id);
            $this->session->set_userdata('username', $session->username);
            $this->session->set_userdata('role_id', $session->role_id);
            $this->session->set_userdata('role_slug', $session->role_slug);
            $this->session->set_userdata('role_name', $session->role_name);
            $this->session->set_userdata('name', $session->name);
            $this->session->set_userdata('jabatan', $session->jabatan);
            $this->session->set_userdata('departement', $session->departemen); 
            if ($session->komite_id != '') {
                $array_komite = explode(",", $session->komite_id);
                $this->session->set_userdata('komite_id', $array_komite);
            }else{
                $this->session->set_userdata('komite_id', NULL);
            }

            if(ONE_TIME_LOGIN==0){
                $date = date('Y-m-d H:i:s');
                $log = [
                    'date'=>$date,
                    'ip_address'=>$_SERVER['REMOTE_ADDR'],
                    'user_id'=>$session->id
                ];


                if(date('Y-m-d',strtotime($this->template->sonDecode($session->session_id)))<date('Y-m-d')){
          
                    $this->mymodel->deleteData('session_login',$log,['user_id'=>$session->id]);
                    $this->mymodel->insertData('session_login',$log);
                    $this->mymodel->updateData('user',['session_id'=>''],['id'=>$session->id]);                        
                }

                $ceklog = $this->mymodel->selectDataone('session_login',['ip_address'=>$_SERVER['REMOTE_ADDR']]);

                if(!$ceklog){
                    $this->mymodel->insertData('session_login',$log);
                }else{
                    $date = $ceklog['date'];
                }

                $u = $this->mymodel->selectDataone('user',['id'=>$session->id]);
                if($u['session_id']==""){
                    $this->mymodel->updateData('user',['session_id'=>$this->template->sonEncode($date)],['id'=>$session->id]);                        
                }


                $this->session->set_userdata('session_otl', $date);
                $this->session->set_userdata('ip_address', $_SERVER['REMOTE_ADDR']);
            }
        }

        redirect('home','refresh');
    }

	public function act_login()
    {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $pass = md5($password);

            if(CAPTCHA==0){
                $word = $this->session->userdata('mycaptcha');
                $captcha = $this->input->post('captcha');
                if (isset($captcha)) {
                    if (strtoupper($captcha)!=strtoupper($word)) {
                        $this->alert->alertdanger('Check captcha');
                        return FALSE;
                    }
                }
            }

            if(FAIL_ATTEMP==0){
                $users = $this->mymodel->selectDataone('user',['username'=>$username]);
                if($users){
                    if($users['is_login']==0){
                        $this->alert->alertdanger('Your account is not activated.');
                        return FALSE;
                    }

                    if($users['wrong']>=5){
                        if(date('Y-m-d H:i:s')<$users['active']){
                            $this->alert->alertdanger('Account will be temporarily disabled, login failed for five times. the account will be active at '.$users['active']);
                            return FALSE;

                        }else{
                            $this->mymodel->updateData('user',['wrong'=>0],['id'=>$users['id']]);
                        }
                    }

                    if($users['password']!=$pass){
                        $count = $users['wrong']+1;
                        $update['wrong'] = $count;
                        if($count==5)  $update['active'] = date("Y-m-d H:i:s", strtotime('+5 minutes'));
                        $this->mymodel->updateData('user',$update,['id'=>$users['id']]);
                    }
                }else{
                    
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $data = $this->mymodel->selectWithQuery("SELECT count(ip_address) AS failed_login_attempt FROM failed_login WHERE ip_address = '$ip'  AND DATE(`date`) = '".date('Y-m-d')."'");
                    $ceklogin = $this->mlogin->login($username,$pass);
                    if($data[0]['failed_login_attempt']>=5){
                        $this->db->order_by('id desc');
                        $ac = $this->mymodel->selectDataone('failed_login',['ip_address'=>$ip]);
                        $active = date("Y-m-d H:i:s", strtotime('+5 minutes',strtotime($ac['date'])));
                        if(date('Y-m-d H:i:s')<$active){
                            $this->alert->alertdanger('IP address will be temporarily disabled, login failed for five times. the account will be active at '.$active);
                            return FALSE;
                        }else{
                            $this->mymodel->deleteData('failed_login',['ip_address'=>$ip]);
                        }
                    }
                    
                    if (!$ceklogin) {
                        $this->mymodel->insertData('failed_login',['ip_address'=>$ip,'date'=>date('Y-m-d H:i:s')]);
                    }

                }
            }
            
            

            $cek     = $this->mlogin->login($username,$pass);
            $session = $this->mlogin->data($username);


            if(EMAIL_VERIFICATION==0){
                // send email
                if($session->is_email==1){
                    $this->alert->alertdanger('Account is not yet active, please activate the account by confirming the email we sent');
                    return FALSE;
                }
            }


            if ($cek > 0) {
                $this->session->set_userdata('session_sop', true);
                $this->session->set_userdata('id', $session->id);
                $this->session->set_userdata('username', $session->username);
                $this->session->set_userdata('role_id', $session->role_id);
                $this->session->set_userdata('role_slug', $session->role_slug);
                $this->session->set_userdata('role_name', $session->role_name);
                $this->session->set_userdata('name', $session->name);
                $this->session->set_userdata('jabatan', $session->jabatan);
                $this->session->set_userdata('departement', $session->departemen);

                if ($session->komite_id != '') {
                    $array_komite = explode(",", $session->komite_id);
                    $this->session->set_userdata('komite_id', $array_komite);
                }else{
                    $this->session->set_userdata('komite_id', NULL);
                }

                if(ONE_TIME_LOGIN==0){
                    $date = date('Y-m-d H:i:s');
                    $log = [
                        'date'=>$date,
                        'ip_address'=>$_SERVER['REMOTE_ADDR'],
                        'user_id'=>$session->id
                    ];


                    if(date('Y-m-d',strtotime($this->template->sonDecode($session->session_id)))<date('Y-m-d')){
              
                        $this->mymodel->deleteData('session_login',$log,['user_id'=>$session->id]);
                        $this->mymodel->insertData('session_login',$log);
                        $this->mymodel->updateData('user',['session_id'=>''],['id'=>$session->id]);                        
                    }

                    $ceklog = $this->mymodel->selectDataone('session_login',['ip_address'=>$_SERVER['REMOTE_ADDR']]);

                    if(!$ceklog){
                        $this->mymodel->insertData('session_login',$log);
                    }else{
                        $date = $ceklog['date'];
                    }

                    $u = $this->mymodel->selectDataone('user',['id'=>$session->id]);
                    if($u['session_id']==""){
                        $this->mymodel->updateData('user',['session_id'=>$this->template->sonEncode($date)],['id'=>$session->id]);                        
                    }


                    $this->session->set_userdata('session_otl', $date);
                    $this->session->set_userdata('ip_address', $_SERVER['REMOTE_ADDR']);
                }

                echo "oke";
                return TRUE;
            } else {
                $this->alert->alertdanger('Check again your username and password');
                return FALSE;
            }
    }

    public function lockscreen()
    {
        $data = [];
        if(CAPTCHA==0){
            $files = glob('./captcha/*'); // get all file names
            foreach($files as $file)
            { 
            // iterate files
            if(is_file($file))
                @unlink($file); // delete file
            }
    
            $options = array(
                'img_path'=>'./captcha/', #folder captcha yg sudah dibuat tadi
                'img_url'=>base_url('captcha'), #ini arahnya juga ke folder captcha
                'img_width'=>'130', #lebar image captcha
                'img_height'=>'35', #tinggi image captcha
                'expiration'=>7200, #waktu expired
                'word_length'   => 5, #panjang capthca
                // 'font_path' => FCPATH . 'assets/font/coolvetica.ttf', #load font jika mau ganti fontnya
                'pool' => '123456789ABCDEFGHJKLMNPQRSTUVWXYZ', #tipe captcha (angka/huruf, atau kombinasi dari keduanya)
         
                # atur warna captcha-nya di sini ya.. gunakan kode RGB
                'colors' => array(
                        'background' => array(242, 242, 242),
                        'border' => array(255, 255, 255),
                        'text' => array(0, 0, 0),
                        'grid' => array(200,200,200)),
                        'font_size' => 10
                   );
            $cap = create_captcha($options);
            $data['image'] = $cap['image'];
            $this->session->set_userdata('mycaptcha', $cap['word']);
            $data['word'] = $this->session->userdata('mycaptcha');
        }
    
        $this->load->view('login/lockscreen',$data);
    }


    public function act_register()
    {
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        // if($this->input->post('username') != $original_value) {
            $is_unique =  '|is_unique[user.username]';
        // } else {
        //     $is_unique =  '';
        // }
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|trim'.$is_unique,
            array('is_unique'=>'This username has been registered.')
        );

        // if($this->input->post('email') != $original_value) {
            $is_unique =  '|is_unique[user.email]';
        // } else {
            // $is_unique =  '';
        // }

        $this->form_validation->set_rules('email', 'Email', 'required'.$is_unique,
            array('is_unique'=>'This e-mail has been registered.')
        );
        $this->form_validation->set_rules('password', 'Pasword', 'required|min_length[6]|callback_password_check');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('term_condition', 'Term', 'required',
            array('required'=>'You Have To Agree With Term And Condition')
        );

        

        $post = $this->input->post();
        if ($this->form_validation->run() == FALSE){
            $this->alert->alertdanger(validation_errors());     
        }else{
            // die(dump_variable($_POST));
            if(CAPTCHA==0){
                $word = $this->session->userdata('mycaptcha');
                $captcha = $this->input->post('captcha');
                if (isset($captcha)) {
                    if (strtoupper($captcha)!=strtoupper($word)) {
                        $this->alert->alertdanger('Check captcha');
                        return FALSE;
                    }
                }
            }
            
            if(EMAIL_VERIFICATION==0){
                // send email
                $post['is_email'] = 1;
                $token = $this->template->sonEncode($post['email'].date("Ymdhis")); 
                $post['token'] = $token;
                $message = $this->load->view('login/send-email-template', $post,true);
				$email = $this->template->sendEmail($post['email'],"Verification Account",$message);
            }

            $post['status'] = 0;
            $post['created_at'] = date('Y-m-d H:i:s');
            $role_id = $this->db->get_where('jabatan',['id'=>$post['jabatan_id']])->row()->role_id;
            $role = $this->mymodel->selectDataone('role',array('id'=>$role_id));
            $post['role_slug'] = $role['slug'];
            $post['role_name'] = $role['role'];
            $post['password'] = md5($post['password']);
            $post['role_id'] = $role_id;
            unset($post['term_condition']);
            unset($post['confirm_password']);
            // die(dump_variable($post));
            // unset($post['captcha']);
            // echo $post['email'];
            $this->mymodel->insertData('user',$post);
            $this->alert->alertsuccess('Success registration user');

            
        }

    }

    public function password_check($str)
	{
		$this->form_validation->set_message('password_check',"password must combine alphabet and numeric");
	   $message = FALSE;
	   if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
	    $message = TRUE;
	   }
	  return $message;
    }
    

    public function active_account()
    {
        $token = $this->input->get('token');
        if($token==""){
            echo "Token cant find";
        }else{  
            $user = $this->mymodel->selectDataone('user',['token'=>$token]);
            if($user){
                $this->mymodel->updateData('user',['token'=>'','is_email'=>0],['id'=>$user['id']]);
                $this->session->set_flashdata('message','account has been activated');
                redirect('login/?account='.$this->template->sonEncode($user['username']),'refresh');
            }else{
                echo "Token cant find";
            }
        }
        
    }
}
/* End of file Login.php */
/* Location: ./application/controllers/Login.php */