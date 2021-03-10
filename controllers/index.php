<?php
Class Controller_Index Extends Controller_Base {

	public $layouts = "layout";

	function index() {
		if (!isset($_SESSION['user_id'])) {
			header('Location: ' . HTTP_SERVER . 'index.php?route=login');
		}
		
		$months = array( 1 => 'января' , 'февраля' , 'марта' , 'апреля' , 'мая' , 'июня' , 'июля' , 'августа' , 'сентября' , 'октября' , 'ноября' , 'декабря');
		
		$user_id = $_SESSION['user_id'];
		
		if (isset($_SESSION['success'])) {
			$data['success'] = $_SESSION['success'];

			unset($_SESSION['success']);
		} else {
			$data['success'] = '';
		}
		
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		
		$limit = 5;
		$data['limit'] = 5;

		$data['logout'] = HTTP_SERVER . 'index.php?route=index/logout';
		
		$data['add_task'] = HTTP_SERVER . 'index.php?route=task';

		$filter_data = array(
			'user_id' 			=> $user_id,
			'start'				=> ($page - 1) * $limit,
			'limit'				=> $limit
		);

		$model = new Model_Task();
		
		$data['user_info'] = $model->userInfo($user_id);
		
		$tasks = $model->TasksUser($filter_data);
		$task_total = $model->TotalTasksUser($filter_data);
		
		$data['task_total'] = $task_total;

		foreach ($tasks as $task){
			$data['tasks'][] = array(
				'text'			=>	$task['text'],
				'edit'			=>	'index.php?route=task&task_id=' . $task['task_id'],
				'delete'		=>	'index.php?route=task/delete&task_id=' .  $task['task_id'],
				'date_added'	=>	date('d ' . $months[date('n')] . ' H:i:s', strtotime($task['date_added']))
			);
		}
		
		$pagination = new Pagination();
		$pagination->total = $task_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = '?page={page}';

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf('Показано с %d по %d из %d (всего %d страниц)', ($task_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($task_total - $limit)) ? $task_total : ((($page - 1) * $limit) + $limit), $task_total, ceil($task_total / $limit));

		$this->template->view('index', $data);
	}
	
	function logout() {
		unset($_SESSION['user_id']);
		header('Location: ' . HTTP_SERVER . 'index.php?route=login');
	}
}