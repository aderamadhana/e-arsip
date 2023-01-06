
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Menu_master extends MY_Controller {

		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['page_name'] = "menu_master";
			$this->template->load('template/template','master/menu_master/all-menu_master',$data);
		}

		public function create()
		{
			$data['page_name'] = "menu_master";

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

			//custom url
			$data['data_url'][] = array(
				'folder'=>'',
				'class'=>'',
				'method'=>'',
				'val'=>'master/absensi-rapat?tipe_rapat=rapat_direksi',
			);

			$data['data_url'][] = array(
				'folder'=>'',
				'class'=>'',
				'method'=>'',
				'val'=>'master/absensi-rapat?tipe_rapat=komite_direksi',
			);

			$data['data_url'][] = array(
				'folder'=>'',
				'class'=>'',
				'method'=>'',
				'val'=>'master/absensi-rapat?tipe_rapat=komite_komisaris',
			);

			$data['data_url'][] = array(
				'folder'=>'',
				'class'=>'',
				'method'=>'',
				'val'=>'master/absensi-rapat?tipe_rapat=rapat_gabungan',
			);

			$this->template->load('template/template','master/menu_master/add-menu_master',$data);
		}


		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[name]', '<strong>Name</strong>', 'required');
			// $this->form_validation->set_rules('dt[icon]', '<strong>Icon</strong>', 'required');
			// $this->form_validation->set_rules('dt[link]', '<strong>Link</strong>', 'required');
			// $this->form_validation->set_rules('dt[urutan]', '<strong>Urutan</strong>', 'required');
			// $this->form_validation->set_rules('dt[parent]', '<strong>Parent</strong>', 'required');
			// $this->form_validation->set_rules('dt[notif]', '<strong>Notif</strong>', 'required');
	}

		public function store()
		{
			$this->validate();
	    	if ($this->form_validation->run() == FALSE){
				$this->alert->alertdanger(validation_errors());     
	        }else{
	        	$dt = $_POST['dt'];

				if($dt['type_icon'] == 'image') {
					$dt['size_icon_image'] = "25px";

					//upload icon
					if (!empty($_FILES['file_image_icon']['name'])){
						$dir  = "./assets/images/";
						$config['upload_path'] = $dir;
						$config['allowed_types'] = 'jpg|jpeg|png';
						$config['file_name'] = md5('smartsoftstudio').rand(1000, 100000);
		
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
		
						if ($this->upload->do_upload('file_image_icon')) {
							$file = $this->upload->data();
						}
		
						$file_ext = pathinfo($_FILES['file_image_icon']['name'], PATHINFO_EXTENSION);
		
						$file_name = $config['file_name'] . '.' . $file_ext;
					} else {
						$file_name = null;
					}

					$dt['icon'] = $file_name;
				}
				
				$dt['created_at'] = date('Y-m-d H:i:s');
				$dt['status'] = "ENABLE";
				$str = $this->db->insert('menu_master', $dt);
				$last_id = $this->db->insert_id();$this->alert->alertsuccess('Success Send Data');   
					
			}
		}

		public function json()
		{
			$status = $_GET['status'];
			if($status==''){
				$status = 'ENABLE';
			}
			header('Content-Type: application/json');
	        $this->datatables->select('id,name,icon,link,urutan,parent,notif,status');
	        $this->datatables->where('status',$status);
	        $this->datatables->from('menu_master');
	        if($status=="ENABLE"){
	        $this->datatables->add_column('view', '<div class="btn-group"><button type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button><button type="button" class="btn btn-sm btn-warning" onclick="set_role($1)"><i class="fa fa-users"></i> Set Role</button></div>', 'id');

	    	}else{
	        $this->datatables->add_column('view', '<div class="btn-group"><button type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button><button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button></div>', 'id');

	    	}
	        echo $this->datatables->generate();
		}
		public function edit($id)
		{
			$data['menu_master'] = $this->mymodel->selectDataone('menu_master',array('id'=>$id));$data['page_name'] = "menu_master";

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

			//custom url
			$data['data_url'][] = array(
				'folder'=>'',
				'class'=>'',
				'method'=>'',
				'val'=>'master/absensi-rapat?tipe_rapat=rapat_direksi',
			);

			$data['data_url'][] = array(
				'folder'=>'',
				'class'=>'',
				'method'=>'',
				'val'=>'master/absensi-rapat?tipe_rapat=komite_direksi',
			);

			$data['data_url'][] = array(
				'folder'=>'',
				'class'=>'',
				'method'=>'',
				'val'=>'master/absensi-rapat?tipe_rapat=komite_komisaris',
			);

			$data['data_url'][] = array(
				'folder'=>'',
				'class'=>'',
				'method'=>'',
				'val'=>'master/absensi-rapat?tipe_rapat=rapat_gabungan',
			);
			
			$this->template->load('template/template','master/menu_master/edit-menu_master',$data);
		}

		public function update()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			
			$this->validate();
			

	    	if ($this->form_validation->run() == FALSE){
				$this->alert->alertdanger(validation_errors());     
	        }else{
				$id = $this->input->post('id', TRUE);		
				$old_menu = $this->mmodel->selectWhere('menu_master',['id'=>$id])->row();
				$dt = $_POST['dt'];

				$menu = $this->mymodel->selectDataone('menu_master', array('id'=>$id));

				if($dt['type_icon'] == 'image') {
					$dt['size_icon_image'] = "25px";

					//upload icon
					if (!empty($_FILES['file_image_icon']['name'])){

						$fileLama = "assets/images/".$menu['icon'];
						@unlink($fileLama);

						$dir  = "./assets/images/";
						$config['upload_path'] = $dir;
						$config['allowed_types'] = 'jpg|jpeg|png';
						$config['file_name'] = md5('smartsoftstudio').rand(1000, 100000);
		
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
		
						if ($this->upload->do_upload('file_image_icon')) {
							$file = $this->upload->data();
						}
		
						$file_ext = pathinfo($_FILES['file_image_icon']['name'], PATHINFO_EXTENSION);
		
						$file_name = $config['file_name'] . '.' . $file_ext;

						$dt['icon'] = $file_name;
					}
				} else {
					if($menu['type_icon'] == 'image') {
						$fileLama = "assets/images/".$menu['icon'];
						@unlink($fileLama);
					}
				}
				
				$dt['updated_at'] = date("Y-m-d H:i:s");
				$this->mymodel->updateData('menu_master', $dt , array('id'=>$id));

				$this->db->update('access_block', ['ab_link'=>$dt['function']], ['ab_link'=>$old_menu->function]);

				$this->alert->alertsuccess('Success Update Data');  }
		}

		public function delete()
		{
				$id = $this->input->post('id', TRUE);
				$this->mymodel->deleteData('menu_master',['id'=>$id]);
				$this->alert->alertdanger('Success Delete Data');     
		}

		public function status($id,$status)
		{
			$this->mymodel->updateData('menu_master',array('status'=>$status),array('id'=>$id));
			redirect('master/Menu_master');
		}

		public function ordering()
		{
			$data['page_name'] = "menu_master";
			$this->template->load('template/template','master/menu_master/ordering-menu_master',$data);
		}

		public function update_ordering()
		{
			$menu = json_decode($this->input->post('menu'));

			foreach ($menu as $kmenu => $vmenu) {
				$this->db->update('menu_master', ['urutan'=>($kmenu+1),'parent'=>0], ['id'=>$vmenu->id]);
				if (count(@$vmenu->children)) {
					foreach ($vmenu->children as $kchild => $vchild) {
						$this->db->update('menu_master', ['urutan'=>($kchild+1),'parent'=>$vmenu->id], ['id'=>$vchild->id]);
					}
				}
			}

			redirect('master/menu_master','refresh');
		}

		public function getRoleByMenu($id)
		{
			$role = $this->mmodel->selectWhere('role',['status'=>'ENABLE'])->result();
			$departemen = $this->mmodel->selectWhere('m_departemen',['status'=>'ENABLE'])->result();
			$role_assigned = [];
			foreach ($role as $vrole) {
				if (in_array($id, json_decode($vrole->menu, true))) {
					$role_assigned[] = $vrole->id;
				}
			}

			$departemen_assigned = [];
			foreach ($departemen as $vdepartment) {
				if (in_array($id, json_decode($vdepartment->menu, true))) {
					$departemen_assigned[] = $vdepartment->id;
				}
			}
			// echo json_encode($role_assigned);
			?>
			<input type="hidden" name="menu" value="<?= $id ?>">
			<div class="form-group">
				<label>Department</label>
				<select name="department[]" class="form-control selmultiple" multiple="multiple">
					<?php foreach ($departemen as $vdepartment): ?>
					<option value="<?= $vdepartment->id ?>" <?= (in_array($vdepartment->id, $departemen_assigned))?"selected":"" ?>><?= $vdepartment->nama ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="form-group">
				<label>Role</label>
				<select name="role[]" class="form-control selmultiple" multiple="multiple">
					<?php foreach ($role as $v): ?>
					<option value="<?= $v->id ?>" <?= (in_array($v->id, $role_assigned))?"selected":"" ?>><?= $v->role ?></option>
					<?php endforeach ?>
				</select>
			</div>

			<script type="text/javascript">
				$('.selmultiple').select2();
			</script>

			<?php
		}

		public function updateRoleMenu()
		{
			$role = $this->mmodel->selectWhere('role',['status'=>'ENABLE'])->result();
			$role_tba = $this->input->post('role');
			$departemen = $this->mmodel->selectWhere('m_departemen',['status'=>'ENABLE'])->result();
			$departemen_tba = $this->input->post('department');
			$menu = $this->input->post('menu');
			$get_menu = $this->mmodel->selectWhere('menu_master',['id'=>$menu])->row();

			foreach ($role as $vrole) {
				$menu_assigned = json_decode($vrole->menu,true); //set akses menu lama
				if (($key = array_search($menu, $menu_assigned)) !== false) { //hapus akses menu
				    unset($menu_assigned[$key]);
				}
				if (in_array($vrole->id, $role_tba)) { //reassign akses menu
					$menu_assigned[] = $menu;
					$this->db->delete('access_block', ['ab_role_id'=>$vrole->id,'ab_link'=>$get_menu->function]);
				} else {
					if ($get_menu->function) { //check if function is set
						$check_available = $this->mmodel->selectWhere('access_block',['ab_role_id'=>$vrole->id,'ab_link'=>$get_menu->function])->num_rows();
						if ($check_available==0) { // check if the link not blocked yet
							$this->db->insert('access_block', ['ab_role_id'=>$vrole->id,'ab_link'=>$get_menu->function]);
						}
					}
				}
				$this->db->update('role', ['menu'=>json_encode(array_values($menu_assigned))], ['id'=>$vrole->id]);
			}

			foreach ($departemen as $vdepartemen) {
				$menu_assigned = json_decode($vdepartemen->menu,true); //set akses menu lama
				if (($key = array_search($menu, $menu_assigned)) !== false) { //hapus akses menu
				    unset($menu_assigned[$key]);
				}
				if (in_array($vdepartemen->id, $departemen_tba)) { //reassign akses menu
					$menu_assigned[] = $menu;
				}

				$this->db->update('m_departemen', ['menu'=>json_encode(array_values($menu_assigned))], ['id'=>$vdepartemen->id]);
			}

			redirect('master/menu_master','refresh');
		}

		public function getParent($parent)
		{
			$this->db->order_by('urutan', 'desc');
			$urutan = $this->mmodel->selectWhere('menu_master',['Parent'=>$parent])->row();

			$urutan_available = ((@$urutan->urutan)?$urutan->urutan:0)+1;
			echo json_encode(['result'=>$urutan_available]);
		}

	}
?>