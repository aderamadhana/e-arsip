<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Access extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data['page_name'] = "access";
		$this->template->load('template/template','access/all-role',$data);
	}
	public function json()
	{
		$status = $_GET['status'];
		header('Content-Type: application/json');
		$this->datatables->select('id,role,status');
		$this->datatables->where('status',$status);
		$this->datatables->from('role');
		// if($status=="ENABLE"){
		$this->datatables->add_column('view', '<div class="btn-group"><button type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Access Control</button></div>', 'id');
			// }else{
		//    $this->datatables->add_column('view', '<div class="btn-group"><button type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button><button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button></div>', 'id');
			// }
		echo $this->datatables->generate();
			}
			
	public function control($id)
	{
		# code...
		$data['page_name'] = "access";
		$data['role'] = $this->mymodel->selectDataone('role',array('id'=>$id));
		$data['control'] = $this->mymodel->selectData('access_control');

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
	    			$data['data_url'][] = array(
	    						'folder'=>str_replace("/","",$fol[$i]),
	    						'class'=>str_replace( '.php', '', $ctrl ),
	    						'method'=>$mt,
	    						'val'=>strtolower($fol[$i].str_replace( '.php', '', $ctrl )."/".$mt),
	    					);
	    		}
	    	}
			$i++;
		}

		$this->template->load('template/template','access/all-control',$data);
	}


	public function store()
	{
		# code...
		$role = $this->input->post('role');
		$control = $this->input->post('link');
		$this->mymodel->deleteData('access_block',array('ab_role_id'=>$role));
		foreach ($control as $key => $value) {
			$data = array(
						'ab_link'=>$value,
						'ab_role_id' =>$role
						);
			$this->db->insert('access_block', $data);
		}
		redirect('access/control/'.$role);
	}
}
/* End of file Access.php */
/* Location: ./application/controllers/Access.php */