<?php
Class Model_Login{
	
	protected $db;

	public function login($data){
		global $db;
		$this->db = $db;
		
		//Создание таблиц в БД
			$sql  = "CREATE TABLE IF NOT EXISTS `tasks` ( ";
			$sql .= "`task_id` int(11) NOT NULL AUTO_INCREMENT, ";
			$sql .= "`user_id` int(11) NOT NULL, ";
			$sql .= "`text` text NOT NULL, ";
			$sql .= "`date_added` datetime NOT NULL, ";
			$sql .= "PRIMARY KEY (`task_id`) ";
			$sql .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";
			
			$this->db->query($sql);
			
			$sql  = "CREATE TABLE IF NOT EXISTS `users` ( ";
			$sql .= "`id` int(11) NOT NULL AUTO_INCREMENT, ";
			$sql .= "`login` varchar(32) NOT NULL, ";
			$sql .= "`firstname` varchar(32) NOT NULL, ";
			$sql .= "`lastname` varchar(32) NOT NULL, ";
			$sql .= "`email` varchar(32) NOT NULL, ";
			$sql .= "`password` varchar(128) NOT NULL, ";
			$sql .= "PRIMARY KEY (`id`) ";
			$sql .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";
			
			$this->db->query($sql);
		//Создание таблиц в БД

		$query = $this->db->query("SELECT * FROM users WHERE email = '" . $this->db->escape($data['email']) . "' AND password = '" . $this->db->escape(md5($data['password'])) . "'");
		
		if (isset($query->row['id'])) {
			$return = $query->row['id'];
		} else {
			$return = false;
		}
		
		return $return;
	}
}