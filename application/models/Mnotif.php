<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mnotif extends CI_Model {

	public function updateByRole($slug,$role,$counting="1")
	{
		if (is_array($role)) {
			foreach ($role as $vrole) {
				$this->db->set('counting','counting + ('.$counting.')', false);
				$this->db->where('slug', $slug, true);
				$this->db->where('role_id', $vrole, true);
				$query = $this->db->update('notification');
			}
		} else {
			$this->db->set('counting','counting + ('.$counting.')', false);
			$this->db->where('slug', $slug, true);
			$this->db->where('role_id', $role, true);
			$query = $this->db->update('notification');
		}

		return $query;
	}

	public function updateByUser($slug,$user,$counting="1")
	{
		if (is_array($user)) {
			foreach ($user as $vuser) {
				$this->db->set('counting','counting + ('.$counting.')', false);
				$this->db->where('slug', $slug, true);
				$this->db->where('user_id', $vuser, true);
				$query = $this->db->update('notification');
			}
		} else {
			$this->db->set('counting','counting + ('.$counting.')', false);
			$this->db->where('slug', $slug, true);
			$this->db->where('user_id', $user, true);
			$query = $this->db->update('notification');
		}
		
		return $query;
	}

	public function updateAllRole($slug,$counting="1")
	{
		$role = $this->mmodel->selectWhere('role',['status'=>'ENABLE'])->result();
		foreach ($role as $vrole) {
			$this->db->set('counting','counting + ('.$counting.')', false);
			$this->db->where('slug', $slug, true);
			$this->db->where('role_id', $vrole->id, true);
			$query = $this->db->update('notification');
		}
		
		return $query;
	}

}

/* End of file mnotif.php */
/* Location: ./application/models/mnotif.php */