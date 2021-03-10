<?php
Class Model_Task{
	
	protected $db;

	public function TasksUser($data = array()){
		global $db;
		$this->db = $db;

		$sql = "SELECT * FROM tasks WHERE user_id = '" . (int)$data['user_id'] . "' ORDER BY date_added DESC";
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 5;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function TotalTasksUser($data = array()){
		global $db;
		$this->db = $db;

		$query = $this->db->query("SELECT COUNT(*) AS total FROM tasks WHERE user_id = '" . (int)$data['user_id'] . "'");
		
		return $query->row['total'];
	}
	
	public function getTask($task_id){
		global $db;
		$this->db = $db;

		$query = $this->db->query("SELECT * FROM tasks WHERE user_id = '" . (int)$_SESSION['user_id'] . "' AND task_id = '" . (int)$task_id . "'");
		
		return $query->row;
	}
	
	public function addTask($data){
		global $db;
		$this->db = $db;

		$this->db->query("INSERT INTO tasks SET user_id = '" . (int)$_SESSION['user_id'] . "', text = '" . $this->db->escape($data['text']) . "', date_added = NOW()");
	}
	
	public function editTask($data){
		global $db;
		$this->db = $db;

		$query = $this->db->query("UPDATE tasks SET text = '" . $this->db->escape($data['text']) . "' WHERE user_id = '" . (int)$_SESSION['user_id'] . "' AND task_id = '" . (int)$data['task_id'] . "'");
	}
	
	public function deleteTask($task_id){
		global $db;
		$this->db = $db;
		$this->db->query("DELETE FROM tasks WHERE task_id = '" . (int)$task_id . "' AND user_id = '" . (int)$_SESSION['user_id'] . "'");
	}
	
	public function userInfo($user_id){
		global $db;
		$this->db = $db;

		$query = $this->db->query("SELECT * FROM users WHERE id = '" . (int)$user_id . "'");
		
		return $query->row;
	}
}