<?php
Class Model_Login{
	
	protected $db;

	public function login($data){
		global $db;
		$this->db = $db;

		$query = $this->db->query("SELECT * FROM users WHERE email = '" . $this->db->escape($data['email']) . "' AND password = '" . $this->db->escape(md5($data['password'])) . "'");
		
		if (isset($query->row['id'])) {
			$return = $query->row['id'];
		} else {
			$return = false;
		}
		
		return $return;
	}
}